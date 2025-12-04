<?php
namespace StrongClose_Media_Offload;

/**
 * StrongClose API Class
 *
 * Handles all StrongClose API operations
 *
 * @package StrongClose_Media_Offload
 * @since 1.0.2
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Load logger class
require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-strongclose-logger.php';

/**
 * Class StrongClose_API
 *
 * Manages all StrongClose API operations including upload, delete, and authentication
 */
class StrongClose_API {
    
    /**
     * Plugin settings
     *
     * @var array
     */
    private $settings;
    
    /**
     * Logger instance
     *
     * @var StrongClose_Logger
     */
    private $logger;

    /**
     * API Base URL
     */
    const API_BASE_URL = 'https://api.strongclose.ai';
    
    /**
     * Constructor
     *
     * @param array $settings Plugin settings
     */
    public function __construct( $settings ) {
        $this->settings = $settings;
        $this->logger = StrongClose_Logger::get_instance();
    }
    
    /**
     * Check if API is configured
     *
     * @return bool
     */
    public function is_configured() {
        return ! empty( $this->settings['site_id'] ) 
            && ! empty( $this->settings['api_key'] );
    }
    
    /**
     * Test API connection
     *
     * @return true|\WP_Error
     */
    public function test_connection() {
        if ( ! $this->is_configured() ) {
            return new \WP_Error( 'not_configured', 'StrongClose credentials not configured.' );
        }
        
        $site_id = $this->settings['site_id'];
        $url = self::API_BASE_URL . '/api/sites/' . $site_id;
        
        $response = wp_remote_get( $url, array(
            'headers' => $this->get_auth_headers(),
            'timeout' => 15,
            'sslverify' => true,
            'user-agent' => 'WordPress/StrongClose-Media-Offload/1.0.2'
        ) );
        
        if ( is_wp_error( $response ) ) {
            $this->logger->error( 'API Test - Connection error: ' . $response->get_error_message() );
            return $response;
        }
        
        $code = wp_remote_retrieve_response_code( $response );
        if ( $code !== 200 ) {
            $body = wp_remote_retrieve_body( $response );
            $this->logger->error( "API Test - Error {$code}: {$body}" );
            return new \WP_Error( 'api_error', "API Error {$code}: " . $this->get_error_message_from_body($body) );
        }

        // Cache the domain for URL rewriting
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        if ( isset( $body['domain'] ) ) {
            update_option( 'strongclose_media_offload_domain', $body['domain'] );
        }
        
        return true;
    }
    
    /**
     * Upload file to StrongClose
     *
     * @param int    $attachment_id Attachment ID
     * @param string $file_path     Local file path
     * @param int    $size          File size (optional)
     * @return string|false|\WP_Error Media ID on success, false or WP_Error on failure
     */
    public function upload_file( $attachment_id, $file_path, $size = 0 ) {
        if ( ! $this->is_configured() ) {
            return false;
        }
        
        if ( ! file_exists( $file_path ) ) {
            $this->logger->error( "Upload - File not found: {$file_path}" );
            return false;
        }
        
        $site_id = $this->settings['site_id'];
        $url = self::API_BASE_URL . '/api/sites/' . $site_id . '/media';
        
        // Calculate relative path for the file
        $upload_dir = wp_upload_dir();
        $relative_path = str_replace( $upload_dir['basedir'], '', $file_path );
        $relative_path = ltrim( $relative_path, '/' );
        
        // If it's not in the uploads directory (e.g. plugin asset), use the path relative to WP root or content dir
        // For now, we assume media library uploads are inside uploads dir.
        
        $file_content = file_get_contents( $file_path );
        $boundary = wp_generate_password( 24 );
        $headers = $this->get_auth_headers();
        $headers['content-type'] = 'multipart/form-data; boundary=' . $boundary;
        
        $payload = '';
        // File field
        $payload .= '--' . $boundary;
        $payload .= "\r\n";
        $payload .= 'Content-Disposition: form-data; name="file"; filename="' . basename( $file_path ) . '"' . "\r\n";
        $payload .= 'Content-Type: ' . $this->get_mime_type( $file_path ) . "\r\n";
        $payload .= "\r\n";
        $payload .= $file_content;
        $payload .= "\r\n";
        
        // File path field (to preserve directory structure)
        $payload .= '--' . $boundary;
        $payload .= "\r\n";
        $payload .= 'Content-Disposition: form-data; name="file_path"' . "\r\n";
        $payload .= "\r\n";
        $payload .= $relative_path;
        $payload .= "\r\n";
        
        $payload .= '--' . $boundary . '--';
        
        $response = wp_remote_post( $url, array(
            'headers' => $headers,
            'body'    => $payload,
            'timeout' => 60,
        ) );
        
        if ( is_wp_error( $response ) ) {
            $this->logger->error( "Upload error for {$file_path}: " . $response->get_error_message() );
            return $response;
        }
        
        $code = wp_remote_retrieve_response_code( $response );
        if ( $code !== 200 && $code !== 201 ) {
            $body = wp_remote_retrieve_body( $response );
            $this->logger->error( "Upload failed {$code}: {$body}" );
            return new \WP_Error( 'upload_failed', "Upload failed {$code}" );
        }
        
        $body = json_decode( wp_remote_retrieve_body( $response ), true );
        
        // Return media_id if available, otherwise true
        return isset( $body['id'] ) ? $body['id'] : true;
    }
    
