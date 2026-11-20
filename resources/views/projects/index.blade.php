@extends('layouts.app')

@php
    $heroSec = $page?->sections?->firstWhere('section_key', 'hero');
    $heroContent = $heroSec ? ($heroSec->content ?? []) : [];
    
    $heroTitle = !empty(trim($heroContent['title'] ?? ($heroContent['heading'] ?? '')))
        ? ($heroContent['title'] ?? $heroContent['heading'])
        : (!empty(trim($page?->title ?? '')) && $page?->slug !== 'projects' ? $page->title : 'Premier Real Estate Projects');

    $heroSubtitle = !empty(trim($heroContent['subtitle'] ?? ($heroContent['tagline'] ?? '')))
        ? ($heroContent['subtitle'] ?? $heroContent['tagline'])
        : 'Discover our exclusive portfolio of verified residential, commercial, and mixed-use property developments across Pakistan.';

    $heroBgImage = !empty(trim($heroContent['bg_image'] ?? ''))
        ? ((str_starts_with($heroContent['bg_image'], 'http') || str_starts_with($heroContent['bg_image'], '/')) ? $heroContent['bg_image'] : asset($heroContent['bg_image']))
        : asset('images/hero/slide-1.jpg');

    // 1. Short Content from CMS (content.intro is primary in CMS admin/pages/{id}/edit?tab=content)
    $contentSec = $page?->sections?->firstWhere('section_key', 'content');
    $contentData = $contentSec ? ($contentSec->content ?? []) : [];
    $aboutSec = $page?->sections?->firstWhere('section_key', 'about');
    $overviewSec = $page?->sections?->firstWhere('section_key', 'overview');

    $shortContent = '';
    if (!empty(trim(strip_tags($contentData['intro'] ?? '')))) {
        $shortContent = $contentData['intro'];
    } elseif (!empty(trim(strip_tags($contentData['description'] ?? '')))) {
        $shortContent = $contentData['description'];
    } elseif (!empty(trim(strip_tags($aboutSec?->content['description'] ?? '')))) {
        $shortContent = $aboutSec->content['description'];
    } elseif (!empty(trim(strip_tags($overviewSec?->content['content'] ?? '')))) {
        $shortContent = $overviewSec->content['content'];
    } elseif (!empty(trim(strip_tags($overviewSec?->content['description'] ?? '')))) {
        $shortContent = $overviewSec->content['description'];
    }

    if (empty(trim(strip_tags($shortContent)))) {
        $shortContent = '<p>Welcome to FS Real Estate Advisory\'s curated portfolio of prime developments. We specialize in connecting discerning homeowners and astute investors with verified residential apartments, master-planned gated villa communities, and dynamic commercial hubs. Every project featured in our portfolio has been evaluated for legal compliance, developer reputation, construction milestones, and long-term capital appreciation potential.</p>';
    }

    // 2. Long Content from CMS (content.html, content.body, or page->body)
    $longContent = '';
    if (!empty(trim(strip_tags($contentData['html'] ?? '')))) {
        $longContent = $contentData['html'];
    } elseif (!empty(trim(strip_tags($contentData['body'] ?? '')))) {
        $longContent = $contentData['body'];
    } elseif (!empty(trim(strip_tags($page?->body ?? '')))) {
        $longContent = $page->body;
    }

    if (empty(trim(strip_tags($longContent)))) {
        $longContent = '<h3>Why Invest in Pakistan\'s Premier Real Estate Developments?</h3>'
            . '<p>Pakistan\'s urban real estate market offers unique capital growth and strong rental yield opportunities, particularly in prime metropolitan corridors like Karachi, Islamabad, and Lahore. With rising demand for modern gated living, state-of-the-art security, and integrated lifestyle amenities, modern projects represent secure tangible assets for local and overseas Pakistani buyers.</p>'
            . '<h3>Flexible Installment & Payment Schedules</h3>'
            . '<p>Most featured developments offer convenient installment schedules spanning 3 to 5 years, allowing buyers to structure their investments without heavy upfront capital outlay. From early pre-launch booking discounts to quarterly milestone payments linked to construction progress, our advisory team helps you navigate the best payment options tailored to your budget.</p>'
            . '<h3>Transparent Advisory & End-to-End Assistance</h3>'
            . '<p>At FS Real Estate Advisory, we guide you through every phase of property acquisition—from initial project comparison and on-ground site visits to booking documentation, payment verification, and eventual handover. Contact our specialized consultants today to find the perfect property that aligns with your lifestyle and financial aspirations.</p>';
    }

    // 3. Project Cards Section Heading & Card Filtering from CMS
    $commSec = $page?->sections?->firstWhere('section_key', 'communities');
    $commData = $commSec ? ($commSec->content ?? []) : [];
    $cardsHeading = !empty(trim($commData['heading'] ?? '')) ? $commData['heading'] : 'Projects';

    $selectedIds = array_values(array_filter((array) ($commData['selected_ids'] ?? ($commData['project_ids'] ?? []))));
    if (!empty($selectedIds)) {
        $idOrderMap = array_flip(array_map('intval', $selectedIds));
        $displayProjects = $projects->filter(fn($p) => isset($idOrderMap[(int)$p->id]))
            ->sortBy(fn($p) => $idOrderMap[(int)$p->id])
            ->values();
    } else {
        $displayProjects = $projects;
    }

    // 4. FAQs from CMS (Section Key: 'faq')
    $faqSec = $page?->sections?->firstWhere('section_key', 'faq');
    $faqData = $faqSec ? ($faqSec->content ?? []) : [];
    $faqHeading = !empty(trim($faqData['heading'] ?? ($faqData['title'] ?? ''))) 
        ? ($faqData['heading'] ?? $faqData['title']) 
        : 'Frequently Asked Questions';
    $faqSub = $faqData['subtitle'] ?? ($faqData['description'] ?? '');
    $rawPageFaqs = $faqData['items'] ?? [];
    $pageFaqs = [];
    if (is_array($rawPageFaqs)) {
        foreach ($rawPageFaqs as $f) {
            $q = trim((string)($f['question'] ?? ($f['q'] ?? '')));
            $a = trim((string)($f['answer'] ?? ($f['a'] ?? '')));
            if ($q !== '' || $a !== '') {
                $pageFaqs[] = ['q' => $q, 'a' => $a];
            }
        }
    }

    $pageMetaTitle = $page?->meta_title ?: 'Real Estate Projects in Pakistan | FS Real Estate Advisory';
    $pageMetaDesc  = $page?->meta_description ?: 'Explore premier residential, commercial, and off-plan real estate projects across Pakistan with verified approvals and flexible installment plans.';
