<div align="center">
  <img src="img/gf-fub.svg" alt="Gravity Forms FUB Integration" height="96" />
</div>

# Gravity Forms FUB Integration Add-On

> [!TIP]
> Seamlessly connect Gravity Forms with Follow Up Boss (FUB) to automate lead capture, tagging, and tracking—no code required.

---

## Security Feature: API Key Masking

> [!IMPORTANT]
> For your privacy, the FUB API key field in plugin settings is automatically masked in the UI, showing only the last four characters (e.g., `************oIoY`). The real value is always submitted and editable—masking is for display only. No visibility toggle is provided.

---

## Overview

**Gravity Forms FUB Integration Add-On** enables WordPress sites using Gravity Forms to automatically send leads to [Follow Up Boss](https://www.followupboss.com/) via the FUB Open API. Assign custom lead sources, tags, and integrate the FUB Pixel for advanced tracking—all from your WordPress dashboard.

<details>
<summary><strong>Key Features</strong></summary>

- **Direct FUB API Integration**: Send Gravity Forms submissions to FUB as new leads or update existing contacts.
- **Custom Lead Source & Tags**: Assign sources and tags dynamically using Gravity Forms merge tags.
- **FUB Pixel Integration**: Easily add and manage the FUB Pixel tracking code for real-time user tracking.
- **Advanced Field Mapping**: Map form fields to FUB contact fields for accurate data transfer.
- **Conditional Feed Processing**: Only send leads to FUB when specific form conditions are met.
- **Automatic Update Checker**: Get notified of new plugin versions via the built-in update checker.
- **Modern Admin UI**: Uses Bootstrap for a clean, responsive settings and feed management experience.

</details>

---

## Getting Started

### Prerequisites

- WordPress 5.0+
- [Gravity Forms](https://www.gravityforms.com/) 1.9+
- A [Follow Up Boss](https://www.followupboss.com/) account with API access

### Installation

1. Download or clone this repository into your WordPress plugins directory:
	```sh
	git clone https://github.com/714Web/gf-fub.git
	```
2. Activate **Gravity Forms FUB Integration Add-On** from the WordPress Plugins admin page.
3. Ensure Gravity Forms is installed and activated.

---

## Configuration

1. **API Key Setup**
	- Go to **Forms > Settings > FUB Integration** in your WordPress admin.
	- Enter your FUB API Key. [How to create an API key?](https://help.followupboss.com/hc/en-us/articles/360014289393-API-Key)

2. **FUB Pixel Tracking (Optional)**
	- Paste your FUB Pixel Tracking Code in the settings.
	- Optionally, disable the pixel if you only want to use direct API integration.

3. **Create a Feed**
	- Edit any Gravity Form, go to **Settings > FUB Integration**.
	- Add a new feed and map form fields to FUB fields (Name, Email, Phone, Tags, etc).
	- Set custom tags, source, and message using merge tags if needed.
	- Configure conditional logic to control when the feed is triggered.

> [!IMPORTANT]
> The FUB Pixel must be enabled for real-time tracking. If disabled, only forms with a configured FUB Integration feed will send leads to FUB.

---

## Usage

1. **Submit a Gravity Form**: When a user submits a form with a configured FUB feed, their data is sent to FUB automatically.
2. **Check FUB**: Log in to your FUB account to see new leads, tags, and sources as configured.
3. **Debugging**: Enable debug mode in the plugin settings to view API responses and troubleshoot issues.

---

## Troubleshooting

> [!NOTE]
> If leads are not appearing in FUB:
> - Double-check your API key and permissions.
> - Ensure the feed is active and conditions are met.
> - Check for errors in the plugin's debug output.
> - Review [FUB API documentation](https://docs.followupboss.com/reference/people-post) for API limits and requirements.

For update checker issues, see the [Plugin Update Checker documentation](inc/plugin-update-checker-5.3/README.md).

---

## Resources

- [Follow Up Boss API Docs](https://docs.followupboss.com/)
- [Gravity Forms Documentation](https://docs.gravityforms.com/)
- [FUB Pixel Overview](https://help.followupboss.com/hc/en-us/articles/360037775174-Follow-Up-Boss-Pixel-Overview)
- [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker)

---

> [!TIP]
> Need help? [Open an issue](https://github.com/714Web/gf-fub/issues) or contact the author via [GitHub](https://github.com/jeremycaris).

