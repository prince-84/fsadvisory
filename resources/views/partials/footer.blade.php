@php
    $fData = footer_data();
    $rawColumns = $fData->columns ?? \App\Models\FooterSection::defaultColumns();
    $footerColumns = $rawColumns;

    // 1. Standard pages that MUST always show the same default CMS footer
    $standardPaths = [
        '', '/', 'home',
        'developers', 'projects',
        'about-us', 'about',
        'contact-us', 'contact',
        'privacy-policy',
        'terms-and-conditions', 'terms-condition', 'terms',
    ];
    $currentPath = trim(strtolower(request()->path()), '/');
    $isStandardPage = in_array($currentPath, $standardPaths, true)
        || request()->is('blog')
        || request()->is('blog/*');

    $contextualHeader = null;
    $contextualLinks = [];

    if (!$isStandardPage) {
        // Helper closure to extract brand keyword from developer or title
        $extractBrand = function (?string $devStr, ?string $titleStr = null): array {
            $kw = null;
            $lbl = null;
            $cleanDev = trim((string) $devStr);
            if ($cleanDev !== '' && !in_array(strtolower($cleanDev), ['modon properties', 'none', 'null'], true)) {
                if (stripos($cleanDev, 'saima') !== false) {
                    $kw = 'saima';
                    $lbl = 'Saima';
                } elseif (stripos($cleanDev, 'zameen') !== false) {
                    $kw = 'zameen';
                    $lbl = 'Zameen';
                } else {
                    $kw = $cleanDev;
                    $lbl = $cleanDev;
                }
            }
            if (!$kw && !empty($titleStr)) {
                $firstWord = strtok(trim($titleStr), ' ');
                if (!empty($firstWord) && strlen($firstWord) >= 3) {
                    $kw = strtolower($firstWord);
                    $lbl = ucfirst($kw);
                }
            }
            return [$kw, $lbl];
        };

        // Helper closure to build active projects query
        $activeProjectsQuery = function () {
            return \App\Models\Project::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('status')->orWhere('status', '!=', 'draft');
                })
                ->whereDoesntHave('page', function ($q) {
                    $q->where('status', 'draft')->orWhere('is_published', false);
                });
        };

        // Helper closure to map Project models to footer links
        $mapProjectLinks = function ($projects): array {
            $links = [];
            foreach ($projects as $rp) {
                $rawSlug = $rp->slug ?: ($rp->page?->slug ?? '');
                $cleanSlug = ltrim(preg_replace('#^project/#', '', ltrim((string) $rawSlug, '/')), '/');
                $links[] = [
                    'label' => $rp->title,
                    'url'   => $cleanSlug ? ('/project/' . $cleanSlug) : ('/project/' . $rp->id),
                ];
            }
            return $links;
        };

        // A. DEVELOPER DETAIL PAGE (/developer/{slug})
        $currDeveloper = null;
        if (isset($developer) && $developer instanceof \App\Models\Developer) {
            $currDeveloper = $developer;
        } elseif (request()->is('developer/*')) {
            $dSlug = trim((string) request()->segment(2));
            $currDeveloper = \App\Models\Developer::where('slug', $dSlug)->orWhere('slug', '/' . $dSlug)->first();
        }

        // B. CITY DETAIL PAGE (/city/{slug})
        $currCity = null;
        if (!$currDeveloper) {
            if (isset($city) && $city instanceof \App\Models\City) {
                $currCity = $city;
            } elseif (request()->is('city/*')) {
                $cSlug = trim((string) request()->segment(2));
                $currCity = \App\Models\City::where('slug', $cSlug)
                    ->orWhere('slug', '/' . $cSlug)
                    ->orWhere('slug', 'city/' . $cSlug)
                    ->first();
            }
        }

        // C. AREA / COMMUNITY DETAIL PAGE (/area/{slug})
        $currCommunity = null;
        if (!$currDeveloper && !$currCity) {
            if (isset($community) && $community instanceof \App\Models\Community) {
                $currCommunity = $community;
            } elseif (request()->is('area/*')) {
                $aSlug = trim((string) request()->segment(2));
                $currCommunity = \App\Models\Community::where('slug', $aSlug)
                    ->orWhere('slug', '/' . $aSlug)
                    ->orWhere('slug', 'area/' . $aSlug)
                    ->first();
            }
        }

        // D. PROJECT DETAIL PAGE (/project/{slug})
        $currProject = null;
        if (!$currDeveloper && !$currCity && !$currCommunity) {
            if (isset($project) && $project instanceof \App\Models\Project) {
                $currProject = $project;
            } elseif (request()->is('project/*')) {
                $pSlug = trim((string) request()->segment(2));
                $currProject = \App\Models\Project::where('slug', $pSlug)
                    ->orWhere('slug', '/' . $pSlug)
                    ->orWhere('slug', 'project/' . $pSlug)
                    ->first();
                if (!$currProject) {
                    $pPage = \App\Models\Page::where('slug', $pSlug)
                        ->orWhere('slug', '/' . $pSlug)
                        ->orWhere('slug', 'project/' . $pSlug)
                        ->first();
                    if ($pPage) {
                        $currProject = \App\Models\Project::where('page_id', $pPage->id)->first();
                    }
                }
            } elseif (isset($page) && $page instanceof \App\Models\Page) {
                $currProject = \App\Models\Project::where('page_id', $page->id)->first();
                if (!$currProject && in_array($page->slug, \App\Models\Page::projectSlugs(), true)) {
                    $currProject = \App\Models\Project::where('slug', $page->slug)
                        ->orWhere('slug', '/' . $page->slug)
                        ->first();
                }
            }
        }

        // --- RESOLVE CONTEXTUAL LINKS (STRICTLY MATCHED BY DETAIL PAGE TYPE, LIMIT: LATEST 10) ---
        if ($currDeveloper) {
            // Developer Detail Page -> ONLY Developer detail pages (/developer/...) filtered by current developer keyword
            [$devKeyword, $devTitle] = $extractBrand($currDeveloper->name, $currDeveloper->name);
            $matchedDevs = \App\Models\Developer::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('status')->orWhere('status', '!=', 'draft');
                })
                ->where(function ($q) use ($currDeveloper, $devKeyword) {
                    $q->where('id', $currDeveloper->id);
                    if (!empty($devKeyword)) {
                        $q->orWhere('name', 'LIKE', '%' . $devKeyword . '%')
                          ->orWhere('slug', 'LIKE', '%' . $devKeyword . '%');
                    }
                })
                ->orderBy('id', 'desc')
                ->take(10)
                ->get();

            if ($matchedDevs->isNotEmpty()) {
                $contextualHeader = ($devTitle ?: $currDeveloper->name) . ' Developers';
                foreach ($matchedDevs as $d) {
                    $dSlug = ltrim(preg_replace('#^developer/#', '', ltrim((string) $d->slug, '/')), '/');
                    $contextualLinks[] = [
                        'label' => $d->name,
                        'url'   => '/developer/' . $dSlug,
                    ];
                }
            }
        } elseif ($currCity) {
            // City Detail Page -> ONLY City detail pages (/city/...) filtered by root city keyword (e.g. Islamabad, Karachi)
            $cityLabel = trim((string) $currCity->name);
            $cSlug = trim((string) $currCity->slug);

            // Filter out common suffix/number noise words so "Islamabad two" matches "Islamabad" and vice versa
            $noiseWords = [
                'city', 'cities', 'urban', 'hub', 'new', 'phase', 'block', 'sector',
                'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
                'first', 'second', 'third', 'fourth', 'fifth',
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
            ];
            $tokens = preg_split('/[\s\-_]+/', strtolower($cityLabel . ' ' . $cSlug));
            $cleanTokens = [];
            foreach ($tokens as $token) {
                $t = trim($token);
                if (strlen($t) >= 3 && !in_array($t, $noiseWords, true)) {
                    $cleanTokens[] = $t;
                }
            }
            if (empty($cleanTokens)) {
                foreach ($tokens as $token) {
                    $t = trim($token);
                    if (strlen($t) >= 3 && !in_array($t, ['city', 'cities'], true)) {
                        $cleanTokens[] = $t;
                    }
                }
            }
            $cleanTokens = array_values(array_unique($cleanTokens));
            $primaryCity = !empty($cleanTokens) ? $cleanTokens[0] : strtolower($cityLabel);

            $matchedCities = \App\Models\City::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('status')->orWhere('status', '!=', 'draft');
                })
                ->where(function ($q) use ($currCity, $cleanTokens) {
                    $q->where('id', $currCity->id);
                    foreach ($cleanTokens as $kw) {
                        if (!empty($kw)) {
                            $q->orWhere('name', 'LIKE', '%' . $kw . '%')
                              ->orWhere('slug', 'LIKE', '%' . $kw . '%');
                        }
                    }
                })
                ->orderBy('id', 'asc')
                ->take(10)
                ->get();

            if ($matchedCities->isNotEmpty()) {
                $contextualHeader = ucwords($primaryCity) . ' Cities';
                foreach ($matchedCities as $ct) {
                    $cleanSlug = ltrim(preg_replace('#^city/#', '', ltrim((string) $ct->slug, '/')), '/');
                    $contextualLinks[] = [
                        'label' => $ct->name,
                        'url'   => '/city/' . $cleanSlug,
                    ];
                }
            }
        } elseif ($currCommunity) {
            // Area / Community Detail Page -> ONLY Area detail pages (/area/...) filtered by current area name/keyword or city (NO projects)
            $areaLabel = trim((string) $currCommunity->name);
            $aSlug = trim((string) $currCommunity->slug);

            $noiseWords = [
                'area', 'community', 'communities', 'neighbourhood', 'sector', 'block', 'phase',
                'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
                'first', 'second', 'third', 'fourth', 'fifth',
                '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
            ];
            $tokens = preg_split('/[\s\-_]+/', strtolower($areaLabel . ' ' . $aSlug));
            $cleanTokens = [];
            foreach ($tokens as $token) {
                $t = trim($token);
                if (strlen($t) >= 3 && !in_array($t, $noiseWords, true)) {
                    $cleanTokens[] = $t;
                }
            }
            if (empty($cleanTokens)) {
                foreach ($tokens as $token) {
                    $t = trim($token);
                    if (strlen($t) >= 3 && !in_array($t, ['area', 'community'], true)) {
                        $cleanTokens[] = $t;
                    }
                }
            }
            $cleanTokens = array_values(array_unique($cleanTokens));
            $primaryArea = !empty($cleanTokens) ? $cleanTokens[0] : strtolower($areaLabel);

            $matchedAreas = \App\Models\Community::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('status')->orWhere('status', '!=', 'draft');
                })
                ->where(function ($q) use ($currCommunity, $cleanTokens) {
                    $q->where('id', $currCommunity->id);
                    if ($currCommunity->city_id) {
                        $q->orWhere('city_id', $currCommunity->city_id);
                    }
                    foreach ($cleanTokens as $kw) {
                        if (!empty($kw)) {
                            $q->orWhere('name', 'LIKE', '%' . $kw . '%')
                              ->orWhere('slug', 'LIKE', '%' . $kw . '%');
                        }
                    }
                })
                ->orderBy('id', 'asc')
                ->take(10)
                ->get();

            if ($matchedAreas->isNotEmpty()) {
                $cityName = $currCommunity->city_id ? \App\Models\City::find($currCommunity->city_id)?->name : null;
                $contextualHeader = ($cityName ? ($cityName . ' ') : (ucwords($primaryArea) . ' ')) . 'Areas';
                foreach ($matchedAreas as $cm) {
                    $cleanSlug = ltrim(preg_replace('#^area/#', '', ltrim((string) $cm->slug, '/')), '/');
                    $contextualLinks[] = [
                        'label' => $cm->name,
                        'url'   => '/area/' . $cleanSlug,
                    ];
                }
            }
        } elseif ($currProject) {
            // Project Detail Page -> ONLY Project detail pages (/project/...) of the same developer/brand
            $devObj = $currProject->developer_id ? \App\Models\Developer::find($currProject->developer_id) : null;
            $devString = $devObj?->name ?? ($currProject->developer ?? '');
            [$brandKeyword, $brandTitle] = $extractBrand($devString, $currProject->title);

            $relQuery = $activeProjectsQuery();
            if (!empty($brandKeyword)) {
                $relQuery->where(function ($q) use ($brandKeyword, $currProject) {
                    if ($currProject->developer_id) {
                        $q->where('developer_id', $currProject->developer_id);
                    }
                    $q->orWhere('title', 'LIKE', '%' . $brandKeyword . '%')
                      ->orWhere('developer', 'LIKE', '%' . $brandKeyword . '%')
                      ->orWhere('slug', 'LIKE', '%' . $brandKeyword . '%');
                });
            }

            $relProjects = $relQuery->orderBy('order', 'asc')->take(10)->get();
            if ($relProjects->isNotEmpty()) {
                $contextualHeader = !empty($brandTitle) ? ($brandTitle . ' Projects') : 'Related Projects';
                $contextualLinks = $mapProjectLinks($relProjects);
            }
        } elseif (isset($page) && $page instanceof \App\Models\Page) {
            // Dynamic Custom Page -> ONLY related Dynamic Pages (/{slug}) filtered by current page brand/topic (NO projects)
            $excludedPageIds = array_unique(array_merge(
                \App\Models\Project::whereNotNull('page_id')->pluck('page_id')->all(),
                \App\Models\City::whereNotNull('page_id')->pluck('page_id')->all(),
                \App\Models\Community::whereNotNull('page_id')->pluck('page_id')->all()
            ));

            $baseDynQuery = \App\Models\Page::where('is_published', true)
                ->where(function ($q) {
                    $q->whereNull('status')->orWhere('status', '!=', 'draft');
                })
                ->whereNotIn('slug', array_merge($standardPaths, \App\Models\Page::projectSlugs()))
                ->when(!empty($excludedPageIds), fn ($q) => $q->whereNotIn('id', $excludedPageIds));

            $pageFilterKw = null;
            $pageHeaderLbl = null;
            if (stripos($page->title, 'saima') !== false || stripos($page->slug, 'saima') !== false) {
                $pageFilterKw = 'saima';
                $pageHeaderLbl = 'Saima Pages';
            } elseif (stripos($page->title, 'zameen') !== false || stripos($page->slug, 'zameen') !== false) {
                $pageFilterKw = 'zameen';
                $pageHeaderLbl = 'Zameen Pages';
            } else {
                $cleanTitle = trim((string) $page->title);
                if ($cleanTitle !== '') {
                    $pageFilterKw = $cleanTitle;
                    $pageHeaderLbl = 'Related Pages';
                }
            }

            $relDynQuery = clone $baseDynQuery;
            if (!empty($pageFilterKw)) {
                $slugKw = \Illuminate\Support\Str::slug($pageFilterKw);
                $relDynQuery->where(function ($q) use ($page, $pageFilterKw, $slugKw) {
                    $q->where('id', $page->id)
                      ->orWhere('title', 'LIKE', '%' . $pageFilterKw . '%');
                    if (!empty($slugKw)) {
                        $q->orWhere('slug', 'LIKE', '%' . $slugKw . '%');
                    }
                });
            }

            $relDynPages = $relDynQuery->orderBy('id', 'desc')->take(10)->get();

            if ($relDynPages->isNotEmpty()) {
                $contextualHeader = $pageHeaderLbl ?: 'Related Pages';
                foreach ($relDynPages as $dp) {
                    $contextualLinks[] = [
                        'label' => $dp->title,
                        'url'   => '/' . ltrim((string) $dp->slug, '/'),
                    ];
                }
            }
        }

        // Apply contextual links into the middle/projects footer column
        if (!empty($contextualLinks)) {
            $targetColIdx = null;
            foreach ($footerColumns as $idx => $col) {
                $h = strtolower($col['header'] ?? '');
                if (str_contains($h, 'search') || str_contains($h, 'project') || str_contains($h, 'communit') || str_contains($h, 'developer')) {
                    $targetColIdx = $idx;
                    break;
                }
            }
            if ($targetColIdx === null && count($footerColumns) > 1) {
                $targetColIdx = 1;
            }
            if ($targetColIdx !== null && isset($footerColumns[$targetColIdx])) {
                $footerColumns[$targetColIdx]['header'] = $contextualHeader ?: ($footerColumns[$targetColIdx]['header'] ?? 'Related Links');
                $footerColumns[$targetColIdx]['links'] = $contextualLinks;
            }
        }
    }