@endphp

@section('title', $pageMetaTitle)
@section('meta_description', $pageMetaDesc)

@section('content')
<style>
    /* ==========================================================
       1. HERO SECTION (Left-Aligned, No Form)
       ========================================================== */
    .projMainHero {
        position: relative;
        min-height: 440px;
        display: flex;
        align-items: center;
        background-image: url('{{ $heroBgImage }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        color: #ffffff;
    }
    .projMainHeroOverlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0.78) 0%, rgba(0, 0, 0, 0.62) 55%, rgba(0, 0, 0, 0.42) 100%);
        z-index: 1;
    }
    .projMainHeroContent {
        position: relative;
        z-index: 2;
        max-width: 880px;
        padding: 100px 0 80px 0;
        text-align: left !important;
    }
    .projMainHeroH1 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(32px, 4.2vw, 52px) !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        line-height: 1.2 !important;
        margin: 0 0 16px 0 !important;
        letter-spacing: -0.015em !important;
        text-shadow: 0 2px 14px rgba(0, 0, 0, 0.65) !important;
        text-align: left !important;
    }
    .projMainHeroTagline {
        font-size: clamp(16px, 1.25vw, 19.5px) !important;
        font-weight: 400 !important;
        color: rgba(255, 255, 255, 0.95) !important;
        line-height: 1.6 !important;
        margin: 0 !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6) !important;
        text-align: left !important;
        max-width: 780px;
    }

    /* ==========================================================
       2. SHORT CONTENT SECTION (Left-Aligned)
       ========================================================== */
    .projShortContentSection {
        padding: 55px 0 20px 0;
        background: #ffffff;
    }
    .projShortContentArea {
        font-size: 16.5px;
        line-height: 1.8;
        color: #374151;
        max-width: 100%;
        text-align: left !important;
    }
    .projShortContentArea p {
        margin: 0 0 16px 0;
        text-align: left !important;
    }
    .projShortContentArea p:last-child {
        margin-bottom: 0;
    }

    /* ==========================================================
       3. HOME PAGE EXACT CARDS STYLING (Larger Cards, Side-by-Side Buttons)
       ========================================================== */
    .projGridSection {
        padding: 25px 0 70px 0;
        background: #ffffff;
    }
    
    /* 3-Column Grid matching Home page — slightly larger cards */
    .projGridSection .communitiesGrid {
        display: grid !important;
        grid-template-columns: repeat(3, 1fr) !important;
        gap: 30px !important;
        width: 100% !important;
    }

    /* Taller, prominent card height */
    .projGridSection .communitiesGrid .cardCustom {
        height: 500px !important;
        position: relative !important;
        border-radius: 18px !important;
        overflow: hidden !important;
        cursor: pointer !important;
        background: #111827 !important;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.12) !important;
        transition: transform 0.35s cubic-bezier(0.165, 0.84, 0.44, 1), box-shadow 0.35s ease !important;
    }

    .projGridSection .communitiesGrid .cardCustom:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 18px 40px rgba(0, 0, 0, 0.22) !important;
    }

    .projGridSection .communitiesGrid .cardCustom .mainImage {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        display: block !important;
        transition: transform 0.5s ease !important;
    }

    .projGridSection .communitiesGrid .cardCustom:hover .mainImage {
        transform: scale(1.06) !important;
    }

    /* Dark vignette gradient overlay for text readability */
    .projGridSection .communitiesGrid .cardCustom::after {
        content: "" !important;
        position: absolute !important;
        inset: 0 !important;
        background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.05) 40%, rgba(0,0,0,0.88) 100%) !important;
        pointer-events: none !important;
        z-index: 2 !important;
    }

    /* Bottom Content Area */
    .projGridSection .communitiesGrid .bottomContent {
        position: absolute !important;
        left: 0 !important;
        right: 0 !important;
        bottom: 0 !important;
        padding: 24px 22px !important;
        z-index: 5 !important;
    }

    .projGridSection .communitiesGrid .cardTitle {
        font-size: 21px !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        margin: 0 0 6px 0 !important;
        line-height: 1.3 !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.7) !important;
    }

    .projGridSection .communitiesGrid .cardLocation {
        font-size: 14px !important;
        color: rgba(255, 255, 255, 0.85) !important;
        margin: 0 0 14px 0 !important;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.6) !important;
    }

    /* BUTTONS SIDE-BY-SIDE (Brabar Brabar me aye) */
    .projGridSection .communitiesGrid .cardBtnRow {
        display: flex !important;
        flex-direction: row !important;
        gap: 12px !important;
        width: 100% !important;
        margin-top: 10px !important;
        position: relative !important;
        z-index: 10 !important;
    }

    .projGridSection .communitiesGrid .cardBtnRow .cardBookBtn {
        flex: 1 1 0 !important;
        width: 50% !important;
        margin: 0 !important;
        padding: 12px 8px !important;
        text-decoration: none !important;
        cursor: pointer !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        border-radius: 999px !important;
        text-align: center !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: #BFA16A !important;
        color: #ffffff !important;
        border: 1.5px solid #BFA16A !important;
        box-shadow: 0 4px 14px rgba(191, 161, 106, 0.35) !important;
        transition: all 0.25s ease !important;
        pointer-events: auto !important;
    }

    .projGridSection .communitiesGrid .cardBtnRow .cardBookBtn:hover {
        background: #aa8d58 !important;
        border-color: #aa8d58 !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(191, 161, 106, 0.5) !important;
    }

    /* WHATSAPP BUTTON (Semi-transparent with border, exactly like Home page) */
    .projGridSection .communitiesGrid .cardBtnRow .cardWaBtn {
        background: rgba(0, 0, 0, 0.5) !important;
        color: #ffffff !important;
        border: 1.5px solid rgba(255, 255, 255, 0.45) !important;
        box-shadow: none !important;
    }

    .projGridSection .communitiesGrid .cardBtnRow .cardWaBtn:hover {
        background: #BFA16A !important;
        border-color: #BFA16A !important;
        color: #ffffff !important;
        box-shadow: 0 6px 18px rgba(191, 161, 106, 0.5) !important;
    }

    /* Responsive Grid */
    @media (max-width: 991px) {
        .projGridSection .communitiesGrid {
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 22px !important;
        }
        .projGridSection .communitiesGrid .cardCustom {
            height: 480px !important;
        }
    }

    @media (max-width: 640px) {
        .projGridSection .communitiesGrid {
            grid-template-columns: 1fr !important;
            max-width: 420px !important;
            margin: 0 auto !important;
            gap: 24px !important;
        }
        .projGridSection .communitiesGrid .cardCustom {
            height: 460px !important;
        }
    }

    /* Show More Button */
    .showMoreProjectsContainer {
        display: flex;
        justify-content: center;
        align-items: center;
        margin-top: 50px;
        padding-bottom: 10px;
    }
    .showMoreProjectsBtn {
        background: #BFA16A;
        color: #ffffff;
        font-family: inherit;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.8px;
        text-transform: uppercase;
        padding: 13px 40px;
        border-radius: 999px;
        border: 1.5px solid #BFA16A;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 4px 14px rgba(191, 161, 106, 0.3);
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .showMoreProjectsBtn:hover {
        background: #aa8d58;
        border-color: #aa8d58;
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(191, 161, 106, 0.45);
    }
    .showMoreProjectsBtn:active {
        transform: translateY(0);
        box-shadow: 0 2px 8px rgba(191, 161, 106, 0.3);
    }
    .showMoreProjectsBtn .showMoreIcon {
        transition: transform 0.3s ease;
    }
    .showMoreProjectsBtn:hover .showMoreIcon {
        transform: translateY(2px);
    }
    .community-card-hidden {
        display: none !important;
    }
    @keyframes fadeInProjectCard {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .cardCustom.card-just-revealed {
        animation: fadeInProjectCard 0.45s cubic-bezier(0.165, 0.84, 0.44, 1) forwards;
    }

    /* ==========================================================
       4. LONG CONTENT SECTION (Clean & Elegant)
       ========================================================== */
    .projLongContentSection {
        padding: 60px 0 85px 0;
        background: #fbfbfc;
        border-top: 1px solid #f1f5f9;
    }
    .projLongContentCard {
        background: #ffffff;
        border: 1px solid #eef2f6;
        border-radius: 14px;
        padding: 45px 50px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
    }
    .projLongContentBody {
        font-size: 15.5px;
        line-height: 1.8;
        color: #374151;
        text-align: left !important;
    }
    .projLongContentBody h1,
    .projLongContentBody h2,
    .projLongContentBody h3,
    .projLongContentBody h4 {
        font-family: 'Playfair Display', Georgia, serif;
        color: #BFA16A !important;
        margin-top: 32px;
        margin-bottom: 12px;
        font-weight: 700;
        text-align: left !important;
    }
    .projLongContentBody h1:first-child,
    .projLongContentBody h2:first-child,
    .projLongContentBody h3:first-child {
        margin-top: 0;
    }
    .projLongContentBody h3 {
        font-size: 22px;
        color: #BFA16A !important;
    }
    .projLongContentBody p {
        margin-bottom: 16px;
        text-align: left !important;
    }
    .projLongContentBody p:last-child {
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .projLongContentCard {
            padding: 30px 20px;
        }
    }
</style>

<!-- 1. HERO SECTION (Left-Aligned, NO Form) -->
<section class="projMainHero">
    <div class="projMainHeroOverlay"></div>
    <div class="container" style="max-width: 1280px; margin: 0 auto; padding: 0 24px; position: relative; z-index: 2; width: 100%;">
        <div class="projMainHeroContent">
            <h1 class="projMainHeroH1">{{ $heroTitle }}</h1>
            @if(!empty($heroSubtitle))
                <p class="projMainHeroTagline">{{ $heroSubtitle }}</p>
            @endif
        </div>
    </div>
</section>

<!-- 2. SHORT CONTENT SECTION (Left-Aligned with Seamless Inline Read More) -->
@if(!empty($shortContent))
<section class="projShortContentSection">
    <div class="container" style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div class="projShortContentArea">
            @php
                $inlineReadMoreHtml = '<a href="#projectsOverviewSection" class="projInlineReadMoreLink" onclick="event.preventDefault(); document.getElementById(\'projectsOverviewSection\')?.scrollIntoView({behavior:\'smooth\'});" style="display: inline; color: #BFA16A; font-weight: 700; text-decoration: none; margin-left: 6px; cursor: pointer; white-space: nowrap; font-size: 15.5px;">Read More &darr;</a>';
                $trimmedShort = trim($shortContent);
                if (str_contains($trimmedShort, '</p>')) {
                    $lastPos = strrpos($trimmedShort, '</p>');
                    $finalShortContent = substr_replace($trimmedShort, ' ' . $inlineReadMoreHtml . '</p>', $lastPos, 4);
                } else {
                    $finalShortContent = $trimmedShort . ' ' . $inlineReadMoreHtml;
                }
            @endphp
            {!! $finalShortContent !!}
        </div>
    </div>
</section>
@endif

<!-- 3. PROJECT CARDS SECTION (Same Home Page Styling & Side-by-Side Buttons) -->
<section class="projGridSection" id="projCardsGridSection">
    <div class="container" style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <!-- Section Header with — Projects — styling -->
        <div class="section-header" style="padding-bottom: 36px;">
            <h2>{{ $cardsHeading }}</h2>
        </div>

        <!-- 3-Column Grid matching Home Page -->
        <div class="communitiesGrid" id="communitiesGrid">
            @forelse($displayProjects as $index => $item)
                @php
                    $targetUrl = $item->url;
                    $imgSrc = $item->image_url;
                    $isSoldOut = ($item->status === 'sold_out') || ($item->page?->status === 'sold_out');
                    $isHidden = $index >= 9;

                    $rawSlug = $item->slug ?: ($item->page?->slug ?? '');
                    $cleanSlug = ltrim(preg_replace('#^project/#', '', ltrim($rawSlug, '/')), '/');
                    $publicDomain = 'https://fsadvisory.pk';
                    $projectFullUrl = $cleanSlug ? ($publicDomain . '/project/' . $cleanSlug) : $publicDomain;
                    $waMessage = "Hello FS Advisory, I am interested in {$item->title}. Please share details.\n{$projectFullUrl}";
                    $waUrl = 'https://wa.me/923322495575?text=' . rawurlencode($waMessage);
                @endphp
                <div class="cardCustom {{ $isHidden ? 'community-card-hidden' : '' }}" style="{{ $isHidden ? 'display: none;' : '' }}" onclick="window.location='{{ $targetUrl }}'" role="link" tabindex="0">
                    <!-- Invisible stretch link -->
                    <a href="{{ $targetUrl }}" class="cardStretchLink" aria-label="{{ $item->title }}" tabindex="-1"></a>

                    <!-- Top-Left Badges (New, Offer, Off plan, Ready) -->
                    <div class="topTags">
                        @if(!empty($item->badges) && is_array($item->badges))
                            @foreach($item->badges as $badge)
                                <span class="badgeTag">{{ $badge }}</span>
                            @endforeach
                        @endif
                    </div>

                    <!-- Top-Right Sold out Badge -->
                    @if($isSoldOut)
                        <span class="soldOutBadge">Sold out</span>
                    @endif

                    <!-- Main Project Photo -->
                    <img src="{{ $imgSrc }}" alt="{{ $item->title }} luxury property" class="mainImage" loading="lazy">

                    <!-- Bottom Content Area -->
                    <div class="bottomContent">
                        <!-- Project Title -->
                        <h3 class="cardTitle">{{ $item->title }}</h3>

                        <!-- Location -->
                        <p class="cardLocation">{{ $item->location ?? 'Karachi, Pakistan' }}</p>

                        <!-- Two Buttons SIDE-BY-SIDE: Details + WhatsApp -->
                        <div class="cardBtnRow">
                            <a href="{{ $targetUrl }}" class="cardBookBtn" onclick="event.stopPropagation()">Details</a>
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="cardBookBtn cardWaBtn" onclick="event.stopPropagation()">WhatsApp</a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; color: #94a3b8;">
                    <p style="font-size: 16px; margin: 0;">No active projects available at the moment.</p>
                </div>
            @endforelse
        </div>

        <!-- Show More Button (Visible when more than 9 projects exist) -->
        @if($displayProjects->count() > 9)
            <div class="showMoreProjectsContainer" id="showMoreProjectsContainer">
                <button type="button" id="showMoreProjectsBtn" class="showMoreProjectsBtn" aria-label="Show More Projects">
                    <span>Show More</span>
                    <svg class="showMoreIcon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 12 15 18 9"></polyline>
                    </svg>
                </button>
            </div>
        @endif
    </div>
</section>

<!-- 4. LONG CONTENT SECTION (Informational / SEO Content) -->
@if(!empty($longContent))
<section id="projectsOverviewSection" class="projLongContentSection">
    <div class="container" style="max-width: 1280px; margin: 0 auto; padding: 0 24px;">
        <div class="projLongContentCard">
            <div class="projLongContentBody">
                {!! $longContent !!}
            </div>
        </div>
    </div>
</section>
@endif

<!-- 5. STATIC SECTION (Ready to Make Your Next Real Estate Move? + Contact Options) -->
@include('partials.home-cta-banner')
@include('partials.home-contact-options')

<!-- 6. STATIC ADVISOR BANNER (Interested in an off-plan investment? + Modal Form) — ABOVE FAQs -->
@include('partials.advisor-banner')

<!-- 7. FAQs SECTION (from CMS) -->
@if(!empty($pageFaqs))
    @include('partials.faq', [
        'customFaqs' => $pageFaqs,
        'customHeading' => $faqHeading,
        'customSubtitle' => $faqSub
    ])
@endif

<!-- Client Scripts for Show More -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const showMoreBtn = document.getElementById('showMoreProjectsBtn');
    const container = document.getElementById('showMoreProjectsContainer');
    if (!showMoreBtn) return;

    showMoreBtn.addEventListener('click', function () {
        const hiddenCards = Array.from(document.querySelectorAll('.cardCustom.community-card-hidden'));
        if (hiddenCards.length === 0) {
            if (container) container.style.display = 'none';
            return;
        }

        // Show next 9 cards (3 rows of 3 columns)
        const batchSize = 9;
        const nextBatch = hiddenCards.slice(0, batchSize);

        nextBatch.forEach(function (card) {
            card.classList.remove('community-card-hidden');
            card.style.display = 'block';
            card.classList.add('card-just-revealed');
        });

        // Hide button when all cards are revealed
        if (hiddenCards.length <= batchSize) {
            if (container) {
                container.style.transition = 'opacity 0.3s ease';
                container.style.opacity = '0';
                setTimeout(function () {
                    container.style.display = 'none';
                }, 300);
            }
        }
    });
});
</script>
@endsection
