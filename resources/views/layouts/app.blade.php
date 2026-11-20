<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0">
    <meta name="theme-color" content="#BFA16A">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@php
    $activePage = page_data();
    $siteDefaultTitle = \App\Models\SiteSetting::where('key', 'seo_default_title')->value('value');
    $siteDefaultDesc = \App\Models\SiteSetting::where('key', 'seo_default_description')->value('value');
    $siteDefaultKeywords = \App\Models\SiteSetting::where('key', 'seo_default_keywords')->value('value');
    $sectionTitle = trim($__env->yieldContent('title'));
    $sectionMetaDesc = trim($__env->yieldContent('meta_description'));
    $sectionCanonical = trim($__env->yieldContent('canonical'));
    $sectionOgImage = trim($__env->yieldContent('og_image'));
    $pageMetaTitle = $sectionTitle ?: ($activePage?->meta_title ?: ($siteDefaultTitle ?: 'FS Real Estate Advisory | Top Real Estate Agency in Pakistan'));
    $pageMetaDesc = $sectionMetaDesc ?: ($activePage?->meta_description ?: ($siteDefaultDesc ?: 'New launch projects by Emaar, HMR, Saima, Al Ghafoor & Naya Nazimabad – check prices, floor plans & payment plans. Book now with FS Real Estate Advisory.'));
    $pageMetaKeywords = $activePage?->meta_keywords ?: ($siteDefaultKeywords ?: 'FS Real Estate Advisory, Real Estate Pakistan, Property Investment Pakistan, Luxury Apartments, Villas for Sale, Commercial Projects');
    $pageOgImage = $sectionOgImage ?: ($activePage?->og_image ? (str_starts_with($activePage->og_image, 'http') ? $activePage->og_image : asset($activePage->og_image)) : asset('images/hero/slide-1.jpg'));
    $pageCanonicalUrl = canonical_url($sectionCanonical ?: null);