@endphp
<footer class="footer Footer-module__S6Hkya__footer">
    <div class="container">
        <!-- Main Columns Grid -->
        <div class="footerGrid Footer-module__S6Hkya__footerGrid">
            <!-- Col 1: Brand Logo & Description -->
            <div class="brandCol Footer-module__S6Hkya__brandCol">
                <a href="/" class="logoLink Footer-module__S6Hkya__logoLink" style="text-decoration: none; display: inline-block; margin-bottom: 14px;">
                    <img src="{{ asset('FS LOGO n FAVICON-08.svg') }}" alt="FS Real Estate Advisory" style="height: 54px; width: auto; object-fit: contain; display: block;">
                </a>
                <p class="brandDescription Footer-module__S6Hkya__brandDescription">
                    {{ $fData->brand_description ?: 'FS Real Estate Advisory trusted property advisory serving local and international buyers. We specialize in residential and investment properties, offering clear guidance, market insight, and long term value.' }}
                </p>

                @if($fData->newsletter_enabled)
                    <div style="margin-top: 18px;">
                        <h5 style="color: #ffffff; font-size: 13.5px; margin: 0 0 6px 0; font-weight: 700;">{{ $fData->newsletter_title ?: 'Subscribe to Our Newsletter' }}</h5>
                        @if($fData->newsletter_subtitle)
                            <p style="color: #9ca3af; font-size: 12px; margin: 0 0 10px 0; line-height: 1.4;">{{ $fData->newsletter_subtitle }}</p>
                        @endif
                        <form onsubmit="event.preventDefault(); alert('Thank you for subscribing!');" style="display: flex; gap: 6px; max-width: 300px;">
                            <input type="email" placeholder="Your email" required style="padding: 8px 12px; font-size: 13px; border-radius: 4px; border: 1px solid #374151; background: #1f2937; color: #ffffff; flex: 1;">
                            <button type="submit" style="background: #BFA16A; color: #ffffff; border: none; padding: 8px 14px; border-radius: 4px; font-weight: 600; font-size: 13px; cursor: pointer;">Join</button>
                        </form>
                    </div>
                @endif
            </div>

            <!-- Dynamic Columns (Managed via CMS with Drag & Drop, Contextual on Project Pages) -->
            @foreach($footerColumns as $cIdx => $fCol)
                <div class="{{ $loop->last ? 'contactCol' : 'linksCol' }}">
                    <h4 class="colTitle Footer-module__S6Hkya__colTitle">{{ $fCol['header'] ?? '' }}</h4>
                    <ul class="{{ $loop->last ? 'contactList Footer-module__S6Hkya__contactList' : 'linksList Footer-module__S6Hkya__linksList' }}">
                        @foreach($fCol['links'] ?? [] as $fLnk)
                            @php
                                $rawUrl = trim($fLnk['url'] ?? '/');
                                // Convert any hardcoded fsadvisory.pk URLs to relative paths so they work on local & production seamlessly
                                $cleanUrl = preg_replace('#^https?://(www\.)?fsadvisory\.pk(/.*)?$#i', '$2', $rawUrl);
                                $targetUrl = empty($cleanUrl) ? '/' : $cleanUrl;
                            @endphp
                            <li>
                                <a href="{{ $targetUrl }}" class="{{ $loop->parent->last ? 'contactLink Footer-module__S6Hkya__contactLink' : 'linkItem Footer-module__S6Hkya__linkItem' }}">
                                    @if($loop->parent->last)
                                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="contactIcon Footer-module__S6Hkya__contactIcon">
                                            <rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/>
                                        </svg>
                                    @endif
                                    <span>{{ $fLnk['label'] ?? '' }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        <!-- Bottom Bar: Disclaimer & Copyright -->
        <div class="bottomBar Footer-module__S6Hkya__bottomBar">
            <p class="disclaimerText Footer-module__S6Hkya__disclaimerText">
                {{ $fData->disclaimer_text ?: 'Disclaimer: Its not official website. We inform that all property information provided on this website is for general guidance only and does not constitute a formal offer. Prices, availability, and property details may change at any time without prior notice. Images are for illustrative purposes and may not reflect actual properties. For the most accurate and up-to-date information, please contact us directly through the details provided on the website.' }}
            </p>
            <p class="copyrightText Footer-module__S6Hkya__copyrightText">
                {{ $fData->copyright_text ?: '© ' . date('Y') . ' FS Real Estate Advisory. All Rights Reserved.' }}
            </p>
        </div>
    </div>
</footer>