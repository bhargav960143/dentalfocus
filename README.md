# DentalFocus

<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/banner-772x250.jpg" alt="DentalFocus — WordPress Plugin for Dental Practices" />
</p>

<p align="center">
  <img src="https://img.shields.io/badge/version-2.8.0-blue.svg?style=for-the-badge" alt="Version 2.8.0" />
  <img src="https://img.shields.io/badge/WordPress-%3E%3D6.0-21759b.svg?style=for-the-badge&logo=wordpress" alt="WordPress 6.0+" />
  <img src="https://img.shields.io/badge/PHP-%3E%3D8.0-8892bf.svg?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.0+" />
  <img src="https://img.shields.io/badge/license-GPL--2.0--or--later-green.svg?style=for-the-badge" alt="License" />
</p>

<p align="center">
  <img src="https://img.shields.io/github/stars/bhargav960143/dentalkit?style=for-the-badge&logo=github&color=yellow" alt="GitHub Stars" />
  <img src="https://img.shields.io/github/forks/bhargav960143/dentalkit?style=for-the-badge&logo=github&color=orange" alt="GitHub Forks" />
  <img src="https://img.shields.io/github/issues/bhargav960143/dentalkit?style=for-the-badge&logo=github&color=red" alt="GitHub Issues" />
  <img src="https://img.shields.io/github/last-commit/bhargav960143/dentalkit?style=for-the-badge&logo=github&color=brightgreen" alt="Last Commit" />
</p>

<p align="center">
  Complete dental practice website toolkit — drag-and-drop form builder, custom post types, submissions management, CSV export, Gutenberg blocks, and social media management.
</p>

<br />

<p align="center">
  <a href="https://github.com/bhargav960143/dentalkit/archive/refs/heads/master.zip">
    <img src="https://img.shields.io/badge/⬇%20Download%20Plugin-DentalFocus%20v2.8.0-0073aa?style=for-the-badge&logo=wordpress&logoColor=white" alt="Download DentalFocus v2.8.0" />
  </a>
  &nbsp;&nbsp;
  <a href="https://github.com/bhargav960143/dentalkit/issues">
    <img src="https://img.shields.io/badge/🐛%20Report%20Bug-open%20issue-d63638?style=for-the-badge" alt="Report Bug" />
  </a>
  &nbsp;&nbsp;
  <a href="https://github.com/bhargav960143/dentalkit/issues">
    <img src="https://img.shields.io/badge/✨%20Request%20Feature-open%20issue-00a32a?style=for-the-badge" alt="Request Feature" />
  </a>
</p>

---

## Features

| Feature | Description |
|---------|-------------|
| **Form Builder** | Drag-and-drop builder with 8 field types. No code required. |
| **Auto Shortcodes** | `[dk_form id="1"]` generated automatically on save. |
| **Submissions** | Capture, view, filter, and delete form submissions. |
| **CSV Export** | UTF-8 + BOM export, Excel-compatible. Filter by form first. |
| **Email Notifications** | Per-submission email to configurable address + patient confirmation email. |
| **Per-form Confirmation** | Custom thank-you message per form, shown after submission. |
| **Honeypot Spam Protection** | Silent bot blocking on all forms — no CAPTCHA friction. |
| **GDPR Consent** | Optional consent checkbox on all forms — enable in Settings → General. |
| **CPT Shortcodes** | `[dk_testimonials]`, `[dk_team]`, `[dk_treatments]`, `[dk_portfolio]`, `[dk_banners]` |
| **Star Ratings** | 1–5 star ratings on testimonials, displayed in gold on the frontend. |
| **Treatment Price** | Price and price note on treatment posts, displayed on treatment cards. |
| **Team Social Links** | LinkedIn, Instagram, Facebook, Twitter fields on team member profiles. |
| **Before/After Slider** | Drag-to-reveal image comparison slider for portfolio posts. |
| **Social Media** | Manage links, display with `[dk_social]` or `[dk_social_list]`. |
| **WhatsApp Button** | `[dk_whatsapp]` click-to-chat shortcode with button/link styles. |
| **Click-to-Call** | `[dk_call]` shortcode renders a tappable phone number. |
| **Google Maps** | `[dk_map address="..."]` embeds a Google Maps iframe. |
| **Opening Hours** | `[dk_opening_hours]` table/list from Settings → Opening Hours. |
| **Treatment Enquiry** | `[dk_treatment_enquiry id="1"]` pre-fills form with treatment name. |
| **Gutenberg Blocks** | All shortcodes available as blocks under the "Dental Focus" category. |
| **REST API** | Full CRUD at `/wp-json/DentalFocus/v1/forms`. |
| **Security** | `$wpdb->prepare()` everywhere, nonces, `manage_options` checks, output escaping, CSV formula injection protection. |
| **Performance** | Assets load only on DentalFocus pages and shortcode pages. PSR-4 autoloading. |
| **i18n** | Translation-ready, `dentalfocus` text domain, POT file included. |

