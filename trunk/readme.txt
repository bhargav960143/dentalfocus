=== Dental Focus ===
Contributors: trentiums
Tags: dental, form builder, appointment form, testimonials, dental team
Requires at least: 6.0
Tested up to: 7.0
Requires PHP: 8.0
Stable tag: 2.8.0
License: GPL-2.0-or-later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

WordPress plugin for dental clinics — appointment forms, testimonials, team profiles, treatments, portfolio, and social media links. No coding needed.

== Description ==

**Dental Focus** is a purpose-built WordPress plugin for dental professionals. Whether you run a single dental clinic, a multi-branch dental hospital, or a specialist dental practice, Dental Focus gives you every tool you need to manage your website content, capture patient enquiries, and showcase your services — all from a clean, intuitive WordPress admin interface.

No page builder subscription. No coding required. Just install, activate, and start building.

---

=== Who Is This For? ===

* **Dental Hospitals** — Manage multiple departments, large teams, and high patient enquiry volumes with structured form submissions and CSV exports.
* **Dental Clinics** — Showcase your treatments, capture appointment requests, and display patient testimonials to build trust with new visitors.
* **Dental Appointment Booking Sites** — Use the drag-and-drop form builder to create custom appointment request forms for any service or specialist.
* **Dental Team Showcase** — Add every dentist, hygienist, and specialist with their bio, photo, and category — display them anywhere with a single shortcode.
* **Dental Portfolio Sites** — Present before/after cases, clinic photography, and treatment imagery in a structured, categorised portfolio gallery.
* **Dental Information & Education Sites** — Publish detailed treatment pages, FAQs, and service descriptions using Dental Focus's Treatments post type.

---

=== Problems Dental Focus Solves ===

**Problem: Patients can't easily book or enquire online.**
Most dental websites have a basic contact form that dumps everything in one inbox. Dental Focus lets you build separate forms for appointment requests, new patient registrations, treatment enquiries, and surveys — each with its own submissions log, CSV export, and email notification.

**Problem: No structured way to showcase patient testimonials.**
Word of mouth is everything in dentistry. Dental Focus gives you a dedicated Testimonials post type with category support. Display them in a responsive grid with `[dk_testimonials]` — filter by category, control the count and columns.

**Problem: Managing team profiles is messy.**
Dentists come and go. With Dental Focus's Team Members post type, each team member has their own profile page. Use `[dk_team]` to display them anywhere, filtered by specialty or department.

**Problem: Treatments buried in generic pages.**
Patients search for specific treatments — implants, whitening, Invisalign. Dental Focus's Treatments post type gives each treatment a proper entry. Display them with `[dk_treatments]`, categorised and filterable.

**Problem: Leads go nowhere.**
Every form submission is stored securely in your database, visible in the admin under Dental Focus > Submissions. Filter by form, view individual entries, and export everything to CSV for your CRM or follow-up workflow.

**Problem: Survey and feedback forms need a developer.**
With the drag-and-drop form builder, you can create satisfaction surveys, post-treatment feedback forms, or new patient questionnaires in minutes. No developer. No plugin subscription.

**Problem: Social media links scattered across theme settings.**
Dental Focus's Social Media Manager stores all your practice's social links in one place. Output a single link with `[dk_social name="facebook"]` or display them all at once with `[dk_social_list]`.

---

=== Features — In Detail ===

**Drag-and-Drop Form Builder**
Build unlimited custom forms from the WordPress admin. Drag field types from the palette onto the canvas, reorder by dragging, configure labels, placeholders, and required validation — then click Save. Your shortcode is generated automatically. Use it for appointment requests, lead capture, new patient registrations, surveys, or any custom enquiry form your practice needs.

Supported field types: Text, Email, Phone, Textarea, Dropdown (Select), Checkboxes, Radio Buttons, Date.

**Submissions Management**
Every form submission is stored securely in your database. View all submissions under Dental Focus > Submissions. Filter by form to see only appointment requests, or only survey responses. Delete individual entries. Nothing gets lost in a shared inbox.

**CSV Export**
Export any form's submissions to a UTF-8 CSV file (Excel-compatible, BOM included). Filter by form before exporting. Hand the file to your front desk team, import it into your CRM, or archive it for compliance.

