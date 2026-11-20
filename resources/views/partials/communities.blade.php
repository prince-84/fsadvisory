@php
$dbHeading = page_section('communities', 'heading', 'Projects');

// Retrieve Home page or current page communities section data
$curPage = page_data('/') ?? (page_data('home') ?? page_data());
$commSec = $curPage ? $curPage->sections()->whereIn('section_key', ['communities', 'projects'])->first() : null;
$commSecData = $commSec ? ($commSec->content ?? []) : [];
$unselectedProjectIds = (array) ($commSecData['unselected_ids'] ?? []);
$selectedProjectIds = (array) ($commSecData['selected_ids'] ?? ($commSecData['project_ids'] ?? []));

$allDbProjects = \App\Models\Project::where('is_active', true)
    ->where(function($q) {
        $q->whereNull('status')->orWhere('status', '!=', 'draft');
    })
    ->whereDoesntHave('page', function($q) {
        $q->where('status', 'draft')->orWhere('is_published', false);
    })
    ->with('page')
    ->orderBy('order', 'asc')
    ->get();

if (!empty($unselectedProjectIds) || !empty($selectedProjectIds)) {
    // Exclude projects explicitly unselected by mouse in CMS
    $unselectedInts = array_map('intval', $unselectedProjectIds);
    $filteredProjects = $allDbProjects->reject(function($p) use ($unselectedInts) {
        return in_array((int)$p->id, $unselectedInts, true);
    });

    // If custom order of selected cards was saved, preserve it; append new projects at the end
    if (!empty($selectedProjectIds)) {
        $idOrderMap = array_flip(array_map('intval', $selectedProjectIds));
        $dbProjects = $filteredProjects->sortBy(function($p) use ($idOrderMap) {
            return $idOrderMap[(int)$p->id] ?? -1;
        })->values();
    } else {
        $dbProjects = $filteredProjects->values();
    }
} else {
    // By default, show all active projects (any newly added project is included by default)
    $dbProjects = $allDbProjects;
}

$hasDbProjects = $dbProjects->isNotEmpty();

@endphp

<section id="communities" aria-label="Featured Residential Projects and Communities" class="communitiesSection">
    <div class="container">
        <!-- Section Header -->
        <div class="section-header" style="padding-bottom: 40px;">
            <h2>{{ $dbHeading }}</h2>
        </div>

        <!-- Communities Grid (3 Columns x 3 Rows = 9 Cards Initially) -->
        <div class="communitiesGrid" id="communitiesGrid">
            @if($hasDbProjects)
                @foreach($dbProjects as $index => $item)
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
                        <!-- Invisible stretch link (pointer-events off — card click handled via JS above) -->
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

                        <!-- Main Community Photo -->
                        <img src="{{ $imgSrc }}" alt="{{ $item->title }} luxury property" class="mainImage">

                        <!-- Bottom Content Area -->
                        <div class="bottomContent">
                            <!-- Community Title -->
                            <h3 class="cardTitle">{{ $item->title }}</h3>

                            <!-- Location -->
                            <p class="cardLocation">{{ $item->location ?? 'Karachi, Pakistan' }}</p>

                            <!-- Two Buttons: Details + WhatsApp -->
                            <div class="cardBtnRow">
                                <a href="{{ $targetUrl }}" class="cardBookBtn" onclick="event.stopPropagation()">Details</a>
                                <a href="{{ $waUrl }}" target="_blank" rel="noopener" class="cardBookBtn cardWaBtn" onclick="event.stopPropagation()">WhatsApp</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Show More Button (Visible when more than 9 projects exist) -->
        @if($hasDbProjects && $dbProjects->count() > 9)
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

<style>
.communitiesGrid .cardCustom { position: relative; cursor: pointer; }
.communitiesGrid .cardStretchLink {
    position: absolute; inset: 0; z-index: 1; border-radius: inherit;
    pointer-events: none;
}
.communitiesGrid .cardBtnRow {
    display: flex; gap: 10px; width: 100%; margin-top: 10px; position: relative; z-index: 10;
}
.communitiesGrid .cardBtnRow .cardBookBtn {
    flex: 1 1 0; width: auto; margin-top: 0; padding: 11px 10px;
    text-decoration: none; cursor: pointer; font-size: 12.5px;
    position: relative; z-index: 10; pointer-events: auto;
}
.communitiesGrid .cardBtnRow .cardWaBtn {
    background: transparent !important; color: #ffffff !important;
    border: 1.5px solid #BFA16A !important; box-shadow: none !important;
}
.communitiesGrid .cardBtnRow .cardWaBtn:hover {
    background: #BFA16A !important; color: #ffffff !important;
}
.communitiesGrid .cardBtnRow .cardBookBtn:not(.cardWaBtn):hover { background: #aa8d58 !important; }
@media (max-width: 400px) {
    .communitiesGrid .cardBtnRow .cardBookBtn { font-size: 11.5px; letter-spacing: 0.4px; }
}
</style>

<style>
.communitiesGrid {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 28px !important;
    width: 100%;
}

.communitiesGrid .cardCustom {
    height: 480px;
}

@media (max-width: 991px) {
    .communitiesGrid {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 20px !important;
    }
    .communitiesGrid .cardCustom {
        height: 460px;
    }
}

@media (max-width: 640px) {
    .communitiesGrid {
        grid-template-columns: 1fr !important;
        max-width: 400px !important;
        margin: 0 auto !important;
        gap: 20px !important;
    }
    .communitiesGrid .cardCustom {
        height: 440px;
    }
}

.showMoreProjectsContainer {
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 45px;
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
    padding: 13px 38px;
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
</style>

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