    /**
     * Delete file from StrongClose
     *
     * @param string $media_id Media ID to delete
     * @return bool|\WP_Error
     */
    public function delete_file( $media_id ) {
        if ( ! $this->is_configured() || empty( $media_id ) ) {
            return false;
        }
        
        $site_id = $this->settings['site_id'];
        $url = self::API_BASE_URL . '/api/sites/' . $site_id . '/media/' . $media_id;
        
        $response = wp_remote_request( $url, array(
            'method'  => 'DELETE',
            'headers' => $this->get_auth_headers(),
            'timeout' => 15,
        ) );
        
        if ( is_wp_error( $response ) ) {
            $this->logger->error( "Delete error for {$media_id}: " . $response->get_error_message() );
            return $response;
        }
        
        $code = wp_remote_retrieve_response_code( $response );
        if ( $code !== 200 && $code !== 204 ) {
            $body = wp_remote_retrieve_body( $response );
            $this->logger->error( "Delete failed {$code}: {$body}" );
            return new \WP_Error( 'delete_failed', "Delete failed {$code}" );
        }
        
        return true;
    }
    
    /**
     * Upload all registered image sizes
     *
     * @param int   $attachment_id Attachment ID
     * @param array $files_to_upload Array of file paths
     * @return array Array of results
     */
    public function upload_all_sizes( $attachment_id, $files_to_upload ) {
        $results = array();
        
        foreach ( $files_to_upload as $size => $file_data ) {
            // Handle both array format (from bulk sync) and direct path (if any)
            $file_path = is_array($file_data) ? $file_data['path'] : $file_data;
            
            if ( file_exists( $file_path ) ) {
                $result = $this->upload_file( $attachment_id, $file_path );
                
                if ( ! is_wp_error( $result ) && $result !== false ) {
                    $results[$size] = array(
                        'id' => $result, // media_id
                        'url' => $this->get_public_url( $file_path )
                    );
                } else {
                    $this->logger->error( "Failed to upload size {$size} for attachment {$attachment_id}" );
                }
            }
        }
        
        return $results;
    }

    /**
     * Get Public URL
     * 
     * @param string $file_path Local file path
     * @return string
     */
    public function get_public_url( $file_path ) {
        $domain = get_option( 'strongclose_media_offload_domain', '' );
        if ( empty( $domain ) ) {
            // Try to fetch domain if missing
            $this->test_connection();
            $domain = get_option( 'strongclose_media_offload_domain', '' );
        }
        
        if ( empty( $domain ) ) {
            return '';
        }

        $upload_dir = wp_upload_dir();
        $relative_path = str_replace( $upload_dir['basedir'], '', $file_path );
        $relative_path = ltrim( $relative_path, '/' );
        
        return "https://cdn.strongclose.ai/{$domain}/wp-content/uploads/{$relative_path}";
    }

    /**
     * Get Auth Headers
     *
     * @return array
     */
    private function get_auth_headers() {
        return array(
            'Authorization' => 'Bearer ' . $this->settings['api_key'],
            'Accept'        => 'application/json',
        );
    }
    
    /**
     * Get MIME type
     *
     * @param string $file_path
     * @return string
     */
    private function get_mime_type( $file_path ) {
        $mime_type = mime_content_type( $file_path );
        return $mime_type ? $mime_type : 'application/octet-stream';
    }

    /**
     * Extract error message from body
     */
    private function get_error_message_from_body( $body ) {
        $json = json_decode( $body, true );
        return isset( $json['message'] ) ? $json['message'] : $body;
    }
}