@endphp
    <title>{{ $pageMetaTitle }}</title> 
    <link rel="canonical" href="{{ $pageCanonicalUrl }}" />
    <meta name="description" content="{{ $pageMetaDesc }}">
    <meta name="keywords" content="{{ $pageMetaKeywords }}">
    <meta name="author" content="FS Real Estate Advisory">
    @if(is_indexing_enabled())
    <meta name="robots" content="index, follow, max-snippet:-1, max-video-preview:-1, max-image-preview:large">
    <meta name="googlebot" content="index, follow">
    @else
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">
    @endif
    <meta name="geo.region" content="PK">
    <meta name="geo.placename" content="Pakistan">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">

    <!-- Header Schemas: Organization, Dynamic FAQPage & RealEstateAgent (JSON-LD) -->
    {!! render_header_schemas($activePage ?? null, $blog ?? null) !!}

    @include('partials.seo-head-scripts')

    <!-- OpenGraph -->
    <meta property="og:title" content="{{ $pageMetaTitle }}">
    <meta property="og:description" content="{{ $pageMetaDesc }}">
    <meta property="og:url" content="{{ $pageCanonicalUrl }}">
    <meta property="og:image" content="{{ $pageOgImage }}">
    <meta property="og:image:secure_url" content="{{ $pageOgImage }}">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FS Real Estate Advisory">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageMetaTitle }}">
    <meta name="twitter:description" content="{{ $pageMetaDesc }}">
    <meta name="twitter:image" content="{{ $pageOgImage }}">

    <!-- Google Fonts: Playfair Display & Ubuntu -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    @include('partials.favicon')

    <!-- Stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/saima.css') }}?v={{ time() }}">

    <!-- Sitewide Brand Theme (#BFA16A Gold & White Navbar) -->
    <style id="sitewide-gold-theme">
    :root {
        --color-primary: #BFA16A !important;
        --color-primary-hover: #aa8d58 !important;
    }

    /* 1. Header & Navigation (White Background #FFFFFF) */
    .header,
    #siteHeader,
    header.header,
    header.sticky-header,
    header[class*="Header"].sticky-header,
    .sticky-header,
    .GolfHeader-module__ZF_nIG__header {
        background: #FFFFFF !important;
        background-color: #FFFFFF !important;
        box-shadow: 0 2px 14px rgba(0, 0, 0, 0.08) !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.06) !important;
    }

    /* Navbar text default color on White background */
    .header .navLink,
    #siteHeader .navLink,
    .GolfHeader-module__ZF_nIG__navLink {
        color: #171717 !important;
        font-weight: 600 !important;
    }
    .header .navLink svg,
    #siteHeader .navLink svg {
        stroke: #171717 !important;
    }

    /* Requirement 2: Navbar text hover color -> #BFA16A */
    .header .navLink:hover,
    #siteHeader .navLink:hover,
    .header .navLink:focus,
    .header #navProjectsBtn:hover,
    .header #navCommercialBtn:hover,
    .header #navDevelopersBtn:hover,
    #siteHeader #navDevelopersBtn:hover,
    .header .navLink:hover svg,
    #siteHeader .navLink:hover svg,
    .dropdownItem:hover,
    .mobileNavLink:hover,
    .GolfHeader-module__ZF_nIG__navLink:hover {
        color: #BFA16A !important;
        stroke: #BFA16A !important;
    }

    /* Requirement 3: Active page nav link underline -> #BFA16A */
    .navLink::after,
    .header .navLink::after,
    #siteHeader .navLink::after,
    .GolfHeader-module__ZF_nIG__navLink::after {
        background-color: #BFA16A !important;
        background: #BFA16A !important;
        height: 2.5px !important;
    }
    .navLinkActive,
    .header .navLinkActive,
    #siteHeader .navLinkActive,
    .GolfHeader-module__ZF_nIG__navItemActive a {
        color: #BFA16A !important;
    }
    .navLinkActive svg,
    .header .navLinkActive svg,
    #siteHeader .navLinkActive svg {
        stroke: #BFA16A !important;
    }
    .navLinkActive::after,
    .header .navLinkActive::after,
    #siteHeader .navLinkActive::after {
        width: 100% !important;
        background-color: #BFA16A !important;
        background: #BFA16A !important;
    }

    /* Mobile toggle icon visible on white header */
    .mobileToggle svg {
        stroke: #171717 !important;
    }

    /* Requirement 1: All Buttons across Website -> background: #BFA16A */
    button:not(#navProjectsBtn):not(#navCommercialBtn):not(#navDevelopersBtn):not(#mobileProjectsToggle):not(#mobileCommercialToggle):not(#mobileDevelopersToggle):not(.mobileToggle):not(.mobileCloseBtn):not(.countryTriggerBtn):not(.faqQuestion):not([class*="faq"]):not(.modalCloseBtn),
    button[type="submit"],
    input[type="submit"],
    a.btn-get-started,
    .btn-get-started,
    .header .btn-get-started,
    .mobileNavList .btn-get-started,
    .cardBookBtn,
    .cardCustom .cardBookBtn,
    .showMoreProjectsBtn,
    .heroBookBtn,
    .heroBtnRow .heroBookBtn,
    #hero .heroBookBtn,
    section[id="hero"] .heroBookBtn,
    [class*="heroSection"] [class*="brochureBtn"],
    [class*="Hero"] [class*="brochureBtn"],
    [class*="__btnRow"] [class*="brochureBtn"],
    [class*="btnRow"] button,
    .heroCard .submitBtn,
    .submitBtn,
    .contactSubmitBtn,
    .saimaSubmitBtn,
    .devCardBtn,
    a.devCardBtn,
    .investmentActionBtn,
    .scrollTopBtn,
    .modalSubmitBtn,
    .sparkleBtn,
    .footer form button[type="submit"],
    .brandCol form button[type="submit"],
    .open-list-modal {
        background: #BFA16A !important;
        background-color: #BFA16A !important;
        border-color: #BFA16A !important;
        color: #ffffff !important;
        box-shadow: 0 4px 14px rgba(191, 161, 106, 0.35) !important;
    }

    /* All Buttons Hover State */
    button:not(#navProjectsBtn):not(#navCommercialBtn):not(#navDevelopersBtn):not(#mobileProjectsToggle):not(#mobileCommercialToggle):not(#mobileDevelopersToggle):not(.mobileToggle):not(.mobileCloseBtn):not(.countryTriggerBtn):not(.faqQuestion):not([class*="faq"]):not(.modalCloseBtn):hover,
    button[type="submit"]:hover,
    input[type="submit"]:hover,
    a.btn-get-started:hover,
    .btn-get-started:hover,
    .header .btn-get-started:hover,
    .mobileNavList .btn-get-started:hover,
    .cardCustom:hover .cardBookBtn,
    .cardBookBtn:hover,
    .showMoreProjectsBtn:hover,
    .heroBookBtn:hover,
    .heroBtnRow .heroBookBtn:hover,
    #hero .heroBookBtn:hover,
    section[id="hero"] .heroBookBtn:hover,
    [class*="heroSection"] [class*="brochureBtn"]:hover,
    [class*="Hero"] [class*="brochureBtn"]:hover,
    [class*="__btnRow"] [class*="brochureBtn"]:hover,
    [class*="btnRow"] button:hover,
    .heroCard .submitBtn:hover,
    .submitBtn:hover,
    .contactSubmitBtn:hover,
    .saimaSubmitBtn:hover,
    .devCardBtn:hover,
    a.devCardBtn:hover,
    .investmentActionBtn:hover,
    .scrollTopBtn:hover,
    .modalSubmitBtn:hover,
    .cardCustom:hover .sparkleBtn,
    .footer form button[type="submit"]:hover,
    .brandCol form button[type="submit"]:hover,
    .open-list-modal:hover {
        background: #aa8d58 !important;
        background-color: #aa8d58 !important;
        border-color: #aa8d58 !important;
        color: #ffffff !important;
        box-shadow: 0 6px 18px rgba(191, 161, 106, 0.5) !important;
    }

    /* Nav Dropdown text buttons must remain transparent */
    .header #navProjectsBtn,
    .header #navCommercialBtn,
    .header #navDevelopersBtn,
    #siteHeader #navProjectsBtn,
    #siteHeader #navCommercialBtn,
    #siteHeader #navDevelopersBtn,
    #navProjectsBtn,
    #navCommercialBtn,
    #navDevelopersBtn,
    #mobileProjectsToggle,
    #mobileCommercialToggle,
    #mobileDevelopersToggle {
        background: none !important;
        background-color: transparent !important;
        border: none !important;
        box-shadow: none !important;
        color: #171717 !important;
    }
    .header #navProjectsBtn:hover,
    .header #navCommercialBtn:hover,
    .header #navDevelopersBtn:hover,
    #siteHeader #navProjectsBtn:hover,
    #siteHeader #navCommercialBtn:hover,
    #siteHeader #navDevelopersBtn:hover,
    #navProjectsBtn:hover,
    #navCommercialBtn:hover,
    #navDevelopersBtn:hover {
        color: #BFA16A !important;
    }

    /* All Icons across Website -> #BFA16A */
    .iconCircle,
    .channelCard .iconCircle,
    .channelCardStatic .iconCircle,
    [class*="iconCircle"],
    .contactFeatureIcon,
    .featureIcon,
    .contactFeatureItem svg,
    .contactInfoCol svg,
    .accentCircle,
    [class*="__accentCircle"],
    .iconWrapper,
    [class*="__iconWrapper"],
    .checkIconGreen,
    .contactIcon,
    .devCardBtn svg,
    .showMoreIcon {
        color: #BFA16A !important;
    }

    .iconCircle,
    .channelCard .iconCircle,
    .channelCardStatic .iconCircle,
    [class*="iconCircle"] {
        background: rgba(191, 161, 106, 0.16) !important;
        color: #BFA16A !important;
    }
    .iconCircle svg,
    .channelCard .iconCircle svg,
    .channelCardStatic .iconCircle svg {
        stroke: #BFA16A !important;
        color: #BFA16A !important;
    }
    .channelCard:hover .iconCircle {
        background: #BFA16A !important;
        color: #ffffff !important;
    }
    .channelCard:hover .iconCircle svg {
        stroke: #ffffff !important;
        color: #ffffff !important;
    }

    .accentCircle,
    [class*="__accentCircle"] {
        background: #BFA16A !important;
    }
    .accentCircle svg,
    .accentCircle img,
    .svgIcon svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }
    .contactFeatureItem svg,
    .contactFeatureIcon {
        color: #BFA16A !important;
        stroke: #BFA16A !important;
    }
    .checkIconGreen {
        background: rgba(191, 161, 106, 0.14) !important;
        color: #BFA16A !important;
    }

    /* Input focus border */
    .phoneUnifiedContainer:focus-within,
    .inputField:focus,
    .textareaField:focus,
    .contactInputField:focus,
    .contactTextareaField:focus,
    .saimaFormInput:focus,
    .modalInputField:focus,
    .modalSelectField:focus,
    .modalTextareaField:focus {
        border-color: #BFA16A !important;
        box-shadow: 0 0 0 3px rgba(191, 161, 106, 0.22) !important;
    }

    /* Section Headers */
    .section-header h2::before,
    .section-header h2::after {
        background: #BFA16A !important;
    }

    /* All Titles, Headings, H1, H2, H3, H4, H5, H6 Across ENTIRE Website -> #BFA16A */
    h1, h2, h3, h4, h5, h6,
    h1 *, h2 *, h3 *, h4 *, h5 *, h6 *,
    article h1, article h2, article h3, article h4, article h5, article h6,
    article h1 *, article h2 *, article h3 *, article h4 *, article h5 *, article h6 *,
    .locMainTitle,
    .locMainTitle *,
    .fsProjectHeroTitle,
    .fsProjectHeroTitle *,
    .fsHeroTitleDark,
    .fsHeroTitleGold,
    .note-editable h1, .note-editable h2, .note-editable h3, .note-editable h4, .note-editable h5, .note-editable h6,
    .note-editable h1 *, .note-editable h2 *, .note-editable h3 *, .note-editable h4 *, .note-editable h5 *, .note-editable h6 *,
    .section-header h2,
    .overviewSection h1,
    .overviewSection h2,
    .overviewSection h3,
    .overviewSection h4,
    .overviewSection h5,
    .overviewSection h6,
    .blogContainer h1,
    .blogContainer h2,
    .blogContainer h3,
    .blogContainer h4,
    .blogContainer h5,
    .blogContainer h6,
    .overviewMainTitle,
    .overviewSubHeading,
    .saimaH2,
    .saimaH3,
    .saimaH4,
    .saimaHighlightHead,
    .saimaContentCol h1,
    .saimaContentCol h2,
    .saimaContentCol h3,
    .saimaContentCol h4,
    .saimaContentCol h5,
    .saimaContentCol h6,
    .saimaDynamicContent h1,
    .saimaDynamicContent h2,
    .saimaDynamicContent h3,
    .saimaDynamicContent h4,
    .saimaDynamicArticleContent h1,
    .saimaDynamicArticleContent h2,
    .saimaDynamicArticleContent h3,
    .saimaDynamicArticleContent h4,
    .saimaLongContentBody h1,
    .saimaLongContentBody h2,
    .saimaLongContentBody h3,
    .saimaLongContentBody h4,
    .saimaShortContent h1,
    .saimaShortContent h2,
    .saimaShortContent h3,
    .saimaShortContent h4,
    .devEditorialBody h1,
    .devEditorialBody h2,
    .devEditorialBody h3,
    .devEditorialBody h4,
    .contactHeroTitle,
    .contactInfoHeading,
    .channelTitle,
    .contactFeatureTitle,
    .featureTitle,
    .faqMainHeading,
    .faqItemOpen .faqQuestion,
    .highlightTitle,
    .amenitiesTitle,
    .galleryTitle,
    .paymentTitle,
    .saimaApptTitle,
    .saimaTocTitle,
    .saimaProjectTag,
    .saimaReadMoreBtn {
        color: #BFA16A !important;
    }

    /* Mobile Drawer & Overlay Layering (Fixes Entire Website Mobile Nav) */
    .mobileDrawerOverlay,
    div[class*="mobileDrawerOverlay"],
    #mobileBackdrop {
        position: fixed !important;
        inset: 0 !important;
        background: rgba(0, 0, 0, 0.72) !important;
        backdrop-filter: blur(4px) !important;
        -webkit-backdrop-filter: blur(4px) !important;
        z-index: 100000 !important;
    }
    .mobileDrawer,
    aside[class*="mobileDrawer"],
    div[class*="mobileDrawer"],
    #mobileDrawer,
    .GolfHeader-module__ZF_nIG__mobileDrawer {
        z-index: 100005 !important;
        background: #111827 !important;
        box-shadow: -8px 0 30px rgba(0, 0, 0, 0.5) !important;
    }
    @media (max-width: 768px) {
        .header,
        #siteHeader,
        .GolfHeader-module__ZF_nIG__header {
            border-bottom: none !important;
            box-shadow: none !important;
        }
        .mobileDrawer,
        #mobileDrawer {
            width: 320px !important;
            max-width: 86vw !important;
        }
    }

    /* Inner spans/strongs in headings */
    .overviewSection h1 *,
    .overviewSection h2 *,
    .overviewSection h3 *,
    .overviewSection h4 *,
    .blogContainer h1 *,
    .blogContainer h2 *,
    .blogContainer h3 *,
    .blogContainer h4 *,
    .saimaContentCol h1 *,
    .saimaContentCol h2 *,
    .saimaContentCol h3 *,
    .saimaContentCol h4 *,
    .saimaDynamicContent h1 *,
    .saimaDynamicContent h2 *,
    .saimaDynamicContent h3 *,
    .saimaDynamicContent h4 *,
    .saimaDynamicArticleContent h1 *,
    .saimaDynamicArticleContent h2 *,
    .saimaDynamicArticleContent h3 *,
    .saimaDynamicArticleContent h4 *,
    .saimaLongContentBody h1 *,
    .saimaLongContentBody h2 *,
    .saimaLongContentBody h3 *,
    .saimaLongContentBody h4 *,
    .devEditorialBody h1 *,
    .devEditorialBody h2 *,
    .devEditorialBody h3 *,
    .devEditorialBody h4 * {
        color: #BFA16A !important;
    }

    /* Accent Badges & Highlights */
    .accentCircle,
    [class*="__accentCircle"] {
        background: #BFA16A !important;
    }
    .investmentLocationBadge,
    .planBadge,
    .channelBadge,
    .contactTitleSmall,
    .contactSectionTag,
    .sectionTag,
    .channelAction,
    .highlightPara,
    .contactHighlightPara,
    .saimaProjectTag,
    .saimaReadMoreBtn,
    .linkItem:hover,
    .contactLink:hover {
        color: #BFA16A !important;
    }
    .checkIconGreen {
        background: rgba(191, 161, 106, 0.14) !important;
        color: #BFA16A !important;
    }

    /* FAQ (Clean White Cards, Light Brand Gold Border on Open) */
    .faqItem {
        background: #ffffff !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 8px !important;
        transition: border-color 0.25s ease, box-shadow 0.25s ease !important;
        overflow: hidden !important;
    }
    .faqItem:hover {
        border-color: #d1d5db !important;
    }
    .faqItemOpen {
        border-color: #BFA16A !important;
        box-shadow: 0 4px 18px rgba(191, 161, 106, 0.16) !important;
    }
    .faqQuestion,
    button.faqQuestion {
        background: transparent !important;
        background-color: transparent !important;
        color: #1a1a1a !important;
        border: none !important;
        box-shadow: none !important;
        transform: none !important;
    }
    .faqQuestion:hover,
    button.faqQuestion:hover {
        background: transparent !important;
        background-color: transparent !important;
        color: #BFA16A !important;
        box-shadow: none !important;
        transform: none !important;
    }
    .faqItemOpen .faqQuestion,
    .faqItemOpen button.faqQuestion {
        color: #BFA16A !important;
        background: transparent !important;
        background-color: transparent !important;
    }
    .faqIcon {
        background: #f3f4f6 !important;
        color: #555555 !important;
    }
    .faqIcon svg {
        stroke: #555555 !important;
    }
    .faqQuestion:hover .faqIcon {
        background: rgba(191, 161, 106, 0.15) !important;
    }
    .faqQuestion:hover .faqIcon svg {
        stroke: #BFA16A !important;
    }
    .faqItemOpen .faqIcon {
        background: #BFA16A !important;
        color: #ffffff !important;
    }
    .faqItemOpen .faqIcon svg {
        stroke: #ffffff !important;
    }

    /* Modals & Dropdown */
    .dropdownItem:hover {
        background: rgba(191, 161, 106, 0.1) !important;
        color: #BFA16A !important;
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

    <!-- Sticky Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- Scroll-To-Top Button -->
    <button type="button" id="scrollTopBtn" class="scrollTopBtn" aria-label="Scroll to top of page">
        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="12" y1="19" x2="12" y2="5"></line>
            <polyline points="5 12 12 5 19 12"></polyline>
        </svg>
    </button>



    <!-- List Your Property Modal -->
    <div id="listPropertyModal" class="modalOverlay" style="display: none;">
        <div class="modalContent">
            <div class="modalHeader">
                <h2 class="modalTitle">LIST YOUR PROPERTY</h2>
                <button type="button" id="modalCloseBtn" class="modalCloseBtn" aria-label="Close modal">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <form id="modalLeadForm" class="modalFormGrid">
                <div>
                    <label class="modalLabel">Name *</label>
                    <input type="text" name="name" required placeholder="Your Name" class="modalInputField">
                </div>

                <div>
                    <label class="modalLabel">Email *</label>
                    <input type="email" name="email" required placeholder="your.email@example.com" class="modalInputField">
                </div>

                <div>
                    <label class="modalLabel">Phone *</label>
                    <div class="phoneUnifiedContainer" style="height: 44px !important;">
                        <div class="countryTriggerWrapper">
                            <button type="button" class="countryTriggerBtn" id="modalCountryBtn" aria-label="Country selector">
                                <span class="flagSlot" id="modalFlagSlot">
                                    <svg width="22" height="15" viewBox="0 0 24 16" class="flagSvg">
                                        <rect width="24" height="5.33" fill="#00732f"/>
                                        <rect y="5.33" width="24" height="5.33" fill="#ffffff"/>
                                        <rect y="10.66" width="24" height="5.34" fill="#000000"/>
                                        <rect width="6" height="16" fill="#fe0000"/>
                                    </svg>
                                </span>
                                <span class="caretDown"></span>
                            </button>
                            <ul class="countryDropdownMenu" id="modalCountryDropdown" style="display: none;"></ul>
                        </div>
                        <input type="tel" name="phone" id="modalPhoneInput" class="phoneInputField" value="+971 " required>
                    </div>
                </div>

                <div>
                    <label class="modalLabel">Property Type *</label>
                    <select name="property_type" class="modalSelectField">
                        <option value="Villa" selected>Villa</option>
                        <option value="Apartment">Apartment</option>
                        <option value="Penthouse">Penthouse</option>
                        <option value="Compound">Compound</option>
                        <option value="Plot">Plot</option>
                        <option value="Showroom">Showroom</option>
                    </select>
                </div>

                <div class="modalFullWidth">
                    <label class="modalLabel">Attachment (Optional)</label>
                    <input type="file" name="attachment" accept="image/*,.pdf" class="modalInputField">
                    <p class="modalFileNote">
                        Upload floor plans, photos, or deed documents (Max 10MB).
                    </p>
                </div>

                <div class="modalFullWidth">
                    <label class="modalLabel">Comments / Specifications</label>
                    <textarea name="comment" rows="3" placeholder="Tell us about the property (bedrooms, plot size, community, expected price)..." class="modalTextareaField"></textarea>
                </div>

                <div class="modalFullWidth">
                    <button type="submit" class="modalSubmitBtn">
                        SUBMIT PROPERTY
                    </button>
                </div>
            </form>

            <div id="modalSuccessBox" class="modalSuccessMessage" style="display: none;">
                ✓ Thank you! Your property listing inquiry has been received. Our luxury portfolio manager will reach out shortly.
            </div>
        </div>
    </div>

    <!-- Universal International Phone Selector (218 Countries Worldwide & Dynamic Validation) -->
    <script src="{{ asset('js/universal-phone-selector.js') }}?v={{ time() }}"></script>


    <!-- Global App Scripts -->
    <script>
    window.openListModal = function() {
        const listModal = document.getElementById("listPropertyModal");
        if (listModal) {
            listModal.style.display = "flex";
            document.body.style.overflow = "hidden";
            if (typeof window.setupPhoneSelector === "function") {
                window.setupPhoneSelector("modalCountryBtn", "modalCountryDropdown", "modalFlagSlot", "modalPhoneInput");
            }
        }
    };

    window.closeListModal = function() {
        const listModal = document.getElementById("listPropertyModal");
        if (listModal) {
            listModal.style.display = "none";
            document.body.style.overflow = "";
        }
    };

    document.addEventListener("DOMContentLoaded", function() {
        // Sticky Header & Scroll Top Button
        window.addEventListener('scroll', () => {
            const header = document.getElementById('siteHeader');
            if (header) {
                if (window.scrollY > 40) {
                    header.classList.add('sticky-header');
                } else {
                    header.classList.remove('sticky-header');
                }
            }

            const scrollBtn = document.getElementById('scrollTopBtn');
            if (scrollBtn) {
                if (window.scrollY > 300) {
                    scrollBtn.classList.add('scrollTopVisible');
                } else {
                    scrollBtn.classList.remove('scrollTopVisible');
                }
            }
        });

        // Scroll to Top action
        document.getElementById('scrollTopBtn')?.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });

        // Modal Controls
        const listModal = document.getElementById("listPropertyModal");
        const closeModalBtn = document.getElementById("modalCloseBtn");

        document.querySelectorAll(".open-list-modal").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                window.openListModal();
            });
        });

        closeModalBtn?.addEventListener("click", window.closeListModal);

        listModal?.addEventListener("click", function(e) {
            if (e.target === listModal) {
                window.closeListModal();
            }
        });

        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                window.closeListModal();
            }
        });

        // Modal Form Submit
        const modalLeadForm = document.getElementById("modalLeadForm");
        modalLeadForm?.addEventListener("submit", async function(e) {
            e.preventDefault();
            const formData = new FormData(modalLeadForm);
            formData.append('source', 'Website');
            formData.append('sub_source', 'fsadvisory.pk');
            formData.append('page_url', window.location.href);
            formData.append('campaign_url', window.location.href);
            formData.append('utm_campaign', new URLSearchParams(window.location.search).get('utm_campaign') || '');
            formData.append('project', 'Saima Project');
            formData.append('developer', 'Saima Group');
            formData.append('community', 'Saima Project');
            formData.append('key_requirement', 'Property Listing Submission: ' + (formData.get('property_type') || ''));
            formData.append('activity_description', 'List Your Property Modal Submission');

            const submitBtn = modalLeadForm.querySelector("button[type='submit']");
            submitBtn.disabled = true;
            submitBtn.textContent = "SUBMITTING...";

            try {
                await fetch("/api/leads", {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || ""
                    },
                    body: formData
                });

                modalLeadForm.style.display = "none";
                document.getElementById("modalSuccessBox").style.display = "block";

                setTimeout(() => {
                    window.closeListModal();
                    modalLeadForm.reset();
                    modalLeadForm.style.display = "grid";
                    document.getElementById("modalSuccessBox").style.display = "none";
                    submitBtn.disabled = false;
                    submitBtn.textContent = "SUBMIT PROPERTY";
                }, 3000);
            } catch (err) {
                console.error(err);
                modalLeadForm.style.display = "none";
                document.getElementById("modalSuccessBox").style.display = "block";
            }
        });
    });
    </script>
    @if($footerScripts = site_setting('footer_scripts'))
    {!! $footerScripts !!}
    @endif
</body>
</html>
