<?php

use App\Models\CmsContent;
use App\Models\TocItem;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

if (! function_exists('cms')) {
    /**
     * Get an editable CMS text value by key.
     * Falls back to the default in config/cms.php if the DB value is empty or the DB is unreachable.
     */
    function cms(string $key, ?string $default = null): string
    {
        static $values = null;

        if ($values === null) {
            try {
                $values = CmsContent::allKeyed();
            } catch (\Throwable $e) {
                $values = [];
            }
        }

        $value = $values[$key] ?? null;

        if ($value === null || $value === '') {
            $value = $default ?? config("cms.content.{$key}.value", '');
        }

        return (string) $value;
    }
}

if (! function_exists('cms_br')) {
    /**
     * CMS value escaped with new lines converted to <br>.
     */
    function cms_br(string $key, ?string $default = null): HtmlString
    {
        return new HtmlString(nl2br(e(cms($key, $default)), false));
    }
}

if (! function_exists('cms_lines')) {
    /**
     * CMS "list" value split into an array (one item per line).
     */
    function cms_lines(string $key): array
    {
        return array_values(array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n/', cms($key))),
            fn ($line) => $line !== ''
        ));
    }
}

if (! function_exists('toc_items')) {
    /**
     * Active Table of Contents tree (top-level items with children).
     */
    function toc_items(): Collection
    {
        try {
            return TocItem::getTree();
        } catch (\Throwable $e) {
            return collect(config('cms.toc', []))->map(fn ($item) => (object) array_merge($item, [
                'level' => 2,
                'children' => collect(),
            ]));
        }
    }
}

if (! function_exists('toc_title')) {
    /**
     * Title of a TOC item by its anchor id (keeps article H2 headings in sync with the TOC).
     */
    function toc_title(string $targetId, string $default): string
    {
        static $titles = null;

        if ($titles === null) {
            try {
                $titles = TocItem::titleMap();
            } catch (\Throwable $e) {
                $titles = [];
            }
        }

        return $titles[$targetId] ?? $default;
    }
}

if (! function_exists('page_data')) {
    /**
     * Retrieve current or specified Page model with sections.
     */
    function page_data(?string $slug = null): ?\App\Models\Page
    {
        try {
            $targetSlug = $slug ?? request()->path();

            // 1. Direct slug match (e.g. '/' or 'wadeem-gardens')
            $page = \App\Models\Page::findBySlug($targetSlug);
            if ($page) {
                return $page;
            }

            // 2. Strip route prefixes: project/, city/, area/, blog/
            $cleanSlug = trim($targetSlug, '/');
            $strippedSlug = preg_replace('#^(project|city|area|blog)/#', '', $cleanSlug);
            if ($strippedSlug !== $cleanSlug) {
                $page = \App\Models\Page::findBySlug($strippedSlug);
                if ($page) {
                    return $page;
                }
            }

            // 3. Fallback: check City, Community, Project models which might link to Page or have slug
            $searchVariants = array_unique(array_filter([$strippedSlug, $cleanSlug]));
            foreach ($searchVariants as $sv) {
                $city = \App\Models\City::where('slug', $sv)->orWhere('slug', '/' . $sv)->first();
                if ($city && $city->page) {
                    return $city->page;
                }
                $comm = \App\Models\Community::where('slug', $sv)->orWhere('slug', '/' . $sv)->first();
                if ($comm && $comm->page) {
                    return $comm->page;
                }
                $proj = \App\Models\Project::where('slug', $sv)->orWhere('slug', '/' . $sv)->first();
                if ($proj && $proj->page) {
                    return $proj->page;
                }
            }

            return null;
        } catch (\Throwable $e) {
            return null;
        }
    }
}

if (! function_exists('page_section')) {
    /**
     * Retrieve content of a page section with fallback.
     */
    function page_section(string $sectionKey, string $fieldKey, $default = null, ?string $pageSlug = null)
    {
        try {
            $page = page_data($pageSlug);
            if ($page) {
                $sec = $page->section($sectionKey);
                if ($sec && $sec->is_active) {
                    $content = $sec->content ?? [];
                    if (is_array($content) && array_key_exists($fieldKey, $content)) {
                        $val = $content[$fieldKey];
                        if ($val !== null && $val !== '') {
                            return $val;
                        }
                        if ($val === '' && (is_string($default) || $default === null)) {
                            return '';
                        }
                    }
                }
            }
        } catch (\Throwable $e) {
            // Graceful fallback on missing DB/table
        }
        return $default;
    }
}

