<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $pageMeta = $community->page;
        $pageTitle = $pageMeta?->meta_title ?: ($community->h1 ?: $community->name);
        $pageDesc = $pageMeta?->meta_description ?: (\Illuminate\Support\Str::limit(strip_tags($community->short_content ?: $community->tagline ?: ''), 160));
        $pageKeywords = $pageMeta?->meta_keywords ?: ($community->name . ', real estate, properties');
        $ogImg = $community->image ? (str_starts_with($community->image, 'http') ? $community->image : asset(ltrim($community->image, '/'))) : asset('images/hero/slide-1.jpg');
    @endphp
    <title>{{ $pageTitle }} | FS Real Estate Advisory</title>
    <link rel="canonical" href="{{ canonical_url() }}" />

    @if($pageDesc)
        <meta name="description" content="{{ $pageDesc }}">
    @endif
    @if($pageKeywords)
        <meta name="keywords" content="{{ $pageKeywords }}">
    @endif

    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="geo.region" content="PK">
    <meta name="geo.placename" content="Pakistan">

    <!-- Open Graph Meta Tags -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FS Real Estate Advisory">
    <meta name="author" content="FS Real Estate Advisory">
    <meta property="og:title" content="{{ $community->h1 ?: $community->name }}">
    <meta property="og:description" content="{{ $community->short_content ? strip_tags($community->short_content) : ($community->tagline ?: '') }}">
    <meta property="og:image" content="{{ $ogImg }}">
    <meta property="og:url" content="{{ $community->url }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $community->h1 ?: $community->name }}">
    <meta name="twitter:description" content="{{ $community->short_content ? strip_tags($community->short_content) : '' }}">
    <meta name="twitter:image" content="{{ $ogImg }}">

    @include('partials.seo-head-scripts')
    @include('partials.favicon')

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Libre+Franklin:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{ asset('css/communities/global.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/communities/Saima-golf-estates.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/saima.css') }}?v={{ time() }}">

    <style>
      html {
        scroll-behavior: smooth;
      }
      body {
        margin: 0;
        padding: 0;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #222222;
        background-color: #ffffff;
      }

      /* Global Headings Gold/Green Color (#BFA16A) */
      article h1, article h2, article h3, article h4, article h5, article h6,
      article h1 *, article h2 *, article h3 *, article h4 *, article h5 *, article h6 *,
      .saimaContentCol h1, .saimaContentCol h2, .saimaContentCol h3, .saimaContentCol h4, .saimaContentCol h5, .saimaContentCol h6,
      .saimaContentCol h1 *, .saimaContentCol h2 *, .saimaContentCol h3 *, .saimaContentCol h4 *, .saimaContentCol h5 *, .saimaContentCol h6 *,
      .saimaDynamicContent h1, .saimaDynamicContent h2, .saimaDynamicContent h3, .saimaDynamicContent h4, .saimaDynamicContent h5, .saimaDynamicContent h6,
      .saimaDynamicContent h1 *, .saimaDynamicContent h2 *, .saimaDynamicContent h3 *, .saimaDynamicContent h4 *, .saimaDynamicContent h5 *, .saimaDynamicContent h6 *,
      .saimaLongContentBody h1, .saimaLongContentBody h2, .saimaLongContentBody h3, .saimaLongContentBody h4, .saimaLongContentBody h5, .saimaLongContentBody h6,
      .saimaLongContentBody h1 *, .saimaLongContentBody h2 *, .saimaLongContentBody h3 *, .saimaLongContentBody h4 *, .saimaLongContentBody h5 *, .saimaLongContentBody h6 *,
      .devContentArea h1, .devContentArea h2, .devContentArea h3, .devContentArea h4, .devContentArea h5, .devContentArea h6,
      .devContentArea h1 *, .devContentArea h2 *, .devContentArea h3 *, .devContentArea h4 *, .devContentArea h5 *, .devContentArea h6 * {
        color: #BFA16A !important;
      }

      /* Compact Paragraph and Content Spacing */
      .devContentArea p,
      .saimaLongContentBody p,
      .saimaDynamicContent p {
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        font-size: 14.5px !important;
        font-weight: 400 !important;
        line-height: 1.6 !important;
        margin: 0 0 8px 0 !important;
        color: #2B2B2B !important;
      }
      .devContentArea h2,
      .saimaLongContentBody h2,
      .saimaDynamicContent h2 {
        font-size: 24px !important;
        font-weight: 700 !important;
        margin: 22px 0 6px 0 !important;
      }
      .devContentArea h3,
      .saimaLongContentBody h3,
      .saimaDynamicContent h3 {
        font-size: 18px !important;
        font-weight: 700 !important;
        margin: 14px 0 4px 0 !important;
      }
      .devContentArea h4,
      .saimaLongContentBody h4,
      .saimaDynamicContent h4 {
        font-size: 16px !important;
        font-weight: 700 !important;
        margin: 10px 0 2px 0 !important;
      }

      /* Centered Hero Section */
      .devHeroSection {
        position: relative;
        min-height: 420px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        text-align: center;
      }
      .devHeroOverlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.40) 0%, rgba(0, 0, 0, 0.60) 100%);
        z-index: 1;
      }
      .devHeroContent {
        position: relative;
        z-index: 2;
        max-width: 920px;
        margin: 0 auto;
        padding: 120px 20px 90px;
      }
      .devHeroH1 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(32px, 4.2vw, 52px) !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        line-height: 1.22 !important;
        margin: 0 0 16px 0 !important;
        letter-spacing: -0.015em !important;
        text-shadow: 0 2px 14px rgba(0, 0, 0, 0.65) !important;
      }
      .devHeroTagline {
        font-size: clamp(16px, 1.4vw, 21px) !important;
        font-weight: 400 !important;
        color: rgba(255, 255, 255, 0.95) !important;
        line-height: 1.5 !important;
        margin: 0 !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6) !important;
      }

      /* Featured Property Cards Parity */
      .cardCustom {
          position: relative;
          height: 460px;
          border-radius: 18px;
          overflow: hidden;
          box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
          cursor: pointer;
          transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.35s ease;
          background: #111111;
          display: block;
      }
      .cardCustom:hover {
          transform: translateY(-6px);
          box-shadow: 0 20px 42px rgba(0, 0, 0, 0.22);
      }
      .mainImage {
          width: 100%;
          height: 100%;
          object-fit: cover;
          display: block;
          transition: transform 0.6s ease;
      }
      .cardCustom:hover .mainImage {
          transform: scale(1.06);
      }
      .topTags {
          position: absolute;
          top: 14px;
          left: 14px;
          display: flex;
          flex-direction: column;
          gap: 6px;
          z-index: 3;
      }
      .badgeTag {
          background: rgba(0, 0, 0, 0.55);
          backdrop-filter: blur(8px);
          -webkit-backdrop-filter: blur(8px);
          color: #ffffff;
          font-size: 11.5px;
          font-weight: 600;
          padding: 5px 12px;
          border-radius: 999px;
          width: fit-content;
          letter-spacing: 0.2px;
          border: 1px solid rgba(255, 255, 255, 0.18);
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
      }
      .bottomContent {
          position: absolute;
          bottom: 0;
          left: 0;
          right: 0;
          padding: 35px 20px 22px;
          background: linear-gradient(
              to top,
              rgba(0, 0, 0, 0.94) 0%,
              rgba(0, 0, 0, 0.75) 50%,
              rgba(0, 0, 0, 0.3) 80%,
              transparent 100%
          );
          z-index: 2;
          display: flex;
          flex-direction: column;
          gap: 7px;
      }
      .cardTitle {
          font-size: 21px;
          font-weight: 700;
          color: #ffffff;
          line-height: 1.22;
          margin: 0;
          text-shadow: 0 2px 8px rgba(0, 0, 0, 0.5);
      }
      .cardLocation {
          font-size: 13px;
          color: rgba(255, 255, 255, 0.88);
          margin: 0;
          line-height: 1.4;
          text-shadow: 0 1px 4px rgba(0, 0, 0, 0.5);
      }
      .soldOutBadge {
          position: absolute;
          top: 14px;
          right: 14px;
          background: #ffffff;
          color: #dc2626;
          font-size: 11.5px;
          font-weight: 800;
          -webkit-text-stroke: 0.3px #dc2626;
          padding: 5px 14px;
          border-radius: 999px;
          width: fit-content;
          letter-spacing: 0.3px;
          border: 1px solid rgba(220, 38, 38, 0.25);
          box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
          text-transform: capitalize;
          z-index: 3;
      }

      html, body {
        overflow-x: visible !important;
      }

      /* Dynamic Page Sticky Sidebar */
      .devMainLayout {
          display: flex;
          align-items: flex-start;
          gap: 36px;
          position: relative;
      }
      .devLeftCol {
          flex: 1;
          min-width: 0;
      }
      .devSidebarCol {
          width: 360px;
          flex-shrink: 0;
          position: -webkit-sticky;
          position: sticky;
          top: 85px;
          display: flex;
          flex-direction: column;
          gap: 18px;
          z-index: 20;
      }

      /* Responsive */
      @media (max-width: 991px) {
          .devMainLayout {
              display: flex !important;
              flex-direction: column !important;
          }
          .devSidebarCol {
              width: 100% !important;
              margin-top: 35px !important;
              position: static !important;
              max-height: none !important;
              overflow-y: visible !important;
          }
          .devProjectsGrid {
              grid-template-columns: 1fr !important;
          }
      }
    </style>
