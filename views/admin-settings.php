<?php
/**
 * Admin Settings View
 * Variables passed from StrongClose_Admin class
 */

// Prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Settings is passed from admin class
$settings = $this->settings;
?>
<div class="wrap">
    <h1><?php esc_html_e('StrongClose Media Offload Settings', 'strongclose-media-offload'); ?></h1>

    <form method="post">
        <?php wp_nonce_field('strongclose_media_offload_settings_nonce'); ?>

        <table class="form-table">
            <tr>
                <th><?php esc_html_e('Site ID', 'strongclose-media-offload'); ?></th>
                <td>
                    <input type="text" name="strongclose_media_offload_settings[site_id]"
                           value="<?php echo esc_attr($settings['site_id']); ?>"
                           class="regular-text" />
                    <p class="description"><?php esc_html_e('Your StrongClose Site ID', 'strongclose-media-offload'); ?></p>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('API Key', 'strongclose-media-offload'); ?></th>
                <td>
                    <input type="password" name="strongclose_media_offload_settings[api_key]"
                           value="<?php echo esc_attr($settings['api_key']); ?>"
                           class="regular-text" />
                    <p class="description"><?php esc_html_e('Your StrongClose API Key', 'strongclose-media-offload'); ?></p>
                </td>
            </tr>
        </table>

        <h3><?php esc_html_e('Options', 'strongclose-media-offload'); ?></h3>
        <div class="notice notice-info inline">
            <p><strong><?php esc_html_e('Speed Optimization Tips:', 'strongclose-media-offload'); ?></strong></p>
            <ul style="list-style: disc; margin-left: 20px;">
                <li><?php esc_html_e('Use "Fast - Full size only" mode for quickest uploads', 'strongclose-media-offload'); ?></li>
                <li><?php esc_html_e('Disable "Auto Fix Thumbnails" if not needed', 'strongclose-media-offload'); ?></li>
                <li><?php esc_html_e('Enable "Delete Local Files" to save disk space', 'strongclose-media-offload'); ?></li>
            </ul>
        </div>
        <table class="form-table">
            <tr>
                <th><?php esc_html_e('Auto Offload New Media', 'strongclose-media-offload'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="strongclose_media_offload_settings[auto_offload]"
                               value="1" <?php checked($settings['auto_offload']); ?> />
                        <?php esc_html_e('Automatically upload new media to StrongClose Storage', 'strongclose-media-offload'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Enable URL Rewrite', 'strongclose-media-offload'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="strongclose_media_offload_settings[enable_url_rewrite]"
                               value="1" <?php checked($settings['enable_url_rewrite']); ?> />
                        <?php esc_html_e('Serve media from StrongClose Storage/CDN', 'strongclose-media-offload'); ?>
                    </label>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Delete Local Files', 'strongclose-media-offload'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="strongclose_media_offload_settings[delete_local_files]"
                               value="1" <?php checked($settings['delete_local_files']); ?> />
                        <?php esc_html_e('Remove local files after upload', 'strongclose-media-offload'); ?>
                    </label>
                    <p class="description" style="color: red;">
                        <?php esc_html_e('⚠️ Use with caution! Files will be permanently deleted from server.', 'strongclose-media-offload'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Upload Mode', 'strongclose-media-offload'); ?></th>
                <td>
                    <label>
                        <input type="radio" name="strongclose_media_offload_settings[upload_mode]"
                               value="full_only" <?php checked(($settings['upload_mode'] ?? 'full_only'), 'full_only'); ?> />
                        <?php esc_html_e('Fast - Full size only', 'strongclose-media-offload'); ?>
                    </label><br>
                    <label>
                        <input type="radio" name="strongclose_media_offload_settings[upload_mode]"
                               value="all_sizes" <?php checked(($settings['upload_mode'] ?? 'full_only'), 'all_sizes'); ?> />
                        <?php esc_html_e('Complete - All sizes (slower)', 'strongclose-media-offload'); ?>
                    </label>
                    <p class="description">
                        <?php esc_html_e('Fast mode only uploads the main image for speed', 'strongclose-media-offload'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Auto Fix Thumbnails', 'strongclose-media-offload'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="strongclose_media_offload_settings[auto_fix_thumbnails]"
                               value="1" <?php checked($settings['auto_fix_thumbnails'] ?? false); ?> />
                        <?php esc_html_e('Automatically fix missing thumbnails when uploading', 'strongclose-media-offload'); ?>
                    </label>
                    <p class="description">
                        <?php esc_html_e('Will regenerate thumbnails and sync to StrongClose Storage automatically', 'strongclose-media-offload'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Enable Debug Logging', 'strongclose-media-offload'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="strongclose_media_offload_settings[enable_debug_logging]"
                               value="1" <?php checked($settings['enable_debug_logging']); ?> />
                        <?php esc_html_e('Enable debug logging to error log', 'strongclose-media-offload'); ?>
                    </label>
                </td>
            </tr>
        </table>

        <h3><?php esc_html_e('Auto Sync Settings', 'strongclose-media-offload'); ?></h3>
        <table class="form-table">
            <tr>
                <th><?php esc_html_e('Enable Auto Background Sync', 'strongclose-media-offload'); ?></th>
                <td>
                    <label>
                        <input type="checkbox" name="strongclose_media_offload_auto_sync_enabled" id="auto-sync-enabled"
                               value="1" <?php checked(get_option('strongclose_media_offload_auto_sync_enabled', false)); ?> />
                        <?php esc_html_e('Automatically sync old media to StrongClose Storage in background', 'strongclose-media-offload'); ?>
                    </label>
                    <p class="description">
                        <?php esc_html_e('Will sync unsynced media every hour automatically', 'strongclose-media-offload'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Batch Size', 'strongclose-media-offload'); ?></th>
                <td>
                    <input type="number" name="strongclose_media_offload_auto_sync_batch_size"
                           value="<?php echo esc_attr(get_option('strongclose_media_offload_auto_sync_batch_size', 10)); ?>"
                           min="1" max="50" class="small-text" />
                    <p class="description">
                        <?php esc_html_e('Number of files to sync per batch (1-50)', 'strongclose-media-offload'); ?>
                    </p>
                </td>
            </tr>
            <tr>
                <th><?php esc_html_e('Sync Interval', 'strongclose-media-offload'); ?></th>
                <td>
                    <select name="strongclose_media_offload_auto_sync_interval">
                        <?php
                        $current_interval = get_option('strongclose_media_offload_auto_sync_interval', 'hourly');
                        $intervals = array(
                            'strongclose_every_5_minutes' => esc_html__('Every 5 minutes (for testing)', 'strongclose-media-offload'),
                            'strongclose_every_15_minutes' => esc_html__('Every 15 minutes', 'strongclose-media-offload'),
                            'strongclose_every_30_minutes' => esc_html__('Every 30 minutes', 'strongclose-media-offload'),
                            'hourly' => esc_html__('Every hour', 'strongclose-media-offload'),
                            'twicedaily' => esc_html__('Twice daily', 'strongclose-media-offload'),
                            'daily' => esc_html__('Once daily', 'strongclose-media-offload'),
                        );
                        foreach ($intervals as $value => $label) {
                            echo '<option value="' . esc_attr($value) . '" ' . selected($current_interval, $value, false) . '>' . esc_html($label) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
        </table>
        
        <?php
        // Show auto sync status
        if ( get_option('strongclose_media_offload_auto_sync_enabled', false) ) {
            $next_run = wp_next_scheduled( 'strongclose_media_offload_auto_sync_cron' );
            if ( $next_run ) {
                echo '<div class="notice notice-info inline">';
                echo '<p><strong>' . esc_html__('Auto Sync Status:', 'strongclose-media-offload') . '</strong> ';
                /* translators: %s: Date and time of next sync */
                echo esc_html( sprintf( esc_html__('Next sync scheduled at %s', 'strongclose-media-offload'),
                    date_i18n( get_option('date_format') . ' ' . get_option('time_format'), $next_run ) ) );
                echo '</p>';
                echo '</div>';
            }
        }
        ?>

        <p class="submit">
            <button type="button" id="save-settings" class="button-primary">
                <?php echo esc_attr__('Save Changes', 'strongclose-media-offload'); ?>
            </button>
            <button type="button" id="test-connection" class="button-secondary">
                <?php esc_html_e('Test Connection', 'strongclose-media-offload'); ?>
            </button>
            <button type="button" id="fix-all-thumbnails" class="button-secondary">
                <?php esc_html_e('Fix All Thumbnails', 'strongclose-media-offload'); ?>
            </button>
            <a href="<?php echo esc_url( admin_url('options-general.php?page=strongclose-media-offload-bulk-sync') ); ?>"
               class="button-secondary">
                <?php esc_html_e('Bulk Sync Media', 'strongclose-media-offload'); ?>
            </a>
            <?php if ( get_option('strongclose_media_offload_auto_sync_enabled', false) ) : ?>
            <button type="button" id="run-sync-now" class="button-secondary">
                <?php esc_html_e('Run Auto Sync Now', 'strongclose-media-offload'); ?>
            </button>
            <?php endif; ?>
        </p>
        
        <div id="save-result" style="margin-top: 10px;"></div>
    </form>
    
    <div id="test-result" style="display: none; margin-top: 20px;"></div>
    
    <?php if ( current_user_can('manage_options') && $settings['enable_debug_logging'] ): ?>
    <div id="strongclose-media-offload-debug-info" style="background: white; border: 1px solid #ccd0d4; padding: 20px; margin-top: 20px; max-width: 100%; overflow: hidden; box-sizing: border-box;">
        <h2>Debug Information</h2>
        <div style="max-width: 100%; overflow-x: auto;">
            <?php $this->show_debug_info(); ?>
        </div>
    </div>
    <?php endif; ?>
</div>