if (! function_exists('navbar_pages')) {
    /**
     * Retrieve all published pages marked for navbar inclusion.
     */
    function navbar_pages(): \Illuminate\Support\Collection
    {
        return \App\Models\Page::navbarPages();
    }
}

if (! function_exists('toc_content')) {
    /**
     * Retrieve the rendered HTML content of an article section by target_id.
     */
    function toc_content(string $targetId, string $default = ''): HtmlString
    {
        static $contents = null;

        if ($contents === null || app()->runningUnitTests()) {
            try {
                $contents = TocItem::contentMap();
            } catch (\Throwable $e) {
                $contents = [];
            }
        }

        $val = $contents[$targetId] ?? null;

        if (!empty(trim($val ?? ''))) {
            return new HtmlString($val);
        }

        return new HtmlString($default);
    }
}

if (! function_exists('toc_image')) {
    /**
     * Retrieve the image URL/path of a TOC section by target_id with optional fallback.
     */
    function toc_image(string $targetId, ?string $default = null): ?string
    {
        static $images = null;

        if ($images === null || app()->runningUnitTests()) {
            try {
                $images = TocItem::imageMap();
            } catch (\Throwable $e) {
                $images = [];
            }
        }

        return $images[$targetId] ?? $default;
    }
}

if (! function_exists('footer_data')) {
    /**
     * Retrieve dynamic footer configuration.
     */
    function footer_data(): \App\Models\FooterSection
    {
        return \App\Models\FooterSection::current();
    }
}

if (! function_exists('is_indexing_enabled')) {
    /**
     * Check if search engine indexing is enabled globally.
     */
    function is_indexing_enabled(): bool
    {
        return \App\Models\SiteSetting::isIndexingEnabled();
    }
}

if (! function_exists('site_setting')) {
    /**
     * Retrieve a global site setting by key.
     */
    function site_setting(string $key, $default = null)
    {
        return \App\Models\SiteSetting::get($key, $default);
    }
}

if (! function_exists('get_navbar_items')) {
    /**
     * Retrieve active items for a navbar dropdown ('projects' or 'commercial'),
     * strictly excluding the currently viewed property/page.
     */
    function get_navbar_items(string $type = 'projects', ?string $currentSlug = null, $currentPageId = null): \Illuminate\Support\Collection
    {
        $items = collect();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('projects')) {
                $column = ($type === 'commercial') ? 'show_in_commercial' : 'show_in_projects';

                $query = \App\Models\Project::with('page')
                    ->where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('status')->orWhere('status', '!=', 'draft');
                    })
                    ->whereDoesntHave('page', function ($q) {
                        $q->where('status', 'draft')->orWhere('is_published', false);
                    });

                // Slugs of any Page in draft or unpublished status
                $draftPageSlugs = [];
                try {
                    $draftPageSlugs = \App\Models\Page::where('status', 'draft')
                        ->orWhere('is_published', false)
                        ->pluck('slug')
                        ->map(fn($s) => trim(preg_replace('#^(project|city|area|developer)/#', '', trim($s, '/')), '/'))
                        ->filter()
                        ->all();
                } catch (\Throwable $e) {}

                if (\Illuminate\Support\Facades\Schema::hasColumn('projects', $column)) {
                    if ($type === 'commercial') {
                        $query->where($column, true);
                    } else {
                        $query->where(function ($q) use ($column) {
                            $q->where($column, true)->orWhereNull($column);
                        });
                    }
                } elseif ($type === 'commercial') {
                    return collect();
                }

                // Latest 10 active non-draft projects
                $dbProjects = $query->orderBy('id', 'desc')->take(10)->get();

                foreach ($dbProjects as $dp) {
                    $pSlug = trim($dp->slug ?: ($dp->page->slug ?? ''), '/');
                    $cleanSlug = ltrim(preg_replace('#^project/#', '', $pSlug), '/');
                    if (empty($cleanSlug)) continue;
                    if (in_array($cleanSlug, $draftPageSlugs, true)) continue;
                    $url = '/project/' . $cleanSlug;
                    $items->push((object)[
                        'id' => $dp->id,
                        'page_id' => $dp->page_id,
                        'title' => $dp->title,
                        'slug' => $cleanSlug,
                        'url' => $url,
                        'type' => $type,
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // ignore table errors
        }

        // Determine current slugs to exclude
        $reqSlug = trim(request()->path(), '/');
        $cleanReqSlug = ltrim(preg_replace('#^project/#', '', $reqSlug), '/');
        $cleanParamSlug = ltrim(preg_replace('#^project/#', '', trim((string)$currentSlug, '/')), '/');
        $rawExclude = [
            trim((string)$currentSlug, '/'),
            $cleanParamSlug,
            $reqSlug,
            $cleanReqSlug,
        ];
        $excludeSlugs = array_values(array_unique(array_filter($rawExclude, fn($s) => $s !== '' && $s !== '/')));

        return $items->filter(function ($item) use ($excludeSlugs, $currentPageId) {
            if (!empty($currentPageId) && !empty($item->page_id) && $item->page_id == $currentPageId) {
                return false;
            }
            if (in_array(trim($item->slug, '/'), $excludeSlugs, true)) {
                return false;
            }
            return true;
        })->values()->take(5);
    }
}

