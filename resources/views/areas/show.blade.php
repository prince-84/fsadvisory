<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $community->meta_title ?? (($community->h1 ?: $community->name) . ' | FS Real Estate Advisory') }}</title>
    <link rel="canonical" href="{{ canonical_url() }}" />

    @php
        $commMetaDesc = $community->meta_description ?? null;
        $commMetaKw   = $community->meta_keywords ?? null;
        $commOgTitle  = $community->og_title ?? ($community->h1 ?: $community->name);
        $commOgDesc   = $community->og_description ?? ($community->short_content ? strip_tags($community->short_content) : ($community->tagline ?? ''));
        $commOgImg    = $community->og_image ?? $community->image ?? '';
        if ($commOgImg && !str_starts_with($commOgImg, 'http') && !str_starts_with($commOgImg, '//')) {
            $commOgImg = asset($commOgImg);
        }
        // Page-level SEO fallback
        if (!$commMetaDesc && isset($page)) {
            $commMetaDesc = $page->meta_description ?? null;
        }
    @endphp

    @if($commMetaDesc)
        <meta name="description" content="{{ $commMetaDesc }}">
    @else
        <meta name="description" content="{{ \Illuminate\Support\Str::limit(strip_tags($community->short_content ?: $community->tagline ?? ''), 160) }}">
    @endif
    @if($commMetaKw)
        <meta name="keywords" content="{{ $commMetaKw }}">
    @endif

    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <meta name="geo.region" content="PK">
    <meta name="geo.placename" content="Pakistan">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="FS Real Estate Advisory">
    <meta name="author" content="FS Real Estate Advisory">
    <meta property="og:title" content="{{ $commOgTitle }}">
    <meta property="og:description" content="{{ $commOgDesc }}">
    <meta property="og:image" content="{{ $commOgImg }}">
    <meta property="og:url" content="{{ url('/area/' . $community->slug) }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $commOgTitle }}">
    <meta name="twitter:description" content="{{ $commOgDesc }}">
    <meta name="twitter:image" content="{{ $commOgImg }}">

    <!-- Header Schemas: Organization, Dynamic FAQPage & RealEstateAgent (JSON-LD) -->
    {!! render_header_schemas($community->page ?? ($page ?? null), null, is_array($community->faqs ?? null) ? $community->faqs : null) !!}

    @include('partials.seo-head-scripts')
    @include('partials.favicon')

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800;900&family=Libre+Franklin:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,600;1,700&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,700&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/communities/global.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/communities/Saima-golf-estates.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/saima.css') }}?v={{ time() }}">

    <style>
      html { scroll-behavior: smooth; }
      body {
        margin: 0; padding: 0;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        color: #222222; background-color: #ffffff;
      }

      article h1, article h2, article h3, article h4, article h5, article h6,
      .saimaContentCol h1, .saimaContentCol h2, .saimaContentCol h3,
      .saimaDynamicContent h1, .saimaDynamicContent h2, .saimaDynamicContent h3,
      .saimaLongContentBody h1, .saimaLongContentBody h2, .saimaLongContentBody h3,
      .devContentArea h1, .devContentArea h2, .devContentArea h3,
      .devContentArea h4, .devContentArea h5, .devContentArea h6 {
        color: #BFA16A !important;
      }

      .devContentArea p, .saimaLongContentBody p, .saimaDynamicContent p {
        font-size: 15px !important; line-height: 1.55 !important;
        margin: 0 0 8px 0 !important; color: #374151 !important;
      }
      .devContentArea h2, .saimaLongContentBody h2, .saimaDynamicContent h2 {
        font-size: 24px !important; font-weight: 700 !important; margin: 22px 0 6px 0 !important;
      }
      .devContentArea h3, .saimaLongContentBody h3, .saimaDynamicContent h3 {
        font-size: 18px !important; font-weight: 700 !important; margin: 14px 0 4px 0 !important;
      }

      /* Hero */
      .devHeroSection {
        position: relative; min-height: 480px; display: flex; align-items: flex-end;
        background-size: cover; background-position: center; background-repeat: no-repeat;
      }
      .devHeroOverlay {
        position: absolute; inset: 0;
        background: linear-gradient(to bottom, rgba(0,0,0,0.18) 0%, rgba(0,0,0,0.65) 100%);
        z-index: 1;
      }
      .devHeroContent {
        position: relative; z-index: 2; padding-bottom: 52px; padding-top: 32px;
      }
      .devHeroH1 {
        font-family: 'Playfair Display', Georgia, serif; font-size: clamp(28px,5vw,52px);
        font-weight: 800; color: #ffffff; margin: 0 0 10px 0; line-height: 1.18; text-shadow: 0 2px 10px rgba(0,0,0,0.3);
      }
      .devHeroTagline {
        font-size: 18px; color: rgba(255,255,255,0.88); margin: 0; font-weight: 400; max-width: 650px;
      }

      /* Main layout */
      .devMainLayout {
        display: flex; gap: 40px; align-items: flex-start;
      }
      .devLeftCol { flex: 1; min-width: 0; }
      .devSidebarCol {
        width: 320px; min-width: 280px; max-width: 340px; flex-shrink: 0;
        position: sticky; top: 90px; align-self: flex-start;
        display: flex; flex-direction: column; gap: 18px;
      }

      /* Project Cards Grid */
      .devProjectsGrid {
        display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 24px;
      }

      /* Sidebar Widgets */
      .saimaProjectsWidget { background: #f7f5f2; border-radius: 10px; padding: 20px; }
      .saimaProjectsHeader {
        font-size: 11px; font-weight: 700; letter-spacing: 1.5px; color: #BFA16A;
        text-transform: uppercase; margin-bottom: 14px; padding-bottom: 8px;
        border-bottom: 1px solid #e5d7c1;
      }

      @media (max-width: 1024px) {
        .devMainLayout { flex-direction: column; }
        .devSidebarCol {
          width: 100%; max-width: 100%; min-width: 0;
          position: static; top: auto;
        }
      }
      @media (max-width: 600px) {
        .devProjectsGrid { grid-template-columns: 1fr !important; }
      }
    </style>
</head>
<body>
@php
    $navProjects  = get_navbar_projects();
    $navCommercial = get_navbar_commercial();

    // Featured Projects for this Community (Strictly selected in CMS only)
    $featuredProjectIds = is_array($community->featured_projects) ? array_values(array_filter($community->featured_projects)) : [];
    $featuredProjects = collect();
    if (!empty($featuredProjectIds)) {
        $featuredProjects = \App\Models\Project::whereIn('id', $featuredProjectIds)
            ->where('is_active', true)
            ->where(function($q) { $q->whereNull('status')->orWhere('status', '!=', 'draft'); })
            ->with('page')
            ->get()
            ->sortBy(function($model) use ($featuredProjectIds) {
                return array_search($model->id, $featuredProjectIds);
            });
    }

    // Latest Projects for sidebar
    $latestProjects = \App\Models\Project::where('is_active', true)
        ->where(function($q) { $q->whereNull('status')->orWhere('status', '!=', 'draft'); })
        ->orderBy('order', 'asc')->orderBy('id', 'desc')->take(5)->get();

    $commFaqs = is_array($community->faqs) ? array_values(array_filter($community->faqs, fn($f) => is_array($f) && !empty(trim($f['q'] ?? ($f['question'] ?? ''))))) : [];

    $heroCoverUrl = $community->image
        ? ((str_starts_with($community->image, 'http') || str_starts_with($community->image, '/')) ? $community->image : asset($community->image))
        : asset('images/hero/slide-1.jpg');

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
        <!-- Header -->
        <header class="GolfHeader-module__ZF_nIG__header">
            <div class="container GolfHeader-module__ZF_nIG__headerContainer">
                <a class="GolfHeader-module__ZF_nIG__logoLink" href="/">
                    <img src="{{ asset('FS LOGO n FAVICON-06.svg') }}" alt="FS Real Estate Advisory" class="GolfHeader-module__ZF_nIG__logoImg" style="color:transparent; height: 50px; width: auto; max-height: 54px; object-fit: contain;"/>
                </a>
                <nav class="GolfHeader-module__ZF_nIG__nav">
                    <ul class="GolfHeader-module__ZF_nIG__navList">
                        <li class="GolfHeader-module__ZF_nIG__navItem"><a class="GolfHeader-module__ZF_nIG__navLink" href="/">HOME</a></li>
                        @if($navProjects->isNotEmpty())
                            <li class="GolfHeader-module__ZF_nIG__navItem">
                                <button type="button" class="GolfHeader-module__ZF_nIG__navLink" style="background:none;border:none;cursor:pointer">
                                    PROJECTS
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"></path></svg>
                                </button>
                                <div class="GolfHeader-module__ZF_nIG__dropdownMenu">
                                    @foreach($navProjects as $proj)
                                        <a class="GolfHeader-module__ZF_nIG__dropdownItem" href="{{ $proj->url }}">{{ $proj->title }}</a>
                                    @endforeach
                                </div>
                            </li>
                        @endif
                        @if($navCommercial->isNotEmpty())
                            <li class="GolfHeader-module__ZF_nIG__navItem">
                                <button type="button" class="GolfHeader-module__ZF_nIG__navLink" style="background:none;border:none;cursor:pointer">
                                    COMMERCIAL
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 9 6 6 6-6"></path></svg>
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
                        <li class="GolfHeader-module__ZF_nIG__navItem">
                            <button type="button" class="GolfHeader-module__ZF_nIG__listPropBtn" onclick="if(window.openListModal){window.openListModal();}">LIST YOUR PROPERTY</button>
                        </li>
                    </ul>
                </nav>
                <button type="button" class="GolfHeader-module__ZF_nIG__mobileToggle" aria-label="Toggle navigation menu">
                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 5h16"></path><path d="M4 12h16"></path><path d="M4 19h16"></path></svg>
                </button>
            </div>
        </header>

        <!-- Mobile Drawer -->
        <div class="GolfHeader-module__ZF_nIG__mobileDrawer">
            <button type="button" class="GolfHeader-module__ZF_nIG__mobileCloseBtn" aria-label="Close menu">
                <svg xmlns="http://www.w3.org/2000/svg" width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
            <ul class="GolfHeader-module__ZF_nIG__mobileNavList">
                <li><a class="GolfHeader-module__ZF_nIG__mobileNavLink" href="/">Home</a></li>
                @if($navProjects->isNotEmpty())
                    <li>
                        <button type="button" class="GolfHeader-module__ZF_nIG__mobileNavLink">Projects<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transform:none;transition:transform 0.2s"><path d="m6 9 6 6 6-6"></path></svg></button>
                        <div class="mobileSubList" style="display: none; padding-left: 14px; flex-direction: column; gap: 8px; margin-top: 8px;">
                            @foreach($navProjects as $proj)
                                <a href="{{ $proj->url }}" class="mobileSubItem" style="color: rgba(255,255,255,0.85); font-size: 14px; text-decoration: none; padding: 6px 0; display: block;">{{ $proj->title }}</a>
                            @endforeach
                        </div>
                    </li>
                @endif
                @if($navCommercial->isNotEmpty())
                    <li>
                        <button type="button" class="GolfHeader-module__ZF_nIG__mobileNavLink">Commercial<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="transform:none;transition:transform 0.2s"><path d="m6 9 6 6 6-6"></path></svg></button>
                        <div class="mobileSubList" style="display: none; padding-left: 14px; flex-direction: column; gap: 8px; margin-top: 8px;">
                            @foreach($navCommercial as $proj)
                                <a href="{{ $proj->url }}" class="mobileSubItem" style="color: rgba(255,255,255,0.85); font-size: 14px; text-decoration: none; padding: 6px 0; display: block;">{{ $proj->title }}</a>
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

        <!-- Hero Section -->
        <section id="hero" class="devHeroSection" style="background-image: url('{{ $heroCoverUrl }}');">
            <div class="devHeroOverlay"></div>
            <div class="container devHeroContent">
                <h1 class="devHeroH1">{{ $community->h1 ?: $community->name }}</h1>
                @if(!empty($community->tagline))
                    <p class="devHeroTagline">{{ $community->tagline }}</p>
                @endif
            </div>
        </section>

        <!-- Main Content: Short Content + Projects | Sidebar -->
        <section style="padding: 55px 0 50px 0; background: #ffffff;">
            <div class="container" style="max-width: 1440px; margin: 0 auto; padding: 0 36px;">
                <div class="devMainLayout">

                    <!-- Left Column -->
                    <div class="devLeftCol" style="flex: 1; min-width: 0;">

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
                                            $imgSrc   = $item->image_url;
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
                                            <img src="{{ $imgSrc }}" alt="{{ $item->title }}" class="mainImage" loading="lazy">
                                            <div class="bottomContent">
                                                <h3 class="cardTitle">{{ $item->title }}</h3>
                                                <p class="cardLocation">{{ $item->location ?? $community->name }}</p>
                                                @include('partials.project-card-actions', ['proj' => $item, 'href' => $cardHref])
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Long / Full Content -->
                        @if(!empty(trim($community->full_content ?? '')))
                            <div id="longContent" style="margin-top: 40px; min-width: 0; overflow-x: auto;">
                                <div class="saimaContentCol saimaDynamicContent saimaLongContentBody devContentArea" style="font-size: 15px; line-height: 1.55; color: #374151;">
                                    {!! $community->full_content !!}
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- Right: Sticky Sidebar -->
                    <aside class="devSidebarCol">
                        @include('partials.sidebar-form-widget', ['sbPageTitle' => $community->name])
                    </aside>

                </div>
            </div>
        </section>

        <!-- FAQs Section -->
        @if(!empty($commFaqs))
            @include('partials.faq', [
                'customFaqs'     => $commFaqs,
                'customHeading'  => $community->faq_heading ?: 'Frequently Asked Questions',
                'customSubtitle' => $community->faq_subtitle !== null ? $community->faq_subtitle : ('Got questions about ' . $community->name . '? Find helpful answers below.')
            ])
        @endif

        <!-- Footer -->
        @include('partials.footer')

        <button type="button" class="ScrollToTop-module__bPaVnG__scrollTopBtn" aria-label="Scroll to top of page">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m5 12 7-7 7 7"></path><path d="M12 19V5"></path></svg>
        </button>
    </main>

    <script src="{{ asset('js/communities/community-interactions.js') }}?v={{ time() }}"></script>
    <script src="{{ asset('js/universal-phone-selector.js') }}?v={{ time() }}"></script>
    <script>
        document.getElementById('saimaAppointmentForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const form = this;
            const btn = form.querySelector('button[type="submit"]');
            const origText = btn.innerText;
            btn.innerText = 'SENDING...'; btn.disabled = true;
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
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify(data)
            })
            .then(r => r.json())
            .then(() => {
                btn.innerText = 'SUBMITTED';
                const s = document.getElementById('saimaFormSuccess');
                if (s) { s.style.display = 'block'; form.reset(); }
            })
            .catch(() => { btn.innerText = origText; btn.disabled = false; alert('Thank you! Your request has been received.'); });
        });
    </script>
    @include('partials.mobile-sticky-bar')
</body>
</html>

