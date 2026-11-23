<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@php
    $dpTitle = ($page ?? null)?->meta_title ?: ((($page ?? null)?->title ?? ($project->title ?? ($city->name ?? ($community->name ?? 'Property')))) . ' | FS Real Estate Advisory');
    $dpDesc = ($page ?? null)?->meta_description ?: (($project ?? null)?->headline ?: 'Explore luxury real estate properties, floor plans, and investment opportunities with FS Real Estate Advisory.');
    $dpCanonical = canonical_url();
    
    // Determine preview image (og:image) for WhatsApp and Social share cards
    $dpOgImage = '';
    if (!empty($project?->image_url)) {
        $dpOgImage = $project->image_url;
    } elseif (!empty($project?->image)) {
        $dpOgImage = (str_starts_with($project->image, 'http://') || str_starts_with($project->image, 'https://')) ? $project->image : asset(ltrim($project->image, '/'));
    } elseif (!empty(($page ?? null)?->og_image)) {
        $dpOgImage = str_starts_with($page->og_image, 'http') ? $page->og_image : asset(ltrim($page->og_image, '/'));
    } else {
        $dpHeroBg = page_section('hero', 'bg_image', null, $page->slug ?? null);
        if (!empty($dpHeroBg) && $dpHeroBg !== '/hero.png') {
            $dpOgImage = (str_starts_with($dpHeroBg, 'http://') || str_starts_with($dpHeroBg, 'https://')) ? $dpHeroBg : asset(ltrim($dpHeroBg, '/'));
        } else {
            $dpOgImage = asset('hero.png');
        }
    }
@endphp
    <title>{{ $dpTitle }}</title>
    <link rel="canonical" href="{{ $dpCanonical }}" />
    <meta name="description" content="{{ $dpDesc }}">
    
@if(($page ?? null)?->meta_keywords)
    <meta name="keywords" content="{{ $page->meta_keywords }}">
@endif
@if(is_indexing_enabled())
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
@else
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
@endif
    <meta name="geo.region" content="PK">
    <meta name="geo.placename" content="Pakistan">

    <!-- Open Graph / WhatsApp Preview Meta Tags -->
    <meta property="og:title" content="{{ $dpTitle }}">
    <meta property="og:description" content="{{ $dpDesc }}">
    <meta property="og:url" content="{{ $dpCanonical }}">
    <meta property="og:image" content="{{ $dpOgImage }}">
    <meta property="og:image:secure_url" content="{{ $dpOgImage }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FS Real Estate Advisory">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $dpTitle }}">
    <meta name="twitter:description" content="{{ $dpDesc }}">
    <meta name="twitter:image" content="{{ $dpOgImage }}">

    <!-- Header Schemas: Organization, Dynamic FAQPage & RealEstateAgent (JSON-LD) -->
    {!! render_header_schemas($page ?? null, null) !!}

    @include('partials.seo-head-scripts')

    @include('partials.favicon')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Libre+Franklin:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/communities/global.css') }}?v={{ time() }}">
            {{-- Hudayriyat stylesheet removed --}}
    <link rel="stylesheet" href="{{ asset('css/communities/Saima-golf-estates.css') }}?v={{ time() }}">
    
@if(file_exists(public_path('css/communities/' . $page->slug . '.css')
) && $page->slug !== 'Saima-golf-estates')
    <link rel="stylesheet" href="{{ asset('css/communities/' . $page->slug . '.css') }}?v={{ time() }}">
    