if (! function_exists('get_navbar_projects')) {
    /**
     * Retrieve latest 5 active projects for the Projects navbar dropdown,
     * strictly excluding the currently viewed property/page.
     */
    function get_navbar_projects(?string $currentSlug = null, $currentPageId = null): \Illuminate\Support\Collection
    {
        return get_navbar_items('projects', $currentSlug, $currentPageId);
    }
}

if (! function_exists('get_navbar_commercial')) {
    /**
     * Retrieve latest 5 active commercial properties for the Commercial navbar dropdown,
     * strictly excluding the currently viewed property/page.
     */
    function get_navbar_commercial(?string $currentSlug = null, $currentPageId = null): \Illuminate\Support\Collection
    {
        return get_navbar_items('commercial', $currentSlug, $currentPageId);
    }
}

if (! function_exists('get_navbar_developers')) {
    /**
     * Retrieve latest 5 active developers for the Developers navbar dropdown,
     * strictly excluding the currently viewed developer page.
     */
    function get_navbar_developers(?string $currentSlug = null): \Illuminate\Support\Collection
    {
        $items = collect();

        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('developers')) {
                $draftDevSlugs = [];
                try {
                    $draftDevSlugs = \App\Models\Page::where('status', 'draft')
                        ->orWhere('is_published', false)
                        ->pluck('slug')
                        ->map(fn($s) => trim(preg_replace('#^developer/#', '', trim($s, '/')), '/'))
                        ->filter()
                        ->all();
                } catch (\Throwable $e) {}

                $query = \App\Models\Developer::where('is_active', true)
                    ->where(function ($q) {
                        $q->whereNull('status')->orWhere('status', '!=', 'draft');
                    })
                    ->orderBy('id', 'desc')
                    ->take(10);

                $dbDevelopers = $query->get();

                foreach ($dbDevelopers as $dev) {
                    $dSlug = trim($dev->slug, '/');
                    $cleanSlug = ltrim(preg_replace('#^developer/#', '', $dSlug), '/');
                    if (empty($cleanSlug)) continue;
                    if (in_array($cleanSlug, $draftDevSlugs, true)) continue;
                    $url = '/developer/' . $cleanSlug;
                    $items->push((object)[
                        'id' => $dev->id,
                        'title' => $dev->name,
                        'name' => $dev->name,
                        'slug' => $cleanSlug,
                        'url' => $url,
                        'type' => 'developer',
                    ]);
                }
            }
        } catch (\Throwable $e) {
            // ignore
        }

        $reqSlug = trim(request()->path(), '/');
        $cleanReqSlug = ltrim(preg_replace('#^developer/#', '', $reqSlug), '/');
        $cleanParamSlug = ltrim(preg_replace('#^developer/#', '', trim((string)$currentSlug, '/')), '/');
        $rawExclude = [
            trim((string)$currentSlug, '/'),
            $cleanParamSlug,
            $reqSlug,
            $cleanReqSlug,
        ];
        $excludeSlugs = array_values(array_unique(array_filter($rawExclude, fn($s) => $s !== '' && $s !== '/')));

        return $items->filter(function ($item) use ($excludeSlugs) {
            if (in_array(trim($item->slug, '/'), $excludeSlugs, true)) {
                return false;
            }
            return true;
        })->values()->take(5);
    }
}

