# StrongClose Media Offload

**Contributors:** strongclose  
**Tags:** strongclose, cdn, media, storage, object-storage  
**Requires at least:** 5.0  
**Tested up to:** 6.8  
**Stable tag:** 1.0.2  
**Requires PHP:** 8.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  

Automatically offload your WordPress media library to StrongClose Storage for improved performance and reduced hosting costs.

## Description

**StrongClose Media Offload** seamlessly integrates your WordPress media library with StrongClose Storage, providing enterprise-grade CDN delivery at a fraction of the cost of traditional solutions.

**📸 New to StrongClose?** Check out the Screenshots section for a complete visual setup guide with step-by-step instructions!

### Key Features

* **Automatic Media Upload**: Automatically upload new media files to StrongClose storage as they're added to WordPress
* **Bulk Sync**: Migrate existing media library to StrongClose with one-click bulk sync
* **CDN URL Rewriting**: Serve all media from StrongClose's global CDN network
* **Image Size Support**: Upload and serve all WordPress image sizes including thumbnails
* **Responsive Images**: Full support for srcset and responsive images
* **Post Content Rewriting**: Automatically rewrite image URLs in post content
* **Secure Authentication**: Secure authentication using industry-standard protocols
* **Debug Mode**: Comprehensive logging for troubleshooting

### Why Choose StrongClose Storage?

* **Cost Effective**: No egress fees - pay only for storage
* **Global Performance**: Leverage StrongClose's worldwide CDN network
* **S3 Compatible**: Works with standard S3 APIs
* **Reliability**: Enterprise-grade infrastructure with 99.9% uptime SLA

### Requirements

* WordPress 5.0 or higher
* PHP 8.0 or higher (compatible with 8.0, 8.1, 8.2, 8.3, 8.4)
* StrongClose account
* StrongClose API credentials (Access Key ID and Secret Access Key)

### Getting Started

**Visual Guide:** See the Screenshots section below for a complete step-by-step visual guide!

Follow these 3 simple steps to connect your WordPress site to StrongClose:

