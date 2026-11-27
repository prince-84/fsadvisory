
---

## 🌐 GLOBAL CONVENTIONS & RULES

1. **Port Conventions**:
   - **Laravel Backend Project**: Runs on **Port 8000** (`http://127.0.0.1:8000`).
   - **Next.js Frontend Project**: Runs on **Port 3000** (`http://localhost:3000`).

2. **Mandatory Global Rule – Automatic README Updates**:
   - **Strict Requirement**: Whenever ANY update, feature, bugfix, or modification is made to the codebase, the documentation in `README.md` must be updated immediately to record what was changed, how it works, and how to use/verify it.

3. **Lead Testing Protocol – Mandatory "TEST" Keyword**:
   - Whenever any developer or agent submits or tests a lead submission, they **MUST use the word "test" or "TEST"** in the lead's name, email, or comment (e.g. `name: "TEST - Verification"`, `email: "test@example.com"`, `comment: "TEST: Checking lead delivery"`). This ensures the team and CRM administrators immediately know that the submission is an automated test.

---
# Hudayriyat Island – Full-Stack Laravel Web Application

A full-stack **Laravel 12** web application replicating 100% of the UI design, layout, typography, components, and interactive features from the original Next.js project for **Hudayriyat Island** by **Modon Properties** in Abu Dhabi, UAE.

---

## 🔐 Admin CMS & Dynamic Content (`/admin`)

- **Admin Login Route**: `http://127.0.0.1:8000/admin`
- **Default Landing**: When opening the admin CMS or logging in, the application immediately directs straight to the **Dashboard** (`/admin/dashboard`).
- **Default Admin Credentials**:
  - **Email**: `admin@hudayriyat.com`
  - **Password**: `Admin@12345`
- **Theme**: Clean, elegant White/Light theme with `#856d52` luxury bronze branding.
- **Key Admin Modules**:
  1. **Dashboard** (`/admin/dashboard`): Lead statistics, 14-day activity chart, status breakdown, and recent submissions. Always opens first upon login or navigating to `/admin`.
  2. **Centralized Pages Management** (`/admin/pages`): All standard pages (`Home`, `About Us`, `Contact Us`, `Privacy Policy`, `Terms of Service`) and all dynamic **Project Detail Pages** (such as `/wadeem-gardens`, `/hudayriyat-golf-estates`, `/bashayer-residences`, `/al-naseem-villas`, etc.) are now centrally managed in a single unified **Pages** module:
     - Breadcrumbs: `Manage > Pages` / `Home - Manage - Pages`.
     - Live real-time search filter (`Search...`).
     - Minimal table showing **`# ▲`**, **`NAME / SLUG`**, **`TYPE`** (Badges distinguishing `[Project Page]`, `[Home]`, `[Standard Page]`), and **`ACTIONS`** (Edit pencil icon, View live eye icon, and Delete trash icon with confirmation).
     - Faint dotted row dividers for clean, uncluttered reading.
     - **Inline Add Page Builder**: Single unified screen with drag-and-drop section arrangement and in-place content editing.
  3. **Dedicated Property Cards & Detail Page Manager** (`/admin/projects`): The `Projects` module serves as the dedicated **Property Cards & Detail Page Manager**:
     - **Dedicated Database Table**: Backed by the `projects` table linked to `pages` via `page_id`.
     - **Unified Property & Page Creator**: Clicking **"+ Add Property Card"** opens a full vertical tabbed editor styled identically to `/admin/pages/{id}/edit`, featuring 13 vertical tabs:
       1. **General Settings**: Page / Property Name, URL Slug, Home Page Card Metrics (Location, Price, Handover Date, Developer, Payment Plan, Status), Property Card Image, and Navbar/Publish toggles.
       2. **Hero Banner**: Background image with live preview and upload, Alt text (SEO), Badge/Pretitle, H1 Heading, and Subtitle.
       3. **Project Highlights**: Developer, Price, Handover Date, Property Type, Ownership, and custom metrics.
       4. **About Community**: Community Title, Story narrative, Video stream URL, and Cover poster.
       5. **Content**: Single unified visual Summernote WYSIWYG editor for complete page article, H1/H2/H3 headings, and photos.
       6. **Amenities & Facilities**: Community amenities title, subtitle, and interactive facility cards with icons.
       7. **Project Gallery**: 6 responsive photo slots with live preview and SEO alt text.
       8. **Payment Plan**: Breakdown for Down Payment %, During Construction %, On Handover %, and milestone items.
       9. **Frequently Asked Questions**: 4 interactive Q&A accordion items with Add Question capability.
       10. **Master Plan**: Visual diagram upload/URL and architectural narrative.
       11. **Contact & Booking CTA**: VIP registration form, button text, phone, and inquiry email.
       12. **Location & Connectivity**: Abu Dhabi commute destination drive times (Downtown, Airport, etc.).
       13. **SEO & Meta**: Meta Title, Description, and Keywords for Google indexing.
     - **Simultaneous Creation**: Saving the form creates **both** the Property Card (`projects` table) and its linked Detail Page (`pages` + all 12 `page_sections` tables) together automatically.
     - **Actions**: Live search, "+ Add Property Card" full creator, edit card modal, direct link to edit detail page, active/inactive toggle, and delete action.
  4. **Page & Project Editor** (`/admin/pages/{id}/edit`): Modern, simplified minimalist editor:
     - Breadcrumbs: `Manage {Page Name}` / `Home - Pages - Manage {Page Name}`.
     - Clickable live `🔗 Page URL` banner card.
     - Clean two-column layout with vertical tab navigation.
     - **Home Page Editor Optimization**: Manual card creation repeaters were removed from `/admin/pages/1/edit` and replaced with an alert card that points administrators directly to the dedicated **Property Cards Manager** (`/admin/projects`).
     - All section content, Summernote WYSIWYG editor, repeater cards, and save functionality 100% preserved.
  5. **Website Content** (`/admin/content`): Global key-value text editor for site-wide defaults.
  6. **Sidebar Navigation**: Cleaned up to focus strictly on Overview (`Dashboard`), Content (`Pages`, `Projects`), and Site Settings (`Global SEO & Indexing`, `Footer & Newsletter`, `Users & Permissions`). The Sales / Leads section has been removed from the sidebar.

---

## 📑 Page-Wise & Section-Wise CMS Architecture

### 1. Database Schema & Migrations
- **Migration**: `2026_10_20_113000_create_pages_and_sections_tables.php`
- **`pages` Table**:
  - `id`: Auto-incrementing primary key.
  - `title`: Page display title (e.g., `Home`, `About Us`, `Wadeem Gardens`).
  - `slug`: Unique page route / URI slug (e.g., `/`, `about-us`, `wadeem-gardens`).
  - `in_navbar`: Boolean flag indicating whether the page appears in primary navigation.
  - `navbar_order`: Integer sorting sequence in navbar menus.
  - `is_published`: Boolean visibility toggle for the page.
  - `meta_title`, `meta_description`, `meta_keywords`, `og_image`: Custom SEO & OpenGraph fields.
  - `created_at` & `updated_at`: Timestamps.

- **`page_sections` Table**:
  - `id`: Auto-incrementing primary key.
  - `page_id`: Foreign key cascade-linking to `pages.id`.
  - `section_key`: Unique programmatic identifier per page (e.g. `hero`, `highlights`, `overview`, `investment`, `contact`).
  - `section_name`: Human-readable label for the section tab (e.g. `Hero Banner & Form`, `Residential Overview`).
  - `order`: Integer sorting sequence for section tabs.
  - `is_active`: Boolean toggle allowing sections to be activated/deactivated on demand.
  - `content`: JSON column storing key-value pairs of section fields (title, subtitle, badge, cards, buttons, etc.).
  - `created_at` & `updated_at`: Timestamps.

- **`projects` Table (Property Cards Manager)**:
  - **Migration**: `2026_10_25_160000_create_projects_table.php`
  - `id`: Auto-incrementing primary key.
  - `page_id`: Nullable foreign key cascade-linking to `pages.id` (dynamic project detail page link).
  - `title`: Property/community title (e.g., `Wadeem Gardens`, `Hudayriyat Golf Estates`).
  - `slug`: Unique property card identifier.
  - `location`: Location tagline (e.g., `Hudayriyat Island, Abu Dhabi`).
  - `price`: Launch Price badge text (e.g., `Launch Price: 8.7M AED`).
  - `delivery_date`: Delivery Date badge text (e.g., `Delivery Date: Q2 2031`).
  - `developer`: Developer badge text (e.g., `Modon Properties`).
  - `payment_plan`: Payment plan badge text (e.g., `Flexible Payment Plan`).
  - `image`: Card photo URL or direct file upload path (`/images/...` or `/uploads/...`).
  - `order`: Integer sorting sequence for card display on the website.
  - `is_active`: Boolean visibility toggle for the property card.
  - `created_at` & `updated_at`: Timestamps.

### 2. Controllers & Routes
Registered under the `admin.` route group and protected by the `auth` middleware:

#### Pages Management:
- `GET /admin/pages` (`admin.pages.index`) -> `PageController@index`
- `POST /admin/pages` (`admin.pages.store`) -> `PageController@store`
- `GET /admin/pages/{page}/edit` (`admin.pages.edit`) -> `PageController@edit`
- `PUT /admin/pages/{page}` (`admin.pages.update`) -> `PageController@update`
- `DELETE /admin/pages/{page}` (`admin.pages.destroy`) -> `PageController@destroy`
- `PATCH /admin/pages/{page}/toggle-navbar` (`admin.pages.toggle-navbar`) -> `PageController@toggleNavbar`
- `PATCH /admin/pages/{page}/toggle-published` (`admin.pages.toggle-published`) -> `PageController@togglePublished`
- `POST /admin/pages/{page}/reorder-sections` (`admin.pages.reorder-sections`) -> `PageController@reorderSections`

#### Dedicated Property Cards Manager:
- `GET /admin/projects` (`admin.projects.index`) -> `ProjectController@index`
- `POST /admin/projects` (`admin.projects.store`) -> `ProjectController@store`
- `PUT /admin/projects/{project}` (`admin.projects.update`) -> `ProjectController@update`
- `DELETE /admin/projects/{project}` (`admin.projects.destroy`) -> `ProjectController@destroy`
- `PATCH /admin/projects/{project}/toggle` (`admin.projects.toggle`) -> `ProjectController@toggle`
- `POST /admin/projects/reorder` (`admin.projects.reorder`) -> `ProjectController@reorder`

### 3. Page Creation Flow: Global vs Custom Sections

Administrators can create new pages from `/admin/pages` using the **"Create New Page"** flow with two distinct options:

#### Option A: Global Page Sections (Modular Assembly)
- **Concept**: Attach reusable pre-built global components on demand.
- **Available Components**:
  - `hero`: Header banner with headline, subtitle, badge, background image & callback form.
  - `highlights`: 6-card quick facts grid (Developer, Price, Handover, Type, Bedrooms, Payment Plan).
  - `about`: Story overview, narrative paragraphs & video player.
  - `amenities`: Curated lifestyle amenities with iconography (Gym, Pool, Beach, Clubhouse, Yoga, etc.).
  - `gallery`: Responsive photo showcase gallery with hover animations.
  - `floor_plans`: Tabbed unit layouts with specifications and architectural blueprints.
  - `payment_plan`: Transparent milestone installment schedule.
  - `payment_methods`: Financing cards, escrow accounts, mortgages, and 10-Year Golden Visa info.
  - `faq`: Interactive accordion with frequently asked questions.
  - `master_plan`: High-resolution master plan visualization.
  - `location`: Abu Dhabi landmark driving times (Downtown, Airport, Louvre, Grand Mosque).
  - `toc`: Dynamic Table of Contents sidebar with deep anchor scrolling.
  - `contact`: Lead capture inquiry form and direct advisor contact details.

#### Option B: Custom Page (Full Section Builder)
- **Concept**: Automatically loads the complete 12-section community template matching the official luxury community layouts.
- **Pre-populated Defaults**: All headings (H1, H2, H3), paragraphs, unit plans, and milestone tables come pre-populated with authentic website content, allowing the administrator to modify text easily rather than starting from scratch.

### 4. Summernote WYSIWYG Editor Integration
- **Asset Location**: Self-contained locally in `public/vendor/summernote/` (`summernote-lite.min.css`, `summernote-lite.min.js`, `jquery-3.7.1.min.js`, and `font/summernote.woff2|woff|ttf`) with CDN fallback.
- **Supported Formatting**:
  - Headings: H1, H2, H3, H4, Paragraph (`<p>`), Blockquote.
  - Styling: Bold, Italic, Underline, Strikethrough, Color picker, Clear formatting.
  - Content: Ordered lists, Unordered lists, Tables, Links, and Media.
- **Frontend Sync**:
  - All rich content entered via Summernote is stored in MySQL as sanitized HTML.
  - Frontend Blade templates render this content using unescaped Blade tags: `{!! page_section($section, $field) !!}` ensuring all visual formatting and hyperlinks render seamlessly.
  - Dynamic page catch-all route `/{slug}` automatically serves newly created pages through `resources/views/dynamic-page.blade.php`.

### 5. Frontend Blade Integration & Global Helpers
Seamlessly renders dynamic page content from MySQL with zero-downtime fallbacks:
- `page_data(?string $slug = null)`: Fetches the cached `Page` model with eager-loaded `sections`.
- `page_section(string $sectionKey, string $fieldKey, $default = null, ?string $pageSlug = null)`: Retrieves a specific field value within a page's section, falling back to `$default` if not set or inactive.
- `navbar_pages()`: Fetches all published pages marked for navbar inclusion sorted by `navbar_order`.
- Dynamic SEO metadata automatically injected into `layouts/app.blade.php`: `<title>`, `<meta name="description">`, `<meta name="keywords">`, `<meta property="og:title">`, `<meta property="og:description">`.

### 6. Hero Section SEO, Dynamic Image Alt Text & H1 Heading Architecture
- **CMS Editor Field (`/admin/pages/{id}/edit?tab=hero`)**:
  - Located directly alongside the **Hero Background Image (Change Photo / Upload)** module.
  - Form input: `sections[hero][bg_image_alt]` allows administrators to configure custom, SEO-descriptive alternative text for any page's hero image.
  - Persisted in MySQL JSON column `page_sections.content` (`bg_image_alt` and synced to `image_alt`).
- **Dynamic Frontend Image Alt Rendering**:
  - Evaluated on every page via:
    ```blade
    <img src="{{ $heroBg }}" alt="{{ page_section('hero', 'bg_image_alt', page_section('hero', 'image_alt', 'Default Alt Text', $pageSlug), $pageSlug) }}" class="slideImage">
    ```
  - Replaces all hardcoded alt tags across all templates (`partials/hero.blade.php`, `dynamic-page.blade.php`, and all 10 community page templates: `al-naseem-villas`, `bashayer-residences`, `bashayer-villas`, `hudayriyat-golf-estates`, `masyaf-plots`, `nawayef-east-hills`, `nawayef-park-views`, `nawayef-village`, `wadeem-gardens`, `wadeem-plots`).
  - When an admin saves changes in the CMS, page cache is invalidated automatically and the new alt text appears in the frontend HTML without delay.
- **Strict H1 Heading SEO Enforcement**:
  - Across all hero templates without exception, the hero main heading is strictly rendered within a single primary `<h1 class="...">` tag per page for optimal search engine crawlability and index ranking.

### 7. Table of Contents (TOC) Dynamic Synchronization & H2 Auto-Scroll Targeting
- **Automatic ID Injection on CMS Save**:
  When an administrator saves article content via the unified Summernote editor (`sections[content][html]`), `PageController@ensureHeadingIds` automatically parses all `<h2>` tags. Any heading lacking an `id` attribute is automatically assigned a clean, unique slug ID based on its text (e.g. `id="about-the-developers"`).
- **Client-Side Live Heading Discovery & Dynamic TOC Sync**:
  On page load, the frontend (`partials/article.blade.php`) discovers all `<h2>` headings inside `.saimaContentCol`, ensures unique IDs are set, and dynamically synchronizes the Table of Contents list. Any newly added, renamed, or reordered heading from the CMS appears immediately in the TOC list.
- **Smooth Auto-Scroll with Fixed Navbar Offset**:
  Clicking any TOC list item (or direct URL hash navigation like `/wadeem-gardens#about-the-developers`) triggers a smooth animated scroll with a 95px fixed navbar offset so that headings are never concealed behind the sticky header.
- **Scroll Spy**:
  Dynamically tracks the user's scroll position and highlights the corresponding TOC list link in `#856d52` luxury bronze.
- **Database Schema**:
  Added `body` column (`longText`, nullable) to `pages` table via migration `2026_10_22_125119_add_body_to_pages_table.php` to mirror rich HTML content alongside `page_sections.content`.

---

## 🌟 Key Architecture & Features

> **Audit Logs & Activity History (`owen-it/laravel-auditing`) (2026-11-11)**:
> - Package `owen-it/laravel-auditing` install kiya gaya hai aur migration `2026_11_11_091053_create_audits_table.php` ke zariye nayi `audits` table create ki gayi hai.
> - Models (`Page`, `Project`, `City`, `Community`, `Amenity`, `Blog`, `SiteSetting`, `PageSection`, `User`) par auditing implement ki gayi hai taake har CRUD action (Created, Updated, Deleted) automatically log ho sake.
> - Admin panel ke sidebar mein SITE SETTINGS ke andar **Audit Logs** (`/admin/audits`) add kiya gaya hai jismein stats cards, event/model/date filters, search, aur interactive Old vs New values comparison modal maujood hai.
>
> **Old Clone Communities Cleanup (2026-11-11)**: Purani clone website ke tamam 10 static Abu Dhabi/Hudayriyat community blade files (`resources/views/communities/`) delete kar diye gaye hain. `Page::projectSlugs()` ko dynamic banaya gaya hai jo ab sirf real active projects return karta hai. Blog sidebar aur communities partial se old hardcoded Abu Dhabi links hata kar dynamic database projects laga diye gaye hain.
>
> **Footer Logo**: `resources/views/partials/footer.blade.php` ab brand text ("Saima") ki jagah navbar wala `logo_saima.png` image dikhata hai. Koi DB/migration change nahi.

### 1. Database Integration (MySQL)
- **Database Name**: `hudayriyat` (configured in `.env` via phpMyAdmin / XAMPP).
- **Leads Table (`leads`)**:
  - `id`: Primary key
  - `name`: Lead full name
  - `phone`: Contact phone number with detected country dial code
  - `email`: Lead email address
  - `comment`: Client requirement, preferred units, or comments
  - `project`: Specific community or form origin (e.g. *Hudayriyat Island - Sidebar Appointment*)
  - `ip_address`: Visitor IP address
  - `country`: Visitor ISO country code
  - `status`: Lead status (default: `new`)
  - `created_at` & `updated_at`: Automated timestamps

### 2. Frontend UI Replication (100% Identical to Next.js)
- **Color Scheme & Luxury Aesthetic**: Strictly preserved gold/charcoal theme (`#856d52` gold primary, `#1a1a1a` dark charcoal, `#f8f9fa` light bg, `#e9ecef` borders).
- **Typography (`theleadmarketing.com` standard / Image 2)**:
  - **H2 Headings**: 30px (`1.85rem`), 700 bold, line-height 1.35.
  - **H3 Headings**: 24px (`1.5rem`), 700 bold, line-height 1.4.
  - **Body Text (`p`)**: 17.5px (`1.1rem`), line-height 1.75, Open Sans font family.
- **Header**:
  - Sticky glassmorphic bar on scroll.
  - Desktop navigation with interactive *PROJECTS* dropdown (all 10 communities).
  - *LIST YOUR PROPERTY* button triggering animated modal.
  - Mobile slide-out drawer with backdrop.
- **Hero Section**:
  - Background carousel with cinematic **Ken Burns zoom effect** (5-second cross-fade).
  - Quick callback lead capture form connected to `/api/leads`.
- **Project Highlights**:
  - 6 luxury metric badges with custom SVG icons (Developer: Modon Properties, Launch Price: AED 4.3M, Handover: Q3 2030, Property Type: Villas & Apartments, Payment Plan: Flexible, Location: Hudayriyat Island).
- **10 Featured Communities**:
  - Wadeem Gardens, Hudayriyat Golf Estates, Bashayer Residences, Nawayef East Hills, Bashayer Villas, Al Naseem Villas, Masyaf Plots, Nawayef Village, Wadeem Plots, Nawayef Park Views.
  - High-res images, pricing badges, handover milestones, and explore buttons.
- **2-Column Article Layout**:
  - **Interactive Table of Contents (TOC)**:
    - Collapsible toggle control (*Hide* / *Show*).
    - Hierarchical nested links for all major H2 and H3 headings.
    - Smooth scrolling with offset compensation (`scroll-margin-top: 100px`).
    - Real-time scroll spy highlighting current reading section.
  - **Complete Editorial Coverage**:
    - About Developers (Modon Properties), Location, Location Connectivity Map (`TOC1.png`).
    - Master Plan, Floor Plans (`TOC2.png` – `TOC7.png`), Payment Plans (`TOC8.png` – `TOC13.png`).
    - Milestone Financing Plan, Communities Summary Grid, and World-Class Facilities.
- **Sticky Sidebar Appointment Form**:
  - Aligned neatly near the right edge.
  - Dynamic country flag & dial code dropdown (`+971`, `+92`, `+91`, `+966`, `+44`, `+1`, etc.).
  - AJAX lead submission storing directly in MySQL `hudayriyat` database with immediate success checkmark.
  - **Latest Projects** card list highlighting top 6 communities with thumbnail images and direct links.
- **Interactive FAQ Accordion**:
  - 8 real estate investment questions with smooth expand/collapse.
- **Contact & Callback Section**:
  - Full-width background image with gradient overlay.
  - Consultation inquiry form storing into database.
- **Floating Scroll-To-Top**:
  - Circular gold button that fades in when scrolling past 300px.
- **"List Your Property" Modal**:
  - Accessible from the header and mobile menu with instant submission.

---

## 🛠️ Tech Stack

- **Backend**: Laravel 12 (PHP 8.2)
- **Database**: MySQL (`hudayriyat`) via Eloquent ORM
- **Frontend**: Blade Templating Engine + Vanilla CSS (`public/css/hudayriyat.css`)
- **Assets**: 560+ optimized images and SVG logos located in `public/`

---

## 🚀 How to Run

1. **Start Apache & MySQL** in XAMPP.
2. In terminal, navigate to the `backend` folder:
   ```bash
   cd backend
   ```
3. Run migrations (already executed):
   ```bash
   php artisan migrate
   ```
4. Start the Laravel development server:
   ```bash
   php artisan serve --port=8000
   ```
5. Open your browser and visit:
   ```
   http://127.0.0.1:8000
   ```

## 🔄 Update Log: 100% Frontend Parity & Phone Flag Selector Match (Port 3000 & 8000)

- **Top Navigation Bar Right Alignment**:
  - Ensured `.headerContainer` has `display: flex; justify-content: space-between; align-items: center;`.
  - Grouped all navigation items (`HOME`, `PROJECTS ▾`, `FAQ`, `CONTACT US`, and `LIST YOUR PROPERTY` button) inside `.nav` (`margin-left: auto !important`) and `<ul class="navList">` with `gap: 26px`.
  - Resolved previous centering issue on Laravel (Port 8000), making the top bar 100% identical to Next.js (Port 3000).

- **Phone Input Flag Selector & Pre-fill**:
  - Implemented the exact `react-international-phone` layout across both the Hero Callback form and Sidebar Appointment form.
  - Features real, crisp SVG country flags (UAE `+971`, Pakistan `+92`, Saudi Arabia `+966`, India `+91`, Qatar `+974`, Kuwait `+965`, Oman `+968`, Bahrain `+973`, UK `+44`, USA `+1`).
  - Pre-fills `+971 ` in the phone input with seamless country change upon dropdown selection.
  - Fixes Windows Chrome/Edge emoji rendering bug where country flags were failing to render.

- **Typography & Layout Synchronized**:
  - **Font Family**: Unified to `'Open Sans', sans-serif` across headings, body paragraphs, and forms.
  - **H2 Headings**: Set to 28px - 32px (30px in article), font-weight 700.
  - **H3 Headings**: Set to 22px - 25px (24px in article), font-weight 700.
  - **Body Paragraphs**: Set to 17.5px with 1.75 line-height and `#4a4a4a` color.
  - **Sidebar Form**: Removed duplicate `<label>` tag in article sidebar form; matched 42px height and styling to `SidebarAppointmentForm.tsx`.

### 🎯 Parity Update: Hero Phone Input & Below-Hero Sections Complete Match
- **Hero Phone Input (Image 1 vs Image 2 Fix)**:
  - Redesigned phone input into a unified single-row container (`.phoneUnifiedContainer`) with 48px height, rounded corners, and soft grey background.
  - Left side contains the UAE SVG flag with dropdown caret arrow and vertical divider line `|`.
  - Right side contains `+971 ` prefilled input field, perfectly aligned with `Full Name` and `E-mail` inputs.
- **Highlights Badges (Image 3 vs Image 4 Fix)**:
  - Replaced unstyled vertical list with the 6 floating highlight cards in a 6-column grid (`highlightsGrid`).
  - Added brown accent circle behind each SVG icon and two-line typography (`highlightLabel` and `highlightValue`).
- **Projects Showcase (Image 3 vs Image 4 Fix)**:
  - Converted section header to `--- Projects ---` with brown accent lines.
  - Implemented 4-column `.cardCustom` grid featuring dark gradient bottom overlay, `MÖDON` badge, sparkle action button, and launch price / delivery date badges.
- **FAQ & Contact Sections**:
  - Synchronized accordion animations, 8 full FAQs, and VIP Consultation callback form with Next.js implementation.

### 🚀 Additional Parity Fixes (Mobile Drawer, Sticky Navbar & Centered Cards)
1. **Mobile Drawer Navigation (Image 1 vs Image 2)**:
   - Replaced full-width grey button with clean, sharp SVG close cross `✕` on the top-right.
   - Removed logo inside drawer and redundant link dumps; aligned exactly to Port 3000 (`HOME`, `PROJECTS ⌄` with accordion dropdown, `FAQ`, `CONTACT US`, and `LIST YOUR PROPERTY` button).
2. **Sticky Navbar on Scroll (Image 3)**:
   - Implemented fixed sticky header with `backdrop-filter: blur(10px)` and slide-down transition upon scrolling past 40px.
3. **Centered 9th & 10th Cards (Image 4 vs Image 5)**:
   - Applied `.centeredRowStart` (`grid-column: 2 / 3 !important;`) on `Wadeem Plots`, positioning Cards 9 and 10 in columns 2 and 3 of the 4-column grid with empty side columns, matching Port 3000 perfectly.

### 🎯 Parity Update: Sidebar Appointment Form & Missing Image Fix
1. **Nawayef Park Views Image Fix**:
   - Corrected image file reference from `nawayef-park.jpg` to `nawayef-park-views.jpg` in `resources/views/partials/communities.blade.php`.
   - Card 10 now displays the full project render identically to Port 3000 instead of a broken black box.
2. **Sidebar Appointment Form Height & Proportions**:
   - Resolved CSS conflict where ContactSection `.formCard` padding (38px 34px) was overriding the sidebar form card.
   - Reduced padding to 20px 18px and input gap to 12px, making the form clean, compact, and proportional to Table of Contents.
3. **Phone Input 1-Row Alignment (Flag + Input)**:
   - Replaced unstyled block container with unified `.phoneUnifiedContainer` (38px height).
   - Flag, dropdown caret arrow, vertical separator, and `+971 ` input field are now strictly locked in one horizontal row matching Port 3000.
4. **Button & Script Polish**:
   - Replaced text with `SUBMIT →` and added animated processing states on appointment booking.


### 🎯 Parity Update: Full Dedicated Contact Us Page (/contact-us)
1. **Dedicated View & Routing**:
   - Created `resources/views/contact-us.blade.php` matching Next.js `src/app/contact-us/ContactUsClient.tsx` 100% identically.
   - Added `Route::get('/contact-us')` and alias `Route::get('/contact')` redirect in `routes/web.php`.
2. **Top Navigation & Drawer**:
   - Updated navbar and mobile drawer `CONTACT US` links to point to `/contact-us` instead of `#contact`.
3. **Hero Banner & 4 Contact Channels**:
   - Darkened hero banner on `slide-1.jpg` with pill badge `HUDAYRIYAT ISLAND • ABU DHABI`, title `Contact Us`, and subtitle.
   - 4 Direct Channels Cards grid: WhatsApp Us, Direct Call (+971 50 000 0000), Email Inquiries (info@hudayriyat-island.ae), and Location (Hudayriyat Island, Abu Dhabi, UAE).
4. **2-Column Overview & Get in Touch Form**:
   - Left column featuring emerging properties overview, 3 paragraphs, and 3 feature cards (Exclusive Island Living, 100% Freehold Ownership, Prompt Advisory).
   - Right column with `Get in Touch` card, unified 1-row UAE flag phone input, and submit handling to `/api/leads`.


### 🎯 Parity Update: Navbar Color & Global Footer Parity
1. **Navbar Color & Translucency**:
   - Synchronized `.sticky-header` background to `rgba(25, 25, 25, 0.45)` with `backdrop-filter: blur(5px)` (matching Next.js `globals.css:225` and Screenshot 1 & 2).
   - Removed opaque/overly-dark background so it delivers the exact frosted glass taupe effect when scrolled over white or image backgrounds.
2. **Footer Component (100% Port 3000 Parity)**:
   - Replaced unstyled footer with exact 4-column layout (`#000000` pitch black background, white serif logo with brightness invert filter).
   - Col 1: Logo & advisory description.
   - Col 2: About Hudayriyat (Home, Projects, About Us, Contact Us, Privacy Policy, Terms & Condition, Disclaimer).
   - Col 3: Properties (10 communities from Wadeem Gardens to Nawayef Park Views).
   - Col 4: Connect With Us (Email icon + Contact Us link).
   - Bottom bar with complete legal disclaimer text and copyright `© 2026 hudayriyat-island.ae All Rights Reserved.`


### 🎯 Parity Update: Full Dedicated About Us Page (/about-us)
1. **Dedicated View & Routing**:
   - Created `resources/views/about-us.blade.php` matching Next.js `src/app/about-us/AboutUsClient.tsx` 100% identically.
   - Added `Route::get('/about-us')` and alias `Route::get('/about')` redirect in `routes/web.php`.
2. **Hero Header**:
   - Dark gradient hero banner with golden badge `HUDAYRIYAT ISLAND • ABU DHABI`, title `About Us`, and subtitle.
3. **Intro & Featured Image**:
   - Lead paragraph and subtext paired with 480px luxury waterfront architecture container (`form image.jpg`).
4. **Core Services, Pillars & Why Choose Us**:
   - 3 Core Services cards (Property Advisory, Property Listings, Market Insights).
   - 3 Pillars cards (Mission, Vision, Values).
   - 3 Why Choose Us cards (Local Market Knowledge, Client-First Approach, Simple Property Search).
5. **Looking for Your Dream Property Form Section**:
   - Journey benefits checklist paired with inquiry form card (Full Name, Email, UAE Flag Phone Input 🇦🇪, SUBMIT NOW button).