---

## Screenshots

### Dashboard
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-1.png" alt="DentalFocus Dashboard" width="100%" />
</p>

Overview of all modules — Form Builder, Submissions, Testimonials, Team, Treatments, Portfolio, Banners, Settings.

---

### Form Builder — Create New Form
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-2.png" alt="Form Builder — create form" width="100%" />
</p>

New form screen — enter a Form Name and optional Description, then drag field types from the left palette (Text, Email, Phone, Textarea, Dropdown, Checkboxes, Radio Buttons, Date) into the empty canvas. Hit **Save Form** when done.

---

### Form Builder — Edit Form, Fields & Shortcode
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-3.png" alt="Edit Form with shortcode and field settings" width="100%" />
</p>

Edit view shows the auto-generated shortcode (`[dk_form id="1"]`) with a **Copy** button at the top. Fields appear in the canvas with drag handles for reordering. Click the pencil icon on any field to open the **Field Settings** panel — configure Label, Placeholder, and Required toggle.

---

### Form Builder — List View & Shortcodes
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-4.png" alt="Form Builder list with shortcodes" width="100%" />
</p>

All saved forms in one table — Name, field count, submission count, auto-generated shortcode, created date, and Edit/Delete actions.

---

### Submissions — Data Table
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-6.png" alt="Submission detail view" width="100%" />
</p>

All patient form submissions in one view. Filter by form, export to CSV, or delete individual entries.

---

### Submissions — Single Detail View
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-7.png" alt="Settings panel" width="100%" />
</p>

Full submission data with field labels, values, timestamp, and IP address.

---

### Settings — General, Social Media & Help
<p align="center">
  <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-8.png" alt="Frontend form rendered by shortcode" width="100%" />
</p>

Tabs — **General**: email notifications, reCAPTCHA, GDPR consent. **Social Media**: manage social links. **Opening Hours**: per-day hours with open/closed toggle. **Help & Guide**: usage reference.

---

### Frontend Form
<p align="center">
    <img src="https://raw.githubusercontent.com/bhargav960143/dentalkit/master/assets/screenshot-5.png" alt="Submissions management table" width="100%" />
</p>

Frontend form rendered by `[dk_form id="1"]`. Fully responsive, accessible, AJAX submission with inline validation.

---

## How It Works

### Form Builder — From Zero to Live Form in 4 Steps

**Step 1 — Create a form**

Go to **DentalFocus → Form Builder → Add New Form**.
Enter a form name (e.g. *Appointment Request*) and an optional description.

```
DentalFocus
 └── Form Builder
      └── Add New Form  ← click here
```

---

**Step 2 — Drag fields onto the canvas**

The screen is split into two panels:

```
┌─────────────────────┬──────────────────────────────────┐
│   FIELD PALETTE     │   BUILDER CANVAS                 │
│                     │                                  │
│  [Text Field]  ──drag──▶  [ Full Name (Text) ]   [✎][✕]│
│  [Email Field]      │  [ Email Address (Email)] [✎][✕] │
│  [Phone Field]      │  [ Message (Textarea) ]   [✎][✕] │
│  [Textarea]         │                                  │
│  [Dropdown]         │  ← drop more fields here         │
│  [Checkboxes]       │                                  │
│  [Radio Buttons]    │                                  │
│  [Date Field]       │                                  │
└─────────────────────┴──────────────────────────────────┘
```

- **Drag** any field type from the left palette into the canvas
- **Reorder** fields by dragging the ≡ handle
- **Edit** a field by clicking the pencil icon — set label, placeholder, required toggle
- **Remove** a field with the trash icon

---

**Step 3 — Save → shortcode appears automatically**

Click **Save Form**. DentalFocus saves the form and instantly displays:

```
Shortcode:  [dk_form id="1"]   [Copy]
```

Click **Copy** — the shortcode is now in your clipboard. No manual setup needed.

---

**Step 4 — Paste shortcode into any page**

Open any WordPress page or post. Paste `[dk_form id="1"]` into the content editor (Gutenberg Shortcode block, Classic editor, Elementor, Divi — anywhere).

Publish the page. Your form is live.

---

### What Happens When a Visitor Submits the Form

