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
                    $brand = preg_replace('/\b(group(\s+and\s+builder(s)?)?|builders?|developers?|properties|pvt|ltd|llc)\b/i', '', $cleanDev);
                    $brand = trim(preg_replace('/\s+/', ' ', (string) $brand), " \t\n\r\0\x0B-&,");
                    $kw = !empty($brand) ? strtolower($brand) : strtolower($cleanDev);
                    $lbl = !empty($brand) ? ucwords(strtolower($brand)) : $cleanDev;
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
            // Developer Detail Page -> Filter and show the latest 10 PROJECTS of this developer (/project/...)
            [$devKeyword, $devTitle] = $extractBrand($currDeveloper->name, $currDeveloper->name);
            $featuredIds = is_array($currDeveloper->featured_projects)
                ? array_values(array_filter(array_map('intval', $currDeveloper->featured_projects)))
                : [];

            $devProjectsQuery = $activeProjectsQuery();
            $devProjectsQuery->where(function ($q) use ($currDeveloper, $devKeyword, $featuredIds) {
                $q->where('developer_id', $currDeveloper->id);

                if (!empty($currDeveloper->name)) {
                    $q->orWhere('developer', 'LIKE', '%' . $currDeveloper->name . '%');
                }

                if (!empty($devKeyword)) {
                    $q->orWhere('developer', 'LIKE', '%' . $devKeyword . '%')
                      ->orWhere('title', 'LIKE', '%' . $devKeyword . '%')
                      ->orWhere('slug', 'LIKE', '%' . $devKeyword . '%');
                }

                if (!empty($featuredIds)) {
                    $q->orWhereIn('id', $featuredIds);
                }
            });

            $devProjects = $devProjectsQuery->orderBy('id', 'desc')->take(10)->get();

            if ($devProjects->isNotEmpty()) {
                $contextualHeader = ($devTitle ?: $currDeveloper->name) . ' Projects';
                $contextualLinks = $mapProjectLinks($devProjects);
            }
        } elseif ($currCity) {
            // City Detail Page -> ONLY Communities / Areas where this city was selected in CMS dropdown (city_id)
            $featuredCommIds = is_array($currCity->featured_communities)
                ? array_values(array_filter(array_map('intval', $currCity->featured_communities)))
                : [];

            $cityCommunities = \App\Models\Community::where('is_active', true)
                ->where(function ($q) {
                    $q->whereNull('status')->orWhere('status', '!=', 'draft');
                })
                ->whereDoesntHave('page', function ($q) {
                    $q->where('status', 'draft')->orWhere('is_published', false);
                })
                ->where(function ($q) use ($currCity, $featuredCommIds) {
                    $q->where('city_id', $currCity->id);
                    if (!empty($featuredCommIds)) {
                        $q->orWhereIn('id', $featuredCommIds);
                    }
                })
                ->orderBy('order', 'asc')
                ->orderBy('id', 'desc')
                ->take(10)
                ->get();

            if ($cityCommunities->isNotEmpty()) {
                $contextualHeader = trim($currCity->name) . ' Areas';
                $contextualLinks = [];
                foreach ($cityCommunities as $cm) {
                    $cleanSlug = ltrim(preg_replace('#^area/#', '', ltrim((string) $cm->slug, '/')), '/');
                    $contextualLinks[] = [
                        'label' => $cm->name,
                        'url'   => '/area/' . $cleanSlug,
                    ];
                }
            }
        } elseif ($currCommunity) {
            // Area / Community Detail Page -> ONLY projects where this community was selected in CMS dropdown
            $featuredIds = is_array($currCommunity->featured_projects)
                ? array_values(array_filter(array_map('intval', $currCommunity->featured_projects)))
                : [];

            $areaProjects = $activeProjectsQuery()
                ->where(function ($q) use ($currCommunity, $featuredIds) {
                    $q->where('community_id', $currCommunity->id);
                    if (!empty($featuredIds)) {
                        $q->orWhereIn('id', $featuredIds);
                    }
                })
                ->orderBy('order', 'asc')
                ->orderBy('id', 'desc')
                ->take(10)
                ->get();

            if ($areaProjects->isNotEmpty()) {
                $contextualHeader = trim($currCommunity->name) . ' Projects';
                $contextualLinks = $mapProjectLinks($areaProjects);
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

                    @if($loop->last)
                        @php
                            $activeSocialLinks = collect($fData->social_links ?? [])
                                ->filter(fn ($item) => !empty(trim((string) ($item['url'] ?? ''))))
                                ->values();
                        @endphp
                        @if($activeSocialLinks->isNotEmpty())
                            <div class="footerSocialLinks" style="display: flex; align-items: center; gap: 10px; margin-top: 16px; flex-wrap: wrap;">
                                @foreach($activeSocialLinks as $sLink)
                                    @php
                                        $platform = strtolower(trim((string) ($sLink['platform'] ?? '')));
                                        $rawSocialUrl = trim((string) ($sLink['url'] ?? ''));
                                        if ($platform === 'whatsapp' && !preg_match('#^https?://#i', $rawSocialUrl)) {
                                            $waDigits = preg_replace('/\D+/', '', $rawSocialUrl);
                                            $socialHref = $waDigits ? ('https://wa.me/' . $waDigits) : $rawSocialUrl;
                                        } else {
                                            $socialHref = preg_match('#^https?://#i', $rawSocialUrl) ? $rawSocialUrl : ('https://' . ltrim($rawSocialUrl, '/'));
                                        }
                                        $platformTitle = match ($platform) {
                                            'facebook' => 'Facebook',
                                            'instagram' => 'Instagram',
                                            'twitter' => 'X (Twitter)',
                                            'linkedin' => 'LinkedIn',
                                            'whatsapp' => 'WhatsApp',
                                            'youtube' => 'YouTube',
                                            default => ucfirst($platform),
                                        };
                                    @endphp
                                    <a href="{{ $socialHref }}"
                                       target="_blank"
                                       rel="noopener noreferrer"
                                       aria-label="{{ $platformTitle }}"
                                       title="{{ $platformTitle }}"
                                       style="width: 36px; height: 36px; border-radius: 50%; border: 1px solid rgba(255,255,255,0.2); background: rgba(255,255,255,0.06); color: #ffffff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s ease;"
                                       onmouseover="this.style.borderColor='#BFA16A'; this.style.background='#BFA16A'; this.style.color='#111111';"
                                       onmouseout="this.style.borderColor='rgba(255,255,255,0.2)'; this.style.background='rgba(255,255,255,0.06)'; this.style.color='#ffffff';">
                                        @if($platform === 'facebook')
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z"/></svg>
                                        @elseif($platform === 'instagram')
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
                                        @elseif($platform === 'twitter')
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        @elseif($platform === 'linkedin')
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                                        @elseif($platform === 'whatsapp')
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                                        @elseif($platform === 'youtube')
                                            <svg width="17" height="17" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                        @else
                                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Bottom Bar: Copyright -->
        <div class="bottomBar Footer-module__S6Hkya__bottomBar">
            <p class="copyrightText Footer-module__S6Hkya__copyrightText">
                {{ $fData->copyright_text ?: '© ' . date('Y') . ' FS Real Estate Advisory. All Rights Reserved.' }}
            </p>
        </div>
    </div>
</footer>