### 🎯 Parity Update: List Your Property Navbar Modal (100% Port 3000 Parity)
1. **Interactive Trigger**:
   - Wired navbar and mobile drawer `LIST YOUR PROPERTY` buttons with `.open-list-modal` to open the modal smoothly with `fadeIn` background and `slideUp` card animation.
   - Added Escape key and outside backdrop click to dismiss.
2. **Form Layout & Fields**:
   - Header: `LIST YOUR PROPERTY` (20px bold uppercase) with sharp close `✕` icon.
   - Row 1: Name * (`Your Name`) & Email * (`your.email@example.com`).
   - Row 2: Phone * with unified UAE Flag 🇦🇪 + dropdown caret + `+971 ` & Property Type * dropdown (Villa, Apartment, Penthouse, Compound, Plot, Showroom).
   - Row 3: Attachment (Optional) file uploader with note `Upload floor plans, photos, or deed documents (Max 10MB).`
   - Row 4: Comments / Specifications textarea (`Tell us about the property (bedrooms, plot size, community, expected price)...`).
   - Row 5: `SUBMIT PROPERTY` button in brand accent brown (`#856d52`).


### 🎯 Parity Update: List Your Property Click Fix & Reliable Modal Trigger
1. **Click Bug Resolution**:
   - Fixed redundant syntax block in `layouts/app.blade.php` that caused script parsing stoppage.
   - Added `window.openListModal()` and `window.closeListModal()` directly to global window scope.
   - Attached `onclick="window.openListModal ? window.openListModal() : null"` directly on the navbar and mobile drawer `LIST YOUR PROPERTY` buttons.
2. **Modal Form Parity (100% Match to Screenshot)**:
   - 2-column grid layout with `Name *`, `Email *`, `Phone *` (UAE Flag 🇦🇪 + unified input), `Property Type *` dropdown.
   - Full-width `Attachment (Optional)` file chooser with note, `Comments / Specifications` textarea, and `SUBMIT PROPERTY` brown button.


### 🎯 Parity Update: Full Live Home Page & Layout Replication from Port 3000 (`hudayriayt_new`)
1. **Removed TOC & Book an Appointment Sidebar from Home Page**:
   - As per project specifications, removed the dynamic Table of Contents (TOC) and sticky "Book an Appointment" sidebar from the Home Page.
2. **Added Exact Matching Next.js Sections**:
   - **Island Overview (`partials.island-overview`)**: Comprehensive editorial rundown covering all 14 communities & plot developments (Wadeem Gardens, Hudayriyat Golf Estates, Nawayef East Hills, Nawayef Village, Nawayef Park Views, Al Naseem Villas, Bashayer, Bashayer Residences, Wadeem plots, Masyaf plots, Sunset Cliff, Quays, Sahl, and Hills).
   - **Investment Potential & Flexible Financing (`partials.investment-potential`)**: 2-column section with Key Investment Highlights (7 bullet items with circular check icons, "Contact a Property Investment Consultant" button) and Flexible Financing Options Card (5 financing highlights with green/gold check icons, "Contact a Mortgage Specialist" button).
   - **Hudayriyat Island Overview and Location (`partials.overview-location`)**: 2-column layout with detailed overview text and high-res overview image (`hudayriyat-overview.jpg`), accompanied by a 4-item location connectivity bar (Al Bateen, Saadiyat Island, Abu Dhabi City Centre, Qasr Al Watan & Emirates Palace).
   - **Accepted Payment Methods (`partials.payment-methods`)**: 4-card grid showcasing accepted payment avenues (Card, Cheque, Cash, Bitcoin) with crisp iconography.
3. **Synchronized FAQs & Contact Section**:
   - Expanded FAQ section to all 10 official questions and answers with smooth interactive accordion toggle matching `FaqAccordion.tsx`.
   - Updated Contact Section (`partials.contact`) with `LET'S CONNECT` pre-title, `Invest in Your Future` headline, background image (`form image.jpg`), and instant VIP callback request form.
4. **Unified Typography to Ubuntu**:
   - Standardized primary font-family to Google Fonts `Ubuntu` across all layouts, components, and stylesheets (`hudayriyat.css`).
   - Matched font sizes, weights, and clamp calculations strictly to `hudayriayt_new`'s `globals.css` and CSS modules.
5. **JSON-LD Schema & Laravel 12 `@context` Resolution**:
   - Resolved `ParseError: syntax error, unexpected end of file, expecting "elseif" or "else" or "endif"` caused by Laravel 12 compiling the JSON-LD `@context` key as a Blade directive (`context()->has(...)`).
   - Encoded the schema via `{!! json_encode([...], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}` in `layouts/app.blade.php`, allowing the view to compile and render seamlessly.


### 🎯 Parity Update: Saima Mangrove Residences Editorial Section Across All Project Pages
1. **Interactive Table of Contents (TOC)**:
   - Designed 100% faithful to `theleadmarketing.com` screenshots with crisp border (`#dcdcdc`), header toggle button `[::=]`, and nested numbered list (1–10 with 5.1–5.6 and 7.1–7.6 sub-items).
   - Real-time scroll spy highlighting active section with red `#d9232d` accent and smooth scroll offset.
2. **Editorial Content & Strict Theme Preservation**:
   - Incorporated the exact user-provided text for Saima Mangrove Residences, About the Developers (with Lead Marketing link), NOC, Location, Location Map, Floor Plans (Types A, A-1, A-2, A-3, B, C), Master Plan, Payment Plans (Types A, A-1, A-2, A-3, B, C), Installation Plan, Apartments for Sale, and Facilities & Amenities.
   - Headings styled in bold `#d9232d` red (H2: 26px, H3: 20px) on clean Open Sans / sans-serif typography.
3. **TOC Public Images Integration (`TOC1.png` – `TOC13.png`)**:
   - Integrated all 13 images located in `backend/public/`:
     - `TOC1.png`: Location Connectivity Map
     - `TOC2.png`: 3-Room Apartments – Type C
     - `TOC3.png`: 4-Room Apartments – Type B
     - `TOC4.png`: 5-Room Apartment – Type A
     - `TOC5.png`: 5-Room Apartments – Type A-1
     - `TOC6.png`: 5-Room Apartments – Type A-2
     - `TOC7.png`: 5-Room Apartments – Type A-3
     - `TOC8.png`: Payment Plan Type A – 5-room Apartment
     - `TOC9.png`: Payment Plan Type A-1 – 5 Room Apartment
     - `TOC10.png`: Payment Plan Type A-2 – 5 Room Apartment
     - `TOC11.png`: Payment Plan Type A-3 – 5 Rooms Apartment
     - `TOC12.png`: Payment Plan Type B – 4 Rooms Apartment
     - `TOC13.png`: Payment Plan Type C – 3 Rooms Apartment
4. **Sticky Right Sidebar with Book An Appointment & Latest Projects**:
   - **BOOK AN APPOINTMENT**: Card with centered bold title, inputs (`Name`, `Phone`, `Email`), textarea (`Leave a comment here`), and red `#d9232d` `SUBMIT` button with AJAX submission to `/api/leads` and instant success feedback.
   - **Latest Projects**: Real estate project showcase featuring Lorévia Collection, Samana South Haven 2, Lily Tower, Avana Residences, and Elan Tower with preview thumbnails.
5. **Universal Deployment Across All 10 Community Pages**:
   - Integrated `@include('partials.article')` across:
     - `/wadeem-gardens`
     - `/hudayriyat-golf-estates`
     - `/bashayer-villas`
     - `/bashayer-residences`
     - `/al-naseem-villas`
     - `/nawayef-east-hills`
     - `/masyaf-plots`
     - `/nawayef-village`
     - `/wadeem-plots`
     - `/nawayef-park-views`

### 🎯 Parity Update: TOC Collapse by Default, Black Hudayriyat Theme & Professional LP1-LP5 Projects
1. **TOC Collapsed by Default**:
   - Table of Contents (`#saimaTocContent`) is closed/collapsed by default (`display: none`).
   - Integrated a clean toggle button with "Show" / "Hide" text and animated chevron indicator that opens/closes the TOC on demand.