**Email Notifications**
Get notified instantly by email on every new form submission. Configure the notification email address per form. Your front desk team never misses an appointment request again.

**Testimonials Post Type**
A dedicated post type for patient testimonials with full category taxonomy support. Add as many testimonials as you like, assign them to categories (e.g. "Implants", "Whitening", "Orthodontics"), and display them anywhere with:
`[dk_testimonials limit="5" columns="3" category="implants"]`

**Team Members Post Type**
Showcase every dentist, specialist, and staff member with a structured profile. Assign categories (e.g. "Orthodontist", "Hygienist", "Surgeon"). Display with:
`[dk_team limit="10" columns="3" category="orthodontist"]`

**Treatments Post Type**
Give each dental treatment its own entry — description, imagery, category. Display a treatments menu anywhere with:
`[dk_treatments limit="10" columns="3" category="cosmetic"]`

**Portfolio Post Type**
Showcase clinic photography, before/after cases, and treatment imagery in a categorised portfolio. Display with:
`[dk_portfolio limit="12" columns="4" category="before-after"]`

**Banners Post Type**
Manage promotional banners and hero images from the admin. Display them in any layout with:
`[dk_banners columns="1" category="promotions"]`

**Social Media Manager**
Store all practice social media URLs (Facebook, Instagram, Twitter, LinkedIn, YouTube, etc.) in one admin panel. Output a single link:
`[dk_social name="facebook"]`
Or display all of them as a list:
`[dk_social_list]`

**WP REST API**
Full REST API endpoint at `/wp-json/dentalfocus/v1/forms` for headless WordPress setups, custom mobile apps, or external integrations.

**Security**
All form inputs are sanitized server-side. All output is escaped. Every form and AJAX request uses WordPress nonce verification. All database queries use `$wpdb->prepare()` — no raw SQL. Capability checks (`manage_options`) protect every admin action.

**Performance**
Plugin assets (CSS/JS) load only on pages that actually use Dental Focus shortcodes — no unnecessary overhead on other pages. PSR-4 autoloading keeps memory usage lean.

**Translation Ready**
Fully internationalized with the `dentalfocus` text domain. Create translations using Loco Translate or the standard `.po`/`.mo` workflow.

---

=== Shortcode Reference ===

`[dk_form id="1"]` — Render a form by ID
`[dk_testimonials limit="5" columns="3" category="slug"]` — Testimonials grid
`[dk_team limit="10" columns="3" category="slug"]` — Team members grid
`[dk_treatments limit="10" columns="3" category="slug"]` — Treatments grid
`[dk_portfolio limit="12" columns="4" category="slug"]` — Portfolio grid
`[dk_banners columns="1" category="slug"]` — Banners display
`[dk_social name="facebook"]` — Single social link
`[dk_social_list]` — All social links as a list

---

=== Support & Custom Development ===

Need help setting up Dental Focus, or require custom development for your dental practice website?

