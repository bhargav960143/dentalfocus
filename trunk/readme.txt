=== DentalKit ===
Contributors: trentiumteam
Tags: dental, form builder, appointment form, testimonials, dental team, dental practice
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.0
Stable tag: 2.0.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Complete dental practice website toolkit — drag-and-drop form builder, shortcodes, submissions management, and CSV export.

== Description ==

DentalKit is a professional WordPress plugin built specifically for dental practices. It provides everything you need to manage your dental website content and capture patient enquiries.

**Key Features:**

* **Drag-and-Drop Form Builder** — Create unlimited custom forms without touching code. Drag fields from the palette, reorder them, configure labels and validation, save and go.
* **Auto-Generated Shortcodes** — Every form gets a unique shortcode (e.g. `[dk_form id="1"]`) automatically. Copy and paste into any page or post.
* **Submissions Management** — All form submissions stored securely. View, filter by form, and delete individual entries from the admin panel.
* **CSV Export** — Export any form's submissions to a UTF-8 CSV file (Excel compatible with BOM). Filter by form before exporting.
* **Email Notifications** — Get notified by email on every new form submission. Configurable notification address.
* **Custom Post Types** — Dedicated post types for Testimonials, Team Members, Treatments, Portfolio, and Banners — each with category taxonomy support.
* **CPT Shortcodes** — Display any post type on any page: `[dk_testimonials]`, `[dk_team]`, `[dk_treatments]`, `[dk_portfolio]`, `[dk_banners]`.
* **Social Media Manager** — Store and manage all practice social media links. Display with `[dk_social name="facebook"]` or `[dk_social_list]`.
* **REST API** — Full WP REST API (`/wp-json/dentalkit/v1/forms`) for headless/custom integrations.
* **Security First** — All inputs sanitized, all outputs escaped, nonce verification on every form and AJAX request, `manage_options` capability checks throughout.
* **Performance** — Assets load only on pages that use DentalKit shortcodes. PSR-4 autoloading, no bloat.
* **Translation Ready** — Fully internationalized with `dentalkit` text domain.

**Shortcode Reference:**

`[dk_form id="1"]` — Display a form by ID
`[dk_testimonials limit="5" columns="3" category="slug"]` — Testimonials grid
`[dk_team limit="10" columns="3" category="slug"]` — Team members grid
`[dk_treatments limit="10" columns="3" category="slug"]` — Treatments grid
`[dk_portfolio limit="12" columns="4" category="slug"]` — Portfolio grid
`[dk_banners columns="1" category="slug"]` — Banners display
`[dk_social name="facebook"]` — Single social link
`[dk_social_list]` — All social links as a list

**Requires:** PHP 8.0+, WordPress 6.0+

== Installation ==

1. Upload the `dentalkit` folder to `/wp-content/plugins/`.
2. Activate the plugin from **Plugins > Installed Plugins**.
3. Go to **DentalKit** in the admin sidebar.
4. Navigate to **Form Builder > Add New Form** to create your first form.
5. Paste the generated shortcode into any page or post.

== Frequently Asked Questions ==

= How do I create a form? =

Go to DentalKit > Form Builder > Add New Form. Enter a form name, then drag field types from the left palette into the builder canvas. Click Save Form — your shortcode is generated automatically.

= What field types are available? =

Text, Email, Phone, Textarea, Dropdown (Select), Checkboxes, Radio Buttons, and Date.

= Where do submissions go? =

All submissions are stored in your WordPress database. View them under DentalKit > Submissions. Export to CSV at any time.

= Can I display team members, testimonials, etc.? =

Yes. DentalKit registers custom post types for Testimonials, Team Members, Treatments, Portfolio, and Banners. Add content via the WordPress admin, then use shortcodes to display them anywhere.

= Is it translation-ready? =

Yes. The plugin uses the `dentalkit` text domain. Create translations using Loco Translate or standard .po/.mo workflow.

= Does it work with page builders? =

Yes. Any shortcode works with Gutenberg (Shortcode block), Elementor, Divi, and any builder that supports WordPress shortcodes.

= Is it secure? =

Yes. All form submissions are nonce-verified and sanitized server-side. All output is escaped. No raw SQL — the plugin uses $wpdb->prepare() for every database query.

== Screenshots ==

1. DentalKit Dashboard — module overview
2. Drag-and-drop Form Builder
3. Field settings panel
4. Submissions management with filter and export
5. Single submission detail view
6. Settings — General and Social Media tabs

== Changelog ==

= 2.0.0 =
* Complete rewrite — PHP 8.0, WP 6.0 minimum
* New: Drag-and-drop form builder with 8 field types
* New: Submissions table with CSV export
* New: WP REST API for forms (dentalkit/v1/forms)
* New: Social media manager with shortcodes
* New: CPT shortcodes (testimonials, team, treatments, portfolio, banners)
* New: PSR-4 autoloading, DentalKit namespace
* Security: All queries use $wpdb->prepare(), nonces on all forms, capability checks throughout
* Removed: jQuery Validation Engine dependency
* Removed: All raw SQL string concatenation

= 1.0.0 =
* Initial release (March 2017)

== Upgrade Notice ==

= 2.0.0 =
Major version upgrade. Complete rewrite. Old social media data in dentalfocus_social_media table will NOT be migrated automatically. Export your data before upgrading if needed.