</head>
<body>
@php
    $navProjects = get_navbar_projects();
    $navCommercial = get_navbar_commercial();

    // Featured Projects for this Community (Strictly selected in CMS only)
    $featuredProjectIds = is_array($community->featured_projects) ? array_values(array_filter($community->featured_projects)) : [];
    $featuredProjects = collect();
    if (!empty($featuredProjectIds)) {
        $featuredProjects = \App\Models\Project::whereIn('id', $featuredProjectIds)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('status')->orWhere('status', '!=', 'draft');
            })
            ->with('page')
            ->get()
            ->sortBy(function($model) use ($featuredProjectIds) {
                return array_search($model->id, $featuredProjectIds);
            });
    }

    $commFaqs = is_array($community->faqs) ? array_values(array_filter($community->faqs, fn($f) => is_array($f) && !empty(trim($f['q'] ?? ($f['question'] ?? ''))))) : [];
    
    $heroCoverUrl = $community->image 
        ? ((str_starts_with($community->image, 'http') || str_starts_with($community->image, '/')) ? $community->image : asset($community->image))
        : asset('images/hero/slide-1.jpg');

    // Prepare short content with "Read More ↓" appended inline at the end of the text
    $rawShort = trim($community->short_content ?? '');
    $readMoreHtml = ' <a href="#longContent" class="devReadMoreLink" style="display: inline-flex; align-items: center; gap: 4px; font-weight: 700; color: #BFA16A; font-size: 15px; text-decoration: none; border-bottom: 1.5px solid #BFA16A; padding-bottom: 1px; white-space: nowrap; margin-left: 6px; cursor: pointer;">Read More <span style="font-size: 13px;">&darr;</span></a>';
    if (!empty($rawShort)) {
        if (preg_match('/<\/p>\s*$/i', $rawShort)) {
            $shortWithReadMore = preg_replace('/<\/p>\s*$/i', $readMoreHtml . '</p>', $rawShort);
        } else {
            $shortWithReadMore = $rawShort . $readMoreHtml;
        }
    } else {
        $shortWithReadMore = '';
    }