**Step 1: Create Storage Bucket**
1. Log in to [StrongClose Dashboard](https://dash.strongclose.com/)
2. Click on "Storage" in the left sidebar
3. Click "Create bucket"
4. Enter a unique bucket name (e.g., "my-wordpress-media")
5. Choose a location (optional)
6. Click "Create bucket"

**Step 2: Get Your Credentials**
You need 4 pieces of information from StrongClose:

*A. Account ID:*
- In StrongClose dashboard, look at the top right corner
- Copy the "Account ID" (format: 32 alphanumeric characters)

*B. Access Key ID & Secret Access Key:*
1. In StrongClose dashboard, click "Manage API Tokens" 
2. Click "Create API token"
3. Give it a name (e.g., "WordPress Media Plugin")
4. Under Permissions, select "Object Read & Write"
5. (Optional) Under "Specify bucket(s)", you can limit to your specific bucket
6. Click "Create API token"
7. **IMPORTANT**: Copy and save both:
   - Access Key ID (shows immediately)
   - Secret Access Key (shows only once - save it now!)

*C. Bucket Name:*
- The name you created in Step 1 (e.g., "my-wordpress-media")

*D. Public URL (CDN URL):*
- Go to your bucket → Settings
- Under "Public access", click "Allow Access"
- Your public URL will be: `https://pub-[hash].strongclose.dev`
- OR connect a custom domain under "Custom Domains" (e.g., `https://cdn.yoursite.com`)

**Step 3: Configure Plugin**
1. Install and activate this plugin
2. Go to Settings → StrongClose Media Offload
3. Enter all 4 credentials from Step 2:
   - Account ID
   - Access Key ID
   - Secret Access Key
   - Bucket Name
   - Public URL (your StrongClose public URL or custom domain)
4. Check "Auto Offload" to automatically upload new media
5. Check "Enable URL Rewrite" to serve media from StrongClose/CDN
6. Click "Save Settings"
7. Use "Bulk Sync" to upload existing media

## Installation

### Automatic Installation

1. Go to Plugins → Add New in your WordPress admin
2. Search for "StrongClose Media Offload"
3. Click "Install Now" and then "Activate"
4. Go to Settings → StrongClose Media Offload to configure

### Manual Installation

1. Download the plugin ZIP file
2. Go to Plugins → Add New → Upload Plugin
3. Choose the ZIP file and click "Install Now"
4. Activate the plugin
5. Go to Settings → StrongClose Media Offload to configure

### Configuration

### Detailed Setup Instructions

**Finding Your Account ID:**
1. Go to [StrongClose Dashboard](https://dash.strongclose.com/)
2. Click "Storage" in the sidebar
3. Your Account ID is displayed on the right side (32-character string)
4. Example format: `a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6`

**Creating API Tokens:**
1. In StrongClose dashboard, click "Manage API Tokens"
2. Click "Create API token"
3. Token name: Enter any name (e.g., "WordPress Plugin")
4. Permissions: Select "Object Read & Write"
5. Bucket scope: Choose "Apply to specific buckets" or "All buckets"
6. TTL: Leave as "Forever" or set expiration
7. Click "Create API token"
8. **Save these immediately (Secret only shows once!):**
   - Access Key ID: `4e65xxxxxxxxxxxxxx` (20 chars)
   - Secret Access Key: `tbral5xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx` (40 chars)

**Getting Public/CDN URL:**

*Option 1: Use strongclose.dev subdomain (easiest):*
1. Go to your bucket → Settings
2. Under "Public access", click "Allow Access"
3. Copy the URL: `https://pub-xxxxx.strongclose.dev`

*Option 2: Custom domain (recommended):*
1. In your bucket, go to "Settings" → "Custom Domains"
2. Click "Connect Domain"
3. Enter your subdomain: `cdn.yoursite.com`
4. Add DNS record as instructed by StrongClose
5. Wait for verification (may take a few minutes)
6. Use `https://cdn.yoursite.com` as your Public URL

**Plugin Settings Explained:**
- **Account ID**: Your StrongClose account identifier
- **Access Key ID**: API token public key
- **Secret Access Key**: API token private key (keep secure!)
- **Bucket Name**: Name of your StrongClose bucket
- **Public URL**: strongclose.dev URL or custom domain
- **Auto Offload**: Upload new media automatically to StrongClose
- **URL Rewrite**: Serve all media from StrongClose/CDN instead of local
- **Delete Local Files**: Remove files from server after upload (saves space)
- **Upload Mode**: 
  - "Full Image Only" = faster, uploads only main image
  - "All Sizes" = uploads all thumbnails too

## Frequently Asked Questions

### Is this plugin free?

Yes, the plugin is completely free. You only pay for StrongClose storage usage.

### What are the StrongClose storage costs?

StrongClose charges competitive rates for storage with no egress fees. Check StrongClose's website for current pricing.

### Does it work with custom image sizes?

Yes, the plugin uploads all registered WordPress image sizes including custom sizes defined by themes or plugins.

### Can I keep local copies of files?

Yes, you can choose whether to delete local files after upload or keep them as backup.

### Is it compatible with other CDN plugins?

The plugin rewrites media URLs to use StrongClose/CDN URLs. It may conflict with other CDN plugins that also rewrite URLs.

### What happens if I deactivate the plugin?

Media URLs will revert to local URLs. Files already uploaded to StrongClose remain there. You can reactivate anytime to resume using StrongClose.

### Can I use a custom domain for CDN?

Yes, you can configure a custom domain (like cdn.yourdomain.com) to point to your StrongClose bucket.

### Does it support WebP images?

Yes, the plugin supports all file types that WordPress accepts, including WebP images.

## Screenshots

1. Step 1: Create R2 bucket in Cloudflare dashboard
2. Step 2: Get your Account ID from R2 dashboard
3. Step 3: Create API token with Read & Write permissions
4. Step 4: Copy Access Key ID and Secret Access Key
5. Step 5: Configure Public URL or custom domain
6. Plugin settings page - Enter R2 credentials
7. Plugin settings - Auto upload and URL rewrite options
8. Bulk sync interface showing upload progress
9. Media library with R2/CDN URLs
10. Debug information and sync status panel

## Changelog

### 1.0.2
* New: AJAX-based settings save - no page reload required
* New: Real-time save confirmation appears below Save button
* New: Enhanced Bulk Sync UI with visual progress bar
* New: Color-coded terminal-style sync logs (info, success, error, warning)
* New: Live sync statistics (processed count, success/error tracking)
* Improved: Settings page UX - notifications stay in place without page refresh
* Improved: Bulk sync feedback - see each file upload in real-time
* Improved: Progress tracking with percentage and file counter
* Enhanced: Better user experience with instant feedback on all actions
* Fixed: Settings save now shows status immediately without reloading

### 1.0.1
* Fixed: Plugin activation issue when debug files are missing
* Improved: Added file existence check for debug/test files
* Enhanced: Better error handling for development mode

### 1.0.0
* Initial release
* Automatic media upload to R2
* Bulk sync for existing media
* CDN URL rewriting
* Support for all image sizes
* Responsive image support
* Post content rewriting
* Debug logging

## Upgrade Notice

### 1.0.2
Major UX improvements! AJAX settings save, enhanced bulk sync UI with real-time progress tracking and color-coded logs. Highly recommended update for better user experience.

### 1.0.1
Bug fix release. Fixes plugin activation issue in some environments.

### 1.0.0
Initial release of StrongClose Media Offload for Cloudflare R2.

## Additional Information

### Support

For support, please use the WordPress.org support forum.

### Contributing

This plugin is open source and welcomes contributions from the community.

### Privacy

This plugin does not collect any personal data. Media files are transferred directly between your WordPress site and your Cloudflare R2 account.