if (! function_exists('get_page_faqs')) {
    /**
     * Get array of FAQ items ['question' => ..., 'answer' => ...] for the given or current page/blog.
     */
    function get_page_faqs(?\App\Models\Page $page = null, ?\App\Models\Blog $blog = null): array
    {
        $faqs = [];

        // 1. If blog is provided or available in view shared data
        $blogInstance = $blog ?? view()->shared('blog');
        if ($blogInstance && is_array($blogInstance->faqs) && !empty($blogInstance->faqs)) {
            foreach ($blogInstance->faqs as $f) {
                $q = trim((string)($f['question'] ?? ($f['q'] ?? '')));
                $a = trim((string)($f['answer'] ?? ($f['a'] ?? '')));
                if ($q !== '' && $a !== '') {
                    $faqs[] = ['question' => $q, 'answer' => strip_tags($a)];
                }
            }
            if (!empty($faqs)) {
                return $faqs;
            }
        }

        // 2. If page or activePage has database FAQ section
        $pageInstance = $page ?? view()->shared('page') ?? page_data();

        if ($pageInstance) {
            $rawFaqs = $pageInstance->sectionField('faq', 'items');
            if (empty($rawFaqs)) {
                $rawFaqs = page_section('faq', 'items', null, $pageInstance->slug);
            }

            if (is_array($rawFaqs) && !empty($rawFaqs)) {
                foreach ($rawFaqs as $f) {
                    $q = trim((string)($f['question'] ?? ($f['q'] ?? '')));
                    $a = trim((string)($f['answer'] ?? ($f['a'] ?? '')));
                    if ($q !== '' && $a !== '') {
                        $faqs[] = ['question' => $q, 'answer' => strip_tags($a)];
                    }
                }
                if (!empty($faqs)) {
                    return $faqs;
                }
            }
        }

        // 3. Sitewide fallback default FAQs
        return [
            [
                'question' => "What is Saima?",
                'answer'   => "It's a premier residential and commercial real estate development portfolio by Saima Group, combining luxury living communities with modern amenities, prime locations, and high-yield investment destinations.",
            ],
            [
                'question' => "Where are Saima projects located?",
                'answer'   => "Saima projects are located across prime urban and coastal destinations in Pakistan, offering direct connectivity to major business districts, highways, and landmarks.",
            ],
            [
                'question' => "Who is developing Saima projects?",
                'answer'   => "Saima Group, one of Pakistan's most trusted and experienced real estate developers with decades of excellence in delivering quality residential and commercial projects.",
            ],
            [
                'question' => "Are Saima properties freehold / clear title?",
                'answer'   => "Yes, all Saima developments come with clear documentation, approved NOCs, and secure ownership for buyers and investors.",
            ],
            [
                'question' => "What residential projects are available by Saima?",
                'answer'   => "Current and recent launches include luxury apartments, modern townhouses, waterfront residences, and bespoke housing schemes with flexible payment plans.",
            ],
            [
                'question' => "What amenities does Saima offer?",
                'answer'   => "Saima communities feature 24/7 security, gated entrances, modern fitness centres, swimming pools, landscaped parks, high-speed elevators, and dedicated parking facilities.",
            ],
            [
                'question' => "Is investing in Saima a good investment?",
                'answer'   => "Yes. With Saima Group's decades-long proven track record, prime locations, and high rental yield potential, Saima properties represent an exceptional investment opportunity.",
            ],
            [
                'question' => "What property sizes are available in Saima projects?",
                'answer'   => "Sizes range from 2, 3, 4, and 5-room luxury apartments to executive penthouses and spacious independent residential plots and villas.",
            ],
            [
                'question' => "What are the payment plans for Saima projects?",
                'answer'   => "Saima offers flexible, easy, construction-linked installment plans spanning 36 to 48 months with reasonable booking and monthly payment options.",
            ],
            [
                'question' => "When will Saima projects be completed?",
                'answer'   => "Completion and handover timelines vary by project, with phased construction milestones and timely deliveries as per developer schedule.",
            ],
        ];
    }
}

if (! function_exists('render_faq_schema')) {
    /**
     * Render dynamic JSON-LD FAQ Schema markup for the current page.
     */
    function render_faq_schema(?\App\Models\Page $page = null, ?\App\Models\Blog $blog = null): string
    {
        try {
            $faqs = get_page_faqs($page, $blog);
            if (empty($faqs)) {
                return '';
            }

            $entities = [];
            foreach ($faqs as $item) {
                $entities[] = [
                    '@type' => 'Question',
                    'name' => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $item['answer'],
                    ],
                ];
            }

            $schema = [
                '@context' => 'https://schema.org',
                '@type' => 'FAQPage',
                'mainEntity' => $entities,
            ];

            return "\n    <!-- Dynamic FAQ Schema (JSON-LD) -->\n    <script type=\"application/ld+json\">\n"
                . json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
                . "\n    </script>\n";
        } catch (\Throwable $e) {
            return '';
        }
    }
}