@endif
    <link rel="stylesheet" href="{{ asset('css/saima.css') }}?v={{ time() }}">
    
    <style>
      body {
        margin: 0;
        padding: 0;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #222222;
        background-color: #ffffff;
      }
      [class*="__iconWrapper"], .iconWrapper {
        position: relative !important;
        width: 44px !important;
        height: 44px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
      }
      [class*="__accentCircle"], .accentCircle {
        position: absolute !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: 38px !important;
        height: 38px !important;
        border-radius: 50% !important;
        background: #BFA16A !important;
        opacity: 1 !important;
        z-index: 1 !important;
      }
      [class*="__svgIcon"], .svgIcon {
        position: relative !important;
        z-index: 2 !important;
        color: #ffffff !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        width: 100% !important;
        height: 100% !important;
      }
      [class*="__svgIcon"] img, .svgIcon img,
      [class*="__highlightCard"] img, .highlightCard img {
        width: 20px !important;
        height: 20px !important;
        max-width: 20px !important;
        max-height: 20px !important;
        object-fit: contain !important;
        filter: brightness(0) invert(1) !important;
        -webkit-filter: brightness(0) invert(1) !important;
        display: block !important;
        margin: auto !important;
      }
      [class*="__svgIcon"] svg, .svgIcon svg,
      [class*="__highlightCard"] svg, .highlightCard svg {
        width: 20px !important;
        height: 20px !important;
        max-width: 20px !important;
        max-height: 20px !important;
        stroke: #ffffff !important;
        color: #ffffff !important;
        display: block !important;
        margin: auto !important;
      }
      .slideHidden {
        display: none !important;
      }
      .slideActive {
        display: block !important;
      }
      /* Global Hero Section: BOOK NOW Brand Gold Background */
      .heroBookBtn,
      .heroBtnRow .heroBookBtn,
      #hero .heroBookBtn,
      section[id="hero"] .heroBookBtn,
      .GolfHero-module__9JtUKq__brochureBtn,
      [class*="heroSection"] [class*="brochureBtn"],
      [class*="Hero"] [class*="brochureBtn"],
      [class*="__btnRow"] [class*="brochureBtn"],
      [class*="btnRow"] button {
        background-color: #BFA16A !important;
        background: #BFA16A !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 4px !important;
        box-shadow: 0 4px 14px rgba(191, 161, 106, 0.35) !important;
        transition: all 0.2s ease !important;
        cursor: pointer !important;
      }
      .heroBookBtn:hover,
      .heroBtnRow .heroBookBtn:hover,
      #hero .heroBookBtn:hover,
      section[id="hero"] .heroBookBtn:hover,
      .GolfHero-module__9JtUKq__brochureBtn:hover,
      [class*="heroSection"] [class*="brochureBtn"]:hover,
      [class*="Hero"] [class*="brochureBtn"]:hover,
      [class*="__btnRow"] [class*="brochureBtn"]:hover,
      [class*="btnRow"] button:hover {
        background-color: #aa8d58 !important;
        background: #aa8d58 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(191, 161, 106, 0.5) !important;
      }
      /* Hero Call Back Form Button */
      .GolfHero-module__9JtUKq__submitBtn,
      .requestCard button[type="submit"],
      [class*="requestCard"] button[type="submit"],
      [class*="callForm"] button[type="submit"] {
        background-color: #BFA16A !important;
        background: #BFA16A !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 4px !important;
        box-shadow: 0 4px 14px rgba(191, 161, 106, 0.35) !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px !important;
        transition: all 0.2s ease !important;
        cursor: pointer !important;
      }
      .GolfHero-module__9JtUKq__submitBtn:hover,
      .requestCard button[type="submit"]:hover,
      [class*="requestCard"] button[type="submit"]:hover,
      [class*="callForm"] button[type="submit"]:hover {
        background-color: #aa8d58 !important;
        background: #aa8d58 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(191, 161, 106, 0.5) !important;
      }
      /* Slider Nav Buttons */
      .GolfHero-module__9JtUKq__prevBtn,
      .GolfHero-module__9JtUKq__nextBtn {
        background: rgba(0, 0, 0, 0.45) !important;
        border: 1px solid rgba(255, 255, 255, 0.35) !important;
        color: #ffffff !important;
        transition: all 0.2s ease !important;
      }
      .GolfHero-module__9JtUKq__prevBtn:hover,
      .GolfHero-module__9JtUKq__nextBtn:hover {
        background: #BFA16A !important;
        border-color: #BFA16A !important;
        color: #ffffff !important;
      }
      .tabHidden {
        display: none !important;
      }
      .tabActive {
        display: block !important;
      }
      .accClosed {
        max-height: 0px !important;
        overflow: hidden !important;
        opacity: 0 !important;
        transition: max-height 0.35s ease, opacity 0.35s ease;
      }
      .accOpen {
        max-height: 1000px !important;
        opacity: 1 !important;
        transition: max-height 0.35s ease, opacity 0.35s ease;
      }
      .modalHidden {
        display: none !important;
      }
      .modalVisible {
        display: flex !important;
      }
      .GolfHeader-module__ZF_nIG__navItem:hover .GolfHeader-module__ZF_nIG__dropdownMenu,
      .GolfHeader-module__ZF_nIG__navItem:hover [class*="dropdownMenu"],
      [class*="navItem"]:hover > [class*="dropdownMenu"],
      [class*="navItem"]:hover > [class*="DropdownMenu"] {
        display: block !important;
        opacity: 1 !important;
        visibility: visible !important;
        transform: translateY(0) !important;
        pointer-events: auto !important;
      }
      /* Universal Hero Heading & Subtitle (100% Home Page Parity) */
      .GolfHero-module__9JtUKq__title,
      [class*="Hero-module__"][class*="__title"],
      .heroTitle {
        font-size: clamp(32px, 3.8vw, 46px) !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        line-height: 1.22 !important;
        margin-bottom: 18px !important;
        letter-spacing: -0.015em !important;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.45) !important;
      }
      .GolfHero-module__9JtUKq__subtitle,
      [class*="Hero-module__"][class*="__subtitle"],
      .heroSubtitle {
        font-size: clamp(15px, 1.35vw, 18px) !important;
        font-weight: 400 !important;
        color: rgba(255, 255, 255, 0.92) !important;
        line-height: 1.55 !important;
        margin-bottom: 16px !important;
        text-shadow: 0 1px 6px rgba(0, 0, 0, 0.45) !important;
      }
      @media (max-width: 991px) {
        .GolfHero-module__9JtUKq__title,
        [class*="Hero-module__"][class*="__title"],
        .heroTitle {
          font-size: 36px !important;
          line-height: 1.15 !important;
          margin-bottom: 12px !important;
        }
        .GolfHero-module__9JtUKq__subtitle,
        [class*="Hero-module__"][class*="__subtitle"],
        .heroSubtitle {
          font-size: 16px !important;
          line-height: 1.4 !important;
          margin-bottom: 10px !important;
        }
      }
      @media (max-width: 576px) {
        .GolfHero-module__9JtUKq__title,
        [class*="Hero-module__"][class*="__title"],
        .heroTitle {
          font-size: 30px !important;
          margin-bottom: 8px !important;
        }
        .GolfHero-module__9JtUKq__subtitle,
        [class*="Hero-module__"][class*="__subtitle"],
        .heroSubtitle {
          font-size: 14px !important;
          margin-bottom: 8px !important;
        }
      }

      /* All Headings Across ENTIRE Dynamic Page -> Brand Gold (#BFA16A) */
      h1, h2, h3, h4, h5, h6,
      h1 *, h2 *, h3 *, h4 *, h5 *, h6 *,
      article h1, article h2, article h3, article h4, article h5, article h6,
      article h1 *, article h2 *, article h3 *, article h4 *, article h5 *, article h6 *,
      .locMainTitle, .locMainTitle *,
      .fsProjectHeroTitle, .fsProjectHeroTitle *,
      .fsHeroTitleDark, .fsHeroTitleGold,
      .note-editable h1, .note-editable h2, .note-editable h3, .note-editable h4, .note-editable h5, .note-editable h6,
      .note-editable h1 *, .note-editable h2 *, .note-editable h3 *, .note-editable h4 *,
      .saimaContentCol h1, .saimaContentCol h2, .saimaContentCol h3, .saimaContentCol h4, .saimaContentCol h5, .saimaContentCol h6,
      .saimaContentCol h1 *, .saimaContentCol h2 *, .saimaContentCol h3 *, .saimaContentCol h4 *, .saimaContentCol h5 *, .saimaContentCol h6 *,
      .saimaDynamicContent h1, .saimaDynamicContent h2, .saimaDynamicContent h3, .saimaDynamicContent h4, .saimaDynamicContent h5, .saimaDynamicContent h6,
      .saimaDynamicContent h1 *, .saimaDynamicContent h2 *, .saimaDynamicContent h3 *, .saimaDynamicContent h4 *, .saimaDynamicContent h5 *, .saimaDynamicContent h6 *,
      .saimaLongContentBody h1, .saimaLongContentBody h2, .saimaLongContentBody h3, .saimaLongContentBody h4, .saimaLongContentBody h5, .saimaLongContentBody h6,
      .saimaLongContentBody h1 *, .saimaLongContentBody h2 *, .saimaLongContentBody h3 *, .saimaLongContentBody h4 *, .saimaLongContentBody h5 *, .saimaLongContentBody h6 * {
        color: #BFA16A !important;
      }
    
      /* Universal White Navbar (#FFFFFF) for Project Detail Pages */
      .GolfHeader-module__ZF_nIG__header,
      header.GolfHeader-module__ZF_nIG__header,
      header[class*="Header"],
      .header,
      #siteHeader {
        position: sticky !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        background: #FFFFFF !important;
        background-color: #FFFFFF !important;
        z-index: 9999 !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.06) !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
        padding: 12px 0 !important;
      }

      @media (max-width: 768px) {
        .header,
        #siteHeader,
        .GolfHeader-module__ZF_nIG__header {
          border-bottom: none !important;
          box-shadow: none !important;
        }
        .mobileDrawerOverlay,
        #mobileBackdrop {
          z-index: 100000 !important;
        }
        .mobileDrawer,
        #mobileDrawer {
          z-index: 100005 !important;
          width: 320px !important;
          max-width: 86vw !important;
        }
      }
      .GolfHeader-module__ZF_nIG__headerContainer {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
      }
      .GolfHeader-module__ZF_nIG__navLink {
        color: #171717 !important;
        font-weight: 600 !important;
        font-size: 13.5px !important;
        letter-spacing: 0.3px !important;
        text-decoration: none !important;
        position: relative !important;
        transition: color 0.2s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 4px !important;
        text-transform: uppercase !important;
      }
      .GolfHeader-module__ZF_nIG__navLink svg {
        stroke: #171717 !important;
        color: #171717 !important;
        transition: stroke 0.2s ease !important;
      }
      .GolfHeader-module__ZF_nIG__navLink:hover,
      .GolfHeader-module__ZF_nIG__navItem:hover > .GolfHeader-module__ZF_nIG__navLink {
        color: #BFA16A !important;
      }
      .GolfHeader-module__ZF_nIG__navLink:hover svg,
      .GolfHeader-module__ZF_nIG__navItem:hover > .GolfHeader-module__ZF_nIG__navLink svg {
        stroke: #BFA16A !important;
        color: #BFA16A !important;
      }
      .GolfHeader-module__ZF_nIG__navLink::after {
        content: "" !important;
        position: absolute !important;
        left: 0 !important;
        bottom: -6px !important;
        width: 0% !important;
        height: 2.5px !important;
        background: #BFA16A !important;
        background-color: #BFA16A !important;
        transition: width 0.25s ease !important;
      }
      .GolfHeader-module__ZF_nIG__navLink:hover::after,
      .GolfHeader-module__ZF_nIG__navItemActive .GolfHeader-module__ZF_nIG__navLink::after {
        width: 100% !important;
      }
      .GolfHeader-module__ZF_nIG__dropdownMenu {
        background: #ffffff !important;
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12) !important;
        border-radius: 6px !important;
      }
      .GolfHeader-module__ZF_nIG__dropdownItem {
        color: #222222 !important;
        transition: all 0.2s ease !important;
      }
      .GolfHeader-module__ZF_nIG__dropdownItem:hover {
        background: rgba(191, 161, 106, 0.1) !important;
        color: #BFA16A !important;
      }
      .GolfHeader-module__ZF_nIG__mobileToggle svg {
        stroke: #171717 !important;
        color: #171717 !important;
      }
      .btn-get-started,
      .GolfHeader-module__ZF_nIG__listPropBtnMobile {
        background-color: #BFA16A !important;
        background: #BFA16A !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 4px !important;
        box-shadow: 0 4px 12px rgba(191, 161, 106, 0.3) !important;
        transition: all 0.2s ease !important;
      }
      .btn-get-started:hover,
      .GolfHeader-module__ZF_nIG__listPropBtnMobile:hover {
        background-color: #aa8d58 !important;
        background: #aa8d58 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 16px rgba(191, 161, 106, 0.45) !important;
      }
      .ScrollToTop-module__bPaVnG__scrollTopBtn {
        background-color: #BFA16A !important;
        background: #BFA16A !important;
        color: #ffffff !important;
      }
      .ScrollToTop-module__bPaVnG__scrollTopBtn:hover {
        background-color: #aa8d58 !important;
        background: #aa8d58 !important;
      }
      .GolfHero-module__9JtUKq__heroSection {
        padding: 60px 0 60px !important;
      }
      /* All Content & Overview Hyperlinks on UI -> Golden #BFA16A */
      .fsAboutDesc a,
      .fsAboutDesc p a,
      .saimaContentCol a,
      .saimaShortContent a,
      .saimaDynamicContent a,
      .saimaLongContentBody a,
      .saimaSummernoteBodyContent a,
      .saimaSummernoteExpanded a,
      .GolfAboutVideo-module__mC9tiq__description a,
      article a:not(.btn):not(.saimaTocLink) {
        color: #BFA16A !important;
        text-decoration: underline !important;
        font-weight: 600 !important;
        transition: color 0.15s ease !important;
      }
      .fsAboutDesc a:hover,
      .fsAboutDesc p a:hover,
      .saimaContentCol a:hover,
      .saimaShortContent a:hover,
      .saimaDynamicContent a:hover,
      .saimaLongContentBody a:hover,
      .saimaSummernoteBodyContent a:hover,
      .saimaSummernoteExpanded a:hover,
      .GolfAboutVideo-module__mC9tiq__description a:hover,
      article a:not(.btn):not(.saimaTocLink):hover {
        color: #aa8d58 !important;
      }
    </style>