```
Visitor fills form → clicks Submit
        │
        ▼
DentalFocus validates each field (required, email format, phone format)
        │
        ├─ Validation fails → inline error messages shown, no data sent
        │
        └─ Validation passes
                │
                ├─ Honeypot check → bot detected → silent discard
                │
                ▼
        Data saved to database (wp_dk_submissions table)
                │
                ├─ Email notification sent to admin (if enabled in Settings)
                ├─ Confirmation email sent to patient (if email field present)
                └─ Custom confirmation message shown to visitor
```

---

### Viewing & Exporting Submissions

Go to **DentalFocus → Submissions**.

```
DentalFocus
 └── Submissions
      ├── Filter by form  [dropdown]
      ├── [Export CSV]    ← downloads all submissions as .csv (Excel-ready)
      │
      └── Table rows
           ├── ID | Form | Data Preview | IP | Date | [View] [Delete]
           └── Click [View] to see full submission detail
```

The CSV file:
- Opens correctly in Microsoft Excel (UTF-8 BOM included)
- First row = column headers (field labels)
- One row per submission
- Formula injection protected — values prefixed where needed

---

### Displaying Post Types (Testimonials, Team, etc.)

1. Go to **Testimonials / Team / Treatments / Portfolio / Banners** in the WP sidebar
2. Add your content (title, featured image, description)
3. Use a shortcode to display it anywhere:

```
[dk_testimonials columns="3" limit="6"]
[dk_team columns="4"]
[dk_treatments columns="3" category="cosmetic"]
[dk_portfolio columns="4" limit="12"]
[dk_banners]
```

All shortcodes support:

| Attribute | Default | Description |
|-----------|---------|-------------|
| `limit` | `10` | Number of items to show |
| `columns` | varies | Grid columns (1–6) |
| `category` | — | Filter by category slug |
| `orderby` | `date` | Sort by: `date`, `title`, `menu_order` |
| `order` | `DESC` | `ASC` or `DESC` |

---

### Social Media Links

1. Go to **DentalFocus → Settings → Social Media tab**
2. Click **Add New** — enter title (e.g. *Facebook*) and URL
3. The slug is auto-generated (e.g. `facebook`)
4. Use in templates:

```
[dk_social name="facebook"]           → <a href="...">Facebook</a>
[dk_social name="instagram"]          → <a href="...">Instagram</a>
[dk_social_list]                      → <ul> of all social links
```

---

### Opening Hours

1. Go to **DentalFocus → Settings → Opening Hours tab**
2. Set open/closed and from/to time for each day of the week
3. Display anywhere with:

```
[dk_opening_hours]              → table layout (default)
[dk_opening_hours style="list"] → <ul> layout
```

Today's row is automatically highlighted.

---

### Before/After Slider

Add before and after images to any Portfolio post via the **Before/After Images** meta box, then display:

```
[dk_before_after post="42"]                         → uses images from portfolio post ID 42
[dk_before_after before="10" after="11"]            → direct attachment IDs
[dk_before_after post="42" label_before="Old" label_after="New"]
```

Mouse and touch drag supported.

---

### Treatment Enquiry Form

Pre-fills a contact form with the treatment name. Useful on individual treatment pages.

```
[dk_treatment_enquiry id="1"]
```

When placed on a treatment post, it auto-detects the treatment name. The `id` attribute sets which form to render.

---

### Utility Shortcodes

```
[dk_whatsapp number="+447700000000" message="Hello" label="Chat on WhatsApp" style="button"]
[dk_call number="+447700000000" label="Call Us"]
[dk_map address="10 Downing Street, London"]
```

---

### Gutenberg Blocks

All shortcodes are available as blocks under the **Dental Focus** category in the block inserter. Blocks render a live server-side preview in the editor.

| Block | Settings |
|-------|---------|
| Dental Focus Form | Form dropdown |
| Testimonials | Items, Columns, Category |
| Team | Items, Columns, Category |
| Treatments | Items, Columns, Category |
| Portfolio | Items, Columns, Category |
| Banners | Items, Columns, Category |
| Social Link | Platform name |
| Social Links List | — |
| Before/After Slider | Post ID or Before/After attachment IDs, labels |
| WhatsApp Button | Number, Message, Label, Style |

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
2. Copy the `trunk/` folder to `/wp-content/plugins/dentalfocus/`.
3. In WordPress admin go to **Plugins → Installed Plugins**.
4. Activate **DentalFocus**.
5. Go to **DentalFocus → Form Builder → Add New Form** to create your first form.
6. Paste the generated shortcode into any page or post.

---

## Shortcode Reference