if (! function_exists('canonical_url')) {
    /**
     * Resolve the clean, dynamic canonical URL for the current or specified page path.
     * Uses the configured SEO canonical base URL when set on production, and appends the current page path.
     */
    function canonical_url(?string $customUrl = null): string
    {
        if (!empty($customUrl)) {
            return rtrim($customUrl, '/') ?: $customUrl;
        }

        try {
            $base = trim((string) \App\Models\SiteSetting::get('seo_canonical_url', ''));
            $currentHost = request()->getHost();

            // Ignore localhost/127.0.0.1 saved in DB when running on a live domain
            if ($base !== '' && (str_contains($base, 'localhost') || str_contains($base, '127.0.0.1')) && !str_contains($currentHost, 'localhost') && !str_contains($currentHost, '127.0.0.1')) {
                $base = '';
            }

            if ($base === '') {
                $base = rtrim(url('/'), '/');
            } else {
                $base = rtrim($base, '/');
            }

            $path = trim(request()->path(), '/');
            $path = trim((string) preg_replace('#^public(/|$)#', '', $path), '/');

            if ($path === '' || $path === '/') {
                return $base;
            }

            return $base . '/' . $path;
        } catch (\Throwable $e) {
            return url()->current();
        }
    }
}

if (! function_exists('render_header_schemas')) {
    /**
     * Render exact JSON-LD schemas in document header (<head>) for:
     * 1. Organization / RealEstateAgent (exact requested JSON-LD schema)
     * 2. FAQPage (100% dynamic for complete page)
     */
    function render_header_schemas(?\App\Models\Page $page = null, ?\App\Models\Blog $blog = null, ?array $customFaqs = null): string
    {
        try {
            // 1. Organization / RealEstateAgent Schema (Exact Requested Structure)
            $orgSchema = [
                '@context' => 'https://schema.org',
                '@type' => 'RealEstateAgent',
                '@id' => 'https://fsadvisory.pk/#real-estate-agent',
                'name' => 'FS Real Estate and Advisory',
                'url' => 'https://fsadvisory.pk/',
                'telephone' => '+923322495575',
                'description' => 'FS Real Estate and Advisory provides residential and commercial real estate advisory services, property buying, selling, renting, and investment guidance in Karachi, Pakistan.',
                'areaServed' => [
                    [
                        '@type' => 'City',
                        'name' => 'Karachi',
                    ],
                    [
                        '@type' => 'Country',
                        'name' => 'Pakistan',
                    ],
                ],
            ];

            // 2. Dynamic FAQPage Schema
            $faqSchemaString = '';
            $faqs = [];
            if (is_array($customFaqs) && !empty($customFaqs)) {
                foreach ($customFaqs as $f) {
                    $q = trim((string) ($f['question'] ?? ($f['q'] ?? '')));
                    $a = trim((string) ($f['answer'] ?? ($f['a'] ?? '')));
                    if ($q !== '' && $a !== '') {
                        $faqs[] = ['question' => $q, 'answer' => strip_tags($a)];
                    }
                }
            }
            if (empty($faqs)) {
                $faqs = get_page_faqs($page, $blog);
            }
            if (!empty($faqs)) {
                $entities = [];
                foreach ($faqs as $item) {
                    $entities[] = [
                        '@type' => 'Question',
                        'name' => $item['question'],
                        'acceptedAnswer' => [
                            '@type' => 'Answer',
                            'text' => $item['answer'],
                        ],
                    ];
                }

                $faqSchema = [
                    '@context' => 'https://schema.org',
                    '@type' => 'FAQPage',
                    'mainEntity' => $entities,
                ];

                $faqSchemaString = "    <!-- Dynamic FAQ Schema (JSON-LD) -->\n    <script type=\"application/ld+json\">\n"
                    . json_encode($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
                    . "\n    </script>\n";
            }

            return "    <!-- Organization Schema (JSON-LD) -->\n    <script type=\"application/ld+json\">\n"
                . json_encode($orgSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT)
                . "\n    </script>\n"
                . $faqSchemaString;
        } catch (\Throwable $e) {
            return '';
        }
    }
}