</head>
<body>
    <main style="min-height:100vh;background-color:#ffffff">
    @include('partials.header')
@php
    $orderedSections = $page->sections()->where('is_active', true)->where('is_visible', true)->orderBy('order', 'asc')->get();
    $articleRendered = false;
    $communitiesRendered = false;
    $GLOBALS['communitiesRenderedGlobal'] = false;
    $isProjectDetailPage = isset($project) || request()->is('project/*') || ($page && \App\Models\Project::where('page_id', $page->id)->exists());
    if ((!isset($project) || !$project) && isset($page) && $page) {
        $project = \App\Models\Project::where('page_id', $page->id)->orWhere('slug', $page->slug)->first();
    }
@endphp

@if($isProjectDetailPage)
    {{-- ========================================================================= --}}
    {{-- PROJECT DETAIL PAGE LAYOUT (EXACT SEQUENCE REQUESTED)                     --}}
    {{-- 1. Hero Banner & Form                                                     --}}
    {{-- 2. Project Highlights                                                     --}}
    {{-- 3. Two-Column Wrapper (Starts after Highlights, Ends after Content)       --}}
    {{--    Left Column: About Community -> Amenities -> Payment Plan -> Content    --}}
    {{--    Right Column: Sticky Sidebar (WhatsApp, Call, Form & Custom Searches)  --}}
    {{-- 4. Subsequent Sections: Gallery -> Master Plan -> Location -> FAQ -> Contact --}}
    {{-- ========================================================================= --}}

    {{-- 1. Hero Section --}}
    @if($orderedSections->contains('section_key', 'hero'))
        @php
            $rawHeroTitle = page_section('hero', 'title', null, $page->slug);
            $rawHeroSub = page_section('hero', 'subtitle', null, $page->slug);
            $rawHeroBg = page_section('hero', 'bg_image', null, $page->slug);
            $rawHeroBadge = page_section('hero', 'badge', null, $page->slug);
            $hasHeroContent = !empty(trim((string)$rawHeroTitle)) 
                || !empty(trim((string)$rawHeroSub)) 
                || (!empty(trim((string)$rawHeroBg)) && $rawHeroBg !== '/hero.png')
                || !empty(trim((string)$rawHeroBadge));
        @endphp
        @if($hasHeroContent)
            @include('partials.project-hero', ['slug' => $page->slug, 'page' => $page, 'project' => $project])
        @endif
    @endif

    {{-- 1b. Auto Project Name / Developer / Community (between Hero and Highlights) --}}
    <section style="background:#f7f5f2; padding: 28px 0 8px 0;">
        <div class="container" style="max-width:1440px; padding: 0 36px;">
            @include('partials.page-about', ['embedded' => true, 'isProjectContext' => true, 'project' => $project, 'part' => 'header'])
        </div>
    </section>

    {{-- 2. Project Highlights (Full Width) --}}
    @if($orderedSections->contains('section_key', 'highlights'))
        @include('partials.page-highlights')
    @endif

    {{-- 3. Two-Column Layout (Starts after Highlights, Ends after Content) --}}
    <style>