| Shortcode | Description | Attributes |
|-----------|-------------|------------|
| `[dk_form id="1"]` | Render a form | `id` (required) |
| `[dk_treatment_enquiry id="1"]` | Treatment enquiry form | `id` (required), `treatment` (optional override) |
| `[dk_testimonials]` | Testimonials grid | `limit`, `columns`, `category`, `orderby`, `order` |
| `[dk_team]` | Team members grid | `limit`, `columns`, `category` |
| `[dk_treatments]` | Treatments grid | `limit`, `columns`, `category` |
| `[dk_portfolio]` | Portfolio grid | `limit`, `columns`, `category` |
| `[dk_banners]` | Banners display | `limit`, `columns`, `category` |
| `[dk_before_after]` | Before/after image slider | `post`, `before`, `after`, `label_before`, `label_after` |
| `[dk_social name="facebook"]` | Single social link | `name` (slug), `label`, `class` |
| `[dk_social_list]` | All social links as `<ul>` | `class` |
| `[dk_whatsapp]` | WhatsApp click-to-chat button | `number`, `message`, `label`, `style` (`button`\|`link`) |
| `[dk_call]` | Click-to-call link | `number`, `label` |
| `[dk_map]` | Google Maps embed | `address` |
| `[dk_opening_hours]` | Opening hours display | `style` (`table`\|`list`) |

**Examples:**
```
[dk_form id="1"]
[dk_treatment_enquiry id="1"]
[dk_testimonials limit="6" columns="3" category="general"]
[dk_team columns="4"]
[dk_treatments columns="3" limit="9"]
[dk_portfolio columns="4" limit="12"]
[dk_banners]
[dk_before_after post="42"]
[dk_before_after before="10" after="11" label_before="Old" label_after="New"]
[dk_social name="facebook"]
[dk_social_list]
[dk_whatsapp number="+447700000000" message="Hello" label="Chat on WhatsApp" style="button"]
[dk_call number="+447700000000" label="Call Us Now"]
[dk_map address="10 Downing Street, London"]
[dk_opening_hours]
[dk_opening_hours style="list"]
```

---

## REST API

Base URL: `/wp-json/DentalFocus/v1/`

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
├── dentalfocus.php         # Plugin header + PSR-4 autoloader
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
│   ├── Blocks/
│   │   └── BlockRegistrar.php  # Gutenberg block registration (10 blocks)
│   ├── FormBuilder/
│   │   ├── Fields/         # FieldInterface + 8 field types
│   │   ├── FieldRegistry.php
│   │   ├── FormRepository.php
│   │   ├── SubmissionRepository.php
│   │   ├── Shortcode.php           # dk_form, dk_treatment_enquiry
│   │   ├── SocialShortcode.php     # dk_social, dk_social_list, dk_whatsapp, dk_call, dk_map
│   │   ├── CptShortcodes.php       # dk_testimonials, dk_team, dk_treatments, dk_portfolio, dk_banners
│   │   ├── BeforeAfterShortcode.php # dk_before_after
│   │   ├── OpeningHoursShortcode.php # dk_opening_hours
│   │   └── SubmissionHandler.php
│   ├── Export/
│   │   └── CsvExporter.php
│   ├── REST/
│   │   └── FormEndpoint.php
│   └── PostTypes/
│       ├── PostTypeRegistry.php
│       ├── TaxonomyRegistry.php
│       ├── TreatmentMeta.php   # Price + price note fields
│       ├── TeamMeta.php        # LinkedIn, Instagram, Facebook, Twitter
│       ├── TestimonialMeta.php # Star rating (1–5)
│       └── PortfolioMeta.php   # Before/after image attachment IDs
├── views/
│   ├── admin/              # PHP view templates
│   └── frontend/
├── assets/
│   ├── css/                # admin.css, frontend.css
│   └── js/
│       ├── admin/
│       │   ├── form-builder.js
│       │   ├── submissions.js
│       │   ├── blocks.js           # Gutenberg block editor scripts
│       │   └── portfolio-meta.js   # Media uploader for before/after images
│       └── frontend/
│           ├── form.js
│           └── before-after.js     # Drag-to-reveal slider
└── languages/
    └── dentalfocus.pot
