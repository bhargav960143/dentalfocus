# DentalKit

<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/banner-772x250.jpg" alt="DentalKit — WordPress Plugin for Dental Practices" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/version-2.0.0-blue.svg" alt="Version 2.0.0" />
  <img src="https://img.shields.io/badge/WordPress-%3E%3D6.0-21759b.svg" alt="WordPress 6.0+" />
  <img src="https://img.shields.io/badge/PHP-%3E%3D8.0-8892bf.svg" alt="PHP 8.0+" />
  <img src="https://img.shields.io/badge/license-GPL--2.0--or--later-green.svg" alt="License GPL-2.0-or-later" />
</p>

<p align="center">
  Complete dental practice website toolkit — drag-and-drop form builder, custom post types, submissions management, CSV export, and social media management.
</p>

---

## Features

| Feature | Description |
|---------|-------------|
| **Form Builder** | Drag-and-drop builder with 8 field types. No code required. |
| **Auto Shortcodes** | `[dk_form id="1"]` generated automatically on save. |
| **Submissions** | Capture, view, filter, and delete form submissions. |
| **CSV Export** | UTF-8 + BOM export, Excel-compatible. Filter by form first. |
| **Email Notifications** | Per-submission email alert to configurable address. |
| **CPT Shortcodes** | `[dk_testimonials]`, `[dk_team]`, `[dk_treatments]`, `[dk_portfolio]`, `[dk_banners]` |
| **Social Media** | Manage links, display with `[dk_social]` or `[dk_social_list]`. |
| **REST API** | Full CRUD at `/wp-json/dentalkit/v1/forms`. |
| **Security** | `$wpdb->prepare()` everywhere, nonces, `manage_options` checks, output escaping. |
| **Performance** | Assets load only on DentalKit pages and shortcode pages. PSR-4 autoloading. |
| **i18n** | Translation-ready, `dentalkit` text domain, POT file included. |

---

## Screenshots

### Dashboard
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-1.png" alt="DentalKit Dashboard" width="100%" />
</p>

Overview of all modules — Form Builder, Submissions, Testimonials, Team, Treatments, Portfolio, Banners, Settings.

---

### Form Builder — Field Palette & Canvas
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-2.png" alt="Form Builder — drag and drop" width="100%" />
</p>

Drag field types from the left palette into the builder canvas. Reorder by dragging the handle.

---

### Form Builder — Field Settings
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-3.png" alt="Field Settings Panel" width="100%" />
</p>

Click the edit icon on any field to configure label, placeholder, options (for select/checkbox/radio), and required toggle.

---

### Auto-Generated Shortcode
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-4.png" alt="Auto-generated shortcode" width="100%" />
</p>

Every saved form displays its shortcode at the top. Click **Copy** to copy to clipboard instantly.

---

### Submissions — Data Table
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-5.png" alt="Submissions management table" width="100%" />
</p>

All patient form submissions in one view. Filter by form, export to CSV, or delete individual entries.

---

### Submissions — Single Detail View
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-6.png" alt="Submission detail view" width="100%" />
</p>

Full submission data with field labels, values, timestamp, and IP address.

---

### Settings — General & Social Media
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-7.png" alt="Settings panel" width="100%" />
</p>

Configure email notifications, reCAPTCHA v3 keys, and manage all social media links.

---

### Frontend Form
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-8.png" alt="Frontend form rendered by shortcode" width="100%" />
</p>

Frontend form rendered by `[dk_form id="1"]`. Fully responsive, accessible, AJAX submission with inline validation.

---

## Requirements

| Requirement | Minimum |
|-------------|---------|
| PHP | 8.0 |
| WordPress | 6.0 |
| MySQL | 5.7 |

---

## Installation

1. Clone or download this repository.
2. Copy the `trunk/` folder to `/wp-content/plugins/dentalkit/`.
3. In WordPress admin go to **Plugins → Installed Plugins**.
4. Activate **DentalKit**.
5. Go to **DentalKit → Form Builder → Add New Form** to create your first form.
6. Paste the generated shortcode into any page or post.

---

## Shortcode Reference

