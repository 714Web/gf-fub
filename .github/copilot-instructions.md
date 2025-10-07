# Copilot Instructions for AI Coding Agents

## Project Architecture
- This is a WordPress plugin that integrates Gravity Forms with the Follow Up Boss (FUB) CRM using the FUB Open API.
- Main entry point: `gffub.php` (plugin bootstrap, update checker, registration)
- Core logic: `class-gffub.php` (Gravity Forms Add-On Framework, FUB API integration, admin UI, feed processing)
- Bundled library: `inc/plugin-update-checker-5.3/` (handles plugin update notifications via GitHub)
- Assets: `css/`, `js/`, `img/` (Bootstrap-based admin UI)

## Key Workflows
- **Install:** Copy to `wp-content/plugins/`, activate in WP admin. No build or dependency install required.
- **Development:** Edit PHP, CSS, or JS files directly. Refresh browser to see changes. No hot reload.
- **Testing:** No automated tests. Manual test by submitting forms and checking FUB for lead creation/tags. Enable debug mode in plugin settings for API response output.
- **Deployment:** Deploy by copying the plugin folder to a WordPress site and activating. Update checker uses GitHub releases/tags.

## Project-Specific Conventions
- PHP code follows WordPress standards: 4-space indentation, no tabs, use of `esc_html__`, `esc_attr__` for output escaping.
- All configuration is via the WordPress admin UI (no .env or config files).
- API keys and secrets are stored in the WordPress options table (never in code).
- All FUB API requests are authenticated using the user-provided API key.
- Only WordPress admins can configure plugin settings.
- No monorepo structure; this is a single-package plugin.

## Integration Points
- **Gravity Forms Add-On Framework:** Used for feed management, field mapping, and admin UI.
- **Follow Up Boss API:** All lead data is sent via the FUB Open API (`/v1/events`).
- **Plugin Update Checker:** Notifies of new plugin versions via GitHub releases/tags.

## Examples and Patterns
- See `class-gffub.php` for:
  - How feeds are processed and mapped to FUB API payloads
  - How settings fields are defined and validated
  - How the FUB Pixel is conditionally injected
- See `gffub.php` for plugin bootstrap and update checker setup
- See `inc/plugin-update-checker-5.3/README.md` for update checker usage

## Troubleshooting
- Enable debug mode in plugin settings to view API responses and error codes.
- If leads do not appear in FUB, check API key, feed configuration, and debug output.
- For update checker issues, verify GitHub repo URL and plugin slug.

---

For more details, see `AGENTS.md` and the main `README.md`.