2. **Black Theme (Hudayriyat Parity)**:
   - TOC links styled in clean black `#1a1a1a` (no red underlines or default red links).
   - Article headings (`H2` & `H3`) unified to `#1a1a1a` (matching Hudayriyat Island's signature aesthetic).
3. **Streamlined TOC Targets (H2 Only)**:
   - Removed cluttered sub-items (5.1–5.6, 7.1–7.6) from the TOC list.
   - Now targets strictly the 10 main `<h2>` sections for clean, readable navigation.
4. **Latest Projects Cards with `LP1.png` – `LP5.png`**:
   - Integrated the 5 images saved in `public/` (`LP1.png` through `LP5.png`).
   - Upgraded card design with larger thumbnail height (80px height x 95px width), crisp rounded borders (`border-radius: 6px`), subtle elevation shadow, and hover animations.

### 🎯 Parity Update: Universal Sticky Navbar on Scroll Across All Pages
1. **Dynamic Scroll Listener**:
   - Attached an active window scroll listener that monitors user scroll position (`window.scrollY > 40`).
   - Dynamically adds the `.sticky-header` class when scrolling down, and removes it smoothly when back at the top.
2. **Glassmorphic Fixed Navbar Styling**:
   - Defined `.sticky-header` across `hudayriyat.css` and `communities/global.css`:
     - `position: fixed !important; top: 0; left: 0; right: 0; width: 100%;`
     - Translucent dark glass backdrop (`background: rgba(20, 20, 20, 0.75)` with `backdrop-filter: blur(8px)`).
     - Elevation shadow (`box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15)`), compact padding (`12px 0`), and `z-index: 1000`.
3. **Universal Coverage**:
   - Operates seamlessly across the Home page, legal pages, About/Contact pages, and all 10 community project pages.

### 🎯 Parity Update: Typography Enhancement & Signature #856d52 Theme Color Integration
1. **Typography & Readability Enlargement (Exact Image 2 Parity)**:
   - Standardized font-family to Google Fonts `'Open Sans'` across the entire article, TOC, and sidebar components.
   - Increased body paragraph font size to **19.5px** with generous **1.88 line-height** and **24px bottom margin**, achieving 100% visual parity with the spacious editorial layout in reference Image 2.
   - **H2 Headings**: Scaled up to **34px** bold in `#856d52` with negative letter-spacing for prominent visibility.
   - **H3 Headings**: Scaled up to **26px** bold in `#856d52`.
   - **TOC Navigation**: Title increased to **22px** and list items to **18px** for easy readability.
   - **Form Fields & Button**: Sized up input fields to **16px** with generous padding, and SUBMIT button to **16px** bold.
2. **Signature Color Matching (Image 3 Parity)**:
   - Extracted the exact gold/brown theme color from the `DOWNLOAD BROCHURE` button in Image 3: **`#856d52`** (hover: `#725c43`).
   - **H2 Headings**: Colored in bold `#856d52` with 34px size.
   - **H3 Headings**: Colored in `#856d52` with 26px size.
   - **BOOK AN APPOINTMENT SUBMIT Button**: Colored in `#856d52` with `#725c43` hover state, 16px bold uppercase font, and subtle golden box shadow (`0 4px 12px rgba(133, 109, 82, 0.25)`).
   - **In-text & TOC Active Links**: Accented with `#856d52`.

### 🎯 Parity Update: Project Gallery Image Alignment & Responsive Centering Fix (100% Port 3000 Parity)
1. **Resolved Gallery Right-Edge Cutoff & Giant Image Sizing**:
   - Diagnosed root causes:
     - Broad CSS selector `div[class*="Gallery"]` was erroneously matching gallery child elements (`viewport`, `track`, and `card`), forcing `width: 100% !important` and stretching a single card across the entire container width.
     - Scope narrowed strictly to `section[id="gallery"]` so that individual cards maintain their exact designed dimensions (`cardWidth x cardHeight`).
   - **Exact Next.js Port 3000 Parity Implementation (`initStandardGallery`)**:
     - Desktop (`viewportWidth >= 992px`): Exactly **2 cards** centered side-by-side (`itemsInCenter = 2`), card width `Math.min(600, Math.max(300, (viewportWidth - gap - 80) / 2))`, 24px gap, and aspect ratio 600:400 (`cardHeight = cardWidth * 400 / 600`).
     - Card 3 peeks into view on the right edge, matching Port 3000 identically.
     - Mobile/Tablet (`viewportWidth < 992px`): Exactly 1 card centered with 16px gap and side margins.
     - **Full Next/Prev & Dot Navigation**:
       - Forward button (`>`) smoothly slides the carousel to the next card index.
       - Backward button (`<`) smoothly slides to the previous card index.
       - Pagination dots activate dynamically and navigate directly on click.
       - Category filter tabs ("ALL", "Exterior") dynamically filter slides and reset to slide 0.
       - Fullscreen Lightbox opens with high-resolution view on card click.
2. **Universal Gallery Fallback Styles in `global.css`**:
   - Container styles for `.carouselContainer`, `.viewport`, `.track`, `.card`, and `img` guaranteeing 18px rounded corners and smooth hover zoom effects.
3. **Article Images Enhancement (`TOC1.png` - `TOC13.png`)**:
   - Centered all floor plan and location map images in `partials/article.blade.php` with `margin: 28px auto 32px auto;`, `border-radius: 8px;`, subtle shadow, and clean light border.
4. **Underscore URL Route Aliases**:
   - Added support in `backend/routes/web.php` for underscore URLs (e.g. `/wadeem_gardens` -> `/wadeem-gardens`, etc.) ensuring both hyphenated and underscore URLs resolve seamlessly.

### 🎯 Parity Update: Wadeem Amenities Section Restoration (100% Port 3000 Parity)
1. **Isolated Gallery Rules from Amenities Cards**:
   - Resolved visual distortion where a broad gallery `.card` selector had unintentionally applied `background: #f4ede5`, `overflow: hidden`, and stretched the 28x28 icon images across the entire card background.
   - Strictly scoped all gallery selectors under `section[id="gallery"]`.
2. **Restored Pristine Port 3000 Amenities Design**:
   - Card container: Clean pure white background (`background: #ffffff`), subtle border (`1px solid #e5e7eb`), soft shadow (`box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02)`), and `border-radius: 8px`.
   - Icon box: 48x48px container in signature brand brown (`#856d52`) with centered 28x28px white icon (`filter: brightness(0) invert(1)`).
   - Typography: 16.5px bold title (`#222222`) aligned beside the icon.
   - Responsive grid: 4 columns on desktop, 2 columns on tablet, 1 column on mobile.

### 🎯 Feature Update: Dedicated "Content" Section Tab & Unified Summernote Editor Across All Pages
1. **Unified Single Summernote Editor**:
   - Replaced fragmented heading/paragraph inputs and separate repeater fields with a single, comprehensive Summernote WYSIWYG editor under the **"Content"** tab (`section_key = 'content'`, `section_name = 'Content'`).
   - Every page in the CMS now has a dedicated **"Content"** section.
2. **Pre-filled Website Content**:
   - **Home (`/`)**: Pre-filled with the complete residential communities article (`<h2>Hudayriyat Island Projects: The Residential Communities</h2>`, intro narrative, and all 10 residential communities with `<h3>` and paragraphs).
   - **Community Pages** (`wadeem-gardens`, `hudayriyat-golf-estates`, `bashayer-residences`, etc.): Pre-filled with the complete editorial article (intro, `<h2>` sections for Developers, NOC, Location, Location Map image `TOC1.png`, Floor Plans images `TOC2.png`-`TOC7.png`, Master Plan, Payment Plans images `TOC8.png`-`TOC13.png`, Installation Plan, Apartments for Sale, and Facilities & Amenities).
   - **About Us, Contact Us & Legal Pages**: Pre-filled with their respective body text and structured headings.
3. **Typography & Image Integration**:
   - Summernote style dropdown provides native support for Heading 1 (`h1`), Heading 2 (`h2`), Heading 3 (`h3`), and Normal (`p`).
   - Images are rendered directly inside the editor (`<img>`) with responsive sizing, border radius, and shadow.
4. **Live Frontend Rendering**:
   - Updates made in the Summernote editor save to the database and immediately reflect on the live website.
   - `partials/island-overview.blade.php` and `partials/article.blade.php` dynamically render the content HTML if configured.
5. **Seeder & Database Synchronization**:
   - Updated `database/seeders/PageSeeder.php` and `PageBlueprintService.php` to include the `content` section for all pages by default.


### 🎯 Frontend Fix: Navbar "PROJECTS" Dropdown Menu
1. **Root Cause**:
   - Community pages (`nawayef-village`, `masyaf-plots`, `wadeem-plots`) used `<ul class="ProjectHeader-module__jLMilW__dropdownMenu">`, which did not match `div[class*="dropdownMenu"]` in `global.css`.
   - As a result, the background defaulted to `#1f1b16` (dark) with `max-height: 420px; overflow-y: auto;` causing an unsightly native Windows OS scrollbar and low-contrast text.
2. **Resolution**:
   - Broadened selector in `public/css/communities/global.css` to `[class*="dropdownMenu"], [class*="DropdownMenu"], .dropdownMenu` with pure white background (`#ffffff`), soft shadow (`box-shadow: 0 15px 35px rgba(0,0,0,0.18)`), and elegant border.
   - Removed ugly native scrollbar by setting `max-height: none` and `overflow: visible` (with thin sleek scrollbars fallback).
   - High-contrast text `#2b2b2b` with gold `#856d52` luxury hover and active styling.
   - Updated `public/css/communities/nawayef-village.css`, `masyaf-plots.css`, `wadeem-plots.css`, and injected head `<style>` in corresponding blade templates for instant, cache-resilient presentation.

### 🎯 Feature Update: "Add Page" Modal with Hero Section Component & Summernote Editor
1. **Renamed Action**:
   - Primary action button and modal header renamed from "Create New Page" / "Create New Website Page" to **"Add Page"**.
2. **Simplified Section Selection**:
   - Replaced previous Global vs. Custom radio choices with an intuitive **"Available Sections"** component card.
3. **Hero Section Component**:
   - Features a visual thumbnail previewing `public/hero.png`.
   - **Click-to-Add**: Clicking the card adds the Hero section to the page (`✓ Added`).
   - **Click-to-Edit Drawer**: Clicking the added card or the "Edit Content" button expands a customization drawer.
   - **Pre-populated Fields**: Main Heading (H1), Subtitle/Tagline, Badge/Pretitle, and Background Image (`/hero.png`).
   - **Integrated Summernote Editor**: Includes an interactive WYSIWYG Summernote editor pre-populated with ready-to-edit HTML content.
4. **Backend Persistence**:
   - `PageController::store` accepts customized Hero fields and Summernote HTML, updating both the `hero` section and `content` section (`pages.body`).

---

### 💬 Fixed Floating WhatsApp Widget Across All Pages
- **Sitewide Floating Widget**: Added to `resources/views/layouts/app.blade.php` so it renders automatically across all public pages (Home, Community projects, About, Contact, Legal pages, etc.).
- **Fixed Positioning**: Anchored at `position: fixed; bottom: 25px; left: 25px; z-index: 99999;` so it remains completely locked in place when scrolling.
- **Design Elements (Matching Image 1)**:
  - Circular official WhatsApp green button (`#25D366`) with crisp white WhatsApp SVG icon.
  - Notification alert badge with red pill (`1`) in the top-right corner of the icon.
  - White callout pill text: `"Contact us for details"`.
  - Links directly to WhatsApp chat (`wa.me`) in a new tab.
  - Smooth hover scale and shadow transitions; optimized for mobile screens.

---

### 📩 Modular Add Page Builder: Contact & Callback Section Component
1. **New Available Section**:
   - Added **Contact Section** (`contact`) directly after the FAQ Section in the Add Page visual builder (`/admin/pages`).
   - Thumbnail preview uses `public/contact_section.png` (`asset('contact_section.png')`).
   - Available sections count badge updated to **7 Available** (`Hero`, `Project Highlights`, `About Community`, `Article & Booking`, `Project Cards`, `FAQ Section`, `Contact Section`).
2. **Visual Builder Workflow**:
   - Clicking "+ Click to Add" adds the large visual card into the upper selected sections builder layout with order badge, drag-and-drop handle, and remove button (`✕`).
   - Expandable drawer **"✎ Edit Content"** allows customizing:
     - Pre-Title (e.g. `LET'S CONNECT`)
     - Main Heading (e.g. `Invest in Your Future`)
     - Subtitle / Narrative
     - Form Top Label (`REQUEST`)
     - Form Main Title (`A CALL BACK`)
     - Submit Button text (`REQUEST NOW`)
     - Background image URL (`/images/form image.jpg`)
3. **Backend & Frontend Sync**:
   - `PageController@store` attaches the `contact` section to the page and persists custom fields.
   - Frontend `dynamic-page.blade.php` dynamically renders `partials.contact` right after FAQ (or according to administrator drag-and-drop order).

---

### 📝 UI Label Update: "Page Title" renamed to "Page Name"
- Updated the label from **"Page Title"** to **"Page Name"** in:
  - Page Editor General Configuration: `resources/views/admin/pages/edit.blade.php`
  - Add Page Modal: `resources/views/admin/pages/index.blade.php`
  - Dedicated Projects Add Modal: `resources/views/admin/pages/projects.blade.php`
- Strictly updated the display label text without modifying any underlying database schema, form field names, or business logic.

---

### 🏷️ Sold Out Card Badge Typography Enhancement (Bold Weight)
- Enhanced the **"Sold out"** badge text on community/project cards to be bolder and more prominent:
  - Updated `.soldOutBadge` in `public/css/hudayriyat.css` and `resources/views/partials/page-communities.blade.php`.
  - Increased `font-weight` from `700` to `800` and added `-webkit-text-stroke: 0.3px #dc2626;` for extra crisp boldness without altering badge dimensions or padding.

---

### ⚡ Auto Page Name Sync to Main Heading (H1)
- In the Page Builder (`/admin/pages` and `/admin/projects`), typing in the **Page Name** input automatically synchronizes directly to the **Main Heading (H1)** field in real time without any suffixes.

---

### 📄 Article & Booking Section: Dual Summernotes & Frontend Flow Update
1. **CMS Page Builder (`/admin/pages` & `/admin/projects`)**:
   - In the **Edit Article & Booking Content** drawer, removed all cluttered inputs (Main Heading, Intro Paragraphs simple textarea, old full content Summernote, and Appointment Form Header).
   - Replaced with **2 simple Summernote editors**:
     - **Short Content** (Summernote editor for top introductory summary, mapped to `article_intro`).
     - **Long Content** (Summernote editor for comprehensive details, headings, and images, mapped to `article_summernote` / `pages.body`).
2. **Frontend UI Rendering Order (`partials/article.blade.php` & `dynamic-page.blade.php`)**:
   - **Step 1 (Top)**: **Short Content** is displayed on the left column with the **Appointment Form** on the right side.
   - **Table of Contents (TOC)**: TOC box and heading are completely removed from the UI.
   - **Step 2 (Middle)**: **Project Cards** (`partials.page-communities`) are rendered directly below the short content & booking form.
   - **Step 3 (Bottom)**: **Long Content** is rendered cleanly below the Project Cards.

---

### 🛠️ Syntax Fix & Blade Template Balance (`partials/article.blade.php`)
- Resolved a 500 `ParseError: syntax error, unexpected token "endif"` encountered when loading dynamic project pages like `/wadeem-gardens`.
- Balanced unclosed `@if` and loop directives and eliminated an orphaned `@endif` directive in `resources/views/partials/article.blade.php`.
- Cleared compiled view cache with `php artisan view:clear`.

---

### 🎨 Page Builder Hero Section & Highlights Metric Selector Update
1. **Hero Section Drawer**:
   - Removed the Summernote editor (`heroSummernote` / `Hero Rich Content / Article`) from the Hero Section drawer in both `resources/views/admin/pages/index.blade.php` and `resources/views/admin/pages/projects.blade.php`.
   - Hero drawer now focuses strictly on background image, badge, main heading, and subtitle.
2. **Project Highlights Metric Dropdown & SVG Icons**:
   - Replaced emoji dropdown with predefined SVG icon metric selectors matching the clean modern UI design.
   - Removed the separate "Icon" select dropdown.
   - Integrated dropdown arrow directly beside the metric label/name input with interactive quick-selection menu (`Developer`, `Price`, `Handover Date`, `Property Type`, `Ownership`, `Bedrooms`, `Location`, `Plot Size`, `Down Payment`, `Featured Highlight`).
   - Automatically populates the correct SVG icon prefix and preserves backend compatibility.

---

### 📑 New Page Layout Polish: Sidebar Cleanup, Reduced Spacing & "Read more" Scroll Trigger
1. **Sidebar Form Only (Latest Projects Removed on New Pages)**:
   - On new dynamically created pages, the `Latest Projects` widget under the sidebar appointment form has been removed. The sidebar now cleanly contains only the **BOOK AN APPOINTMENT** form.
2. **Reduced Section Gap**:
   - Tightened vertical spacing between the Short Content / Form section and the **Featured Projects** section (`saimaArticleWrapper` bottom padding reduced, `saimaMainGrid` aligned to start to prevent stretching, and `communitiesSection` top padding reduced).
3. **"Read more" Smooth Scroll Link**:
   - Appended a blue "Read more ↓" link (`.saimaReadMoreBtn`) directly at the end of the Short Content text.
   - Clicking "Read more" smoothly scrolls down past the Featured Projects directly to the **Long Content** (`#pageLongContent`).
   - Long content remains fully rendered and visible in place below the project cards even without clicking the link.
4. **Scope Isolation**:
   - This enhanced flow strictly applies to newly created pages (`dynamic-page.blade.php`) while preserving the 10 original legacy community portfolio landing pages.

---

### 🛡️ Strict Separation Between Created Pages and Property Detail Pages
1. **Created Pages (`/admin/pages`)**:
   - CMS Drawer features the 2 Summernote editors: **Short Content** (`article_intro`) and **Long Content** (`article_summernote`).
   - Frontend layout renders the modern split pattern:
     - Left column: Short Content with blue **"Read more ↓"** smooth-scroll button.
     - Sidebar: Appointment Form only (no Latest Projects widget).
     - Middle: Project Cards grid (`page-communities`).
     - Bottom: Long Content section (`#pageLongContent`).
     - **Deduplication**: In `dynamic-page.blade.php`, trailing `communities` section is suppressed when already rendered by `content`, preventing the cards from repeating after long content.
2. **Property Pages (`/admin/projects` or `/admin/pages/projects`)**:
   - CMS Drawer preserves the classic fields: Main Heading (`article_title`), Simple Text Area (`article_intro`), Full WYSIWYG Content (`article_summernote`), and Appointment Header (`article_appt_title`).
   - Frontend layout remains **100% original**:
     - Left column: Collapsible **Table of Contents (TOC)** box (`#saimaToc`), intro paragraphs, and complete article content together in one column.
     - Sidebar: Appointment Form AND **Latest Projects** widget (`.saimaProjectsWidget`).
     - NO injected Project Cards in the middle of the article.
     - NO "Read more" scroll button and NO separate long content section below.



---

### ??? Dedicated Cities Management Module (/admin/cities)
- **Admin Sidebar Navigation**: Added Cities under Content in the sidebar (dmin.layouts.app) with the map-pin icon.
- **Top Sub-Navigation**: Seamless 3-way toggle between Pages, Projects, and Cities.
- **Minimalist Table Listing**: Displays exactly:
  - **#** (Number / Order)
  - **NAME** (City Name + /slug badge)
  - **STATUS** (Publish / Draft / Sold out dropdown pill with quick status update)
  - **ACTIONS** (View live /{slug}, Edit city, and Delete city)
- **+ Add City Creator Drawer**: Modeled identically to the + Add Property tabbed layout (.adm-edit-layout):
  - **Live URL Preview**: Top banner displaying Page URL: ... /<slug>.
  - **Real-Time Synchronisation**: Typing in **City Name** instantly computes and auto-populates the **Route Slug** and the **Hero Main Heading (H1)**.
  - **Exact 6 Section Pattern**:
    1. **General Settings**: City Name, Slug, Status, Navigation checkbox.
    2. **Hero**: Main Heading (H1, auto-synced), Subtitle, Background image, Badge.
    3. **TOC**: Article & Content section with Main Heading, Lead Intro, Body Summernote editor, and Appointment Title.
    4. **Project Card**: Section Heading, Subtitle, and interactive Property Card selector (pick which property cards appear in this city).
    5. **About Community**: Headline, City narrative/story, Video stream URL, and Poster image.
    6. **FAQ**: FAQ Section Title, Subtitle, and interactive Q&A accordion items with Add Question capability.
    7. **Contact Section**: CTA Heading, Subtitle, Phone, Email, and Button text.
    8. **SEO & Meta**: Meta Title, Description, and Keywords for search indexing.
  - **Clean**: No extraneous inputs (no queries, amenities, floor plans, or payment plan bloat).
  - **Sticky Bottom Action Bar**: Displays Creating City Page for: [City Name] with Cancel and Save City Page buttons.

---

### ?? Cities CMS: TOC Renamed to Content & Single Pre-filled Summernote
- **Tab Renamed**: In both Cities create (dmin/cities/index.blade.php) and edit (dmin/cities/edit.blade.php), renamed **TOC** tab to **Content** with the edit icon.
- **Single Visual WYSIWYG Editor**:
  - Removed separate Article Main Heading, Lead Paragraph / Intro, and Appointment / Sidebar Form Title inputs.
  - Replaced with a single full visual Summernote editor labeled **Page Article & Community Body (Headings, Paragraphs, Images)**.
  - Pre-filled by default with the complete rich content, headings (H2/H3), images, and community highlights matching the **Add Property** content tab.
  - Automatically initializes Summernote toolbar when the drawer opens or when switching to the Content tab.

---

### ?? Cities CMS: City Name & Route Slug Side-by-Side Grid Layout
- In General Settings of both Cities creation (dmin/cities/index.blade.php) and edit (dmin/cities/edit.blade.php), updated the layout so **City Name** and **Route / Slug** appear side-by-side in a responsive 2-column grid (display: grid; grid-template-columns: 1fr 1fr; gap: 16px;).

---

### ??? Cities CMS: Dual-Box Drag & Drop Project Card Selector (Image 2 Parity)
- Replaced the simple pill-chip selector in **Project Card** tab with the complete dual-box interactive drag & drop / click assignment system matching Image 2:
  - **Left Box (Available Property Cards)**: Displays all created property cards with drag handle (?), image thumbnail, title, price/location, and + Add button.
  - **Right Box (Selected Cards for This Page)**: Displays selected cards with ? Selected Cards for This Page count, Clear All button, and drag-and-drop dropzone with empty state placeholder (Drag Cards Here).
  - **Interaction**: Administrators can either drag and drop cards between 
  
  boxes or click + Add / ? Remove.
  - **Ordering & Persistence**: Synchronizes exact card IDs and reorder sequence directly into selected_project_ids[].

---

### 🚀 Hero Section Dynamic Badge & BOOK NOW Scroll Button
- **Dynamic Hero Badge ("Freehold for All Nationalities")**:
  - Removed static hardcoded `"Freehold for All Nationalities"` badge fallback across Homepage Hero (`partials/hero.blade.php`), Dynamic Page Hero (`partials/page-hero.blade.php`), and all 10 Community Blade Views (`resources/views/communities/*.blade.php`).
  - Badge is now 100% dynamic via CMS (`sections[hero][badge]`). If left empty, the badge tag does not render at all. If filled in the CMS, it renders dynamically with full styling.
- **Hero CTA Button ("BOOK NOW")**:
  - Replaced `"Download Brochure"` button in Hero sections across all pages with `"BOOK NOW"`.
  - Added the `"BOOK NOW"` CTA button to the **Homepage Hero** (`partials/hero.blade.php`) matching the property detail pages style and behavior.
  - Added smooth scroll handler on click targeting the on-page callback/inquiry form (`document.querySelector('...form...')?.scrollIntoView({behavior: 'smooth'})`).
- **Country Flag-Based Phone Validation**:
  - Implemented client-side HTML5 native phone validation (`setCustomValidity` and `reportValidity`) matching each country's exact phone length requirements (UAE: 9 digits, PK: 10 digits, SA: 9 digits, IN: 10 digits, etc.) without altering any DOM hierarchy or styles.

---

### 🏢 Dedicated Project Edit Route Retention (`/admin/projects/{id}/edit`)
- **Direct Route Rendering**: Clicking to edit any project in `/admin/projects` now opens directly at `/admin/projects/{project}/edit` without redirecting to `/admin/pages/{id}/edit`.
- **Sidebar Active State**: The sidebar now keeps **Projects** highlighted as active (`is-active`), rather than jumping to `Pages`.
- **Breadcrumbs & Navigation**:
  - Breadcrumbs reflect project hierarchy: `Home – Projects – Manage {Project Title}`.
  - Return button dynamically links back to **"Back to Projects"** (`/admin/projects`).
- **Form Submission**: Submitting changes from `/admin/projects/{project}/edit` posts to `admin.projects.update` and safely redirects back to `/admin/projects/{project}/edit` with active tab preserved.

---

### 🏊 Global Sidebar Amenities Dropdown Sync (Project Highlights & Facilities)
- **Centralized Synchronization**:
  - Amenities added, edited, or deleted in the sidebar CMS (`/admin/amenities` with icons and names) automatically synchronize across both:
    1. **Project Highlights** section dropdowns.
    2. **Amenities & Facilities** section dropdowns.
- **Universal Coverage Across CMS Entry Points**:
  - **Add Property Drawer** (`/admin/projects` -> "+ Add Property Card"):
    - Highlights: Dropdown strictly lists sidebar amenities (no standard metrics). Redundant visible label text input removed (hidden input used); only the Value text input is displayed alongside the dropdown.
    - Amenities & Facilities: Duplicate text input removed; dropdown is aligned directly beside the icon in a clean single flex row (`[Icon Preview] [Dropdown] [✕ Delete]`) with hidden icon input.
  - **Full Project Editor** (`/admin/projects/{id}/edit`) & **Pages Editor** (`/admin/pages/{id}/edit`):
    - Highlights repeater: Dropdown displays only sidebar amenities, with label stored via hidden input and a single visible Value input.
    - Amenities & Facilities: Duplicate text input removed; displays a single flex row (`[Icon Preview] [Dropdown] [✕ Delete]`) with hidden icon input.
- **Dynamic CRUD Sync**:
  - Embedded client-side `syncAmenitiesFromApi()` fetches `/admin/api/amenities` dynamically so any newly added or updated amenities in the CMS appear immediately in the dropdowns without requiring manual configuration.
- **Frontend UI Icon Rendering**:
  - `partials/highlight-icon.blade.php` dynamically detects uploaded SVG/PNG/JPG amenity icon URLs or paths, inlining local SVGs in pure white (`stroke="#ffffff"`) and applying `filter: brightness(0) invert(1)` to images so all icons appear crisp white (`#ffffff`) and stand out sharply.
  - Green circular badges (`.accentCircle`) have been centered (`top: 50%; left: 50%; transform: translate(-50%, -50%); width: 38px; height: 38px`) across all community and dynamic page templates with 20px calibrated icon sizing to ensure proper alignment and contrast.
  - Custom amenities chosen in Project Highlights and Amenities & Facilities automatically render on the Home page (`partials/highlights.blade.php`), Project detail pages (`dynamic-page.blade.php`), and community landing pages.

---

### 🏢 Commercial Navbar Dropdown & Dynamic Property Placement (CMS & Frontend)
- **Navbar Layout & Hierarchy**:
  - Added a dedicated **COMMERCIAL** dropdown item directly beside **PROJECTS** in the header navigation (both desktop navigation and mobile drawer menu).
  - Matches the exact luxury styling, typography, chevron down animation, hover states, and smooth slide-down transitions of the Projects dropdown.
- **Dynamic Property Filtering (Active Property Omission)**:
  - When a user is visiting any property/project page (e.g. `/hasan`, `/hussain`, `/hudayriyat-golf-estates`, `/wadeem-gardens`, `/al-naseem-villas`, etc.), that property is **automatically excluded/omitted** from the navbar dropdowns so users are not presented with a link to the page they are already browsing.
  - Whichever other active properties belong to Projects or Commercial will show properly.
  - Applies universally across:
    - Main Header (`partials/header.blade.php`) - Home, About Us, Contact Us, Privacy, Blogs (`/blogs`, `/blog/{slug}`).
    - Dynamic Page Template (`dynamic-page.blade.php`) - Dynamic properties, Cities, Custom Pages (e.g. `/hasan`, `/hussain`).
    - All 10 Community Blade Templates (`resources/views/communities/*.blade.php`) - `al-naseem-villas`, `bashayer-residences`, `bashayer-villas`, `hudayriyat-golf-estates`, `masyaf-plots`, `nawayef-east-hills`, `nawayef-park-views`, `nawayef-village`, `wadeem-gardens`, `wadeem-plots`.
    - Next.js Main Header (`src/components/Header.tsx`)
    - All 8 Next.js Community & Project Detail Headers (`GolfHeader`, `BashayerHeader`, `VillasHeader`, `WadeemHeader`, `NaseemHeader`, `NawayefHeader`, `ParkViewsHeader`, `ProjectHeader`) via the reactive hook `src/lib/useNavbarItems.ts`.
- **Interaction & Hover Fixes**:
  - `community-interactions.js` includes `COMMERCIAL` in dropdown button listeners, allowing hover and click opening.
  - `communities/global.css` and `dynamic-page.blade.php` include universal CSS `:hover` selectors for instant dropdown visibility.
- **Admin CMS Checkboxes (Property Placement Control)**:
  - **"+ Add Property Card" Modal** (`/admin/projects`): General Settings tab includes:
    - `Show in Projects Dropdown` (checkbox, checked by default).
    - `Show in Commercial Dropdown` (checkbox, unchecked by default).
  - **"Edit Property Card" Modal** (`/admin/projects`): Includes both checkboxes with automatic state population.
  - **Page Editor** (`/admin/pages/{id}/edit`): General tab includes both checkboxes, syncing seamlessly to the linked property card.
  - Whichever checkbox is selected determines whether the property shows in Projects, Commercial, both, or neither.
- **Public API Endpoint**:
  - Endpoint: `/api/navbar-items?current_slug={slug}`
  - Returns categorized active properties `{ projects: [...], commercial: [...] }` with active property filtering built in.

---

### 🎨 Hero Heading Typography Parity (Home Page Parity Across All Properties)
- **Problem**:
  - Previously on property detail pages (e.g. `/hasan`, `/wadeem-gardens`, and any new property created in the CMS), the hero `<h1>` title was hardcoded at `52px` font size with extra-heavy `800` weight.
  - This caused the heading to appear disproportionately large and wrap across 3 lines compared to the balanced Home page hero heading.
- **Home Page Reference Baseline (`public/css/hudayriyat.css`)**:
  - `font-size: clamp(32px, 3.8vw, 46px);`
  - `font-weight: 700;`
  - `line-height: 1.22;`
  - `letter-spacing: -0.015em;`
  - `text-shadow: 0 2px 10px rgba(0, 0, 0, 0.45);`
  - `margin-bottom: 18px;`
  - Responsive: `36px` on tablet (`<= 991px`), `30px` on mobile (`<= 576px`).
  - Subtitle: `font-size: clamp(15px, 1.35vw, 18px); font-weight: 400; line-height: 1.55; margin-bottom: 16px;`.
- **Universal Fixes Applied**:
  - `public/css/communities/hudayriyat-golf-estates.css`: Updated `.GolfHero-module__9JtUKq__title` to `clamp(32px, 3.8vw, 46px)` with `700` weight and `1.22` line height.
  - `resources/views/dynamic-page.blade.php`: Injected scoped typography rules so every newly created property automatically enforces the identical Home page hero font sizing.
  - `resources/views/partials/page-hero.blade.php`: Added `.heroTitle` and `.heroSubtitle` classes to the hero headline and subtitle elements.

---

### 🌍 Universal Contact Form, Auto Country Flag Detection & Dynamic Phone Validation
- **Global Contact Form Parity**:
  - All contact forms located below the FAQ section on every page (Home, Dynamic Pages like `/hasan` and `/hussain`, Cities, Communities, Blogs, and dedicated contact/about pages) now share a unified, state-of-the-art international phone input component.
- **Auto-Detect Country & Flag**:
  - Automatically identifies visitor's country with 0ms delay using client timezone analysis (`Intl.DateTimeFormat().resolvedOptions().timeZone`), accompanied by an asynchronous IP geolocation lookup (`https://api.country.is` with fallback to `ipapi.co`).
  - Automatically displays the visitor's country flag and dials code by default across all forms on the page.
- **218 Worldwide Countries Alphabetical Dropdown (A to Z) with Real-Time Search**:
  - Clicking the country flag opens a luxury dropdown displaying all 218 countries worldwide, sorted strictly alphabetically (A to Z).
  - Features an embedded search box (`Search country or dial code...`) allowing instant filtering by country name, ISO code, or dial code.
  - Powered by high-definition FlagCDN assets (`https://flagcdn.com/w40/{code}.png`).
- **Dynamic Phone Length & Numbers-Only Validation**:
  - Restricts input exclusively to numbers; letters, punctuation, and invalid characters are blocked on keydown, input, and paste.
  - Dynamically adapts placeholder, max length, and validation boundaries to the specific country selected (e.g. 9 digits for UAE, 10 digits for Pakistan/US/India, 8 digits for Qatar/Kuwait/Oman/Bahrain).
  - Enforces native HTML5 form validation (`reportValidity()`) to prevent submission with incomplete or invalid phone numbers.
- **Site-Wide Global Coverage**:
  - Contact Section below FAQ on all pages (`partials/contact.blade.php`).
  - Dynamic page template (`dynamic-page.blade.php`).
  - All 10 Community Blade templates (`resources/views/communities/*.blade.php`).
  - Home Page Hero Callback Form (`partials/hero.blade.php`).
  - "List Your Property" Navbar Modal (`layouts/app.blade.php`).
  - Dedicated Contact Us Page (`contact-us.blade.php`).
  - About Us Page Inquiry Form (`about-us.blade.php`).
  - Sticky Sidebar Appointment Forms (`partials/article.blade.php`, `partials/page-article.blade.php`, `blogs/show.blade.php`).
  - Blog Detail Page (`blogs/show.blade.php`) - contact section below FAQ.

- **Bug Fixes & UX Hardening Applied**:
  - **Raw Script Text Removed**: Fixed a premature closing `</script>` tag in `resources/views/partials/contact.blade.php` that was previously causing JavaScript lead-handler code to leak and render as plain text under the contact card on all pages.
  - **Flag Click & Dropdown Visibility Restored**: Fixed CSS specificity collision in `public/css/communities/global.css` where global navbar rule `[class*="dropdownMenu"]` was inappropriately applying `opacity: 0` and `visibility: hidden` to `.countryDropdownMenu`. Excluded `.countryDropdownMenu` and added explicit `.dropdownOpen` and `.isOpen` styles with `pointer-events: none` on inner flag/caret child elements to guarantee instantaneous, responsive opening upon clicking the flag.




  7. **Duplicate Dropdown Fix in Appointment Forms**:
     - **Issue**: In `BOOK AN APPOINTMENT` sidebar forms (e.g. in `resources/views/partials/page-article.blade.php`, `article.blade.php`, and `blogs/show.blade.php`), the input was already structured inside a `phoneUnifiedContainer`. An auto-discovery loop in `public/js/universal-phone-selector.js` was erroneously injecting a second nested `phoneUnifiedContainer` beside the existing trigger button, causing two side-by-side dropdown buttons to render on the UI.
     - **Fix**: Added a guard condition `if (input.closest('.phoneUnifiedContainer') || input._phoneInstance) return;` so that inputs already encased in unified containers are never duplicated. Verified on live pages that exactly one clean flag trigger button and dropdown are rendered.


---

### ⚡ Site-Wide n8n Webhook & Lead Automation Integration
- **Webhook Endpoint**: `https://n8n.srv1625508.hstgr.cloud/webhook/979a4b97-a515-4ee0-96e3-5d0ddb475e99`
- **Authentication**: Header Auth using `Authorization: fsa_n8n_secret_token_2026_x99a` (redundantly backed by `X-Token` and `token` headers).
- **Architecture**:
  - Centralized lead dispatcher inside `app/Http/Controllers/LeadController.php` (`dispatchToN8n`).
  - Automatically captures submissions from:
    1. **Contact Section** (below FAQ across all pages)
    2. **Book An Appointment Sidebar** (Project pages, Dynamic pages, and Blog articles)
    3. **Homepage Hero Callback Form**
    4. **List Your Property Modal** (Header & Mobile Drawer)
    5. **Dedicated Contact Us Page** (`/contact-us`)
    6. **About Us Page Inquiry Form** (`/about-us`)
    7. **Community Project Direct Inquiries**
  - Sends exact 13-field JSON payload:
```json
{
  "name": "{{ $json.body.name }}",
  "phone": "{{ $json.body.phone }}",
  "email": "{{ $json.body.email }}",
  "source": "{{ $json.body.source || '' }}",
  "sub_source": "{{ $json.body.sub_source || '' }}",
  "utm_campaign": "{{ $json.body.utm_campaign || '' }}",
  "campaign_url": "{{ $json.body.campaign_url || '' }}",
  "project": "{{ $json.body.project || '' }}",
  "developer": "{{ $json.body.developer || '' }}",
  "community": "{{ $json.body.community || '' }}",
  "property_type": "{{ $json.body.property_type || '' }}",
  "key_requirement": "{{ $json.body.key_requirement || '' }}",
  "activity_description": "{{ $json.body.activity_description || '' }}"
}
```
- **Resilience**: Non-blocking asynchronous dispatch with try-catch fallback. If n8n or external services experience latency or downtime, lead data is safely preserved in MySQL and user interface responds with 0 interruption.
- **Verification**: Verified live with HTTP 200 `{"message":"Workflow was started"}` logged in `storage/logs/laravel.log`.

- **Default Routing Values (CRM & Attribution)**:
  - `sub_source`: Always set to `"saima project"`.
  - `campaign_url`: Always set to `"https://saimaprojects.com/"`.


---

### 🗺️ Dynamic XML Sitemap (`/sitemap.xml`)
- **Route**: `GET /sitemap.xml` (alias: `/sitemap` 301 redirect).
- **Controller**: `app/Http/Controllers/SitemapController.php`
- **Dynamic Content Inclusion**:
  - **Core Routes**: Home (`/`), About Us (`/about-us`), Contact Us (`/contact-us`), Blog Archive (`/blogs`), Legal Pages (`/privacy-policy`, `/terms-and-conditions`, `/disclaimer`).
  - **Dynamic Pages**: All published records from MySQL `pages` table.
  - **Dynamic Projects**: All active records from MySQL `projects` table & 10 luxury community templates.
  - **Dynamic Cities**: All active records from MySQL `cities` table.
  - **Dynamic Communities**: All active records from MySQL `communities` table.
  - **Dynamic Blogs**: All published articles from MySQL `blogs` table (`/blog/{slug}`).
- **SEO Features**: Canonical domain compliance, automatic ISO 8601 `lastmod` timestamps, dynamic priority & change frequency weighting, automatic deduplication, and integration with `robots.txt`.

---

### 🔴 Global Hero Section: "BOOK NOW" Red Color Update
- **Change**: Updated the background color of the hero CTA button (`"BOOK NOW"`) across all website hero sections from green (`#1a4731`) to signature red (`#d9232d`, hover: `#b71a23`).
- **Scope**: Applied universally across the Home page hero, dynamic property page heroes, and all community project templates.

---

### 🏛️ Universal Property URLs Restructuring (`/project/{slug}`) & Automatic 301 Redirects
- **Objective**: Standardize all property/project endpoints so that every property URL is prefixed with `/project/` (e.g. `http://127.0.0.1:8000/project/wadeem-gardens`).
- **Architecture**:
  - **Direct Dedicated Route**: `GET /project/{slug}` resolves all project details pages (database projects, dynamic CMS pages, and custom luxury community templates).
  - **SEO-Friendly 301 Permanent Redirect**: Visiting legacy property URLs (e.g. `http://127.0.0.1:8000/wadeem-gardens` or `wadeem_gardens`) instantly issues an HTTP `301 Moved Permanently` redirect to `/project/{slug}`.
  - **Safety Isolation**: Non-project routes (Cities like `/lahore`, Communities like `/jamshed-road-number`, General Pages `/about-us`, Blogs `/blog/{slug}`) remain untouched at their standard routes.
  - **Navigation & Helper Sync**:
    - `get_navbar_items()` outputs all project dropdown links under `/project/{slug}` and handles active property exclusion.
    - `Project` Eloquent model `$project->url` accessor automatically prepends `/project/`.
    - All community cards, latest project sidebars, and footer links updated to `/project/{slug}`.
    - Dynamic `/sitemap.xml` automatically emits all project links as `https://saimaprojects.com/project/{slug}`.
    - Admin panel ("View Live Page" button, Page URL banner, and Projects table) reflect `/project/{slug}`.

---

### 🏙️ Universal City (`/city/{slug}`) & Community (`/area/{slug}`) URLs & 301 Redirects
- **City Endpoints**: All existing and newly created city pages are strictly served at `http://127.0.0.1:8000/city/{endpoint}` (e.g. `/city/lahore`, `/city/karachi`, `/city/punjab`).
- **Community / Area Endpoints**: All existing and newly created community/neighbourhood pages are strictly served at `http://127.0.0.1:8000/area/{endpoint}` (e.g. `/area/jamshed-road-number`).
- **301 Permanent Redirects**:
  - Legacy URLs (e.g. `http://127.0.0.1:8000/lahore` or `lahore_city`) automatically 301 redirect to `/city/lahore`.
  - Legacy URLs (e.g. `http://127.0.0.1:8000/jamshed-road-number` or `jamshed_road_number`) automatically 301 redirect to `/area/jamshed-road-number`.
- **Model URL Accessors**:
  - `City::getUrlAttribute()` dynamically formats as `/city/{slug}`.
  - `Community::getUrlAttribute()` dynamically formats as `/area/{slug}`.
- **Admin CMS Views**:
  - Page URL banners, live view buttons, slug input prefixes, and listing tables in both City and Community CMS managers updated to `/city/` and `/area/` respectively.
- **Sitemap Note**: As per instruction, `sitemap.xml` was left completely untouched for later review.



---

### 🗺️ Dedicated Core Pages XML Sitemap (`/sitemap/page-sitemap.xml`)
- **Primary Endpoint**: `https://saimaprojects.com/sitemap/page-sitemap.xml` (local development: `http://127.0.0.1:8000/sitemap/page-sitemap.xml` or `/page-sitemap.xml`).
- **Core 6 Static / Institutional Pages Included**:
  1. **Home Page** (`https://saimaprojects.com/`): Priority `1.0`, Change frequency: `daily`
  2. **Contact Us** (`https://saimaprojects.com/contact-us`): Priority `0.5`, Change frequency: `monthly`
  3. **About Us** (`https://saimaprojects.com/about-us`): Priority `0.5`, Change frequency: `monthly`
  4. **Privacy Policy** (`https://saimaprojects.com/privacy-policy`): Priority `0.5`, Change frequency: `yearly`
  5. **Disclaimer** (`https://saimaprojects.com/disclaimer`): Priority `0.5`, Change frequency: `yearly`
  6. **Terms & Conditions** (`https://saimaprojects.com/terms-and-conditions`): Priority `0.5`, Change frequency: `yearly`
- **Dynamic Timestamps**: Automatically checks the MySQL database (`pages` table) for each slug's exact `updated_at` timestamp and renders it in standardized UTC ISO 8601 format.
- **Root Sitemap Integration**:
  - `https://saimaprojects.com/sitemap.xml` points directly to `https://saimaprojects.com/sitemap/page-sitemap.xml` with the latest modification timestamp among the 6 pages.

---

### 🌐 Complete Multi-XML Sitemap Architecture (`/sitemap.xml`)
- **Master Sitemap Index**: `https://saimaprojects.com/sitemap.xml` (local: `http://127.0.0.1:8000/sitemap.xml`)
- **Included Silo Sitemaps**:
  1. `https://saimaprojects.com/sitemap/page-sitemap.xml`: 6 core institutional pages (Home priority: 1.0, Contact/About/Legal priority: 0.5).
  2. `https://saimaprojects.com/sitemap/project-sitemap.xml`: All active projects under `/project/{slug}` (Priority: 0.8).
  3. `https://saimaprojects.com/sitemap/city-sitemap.xml`: All active city landing pages under `/city/{slug}` (Priority: 0.8).
  4. `https://saimaprojects.com/sitemap/area-sitemap.xml`: All active community / area landing pages under `/area/{slug}` (Priority: 0.8).
  5. `https://saimaprojects.com/sitemap/blog-sitemap.xml`: All published blog posts under `/blog/{slug}` and `/blogs` (Priority: 0.8).
  6. `https://saimaprojects.com/sitemap/dynamic-sitemap.xml`: All custom dynamic pages added via `+ Add Page` in CMS (Image 2) (Priority: 0.8).

> **Dynamic CMS Sync Note**: `/sitemap/project-sitemap.xml` strictly outputs projects that have status `Publish` and `is_active = true` in the CMS (`/admin/projects`). Projects in `Draft` status (e.g. Hasan) and un-created templates are automatically excluded.

---

### 🎯 Dynamic Lead Source Page URL Tracking & CRM Delivery

To guarantee that the sales team and CRM always know exactly which webpage generated each inquiry, a full-stack source URL tracking system is active across the application:

1. **Frontend Transmission Across All Pages**:
   - **Project Pages** (`/project/{slug}`, e.g. `/project/wadeem-gardens`, `/project/al-naseem-villas`): Both the sidebar appointment form (`partials/article.blade.php`, `partials/page-article.blade.php`) and custom community interactions script (`community-interactions.js`) dynamically send `page_url: window.location.href` and `campaign_url: window.location.href`.
   - **Area / Community Pages** (`/area/{slug}`): Transmits the exact live URL of the area page via `window.location.href`.
   - **City Pages** (`/city/{slug}`): Transmits the exact live city page URL.
   - **Home Page** (`/`): The Hero callback form (`partials/hero.blade.php`) and footer contact section (`partials/contact.blade.php`) pass `window.location.href`.
   - **Dynamic Blog Pages** (`/blog/{slug}`): The blog appointment form (`blogs/show.blade.php`) passes `window.location.href`.
   - **About Us & Contact Us Pages** (`/about-us`, `/contact-us`): Dedicated forms pass `window.location.href`.
   - **List Your Property Modal** (`layouts/app.blade.php`): Modal form openable across any page captures the current page's `window.location.href`.
   - **Next.js Frontend Parity** (`hudayriayt/src/lib/sendLead.ts` & `hudayriayt_new/src/lib/sendLead.ts`): Form submissions attach `page_url: window.location.href` alongside `campaign_url`.

2. **Backend Controller Ingestion (`LeadController@store`)**:
   - Accepts and validates `page_url` and `campaign_url`.
   - Resolves the exact page URL using a tiered fallback:
     ```php
     $rawPageUrl = $validated['page_url']
         ?? $request->input('page_url')
         ?? ($request->filled('campaign_url') && !in_array(rtrim($request->input('campaign_url'), '/'), ['https://saimaprojects.com', 'http://saimaprojects.com'], true) ? $request->input('campaign_url') : null)
         ?? $request->header('referer')
         ?? $validated['campaign_url']
         ?? $request->input('campaign_url')
         ?? $request->input('url')
         ?? $request->header('origin')
         ?? url()->previous();
     ```
   - Persists the URL into the MySQL `leads` table in the `page_url` column.
   - Forwards the exact URL to the n8n CRM Webhook in multiple standard keys:
     - `campaign_url`: `$pageUrl`
     - `page_url`: `$pageUrl`
     - `url`: `$pageUrl`
     - `source_page_url`: `$pageUrl`

3. **Admin Panel Visibility (`/admin/leads`)**:
   - **Leads Table** (`/admin/leads`): Displays a dedicated **"Source Page URL"** column with a direct link and external icon (`↗`) that allows administrators to open and inspect the exact page where the inquiry was submitted.
   - **Lead Detail View** (`/admin/leads/{id}`): Dedicated view showing client information, clickable phone (`tel:`) and email (`mailto:`), comments, technical metadata (Country, IP address, Timestamp), a prominent **Source Page URL** card with an **"Open Live Page ↗"** button, and an interactive status updater.
   - **CSV Export** (`/admin/leads/export`): Automatically outputs `Page URL` as a column in the downloadable CSV file.

4. **Testing Protocol Requirement**:
   - Whenever automated or manual lead submissions are conducted for testing purposes, **always include the word `"test"` or `"TEST"`** in the name, email, or comment fields to prevent test data from being confused with genuine customer inquiries.

---

## 📦 Deployment & Update Log (Boss / Live Server Reference)

### Update: Project Gallery Direct File Upload (`Choose File`, Max 2MB, Max 10 Images)

#### 1. Database & Migration Changes
* **New Migration File:** None (No new migration required).
* **Database Table Update:** None (Uses existing `page_sections` table `content` JSON column where `section_key = 'gallery'`).

#### 2. Backend & View Files (Created / Updated)
* **Updated Files:**
  * `resources/views/admin/projects/index.blade.php` — Replaced the gallery URL text input field (`Image URL / path`) in the Add Property modal (`#add_tab_gallery`) with a direct `Choose File` upload input (`section_files[gallery][images][*][file]`), live image preview, 2MB max file size validation, and 10-image counter/limit (`1/10`).
  * `resources/views/admin/pages/edit.blade.php` — Updated the Project Gallery editor tab (`#tab-gallery`) across all Property/Page edit screens to include a direct `Choose File` input per gallery item alongside multi-file upload, enforcing the 2MB max file size and 10-image limit.
  * `app/Http/Controllers/Admin/ProjectController.php` — Updated `store()` to process uploaded gallery image files (`section_files.gallery.images`), validate image format (`jpg, jpeg, png, webp, avif`) and size (`<= 2MB`), enforce the 10-image limit, and store files in `public/uploads/pages/`.
  * `app/Http/Controllers/Admin/PageController.php` — Updated `update()` gallery image handling with `_has_images` state tracking, 2MB file size validation, and 10-image cap.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend folder me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Uploads folder ki permissions ensure karein
mkdir -p public/uploads/pages
chmod -R 775 public/uploads/pages

# 4. Laravel cache clear aur optimize karein
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Update: Hide Amenity & Highlight Icons When Not Selected (`-- Choose Amenity --`)

#### 1. Database & Migration Changes
* **New Migration File:** None (Koi nayi migration nahi bani).
* **Database Table Update:** None (Existing `page_sections` table ke JSON `content` column me items sanitize ho kar save hote hain).

#### 2. Backend & View Files (Created / Updated)
* **Updated Files:**
  * `resources/views/admin/pages/edit.blade.php`:
    * `#tab-highlights` & `#tab-amenities`: Dropdown me agar `-- Choose Amenity --` select ho ya koi icon na ho, to preview icon container hide (`display: none`) rehta hai aur icon hidden input empty (`""`) rehta hai.
    * `applyHighlightPreset()`, `addHighlightItem()`, `applyPredefinedAmenity()`, `addAmenityCard()`: JavaScript functions me `-- Choose Amenity --` par switch karne se icon preview clear aur hide ho jata hai.
  * `resources/views/admin/projects/index.blade.php`:
    * `#add_tab_highlights` & `#add_tab_amenities`: Initial state me icon preview box hidden (`display: none;`) rehta hai jab tak koi valid amenity dropdown se select na ki jaye.
    * `applyAddHighlightChoice()`, `addAddHighlightItem()`, `applyProjectAmenity()`, `addAddAmenityCard()`: JS handlers dropdown reset hone par preview image src aur container ko instantly hide aur clear karte hain.
  * `app/Http/Controllers/Admin/PageController.php`:
    * `update()` method me highlights aur amenities repeater sanitize logic update kiya gaya: agar `label` ya `name` empty ho to `icon` ko empty string (`""`) set kiya jata hai aur empty rows ko database me save hone se filter out kiya jata hai.
  * `app/Http/Controllers/Admin/ProjectController.php`:
    * `store()` method me highlights aur amenities items validation update ki gayi taaki empty labels par stale icons persist na hon.
  * `resources/views/partials/highlight-icon.blade.php`:
    * Fallback SVG icons jo empty `$icon` hone par bhi index (0-5) ke base par icon render kar rahe the, unko strictly clean kiya gaya. Ab icon sirf tab render hota hai jab `$icon` explicitly selected ho.
  * `resources/views/partials/highlights.blade.php` & `resources/views/partials/page-highlights.blade.php`:
    * Highlight card me `.iconWrapper` aur `.accentCircle` tabhi render hote hain jab highlight ke paas valid `$hIcon` ho. Empty icon par blank circle/icon box UI par nahi dikhega.
  * `resources/views/dynamic-page.blade.php`:
    * Amenities grid me default placeholder fallback (`/images/golf-estates/amenity-golf.png`) remove kiya gaya. Card tabhi icon container render karta hai jab amenity ka icon database me exist karta ho.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend folder me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Laravel views aur cache clear karein
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan optimize:clear
```

---

### Update: Fix Full-Width Alignment for Contact Form on Blog Detail Pages

#### 1. Database & Migration Changes
* **New Migration File:** None (Koi nayi migration nahi bani).
* **Database Table Update:** None (Koi database table ya schema change nahi hua).

#### 2. Backend & View Files (Created / Updated)
* **Updated Files:**
  * `resources/views/blogs/show.blade.php`:
    * `@include('partials.contact')` ko restricted `.blogDetailContainer` (max-width: 1200px) aur `<main>` wrapper se bahar move kiya gaya. Ab FAQ section ke neeche Contact / Request a Callback section website ke baaki sabhi pages ki tarah 100% full-width viewport background ke saath perfectly align aur adjust hota hai.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend folder me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. View cache clear karein
php artisan view:clear
```

---

### Update: Global Favicon Synchronization (`favicon.png` across all Pages, Projects & CMS)

#### 1. Database & Migration Changes
* **New Migration File:** None (Koi nayi migration nahi bani).
* **Database Table Update:** None (Database table ya schema me koi badlao nahi hua).

#### 2. Backend & View Files (Created / Updated)
* **Updated Files:**
  * `resources/views/dynamic-page.blade.php`:
    * `<head>` section me explicitly `favicon.png` ke `<link rel="icon">`, `<link rel="shortcut icon">`, aur `<link rel="apple-touch-icon">` tags add kiye cache-busting timestamp version (`?v=...`) ke saath. Is se sabhi Dynamic Detail Pages, Project Pages, City, aur Area pages par wahi naya `favicon.png` load hota hai.
  * `resources/views/layouts/app.blade.php`:
    * Global layout me favicon tags ko cache-busting query parameter (`?v=...`) ke saath update kiya gaya taaki browser old cached icon use na kare.
  * `public/favicon.ico`:
    * Browser ke default root `/favicon.ico` request ke liye `public/favicon.ico` ko naye `public/favicon.png` se synchronize aur replace kiya gaya.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend folder me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Views aur cache clear karein
php artisan view:clear
php artisan config:clear
php artisan optimize:clear
```

---

### Update: Global Text & Asset Replacement (`hudayriyat` -> `saima`) in Views, CMS & Source Code

#### 1. Database & Migration Changes
* **New Migration File:** None (Database me koi tabdeeli nahi ki gayi - user instruction ke mutabiq zero database changes).
* **Database Table Update:** None.

#### 2. Backend & View Files (Created / Updated)
* **Created Files:**
  * `public/css/saima.css` — Created as the main luxury theme stylesheet (replacing `hudayriyat.css`).
* **Updated Files:**
  * `resources/views/layouts/app.blade.php`:
    * Replaced stylesheet link `css/hudayriyat.css` with `css/saima.css`.
    * Replaced Schema.org JSON-LD definitions (`Hudayriyat Island` -> `Saima`, `Modon Properties` -> `Saima Group`).
    * Replaced modal lead form defaults (`project`, `developer`, `community`).
  * `resources/views/dynamic-page.blade.php`:
    * Updated stylesheet reference from `css/hudayriyat.css` to `css/saima.css`.
  * `resources/views/admin/**/*.blade.php` (All Admin CMS Blade Templates):
    * Replaced hardcoded references, fallback labels, email place-holders (`info@saimaprojects.com`), and panel titles across Dashboard, Login, Cities, Communities, Pages, Projects, Leads, and SEO modules.
  * `resources/views/**/*.blade.php` (All Frontend Views & Partials):
    * Replaced all occurrences of `Hudayriyat Island` / `Hudayriyat` with `Saima` / `Saima Group` across `about-us.blade.php`, `contact-us.blade.php`, `privacy-policy.blade.php`, `blogs/*.blade.php`, and all `partials/*.blade.php`.
    * (Note: Existing CMS-deleted community files in `resources/views/communities/` were strictly preserved as requested).

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend folder me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Laravel views, config aur route cache clear karein
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

---

### Update: Dynamic Pages Content Synchronization (Short & Long Content) & CMS-Driven Project Cards Display Logic

#### 1. Database & Migration Changes
* **New Migration File:** None *(Strict compliance with user instruction: database table ya structure me koi tabdeeli nahi ki gayi)*.
* **Database Table Update:** None.

#### 2. Backend & View Files (Created / Updated)
* **Updated Files:**
  * `resources/views/admin/pages/edit.blade.php`:
    * `#tab-content` (Content Editor tab) ko update kiya gaya taake **Add Page** (`admin/pages/index.blade.php`) ke exact structure ke mutabiq 2 alag visual Summernote WYSIWYG editors display hon:
      1. **Short Content (`sections[content][intro]`)**: Appointment form ke barabar aane wala introductory text.
      2. **Long Content (`sections[content][html]`)**: Page ka tafseeli article body (Headings, Paragraphs, Images).
    * Page create karne ke baad jab edit kiya jaye ga to Short Content aur Long Content apne apne editor me load honge.
  * `app/Http/Controllers/Admin/PageController.php`:
    * `update()` method me ensure kiya gaya ke `sections.content.intro` aur `sections.content.html` dono sanitize aur decode hoker `page_sections` ke JSON content me aur `$page->body` me sync aur save hon.
  * `resources/views/partials/page-communities.blade.php`:
    * Fallback cards aur unconditional query (`Project::where('is_active', true)->get()`) ko khatam kiya gaya.
    * Strict Rule: Agar CMS se page par specific project cards select nahi kiye gaye (i.e., `selected_ids` / `project_ids` empty hain aur custom items nahi hain) to ye partial **kuch bhi render nahi karega (`return;`)**.
  * `resources/views/partials/article.blade.php`:
    * **Dynamic Pages Layout Rules**:
      * **Case A (Project Cards Selected in CMS)**:
        * Left column me Short Content render hoga aur uske aakhri jumlay ke baad automatically blue color me clickable **`Read more`** link (`style="color: #2563eb; font-weight: 600; text-decoration: underline; cursor: pointer; margin-left: 6px;"`) add hoga jo smooth scroll karke neeche `#pageLongContent` par le jata hai. CMS me user ko "Read more" likhne ki zaroorat nahi hai.
        * Right column me Book an Appointment form aayega.
        * Short Content + Form ke theek baad **Project Cards (Communities Grid)** display honge.
        * Project cards ke neeche **Long Content** display hoga.
      * **Case B (Project Cards NOT Selected in CMS)**:
        * Unwanted project cards bilkul hide rahenge (UI par 0 cards dikhenge).
        * "Read more" ka text bilkul show nahi hoga.
        * Short Content aur Long Content ek sath mix / merge hoker main article column me flow karenge, appointment form ke barabar jese regular pages par hota hai.
  * `resources/views/dynamic-page.blade.php`:
    * Sequence ordering verify ki gayi. Unselected communities section ke duplicate ya forced rendering ko prevent kiya gaya. Jo section CMS me add/active na ho wo UI par render nahi hoga.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend directory me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Views aur cache clear karein
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

---

### Update: Dynamic Pages UI Header Fix, Brand Green Headings & Inline Content Continuation Logic

#### 1. Database & Migration Changes
* **Migration:** None *(Database table ya structure me koi tabdeeli nahi ki gayi)*.
* **Database Table:** None.

#### 2. Backend & View Files (Created / Updated)
* **Created Files:**
  * `public/css/communities/Saima-golf-estates.css` *(Ensuring backward compatibility and preventing 404 styling errors)*.
* **Updated Files:**
  * `resources/views/dynamic-page.blade.php`:
    * Added missing `css/communities/hudayriyat-golf-estates.css` stylesheet link in `<head>` taake dynamic pages par navigation bar, logo alignment, mobile menu drawer, aur hero banner bilkul standard aur clean UI me render hon (un-styled black stacked list fix).
    * `<style>` block me content headings (`h1` ta `h6`) ke liye sitewide brand green (`#1a4731 !important;`) styling add ki.
  * `resources/views/partials/article.blade.php`:
    * **Brand Green Headings**: Article content ke andar تمام headings (`h1` ta `h6`) aur unke child elements (spans, bold, strong) ko `#1a4731 !important;` color assign kiya gaya.
    * **Inline "Read more" Text**: Jab project cards select hon, to "Read more" link ab next line par jane ke bajaye aakhri paragraph ke text ke theek baad usi line par render hota hai (`coastal areas of Karachi. Read more`).
    * **Seamless Content Continuation Without Next Line (Zero Project Cards)**: Jab CMS me project cards select na hon, to long content short content ke theek baad baghair kisi gap ya next line break ke start hota hai. Leading empty `<p><br></p>` tags aur unnecessary container margins ko khatam karke dono contents ko seamlessly merge kiya gaya.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend directory me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Views aur cache clear karein
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```


---

### Update: JSON-LD Schemas (Organization, Dynamic FAQPage & RealEstateAgent) Implementation in Document Header (`<head>`)

#### 1. Database & Migration Changes
* **Migration:** None *(Database table ya structure me koi tabdeeli nahi ki gayi)*.
* **Database Table:** None.

#### 2. Backend & View Files (Created / Updated)
* **Created Files:** None.
* **Updated Files:**
  * `app/helpers.php`:
    * Enhanced `page_data(?string $slug = null)` helper taake URL prefix (`project/`, `city/`, `area/`, `blog/`) ko strip karke related City, Community aur Project models ke sath exact `Page` model aur uske sections resolve hon.
    * Enhanced `get_page_faqs(?\App\Models\Page $page = null, ?\App\Models\Blog $blog = null)` taake current page ke sections me se dynamic FAQ items (`q` / `question`, `a` / `answer`) dynamically extract hon aur HTML tags sanitize hon, with sitewide fallback defaults for generic institutional pages.
    * Added `render_header_schemas(?\App\Models\Page $page = null, ?\App\Models\Blog $blog = null)` helper jo header (`<head>`) me 3 exact JSON-LD schemas generate karta hai:
      1. **Organization Schema**:
         ```json
         {
           "@context": "https://schema.org",
           "@type": "Organization",
           "name": "Saima Projects",
           "url": "https://saimaprojects.com/"
         }
         ```
      2. **FAQPage Schema** (100% Dynamic for complete page):
         ```json
         {
           "@context": "https://schema.org",
           "@type": "FAQPage",
           "mainEntity": [
             {
               "@type": "Question",
               "name": "Where is the project located?",
               "acceptedAnswer": {
                 "@type": "Answer",
                 "text": "The project is located in Karachi, Pakistan."
               }
             }
           ]
         }
         ```
      3. **RealEstateAgent Schema**:
         ```json
         {
           "@context": "https://schema.org",
           "@type": "RealEstateAgent",
           "name": "Saima Projects",
           "url": "https://saimaprojects.com/"
         }
         ```
  * `resources/views/layouts/app.blade.php`:
    * Header `<head>` me `{!! render_header_schemas($activePage ?? null, $blog ?? null) !!}` integrate kiya gaya.
    * Redundant body `@graph` script block ko clean kiya gaya taake header schemas hi single source of truth rahein.
  * `resources/views/dynamic-page.blade.php`:
    * Header `<head>` me `{!! render_header_schemas($page ?? null, null) !!}` inject kiya gaya taake har dynamic page, project, city, aur area page par Organization, Dynamic FAQPage, aur RealEstateAgent schemas render hon.
  * `resources/views/communities/*.blade.php` (All 10 community templates):
    * Har template ke `<head>` me `{!! render_header_schemas($page ?? null, null) !!}` inject kiya gaya aur legacy duplicate hardcoded body schema ko clean kiya gaya.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend directory me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Views aur cache clear karein
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```

---

### Update: Dynamic Pages UI Header Fix, Brand Green Headings & Inline Content Continuation Logic

#### 1. Database & Migration Changes
* **Migration:** None *(Database table ya structure me koi tabdeeli nahi ki gayi)*.
* **Database Table:** None.

#### 2. Backend & View Files (Created / Updated)
* **Created Files:**
  * `public/css/communities/Saima-golf-estates.css` *(Ensuring backward compatibility and preventing 404 styling errors)*.
* **Updated Files:**
  * `resources/views/dynamic-page.blade.php`:
    * Added missing `css/communities/hudayriyat-golf-estates.css` stylesheet link in `<head>` taake dynamic pages par navigation bar, logo alignment, mobile menu drawer, aur hero banner bilkul standard aur clean UI me render hon (un-styled black stacked list fix).
    * `<style>` block me content headings (`h1` ta `h6`) ke liye sitewide brand green (`#1a4731 !important;`) styling add ki.
  * `resources/views/partials/article.blade.php`:
    * **Brand Green Headings**: Article content ke andar تمام headings (`h1` ta `h6`) aur unke child elements (spans, bold, strong) ko `#1a4731 !important;` color assign kiya gaya.
    * **Inline "Read more" Text**: Jab project cards select hon, to "Read more" link ab next line par jane ke bajaye aakhri paragraph ke text ke theek baad usi line par render hota hai (`coastal areas of Karachi. Read more`).
    * **Seamless Content Continuation Without Next Line (Zero Project Cards)**: Jab CMS me project cards select na hon, to long content short content ke theek baad baghair kisi gap ya next line break ke start hota hai. Leading empty `<p><br></p>` tags aur unnecessary container margins ko khatam karke dono contents ko seamlessly merge kiya gaya.

#### 3. Live Server Par Deploy Karne Ki EXACT Commands
```bash
# 1. Backend directory me jayein
cd /path/to/backend

# 2. Latest code pull karein
git pull origin master

# 3. Views aur cache clear karein
php artisan view:clear
php artisan config:clear
php artisan route:clear
php artisan optimize:clear
```






---

## Changelog — 2026-11-06

### Dynamic Page Layout: Project Cards + Sticky Form

**Files changed:**
- `resources/views/partials/article.blade.php`

**Changes:**
1. **Project cards + sticky appointment form layout** — When a CMS page has project cards assigned (communities section), the cards now appear in a **two-column grid** directly below the "Read more" text:
   - **Left column**: Project cards grid (full-width, all assigned cards)
   - **Right column**: Sticky "Book an Appointment" form that remains fixed while scrolling through the cards, then un-sticks when the cards section ends
2. **Sidebar "Latest Projects" widget** is now hidden when assigned project cards are displayed (to avoid duplication)
3. The layout is **responsive** — on mobile (≤991px) the form stacks below the cards normally

### Bug Fix: Project Cards Auto-Assignment on Content Save

**File changed:**
- `app/Http/Controllers/Admin/PageController.php`

**Problem:** Saving the Content section in the admin would auto-assign ALL projects to the page's communities section (project cards picker), overwriting any manually configured selection.

**Root cause:** When only content data was submitted (no dual-picker fields), the `communities` section was saved without preserving `selected_ids` / `unselected_ids`, causing them to be blank and later interpreted as "all selected".

**Fix:** When the dual-picker fields (`selected_project_ids`, `unselected_project_ids`, `dual_boxes_submitted`) are absent from the POST, the existing `selected_ids` and `unselected_ids` values from the database are preserved during save.

### PageController Meta Defaults: Saima Branding

**File changed:**
- `app/Http/Controllers/Admin/PageController.php` (lines 131–133)

**Changes:** Default `meta_title`, `meta_description`, and `meta_keywords` for newly created pages now use "Saima Island" instead of "Hudayriyat Island".


### Dynamic Page Layout & Image Display Refinement (Single Sidebar, No Duplicate Form)

**Files changed:**
- `resources/views/partials/article.blade.php`

**Updates:**
1. **Single Unified Sidebar & Zero Duplicate Forms**:
   - The duplicate `saimaCardsWithForm` section and secondary form have been completely removed.
   - Now only ONE single "Book an Appointment" form exists on the page inside `.saimaStickySidebar`.
   - The "Latest Projects" widget under the appointment form is now always visible (`@if($sidebarProjects->isNotEmpty())`), regardless of whether project cards are selected.
2. **Compact Gap Between Short Content & Project Cards**:
   - Project cards now render directly inside `.saimaContentCol` with a compact `margin-top: 18px;` gap, eliminating the huge white space gap.
3. **Clean Block Image & Text Layout in Long Content**:
   - Added strict CSS overrides (`float: none !important; display: block !important; clear: both !important; margin: 22px auto !important; max-width: 100% !important;`) on images, figures, and paragraphs in dynamic content and long content.
   - Text will no longer awkwardly squeeze beside images; images render as centered, full-width block elements with text cleanly flowing above and below.
4. **Natural Sticky Form Behavior**:
   - The appointment form stays sticky while scrolling through the short content and project cards. When the user scrolls past the project cards into the long content section, the sidebar naturally reaches the bottom of its container and un-sticks.


### Project Cards Full-Bleed Fix & Long Content Width Optimization

**Files changed:**
- `resources/views/partials/article.blade.php`

**Updates:**
1. **Project Card Image & Typography Fix**:
   - Fixed project cards displaying images in shrunk height with dark empty blocks.
   - Enforced `position: absolute !important; width: 100% !important; height: 100% !important; object-fit: cover !important;` on `.cardCustom img.mainImage` so project card images always fill the card 100% full-bleed.
   - Restored `.cardTitle` to bright white (`#ffffff !important;`) with text shadows so titles are clearly readable over the image overlay.
   - Restored `.cardLocation` and `.cardBookBtn` hover effects for property cards.
2. **Eliminated Left/Right Empty Margins in Long Content**:
   - Updated `.saimaLongContentBody` from restricted `max-width: 960px` to `width: 100%; max-width: 100%;` inside the container. Long content now spans cleanly across the entire container width without large empty gutters on the sides.
3. **Optimized Flow When No Project Cards Are Assigned**:
   - When project cards are not assigned, short content and long content flow together seamlessly in the left column (`.saimaContentCol`) alongside the 370px sticky sidebar (appointment form + latest projects), utilizing the full left grid column comfortably.


### CMS Content Tab: Standard Single Summernote vs Dynamic Short/Long Content

**Files changed:**
- `resources/views/admin/pages/edit.blade.php`

**Updates:**
1. **Preserved Original Single Summernote UI for Projects & Communities**:
   - For all project pages (e.g. Wadeem Gardens, managed from Projects), communities, and city pages, the Content tab now displays only the original single Summernote editor ("Content (Summernote Editor)").
2. **Dynamic Custom Pages Retain Short & Long Content**:
   - The dual editor UI (Short Content + Long Content) is only active when creating dynamic pages via "Add Page" and editing custom dynamic pages. Standard projects retain their original clean single-editor CMS workflow.


### Global Favicon Consistency (Frontend, CMS, `sitemap.xml` & `view-source:`)

**Files changed:**
- `public/favicon.ico`
- `routes/web.php`
- `resources/views/admin/layouts/app.blade.php`
- `resources/views/admin/auth/login.blade.php`
- `resources/views/layouts/app.blade.php`
- `resources/views/dynamic-page.blade.php`

**Updates:**
1. **CMS Admin Panel & Login Favicon**:
   - Added `<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=...">`, `<link rel="shortcut icon">`, `<link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=...">`, and `<link rel="apple-touch-icon">` inside `<head>` of `resources/views/admin/layouts/app.blade.php` and `resources/views/admin/auth/login.blade.php`.
   - Replaced the old `H` badge inside `.adm-brand-mark` in the CMS sidebar with `public/favicon.png`.
2. **Valid `.ico` Binary & Browser Cache Refresh for `sitemap.xml` and `view-source:`**:
   - Converted `public/favicon.ico` into a valid Windows `.ico` container embedding the 32×32 `public/favicon.png` image so non-HTML tabs (`sitemap.xml`, sub-sitemaps, and `view-source:`) decode `/favicon.ico` properly.
   - Added a one-time session `fetch('/favicon.ico', { cache: 'reload' })` and fallback routes in `routes/web.php` so browsers immediately evict any previously cached default/old `/favicon.ico`.


### Dynamic Page Creation: Prevent Auto-Selection & Auto-Saving of Unselected Cards (Project Highlights & Project Cards)

**Files changed:**
- `app/Http/Controllers/Admin/PageController.php`
- `app/Http/Controllers/Admin/ProjectController.php`
- `app/Services/PageBlueprintService.php`
- `resources/views/admin/pages/edit.blade.php`
- `resources/views/admin/pages/index.blade.php`

**Updates:**
1. **Unselected Cards Stay Unselected on Add Page & Save**:
   - In `PageController@store` and `PageController@edit`, dynamic pages created via "Add Page" now keep all cards unselected by default (`selected_ids => []`, `items => []`).
   - Removed fallback logic in `PageController@edit` and `ProjectController@edit` that previously defaulted `$selectedProjectIds` to `$allProjects->pluck('id')->all()` when no cards were selected.
2. **Project Highlights Cards Only Save When Explicitly Selected**:
   - In `resources/views/admin/pages/edit.blade.php`, removed hardcoded fallback highlight values (`Modon Properties`, `AED 4,300,000*`, etc.) so unselected highlight cards remain blank/unselected (`-- Choose Amenity --`).
   - In `PageController@store`, `PageController@update`, and `ProjectController@store`, highlight cards are only saved when both the metric/amenity label and value are explicitly filled by the admin.


### Amenities-Powered Icon + Name Dropdown in CMS (Project Highlights, Direct Contact Channels & Amenities)

**Files changed:**
- `resources/views/admin/pages/edit.blade.php`
- `resources/views/admin/pages/index.blade.php`
- `resources/views/contact-us.blade.php`

**Updates:**
1. **Rich Icon + Name Dropdown Populated from Amenities (`$allAmenities`)**:
   - Updated the custom `.adm-metric-input-wrap` + `.adm-metric-menu` dropdown across **Project Highlights** (`edit.blade.php` & `index.blade.php`), **Direct Contact Channels** (`edit.blade.php`), and **Amenities & Facilities** (`edit.blade.php`) to dynamically load names and icons from active **Amenities** (`\App\Models\Amenity`).
   - Selecting any item from the dropdown updates the input label, the prefix icon preview (`<img>`), and the hidden icon input field.
2. **Frontend Contact Channel Icon Rendering**:
   - Updated `resources/views/contact-us.blade.php` so channel cards render uploaded Amenity icon images (`<img>`) alongside built-in SVG icons.




## Changelog — 2026-11-08 (Project Cards stay empty after Save)

- **Bug:** On a page (e.g. newly added) with no project cards selected in the CMS, clicking *Save Changes* still rendered a stale default card (e.g. Wadeem Gardens) on the UI, because the section's old `items` array was never cleared.
- **Fix:** `Admin/PageController` now rebuilds the section `items` from the selected project IDs on every save (`buildProjectCardItems()`); an empty selection saves `items = []` so nothing is shown. Used in the section loop, the top-level dual-picker catch, and `store()`.
- **Files changed:** `app/Http/Controllers/Admin/PageController.php`, `README.md`.
- **Migrations / DB tables:** none created or changed. Re-save an affected page once to clear its stale card.

## Changelog — 2026-11-08 (Investigation: cards auto-selected after Save Changes)

- Simulated page create (store) → edit → Save Changes with an empty picker against the local DB inside a rolled-back transaction: `selected_ids` stayed `[]` and the edit page showed 0 selected cards. Could not reproduce locally, so no code change was made.
- **Files changed:** `README.md` only.
- **Migrations / DB tables:** none created or changed.

## Changelog — 2026-11-09 (Page Layout Component Manager with Drag & Drop Reorder & Dynamic Canonical Tag)

1. **Dynamic SEO Canonical Tag Across All Pages**:
   - Added dynamic `canonical_url()` helper function in `app/helpers.php` that resolves clean page canonical URLs based on the configured SEO Canonical Base URL (or current domain) + clean path.
   - Updated `resources/views/layouts/app.blade.php` and `resources/views/dynamic-page.blade.php` with `<link rel="canonical" href="{{ canonical_url() }}" />`.

2. **Page Edit Component Manager (Image 1 & 2 Parity)**:
   - Added Section Layout & Component Manager at the end of General Settings in `resources/views/admin/pages/edit.blade.php`.
   - **Top Area (Image 1 Top)**: Draggable cards of currently active/selected sections with live order badges, thumbnails, section title, direct edit shortcut, and remove ('✕') button. Supports drag-and-drop mouse reordering.
   - **Bottom Area (Image 1 Bottom & Image 2)**: 'Select Components' multi-select input box with selected component chips and dropdown menu displaying all 7 core sections (Hero Section, Project Highlights, About Community, Article & Booking, Project Cards, FAQ Section, Contact Section) with thumbnails and status (+ Add / ✓ Selected).
   - Selecting from dropdown instantly adds the component to active cards, adds its chip, and shows its tab in the left sidebar.
   - Reordering via drag-and-drop instantly syncs the left sidebar navigation items into the exact sequence and persists via AJAX and form submission.
   - Updated `PageController.php` and `ProjectController.php` to ensure core sections are available and properly update `order` and `is_active` on save/reorder.
- **Files changed**: `resources/views/admin/pages/edit.blade.php`, `app/Http/Controllers/Admin/PageController.php`, `app/Http/Controllers/Admin/ProjectController.php`, `app/helpers.php`, `resources/views/layouts/app.blade.php`, `resources/views/dynamic-page.blade.php`, `README.md`.
- **Database / Migrations**: No new database tables or migrations created (used existing `page_sections` table and `is_active`/`order` columns).

## Changelog — 2026-11-09 (Fix: Components Dropdown Push Down Save Changes Bar)

- **Issue**: When opening the 'Select Components' dropdown in Page Edit, the sticky 'Save Changes' bottom bar was overlapping on top of the dropdown menu.
- **Fix**: Changed `#componentsDropdownMenu` from floating `position: absolute` to natural in-flow `position: relative; margin-top: 10px; width: 100%`. When the dropdown opens, it expands the layout card smoothly and naturally pushes the Save Changes bar down below the dropdown. Also lowered `.adm-sticky-save` z-index to `99` and added automatic smooth scroll into view on open.
- **Files changed**: `resources/views/admin/pages/edit.blade.php`, `README.md`.
- **Database / Migrations**: No database tables or migrations modified.

## Changelog — 2026-11-09 (Fix: Left Sidebar Navigation Tabs Strictly Match Selected Components & Sequence)

- **Issue**: In Admin Page Edit (`admin/pages/{id}/edit`), all section tabs on the left sidebar were visible even when only 2 sections (e.g. Hero Section and Article & Booking) were selected in General Settings. Furthermore, unselected sections were appearing at the top and active sections were pushed to the bottom.
- **Root Cause**:
  1. `.adm-edit-layout > #pageSectionTabs .adm-tab` had CSS `display: flex !important;`, which completely overrode inline `style="display:none;"` from Blade and `btn.style.display = 'none'` from JavaScript.
  2. Tab elements in `#draggableTabsContainer` were not hidden cleanly using `!important` or an explicit `.is-hidden` CSS rule.
- **Fix**:
  1. Updated CSS in `resources/views/admin/pages/edit.blade.php`: removed `!important` from `display: flex;` on `.adm-tab` and added `.adm-edit-layout > #pageSectionTabs .adm-tab.is-hidden { display: none !important; }`.
  2. In the Blade template, tabs for unselected sections are rendered with `is-hidden` class and `style="display:none !important;"` initially so unselected sections never flash or appear on screen.
  3. "General Settings" tab (top) and "SEO & Meta" tab (bottom) remain permanently fixed by default.
  4. Updated `syncPageSectionLayout()` and `saveSectionTabOrder()`:
     - All active/selected sections are ordered in `#draggableTabsContainer` in the exact sequence (#1, #2, etc.) matching the top cards in General Settings and displayed with `display: flex !important`.
     - All unselected sections are moved to the bottom and hidden with `is-hidden` and `display: none !important`.
     - Reordering cards in General Settings or reordering tabs on the sidebar keeps both views 100% synchronized in real time.
     - Auto-switches active pane to 'general' if an active section is removed from selection.
- **Files changed**: `resources/views/admin/pages/edit.blade.php`, `README.md`.
- **Database / Migrations**: No database tables or migrations modified.

## Changelog — 2026-11-10 (Dynamic Page: Content & Property Cards Layout Priority)

- **Requirement**:
  1. When adding/editing a page, if **Short Content** is NOT provided (`article_intro` empty) and **Property Cards** ARE selected, the **Cards must appear at the top** (beside the appointment form), followed by **Long Content** (`article_summernote`) below the cards.
  2. If **Short Content** IS provided and Property Cards ARE selected, the sequence must be: **Short Content first** (beside the appointment form) -> then **Property Cards** -> then **Long Content** below the cards.
- **Fix**:
  - In `resources/views/partials/article.blade.php`, pre-calculated property cards availability (`$pcHasCards`).
  - Removed unconditional fallback rendering of `longContentHtml` before property cards when `hasShortContent` was false.
  - When short content is empty and cards exist, cards render directly at the top of the column (`margin-top: 0px`), followed cleanly by long content rendered in `<section class="saimaLongContentSection" id="pageLongContent">` below the cards.
  - When short content is provided, short content renders first with the inline smooth-scroll 'Read more' link, followed directly by project cards, followed by long content below.
## Changelog — 2026-11-10 (Fix: Blade ParseError unexpected token 'else' in article.blade.php)

- **Issue**: Opening newly created dynamic pages (e.g., `/danish`) caused a Laravel `ParseError: syntax error, unexpected token "else"` at `article.blade.php:1003`.
- **Root Cause**: An accidental duplicate `@endif` block existed around line 905 inside the section subtitle rendering, which prematurely closed the outer `@if($isNewPage)` check before reaching `@else`.
- **Fix**: Removed the duplicate lines from `resources/views/partials/article.blade.php`. Verified successful Blade template compilation and confirmed live rendering of `/danish`.
- **Files changed**: `resources/views/partials/article.blade.php`, `README.md`.
- **Database / Migrations**: No database tables or migrations modified.

## Changelog — 2026-11-10 (Global Search Engine Verifications & Google Analytics Head Tags)

- **Requirement**: Inject Webmaster verification meta tags (Google Search Console, Bing Webmaster, Yandex) and Google Analytics GA4 gtag.js scripts into the `<head>` of all website pages.
- **Implemented Tags**:
  1. **Google Search Console**: `<meta name="google-site-verification" content="Pm7-Vgw4thZ8OH-WltmZSRwDdqxp9q4Xn5mMU_06tRg" />`
  2. **Bing Webmaster Tools**: `<meta name="msvalidate.01" content="E65C761395C7D12E4A6CFCB1B51CD0E8" />`
  3. **Yandex Webmaster**: `<meta name="yandex-verification" content="433a6fd3c0ac4850" />`
  4. **Google Analytics (GA4)**: `gtag.js` and `gtm.js` loader for ID `G-N3YF0EL0QY` with dataLayer initialization and `gtag('config', 'G-N3YF0EL0QY')`.
- **Architecture**:
  - Created centralized partial `resources/views/partials/seo-head-scripts.blade.php`.
  - Injected into master layout (`layouts/app.blade.php`), universal dynamic pages (`dynamic-page.blade.php`), and all 10 legacy community pages (`resources/views/communities/*.blade.php`).
  - Synced into CMS `site_settings` table under `seo_header_scripts` and `header_scripts` so the admin Global SEO panel (`/admin/seo`) displays these scripts.
- **Files changed**:
  - `resources/views/partials/seo-head-scripts.blade.php` (created)
  - `resources/views/layouts/app.blade.php`
  - `resources/views/dynamic-page.blade.php`
  - `resources/views/communities/*.blade.php` (10 files)
  - `README.md`
- **Database / Migrations**: Existing `site_settings` key updated. No new tables or migrations created.

## Changelog — 2026-11-12 (City & Community CMS: Empty Add Fields, Strict Dynamic Data on Frontend, and Active Tab Persistence on Save)

- **Requirement**:
  1. **Empty Input Fields on Add**: When adding a new City (`/admin/cities`) or Community (`/admin/communities`), all section input fields (Hero badge, WYSIWYG Content, Project Cards headings, About narrative/video/poster, FAQ questions & answers, Contact headings & details) must start completely empty instead of pre-filled demo/placeholder values.
  2. **No Hardcoded Data on Frontend**: When saving and viewing a City or Community page on the frontend (`/city/{slug}` or `/area/{slug}`), the page must only display data actually added via CMS. If a section or field is empty in the CMS, no hardcoded/fallback placeholder text or dummy content should appear.
  3. **Stay on Current Section upon Save Changes**: When clicking save ("Save City Page", "Save Community", or "Save Changes"), administrators should remain on the same page and on the exact active section/tab they were editing rather than being redirected to the index listing.
- **Changes Implemented**:
  - **`app/Http/Controllers/Admin/CityController.php` & `app/Http/Controllers/Admin/CommunityController.php`**:
    - `store()`: Removed all hardcoded string fallbacks (e.g. `"Explore Premier Properties..."`, `"Prime Investment Hub"`, `"Featured Projects in..."`). Empty inputs are stored cleanly as empty strings/nulls.
    - `store()` redirect: Now passes `active_tab` and redirects directly to the newly created entity's edit route (`admin.cities.edit` or `admin.communities.edit`) with `?tab={activeTab}`, keeping the user directly on the section they just saved.
    - `update()`: Removed restrictive `if ($request->filled(...))` blocks that prevented clearing content. Erasing or updating a field in CMS now properly updates and clears the database/JSON content. Preserves `?tab={activeTab}` on save.
  - **`resources/views/admin/cities/index.blade.php` & `resources/views/admin/communities/index.blade.php`**:
    - Removed all prefilled template text from Hero Badge, Summernote Content WYSIWYG editor, Project Cards headings, About Community headline/narrative/video/poster, FAQ items repeater, and Contact CTA details.
    - Added hidden `<input type="hidden" name="active_tab" id="add_active_tab_input" value="general">` and synced `switchAddTab(tabId)` to track the active section when submitting the form.
  - **`resources/views/admin/cities/edit.blade.php` & `resources/views/admin/communities/edit.blade.php`**:
    - Removed hardcoded default FAQ questions injection (`$faqItems = is_array($faqItems) ? $faqItems : [];`).
    - Removed hardcoded fallback strings from FAQ section title/subtitle inputs and About poster image.
  - **`resources/views/dynamic-page.blade.php`, `resources/views/partials/page-about.blade.php`, `resources/views/partials/contact.blade.php`**:
    - Contact Section: Gated with `$hasContactContent` check so it only renders if contact information was entered in CMS. Removed hardcoded marketing paragraphs from `partials/contact.blade.php`.
    - About Section: Removed hardcoded `', Saima'` title suffix. Section only renders if description, poster, or video URL exists.
    - FAQ Section: Confirmed strictly gated by `@if(!empty($dbFaqs))` so empty FAQs do not render.
    - Content/TOC Section: Gated by `$hasContentSection` so empty WYSIWYG does not render empty blocks.
- **Files Modified**:
  - `app/Http/Controllers/Admin/CityController.php`
  - `app/Http/Controllers/Admin/CommunityController.php`
  - `resources/views/admin/cities/index.blade.php`
  - `resources/views/admin/cities/edit.blade.php`
  - `resources/views/admin/communities/index.blade.php`
  - `resources/views/admin/communities/edit.blade.php`
  - `resources/views/dynamic-page.blade.php`
  - `resources/views/partials/page-about.blade.php`
  - `resources/views/partials/contact.blade.php`
  - `README.md`
- **Database / Migrations**: No migrations created or table schemas altered.

## Changelog — 2026-11-12 (Part 2: Karachi & Islamabad City Pages Section Data Reset & Clean Frontend Display)

- **Requirement**:
  1. Empty all section content for **Karachi** (`/city/karachi`) and **Islamabad** (`/city/islamabad`) city pages in the database while retaining their slugs and basic page records.
  2. The page URL routes must continue to exist (HTTP 200), but appear completely empty on the frontend UI without dummy text or fallback hero sliders/forms.
  3. Allow administrators to add data via CMS whenever desired, and ensure clearing fields in CMS correctly persists empty values.
- **Changes Implemented**:
  - **Database Records Reset**:
    - Cleared all section data (`hero`, `content`, `communities`, `about`, `faq`, `contact`) in `page_sections` table for Karachi (`page_id: 65`) and Islamabad (`page_id: 86`).
    - Cleared `body` on `pages` and `image` on `cities` table for both records.
  - **`resources/views/dynamic-page.blade.php`**:
    - Added `$hasHeroContent` gate before rendering `partials/page-hero`. If Hero title, subtitle, badge, and background image are not set in the CMS, the hero section is not rendered, preventing dummy fallback hero slides or forms from showing.
  - **`app/Http/Controllers/Admin/CityController.php` & `app/Http/Controllers/Admin/CommunityController.php`**:
    - Updated hero update handler to allow erasing background image (does not retain old image if text field is empty and no new file uploaded).
    - Allowed clearing Hero H1 title without auto-forcing city/community name.
  - **`resources/views/admin/cities/edit.blade.php` & `resources/views/admin/communities/edit.blade.php`**:
    - Updated Hero Main Heading (H1) input to default to empty string (`value="{{ $heroContent['title'] ?? '' }}"`) with a placeholder, ensuring clean empty fields when editing pages with cleared hero data.
- **Files Modified**:
  - `app/Http/Controllers/Admin/CityController.php`
  - `app/Http/Controllers/Admin/CommunityController.php`
  - `resources/views/admin/cities/edit.blade.php`
  - `resources/views/admin/communities/edit.blade.php`
  - `resources/views/dynamic-page.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Data rows updated in `cities`, `pages`, and `page_sections` tables (Karachi and Islamabad records). Schema unchanged.

## Changelog — 2026-11-12 (Part 3: Complete Removal of Dummy "Wadeem Gardens" Legacy Data Across CMS & Frontend)

- **Bug Identification**:
  - The card **"Wadeem Gardens"** (with location `"Hudayriyat Island, Abu Dhabi"`) was appearing on `/area/pidc` and multiple city/community pages even though it was never added to the CMS by the user and did not exist in the `projects` table.
  - **Root Cause**:
    1. Legacy database rows in `page_sections` table (`section_key = 'communities'`) contained a seeded fallback JSON `items` array: `[{"name":"Wadeem Gardens","location":"Hudayriyat Island, Abu Dhabi",...}]`.
    2. In frontend Blade templates (`partials/page-communities.blade.php`, `partials/article.blade.php`, `dynamic-page.blade.php`), when no real projects were selected by the user (`selected_ids` is empty), the templates fell back to `@elseif(!empty($secCommunities))` or `@elseif(!empty($pcCustomItems))`, rendering the dummy Wadeem Gardens card.
- **Changes Implemented**:
  1. **Database Cleanup**:
     - Scanned all database tables (`page_sections`, `pages`, `cities`, `communities`, `projects`).
     - Removed the dummy `Wadeem Gardens` items array from all 12 affected `page_sections` rows (Sections 471, 495, 567, 595, 601, 618, 635, 669, 675, 692, 731, 770).
     - Cleared default fallback headings where `selected_ids` was empty.
     - Cleared legacy `og_image` on `pages` (ID 85) that pointed to `wadeem-gardens.png`.
  2. **Template Hardening (No Dummy Fallbacks)**:
     - `resources/views/partials/page-communities.blade.php`: Completely removed the `@elseif(!empty($secCommunities))` fallback loop. If `$hasDbProjects` is false (no real projects selected from the CMS `projects` table), the template returns immediately and renders nothing.
     - `resources/views/dynamic-page.blade.php`: Removed `$hasCommItems` trigger; only renders the Project Cards section if `$hasSelProjects` is true.
     - `resources/views/partials/article.blade.php`: Removed `@elseif(!empty($pcCustomItems))` fallback loop; only renders project cards if real database projects are selected.
  3. **Model & Controller Cleanup**:
     - `app/Models/Project.php`: Removed fallback image URL pointing to `/images/communities/wadeem-gardens.png`.
     - `app/Http/Controllers/Admin/PageController.php`: Removed fallback image paths pointing to `/images/communities/wadeem-gardens.png`.
- **Files Modified**:
  - `app/Models/Project.php`
  - `app/Http/Controllers/Admin/PageController.php`
  - `resources/views/partials/page-communities.blade.php`
  - `resources/views/partials/article.blade.php`
  - `resources/views/dynamic-page.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Cleaned dummy data rows in `page_sections` and `pages` tables. Schema unchanged.

## Changelog — 2026-11-12 (Part 4: Direct Image Upload / File Picker in Content WYSIWYG Editor)

- **Requirement**:
  - In the Content section of Project detail pages (`/admin/projects/{id}/edit`) and Dynamic pages (`/admin/pages/{id}/edit`), clicking the image button showed a confusing modal asking for an "Image URL" with a disabled "Insert Image" button instead of allowing the administrator to choose a file directly from their computer (`choose file kersakho`).
  - Fix the Content section so administrators can directly select image files from their computer and have them uploaded and inserted into the article.
- **Changes Implemented**:
  1. **Backend Route & Controller Endpoint**:
     - Added endpoint `POST /admin/upload-content-image` in `routes/web.php` mapped to `AdminPageController::uploadContentImage`.
     - Validates incoming image files, stores them in `public/uploads/content/`, and returns `{ success: true, url: "/uploads/content/..." }`.
  2. **Summernote Global Integration (`admin/layouts/app.blade.php`)**:
     - Added `window.uploadAndInsertSummernoteFile(file, $editor)` function that sends selected files via AJAX and inserts clean, responsive `<img>` tags (`max-width: 100%; height: auto; border-radius: 8px; margin: 15px 0;`).
     - Added `callbacks.onImageUpload` in Summernote options.
     - Intercepted Summernote toolbar Picture button to directly trigger the native OS File Chooser dialog, completely bypassing the confusing "Image URL" modal.
     - Added fallback listener for file selection inside any open Summernote dialog.
  3. **Direct UI "Choose File & Insert Image" Buttons**:
     - Added explicit `[ 📷 Choose File & Insert Image ]` buttons above the Content WYSIWYG editors in:
       - `resources/views/admin/pages/edit.blade.php` (Content & Short Content tabs for Projects and Dynamic Pages).
       - `resources/views/admin/projects/index.blade.php` (Add Project Drawer Content tab).
       - `resources/views/admin/pages/index.blade.php` (Add Page Drawer Content tabs).
       - `resources/views/admin/cities/edit.blade.php` & `resources/views/admin/communities/edit.blade.php`.
- **Files Modified**:
  - `routes/web.php`
  - `app/Http/Controllers/Admin/PageController.php`
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `resources/views/admin/pages/index.blade.php`
  - `resources/views/admin/cities/edit.blade.php`
  - `resources/views/admin/communities/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 8: Dual-Box Featured Projects Layout & Custom Heading Range Formatter)

- **Requirements Completed**:
  1. **Dual-Box Featured Projects System (Matching Image 2)**:
     - Replaced the tabbed view with the familiar 2-column dual box system:
       - **Box 1 (Left)**: `Available Property Cards ( [count] )` with `+ Select All`, drag-and-drop, and `+ Add` button.
       - **Box 2 (Right)**: `Selected Cards for This Page ( [count] )` with `Clear All`, drag-and-drop, and `✕ Remove` button.
     - **Strict Developer Filtering**: Box 1 contains **strictly only** projects where the project's developer matches this developer (via the project card developer dropdown). Projects from other developers do not appear.
     - Automatically updates hidden inputs `featured_projects[]` on add/remove/drag for seamless form saving.
  2. **Summernote Headings H1 to H6 & Selective Text Formatting**:
     - Added full H1, H2, H3, H4, H5, H6, and Normal (p) options to the Summernote Style dropdown.
     - Removed `data-no-h1="true"` restrictions from Developer short and full content editors.
     - **Selection-Specific Heading Application**: Solved the issue where selecting a few words turned the entire paragraph into a heading. Now, when a text range is highlighted inside a paragraph, choosing a heading splits the block cleanly so **only the selected text becomes that heading**, while surrounding text remains untouched.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 6: Project-Developer Association & Two-Tab Featured Projects System)

- **Requirements Completed**:
  1. **Developer Dropdown in Project Card Settings**:
     - Added `Developer (Select Developer)` dropdown directly below `Neighbourhood/Community` in both the Project Edit Page (`admin/pages/edit.blade.php`), the Projects Add Drawer (`admin/projects/index.blade.php`), and the Projects Edit Modal (`admin/projects/index.blade.php`).
     - Selecting a developer associates the project with that developer (`developer_id` foreign key & `developer` name sync).
  2. **Removed Specified Helper Texts**:
     - Removed `"Jo community sidebar se add ki hai wo yahan dropdown me ayegi (Community, City format me card par show hogi)."` from `admin/pages/edit.blade.php` and `admin/projects/index.blade.php`.
     - Removed `"Abhi koi developer add nahi kiya hai. Jab aap create karenge tab yahan list show hogi."` from empty state in `admin/developers/index.blade.php`.
  3. **Two-Tab Featured Projects System (Selected & Unselected)**:
     - Eliminated the global project checkbox grid.
     - Implemented two sub-tabs: **Selected** and **Unselected**.
     - In **Unselected**: Only projects that have this developer selected from their project page dropdown appear (unrelated projects from other developers do not appear).
     - Added dropdown selector `Select Project From Dropdown` and `+ Add to Selected` button, as well as direct `Select` and `Unselect` buttons on cards with real-time badges.
- **Files Created**:
  - `database/migrations/2026_11_13_163000_add_developer_id_to_projects_table.php`
- **Files Modified**:
  - `app/Models/Project.php`
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/PageController.php`
  - `app/Http/Controllers/Admin/ProjectController.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `resources/views/admin/developers/index.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migration created and executed: `2026_11_13_163000_add_developer_id_to_projects_table.php`.
  - Database Table `projects` updated with nullable foreign key column: `developer_id` referencing `developers(id)` on delete set null.


## Changelog — 2026-11-13 (Part 7: Fix Developer Dropdown in Project Card Editor)

- **Issue Reported**:
  - In project card settings dropdown, developers were not showing ("No developers found. Please add a developer from sidebar first.") even though 2 developers were created in the database.
- **Root Cause**:
  - When editing a project via `/admin/projects/{project}/edit`, the route is handled by `ProjectController@edit` which renders `admin.pages.edit`.
  - `ProjectController@edit` had not passed `$developers` to the view data.
- **Changes Implemented**:
  1. Updated `ProjectController@edit` to fetch `$developers = \App\Models\Developer::orderBy('order', 'asc')->orderBy('name', 'asc')->get();` and include it in `compact(...)`.
  2. Added fallback query in `admin/pages/edit.blade.php` and `admin/projects/index.blade.php` so the dropdown always has access to the developers list even if omitted by a controller method.
- **Files Modified**:
  - `app/Http/Controllers/Admin/ProjectController.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 8: Dual-Box Featured Projects Layout & Custom Heading Range Formatter)

- **Requirements Completed**:
  1. **Dual-Box Featured Projects System (Matching Image 2)**:
     - Replaced the tabbed view with the familiar 2-column dual box system:
       - **Box 1 (Left)**: `Available Property Cards ( [count] )` with `+ Select All`, drag-and-drop, and `+ Add` button.
       - **Box 2 (Right)**: `Selected Cards for This Page ( [count] )` with `Clear All`, drag-and-drop, and `✕ Remove` button.
     - **Strict Developer Filtering**: Box 1 contains **strictly only** projects where the project's developer matches this developer (via the project card developer dropdown). Projects from other developers do not appear.
     - Automatically updates hidden inputs `featured_projects[]` on add/remove/drag for seamless form saving.
  2. **Summernote Headings H1 to H6 & Selective Text Formatting**:
     - Added full H1, H2, H3, H4, H5, H6, and Normal (p) options to the Summernote Style dropdown.
     - Removed `data-no-h1="true"` restrictions from Developer short and full content editors.
     - **Selection-Specific Heading Application**: Solved the issue where selecting a few words turned the entire paragraph into a heading. Now, when a text range is highlighted inside a paragraph, choosing a heading splits the block cleanly so **only the selected text becomes that heading**, while surrounding text remains untouched.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 9: Site-Wide H1-H6 Style Dropdown & Range-Specific Heading Replacement)

- **Requirements Completed**:
  1. **All Site-Wide Editors Standardized with H1 to H6**:
     - Configured `defaultStyleTags` across all Summernote editors (`.adm-summernote, .summernote`) to explicitly provide:
       `Normal (P)`, `Heading 1 (H1)`, `Heading 2 (H2)`, `Heading 3 (H3)`, `Heading 4 (H4)`, `Heading 5 (H5)`, and `Heading 6 (H6)`.
     - Removed restrictive conditions (`data-no-h1`) so every editor has access to all headings.
     - Fixed CSS overflow clipping: Set `.note-editor.note-frame { overflow: visible !important; }` and `.note-dropdown-menu { max-height: 380px !important; overflow-y: auto !important; z-index: 99999 !important; }` so all headings (H1 through H6) are fully visible and never cut off.
  2. **Selective Text Range Heading Replacement**:
     - Hooked directly into Summernote's core editor module (`context.modules.editor.formatBlock`).
     - When any text is highlighted/selected, choosing any heading (H1 to H6) splits the enclosing paragraph block cleanly around the selection and transforms **strictly only the selected text into that heading**, leaving preceding and succeeding text completely intact as paragraphs.
     - If no text is selected (cursor collapsed), standard block-level formatBlock runs smoothly.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 10: Compact Style Dropdown Matching Image 1 & In-Place Same-Line Heading Replacement)

- **Requirements Completed**:
  1. **Compact Style Dropdown Matching User Reference (Image 1)**:
     - Replaced oversized, scrolled dropdown preview items with a clean, compact dropdown menu.
     - Updated options to exact clean titles: `Normal`, `Quote`, `Code`, `Header 1`, `Header 2`, `Header 3`, `Header 4`, `Header 5`, and `Header 6`.
     - Overrode `.note-dropdown-menu` CSS rules to eliminate excessive line-height, eliminate vertical scrollbars (`max-height: none !important`, `overflow-y: visible !important`), and set balanced, compact font sizes for each option (`18px` to `13px`) matching Image 1.
  2. **In-Place Same-Line Selected Text Formatting (No Line Break / Jump)**:
     - Fixed the issue where applying a heading to selected text split the paragraph and pushed the word onto a separate new line.
     - Implemented inline formatting (`<span class="heading-inline heading-hX" style="display: inline; font-size: ...; font-weight: ...;">`) for selected text ranges.
     - When a word or phrase is highlighted (e.g. "make" in a paragraph) and any Header or Style is clicked, it remains on the **exact same line in-place** while immediately updating its font size and font weight according to Header 1 through Header 6, Normal, Quote, or Code.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 11: Z-Index Elevation for Style Dropdown & H5/H6 Visibility)

- **Requirements Completed**:
  1. **Style Dropdown Z-Index Stacking Context Fix**:
     - Resolved the issue where the Style dropdown of the top editor (`Short Content`) was dipping underneath the toolbar of the next editor (`Full Content`), hiding `Header 5` and `Header 6`.
     - Elevated the active `.note-editor` stacking context (`z-index: 9999 !important; position: relative !important;`) on focus, open state, and click events.
     - Elevated `.note-toolbar` (`z-index: 20`), `.note-btn-group.open` (`z-index: 99999`), and `.note-dropdown-menu` (`z-index: 999999 !important;`).
     - Tightened item padding and margins inside the dropdown for a sleeker profile so all items (Normal, Quote, Code, Header 1–Header 6) render completely on top and are fully visible.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 12: Developer Public Detail Page 100% Dynamic Page UI Parity)

- **Requirements Completed**:
  1. **Dynamic Page UI Replication for Developer Public Detail Page (`/developer/{slug}`)**:
     - Upgraded `developers/show.blade.php` to match the exact frontend design system, stylesheets, fonts, and layout structure of `dynamic-page.blade.php` without modifying `dynamic-page.blade.php`.
  2. **Identical Section Ordering & Aesthetic**:
     - **Header & Navbar**: Full sticky header with Projects & Commercial dropdown menus, mobile navigation drawer, and "LIST YOUR PROPERTY" modal trigger.
     - **Hero Section**: `GolfHero` banner featuring the developer cover image, dark gradient overlay, developer SVG logo (with drop shadow), H1 (`$developer->h1 ?: $developer->name`), tagline (`$developer->tagline`), red "BOOK NOW" button, and the "REQUEST A CALL BACK" card with international phone selector.
     - **Short Content**: Rendered in a clean container directly beneath the Hero.
     - **Featured Property Cards**: Rendered with the exact same 460px luxury card design from `partials/page-communities.blade.php` (tags/badges, sold-out status, luxury preview thumbnail, title, location, and green "BOOK NOW" button) for all projects assigned to this developer in `featured_projects`.
     - **Long Content**: Rendered with identical typography and layout (`saimaContentCol`, `saimaDynamicContent`, `saimaLongContentBody`).
     - **Brand Green Headings (`#1a4731`)**: Configured all headings (H1 through H6) inside content blocks to display in the site-wide signature brand green (`#1a4731`).
     - **FAQs**: Rendered in the exact interactive accordion style matching `dynamic-page.blade.php` with brand green active state and animated chevron indicator.
     - **Footer & Interactions**: Full site footer with scroll-to-top button and client interaction scripts.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 13: Dedicated Developer Page Custom Layout with Sticky Sidebar & Centered Hero)

- **Requirements Completed**:
  1. **Centered Minimalist Hero (Developer Page Only)**:
     - Configured the Hero section to show **strictly only** the Developer H1 title and Tagline beneath it, centered horizontally and vertically.
     - Removed all buttons, forms, and logos from the Hero section.
  2. **Two-Column Top Layout with Sticky Sidebar (Short Content + Cards on Left, Sidebar on Right)**:
     - **Left Column**:
       - Developer **Short Content** with an automatic **Read More ↓** link at the end that smoothly scrolls down to the Long Content section (`#longContent`).
       - Developer **Featured Project Cards** grid matching the luxury cards design.
     - **Right Column (Sticky Sidebar)**:
       - Developer **SVG Logo** placed directly on top of the form.
       - **Request A Call Back** form card with fields for name, email, and phone.
       - **Latest Projects** card beneath the form displaying the latest active projects with thumbnail, title, and location.
       - Sticky positioning (`position: sticky; top: 90px;`): stays in view while browsing short content and project cards, and naturally scrolls away as soon as cards end and long content begins.
  3. **Full-Width Long Content & FAQs**:
     - Full-width Long Content section beneath the two-column cards section with brand green (`#1a4731`) headings.
     - FAQs accordion section beneath long content with brand green active states.
     - Site footer and interaction scripts.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 14: Inline Read More, Original Hero Image Colors & Dynamic Sticky Sidebar with Scrollbar)

- **Requirements Completed**:
  1. **Inline Read More Placement**:
     - Moved the `Read More ↓` link from a separate newline container to sit directly **inline at the end of the short content text** (inside the ending paragraph tag).
     - Does not break onto a new line, keeping the reading flow natural and seamless.
  2. **Original Hero Image Color (No Green Tint)**:
     - Replaced the green-tinted overlay (`rgba(10, 26, 17, ...)`) with a neutral photographic gradient (`rgba(0, 0, 0, 0.40)` to `rgba(0, 0, 0, 0.60)`).
     - The hero cover image now preserves its authentic original colors with zero color alteration or green cast.
  3. **Dynamic Page Sticky Sidebar Parity**:
     - Upgraded the developer page right sidebar to match `partials/article.blade.php`:
       - `position: sticky; top: 90px; max-height: calc(100vh - 110px);`
       - Integrated custom slim vertical scrollbar (`::-webkit-scrollbar` with `#cbd5e1` thumb) allowing independent internal scrolling.
       - Full `BOOK AN APPOINTMENT` card with name, phone, email, and comments textarea with AJAX form submission.
       - Developer SVG logo placed above the form card, and Latest Projects list below the form.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 15: CMS-Managed FAQ Heading & Subtitle for Developers)

- **Requirements Completed**:
  1. **CMS Fields for FAQ Heading & Subtitle**:
     - Added new fields `FAQ Heading` and `FAQ Subtitle` to the Developer FAQs tab in both `create.blade.php` and `edit.blade.php`.
     - Admins can now customize the main heading (e.g. `Frequently Asked Questions`) and explanatory subtitle (e.g. `Got questions about [Developer Name]? Find helpful answers below.`) directly from the CMS.
  2. **Backend Controller & Model Updates**:
     - Added `faq_heading` (string, nullable) and `faq_subtitle` (text, nullable) columns to the `developers` table via database migration `2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table`.
     - Updated `Developer` Eloquent model `$fillable` array.
     - Updated `DeveloperController@store` and `DeveloperController@update` to capture and persist both fields.
  3. **Frontend Dynamic Rendering**:
     - Updated `developers/show.blade.php` to dynamically display `$developer->faq_heading` and `$developer->faq_subtitle` on the public developer detail page.
     - Clean fallback support: If left blank in the CMS, defaults smoothly to `Frequently Asked Questions` and the standard developer-specific help text.
- **Files Modified**:
  - `database/migrations/2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table.php` (New)
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: Created and executed `2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table`.
  - Database Tables: Added `faq_heading` and `faq_subtitle` to `developers` table. Uploaded images are stored in `public/uploads/content/`.

## Changelog — 2026-11-12 (Part 5: Fix Content Editor Cursor Range, Unfreeze Page Clicks, and Isolate Long vs Short Content)

- **Issues Reported**:
  1. **Page Unclickable / Frozen Overlay**: After inserting an image in the content editor, the entire admin page was unclickable and had a dark gray overlay.
     - *Root Cause*: Summernote Lite's modal injected a `.note-modal-backdrop` fixed overlay covering the entire viewport with `z-index: 1040`.
  2. **Image Inserted at Top Instead of Below Target Text**: When selecting an image, it was being placed at the very beginning of the editor (offset 0) instead of below the text where the user had clicked/placed their cursor.
     - *Root Cause*: Summernote lost its range selection when clicking buttons or opening file pickers, and `restoreRange` was not being called before `insertImage`.
  3. **Image Leaking into Short Content**: On dynamic pages with both Short Content and Long Content, inserting an image sometimes affected Short Content instead of Long Content.
     - *Root Cause*: When focus was lost, the upload function fell back to the first visible textarea on the page (`$('textarea.adm-summernote:visible:first')`), which was Short Content.
- **Changes Implemented**:
  1. **Removed All Backdrops & Unfroze UI**:
     - Added global CSS `.note-modal-backdrop { display: none !important; pointer-events: none !important; }` in `admin/layouts/app.blade.php`.
     - Added automated backdrop cleanup (`cleanupAllModalsAndBackdrops()`) on upload success, upload error, and DOM mutations, permanently preventing frozen overlays.
  2. **Exact Cursor Range Restoration**:
     - Summernote now continuously saves cursor range (`saveRange`) on `focus`, `keyup`, `mouseup`, and `click`.
     - When clicking any "Choose File & Insert Image" button or the toolbar Picture icon, `onmousedown` explicitly saves the cursor range on that specific editor.
     - Before inserting the image, the exact saved range is restored (`$target.summernote('focus'); $target.summernote('restoreRange'); $target.summernote('insertImage', res.url)`), placing the image directly at the exact position/paragraph where the cursor was located.
  3. **Strict Isolation Between Long & Short Content**:
     - Each file upload button explicitly binds to its corresponding textarea element (`content_wysiwyg` for Long Content, `content_intro` for Short Content), ensuring images never cross-contaminate between editors.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `resources/views/admin/pages/index.blade.php`
  - `resources/views/admin/cities/edit.blade.php`
  - `resources/views/admin/communities/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 8: Dual-Box Featured Projects Layout & Custom Heading Range Formatter)

- **Requirements Completed**:
  1. **Dual-Box Featured Projects System (Matching Image 2)**:
     - Replaced the tabbed view with the familiar 2-column dual box system:
       - **Box 1 (Left)**: `Available Property Cards ( [count] )` with `+ Select All`, drag-and-drop, and `+ Add` button.
       - **Box 2 (Right)**: `Selected Cards for This Page ( [count] )` with `Clear All`, drag-and-drop, and `✕ Remove` button.
     - **Strict Developer Filtering**: Box 1 contains **strictly only** projects where the project's developer matches this developer (via the project card developer dropdown). Projects from other developers do not appear.
     - Automatically updates hidden inputs `featured_projects[]` on add/remove/drag for seamless form saving.
  2. **Summernote Headings H1 to H6 & Selective Text Formatting**:
     - Added full H1, H2, H3, H4, H5, H6, and Normal (p) options to the Summernote Style dropdown.
     - Removed `data-no-h1="true"` restrictions from Developer short and full content editors.
     - **Selection-Specific Heading Application**: Solved the issue where selecting a few words turned the entire paragraph into a heading. Now, when a text range is highlighted inside a paragraph, choosing a heading splits the block cleanly so **only the selected text becomes that heading**, while surrounding text remains untouched.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 6: Project-Developer Association & Two-Tab Featured Projects System)

- **Requirements Completed**:
  1. **Developer Dropdown in Project Card Settings**:
     - Added `Developer (Select Developer)` dropdown directly below `Neighbourhood/Community` in both the Project Edit Page (`admin/pages/edit.blade.php`), the Projects Add Drawer (`admin/projects/index.blade.php`), and the Projects Edit Modal (`admin/projects/index.blade.php`).
     - Selecting a developer associates the project with that developer (`developer_id` foreign key & `developer` name sync).
  2. **Removed Specified Helper Texts**:
     - Removed `"Jo community sidebar se add ki hai wo yahan dropdown me ayegi (Community, City format me card par show hogi)."` from `admin/pages/edit.blade.php` and `admin/projects/index.blade.php`.
     - Removed `"Abhi koi developer add nahi kiya hai. Jab aap create karenge tab yahan list show hogi."` from empty state in `admin/developers/index.blade.php`.
  3. **Two-Tab Featured Projects System (Selected & Unselected)**:
     - Eliminated the global project checkbox grid.
     - Implemented two sub-tabs: **Selected** and **Unselected**.
     - In **Unselected**: Only projects that have this developer selected from their project page dropdown appear (unrelated projects from other developers do not appear).
     - Added dropdown selector `Select Project From Dropdown` and `+ Add to Selected` button, as well as direct `Select` and `Unselect` buttons on cards with real-time badges.
- **Files Created**:
  - `database/migrations/2026_11_13_163000_add_developer_id_to_projects_table.php`
- **Files Modified**:
  - `app/Models/Project.php`
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/PageController.php`
  - `app/Http/Controllers/Admin/ProjectController.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `resources/views/admin/developers/index.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migration created and executed: `2026_11_13_163000_add_developer_id_to_projects_table.php`.
  - Database Table `projects` updated with nullable foreign key column: `developer_id` referencing `developers(id)` on delete set null.


## Changelog — 2026-11-13 (Part 7: Fix Developer Dropdown in Project Card Editor)

- **Issue Reported**:
  - In project card settings dropdown, developers were not showing ("No developers found. Please add a developer from sidebar first.") even though 2 developers were created in the database.
- **Root Cause**:
  - When editing a project via `/admin/projects/{project}/edit`, the route is handled by `ProjectController@edit` which renders `admin.pages.edit`.
  - `ProjectController@edit` had not passed `$developers` to the view data.
- **Changes Implemented**:
  1. Updated `ProjectController@edit` to fetch `$developers = \App\Models\Developer::orderBy('order', 'asc')->orderBy('name', 'asc')->get();` and include it in `compact(...)`.
  2. Added fallback query in `admin/pages/edit.blade.php` and `admin/projects/index.blade.php` so the dropdown always has access to the developers list even if omitted by a controller method.
- **Files Modified**:
  - `app/Http/Controllers/Admin/ProjectController.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 8: Dual-Box Featured Projects Layout & Custom Heading Range Formatter)

- **Requirements Completed**:
  1. **Dual-Box Featured Projects System (Matching Image 2)**:
     - Replaced the tabbed view with the familiar 2-column dual box system:
       - **Box 1 (Left)**: `Available Property Cards ( [count] )` with `+ Select All`, drag-and-drop, and `+ Add` button.
       - **Box 2 (Right)**: `Selected Cards for This Page ( [count] )` with `Clear All`, drag-and-drop, and `✕ Remove` button.
     - **Strict Developer Filtering**: Box 1 contains **strictly only** projects where the project's developer matches this developer (via the project card developer dropdown). Projects from other developers do not appear.
     - Automatically updates hidden inputs `featured_projects[]` on add/remove/drag for seamless form saving.
  2. **Summernote Headings H1 to H6 & Selective Text Formatting**:
     - Added full H1, H2, H3, H4, H5, H6, and Normal (p) options to the Summernote Style dropdown.
     - Removed `data-no-h1="true"` restrictions from Developer short and full content editors.
     - **Selection-Specific Heading Application**: Solved the issue where selecting a few words turned the entire paragraph into a heading. Now, when a text range is highlighted inside a paragraph, choosing a heading splits the block cleanly so **only the selected text becomes that heading**, while surrounding text remains untouched.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 9: Site-Wide H1-H6 Style Dropdown & Range-Specific Heading Replacement)

- **Requirements Completed**:
  1. **All Site-Wide Editors Standardized with H1 to H6**:
     - Configured `defaultStyleTags` across all Summernote editors (`.adm-summernote, .summernote`) to explicitly provide:
       `Normal (P)`, `Heading 1 (H1)`, `Heading 2 (H2)`, `Heading 3 (H3)`, `Heading 4 (H4)`, `Heading 5 (H5)`, and `Heading 6 (H6)`.
     - Removed restrictive conditions (`data-no-h1`) so every editor has access to all headings.
     - Fixed CSS overflow clipping: Set `.note-editor.note-frame { overflow: visible !important; }` and `.note-dropdown-menu { max-height: 380px !important; overflow-y: auto !important; z-index: 99999 !important; }` so all headings (H1 through H6) are fully visible and never cut off.
  2. **Selective Text Range Heading Replacement**:
     - Hooked directly into Summernote's core editor module (`context.modules.editor.formatBlock`).
     - When any text is highlighted/selected, choosing any heading (H1 to H6) splits the enclosing paragraph block cleanly around the selection and transforms **strictly only the selected text into that heading**, leaving preceding and succeeding text completely intact as paragraphs.
     - If no text is selected (cursor collapsed), standard block-level formatBlock runs smoothly.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 10: Compact Style Dropdown Matching Image 1 & In-Place Same-Line Heading Replacement)

- **Requirements Completed**:
  1. **Compact Style Dropdown Matching User Reference (Image 1)**:
     - Replaced oversized, scrolled dropdown preview items with a clean, compact dropdown menu.
     - Updated options to exact clean titles: `Normal`, `Quote`, `Code`, `Header 1`, `Header 2`, `Header 3`, `Header 4`, `Header 5`, and `Header 6`.
     - Overrode `.note-dropdown-menu` CSS rules to eliminate excessive line-height, eliminate vertical scrollbars (`max-height: none !important`, `overflow-y: visible !important`), and set balanced, compact font sizes for each option (`18px` to `13px`) matching Image 1.
  2. **In-Place Same-Line Selected Text Formatting (No Line Break / Jump)**:
     - Fixed the issue where applying a heading to selected text split the paragraph and pushed the word onto a separate new line.
     - Implemented inline formatting (`<span class="heading-inline heading-hX" style="display: inline; font-size: ...; font-weight: ...;">`) for selected text ranges.
     - When a word or phrase is highlighted (e.g. "make" in a paragraph) and any Header or Style is clicked, it remains on the **exact same line in-place** while immediately updating its font size and font weight according to Header 1 through Header 6, Normal, Quote, or Code.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 11: Z-Index Elevation for Style Dropdown & H5/H6 Visibility)

- **Requirements Completed**:
  1. **Style Dropdown Z-Index Stacking Context Fix**:
     - Resolved the issue where the Style dropdown of the top editor (`Short Content`) was dipping underneath the toolbar of the next editor (`Full Content`), hiding `Header 5` and `Header 6`.
     - Elevated the active `.note-editor` stacking context (`z-index: 9999 !important; position: relative !important;`) on focus, open state, and click events.
     - Elevated `.note-toolbar` (`z-index: 20`), `.note-btn-group.open` (`z-index: 99999`), and `.note-dropdown-menu` (`z-index: 999999 !important;`).
     - Tightened item padding and margins inside the dropdown for a sleeker profile so all items (Normal, Quote, Code, Header 1–Header 6) render completely on top and are fully visible.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 12: Developer Public Detail Page 100% Dynamic Page UI Parity)

- **Requirements Completed**:
  1. **Dynamic Page UI Replication for Developer Public Detail Page (`/developer/{slug}`)**:
     - Upgraded `developers/show.blade.php` to match the exact frontend design system, stylesheets, fonts, and layout structure of `dynamic-page.blade.php` without modifying `dynamic-page.blade.php`.
  2. **Identical Section Ordering & Aesthetic**:
     - **Header & Navbar**: Full sticky header with Projects & Commercial dropdown menus, mobile navigation drawer, and "LIST YOUR PROPERTY" modal trigger.
     - **Hero Section**: `GolfHero` banner featuring the developer cover image, dark gradient overlay, developer SVG logo (with drop shadow), H1 (`$developer->h1 ?: $developer->name`), tagline (`$developer->tagline`), red "BOOK NOW" button, and the "REQUEST A CALL BACK" card with international phone selector.
     - **Short Content**: Rendered in a clean container directly beneath the Hero.
     - **Featured Property Cards**: Rendered with the exact same 460px luxury card design from `partials/page-communities.blade.php` (tags/badges, sold-out status, luxury preview thumbnail, title, location, and green "BOOK NOW" button) for all projects assigned to this developer in `featured_projects`.
     - **Long Content**: Rendered with identical typography and layout (`saimaContentCol`, `saimaDynamicContent`, `saimaLongContentBody`).
     - **Brand Green Headings (`#1a4731`)**: Configured all headings (H1 through H6) inside content blocks to display in the site-wide signature brand green (`#1a4731`).
     - **FAQs**: Rendered in the exact interactive accordion style matching `dynamic-page.blade.php` with brand green active state and animated chevron indicator.
     - **Footer & Interactions**: Full site footer with scroll-to-top button and client interaction scripts.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 13: Dedicated Developer Page Custom Layout with Sticky Sidebar & Centered Hero)

- **Requirements Completed**:
  1. **Centered Minimalist Hero (Developer Page Only)**:
     - Configured the Hero section to show **strictly only** the Developer H1 title and Tagline beneath it, centered horizontally and vertically.
     - Removed all buttons, forms, and logos from the Hero section.
  2. **Two-Column Top Layout with Sticky Sidebar (Short Content + Cards on Left, Sidebar on Right)**:
     - **Left Column**:
       - Developer **Short Content** with an automatic **Read More ↓** link at the end that smoothly scrolls down to the Long Content section (`#longContent`).
       - Developer **Featured Project Cards** grid matching the luxury cards design.
     - **Right Column (Sticky Sidebar)**:
       - Developer **SVG Logo** placed directly on top of the form.
       - **Request A Call Back** form card with fields for name, email, and phone.
       - **Latest Projects** card beneath the form displaying the latest active projects with thumbnail, title, and location.
       - Sticky positioning (`position: sticky; top: 90px;`): stays in view while browsing short content and project cards, and naturally scrolls away as soon as cards end and long content begins.
  3. **Full-Width Long Content & FAQs**:
     - Full-width Long Content section beneath the two-column cards section with brand green (`#1a4731`) headings.
     - FAQs accordion section beneath long content with brand green active states.
     - Site footer and interaction scripts.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 14: Inline Read More, Original Hero Image Colors & Dynamic Sticky Sidebar with Scrollbar)

- **Requirements Completed**:
  1. **Inline Read More Placement**:
     - Moved the `Read More ↓` link from a separate newline container to sit directly **inline at the end of the short content text** (inside the ending paragraph tag).
     - Does not break onto a new line, keeping the reading flow natural and seamless.
  2. **Original Hero Image Color (No Green Tint)**:
     - Replaced the green-tinted overlay (`rgba(10, 26, 17, ...)`) with a neutral photographic gradient (`rgba(0, 0, 0, 0.40)` to `rgba(0, 0, 0, 0.60)`).
     - The hero cover image now preserves its authentic original colors with zero color alteration or green cast.
  3. **Dynamic Page Sticky Sidebar Parity**:
     - Upgraded the developer page right sidebar to match `partials/article.blade.php`:
       - `position: sticky; top: 90px; max-height: calc(100vh - 110px);`
       - Integrated custom slim vertical scrollbar (`::-webkit-scrollbar` with `#cbd5e1` thumb) allowing independent internal scrolling.
       - Full `BOOK AN APPOINTMENT` card with name, phone, email, and comments textarea with AJAX form submission.
       - Developer SVG logo placed above the form card, and Latest Projects list below the form.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 15: CMS-Managed FAQ Heading & Subtitle for Developers)

- **Requirements Completed**:
  1. **CMS Fields for FAQ Heading & Subtitle**:
     - Added new fields `FAQ Heading` and `FAQ Subtitle` to the Developer FAQs tab in both `create.blade.php` and `edit.blade.php`.
     - Admins can now customize the main heading (e.g. `Frequently Asked Questions`) and explanatory subtitle (e.g. `Got questions about [Developer Name]? Find helpful answers below.`) directly from the CMS.
  2. **Backend Controller & Model Updates**:
     - Added `faq_heading` (string, nullable) and `faq_subtitle` (text, nullable) columns to the `developers` table via database migration `2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table`.
     - Updated `Developer` Eloquent model `$fillable` array.
     - Updated `DeveloperController@store` and `DeveloperController@update` to capture and persist both fields.
  3. **Frontend Dynamic Rendering**:
     - Updated `developers/show.blade.php` to dynamically display `$developer->faq_heading` and `$developer->faq_subtitle` on the public developer detail page.
     - Clean fallback support: If left blank in the CMS, defaults smoothly to `Frequently Asked Questions` and the standard developer-specific help text.
- **Files Modified**:
  - `database/migrations/2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table.php` (New)
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: Created and executed `2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table`.
  - Database Tables: Added `faq_heading` and `faq_subtitle` to `developers` table.


## Changelog — 2026-11-13 (Developer CMS Module Implementation)

- **Requirements**:
  1. Add **Developer** menu item in CMS sidebar directly below **Neighbourhood/Community**.
  2. When clicked, display the **Add Developer** page replicating the user-specified layout:
     - Header: "Add Developer", breadcrumb "Home - Manage - Developer", and "Developers List" top-right button.
     - Left sidebar tab: "Basic Details" with active indicator.
     - Right section: "Developer Details" form.
     - Field: **Developer Name***.
     - Field: **Slug*** placed directly below Developer Name (with real-time automatic slug generation).
     - Field: **H1** (renamed from "Total No. of Projects").
     - Field: **Tagline** (renamed from "Established On").
     - Field: **Short Content** textarea with placeholder "Please Enter information here...".
     - Field: **Full Content** WYSIWYG editor (integrated with Summernote).
- **Files Created**:
  - `database/migrations/2026_11_13_140000_create_developers_table.php`
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/index.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
- **Files Modified**:
  - `routes/web.php`
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/partials/icon.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migration created and executed: `2026_11_13_140000_create_developers_table.php`.
  - Database Table created: `developers` table with columns `id`, `name`, `slug`, `h1`, `tagline`, `short_content`, `full_content`, `image`, `status`, `is_active`, `order`, `created_at`, `updated_at`.


## Changelog — 2026-11-13 (Part 2: Developer Cover Auto-OG, Logo SVG & Summernote Enhancements)

- **Requirements**:
  1. **Cover Image & Auto OpenGraph (OG)**: Added Cover Image upload/path in Developer CMS. When set, it automatically populates the `og:image` and `twitter:image` meta tags so sharing developer links (WhatsApp, social media) displays the developer cover thumbnail.
  2. **Developer Logo (SVG)**: Added dedicated SVG/image logo upload field and URL input with live preview.
  3. **Summernote for Short Content**: Converted Short Content to a rich Summernote WYSIWYG editor.
  4. **Both Editors 5 Core Capabilities**:
     - **Image**: Photo insertion with drag-and-drop / upload inside content.
     - **Table**: Table creation and styling.
     - **Bullets**: Ordered and unordered list points.
     - **Headings (H2, H3)**: Strictly restricted styleTags to H2 and H3 only (removed H1 to maintain strict semantic single-H1 hierarchy per page). Styled H2 and H3 with distinct visual font sizes.
     - **Link**: Text hyperlinking on any selected text.
  5. **Public Developer Show Page**: Created public route `/developer/{slug}` and view `developers.show` rendering H1, Tagline, Logo, Cover Hero with auto-OG integration, Short Content, and Full Content.
- **Files Created**:
  - `database/migrations/2026_11_13_150000_add_cover_and_logo_to_developers_table.php`
  - `resources/views/developers/show.blade.php`
- **Files Modified**:
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `resources/views/admin/developers/index.blade.php`
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/layouts/app.blade.php`
  - `routes/web.php`
  - `README.md`
- **Database / Migrations**:
  - Migration created and executed: `2026_11_13_150000_add_cover_and_logo_to_developers_table.php`.
  - Database Table `developers` columns added: `logo` (nullable), `cover_image` (nullable), `og_image` (nullable).


## Changelog — 2026-11-13 (Part 3: Developer List View, Status Dropdown, 4 Sidebar Tabs & Clean Image Uploads)

- **Requirements**:
  1. **Clean Image Upload Controls**: Removed manual text inputs ("Or provide Image path:" and "Or provide SVG image path:"), leaving pure, clean file choosers.
  2. **Strict SVG Validation for Developer Logo**: Enforced SVG-only validation (`.svg`, `image/svg+xml`) on Developer Logo upload.
  3. **Field Layout Sequence**: Arranged fields in exact requested sequence:
     - Developer Name *
     - Slug *
     - H1
     - Tagline
     - Short Content (Summernote)
     - Long Content / Full Content (Summernote)
     - Cover Image (auto og:image)
     - Developer Logo (SVG)
  4. **Sidebar Navigation to List**: Clicking "Developer" in CMS sidebar now directly opens the Developers List page (`admin.developers.index`).
  5. **3-Column List View**: Developers list table now contains strictly 3 columns as requested:
     - `#` (Number)
     - `DEVELOPER NAME`
     - `ACTIONS` (Edit, View Public Page, Delete)
     - Search filter bar and empty state when no developers exist yet.
  6. **4 Vertical Tabs (Matching Image 3)**:
     - `Basic Details`
     - `SEO` (Meta Title, Meta Description, Meta Keywords, Canonical URL)
     - `Featured Projects` (Project select/checkboxes from projects table)
     - `FAQs` (Renamed from "Developer Detail L2" with dynamic Add/Remove FAQ repeater items)
  7. **Status Dropdown Next to Developers List**: Added `Draft` / `Publish` dropdown at top right next to "Developers List" button, defaulting to `Draft`. All fields default empty when adding a new developer.
- **Files Created**:
  - `database/migrations/2026_11_13_154500_add_seo_projects_faqs_to_developers_table.php`
- **Files Modified**:
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/developers/index.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migration created and executed: `2026_11_13_154500_add_seo_projects_faqs_to_developers_table.php`.
  - Database Table `developers` columns added: `meta_title` (nullable), `meta_description` (nullable), `meta_keywords` (nullable), `canonical_url` (nullable), `featured_projects` (json, nullable), `faqs` (json, nullable), with `status` default set to `'draft'`.


## Changelog — 2026-11-13 (Part 4: Fix Projects Column Name in DeveloperController)

- **Issues Reported**:
  - `Illuminate\Database\QueryException: Column not found: 1054 Unknown column 'name' in 'order clause' (SQL: select * from projects order by name asc)` when loading `/admin/developers/create`.
- **Root Cause**:
  - The `projects` database table uses the `title` column instead of `name`.
- **Changes Implemented**:
  - Updated `DeveloperController.php` (`create` and `edit` methods) to sort projects by `order asc, title asc` instead of nonexistent `name`.
  - Updated `create.blade.php` and `edit.blade.php` to render `$proj->title ?: ($proj->name ?? ...)`.
- **Files Modified**:
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 5: UI Cleanups & FAQ Layout Refinements)

- **Requirements**:
  1. **Removed Default Topbar ("Menu" & "Saima")**: Added `.adm-topbar { display: none !important; }` across all developer views (`index`, `create`, `edit`) to permanently eliminate unwanted topbar elements.
  2. **Relocated "+ Add FAQ Item" Button**: Moved the button from the header down directly below the FAQ items container.
  3. **Removed Canonical URL Field**: Removed the `Canonical URL` field from the SEO tab.
  4. **Removed Redundant Helper Texts from Basic Details**:
     - Removed `"Cover Image automatically becomes og:image (link share karne par yahi image thumbnail preview me show hogi)."`
     - Removed `"Full detail for the main developer page. Supports: Images, Tables, Bullets, Headings (H2, H3), and Links."`
- **Files Modified**:
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `resources/views/admin/developers/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 8: Dual-Box Featured Projects Layout & Custom Heading Range Formatter)

- **Requirements Completed**:
  1. **Dual-Box Featured Projects System (Matching Image 2)**:
     - Replaced the tabbed view with the familiar 2-column dual box system:
       - **Box 1 (Left)**: `Available Property Cards ( [count] )` with `+ Select All`, drag-and-drop, and `+ Add` button.
       - **Box 2 (Right)**: `Selected Cards for This Page ( [count] )` with `Clear All`, drag-and-drop, and `✕ Remove` button.
     - **Strict Developer Filtering**: Box 1 contains **strictly only** projects where the project's developer matches this developer (via the project card developer dropdown). Projects from other developers do not appear.
     - Automatically updates hidden inputs `featured_projects[]` on add/remove/drag for seamless form saving.
  2. **Summernote Headings H1 to H6 & Selective Text Formatting**:
     - Added full H1, H2, H3, H4, H5, H6, and Normal (p) options to the Summernote Style dropdown.
     - Removed `data-no-h1="true"` restrictions from Developer short and full content editors.
     - **Selection-Specific Heading Application**: Solved the issue where selecting a few words turned the entire paragraph into a heading. Now, when a text range is highlighted inside a paragraph, choosing a heading splits the block cleanly so **only the selected text becomes that heading**, while surrounding text remains untouched.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 6: Project-Developer Association & Two-Tab Featured Projects System)

- **Requirements Completed**:
  1. **Developer Dropdown in Project Card Settings**:
     - Added `Developer (Select Developer)` dropdown directly below `Neighbourhood/Community` in both the Project Edit Page (`admin/pages/edit.blade.php`), the Projects Add Drawer (`admin/projects/index.blade.php`), and the Projects Edit Modal (`admin/projects/index.blade.php`).
     - Selecting a developer associates the project with that developer (`developer_id` foreign key & `developer` name sync).
  2. **Removed Specified Helper Texts**:
     - Removed `"Jo community sidebar se add ki hai wo yahan dropdown me ayegi (Community, City format me card par show hogi)."` from `admin/pages/edit.blade.php` and `admin/projects/index.blade.php`.
     - Removed `"Abhi koi developer add nahi kiya hai. Jab aap create karenge tab yahan list show hogi."` from empty state in `admin/developers/index.blade.php`.
  3. **Two-Tab Featured Projects System (Selected & Unselected)**:
     - Eliminated the global project checkbox grid.
     - Implemented two sub-tabs: **Selected** and **Unselected**.
     - In **Unselected**: Only projects that have this developer selected from their project page dropdown appear (unrelated projects from other developers do not appear).
     - Added dropdown selector `Select Project From Dropdown` and `+ Add to Selected` button, as well as direct `Select` and `Unselect` buttons on cards with real-time badges.
- **Files Created**:
  - `database/migrations/2026_11_13_163000_add_developer_id_to_projects_table.php`
- **Files Modified**:
  - `app/Models/Project.php`
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/PageController.php`
  - `app/Http/Controllers/Admin/ProjectController.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `resources/views/admin/developers/index.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migration created and executed: `2026_11_13_163000_add_developer_id_to_projects_table.php`.
  - Database Table `projects` updated with nullable foreign key column: `developer_id` referencing `developers(id)` on delete set null.


## Changelog — 2026-11-13 (Part 7: Fix Developer Dropdown in Project Card Editor)

- **Issue Reported**:
  - In project card settings dropdown, developers were not showing ("No developers found. Please add a developer from sidebar first.") even though 2 developers were created in the database.
- **Root Cause**:
  - When editing a project via `/admin/projects/{project}/edit`, the route is handled by `ProjectController@edit` which renders `admin.pages.edit`.
  - `ProjectController@edit` had not passed `$developers` to the view data.
- **Changes Implemented**:
  1. Updated `ProjectController@edit` to fetch `$developers = \App\Models\Developer::orderBy('order', 'asc')->orderBy('name', 'asc')->get();` and include it in `compact(...)`.
  2. Added fallback query in `admin/pages/edit.blade.php` and `admin/projects/index.blade.php` so the dropdown always has access to the developers list even if omitted by a controller method.
- **Files Modified**:
  - `app/Http/Controllers/Admin/ProjectController.php`
  - `resources/views/admin/pages/edit.blade.php`
  - `resources/views/admin/projects/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.



## Changelog — 2026-11-13 (Part 8: Dual-Box Featured Projects Layout & Custom Heading Range Formatter)

- **Requirements Completed**:
  1. **Dual-Box Featured Projects System (Matching Image 2)**:
     - Replaced the tabbed view with the familiar 2-column dual box system:
       - **Box 1 (Left)**: `Available Property Cards ( [count] )` with `+ Select All`, drag-and-drop, and `+ Add` button.
       - **Box 2 (Right)**: `Selected Cards for This Page ( [count] )` with `Clear All`, drag-and-drop, and `✕ Remove` button.
     - **Strict Developer Filtering**: Box 1 contains **strictly only** projects where the project's developer matches this developer (via the project card developer dropdown). Projects from other developers do not appear.
     - Automatically updates hidden inputs `featured_projects[]` on add/remove/drag for seamless form saving.
  2. **Summernote Headings H1 to H6 & Selective Text Formatting**:
     - Added full H1, H2, H3, H4, H5, H6, and Normal (p) options to the Summernote Style dropdown.
     - Removed `data-no-h1="true"` restrictions from Developer short and full content editors.
     - **Selection-Specific Heading Application**: Solved the issue where selecting a few words turned the entire paragraph into a heading. Now, when a text range is highlighted inside a paragraph, choosing a heading splits the block cleanly so **only the selected text becomes that heading**, while surrounding text remains untouched.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 9: Site-Wide H1-H6 Style Dropdown & Range-Specific Heading Replacement)

- **Requirements Completed**:
  1. **All Site-Wide Editors Standardized with H1 to H6**:
     - Configured `defaultStyleTags` across all Summernote editors (`.adm-summernote, .summernote`) to explicitly provide:
       `Normal (P)`, `Heading 1 (H1)`, `Heading 2 (H2)`, `Heading 3 (H3)`, `Heading 4 (H4)`, `Heading 5 (H5)`, and `Heading 6 (H6)`.
     - Removed restrictive conditions (`data-no-h1`) so every editor has access to all headings.
     - Fixed CSS overflow clipping: Set `.note-editor.note-frame { overflow: visible !important; }` and `.note-dropdown-menu { max-height: 380px !important; overflow-y: auto !important; z-index: 99999 !important; }` so all headings (H1 through H6) are fully visible and never cut off.
  2. **Selective Text Range Heading Replacement**:
     - Hooked directly into Summernote's core editor module (`context.modules.editor.formatBlock`).
     - When any text is highlighted/selected, choosing any heading (H1 to H6) splits the enclosing paragraph block cleanly around the selection and transforms **strictly only the selected text into that heading**, leaving preceding and succeeding text completely intact as paragraphs.
     - If no text is selected (cursor collapsed), standard block-level formatBlock runs smoothly.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 10: Compact Style Dropdown Matching Image 1 & In-Place Same-Line Heading Replacement)

- **Requirements Completed**:
  1. **Compact Style Dropdown Matching User Reference (Image 1)**:
     - Replaced oversized, scrolled dropdown preview items with a clean, compact dropdown menu.
     - Updated options to exact clean titles: `Normal`, `Quote`, `Code`, `Header 1`, `Header 2`, `Header 3`, `Header 4`, `Header 5`, and `Header 6`.
     - Overrode `.note-dropdown-menu` CSS rules to eliminate excessive line-height, eliminate vertical scrollbars (`max-height: none !important`, `overflow-y: visible !important`), and set balanced, compact font sizes for each option (`18px` to `13px`) matching Image 1.
  2. **In-Place Same-Line Selected Text Formatting (No Line Break / Jump)**:
     - Fixed the issue where applying a heading to selected text split the paragraph and pushed the word onto a separate new line.
     - Implemented inline formatting (`<span class="heading-inline heading-hX" style="display: inline; font-size: ...; font-weight: ...;">`) for selected text ranges.
     - When a word or phrase is highlighted (e.g. "make" in a paragraph) and any Header or Style is clicked, it remains on the **exact same line in-place** while immediately updating its font size and font weight according to Header 1 through Header 6, Normal, Quote, or Code.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 11: Z-Index Elevation for Style Dropdown & H5/H6 Visibility)

- **Requirements Completed**:
  1. **Style Dropdown Z-Index Stacking Context Fix**:
     - Resolved the issue where the Style dropdown of the top editor (`Short Content`) was dipping underneath the toolbar of the next editor (`Full Content`), hiding `Header 5` and `Header 6`.
     - Elevated the active `.note-editor` stacking context (`z-index: 9999 !important; position: relative !important;`) on focus, open state, and click events.
     - Elevated `.note-toolbar` (`z-index: 20`), `.note-btn-group.open` (`z-index: 99999`), and `.note-dropdown-menu` (`z-index: 999999 !important;`).
     - Tightened item padding and margins inside the dropdown for a sleeker profile so all items (Normal, Quote, Code, Header 1–Header 6) render completely on top and are fully visible.
- **Files Modified**:
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 12: Developer Public Detail Page 100% Dynamic Page UI Parity)

- **Requirements Completed**:
  1. **Dynamic Page UI Replication for Developer Public Detail Page (`/developer/{slug}`)**:
     - Upgraded `developers/show.blade.php` to match the exact frontend design system, stylesheets, fonts, and layout structure of `dynamic-page.blade.php` without modifying `dynamic-page.blade.php`.
  2. **Identical Section Ordering & Aesthetic**:
     - **Header & Navbar**: Full sticky header with Projects & Commercial dropdown menus, mobile navigation drawer, and "LIST YOUR PROPERTY" modal trigger.
     - **Hero Section**: `GolfHero` banner featuring the developer cover image, dark gradient overlay, developer SVG logo (with drop shadow), H1 (`$developer->h1 ?: $developer->name`), tagline (`$developer->tagline`), red "BOOK NOW" button, and the "REQUEST A CALL BACK" card with international phone selector.
     - **Short Content**: Rendered in a clean container directly beneath the Hero.
     - **Featured Property Cards**: Rendered with the exact same 460px luxury card design from `partials/page-communities.blade.php` (tags/badges, sold-out status, luxury preview thumbnail, title, location, and green "BOOK NOW" button) for all projects assigned to this developer in `featured_projects`.
     - **Long Content**: Rendered with identical typography and layout (`saimaContentCol`, `saimaDynamicContent`, `saimaLongContentBody`).
     - **Brand Green Headings (`#1a4731`)**: Configured all headings (H1 through H6) inside content blocks to display in the site-wide signature brand green (`#1a4731`).
     - **FAQs**: Rendered in the exact interactive accordion style matching `dynamic-page.blade.php` with brand green active state and animated chevron indicator.
     - **Footer & Interactions**: Full site footer with scroll-to-top button and client interaction scripts.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 13: Dedicated Developer Page Custom Layout with Sticky Sidebar & Centered Hero)

- **Requirements Completed**:
  1. **Centered Minimalist Hero (Developer Page Only)**:
     - Configured the Hero section to show **strictly only** the Developer H1 title and Tagline beneath it, centered horizontally and vertically.
     - Removed all buttons, forms, and logos from the Hero section.
  2. **Two-Column Top Layout with Sticky Sidebar (Short Content + Cards on Left, Sidebar on Right)**:
     - **Left Column**:
       - Developer **Short Content** with an automatic **Read More ↓** link at the end that smoothly scrolls down to the Long Content section (`#longContent`).
       - Developer **Featured Project Cards** grid matching the luxury cards design.
     - **Right Column (Sticky Sidebar)**:
       - Developer **SVG Logo** placed directly on top of the form.
       - **Request A Call Back** form card with fields for name, email, and phone.
       - **Latest Projects** card beneath the form displaying the latest active projects with thumbnail, title, and location.
       - Sticky positioning (`position: sticky; top: 90px;`): stays in view while browsing short content and project cards, and naturally scrolls away as soon as cards end and long content begins.
  3. **Full-Width Long Content & FAQs**:
     - Full-width Long Content section beneath the two-column cards section with brand green (`#1a4731`) headings.
     - FAQs accordion section beneath long content with brand green active states.
     - Site footer and interaction scripts.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 14: Inline Read More, Original Hero Image Colors & Dynamic Sticky Sidebar with Scrollbar)

- **Requirements Completed**:
  1. **Inline Read More Placement**:
     - Moved the `Read More ↓` link from a separate newline container to sit directly **inline at the end of the short content text** (inside the ending paragraph tag).
     - Does not break onto a new line, keeping the reading flow natural and seamless.
  2. **Original Hero Image Color (No Green Tint)**:
     - Replaced the green-tinted overlay (`rgba(10, 26, 17, ...)`) with a neutral photographic gradient (`rgba(0, 0, 0, 0.40)` to `rgba(0, 0, 0, 0.60)`).
     - The hero cover image now preserves its authentic original colors with zero color alteration or green cast.
  3. **Dynamic Page Sticky Sidebar Parity**:
     - Upgraded the developer page right sidebar to match `partials/article.blade.php`:
       - `position: sticky; top: 90px; max-height: calc(100vh - 110px);`
       - Integrated custom slim vertical scrollbar (`::-webkit-scrollbar` with `#cbd5e1` thumb) allowing independent internal scrolling.
       - Full `BOOK AN APPOINTMENT` card with name, phone, email, and comments textarea with AJAX form submission.
       - Developer SVG logo placed above the form card, and Latest Projects list below the form.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 15: CMS-Managed FAQ Heading & Subtitle for Developers)

- **Requirements Completed**:
  1. **CMS Fields for FAQ Heading & Subtitle**:
     - Added new fields `FAQ Heading` and `FAQ Subtitle` to the Developer FAQs tab in both `create.blade.php` and `edit.blade.php`.
     - Admins can now customize the main heading (e.g. `Frequently Asked Questions`) and explanatory subtitle (e.g. `Got questions about [Developer Name]? Find helpful answers below.`) directly from the CMS.
  2. **Backend Controller & Model Updates**:
     - Added `faq_heading` (string, nullable) and `faq_subtitle` (text, nullable) columns to the `developers` table via database migration `2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table`.
     - Updated `Developer` Eloquent model `$fillable` array.
     - Updated `DeveloperController@store` and `DeveloperController@update` to capture and persist both fields.
  3. **Frontend Dynamic Rendering**:
     - Updated `developers/show.blade.php` to dynamically display `$developer->faq_heading` and `$developer->faq_subtitle` on the public developer detail page.
     - Clean fallback support: If left blank in the CMS, defaults smoothly to `Frequently Asked Questions` and the standard developer-specific help text.
- **Files Modified**:
  - `database/migrations/2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table.php` (New)
  - `app/Models/Developer.php`
  - `app/Http/Controllers/Admin/DeveloperController.php`
  - `resources/views/admin/developers/create.blade.php`
  - `resources/views/admin/developers/edit.blade.php`
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: Created and executed `2026_11_13_134516_add_faq_heading_and_subtitle_to_developers_table`.
  - Database Tables: Added `faq_heading` and `faq_subtitle` to `developers` table.


## Changelog — 2026-11-13 (Part 16: Navbar DEVELOPER Link & Dedicated Static Developers Main Page)

- **Requirements Completed**:
  1. **Navbar Integration (`DEVELOPERS` Link)**:
     - Added `DEVELOPERS` navigation link right beside `COMMERCIAL` in the desktop navbar and mobile drawer across:
       - `resources/views/partials/header.blade.php`
       - `resources/views/dynamic-page.blade.php`
       - `resources/views/developers/show.blade.php`
     - Added dedicated route `/developers` in `routes/web.php` with 301 redirection from legacy `/developer`.
  2. **Dedicated Static Public Developers Main Page (`/developers`)**:
     - Created `resources/views/developers/index.blade.php` inheriting the standard layout (`layouts.app`).
     - **Static Hero Section**:
       - Background image: `develoepr_main_hero_image.jpeg` from `public/` directory.
       - Centered Heading: `Real Estate Developers in Pakistan`
       - Centered Paragraph: `Discover the Developers Shaping Pakistan's Real Estate Landscape`
       - Preserved original photographic tones with a neutral dark overlay (no green cast).
       - Only the heading and paragraph are displayed in the hero section.
     - **Stats Bar Beneath Hero** (matching uploaded reference):
       - Full-width white section with 3 counter items:
         1. **566** `Property Developers`
         2. **Verified** `Listed Development Projects`
         3. **Regularly** `Updated Developer Profiles`
       - Styled with prominent bold numbers/status and clean muted grey descriptions, with responsive stacking for mobile devices.
- **Files Modified**:
  - `routes/web.php`
  - `resources/views/developers/index.blade.php` (New)
  - `resources/views/partials/header.blade.php`
  - `resources/views/dynamic-page.blade.php`
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 17: Featured Developers Cards Section on Developers Main Page)

- **Requirements Completed**:
  1. **Dynamic Database Fetching for Developers Main Page**:
     - Updated route `/developers` in `routes/web.php` to query all active developers (`status != 'draft'`).
     - Ordered by `id desc` (`orderBy('id', 'desc')`) so any newly created developer detail page immediately surfaces on top.
  2. **Featured Developers Section Design & Parity**:
     - Section Header:
       - Heading: `Featured Developers` in black (`#000000`).
       - Subtitle: `Discover some of Pakistan's recognised real estate developers and development companies Cards` in black (`#000000`).
     - Developer Cards (matching reference image `media_1794579971457_2e1e6347.jpg`):
       - **Left Column**: Developer cover image with rounded corners (`border-radius: 14px`) and an overlaid white floating badge at the bottom-left holding the developer's SVG/image logo.
       - **Right Column**:
         - H1 Developer title linking to `/developer/{slug}`.
         - Short content excerpt rendered cleanly.
         - Omitted the `218 Live projects` counter as explicitly requested.
         - Thin horizontal divider.
         - `View Developer ↗` blue button on the right navigating to the developer detail page.
       - Smooth hover elevations and mobile-friendly responsive layout.
- **Files Modified**:
  - `routes/web.php`
  - `resources/views/developers/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 18: Editorial Long Content Section on Developers Main Page)

- **Requirements Completed**:
  1. **Comprehensive Editorial Content Integration**:
     - Added the complete structured editorial content directly beneath the Featured Developers cards section on `resources/views/developers/index.blade.php`.
     - Structured with semantic HTML (`article`, `h2`, `h3`, `h4`, `p`, `ul`, `li`):
       - **Section 1**: Real Estate Development in Pakistan & Developer Categories list (with bullet circles/discs).
       - **Section 2**: Why Choose the Right Property Developer in Pakistan? (Key factors 1 to 6).
       - **Section 3**: How to Choose a Property Developer in Pakistan (Step-by-step guide Steps 01 to 05).
       - **Section 4**: Residential vs. Commercial Property Developers (Segment breakdowns).
       - **Section 5**: Popular Real Estate Markets in Pakistan (Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Multan, Peshawar, Gwadar).
       - **Section 6**: Leading Real Estate Developers in Pakistan (Bahria Town, DHA, Habib Rafiq Group, Zameen Developments, FDHL, Royal Developers, Lake City).
  2. **Strict Site-Wide Styling Parity**:
     - Heading colors styled with signature `#1a4731` green matching all pages.
     - Heading hierarchy: H2 (`26px`, bold), H3 (`20px`, bold), H4 (`17.5px`, bold).
     - Paragraphs: `16px` font size, `1.85` line-height, `#374151` dark neutral color.
     - Unordered lists: Custom disc and nested circle bullet markers with clean indentations and spacing.
- **Files Modified**:
  - `resources/views/developers/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 19: Site-Wide Accordion FAQs Section on Developers Main Page)

- **Requirements Completed**:
  1. **FAQ Section Integration on Developers Main Page (`/developers`)**:
     - Added the complete 11 interactive FAQs directly beneath the editorial long content section in `resources/views/developers/index.blade.php`.
     - Target section anchor `#faq` matches the navigation link in the site header.
     - Section Header:
       - Heading: `Frequently Asked Questions` styled in `#1a4731` green (`32px`, bold).
       - Subtitle: `Frequently Asked Questions About Real Estate Developers in Pakistan` (`#666`, `15px`).
  2. **11 Verified FAQs Structured**:
     - Q1: What is a real estate developer?
     - Q2: Who are the leading property developers in Pakistan?
     - Q3: How can I find property developers in Pakistan?
     - Q4: How can I verify a property developer?
     - Q5: What is the difference between a developer and a housing society?
     - Q6: Are all housing societies in Pakistan approved?
     - Q7: What information should I check before choosing a developer?
     - Q8: Can I compare different property developers online?
     - Q9: Do property developers offer instalment plans?
     - Q10: Can overseas Pakistanis explore property developers in Pakistan?
     - Q11: How do I choose between residential and commercial developers?
  3. **Accordion Mechanism & Site-Wide Parity**:
     - Utilizes site component classes (`.faqSection`, `.faqContainer`, `.faqList`, `.faqItem`, `.faqQuestion`, `.faqIcon`, `.faqAnswer`).
     - Animated toggle with rotating icon (`+` to `x`), first item open by default, smooth animated expanding/collapsing.
- **Files Modified**:
  - `resources/views/developers/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 20: Reduced Paragraph Gaps & Line Height Optimization)

- **Requirements Completed**:
  1. **Paragraph Spacing & Line Height Adjustment**:
     - Reduced paragraph bottom margin from `16px` down to `8px - 10px` across editorial long content and developer detail pages.
     - Adjusted line-height from `1.85` to `1.62` for clean, tight reading ergonomics without excessive empty vertical gaps.
     - Headings margins optimized (H2: `30px 0 10px 0`, H3: `20px 0 8px 0`, H4: `16px 0 6px 0`) to maintain compact, balanced flow.
     - Unordered list item margin reduced to `5px` and list vertical margins to `10px 0 16px 0`.
  2. **Consistency Across Views**:
     - Synchronized paragraph spacing in both `resources/views/developers/index.blade.php` and `resources/views/developers/show.blade.php`.
- **Files Modified**:
  - `resources/views/developers/index.blade.php`
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 21: Paragraph Sentence Consolidation & Natural Flow)

- **Requirements Completed**:
  1. **Consolidated Sentence Flow (Eliminated Single-Line Paragraph Breaks)**:
     - Merged disjointed 1-sentence paragraph tags into natural, cohesive editorial paragraphs across all 6 long content sections in `resources/views/developers/index.blade.php`:
       - Combined city descriptions (Karachi, Lahore, Islamabad, Rawalpindi, Faisalabad, Multan, Peshawar, Gwadar) from two broken `<p>` tags into unified paragraphs.
       - Consolidated development factors, evaluation steps, and property segments into clean narrative blocks.
     - Completely eliminated the unwanted empty gaps between single lines.
  2. **Fine-Tuned Heading-to-Paragraph Spacing**:
     - Added adjacent sibling margin overrides (`h2 + h3 { margin-top: 4px; }`, `h3 + p { margin-top: 4px; }`, `h4 + p { margin-top: 4px; }`).
     - Balanced paragraph line-height (`1.65`) and margin-bottom (`14px`) for optimal readability.
- **Files Modified**:
  - `resources/views/developers/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 22: Removed Sidebar Scrollbar on Developer Detail Page)

- **Requirements Completed**:
  1. **Removed Sidebar Internal Scrollbar**:
     - Updated `.saimaStickySidebar` in `resources/views/developers/show.blade.php`:
       - Removed `overflow-y: auto`, `max-height: calc(100vh - 110px)`, and `overscroll-behavior`.
       - Removed custom `::-webkit-scrollbar` styling and right padding.
     - The appointment form and sidebar elements now render straight down cleanly with no scrollbar.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 23: Synchronized Sticky Form Duration with Project Cards)

- **Requirements Completed**:
  1. **Strict Sticky Sidebar Lifetime Tied to Project Cards**:
     - Updated `.devMainLayout` with `align-items: stretch; position: relative;`.
     - Updated `.devSidebarCol` with `align-self: stretch; height: 100%; position: relative;` so the sidebar container exactly spans the full height of the left column (short content + all featured project cards).
     - As user scrolls, `.saimaStickySidebar` stays fixed at `top: 90px` alongside the cards.
     - As soon as the project cards end, the parent container boundaries are reached, and the sticky form naturally scrolls away out of view as long content begins.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 24: Updated Header Search Engine Verifications & GA4/GTM Scripts)

- **Requirements Completed**:
  1. **Site-Wide Header SEO & Analytics Update**:
     - Updated `resources/views/partials/seo-head-scripts.blade.php`, which is included across the entire website (`layouts/app.blade.php`, `dynamic-page.blade.php`, `developers/show.blade.php`, `developers/index.blade.php`, `welcome.blade.php`).
     - **Google Search Console**: `<meta name="google-site-verification" content="y1noJOhSDc2Z8nuDupa_uCByiBdHsimXEc9FhurNqFc" />`
     - **Bing Webmaster**: `<meta name="msvalidate.01" content="E65C761395C7D12E4A6CFCB1B51CD0E8" />`
     - **Yandex Verification**: `<meta name="yandex-verification" content="334d714fee991fab" />`
     - **GA4 / Google Tag Manager**:
       - Container ID: `GTM-TC468P78`
       - Async loader and dataLayer initialization snippet included.
- **Files Modified**:
  - `resources/views/partials/seo-head-scripts.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 25: CSS Grid Architecture for Robust Sticky Sidebar Duration)

- **Requirements Completed**:
  1. **Fixed Sticky Sidebar Sticking Duration**:
     - Refactored `.devMainLayout` from Flexbox to CSS Grid (`display: grid; grid-template-columns: minmax(0, 1fr) 360px; gap: 40px; align-items: stretch;`).
     - In CSS Grid, `.devSidebarCol` formally spans 100% of the entire grid row height (dictated by the full length of the project cards).
     - Ensured `.saimaStickySidebar` stays stuck at `top: 90px` alongside all rows of project cards (Row 1, Row 2, Row 3).
     - Once the project cards row concludes, the grid container ends, allowing the sticky sidebar to naturally scroll up and out of view as the Long Content section enters.
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 26: Domain Migration to fsadvisory.pk in Sitemap, Developer Sitemaps, Unified Favicon & Compact Content Spacing)

- **Requirements Completed**:
  1. **Replaced Domain Across Sitemap, Robots.txt, .htaccess & System to `https://fsadvisory.pk`**:
     - Updated fallback domain in `app/Http/Controllers/SitemapController.php` (`getBaseUrl()` fallback: `https://fsadvisory.pk`).
     - Updated `public/robots.txt` Sitemap URL to `https://fsadvisory.pk/sitemap.xml`.
     - Updated `public/.htaccess` canonical redirect to `https://fsadvisory.pk/`.
     - Updated `seo_canonical_url` in `site_settings` database table to `https://fsadvisory.pk` and flushed cache.
     - Updated `app/helpers.php` line 532 schema URL to `https://fsadvisory.pk/`.
     - Updated `FooterSection` columns and copyright strings from `saimaprojects.com` to `fsadvisory.pk`.
  2. **Added Developers to Sitemap (`sitemap.xml`)**:
     - Added Developers directory page (`/developers`) to `/sitemap/page-sitemap.xml` with priority `0.8` and changefreq `weekly`.
     - Implemented dedicated `/sitemap/developer-sitemap.xml` in `SitemapController` that dynamically queries all active published developers (`is_active = true`, `status != 'draft'`) and outputs `/developer/{slug}` with proper `<lastmod>`, `<changefreq>weekly</changefreq>`, `<priority>0.8</priority>`.
     - Registered `/sitemap/developer-sitemap.xml` in root sitemap index (`/sitemap.xml`).
     - Registered routes in `routes/web.php` for `/sitemap/developer-sitemap.xml`, `/developer-sitemap.xml`, and 301 redirect.
  3. **Unified Favicon Consistency**:
     - Synced `public/favicon.ico` directly from `public/favicon.png` so browsers requesting `/favicon.ico` (such as in `view-source:` and `sitemap.xml`) receive the exact same icon as the UI and CMS.
     - Ensured all templates (`layouts/app.blade.php`, `admin/layouts/app.blade.php`, `dynamic-page.blade.php`, `developers/show.blade.php`) reference the unified favicon with cache-busting timestamps.
  4. **Fixed Developer Detail Page Sticky Form Behavior**:
     - Streamlined `.devMainLayout` and `.devSidebarCol` with clean CSS `position: sticky; top: 85px;` directly on the sidebar column.
     - Ensured the Appointment form stays sticky alongside all project cards as the user scrolls down through the cards.
     - The moment all project cards end, the layout container ends and the sticky sidebar smoothly scrolls away with the cards, allowing the content below (`#longContent`) to enter the view.
     - Removed any internal scrollbar from the appointment form so it is straight, sleek, and fully visible without truncation.
  5. **Adjusted Paragraph & Heading Line Gaps in Content**:
     - In `developers/index.blade.php` and `developers/show.blade.php`, tightened paragraph spacing (`margin: 0 0 6px 0`, `line-height: 1.52`) and heading gaps (`h2`, `h3`, `h4`) to eliminate excessive blank line spaces between sentences.
- **Files Modified**:
  - `public/robots.txt`
  - `public/.htaccess`
  - `app/Http/Controllers/SitemapController.php`
  - `routes/web.php`
  - `app/helpers.php`
  - `app/Models/FooterSection.php`
  - `public/favicon.ico`
  - `resources/views/developers/show.blade.php`
  - `resources/views/developers/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: `site_settings` updated `seo_canonical_url` to `https://fsadvisory.pk`; `footer_sections` updated links to `https://fsadvisory.pk`.


## Changelog — 2026-11-13 (Part 28: Developer Detail Long Content Background Changed to Pure White)

- **Requirements Completed**:
  1. **Developer Detail Long Content Background Color**:
     - Updated `#longContent` section background in `resources/views/developers/show.blade.php` from `#faf8f5` (warm light-pink tint) to pure `#ffffff` (White).
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-13 (Part 26: Domain Migration to fsadvisory.pk in Sitemap, Developer Sitemaps, Unified Favicon & Compact Content Spacing)

- **Requirements Completed**:
  1. **Replaced Domain Across Sitemap, Robots.txt, .htaccess & System to `https://fsadvisory.pk`**:
     - Updated fallback domain in `app/Http/Controllers/SitemapController.php` (`getBaseUrl()` fallback: `https://fsadvisory.pk`).
     - Updated `public/robots.txt` Sitemap URL to `https://fsadvisory.pk/sitemap.xml`.
     - Updated `public/.htaccess` canonical redirect to `https://fsadvisory.pk/`.
     - Updated `seo_canonical_url` in `site_settings` database table to `https://fsadvisory.pk` and flushed cache.
     - Updated `app/helpers.php` line 532 schema URL to `https://fsadvisory.pk/`.
     - Updated `FooterSection` columns and copyright strings from `saimaprojects.com` to `fsadvisory.pk`.
  2. **Added Developers to Sitemap (`sitemap.xml`)**:
     - Added Developers directory page (`/developers`) to `/sitemap/page-sitemap.xml` with priority `0.8` and changefreq `weekly`.
     - Implemented dedicated `/sitemap/developer-sitemap.xml` in `SitemapController` that dynamically queries all active published developers (`is_active = true`, `status != 'draft'`) and outputs `/developer/{slug}` with proper `<lastmod>`, `<changefreq>weekly</changefreq>`, `<priority>0.8</priority>`.
     - Registered `/sitemap/developer-sitemap.xml` in root sitemap index (`/sitemap.xml`).
     - Registered routes in `routes/web.php` for `/sitemap/developer-sitemap.xml`, `/developer-sitemap.xml`, and 301 redirect.
  3. **Unified Favicon Consistency**:
     - Synced `public/favicon.ico` directly from `public/favicon.png` so browsers requesting `/favicon.ico` (such as in `view-source:` and `sitemap.xml`) receive the exact same icon as the UI and CMS.
     - Ensured all templates (`layouts/app.blade.php`, `admin/layouts/app.blade.php`, `dynamic-page.blade.php`, `developers/show.blade.php`) reference the unified favicon with cache-busting timestamps.
  4. **Fixed Developer Detail Page Sticky Form Behavior**:
     - Streamlined `.devMainLayout` and `.devSidebarCol` with clean CSS `position: sticky; top: 85px;` directly on the sidebar column.
     - Ensured the Appointment form stays sticky alongside all project cards as the user scrolls down through the cards.
     - The moment all project cards end, the layout container ends and the sticky sidebar smoothly scrolls away with the cards, allowing the content below (`#longContent`) to enter the view.
     - Removed any internal scrollbar from the appointment form so it is straight, sleek, and fully visible without truncation.
  5. **Adjusted Paragraph & Heading Line Gaps in Content**:
     - In `developers/index.blade.php` and `developers/show.blade.php`, tightened paragraph spacing (`margin: 0 0 6px 0`, `line-height: 1.52`) and heading gaps (`h2`, `h3`, `h4`) to eliminate excessive blank line spaces between sentences.
- **Files Modified**:
  - `public/robots.txt`
  - `public/.htaccess`
  - `app/Http/Controllers/SitemapController.php`
  - `routes/web.php`
  - `app/helpers.php`
  - `app/Models/FooterSection.php`
  - `public/favicon.ico`
  - `resources/views/developers/show.blade.php`
  - `resources/views/developers/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: `site_settings` updated `seo_canonical_url` to `https://fsadvisory.pk`; `footer_sections` updated links to `https://fsadvisory.pk`.


## Changelog — 2026-11-13 (Part 28: Developer Detail Long Content Background Changed to Pure White)

- **Requirements Completed**:
  1. **Developer Detail Long Content Background Color**:
     - Updated `#longContent` section background in `resources/views/developers/show.blade.php` from `#faf8f5` (warm light-pink tint) to pure `#ffffff` (White).
- **Files Modified**:
  - `resources/views/developers/show.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-14 (Part 29: Developer Main Page Content Replacement & CMS Pages Exclusion)

- **Requirements Completed**:
  1. **Developer Main Page Content Replacement**:
     - Removed the old introductory text ("Real Estate Development in Pakistan") from `resources/views/developers/index.blade.php`.
     - Replaced the content section with the requested text starting with `Why Choose the Right Property Developer in Pakistan?`, followed by `How to Choose a Property Developer in Pakistan`, `Residential vs. Commercial Property Developers`, `Popular Real Estate Markets in Pakistan`, and `Leading Real Estate Developers in Pakistan`.
     - Removed the accidental trailing word "Cards" from the `Featured Developers` subtitle.
  2. **CMS Pages Tab Developer Exclusion**:
     - Explicitly excluded `developers` and `/developers` from `PageController.php` and `resources/views/admin/pages/index.blade.php`.
     - Ensured Developer directory is exclusively managed under its dedicated `Developer` CMS tab (`/admin/developers`) and will never appear under `/admin/pages`.
- **Files Modified**:
  - `resources/views/developers/index.blade.php`
  - `app/Http/Controllers/Admin/PageController.php`
  - `resources/views/admin/pages/index.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-14 (Part 30: "View Live Page" Button Added to Edit Developer Screen)

- **Requirements Completed**:
  1. **View Live Page Action Button on Edit Developer**:
     - Added `View Live Page` button right next to `Developers List` on the top action bar in `resources/views/admin/developers/edit.blade.php`.
     - Styled with matching admin design language (`dev-live-btn`: white card, sky-blue border `#bae6fd`, primary blue `#0284c7`, hover animation, and external link icon).
     - Opens the developer's public detail page (`/developer/{slug}`) in a new tab (`target="_blank" rel="noopener"`).
     - Added real-time JS synchronization so if the admin edits the `dev_slug` field, the link's `href` updates on the fly.
  2. **Admin Draft/Inactive Preview Support**:
     - Updated `/developer/{slug}` route in `routes/web.php` to allow logged-in administrators (`auth()->check()`) to preview developer detail pages even when in `draft` status or inactive, preventing premature 404 errors during review.
- **Files Modified**:
  - `resources/views/admin/developers/edit.blade.php`
  - `routes/web.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-14 (Part 31: Hardcoded "Saima" Meta Tags & Schema Migrated to "FS Real Estate Advisory")

- **Requirements Completed**:
  1. **Fixed Static Hardcoded Author & OG Site Name in Global Layout**:
     - Investigated source of SEO metadata reported by SEO team. Identified that `<meta name="author" content="Saima Group">` and `<meta property="og:site_name" content="Saima">` were 100% hardcoded in `resources/views/layouts/app.blade.php`.
     - Replaced both static tags with `content="FS Real Estate Advisory"`.
  2. **Fixed Static Hardcoded Keywords & Description Fallbacks**:
     - Updated fallback metadata in `resources/views/layouts/app.blade.php` to first read CMS `seo_default_keywords` and `seo_default_description` from `SiteSetting`, falling back to `FS Real Estate Advisory` keywords rather than old `Saima` keywords when a page in CMS has empty metadata.
  3. **Updated Schema Organization & RealEstateAgent Name in Helpers**:
     - In `app/helpers.php` (`render_header_schemas`), updated `$siteName` from `'Saima Projects'` to `'FS Real Estate Advisory'` so JSON-LD Structured Data reflects the new company.
  4. **Updated Dynamic & Developer Detail Title Fallbacks**:
     - In `dynamic-page.blade.php` and `developers/show.blade.php`, updated default title suffix from `' | Saima'` to `' | FS Real Estate Advisory'`.
     - In `developers/index.blade.php`, updated `@section('title')` to `'Real Estate Developers in Pakistan | FS Real Estate Advisory'`.
- **Files Modified**:
  - `resources/views/layouts/app.blade.php`
  - `resources/views/dynamic-page.blade.php`
  - `resources/views/developers/show.blade.php`
  - `resources/views/developers/index.blade.php`
  - `app/helpers.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-14 (Part 32: Navbar Active Underline Fixed to Current Page Only)

- **Requirements Completed**:
  1. **Fixed Dual Active Navbar Underline**:
     - In `resources/views/partials/header.blade.php`, the `HOME` navigation item previously had `class="navLink navLinkActive"` hardcoded statically, causing it to display an active underline on all pages including `/developers`.
     - Replaced hardcoded class with dynamic condition: `class="navLink {{ (request()->is('/') || request()->path() === '/') ? 'navLinkActive' : '' }}"`.
     - Ensured only the link corresponding to the current active route receives `.navLinkActive`:
       - Homepage (`/`): only HOME is active.
       - Developers (`/developers`, `/developer/*`): only DEVELOPERS is active.
       - Projects (`/project/*`): only PROJECTS is active.
       - Commercial (`/commercial/*`): only COMMERCIAL is active.
       - Contact Us (`/contact-us*`): only CONTACT US is active.
- **Files Modified**:
  - `resources/views/partials/header.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-14 (Part 33: CMS Sidebar Solid White Background & Thin Scrollbar)

- **Requirements Completed**:
  1. **Complete Solid White Sidebar Background**:
     - Applied solid `#ffffff` (`background: #ffffff !important; background-color: #ffffff !important;`) to `.adm-sidebar` and `.adm-sidebar-foot` across `public/css/admin.css` and `resources/views/admin/layouts/app.blade.php`.
     - Modernized `.adm-user` with a clean light slate card background (`#f8fafc`) and subtle border (`#e2e8f0`).
  2. **Slim Thin Custom Scrollbar (Patla Scrollbar)**:
     - Added `overflow-y: auto !important; max-height: 100vh !important;` to `.adm-sidebar` so all navigation items, site settings, and footer actions are smoothly accessible on any screen height without truncation.
     - Implemented an ultra-thin 4px custom scrollbar (`width: 4px;`) with a light rounded thumb (`#cbd5e1`) and pure white track (`#ffffff`), supporting both Webkit and Firefox standards (`scrollbar-width: thin`).
- **Files Modified**:
  - `public/css/admin.css`
  - `resources/views/admin/layouts/app.blade.php`
  - `README.md`
- **Database / Migrations**:
  - Migrations: None created or modified.
  - Database Tables: Schema unchanged.


## Changelog — 2026-11-20 (Part 104: Live Dynamic Community & City Location Synchronization Across Property Cards & Project Detail Headers)

### What Changed
- **Dynamic Community & City Accessor on Project Model (`app/Models/Project.php`):**
  - Added dynamic accessor `getLocationAttribute($value)` on `Project` model. When `community_id` is assigned to a project, it dynamically resolves the latest Community name and its linked City (`name, city.name`).
- **Automated Location Synchronization on Community Updates (`app/Http/Controllers/Admin/CommunityController.php`):**
  - In `CommunityController@update`, when a Community is assigned to a different City or its name changes, all linked projects in the `projects` table are automatically batch-updated with the fresh location string (`Community Name, City Name`).
- **Automated Location Synchronization on City Updates (`app/Http/Controllers/Admin/CityController.php`):**
  - In `CityController@update`, when a City is renamed or updated, all projects belonging to all communities within that City are automatically synchronized.
- **Automated Location Resolution on Project Save & Update (`app/Http/Controllers/Admin/ProjectController.php`, `PageController.php`):**
  - In both `ProjectController` and `PageController` (when editing a Project Detail page), saving or updating the project automatically determines the linked `community_id` and derives the formatted location string from the active Community model.
- **Project Detail Page Header Location Prioritization (`resources/views/partials/page-about.blade.php`):**
  - Updated `$projectComm` and `$projectCommName` in `page-about.blade.php` to directly prioritize `$projectComm->name . ($projectComm->city ? ', ' . $projectComm->city->name : '')`, ensuring that the header location sub-line immediately reflects any CMS community/city updates.
- **Database Synchronization of Existing Projects:**
  - Synchronized existing projects linked to community 27 (including *Saima Prestige Park*, *Saima Luxury Apartments*, *Saima ACE Avenue*, and *Saima Boulevard*) from stale `'test four, Islamabad'` to the active `'test four area, test first city'`.

### Files Modified
- app/Models/Project.php
- app/Http/Controllers/Admin/CommunityController.php
- app/Http/Controllers/Admin/CityController.php
- app/Http/Controllers/Admin/ProjectController.php
- app/Http/Controllers/Admin/PageController.php
- resources/views/partials/page-about.blade.php
- README.md


## Changelog — 2026-11-20 (Part 105: City Detail Page Community Card Styling Parity with Area Page)

### What Changed
- **City Community Cards Parity (`resources/views/cities/show.blade.php`):**
  - Updated `.cardCustom` height from `500px` to `460px`, `.bottomContent` padding to `35px 20px 22px`, `.cardTitle` to `21px`, `.cardLocation` to `13px`, `.devProjectsGrid` to `repeat(auto-fill, minmax(280px, 1fr))` with `24px` gap, and added `.topTags` / `.badgeTag` / `Sold out` badge markup matching `communities/show.blade.php`.
  - Updated `.cardBtnRow .cardWaBtn` to transparent with `#BFA16A` border and gold hover, matching Area page cards identically.

### Files Modified
- resources/views/cities/show.blade.php
- README.md


## Changelog — 2026-11-20 (Part 106: Project Detail Section Title Visibility & Global CMS Clear/Save Rule)

### What Changed
- **Section Title Rendering on Project Detail Page (`resources/views/partials/page-payment-plan.blade.php`, `page-amenities.blade.php`):**
  - Updated Payment Plan and Amenities section visibility guards to render when Section Title has text even if cards/images are empty, and hide cleanly when cleared.
- **Global CMS Clear/Save Persistence (`app/Http/Controllers/Admin/PageController.php`, `app/helpers.php`, `resources/views/admin/pages/edit.blade.php`):**
  - Persisted cleared form fields (`null`) as explicit empty strings (`''`) in `PageController` instead of `null`, synced legacy alias keys (`title`/`heading`), updated `page_section()` to respect explicitly cleared empty strings, and switched CMS default value fallbacks in `edit.blade.php` to `array_key_exists` so removing text and clicking Save removes it from both CMS inputs and frontend UI.

### Files Modified
- app/Http/Controllers/Admin/PageController.php
- app/helpers.php
- resources/views/admin/pages/edit.blade.php
- resources/views/partials/page-payment-plan.blade.php
- resources/views/partials/page-amenities.blade.php
- README.md


## Changelog — 2026-11-20 (Part 107: City & Community Clean Slug Reuse & Duplicate Blocking)

### What Changed
- **Strict Active-List Duplicate Blocking & Clean Slug Reuse (`app/Http/Controllers/Admin/CityController.php`, `CommunityController.php`):**
  - Updated `store()` and `update()` in both `CityController` and `CommunityController` to check uniqueness strictly against existing active rows in `cities` / `communities` tables (blocking duplicates with a clear validation error instead of silently appending `-1` or `-17`).
  - Kept clean slugs (`lahore`, `islamabad`, etc.) on `cities.slug` and `communities.slug`, isolating linked `pages.slug` (`city/{slug}` / `area/{slug}`) only when an unrelated page exists in `pages`.
  - Updated `CommunityController@destroy()` to also delete linked page sections before deleting the page.
  - Fixed existing slugs in DB: `lahore-17` -> `lahore` and `islamabad-1` -> `islamabad`.

### Files Modified
- app/Http/Controllers/Admin/CityController.php
- app/Http/Controllers/Admin/CommunityController.php
- README.md


## Changelog — 2026-11-20 (Part 108: Summernote Normal Body Text Light-Black #2B2B2B & 14.5px Open Sans Alignment)

### What Changed
- **Summernote Normal Text Styling Parity (`article.blade.php`, `page-article.blade.php`, `page-article-summernote.blade.php`, `page-about.blade.php`, `communities/show.blade.php`, `cities/show.blade.php`, `admin/layouts/app.blade.php`):**
  - Unified all Summernote normal paragraph/body text (both frontend UI and CMS `.note-editable` editor) to `#2B2B2B` light black, `14.5px` `'Open Sans'`, `line-height: 1.6`, `font-weight: 400`, matching `.fsFeaturesAmenitiesSubtitle` identically while preserving golden `#BFA16A` headings and links.

### Files Modified
- resources/views/partials/article.blade.php
- resources/views/partials/page-article.blade.php
- resources/views/partials/page-article-summernote.blade.php
- resources/views/partials/page-about.blade.php
- resources/views/communities/show.blade.php
- resources/views/cities/show.blade.php
- resources/views/admin/layouts/app.blade.php
- README.md


## Changelog — 2026-11-20 (Part 109: Lead Webhook sub_source Updated to fsadvisory.pk)

### What Changed
- **Lead Submission sub_source Standardization (`LeadController.php` & Frontend Form Handlers):**
  - Updated the outgoing lead webhook payload and frontend form handlers from `sub_source: 'saima project'` to `sub_source: 'fsadvisory.pk'`. All leads dispatched to the CRM webhook now accurately carry `fsadvisory.pk` as their `sub_source`.

### Files Modified
- app/Http/Controllers/LeadController.php
- public/js/communities/community-interactions.js
- resources/views/about-us.blade.php
- resources/views/blogs/show.blade.php
- resources/views/contact-us.blade.php
- resources/views/layouts/app.blade.php
- resources/views/partials/article.blade.php
- resources/views/partials/contact.blade.php
- resources/views/partials/hero.blade.php
- resources/views/partials/page-article.blade.php
- README.md


## Changelog — 2026-11-20 (Part 110: Clean Slug Enforcement & Orphan Page Resolution for Cities & Communities)

### What Changed
- **City & Community Clean Slug Assurance (`CityController.php` & `CommunityController.php`):**
  - Removed legacy `while (Page::where('slug', $uniqueSlug)->exists())` loop which was unintentionally appending `-1`, `-2` to new city/community slugs.
  - Added duplicate validation against active lists: if a city or community already exists with the same name or slug, the CMS returns a clear validation error blocking duplicates.
  - Added automated cleanup for orphaned/unlinked pages left behind by earlier deletions: if an old unlinked page with that slug exists, it is cleanly recycled so the new city or community receives the exact clean slug (e.g. `/city/lahore`).
  - Fixed existing city record in database (`id: 21` slug updated from `lahore-1` to `lahore`).

### Files Modified
- app/Http/Controllers/Admin/CityController.php
- app/Http/Controllers/Admin/CommunityController.php
- README.md


## Changelog — 2026-11-23 (Part 111: Project Detail Page Summary Heading H1 to H2)

### What Changed
- **Project Detail Page Heading Semantic Update (`page-about.blade.php`):**
  - Updated auto project title below the hero banner from `<h1>` to `<h2>` (`<h2 class="fsProjectSummaryTitle">`), resolving SEO duplicate H1 tags while retaining the exact same visual styling and responsive layout.

### Files Modified
- resources/views/partials/page-about.blade.php
- README.md


## Changelog — 2026-11-23 (Part 112: Developer Detail Page Footer Dynamic Projects Filtering)

### What Changed
- **Developer Detail Page Footer Projects Integration (`footer.blade.php`):**
  - Updated the contextual footer resolution on developer detail pages (`/developer/{slug}`) to query and display the latest 10 active projects linked to that developer (via `developer_id`, brand keyword, developer name match, or assigned featured projects).
  - The middle footer column header now dynamically reads `[Developer] Projects` (e.g. "Saima Projects", "Al Ghafour Projects"), with each item directly linking to its respective `/project/{slug}` detail page.

### Files Modified
- resources/views/partials/footer.blade.php
- README.md


## Changelog — 2026-11-23 (Part 113: Area / Community Detail Page Footer Dropdown Projects Filtering)

### What Changed
- **Area / Community Detail Page Footer Contextual Projects (`footer.blade.php`):**
  - Updated the contextual footer resolution on Area / Community detail pages (`/area/{slug}`).
  - Instead of listing other areas, the footer now specifically queries and displays only the projects that were assigned to that community via the CMS dropdown (`community_id`), or selected in featured projects.
  - The column header now reads `[Area Name] Projects` (e.g. `Gulberg Projects`), with each link opening the corresponding `/project/{slug}` detail page.

### Files Modified
- resources/views/partials/footer.blade.php
- README.md


## Changelog — 2026-11-23 (Part 114: City Detail Page Footer Dynamic Communities Filtering)

### What Changed
- **City Detail Page Footer Communities Integration (`footer.blade.php`):**
  - Updated the contextual footer resolution on City detail pages (`/city/{slug}`).
  - The footer now dynamically displays only the communities / areas that were assigned to that city via the CMS dropdown (`communities.city_id == $currCity->id`), or selected in the city's featured communities.
  - The column header now reads `[City Name] Areas` (e.g. `Lahore Areas`, `Karachi Areas`), with each item directly linking to its `/area/{slug}` detail page.

### Files Modified
- resources/views/partials/footer.blade.php
- README.md


## Changelog — 2026-11-23 (Part 115: Default Draft Status on Creation & Public 404 Protection for 5 Entities)

### What Changed
- **Default Draft Status for All 5 Page Types on Creation**:
  - **Dynamic Pages (`Page`)**: Form status defaults to `draft`. `PageController::store` strictly enforces `status = 'draft'` and `is_published = false` unless explicitly changed.
  - **Project Detail Pages (`Project`)**: In `resources/views/admin/projects/index.blade.php`, the create property status dropdown is now set to `draft` by default (styled in draft badge styling), and the `is_published` checkbox default has been unchecked. `ProjectController::store` sets both the project card and linked page to `status = 'draft'`, `is_active = false`, and `is_published = false`.
  - **City Detail Pages (`City`)**: Create form dropdown defaults to `draft`. `CityController::store` enforces `status = 'draft'`, `is_active = false`, and linked page `is_published = false`.
  - **Area / Community Detail Pages (`Community`)**: Create form dropdown defaults to `draft`. `CommunityController::store` enforces `status = 'draft'`, `is_active = false`, and linked page `is_published = false`.
  - **Developer Detail Pages (`Developer`)**: Create form dropdown defaults to `draft`. `DeveloperController::store` enforces `status = 'draft'` and `is_active = false`.
- **Strict Public UI 404 Protection (`routes/web.php`)**:
  - Enforced strict `abort(404)` on public routes for all 5 entities whenever `status === 'draft'` or inactive (`!is_active` / `!is_published`):
    - `/{slug}` (Dynamic custom pages)
    - `/project/{slug}` (Project detail pages)
    - `/city/{slug}` (City detail pages)
    - `/area/{slug}` (Area / Community detail pages)
    - `/developer/{slug}` (Developer detail pages)
  - Excluded draft entities from all public listings, footer links, navigation dropdowns, and sidebar widgets.

### Files Modified
- app/Http/Controllers/Admin/PageController.php
- app/Http/Controllers/Admin/ProjectController.php
- resources/views/admin/projects/index.blade.php
- resources/views/partials/footer.blade.php
- resources/views/partials/sidebar-form-widget.blade.php
- routes/web.php
- README.md


## Changelog — 2026-11-23 (Part 114: City Detail Page Footer Dynamic Communities Filtering)

### What Changed
- **City Detail Page Footer Communities Integration (`footer.blade.php`):**
  - Updated the contextual footer resolution on City detail pages (`/city/{slug}`).
  - The footer now dynamically displays only the communities / areas that were assigned to that city via the CMS dropdown (`communities.city_id == $currCity->id`), or selected in the city's featured communities.
  - The column header now reads `[City Name] Areas` (e.g. `Lahore Areas`, `Karachi Areas`), with each item directly linking to its `/area/{slug}` detail page.

### Files Modified
- resources/views/partials/footer.blade.php
- README.md


## Changelog — 2026-11-23 (Part 115: Default Draft Status on Creation & Public 404 Protection for 5 Entities)

### What Changed
- **Default Draft Status for All 5 Page Types on Creation**:
  - **Dynamic Pages (`Page`)**: Form status defaults to `draft`. `PageController::store` strictly enforces `status = 'draft'` and `is_published = false` unless explicitly changed.
  - **Project Detail Pages (`Project`)**: In `resources/views/admin/projects/index.blade.php`, the create property status dropdown is now set to `draft` by default (styled in draft badge styling), and the `is_published` checkbox default has been unchecked. `ProjectController::store` sets both the project card and linked page to `status = 'draft'`, `is_active = false`, and `is_published = false`.
  - **City Detail Pages (`City`)**: Create form dropdown defaults to `draft`. `CityController::store` enforces `status = 'draft'`, `is_active = false`, and linked page `is_published = false`.
  - **Area / Community Detail Pages (`Community`)**: Create form dropdown defaults to `draft`. `CommunityController::store` enforces `status = 'draft'`, `is_active = false`, and linked page `is_published = false`.
  - **Developer Detail Pages (`Developer`)**: Create form dropdown defaults to `draft`. `DeveloperController::store` enforces `status = 'draft'` and `is_active = false`.
- **Strict Public UI 404 Protection (`routes/web.php`)**:
  - Enforced strict `abort(404)` on public routes for all 5 entities whenever `status === 'draft'` or inactive (`!is_active` / `!is_published`):
    - `/{slug}` (Dynamic custom pages)
    - `/project/{slug}` (Project detail pages)
    - `/city/{slug}` (City detail pages)
    - `/area/{slug}` (Area / Community detail pages)
    - `/developer/{slug}` (Developer detail pages)
  - Excluded draft entities from all public listings, footer links, navigation dropdowns, and sidebar widgets.

### Files Modified
- app/Http/Controllers/Admin/PageController.php
- app/Http/Controllers/Admin/ProjectController.php
- resources/views/admin/projects/index.blade.php
- resources/views/partials/footer.blade.php
- resources/views/partials/sidebar-form-widget.blade.php
- routes/web.php
- README.md


## Changelog — 2026-11-23 (Part 116: Mobile Navbar Horizontal Scroll Fix, Desktop Drawer Isolation, & Blog Default Draft Status)

### What Changed
- **Mobile Navbar Horizontal Scroll Removal & Layout Adjustment (`header.blade.php`, `saima.css`)**:
  - Replaced off-screen `right: -100%` positioning on `.mobileDrawer` with GPU-accelerated `transform: translateX(105%)`, `right: 0`, and `visibility: hidden; pointer-events: none;`.
  - Added strict `overflow-x: hidden !important;` and `max-width: 100% !important;` to `html, body` and `overflow-x: clip` to `.header`, eliminating the unwanted horizontal scrollbar under the navbar on mobile devices.
- **Desktop Mobile Drawer Display Fix (`header.blade.php`, `saima.css`)**:
  - Added `@media (min-width: 1025px)` rules enforcing `display: none !important; visibility: hidden !important; opacity: 0 !important; pointer-events: none !important;` for `.mobileDrawer`, `#mobileDrawer`, `.mobileDrawerOverlay`, and `#mobileBackdrop`.
  - Added a `window.addEventListener('resize')` listener in `header.blade.php` to immediately close and reset the mobile drawer whenever the viewport is resized to desktop (such as when DevTools inspect is closed).
- **Default Draft Status for New Blogs (`admin/blogs/index.blade.php`)**:
  - Updated the Blog creation form top status badge and hidden input default from `publish` to `draft` (`status = 'draft'`), displaying the amber `#f59e0b` Draft pill by default.
  - New blogs are saved as draft by default, excluded from `/blogs` list, and protected with strict 404 until manually published.

### Files Modified
- resources/views/admin/blogs/index.blade.php
- resources/views/partials/header.blade.php
- public/css/saima.css
- README.md


## Changelog — 2026-11-23 (Part 117: Mobile Drawer Close Button Alignment & Dropdown Chevrons Crisp White Visibility)

### What Changed
- **Mobile Drawer Close Button Left Alignment (`header.blade.php`, `saima.css`)**:
  - Added `margin-right: 10px !important;`, `min-width: 36px;`, and `flex-shrink: 0;` to `#mobileDrawerClose`, pulling the circular close button slightly inward to the left so it is completely visible, well-padded, and never clipped or cut off by the drawer edge.
- **Mobile Dropdown Chevron Icons Crisp White Color (`header.blade.php`, `saima.css`)**:
  - Set explicit `stroke: #ffffff !important;` and `color: #ffffff !important;` on `#mobileChevronIcon`, `#mobileCommChevronIcon`, `#mobileDevChevronIcon`, and their child SVG paths.
  - Increased chevron icon dimensions to 18x18px with `stroke-width="2.5"`, ensuring high-contrast, crystal-clear visibility against the dark navy mobile navigation background.

### Files Modified
- resources/views/partials/header.blade.php
- public/css/saima.css
- README.md


## Changelog — 2026-11-23 (Part 118: Universal Phone Flag Selector Pakistan Default & Reliable Country Detection)

### What Changed
- **Resolved US Flag Override Across Global Website**:
  - Investigated the root cause of the American flag (🇺🇸 `+1`) automatically overwriting phone inputs on the website: a legacy background fetch (`checkIpCountryAsync`) in `universal-phone-selector.js` was querying an external IP API (`api.country.is`) which, when the user visited with an active VPN or proxy set to US, returned `country: 'US'` and forcefully overrode all phone inputs across the website with the US flag.
  - Purged obsolete sessionStorage/localStorage cache key `hudayriyat_user_country` and migrated to `fs_advisory_active_country`.
  - Added device timezone resolution via `Intl.DateTimeFormat().resolvedOptions().timeZone` with first-priority mapping for Pakistan (`Asia/Karachi`, `Asia/Islamabad`, etc. -> `pk`).
  - Guarded against proxy/VPN overwriting: when the user's device timezone matches Pakistan or another definitive country, the background IP check is strictly prevented from overriding it with a VPN IP.
  - Default fallback for `getCountryByCode` and `detectInitialCountry` changed from `ae` to `pk` (Pakistan, 🇵🇰 `+92`).
  - Added `sessionStorage.setItem('fs_country_manual', code)` whenever the user manually selects any country from the dropdown, ensuring their explicit choice is never overridden.
- **Server-Side Blade Templates Updated to Pakistan (`+92`)**:
  - Replaced hardcoded UAE SVG flags and `value="+971 "` across all blade form views with the crisp Pakistan flag image and `value="+92 "` (with placeholder `+92 300 1234567`):
    - `resources/views/partials/hero.blade.php` (Homepage hero callback form)
    - `resources/views/partials/contact.blade.php` (Contact form section)
    - `resources/views/partials/project-hero.blade.php` (Project detail modal request form)
    - `resources/views/partials/sidebar-form-widget.blade.php` (Sidebar appointment form)
    - `resources/views/partials/page-article.blade.php` (Article sidebar appointment form)
    - `resources/views/contact-us.blade.php` (Contact Us page form)
    - `resources/views/about-us.blade.php` (About Us page form)
    - `resources/views/layouts/app.blade.php` (Global 'List Your Property' modal form)

### Files Modified
- public/js/universal-phone-selector.js
- resources/views/partials/hero.blade.php
- resources/views/partials/contact.blade.php
- resources/views/partials/project-hero.blade.php
- resources/views/partials/sidebar-form-widget.blade.php
- resources/views/partials/page-article.blade.php
- resources/views/contact-us.blade.php
- resources/views/about-us.blade.php
- resources/views/layouts/app.blade.php
- README.md


## Changelog — 2026-11-23 (Part 119: Project Detail Dummy Developer/Community Removal & Automatic Deletion Hook)

### What Changed
- **Removal of Dummy Developer / Community Placeholder on Project Detail Page**:
  - In `app/Models/Project.php`, updated `getDeveloperAttribute()`: removed legacy fallback `'Modon Properties'`. If no developer is linked or if dummy text is found, it cleanly returns `null`.
  - In `resources/views/partials/page-about.blade.php`, updated Developer and Community resolution:
    - If no Developer is chosen in CMS, `$projectDevName` is empty and developer metadata is completely hidden.
    - If no Community is chosen in CMS, `$projectCommName` is empty and community metadata is completely hidden.
    - Wrapped the metadata row (`.fsProjectSummaryMeta`) in `@if(!empty($projectDevName) || !empty($projectCommName))`. If neither is selected, the line is omitted entirely from the UI with zero dummy text.
- **Model Deletion Hooks for Developer & Community (`Developer.php`, `Community.php`)**:
  - Added Eloquent `booted()` deleting lifecycle hooks:
    - When a `Developer` is deleted, any project linked via `developer_id` or `developer` name has both fields automatically cleared (`null`).
    - When a `Community` is deleted, any project linked via `community_id` has both `community_id` and `location` automatically cleared (`null`).
- **Database Cleanup**:
  - Ran migration script updating all 13 legacy project records where dummy `developer = 'Modon Properties'` was saved to `null`.

### Files Modified
- app/Models/Project.php
- app/Models/Developer.php
- app/Models/Community.php
- resources/views/partials/page-about.blade.php
- README.md


## Changelog — 2026-11-23 (Part 120: Global Mobile Responsive Sticky Bottom Bar with Register Now Modal & Page-Aware WhatsApp)

### What Changed
- **Global Sticky Bottom Bar on Mobile Devices (`layouts/app.blade.php`)**:
  - Added `#fsMobileStickyBottomBar` fixed at screen bottom (`position: fixed; bottom: 0; left: 0; right: 0; z-index: 99990;`).
  - Added strict desktop isolation: on laptops and desktops, `#fsMobileStickyBottomBar` is completely hidden with `display: none !important;`.
  - On mobile responsive (`@media (max-width: 768px)`), displays two full-width side-by-side action buttons:
    1. **REGISTER NOW**: Luxury bronze `#BFA16A` button with user registration icon.
    2. **WHATSAPP**: Vibrant green `#25D366` button with official WhatsApp SVG icon.
  - Added mobile body bottom padding (`padding-bottom: 64px !important;`) and adjusted `#scrollTopBtn` (`bottom: 74px !important;`) to prevent sticky bar overlap.
- **Dedicated Register Modal (`#fsMobileStickyRegisterModal`)**:
  - Clicking "REGISTER NOW" opens an elegant modal with Full Name, Email Address, and Phone Number input with the Universal Flag Selector (defaulting to Pakistan 🇵🇰 `+92`).
  - Connected to `universal-phone-selector.js` via `mobileStickyCountryBtn` / `mobileStickyCountryDropdown`.
  - AJAX submit handler sends lead to `/api/leads` with source `'Mobile Sticky Bottom Bar'`, page URL, and displays success message.
- **Dynamic Page-Aware WhatsApp Button**:
  - Clicking "WHATSAPP" executes `handleMobileStickyWhatsApp(event)`, dynamically resolving the current page's title and live URL (`window.location.href`).
  - Opens WhatsApp (`wa.me/923322495575`) with a pre-filled message: `"Hello FS Advisory, I am interested in [Page Title]. Please share details. [Page URL]"`.

### Files Modified
- resources/views/layouts/app.blade.php
- public/js/universal-phone-selector.js
- README.md


## Changelog — 2026-11-23 (Part 121: Phone Flag Pakistan Default Lock, Mobile Sticky Modal Isolation, & Draft Dropdown Exclusion)

### What Changed
- **Issue 1 — Pakistan Default Flag Lock (`public/js/universal-phone-selector.js`)**:
  - Disabled external IP geolocation override (`checkIpCountryAsync()`) and removed `en-US` browser language / US timezone fallbacks so VPN/proxy sessions cannot switch the phone selector to USA (`+1`).
  - Purged stale `sessionStorage` / `localStorage` keys (`hudayriyat_user_country`, `fs_advisory_active_country`, and stale `'us'` manual values) and defaulted strictly to Pakistan (🇵🇰 `+92`).
- **Issues 2 & 3 — Mobile Sticky Modal Strict Closed Default & Desktop/Inspect Isolation (`resources/views/partials/mobile-sticky-bar.blade.php`, `resources/views/layouts/app.blade.php`, `dynamic-page.blade.php`, `areas/show.blade.php`, `cities/show.blade.php`, `communities/show.blade.php`, `developers/show.blade.php`)**:
  - Extracted the mobile sticky bottom bar and Register modal into a reusable partial `resources/views/partials/mobile-sticky-bar.blade.php` included globally across all page layouts.
  - Removed conflicting CSS `display: flex !important` default and JS inline `!important` display overrides; `#fsMobileStickyRegisterModal` is strictly hidden by default (`display: none !important`) and opens ONLY when clicking "REGISTER NOW" at `<= 768px`.
  - Added both `@media (min-width: 769px)` CSS force-hide and `resize` / `matchMedia` listeners to automatically close the modal when DevTools inspect is closed or viewport expands to desktop.
- **Issue 4 — Draft Pages Excluded from All Dropdowns (`app/helpers.php`, `Admin/ProjectController.php`, `Admin/PageController.php`, `Admin/CommunityController.php`, `Admin/CityController.php`)**:
  - Updated `get_navbar_items()` and `get_navbar_developers()` in `app/helpers.php` to exclude any Project, Developer, or linked/matching Page with `status = 'draft'` or `is_published = false`.
  - Updated Admin CMS dropdown queries (`$pages`, `$projectPages`, `$allProjects`, `$communities`, `$developers`, `$cities`) so draft items do not appear in selection dropdowns until published.

### Files Modified
- public/js/universal-phone-selector.js
- resources/views/partials/mobile-sticky-bar.blade.php
- resources/views/layouts/app.blade.php
- resources/views/dynamic-page.blade.php
- resources/views/areas/show.blade.php
- resources/views/cities/show.blade.php
- resources/views/communities/show.blade.php
- resources/views/developers/show.blade.php
- app/helpers.php
- app/Http/Controllers/Admin/ProjectController.php
- app/Http/Controllers/Admin/PageController.php
- app/Http/Controllers/Admin/CommunityController.php
- app/Http/Controllers/Admin/CityController.php
- README.md


## Changelog — 2026-11-23 (Part 122: Complete Organization JSON-LD Schema Across All Page Headers)

### What Changed
- **Enriched Organization JSON-LD Schema (`app/helpers.php` — `render_header_schemas()`)**:
  - Upgraded the header `Organization` JSON-LD schema with complete Schema.org fields: `@context`, `@type: Organization`, `@id`, `name` (`FS Real Estate Advisory`), `alternateName` (`FS Advisory`), canonical `url`, `logo` (`ImageObject`), `image`, `description`, `telephone` (`+92-332-2495575`), `email` (`info@fsadvisory.pk`), `address` (`PostalAddress` — Karachi, PK), `areaServed` (`Pakistan`), `contactPoint` (`customer service`, English/Urdu), and dynamic `sameAs` social URLs from CMS Footer settings.
  - Added optional `?array $customFaqs` support in `render_header_schemas()` for entity detail pages.
- **Sitewide Header Schema Coverage**:
  - Verified `layouts/app.blade.php` and `dynamic-page.blade.php` render `render_header_schemas()` in `<head>`.
  - Added `{!! render_header_schemas(...) !!}` into `<head>` of standalone detail templates (`areas/show.blade.php`, `cities/show.blade.php`, `communities/show.blade.php`, `developers/show.blade.php`) so every page across the website outputs valid `Organization` JSON-LD schema in `<head>`.

### Files Modified
- app/helpers.php
- resources/views/areas/show.blade.php
- resources/views/cities/show.blade.php
- resources/views/communities/show.blade.php
- resources/views/developers/show.blade.php
- README.md


## Changelog — 2026-11-23 (Part 123: Exact RealEstateAgent Organization JSON-LD Schema in Sitewide Header)

### What Changed
- **Exact `RealEstateAgent` JSON-LD Schema (`app/helpers.php` — `render_header_schemas()`)**:
  - Updated the `RealEstateAgent` JSON-LD block rendered in `<head>` across all pages to match the exact requested specification:
    - `@id`: `https://fsadvisory.pk/#real-estate-agent`
    - `name`: `FS Real Estate and Advisory`
    - `url`: `https://fsadvisory.pk/`
    - `telephone`: `+923322495575`
    - `description`: `FS Real Estate and Advisory provides residential and commercial real estate advisory services, property buying, selling, renting, and investment guidance in Karachi, Pakistan.`
    - `areaServed`: `City: Karachi` & `Country: Pakistan`.

### Files Modified
- app/helpers.php
- README.md


## Changelog — 2026-11-23 (Part 124: Mobile Sticky WhatsApp Button Production Domain URL)

### What Changed
- **Production URL in Mobile Sticky WhatsApp Message (`resources/views/partials/mobile-sticky-bar.blade.php`)**:
  - Updated `handleMobileStickyWhatsApp()` to always construct the message link using `https://fsadvisory.pk` + current pathname instead of `window.location.href` (replacing local `http://127.0.0.1:8000` with `https://fsadvisory.pk`).

### Files Modified
- resources/views/partials/mobile-sticky-bar.blade.php
- README.md


## Changelog — 2026-11-23 (Part 125: Removed Extra Organization Schema Fields, Exact RealEstateAgent JSON-LD Only)

### What Changed
- **Cleaned Header Schema (`app/helpers.php` — `render_header_schemas()`)**:
  - Removed the separate `Organization` block with extra properties (`alternateName`, `logo`, `image`, `email`, `address`, `contactPoint`, `sameAs`) so `<head>` outputs ONLY the exact requested `RealEstateAgent` JSON-LD block (plus dynamic `FAQPage` schema).

### Files Modified
- app/helpers.php
- README.md


## Changelog — 2026-11-24 (Part 126: Exact SEO Meta Title Display Without Auto Brand Suffix)

### What Changed
- **Removed Hardcoded Brand Name Suffix when Custom Meta Title is Set**:
  - Previously, `communities/show.blade.php` and `cities/show.blade.php` unconditionally appended ` | FS Real Estate Advisory` to `<title>`, causing custom SEO Meta Titles defined in CMS (such as `"Gulberg Properties | Luxury Investment & Community Guide"`) to display as `<title>Gulberg Properties | Luxury Investment &amp; Community Guide | FS Real Estate Advisory</title>`.
  - Updated `<title>` resolution logic across all detail templates:
    - `resources/views/communities/show.blade.php`: Check `$community->meta_title ?: ($pageMeta?->meta_title ?? null)`. If a custom meta title exists, render it exactly without any appended text. Fallback to `(($community->h1 ?: $community->name) . ' | FS Real Estate Advisory')` only when no custom title is defined.
    - `resources/views/areas/show.blade.php`: Check `$community->meta_title ?: ($community->page?->meta_title ?? null)`. If set, display as-is.
    - `resources/views/cities/show.blade.php`: Check `$city->meta_title ?: ($pageMeta?->meta_title ?? null)`. If set, display as-is without suffix.
    - `resources/views/developers/show.blade.php`: Check `$developer->meta_title ?: ($developer->page?->meta_title ?? null)`. If set, display as-is without suffix.
    - `resources/views/dynamic-page.blade.php`: Check `$customDpTitle = ($page ?? null)?->meta_title ?: (($project ?? null)?->meta_title ?: (($city ?? null)?->meta_title ?: (($community ?? null)?->meta_title ?: null)))`. If set, render as-is without suffix.

### Files Modified
- resources/views/areas/show.blade.php
- resources/views/cities/show.blade.php
- resources/views/communities/show.blade.php
- resources/views/developers/show.blade.php
- resources/views/dynamic-page.blade.php
- README.md


## Changelog — 2026-11-26 (Part 127: Blog Full Content Summernote Image Insert Position & Duplicate Fix)

### What Changed
- **Blog Full Content Summernote Image Upload Fix (`resources/views/admin/blogs/index.blade.php`)**:
  - Removed conflicting `.adm-summernote` global initialization on `#field_full_content` (switched to `.blog-summernote`) so the blog editor does not get double-bound or trigger duplicate image uploads.
  - Added native DOM `Range` capture (`savedBlogRange`) on `.note-editable` interaction and capture-phase `mousedown`/`click` interception on the toolbar Picture button, ensuring:
    1. Uploading 1 image inserts **exactly 1 image** (no duplicate insertion).
    2. The uploaded image is inserted **at the exact cursor position** inside the content rather than jumping to the top of the editor.

### Files Modified
- resources/views/admin/blogs/index.blade.php
- README.md



## Changelog — 2026-11-27 (Part 128: Homepage-Only @graph JSON-LD Schema & fs-advisory-logo.svg)

### What Changed
- **Homepage-Only `@graph` JSON-LD Schema (`app/helpers.php` — `render_header_schemas()`)**:
  - Updated `render_header_schemas()` so that when rendering the Homepage (`/` or `home` slug), it outputs the exact requested `@graph` schema containing `Organization`, `WebSite`, `["RealEstateAgent", "LocalBusiness"]` (`postalCode: "75290"`), and `BreadcrumbList`, while preserving Homepage's dynamic `FAQPage` schema.
  - Non-homepage routes continue rendering the standard `RealEstateAgent` schema + dynamic `FAQPage` schema unchanged.
- **Public Logo File (`public/fs-advisory-logo.svg`)**:
  - Copied `public/FS LOGO n FAVICON-06.svg` to `public/fs-advisory-logo.svg`.

### Files Modified
- app/helpers.php
- public/fs-advisory-logo.svg (created)
- README.md


## Changelog — 2026-11-27 (Part 129: Remove FAQPage JSON-LD Schema from About Us Page)

### What Changed
- **About Us Page (`app/helpers.php` — `render_header_schemas()`)**:
  - Excluded `about-us` / `about` from emitting the fallback `FAQPage` JSON-LD schema because the About Us page has no visible FAQ section.

### Files Modified
- app/helpers.php
- README.md


## Changelog — 2026-11-27 (Part 130: Render CMS Social Media Icons in Public Footer)

### What Changed
- **Public Footer Social Links (`resources/views/partials/footer.blade.php`)**:
  - Rendered `$fData->social_links` (Facebook, Instagram, X/Twitter, LinkedIn, WhatsApp, YouTube) under the **Connect With Us** column in the public footer.

### Files Modified
- resources/views/partials/footer.blade.php
- README.md


## Changelog — 2026-11-27 (Part 131: 301 Redirect from /main-shahra-e-faisal to /main-shahra-e-faisal-karachi)

### What Changed
- **301 SEO Redirect (`routes/web.php`)**:
  - Added permanent `301` redirect from `/main-shahra-e-faisal` to `/main-shahra-e-faisal-karachi` so visitors and search engines hitting the old URL are redirected cleanly without a 404.

### Files Modified
- routes/web.php
- README.md



## Changelog — 2026-11-27 (Part 132: Remove Legacy FAQ Subtitle Paragraph on Project Detail Pages)

### What Changed
- **Project Detail Pages (`resources/views/dynamic-page.blade.php`)**:
  - Passed `'customSubtitle' => ''` to `partials.faq` whenever rendering a project detail page (`isset($project) && $project` or `request()->is('project/*')`).
  - This removes the static/legacy subtitle paragraph (`"Key information and helpful answers regarding property purchases on Hudayriyat Island."`) beneath the `Frequently Asked Questions` heading on all project detail pages while leaving all other pages untouched.

### Files Modified
- resources/views/dynamic-page.blade.php
- README.md