.fsProjectGrid { display: grid; grid-template-columns: minmax(0, 1fr) 380px; gap: 40px; align-items: start; }
.fsProjectMainCol { display: flex; flex-direction: column; gap: 24px; min-width: 0; }
.fsProjectSidebarCol { min-width: 0; align-self: stretch; position: relative; }
.fsProjectSidebarCol .saimaStickySidebar { position: -webkit-sticky; position: sticky; top: var(--fsSbTop, 95px); max-height: none; overflow: visible; }
.fsProjectSidebarCol .saimaStickySidebar::-webkit-scrollbar { display: none; }
@media (max-width: 991px) {
  .fsProjectGrid { grid-template-columns: 1fr; }
  .fsProjectSidebarCol .saimaStickySidebar { position: static; max-height: none; overflow: visible; }
}
</style>
<section id="projectMainSection" style="padding: 35px 0 55px 0; background-color: #ffffff;">
        <div class="container" style="max-width:1440px; padding: 0 36px;">
            <div class="fsProjectGrid">
                <!-- Left Main Content Column: About, Amenities, Payment Plan, Content -->
                <div class="fsProjectMainCol">
                    @if($orderedSections->contains('section_key', 'about'))
                        @include('partials.page-about', ['embedded' => true, 'isProjectContext' => true, 'project' => $project, 'part' => 'body'])
                    @endif

                    @if($orderedSections->contains('section_key', 'amenities'))
                        @include('partials.page-amenities', ['embedded' => true])
                    @endif

                    @if($orderedSections->contains('section_key', 'payment_plan'))
                        <div id="paymentplan">@include('partials.page-payment-plan', ['embedded' => true])</div>
                    @endif

                    @if($orderedSections->contains('section_key', 'floor_plan'))
                        @php
                            $fpHasContent = !empty(trim((string)page_section('floor_plan', 'title', '', $page->slug)))
                                || !empty(trim(strip_tags((string)page_section('floor_plan', 'description', '', $page->slug))))
                                || !empty(array_filter((array)page_section('floor_plan', 'plan_images', [], $page->slug)));
                        @endphp
                        @if($fpHasContent)
                            <div id="floorplan">@include('partials.page-floor-plan')</div>
                        @endif
                    @endif

                    @if($orderedSections->contains('section_key', 'content') || $orderedSections->contains('section_key', 'toc'))
                        @php $articleRendered = true; @endphp
                        <div id="mainContentArticle">
                            @include('partials.article', ['embedded' => true, 'slug' => $page->slug, 'page' => $page])
                        </div>
                    @endif
                </div>

                <!-- Right Sticky Sidebar: Starts after Highlights, Ends after Content -->
                <aside class="fsProjectSidebarCol">
                    @include('partials.sidebar-form-widget')
                </aside>
            </div>
        </div>
    </section>
    <script>
    (function(){
        function fsAdjustSidebarTop(){
            var sb = document.querySelector('.fsProjectSidebarCol .saimaStickySidebar');
            if(!sb) return;
            var h = sb.offsetHeight, vh = window.innerHeight;
            var top = Math.min(95, vh - h - 20);
            document.documentElement.style.setProperty('--fsSbTop', top + 'px');
        }
        window.addEventListener('load', fsAdjustSidebarTop);
        window.addEventListener('resize', fsAdjustSidebarTop);
        setTimeout(fsAdjustSidebarTop, 600);
    })();
    </script>

    {{-- 4. Project Gallery (Full Width) --}}
    @if($orderedSections->contains('section_key', 'gallery'))
        @include('partials.project-gallery', ['slug' => $page->slug])
    @endif

    {{-- 5. Master Plan (Full Width) --}}
    @if($orderedSections->contains('section_key', 'master_plan'))
        @php
            $mpImg = page_section('master_plan', 'image', '', $page->slug);
            $mpTitle = page_section('master_plan', 'title', '', $page->slug);
            $hasMasterPlan = !empty($mpImg) && (str_starts_with($mpImg, 'http') || file_exists(public_path(ltrim($mpImg, '/'))));
        @endphp
        @if($hasMasterPlan)
        <section id="master" style="padding: 60px 0; background: #ffffff;">
            <div class="container">
                <div style="text-align: center; margin-bottom: 25px;">
                    <h2 style="font-size: 32px; font-weight: 700; color: #1a1a1a;">{!! $mpTitle ?: 'Master Plan' !!}</h2>
                </div>
                <div style="max-width: 1100px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); text-align: center; padding: 15px;">
                    <div style="width: 100%; aspect-ratio: 16 / 9; max-height: 580px; border-radius: 6px; overflow: hidden; background: #fbfaf8; position: relative;">
                        <img src="{{ $mpImg }}" alt="{!! $mpTitle ?: 'Master Plan' !!}" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; border-radius: 6px;">
                    </div>
                </div>
            </div>
        </section>
        @endif
    @endif

    {{-- 6. Location & Connectivity (Full Width) --}}
    @if($orderedSections->contains('section_key', 'location') || $orderedSections->contains('section_key', 'overview_location'))
        @php
            $locImg = page_section('location', 'image', '', $page->slug);
            $locCategories = page_section('location', 'categories', [], $page->slug);
            $locCategories = array_values(array_filter((array)$locCategories, fn($c) => is_array($c) && !empty($c['name'])));
            $locSub = trim((string)page_section('location', 'subtitle', '', $page->slug));
            $locItems = page_section('location', 'items', [], $page->slug);
            $locItems = array_values(array_filter((array)$locItems, fn($i) => is_array($i) && !empty($i['name'])));
            $hasLocImg = !empty($locImg) && (str_starts_with($locImg, 'http') || file_exists(public_path(ltrim($locImg, '/'))));
            $hasLocationContent = !empty($locCategories) || !empty($locItems) || (!empty($locSub) && $hasLocImg);
        @endphp
        @if($hasLocationContent)
        <section class="GolfLocation-module__HavC9G__locationSection" id="location">
            <div class="container">
                <style>
                .fsLocRow { display: grid; grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 40px; align-items: start; }
                .fsLocText { text-align: left; }
                @media (max-width: 900px) { .fsLocRow { grid-template-columns: 1fr; gap: 24px; } }
                </style>
                <div class="fsLocRow">
                    <div class="fsLocText">
                        <h2 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin: 0 0 12px 0;">{!! page_section('location', 'title', 'Location & Attractions', $page->slug) !!}</h2>
                        @if(!empty($locSub))
                        <p style="font-size: 15px; color: #666; margin: 0; line-height: 1.7;">{{ $locSub }}</p>
                        @endif
                    </div>
                    @if(!empty($locCategories))
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($locCategories as $cIdx => $cat)
                            <div style="border: 1px solid #e0d7cb; border-radius: 8px; overflow: hidden; background: #fff;">
                                <button type="button" onclick="const p = this.nextElementSibling; p.style.display = (p.style.display === 'none' ? 'block' : 'none');" style="width: 100%; padding: 14px 18px; background: {{ $cIdx === 0 ? '#BFA16A' : '#f7f4f0' }}; color: {{ $cIdx === 0 ? '#fff' : '#333' }}; font-weight: 700; font-size: 15px; border: none; text-align: left; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                                    <span>{{ $cat['name'] ?? '' }}</span>
                                    <span style="font-size: 18px;">▾</span>
                                </button>
                                <div style="display: {{ $cIdx === 0 ? 'block' : 'none' }}; padding: 12px 18px;">
                                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                                        @foreach($cat['items'] ?? [] as $cItm)
                                             <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #eee; padding-bottom: 6px; font-size: 14px;">
                                                <span style="font-weight: 600; color: #222;">{{ $cItm['name'] ?? '' }}</span>
                                                <span style="color: #BFA16A; font-weight: 700; font-size: 13px;">{{ $cItm['time'] ?? '' }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
                @if($hasLocImg)
                <div style="position: relative; border-radius: 10px; overflow: hidden; min-height: 380px; margin-top: 32px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                    <img src="{{ $locImg }}" alt="{!! page_section('location', 'title', 'Location', $page->slug) !!}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                </div>
                @endif
            </div>
        </section>
        @endif
    @endif

    {{-- 7. FAQ Accordion (Full Width) --}}
    @if($orderedSections->contains('section_key', 'faq'))
        @include('partials.faq', ['page' => $page, 'slug' => $page->slug])
    @endif

    {{-- 8. Contact & Booking CTA (Full Width) --}}
    @if($orderedSections->contains('section_key', 'contact'))
        @php
            $hasContactContent = !empty(trim((string)page_section('contact', 'heading', page_section('contact', 'title', '', $page->slug), $page->slug)))
                || !empty(trim((string)page_section('contact', 'subtitle', '', $page->slug)))
                || !empty(trim((string)page_section('contact', 'phone', '', $page->slug)))
                || !empty(trim((string)page_section('contact', 'email', '', $page->slug)))
                || !empty(trim((string)page_section('contact', 'pretitle', '', $page->slug)));
        @endphp
        @if($hasContactContent)
            @include('partials.contact')
        @endif
    @endif

@else
    {{-- Non-project page default sequential loop --}}
    @foreach($orderedSections as $sec)
    @if($sec->section_key === 'hero')
        @php
            $rawHeroTitle = page_section('hero', 'title', null, $page->slug);
            $rawHeroSub = page_section('hero', 'subtitle', null, $page->slug);
            $rawHeroBg = page_section('hero', 'bg_image', null, $page->slug);
            $rawHeroBadge = page_section('hero', 'badge', null, $page->slug);
            $hasHeroContent = !empty(trim((string)$rawHeroTitle)) 
                || !empty(trim((string)$rawHeroSub)) 
                || (!empty(trim((string)$rawHeroBg)) && $rawHeroBg !== '/hero.png')
                || !empty(trim((string)$rawHeroBadge));
        @endphp
        @if($hasHeroContent)
            @include('partials.page-hero')
        @endif
    @elseif($sec->section_key === 'highlights')
        @include('partials.page-highlights')
    @elseif($sec->section_key === 'about')
        @include('partials.page-about')
    @elseif($sec->section_key === 'amenities')
        @include('partials.page-amenities')
    @elseif($sec->section_key === 'gallery')
        @include('partials.project-gallery', ['slug' => $page->slug])
    @elseif(($sec->section_key === 'content' || $sec->section_key === 'toc') && !$articleRendered)
        @php $articleRendered = true; @endphp
        @include('partials.article', ['slug' => $page->slug, 'page' => $page])
    @elseif($sec->section_key === 'floor_plans')
        @php
            $fpUnits = page_section('floor_plans', 'units', page_section('floor_plans', 'items', [], $page->slug), $page->slug);
            $fpUnits = array_values(array_filter((array)$fpUnits, fn($u) => is_array($u) && (!empty($u['title']) || !empty($u['name']) || !empty($u['image']))));
        @endphp
        @if(!empty($fpUnits))
        <section id="floorplans" class="GolfFloorPlans-module__Vvrdhq__floorPlansSection">
            <div class="container">
                <div class="GolfFloorPlans-module__Vvrdhq__header">
                    <h2 class="GolfFloorPlans-module__Vvrdhq__title">{!! page_section('floor_plans', 'title', $page->title . ' Floor Plans', $page->slug) !!}</h2>
                    <p class="GolfFloorPlans-module__Vvrdhq__subtitle">Explore the thoughtfully designed layouts created for modern island living.</p>
                </div>
            </div>
        </section>
        @endif
    @elseif($sec->section_key === 'payment_plan')
        @include('partials.page-payment-plan')
    @elseif($sec->section_key === 'master_plan')
        @php
            $mpImg = page_section('master_plan', 'image', '', $page->slug);
            $mpTitle = page_section('master_plan', 'title', '', $page->slug);
            $hasMasterPlan = !empty($mpImg) && (str_starts_with($mpImg, 'http') || file_exists(public_path(ltrim($mpImg, '/'))));
        @endphp
        @if($hasMasterPlan)
        <section id="master" style="padding: 60px 0; background: #ffffff;">
            <div class="container">
                <div style="text-align: center; margin-bottom: 25px;">
                    <h2 style="font-size: 32px; font-weight: 700; color: #1a1a1a;">{!! $mpTitle ?: 'Master Plan' !!}</h2>
                </div>
                <div style="max-width: 1100px; margin: 0 auto; background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 20px rgba(0,0,0,0.08); text-align: center; padding: 15px;">
                    <div style="width: 100%; aspect-ratio: 16 / 9; max-height: 580px; border-radius: 6px; overflow: hidden; background: #fbfaf8; position: relative;">
                        <img src="{{ $mpImg }}" alt="{!! $mpTitle ?: 'Master Plan' !!}" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block; border-radius: 6px;">
                    </div>
                </div>
            </div>
        </section>
        @endif
    @elseif($sec->section_key === 'location' || $sec->section_key === 'overview_location')
        @php
            $locImg = page_section('location', 'image', '', $page->slug);
            $locCategories = page_section('location', 'categories', [], $page->slug);
            $locCategories = array_values(array_filter((array)$locCategories, fn($c) => is_array($c) && !empty($c['name'])));
            $locSub = trim((string)page_section('location', 'subtitle', '', $page->slug));
            $locItems = page_section('location', 'items', [], $page->slug);
            $locItems = array_values(array_filter((array)$locItems, fn($i) => is_array($i) && !empty($i['name'])));
            $hasLocImg = !empty($locImg) && (str_starts_with($locImg, 'http') || file_exists(public_path(ltrim($locImg, '/'))));
            $hasLocationContent = !empty($locCategories) || !empty($locItems) || (!empty($locSub) && $hasLocImg);
        @endphp
        @if($hasLocationContent)
        <section class="GolfLocation-module__HavC9G__locationSection" id="location">
            <div class="container">
                <div style="text-align: center; margin-bottom: 40px;">
                    <h2 style="font-size: 32px; font-weight: 700; color: #1a1a1a; margin-bottom: 12px;">{!! page_section('location', 'title', 'Location & Attractions', $page->slug) !!}</h2>
                    @if(!empty($locSub))
                    <p style="font-size: 15px; color: #666; max-width: 800px; margin: 0 auto; line-height: 1.6;">{{ $locSub }}</p>
                    @endif
                </div>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 32px; align-items: start;">
                    @if($hasLocImg)
                    <div style="position: relative; border-radius: 10px; overflow: hidden; min-height: 380px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                        <img src="{{ $locImg }}" alt="{!! page_section('location', 'title', 'Location', $page->slug) !!}" style="position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    @endif
                    @if(!empty($locCategories))
                    <div style="display: flex; flex-direction: column; gap: 12px;">
                        @foreach($locCategories as $cIdx => $cat)
                            <div style="border: 1px solid #e0d7cb; border-radius: 8px; overflow: hidden; background: #fff;">
                                <button type="button" onclick="const p = this.nextElementSibling; p.style.display = (p.style.display === 'none' ? 'block' : 'none');" style="width: 100%; padding: 14px 18px; background: {{ $cIdx === 0 ? '#BFA16A' : '#f7f4f0' }}; color: {{ $cIdx === 0 ? '#fff' : '#333' }}; font-weight: 700; font-size: 15px; border: none; text-align: left; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                                    <span>{{ $cat['name'] ?? '' }}</span>
                                    <span style="font-size: 18px;">▾</span>
                                </button>
                                <div style="display: {{ $cIdx === 0 ? 'block' : 'none' }}; padding: 12px 18px;">
                                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 10px;">
                                        @foreach($cat['items'] ?? [] as $cItm)
                                             <li style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px dashed #eee; padding-bottom: 6px; font-size: 14px;">
                                                <span style="font-weight: 600; color: #222;">{{ $cItm['name'] ?? '' }}</span>
                                                <span style="color: #BFA16A; font-weight: 700; font-size: 13px;">{{ $cItm['time'] ?? '' }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </section>
        @endif
    @elseif($sec->section_key === 'landmarks')
        <section class="GolfLandmarks-module__N9ZsyW__landmarksSection"><div class="container"><div class="GolfLandmarks-module__N9ZsyW__header"><h2 class="GolfLandmarks-module__N9ZsyW__title">Nearby Landmarks</h2></div><div class="GolfLandmarks-module__N9ZsyW__landmarksGrid"><div class="GolfLandmarks-module__N9ZsyW__card"><div class="GolfLandmarks-module__N9ZsyW__imgWrapper"><img alt="Ferrari World Abu Dhabi" class="GolfLandmarks-module__N9ZsyW__cardImg" style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent" sizes="100vw" src="/images/golf-estates/landmark-ferrari.jpg"/></div><div class="GolfLandmarks-module__N9ZsyW__cardContent"><h3 class="GolfLandmarks-module__N9ZsyW__landmarkTitle">Ferrari World Abu Dhabi</h3><p class="GolfLandmarks-module__N9ZsyW__landmarkTime">42 Mins</p></div></div><div class="GolfLandmarks-module__N9ZsyW__card"><div class="GolfLandmarks-module__N9ZsyW__imgWrapper"><img alt="Zayed International Airport" class="GolfLandmarks-module__N9ZsyW__cardImg" style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent" sizes="100vw" src="/images/golf-estates/landmark-airport.jpg"/></div><div class="GolfLandmarks-module__N9ZsyW__cardContent"><h3 class="GolfLandmarks-module__N9ZsyW__landmarkTitle">Zayed International Airport</h3><p class="GolfLandmarks-module__N9ZsyW__landmarkTime">25 Mins</p></div></div><div class="GolfLandmarks-module__N9ZsyW__card"><div class="GolfLandmarks-module__N9ZsyW__imgWrapper"><img alt="Louvre Abu Dhabi" class="GolfLandmarks-module__N9ZsyW__cardImg" style="position:absolute;height:100%;width:100%;left:0;top:0;right:0;bottom:0;color:transparent" sizes="100vw" src="/images/golf-estates/landmark-louvre.jpg"/></div><div class="GolfLandmarks-module__N9ZsyW__cardContent"><h3 class="GolfLandmarks-module__N9ZsyW__landmarkTitle">Louvre Abu Dhabi</h3><p class="GolfLandmarks-module__N9ZsyW__landmarkTime">34 Mins</p></div></div></div></div></section>
    @elseif($sec->section_key === 'faq')
        @include('partials.faq', ['page' => $page, 'slug' => $page->slug])
    @elseif($sec->section_key === 'contact')
        @php
            $hasContactContent = !empty(trim((string)page_section('contact', 'heading', page_section('contact', 'title', '', $page->slug), $page->slug)))
                || !empty(trim((string)page_section('contact', 'subtitle', '', $page->slug)))
                || !empty(trim((string)page_section('contact', 'phone', '', $page->slug)))
                || !empty(trim((string)page_section('contact', 'email', '', $page->slug)))
                || !empty(trim((string)page_section('contact', 'pretitle', '', $page->slug)));
        @endphp
        @if($hasContactContent)
            @include('partials.contact')
        @endif
    @elseif($sec->section_key === 'communities' && !$communitiesRendered && empty($GLOBALS['communitiesRenderedGlobal']))
        @php
            $rawSelCommIds = (isset($community) && !empty($community->featured_projects))
                ? $community->featured_projects
                : ((isset($city) && !empty($city->featured_communities))
                    ? $city->featured_communities
                    : (page_section('communities', 'selected_ids', [], $page->slug) ?: page_section('communities', 'project_ids', [], $page->slug)));
            $hasSelProjects = !empty(array_filter((array)$rawSelCommIds));
        @endphp
        @if($hasSelProjects)
            @php $communitiesRendered = true; @endphp
            @include('partials.page-communities')
        @endif
    @endif
@endforeach
@endif

@include('partials.footer')<button type="button" class="ScrollToTop-module__bPaVnG__scrollTopBtn " aria-label="Scroll to top of page"><svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up" aria-hidden="true"><path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path></svg></button></main>

    <!-- Community Client JavaScript -->
    <script src="{{ asset('js/communities/community-interactions.js') }}?v={{ time() }}"></script>
    <!-- Universal International Phone Selector (218 Countries Worldwide & Dynamic Validation) -->
    <script src="{{ asset('js/universal-phone-selector.js') }}?v={{ time() }}"></script>

    <!-- List Your Property Modal -->
    <div id="listPropertyModal" class="modalOverlay" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.65); z-index: 100000; align-items: center; justify-content: center; padding: 20px;">
        <div class="modalContent" style="background: #fff; width: 100%; max-width: 580px; border-radius: 12px; padding: 32px 28px; position: relative; max-height: 90vh; overflow-y: auto; box-shadow: 0 20px 50px rgba(0,0,0,0.3);">
            <div class="modalHeader" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 22px; padding-bottom: 14px; border-bottom: 1px solid #f0ebe4;">
                <h2 class="modalTitle" style="margin: 0; font-size: 22px; font-weight: 700; color: #BFA16A;">LIST YOUR PROPERTY</h2>
                <button type="button" id="modalCloseBtn" onclick="window.closeListModal()" aria-label="Close modal" style="background: none; border: none; cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center;">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#222" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="modalLeadForm" style="display: grid; gap: 16px;">
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px;">Name *</label>
                    <input type="text" name="name" required placeholder="Your Name" style="width: 100%; padding: 11px 14px; border: 1px solid #dcdcdc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px;">Email *</label>
                    <input type="email" name="email" required placeholder="your.email@example.com" style="width: 100%; padding: 11px 14px; border: 1px solid #dcdcdc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px;">Phone *</label>
                    <input type="tel" name="phone" required placeholder="+92 300 1234567" style="width: 100%; padding: 11px 14px; border: 1px solid #dcdcdc; border-radius: 4px; font-size: 14px; box-sizing: border-box;">
                </div>
                <div>
                    <label style="display: block; font-size: 13px; font-weight: 600; color: #444; margin-bottom: 6px;">Property Details</label>
                    <textarea name="comment" rows="3" placeholder="Tell us about the property (bedrooms, plot size, location, expected price)..." style="width: 100%; padding: 11px 14px; border: 1px solid #dcdcdc; border-radius: 4px; font-size: 14px; box-sizing: border-box;"></textarea>
                </div>
                <div>
                    <button type="submit" style="width: 100%; padding: 14px; background: #BFA16A; color: #fff; font-weight: 700; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; letter-spacing: 0.5px; transition: background 0.2s ease;">SUBMIT PROPERTY</button>
                </div>
            </form>
            <div id="modalSuccessBox" style="display: none; padding: 18px; background: rgba(191, 161, 106, 0.12); border: 1px solid #BFA16A; border-radius: 6px; color: #222; text-align: center; font-weight: 600; font-size: 14px;">
                Thank you! Your property listing inquiry has been received. Our advisory team will reach out shortly.
            </div>
        </div>
    </div>
    <script>
    window.openListModal = function() {
        const listModal = document.getElementById("listPropertyModal");
        if (listModal) {
            listModal.style.display = "flex";
            document.body.style.overflow = "hidden";
        }
    };
    window.closeListModal = function() {
        const listModal = document.getElementById("listPropertyModal");
        if (listModal) {
            listModal.style.display = "none";
            document.body.style.overflow = "";
        }
    };
    document.getElementById("modalLeadForm")?.addEventListener("submit", async function(e) {
        e.preventDefault();
        const f = this;
        const submitBtn = f.querySelector("button[type='submit']");
        submitBtn.disabled = true;
        submitBtn.textContent = "SUBMITTING...";
        const formData = new FormData(f);
        formData.append("source", "Website");
        formData.append("sub_source", "Project Page Modal");
        formData.append("form_identifier", "project_list_modal");
        formData.append("activity_description", "List Your Property Modal Submission");
        try {
            await fetch("/api/leads", {
                method: "POST",
                body: formData,
                headers: { "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || "" }
            });
        } catch(err){}
        f.style.display = "none";
        document.getElementById("modalSuccessBox").style.display = "block";
        setTimeout(() => {
            window.closeListModal();
            f.reset();
            f.style.display = "grid";
            document.getElementById("modalSuccessBox").style.display = "none";
            submitBtn.disabled = false;
            submitBtn.textContent = "SUBMIT PROPERTY";
        }, 3000);
    });
    </script>
    @include('partials.mobile-sticky-bar')
</body>
</html>