```

**Database Tables:**

| Table | Purpose |
|-------|---------|
| `{prefix}dk_forms` | Form name, description, fields JSON schema, confirmation message |
| `{prefix}dk_submissions` | Captured form submissions (JSON) |
| `{prefix}dk_social_media` | Social media links |

---

## Security

- All DB queries use `$wpdb->prepare()` — no raw SQL
- Nonce verification on every form, AJAX request, and delete action
- `current_user_can('manage_options')` check on every admin controller
- `esc_html()`, `esc_attr()`, `esc_url()` on all output
- Input sanitized via `sanitize_text_field()`, `sanitize_email()`, `esc_url_raw()`, `wp_unslash()`
- CSV formula injection protection — values prefixed to prevent Excel formula execution
- Honeypot field on all forms — silent bot discard, no user friction
- REST API gated behind WordPress authentication

---

## Changelog

### 2.8.0
- New: `[dk_treatment_enquiry id="1"]` — pre-fills form with treatment name, auto-detects on treatment pages
- New: Patient confirmation email — patients receive acknowledgement after submission
- New: Honeypot spam protection on all forms — silent bot blocking
- New: `[dk_call number="+44..." label="Call Us"]` click-to-call shortcode
- New: `[dk_opening_hours]` shortcode with Settings → Opening Hours tab
- New: Team member social links — LinkedIn, Instagram, Facebook, Twitter on team profiles
- New: `[dk_map address="..."]` Google Maps embed shortcode
- New: Per-form confirmation message — custom thank-you text per form

### 2.7.0
- Security: CSV formula injection fix — values starting with `=`, `+`, `-`, `@` are prefixed
- Security: `wp_unslash()` added to all `$_POST` reads in SettingsController and PortfolioMeta
- Fix: `mb_substr()` for multibyte-safe user agent string truncation

### 2.6.0
- New: Before/After image comparison slider for dental portfolio
- New: `[dk_before_after]` shortcode — use post ID or direct attachment IDs
- New: Drag-to-reveal slider with mouse and touch support
- New: Before/After image meta box on Portfolio posts with WP media uploader
- New: Gutenberg block for before/after slider under Dental Focus category

### 2.5.0
- New: Price field on Treatments post type — set price and price note from admin sidebar
- New: Price displayed on treatment cards with bold value and small note

### 2.4.0
- New: `[dk_whatsapp]` click-to-chat shortcode with number, message, label, and style params
- New: WhatsApp Gutenberg block under Dental Focus block category
- New: Green WhatsApp button style with inline SVG icon

### 2.3.0
- New: GDPR consent checkbox on all forms — enable in Settings → General
- New: Configurable consent label and privacy policy URL
- New: Server-side validation blocks submission if consent not given
- New: Consent field excluded from stored submission data

### 2.2.0
- New: Star ratings (1–5) on testimonials — set from admin meta box, displayed in gold on frontend
- New: "No rating" option to keep testimonials without stars

### 2.1.0
- New: Gutenberg blocks for all shortcodes — use Dental Focus directly in the block editor
- New: "Dental Focus" block category in block inserter
- New: Live server-side preview for all blocks in editor
- New: Form block with dynamic form dropdown fetched from REST API
- New: CPT blocks (Testimonials, Team, Treatments, Portfolio, Banners) with Items, Columns, Category controls
- New: Social Link and Social Links List blocks

### 2.0.0
- Complete rewrite — PHP 8.0, WP 6.0 minimum, `DentalFocus\` namespace, PSR-4 autoloading
- New: Drag-and-drop form builder with 8 field types
- New: Submissions table with CSV export (UTF-8 BOM)
- New: WP REST API (`DentalFocus/v1/forms`)
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

<p>
  <a href="https://github.com/bhargav960143" title="Bhargav Patel">
    <img src="https://github.com/bhargav960143.png" width="80" height="80" style="border-radius:50%" alt="Bhargav Patel" />
  </a>
</p>

**Bhargav Patel** — Full Stack WordPress Developer

<p>
  <a href="https://www.linkedin.com/in/bhargav-patel-tech-partner/">
    <img src="https://img.shields.io/badge/LinkedIn-Bhargav%20Patel-0077b5?style=flat-square&logo=linkedin&logoColor=white" alt="LinkedIn" />
  </a>
  &nbsp;
  <a href="https://github.com/bhargav960143">
    <img src="https://img.shields.io/badge/GitHub-bhargav960143-181717?style=flat-square&logo=github&logoColor=white" alt="GitHub" />
  </a>
  &nbsp;
  <a href="https://www.trentiums.com/bhargav">
    <img src="https://img.shields.io/badge/Website-trentiums.com-0073aa?style=flat-square&logo=wordpress&logoColor=white" alt="Website" />
  </a>
</p>

---

## Sponsor

Support this project by becoming a sponsor.

<a href="https://www.trentiums.com/" title="Trentium Solution">
  <img src="https://www.trentiums.com/front/theme/assets/img/logo/logo.png" height="80" alt="Trentium Solution" />
</a>

**[Trentium Solution](https://www.trentiums.com/)** — Web & Mobile Development Company
