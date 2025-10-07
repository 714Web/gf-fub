# AGENTS.md

## Project Overview

Gravity Forms FUB Integration Add-On is a WordPress plugin that connects Gravity Forms to the Follow Up Boss (FUB) CRM using the FUB Open API. It enables automatic lead capture, tagging, and pixel tracking from Gravity Forms submissions. The plugin is written in PHP and uses the Gravity Forms Add-On Framework. It also includes the Plugin Update Checker library for automatic update notifications.

- **Primary language:** PHP
- **Frameworks:** Gravity Forms Add-On Framework
- **Bundled libraries:** Plugin Update Checker (in `inc/plugin-update-checker-5.3/`)
- **UI:** WordPress admin (Bootstrap-based for plugin pages)

## Setup Commands

- **Install plugin:**
  1. Clone or copy the repository into your WordPress `wp-content/plugins/` directory:
     ```sh
     git clone https://github.com/714Web/gf-fub.git
     ```
  2. Activate the plugin from the WordPress admin Plugins page.
  3. Ensure Gravity Forms is installed and activated.

- **Dependencies:**
  - No Composer or npm install required; all dependencies are bundled.

## Development Workflow

- **Local development:**
  - Edit PHP source files directly (`gffub.php`, `class-gffub.php`, etc.).
  - For CSS/JS, edit files in `css/` and `js/`.
  - Reload the WordPress admin or frontend to see changes.

- **Admin UI:**
  - Plugin settings and feed configuration are available in the WordPress admin under **Forms > Settings > FUB Integration** and in each form's settings.

- **Hot reload:**
  - Not supported; manual browser refresh required.

- **Environment variables:**
  - Not used. All configuration is via the WordPress admin UI.

## Testing Instructions

- **Automated tests:**
  - No automated test suite is included.
  - Manual testing is performed via the WordPress admin and frontend forms.

- **Manual test steps:**
  1. Configure the plugin with a valid FUB API key in the settings.
  2. Create a Gravity Form and add a FUB Integration feed.
  3. Submit the form and verify the lead appears in FUB with correct tags/source.
  4. Test with/without the FUB Pixel enabled.
  5. Use debug mode in plugin settings to view API responses.

- **Test locations:**
  - All plugin logic is in `gffub.php` and `class-gffub.php`.

## Code Style Guidelines

- **Language:** PHP (WordPress standards)
- **Linting:**
  - No automated linting is enforced, but follow [WordPress PHP Coding Standards](https://developer.wordpress.org/coding-standards/wordpress-coding-standards/php/).
- **Formatting:**
  - 4-space indentation, no tabs.
  - Use `esc_html__`, `esc_attr__`, etc. for output escaping.
- **File organization:**
  - Main entry: `gffub.php`
  - Core logic: `class-gffub.php`
  - Assets: `css/`, `js/`, `img/`
  - Update checker: `inc/plugin-update-checker-5.3/`
- **Naming conventions:**
  - Classes: `CamelCase`
  - Functions: `snake_case`
  - Constants: `UPPER_SNAKE_CASE`

## Build and Deployment

- **Build process:**
  - No build step required; all files are ready for deployment.
- **Production deployment:**
  - Copy the plugin folder to the target WordPress site's `wp-content/plugins/` directory and activate.
- **Update checker:**
  - Uses Plugin Update Checker to notify of new releases via GitHub.
- **Environment configs:**
  - All configuration is via the WordPress admin UI.

## Security Considerations

- **Secrets:**
  - FUB API key is stored in the WordPress options table; never commit secrets to the repo.
- **Authentication:**
  - All API requests to FUB use the configured API key.
- **Permissions:**
  - Only WordPress admins can configure plugin settings.

## Pull Request Guidelines

- **Title format:** `[component] Brief description`
- **Required checks:**
  - Manual test of plugin install, settings, and lead submission.
- **Review:**
  - Ensure code follows WordPress PHP standards and does not break existing functionality.
- **Commits:**
  - Use clear, descriptive commit messages.

## Debugging and Troubleshooting

- **Debug mode:**
  - Enable debug mode in plugin settings to view API responses and error codes.
- **Common issues:**
  - Leads not appearing: check API key, feed configuration, and debug output.
  - Update checker not working: verify GitHub repo URL and plugin slug.
- **Logs:**
  - Uses Gravity Forms logging if enabled.

## Additional Notes

- **Plugin Update Checker**: See `inc/plugin-update-checker-5.3/README.md` for update checker usage and troubleshooting.
- **No monorepo:** This is a single-package plugin.
- **No automated CI/CD:** All deployment is manual.