@endphp

    <main style="min-height:100vh;background-color:#ffffff">
        <!-- Header (100% Matching Dynamic Page) -->
        <header class="GolfHeader-module__ZF_nIG__header">
            <div class="container GolfHeader-module__ZF_nIG__headerContainer">
                <a class="GolfHeader-module__ZF_nIG__logoLink" href="/">
                    <img src="{{ asset('FS LOGO n FAVICON-06.svg') }}" alt="FS Real Estate Advisory" class="GolfHeader-module__ZF_nIG__logoImg" style="color:transparent; height: 50px; width: auto; max-height: 54px; object-fit: contain;"/>
                </a>
                <nav class="GolfHeader-module__ZF_nIG__nav">
                    <ul class="GolfHeader-module__ZF_nIG__navList">
                        <li class="GolfHeader-module__ZF_nIG__navItem"><a class="GolfHeader-module__ZF_nIG__navLink" href="/">HOME</a></li>
                        <li class="GolfHeader-module__ZF_nIG__navItem">
                            <a href="/projects" class="GolfHeader-module__ZF_nIG__navLink" style="display:inline-flex;align-items:center;gap:4px">
                                PROJECTS
                                @if($navProjects->isNotEmpty())
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"></path></svg>
                                @endif
                            </a>
                            @if($navProjects->isNotEmpty())
                                <div class="GolfHeader-module__ZF_nIG__dropdownMenu">
                                    @foreach($navProjects as $proj)
                                        <a class="GolfHeader-module__ZF_nIG__dropdownItem" href="{{ $proj->url }}">{{ $proj->title }}</a>
                                    @endforeach
                                </div>
                            @endif
                        </li>
                        @if($navCommercial->isNotEmpty())
                            <li class="GolfHeader-module__ZF_nIG__navItem">
                                <button type="button" class="GolfHeader-module__ZF_nIG__navLink" style="background:none;border:none;cursor:pointer">
                                    COMMERCIAL
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down"><path d="m6 9 6 6 6-6"></path></svg>
                                </button>
                                <div class="GolfHeader-module__ZF_nIG__dropdownMenu">
                                    @foreach($navCommercial as $proj)
                                        <a class="GolfHeader-module__ZF_nIG__dropdownItem" href="{{ $proj->url }}">{{ $proj->title }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        <li class="GolfHeader-module__ZF_nIG__navItem"><a class="GolfHeader-module__ZF_nIG__navLink" href="/developers">DEVELOPERS</a></li>
                        @if(!empty($commFaqs))
                            <li class="GolfHeader-module__ZF_nIG__navItem"><a href="#faq" class="GolfHeader-module__ZF_nIG__navLink">FAQ</a></li>
                        @endif
                        <li class="GolfHeader-module__ZF_nIG__navItem"><a class="GolfHeader-module__ZF_nIG__navLink" href="/contact-us">CONTACT US</a></li>
                    </ul>
                </nav>
                <button type="button" class="GolfHeader-module__ZF_nIG__mobileToggle" aria-label="Toggle navigation menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-menu"><path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path></svg>
                </button>
            </div>
        </header>

        <!-- Mobile Drawer -->
        <div class="GolfHeader-module__ZF_nIG__mobileDrawer">
            <button type="button" class="GolfHeader-module__ZF_nIG__mobileCloseBtn" aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
            </button>
            <ul class="GolfHeader-module__ZF_nIG__mobileNavList">
                <li><a class="GolfHeader-module__ZF_nIG__mobileNavLink" href="/">Home</a></li>
                <li>
                    @if($navProjects->isNotEmpty())
                        <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                            <a href="/projects" class="GolfHeader-module__ZF_nIG__mobileNavLink" style="flex: 1;">Projects</a>
                            <button type="button" class="GolfHeader-module__ZF_nIG__mobileNavLink" style="background: none; border: none; padding: 10px 14px; cursor: pointer;" onclick="const sl = this.parentElement.nextElementSibling; const isO = sl.style.display==='flex'; sl.style.display=isO?'none':'flex'; this.querySelector('svg').style.transform=isO?'none':'rotate(180deg)';">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down" style="transform:none;transition:transform 0.2s"><path d="m6 9 6 6 6-6"></path></svg>
                            </button>
                        </div>
                        <div class="mobileSubList" style="display: none; padding-left: 14px; flex-direction: column; gap: 8px; margin-top: 8px;">
                            @foreach($navProjects as $proj)
                                <a href="{{ $proj->url }}" class="mobileSubItem" style="color: rgba(255, 255, 255, 0.85); font-size: 14px; text-decoration: none; padding: 6px 0; display: block;">{{ $proj->title }}</a>
                            @endforeach
                        </div>
                    @else
                        <a href="/projects" class="GolfHeader-module__ZF_nIG__mobileNavLink">Projects</a>
                    @endif
                </li>
                @if($navCommercial->isNotEmpty())
                    <li>
                        <button type="button" class="GolfHeader-module__ZF_nIG__mobileNavLink">Commercial<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down" style="transform:none;transition:transform 0.2s"><path d="m6 9 6 6 6-6"></path></svg></button>
                        <div class="mobileSubList" style="display: none; padding-left: 14px; flex-direction: column; gap: 8px; margin-top: 8px;">
                            @foreach($navCommercial as $proj)
                                <a href="{{ $proj->url }}" class="mobileSubItem" style="color: rgba(255, 255, 255, 0.85); font-size: 14px; text-decoration: none; padding: 6px 0; display: block;">{{ $proj->title }}</a>
                            @endforeach
                        </div>
                    </li>
                @endif
                <li><a class="GolfHeader-module__ZF_nIG__mobileNavLink" href="/developers">Developers</a></li>
                @if(!empty($commFaqs))
                    <li><a href="#faq" class="GolfHeader-module__ZF_nIG__mobileNavLink">FAQ</a></li>
                @endif
                <li><a class="GolfHeader-module__ZF_nIG__mobileNavLink" href="/contact-us">Contact Us</a></li>
                <li style="margin-top:12px"><button type="button" class="GolfHeader-module__ZF_nIG__listPropBtnMobile" onclick="if(window.openListModal){window.openListModal();}">LIST YOUR PROPERTY</button></li>
            </ul>
        </div>

        <!-- 1. Hero Section: ONLY H1 & Tagline, Centered -->
        <section id="hero" class="devHeroSection" style="background-image: url('{{ $heroCoverUrl }}');">
            <div class="devHeroOverlay"></div>
            <div class="container devHeroContent">
                <h1 class="devHeroH1">{{ $community->h1 ?: $community->name }}</h1>
                @if(!empty($community->tagline))
                    <p class="devHeroTagline">{{ $community->tagline }}</p>
                @endif
            </div>
        </section>

        <!-- 2. Main Top Layout: Left (Short Content + Project Cards + Long Content) | Right Dynamic Sticky Sidebar -->
        <section style="padding: 55px 0 50px 0; background: #ffffff;">
            <div class="container" style="max-width: 1440px; margin: 0 auto; padding: 0 36px;">
                <div class="devMainLayout">
                    
                    <!-- Left Column: Short Content & Featured Project Cards & Full Content -->
                    <div class="devLeftCol" style="flex: 1; min-width: 0;">
                        
                        <!-- Short Content with "Read More ↓" appended inline at the end of the text -->
                        @if(!empty($shortWithReadMore))
                            <div style="margin-bottom: 35px;">
                                <div class="saimaDynamicContent devContentArea" style="font-size: 15.5px; line-height: 1.62; color: #374151;">
                                    {!! $shortWithReadMore !!}
                                </div>
                            </div>
                        @endif

                        <!-- Featured Project Cards -->
                        @if($featuredProjects->isNotEmpty())
                            <div id="projects" style="margin-top: 15px;">
                                <h2 style="font-size: 26px; font-weight: 700; color: #BFA16A; margin: 0 0 22px 0;">Featured Projects</h2>
                                <div class="devProjectsGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;">
                                    @foreach($featuredProjects as $item)
                                        @php
                                            $imgSrc = $item->image_url;
                                            $cardHref = $item->url;
                                            $isSoldOut = ($item->status === 'sold_out') || ($item->page?->status === 'sold_out');
                                        @endphp
                                        <div class="cardCustom" style="cursor: pointer;" onclick="window.location='{{ $cardHref }}'" role="link" tabindex="0" aria-label="{{ $item->title }}">
                                            <div class="topTags">
                                                @if(!empty($item->badges) && is_array($item->badges))
                                                    @foreach($item->badges as $badge)
                                                        <span class="badgeTag">{{ $badge }}</span>
                                                    @endforeach
                                                @endif
                                            </div>

                                            @if($isSoldOut)
                                                <span class="soldOutBadge">Sold out</span>
                                            @endif

                                            <img src="{{ $imgSrc }}" alt="{{ $item->title }} luxury property" class="mainImage" loading="lazy">

                                            <div class="bottomContent">
                                                <h3 class="cardTitle">{{ $item->title }}</h3>
                                                <p class="cardLocation">{{ $item->location ?? ($community->name . ', Pakistan') }}</p>
                                                @include('partials.project-card-actions', ['proj' => $item, 'href' => $cardHref])
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Long Content -->
                        @if(!empty(trim($community->full_content ?? '')))
                            <div id="longContent" style="margin-top: 40px; min-width: 0; overflow-x: auto;">
                                <div class="saimaContentCol saimaDynamicContent saimaLongContentBody devContentArea" style="font-size: 15px; line-height: 1.55; color: #374151;">
                                    {!! $community->full_content !!}
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- Right Column: Sticky Sidebar (NO logo SVG field) -->
                    <aside class="devSidebarCol">
                        <!-- Sidebar Form Widget (WhatsApp, Call, Appointment Form & Custom Searches) -->
                        @include('partials.sidebar-form-widget', ['sbPageTitle' => $community->name])
                    </aside>

                </div>
            </div>
        </section>

        <!-- 4. Static CTA Banner & Contact Options (Call / Consultation / Message) -->
        @include('partials.home-cta-banner', [
            'ctaTitle' => 'Best Real Estate Agency in ' . ($community->name ?? '')
        ])
        @include('partials.home-contact-options')

        <!-- 5. FAQs Section -->
        @if(!empty($commFaqs))
            @include('partials.faq', [
                'customFaqs' => $commFaqs,
                'customHeading' => $community->faq_heading ?: 'Frequently Asked Questions',
                'customSubtitle' => $community->faq_subtitle !== null ? $community->faq_subtitle : ('Got questions about ' . $community->name . '? Find helpful answers below.')
            ])
        @endif

        <!-- 6. Footer -->
        @include('partials.footer')

        <button type="button" class="ScrollToTop-module__bPaVnG__scrollTopBtn" aria-label="Scroll to top of page">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-up"><path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path></svg>
        </button>
    </main>

    <!-- Client JavaScripts -->
    <script src="{{ asset('js/communities/community-interactions.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/universal-phone-selector.js') }}?v={{ time() }}"></script>
    <script>
        document.getElementById('saimaAppointmentForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = form.querySelector('button[type="submit"]');
            const origText = btn.innerText;
            btn.innerText = 'SENDING...';
            btn.disabled = true;

            const data = {
                name: form.querySelector('[name="name"]')?.value || '',
                phone: form.querySelector('[name="phone"]')?.value || '',
                email: form.querySelector('[name="email"]')?.value || '',
                notes: form.querySelector('[name="comment"]')?.value || '',
                source: 'Community Page: {{ $community->name }}',
                _token: '{{ csrf_token() }}'
            };

            fetch('/api/leads', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify(data)
            })
            .then(r => r.json())
            .then(res => {
                btn.innerText = 'SUBMITTED';
                const s = document.getElementById('saimaFormSuccess');
                if (s) {
                    s.style.display = 'block';
                    form.reset();
                }
            })
            .catch(() => {
                btn.innerText = origText;
                btn.disabled = false;
                alert('Thank you! Your request has been received.');
            });
        });
    </script>
</body>
</html>