**Bhargav — WordPress Developer**
Email: [bhargav@trentiums.com](mailto:bhargav@trentiums.com)
GitHub: [github.com/bhargav960143](https://github.com/bhargav960143)

Available for plugin customisation, custom form logic, CRM integrations, and bespoke dental website development.

---

**Requires:** PHP 8.0+, WordPress 6.0+

== Installation ==

1. Upload the `dentalfocus` folder to `/wp-content/plugins/`.
2. Activate the plugin from **Plugins > Installed Plugins**.
3. Go to **Dental Focus** in the admin sidebar.
4. Navigate to **Form Builder > Add New Form** to create your first form.
5. Paste the generated shortcode into any page or post.

== Frequently Asked Questions ==

= What is the best WordPress plugin for dental clinics? =

Dental Focus is a purpose-built WordPress plugin for dental clinics, dental hospitals, and dental practices. It provides appointment booking forms, patient testimonial management, dental team profiles, treatment listings, portfolio galleries, and social media management — all in a single free plugin designed specifically for dental websites.

= How do I add an appointment booking form to my dental website? =

Install Dental Focus, go to Dental Focus > Form Builder > Add New Form, drag the fields you need (Name, Email, Phone, Date, preferred treatment), click Save, then paste the auto-generated shortcode `[dk_form id="1"]` into any page or post. The form captures submissions directly into your WordPress database and sends you an email notification for every new booking request.

= How do I display my dental team on a WordPress website? =

Dental Focus adds a dedicated Team Members post type to your WordPress admin. Add each dentist, hygienist, or specialist as a post, upload their photo, write their bio, and assign them to a specialty category. Then place `[dk_team limit="10" columns="3"]` on any page to display a responsive team grid. Filter by specialty using the `category` parameter.

= How do I add patient testimonials to a dental website? =

Dental Focus includes a Testimonials custom post type. Add each testimonial from WordPress admin > Testimonials > Add New, assign it to a category (e.g. Implants, Whitening, Invisalign), and display them anywhere with `[dk_testimonials limit="5" columns="3"]`. You can filter testimonials by treatment category to show relevant social proof on each service page.

= Can I create a dental appointment request form without coding? =

Yes. Dental Focus includes a drag-and-drop form builder. Open Dental Focus > Form Builder > Add New Form, drag fields from the palette (Text, Email, Phone, Date, Dropdown, Checkboxes, Radio, Textarea), reorder them by dragging, set required fields, and click Save. No coding required. Your form shortcode is generated automatically.

= Where are dental appointment form submissions stored? =

All form submissions are stored securely in your WordPress database. View them under Dental Focus > Submissions in your admin panel. Filter by form to see only appointment requests, only survey responses, or any specific form. Export all submissions to a CSV file compatible with Excel and Google Sheets.

= How do I add dental treatments or services to my WordPress website? =

Dental Focus registers a Treatments custom post type. Add each dental treatment (implants, whitening, braces, veneers, etc.) as a post with its own description, images, and category. Display a treatments menu anywhere on your site using `[dk_treatments limit="10" columns="3" category="cosmetic"]`. This gives each treatment its own structured entry instead of burying them in a generic services page.

= Does Dental Focus work with Elementor, Divi, or other page builders? =

Yes. All Dental Focus shortcodes work inside any page builder that supports WordPress shortcodes. In Elementor, use the Shortcode widget. In Divi, use the Code module. In Gutenberg (WordPress block editor), use the Shortcode block. Paste the shortcode and your content renders immediately.

= Is Dental Focus compatible with the latest version of WordPress? =

Yes. Dental Focus requires WordPress 6.0 or higher and PHP 8.0 or higher. It is regularly tested against the latest WordPress releases. The plugin follows WordPress coding standards with sanitized inputs, escaped outputs, nonce verification, and capability checks throughout.

= How do I showcase a dental portfolio or before-and-after gallery? =

Dental Focus includes a Portfolio custom post type. Upload your clinic photography, before-and-after treatment images, or procedure photos from WordPress admin > Portfolio > Add New. Assign them to categories (e.g. Before-After, Clinic, Procedures) and display them with `[dk_portfolio limit="12" columns="4" category="before-after"]`.

= Can I manage my dental practice social media links in WordPress? =

Yes. Dental Focus includes a Social Media Manager under Dental Focus > Settings. Enter all your practice social media URLs (Facebook, Instagram, Twitter, LinkedIn, YouTube, WhatsApp) once. Display a single platform link anywhere with `[dk_social name="facebook"]` or render all social links as a list with `[dk_social_list]`.

= How do I get email notifications when a patient submits a form? =

Dental Focus sends an email notification automatically for every new form submission. Configure the notification email address under each form's settings in Dental Focus > Form Builder. Your front desk team receives an instant alert whenever a patient submits an appointment request, enquiry, or survey.

= Can I export patient form submissions to Excel or CSV? =

Yes. Go to Dental Focus > Submissions, filter by the form you want to export, and click the Export CSV button. The file downloads as UTF-8 CSV compatible with Excel, Google Sheets, and any CRM that accepts CSV import. Useful for following up on appointment requests or archiving patient enquiry records.

= Is Dental Focus free? =

Yes. Dental Focus is completely free and open source (GPL-2.0-or-later). It is available on the WordPress plugin repository at wordpress.org/plugins/dental-focus. For custom development, CRM integrations, or bespoke dental website features, contact Bhargav at bhargav@trentiums.com.

= How do I get support for the Dental Focus WordPress plugin? =

For general support, post in the WordPress.org support forum at wordpress.org/support/plugin/dental-focus. For custom development, priority support, or bespoke dental website features, contact Bhargav directly at bhargav@trentiums.com. Custom work includes form logic, CRM integrations, booking system connections, and full dental website builds.

== Screenshots ==

1. Dental Focus Dashboard — module overview
2. Drag-and-drop Form Builder
3. Field settings panel
4. Submissions management with filter and export
5. Single submission detail view
6. Settings — General and Social Media tabs

== Changelog ==

= 2.8.0 =
* New: Treatment enquiry shortcode `[dk_treatment_enquiry id="1"]` — pre-fills form with treatment name, auto-detects on treatment pages
* New: Patient confirmation email — patients receive acknowledgement after form submission
* New: Honeypot spam protection on all forms — silent bot blocking, no friction
* New: Click-to-call shortcode `[dk_call number="+44..." label="Call Us"]`
* New: Opening hours shortcode `[dk_opening_hours]` with Settings → Opening Hours tab
* New: Team member social links — LinkedIn, Instagram, Facebook, Twitter on team profiles
* New: Google Maps embed shortcode `[dk_map address="..."]`
* New: Per-form confirmation message — custom thank-you text per form

= 2.7.0 =
* Security: Fix CSV formula injection — values starting with =, +, -, @ are now prefixed to prevent Excel formula execution
* Security: Add wp_unslash() to all $_POST reads in SettingsController and PortfolioMeta
* Fix: Use mb_substr() for multibyte-safe user agent string truncation

= 2.6.0 =
* New: Before/After image comparison slider for dental portfolio
* New: `[dk_before_after]` shortcode — use post ID or direct attachment IDs
* New: Drag-to-reveal slider with mouse and touch support
* New: Before/After image meta box on Portfolio posts with WP media uploader
* New: Gutenberg block for before/after slider under Dental Focus category

= 2.5.0 =
* New: Price field on Treatments post type — set price and price note from admin sidebar
* New: Price displayed on treatment cards with bold value and small note
* Fix: Price renders only when set — no empty space on unprice treatments

= 2.4.0 =
* New: WhatsApp click-to-chat shortcode `[dk_whatsapp]` with number, message, label, and style params
* New: WhatsApp Gutenberg block under Dental Focus block category
* New: Green WhatsApp button style with inline SVG icon

= 2.3.0 =
* New: GDPR consent checkbox on all forms — enable in Settings → General
* New: Configurable consent label and privacy policy URL
* New: Server-side validation blocks submission if consent not given
* New: Consent field excluded from stored submission data

= 2.2.0 =
* New: Star ratings (1–5) on testimonials — set rating from admin meta box, displayed in gold on frontend
* New: "No rating" option to keep testimonials without stars

= 2.1.0 =
* New: Gutenberg blocks for all 8 shortcodes — use Dental Focus directly in the block editor
* New: "Dental Focus" block category in block inserter
* New: Live server-side preview for all blocks in editor
* New: Form block with dynamic form dropdown fetched from REST API
* New: CPT blocks (Testimonials, Team, Treatments, Portfolio, Banners) with Items, Columns, Category controls
* New: Social Link and Social Links List blocks

= 2.0.0 =
* Complete rewrite — PHP 8.0, WP 6.0 minimum
* New: Drag-and-drop form builder with 8 field types
* New: Submissions table with CSV export
* New: WP REST API for forms (Dental Focus/v1/forms)
* New: Social media manager with shortcodes
* New: CPT shortcodes (testimonials, team, treatments, portfolio, banners)
* New: PSR-4 autoloading, Dental Focus namespace
* Security: All queries use $wpdb->prepare(), nonces on all forms, capability checks throughout
* Removed: jQuery Validation Engine dependency
* Removed: All raw SQL string concatenation

= 1.0.0 =
* Initial release (March 2017)

== Upgrade Notice ==

= 2.0.0 =
Major version upgrade. Complete rewrite. Old social media data in dentalfocus_social_media table will NOT be migrated automatically. Export your data before upgrading if needed.