| Shortcode | Description | Attributes |
|-----------|-------------|------------|
| `[dk_form id="1"]` | Render a form | `id` (required) |
| `[dk_testimonials]` | Testimonials grid | `limit`, `columns`, `category`, `orderby`, `order` |
| `[dk_team]` | Team members grid | `limit`, `columns`, `category` |
| `[dk_treatments]` | Treatments grid | `limit`, `columns`, `category` |
| `[dk_portfolio]` | Portfolio grid | `limit`, `columns`, `category` |
| `[dk_banners]` | Banners display | `limit`, `columns`, `category` |
| `[dk_social name="facebook"]` | Single social link | `name` (slug), `label`, `class` |
| `[dk_social_list]` | All social links as `<ul>` | `class` |

**Examples:**
```
[dk_form id="1"]
[dk_testimonials limit="6" columns="3" category="general"]
[dk_team columns="4"]
[dk_treatments columns="3" limit="9"]
[dk_portfolio columns="4" limit="12"]
[dk_banners]
[dk_social name="facebook"]
[dk_social_list]
```

---

## REST API

Base URL: `/wp-json/dentalkit/v1/`

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/forms` | List all forms |
| `POST` | `/forms` | Create form |
| `GET` | `/forms/{id}` | Get single form |
| `PUT` | `/forms/{id}` | Update form |
| `DELETE` | `/forms/{id}` | Delete form |

All endpoints require `manage_options` capability. Authenticate via WP nonce header `X-WP-Nonce`.

---

## Architecture

```
trunk/
├── dentalkit.php           # Plugin header + PSR-4 autoloader
├── uninstall.php           # Clean table removal on uninstall
├── src/
│   ├── Plugin.php          # Singleton bootstrap
│   ├── Loader.php          # Hook/filter registry
│   ├── Activator.php       # DB schema (dbDelta)
│   ├── Deactivator.php
│   ├── Admin/
│   │   ├── AdminMenu.php
│   │   ├── Assets.php      # Conditional enqueue
│   │   └── Controller/     # Dashboard, FormBuilder, Submissions, Settings
│   ├── FormBuilder/
│   │   ├── Fields/         # FieldInterface + 8 field types
│   │   ├── FieldRegistry.php
│   │   ├── FormRepository.php
│   │   ├── SubmissionRepository.php
│   │   ├── Shortcode.php
│   │   ├── SocialShortcode.php
│   │   ├── CptShortcodes.php
│   │   └── SubmissionHandler.php
│   ├── Export/
│   │   └── CsvExporter.php
│   ├── REST/
│   │   └── FormEndpoint.php
│   └── PostTypes/
│       ├── PostTypeRegistry.php
│       └── TaxonomyRegistry.php
├── views/
│   ├── admin/              # PHP view templates
│   └── frontend/
├── assets/
│   ├── css/                # admin.css, frontend.css
│   └── js/                 # form-builder.js, submissions.js, form.js
└── languages/
    └── dentalkit.pot
```

**Database Tables:**

| Table | Purpose |
|-------|---------|
| `{prefix}dk_forms` | Form name, description, fields JSON schema |
| `{prefix}dk_submissions` | Captured form submissions (JSON) |
| `{prefix}dk_social_media` | Social media links |

---

## Security

- All DB queries use `$wpdb->prepare()` — no raw SQL
- Nonce verification on every form, AJAX request, and delete action
- `current_user_can('manage_options')` check on every admin controller
- `esc_html()`, `esc_attr()`, `esc_url()` on all output
- Input sanitized via `sanitize_text_field()`, `sanitize_email()`, `esc_url_raw()`
- REST API gated behind WordPress authentication

---

## Changelog

### 2.0.0
- Complete rewrite — PHP 8.0, WP 6.0 minimum, `DentalKit\` namespace, PSR-4 autoloading
- New: Drag-and-drop form builder with 8 field types
- New: Submissions table with CSV export (UTF-8 BOM)
- New: WP REST API (`dentalkit/v1/forms`)
- New: CPT shortcodes with columns, limit, category support
- New: Social media shortcodes `[dk_social]` and `[dk_social_list]`
- New: Email notification on submission
- Security: All queries prepared, all output escaped, nonces everywhere
- Removed: jQuery Validation Engine, raw SQL, procedural global functions

### 1.0.0
- Initial release (March 2017)

---

## License

GPL-2.0-or-later — see [LICENSE](https://www.gnu.org/licenses/gpl-2.0.html)

---

## Author

**Trentium Team** — [trentiums.com](https://www.trentiums.com)

