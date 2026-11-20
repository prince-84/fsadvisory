<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Community;
use App\Models\Page;
use App\Models\PageSection;
use App\Models\Project;
use App\Services\PageBlueprintService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CityController extends Controller
{
    /**
     * Display a listing of all Cities.
     */
    public function index(Request $request)
    {
        $cities = City::with(['page.sections'])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $allProjects = Project::with('page')->orderBy('order', 'asc')->get();
        $totalCities = $cities->count();
        $activeCities = $cities->where('is_active', true)->count();

        return view('admin.cities.index', compact('cities', 'allProjects', 'totalCities', 'activeCities'));
    }

    /**
     * Show form for creating a new City.
     */
    public function create()
    {
        $assignedCommunities = collect();
        return view('admin.cities.create', compact('assignedCommunities'));
    }

    /**
     * Store a newly created City and its linked Detail Page.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'slug'             => ['nullable', 'string', 'max:255'],
            'status'           => ['nullable', 'string', 'in:publish,draft,sold_out'],
            'h1'               => ['nullable', 'string', 'max:255'],
            'tagline'          => ['nullable', 'string', 'max:255'],
            'short_content'    => ['nullable', 'string'],
            'full_content'     => ['nullable', 'string'],
            'cover_image_file' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'faqs'             => ['nullable', 'array'],
        ]);

        $name = trim($validated['name']);
        $rawSlug = trim($request->input('slug') ?: $name);
        $cleanRawSlug = ltrim(preg_replace('#^city/#', '', ltrim($rawSlug, '/')), '/');
        $slug = Str::slug($cleanRawSlug ?: $name);

        $status = $request->input('status', 'draft');
        if (!in_array($status, ['publish', 'draft', 'sold_out'])) {
            $status = 'draft';
        }
        $isActive = ($status !== 'draft');

        // Cover / Hero Background Image Handling
        $heroBgImage = '';
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $uploadDir = public_path('images/cities');
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            $filename = time() . '_cover_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $heroBgImage = '/images/cities/' . $filename;
        } elseif ($request->hasFile('hero_image_file')) {
            $file = $request->file('hero_image_file');
            $uploadDir = public_path('images/cities');
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $filename = time() . '_hero_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $heroBgImage = '/images/cities/' . $filename;
        } elseif ($request->filled('sections.hero.bg_image')) {
            $heroBgImage = $request->input('sections.hero.bg_image');
        }

        // Unique slug for Page
        $uniqueSlug = $slug;
        $count = 1;
        while (Page::where('slug', $uniqueSlug)->exists()) {
            $uniqueSlug = $slug . '-' . $count;
            $count++;
        }

        // 1. Create linked Page
        $page = Page::create([
            'title'            => $name,
            'slug'             => $uniqueSlug,
            'in_navbar'        => $request->boolean('in_navbar', true),
            'navbar_order'     => ((int) Page::max('navbar_order')) + 1,
            'status'           => $status,
            'is_published'     => $isActive,
            'meta_title'       => $request->input('meta_title', ''),
            'meta_description' => $request->input('meta_description', ''),
            'meta_keywords'    => $request->input('meta_keywords', ''),
            'og_image'         => $heroBgImage ?: null,
        ]);

        // 2. Attach only the requested 6 vertical sections in order:
        // Hero, TOC/Content, Project Cards, About Community, FAQ, Contact Section
        $orderedKeys = ['hero', 'content', 'communities', 'about', 'faq', 'contact'];
        $globalSections = PageBlueprintService::getGlobalSections();
        $orderNum = 1;
        foreach ($orderedKeys as $key) {
            $sectionName = match($key) {
                'hero'        => 'Hero Banner',
                'content'     => 'Table of Contents & Article',
                'communities' => 'Project Cards',
                'about'       => 'About ' . $name,
                'faq'         => 'Frequently Asked Questions',
                'contact'     => 'Contact & Booking CTA',
                default       => ucwords(str_replace('_', ' ', $key)),
            };

            $defaultContent = PageBlueprintService::getDefaultSectionContent($key, $name);
            PageSection::create([
                'page_id'      => $page->id,
                'section_key'  => $key,
                'section_name' => $sectionName,
                'order'        => $orderNum++,
                'is_active'    => true,
                'content'      => $defaultContent,
            ]);
        }

        // 3. Customize Sections with form inputs
        $submittedSections = $request->input('sections', []);

        // 3.1 Hero
        $heroSec = $page->sections()->where('section_key', 'hero')->first();
        if ($heroSec) {
            $hContent = $heroSec->content ?? [];
            $hContent['bg_image'] = $heroBgImage;
            $hContent['title'] = $request->input('sections.hero.title') ?: $name;
            $hContent['subtitle'] = $request->input('sections.hero.subtitle', '');
            $hContent['badge'] = $request->input('sections.hero.badge', '');
            $heroSec->update(['content' => $hContent]);
        }

        // 3.2 TOC / Content
        $contentSec = $page->sections()->where('section_key', 'content')->first();
        if ($contentSec) {
            $cContent = $contentSec->content ?? [];
            $cContent['title'] = $request->input('sections.content.title', '');
            $cContent['intro'] = $request->input('sections.content.intro', '');
            $html = $request->input('sections.content.html', '');
            $cContent['html'] = $html;
            $cContent['body'] = $html;
            $cContent['appt_title'] = $request->input('sections.content.appt_title', '');
            $page->update(['body' => $html ?: null]);
            $contentSec->update(['content' => $cContent]);
        }

        // 3.3 Project Cards (Communities)
        $commSec = $page->sections()->where('section_key', 'communities')->first();
        if ($commSec) {
            $commContent = $commSec->content ?? [];
            $commContent['heading'] = $request->input('sections.communities.heading', '');
            $commContent['subtitle'] = $request->input('sections.communities.subtitle', '');
            
            $selectedCardIds = $request->input('selected_project_ids', []);
            $cleanSelectedIds = array_values(array_filter(array_map('intval', (array)$selectedCardIds)));
            $commContent['selected_ids'] = $cleanSelectedIds;
            $commContent['project_ids'] = $cleanSelectedIds;
            $commSec->update(['content' => $commContent]);
        }

        // 3.4 About Community
        $aboutSec = $page->sections()->where('section_key', 'about')->first();
        if ($aboutSec) {
            $aContent = $aboutSec->content ?? [];
            $aHeading = $request->input('sections.about.heading') ?? $request->input('sections.about.title', '');
            $aContent['heading'] = $aHeading;
            $aContent['title'] = $aHeading;
            $aContent['description'] = $request->input('sections.about.description', '');
            $aContent['video_url'] = $request->input('sections.about.video_url', '');
            $aPoster = $request->input('sections.about.poster_image', '');
            if ($request->hasFile('about_poster_file')) {
                $file = $request->file('about_poster_file');
                $uploadDir = public_path('images/cities');
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $safeName = time() . '_about_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadDir, $safeName);
                $aPoster = '/images/cities/' . $safeName;
            }
            $aContent['poster_image'] = $aPoster;
            $aContent['video_poster'] = $aPoster;
            $aboutSec->update(['content' => $aContent]);
        }

        // 3.5 FAQ
        $faqSec = $page->sections()->where('section_key', 'faq')->first();
        if ($faqSec) {
            $fContent = $faqSec->content ?? [];
            $fTitle = $request->input('sections.faq.title') ?? $request->input('sections.faq.heading', '');
            $fContent['title'] = $fTitle;
            $fContent['heading'] = $fTitle;
            $fContent['subtitle'] = $request->input('sections.faq.subtitle', '');

            if ($request->has('faq_q') && is_array($request->input('faq_q'))) {
                $qs = (array) $request->input('faq_q');
                $as = (array) $request->input('faq_a');
                $items = [];
                foreach ($qs as $idx => $q) {
                    $qText = trim($q);
                    $aText = trim($as[$idx] ?? '');
                    if ($qText !== '') {
                        $items[] = ['q' => $qText, 'a' => $aText];
                    }
                }
                $fContent['items'] = $items;
            } elseif (!empty($submittedSections['faq']['items']) && is_array($submittedSections['faq']['items'])) {
                $fContent['items'] = array_values(array_filter($submittedSections['faq']['items'], fn($item) => !empty(trim($item['q'] ?? ($item['question'] ?? '')))));
            } else {
                $fContent['items'] = [];
            }
            $faqSec->update(['content' => $fContent]);
        }

        // 3.6 Contact CTA
        $contactSec = $page->sections()->where('section_key', 'contact')->first();
        if ($contactSec) {
            $ctContent = $contactSec->content ?? [];
            $cHeading = $request->input('sections.contact.heading') ?? ($request->input('sections.contact.title') ?? ($submittedSections['contact']['heading'] ?? ($submittedSections['contact']['title'] ?? '')));
            $ctContent['heading'] = $cHeading;
            $ctContent['title'] = $cHeading;
            $ctContent['subtitle'] = $request->input('sections.contact.subtitle') ?? ($submittedSections['contact']['subtitle'] ?? '');
            $cBtnText = $request->input('sections.contact.btn_text') ?? ($request->input('sections.contact.button_text') ?? ($submittedSections['contact']['btn_text'] ?? ($submittedSections['contact']['button_text'] ?? '')));
            $ctContent['btn_text'] = $cBtnText;
            $ctContent['button_text'] = $cBtnText;
            $ctContent['submit_button'] = $cBtnText;
            $ctContent['phone'] = $request->input('sections.contact.phone') ?? ($submittedSections['contact']['phone'] ?? '');
            $ctContent['email'] = $request->input('sections.contact.email') ?? ($submittedSections['contact']['email'] ?? '');
            $contactSec->update(['content' => $ctContent]);
        }

        // Handle FAQs
        $faqs = [];
        if ($request->has('faqs') && is_array($request->input('faqs'))) {
            foreach ($request->input('faqs') as $faq) {
                $q = trim($faq['question'] ?? ($faq['q'] ?? ''));
                $a = trim($faq['answer'] ?? ($faq['a'] ?? ''));
                if ($q !== '') {
                    $faqs[] = ['question' => $q, 'answer' => $a];
                }
            }
        }

        // Handle Featured Communities
        $featComms = $request->input('featured_communities', []);
        if (is_string($featComms)) {
            $featComms = json_decode($featComms, true) ?: [];
        }
        $cleanFeatComms = is_array($featComms) ? array_values(array_filter(array_map('intval', $featComms))) : [];

        // 4. Create City record
        $city = City::create([
            'name'                 => $name,
            'slug'                 => $uniqueSlug,
            'page_id'              => $page->id,
            'image'                => $heroBgImage,
            'status'               => $status,
            'order'                => ((int) City::max('order')) + 1,
            'is_active'            => $isActive,
            'h1'                   => $request->input('h1'),
            'tagline'              => $request->input('tagline'),
            'short_content'        => $request->input('short_content'),
            'full_content'         => $request->input('full_content'),
            'faq_heading'          => $request->input('faq_heading'),
            'faq_subtitle'         => $request->input('faq_subtitle'),
            'faqs'                 => $faqs,
            'featured_communities' => $cleanFeatComms,
        ]);

        return redirect()->route('admin.cities.index')
            ->with('success', "City '{$name}' created successfully!");
    }

    /**
     * Show edit form for City.
     */
    public function edit(City $city)
    {
        $city->load(['page.sections']);
        $page = $city->page;
        $sections = $page ? $page->sections->keyBy('section_key') : collect();
        $commContent = $sections['communities']->content ?? [];
        $selectedProjectIds = (array) ($commContent['selected_ids'] ?? ($commContent['project_ids'] ?? []));
        $faqContent = $sections['faq']->content ?? [];
        $faqItems = (array) ($faqContent['items'] ?? []);
        $allProjects = Project::with('page')->orderBy('order', 'asc')->get();

        // Communities assigned to this city via city_id
        $assignedCommunities = \App\Models\Community::where('city_id', $city->id)
            ->orderBy('order', 'asc')->orderBy('name', 'asc')->get();

        return view('admin.cities.edit', compact('city', 'page', 'sections', 'selectedProjectIds', 'faqItems', 'allProjects', 'assignedCommunities'));
    }

    /**
     * Update an existing City.
     */
    public function update(Request $request, City $city)
    {
        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'slug'   => ['nullable', 'string', 'max:255'],
            'status' => ['nullable', 'string', 'in:publish,draft,sold_out'],
        ]);

        $name = trim($validated['name']);
        $rawSlug = trim($request->input('slug') ?: $name);
        $cleanRawSlug = ltrim(preg_replace('#^city/#', '', ltrim($rawSlug, '/')), '/');
        $slug = Str::slug($cleanRawSlug ?: $name);

        $status = $request->input('status', 'draft');
        if (!in_array($status, ['publish', 'draft', 'sold_out'])) {
            $status = 'draft';
        }
        $isActive = ($status !== 'draft');

        // Check slug uniqueness
        $existingPage = Page::where('slug', $slug)->where('id', '!=', $city->page_id)->first();
        if ($existingPage) {
            $slug = $slug . '-' . $city->id;
        }

        // Handle cover image
        $coverImage = $city->image;
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $uploadDir = public_path('images/cities');
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);
            $filename = time() . '_cover_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $filename);
            $coverImage = '/images/cities/' . $filename;
        }

        // Handle FAQs
        $faqs = [];
        if ($request->has('faqs') && is_array($request->input('faqs'))) {
            foreach ($request->input('faqs') as $faq) {
                $q = trim($faq['question'] ?? ($faq['q'] ?? ''));
                $a = trim($faq['answer'] ?? ($faq['a'] ?? ''));
                if ($q !== '') $faqs[] = ['question' => $q, 'answer' => $a];
            }
        }

        // Handle Featured Communities
        $featComms = $request->input('featured_communities', []);
        if (is_string($featComms)) $featComms = json_decode($featComms, true) ?: [];
        $cleanFeatComms = is_array($featComms) ? array_values(array_filter(array_map('intval', $featComms))) : [];

        // Update City
        $city->update([
            'name'                  => $name,
            'slug'                  => $slug,
            'status'                => $status,
            'is_active'             => $isActive,
            'image'                 => $coverImage,
            'h1'                    => $request->input('h1'),
            'tagline'               => $request->input('tagline'),
            'short_content'         => $request->input('short_content'),
            'full_content'          => $request->input('full_content'),
            'faq_heading'           => $request->input('faq_heading'),
            'faq_subtitle'          => $request->input('faq_subtitle'),
            'faqs'                  => $faqs,
            'featured_communities'  => $cleanFeatComms,
        ]);

        // Auto sync updated City Name to all linked communities' projects
        foreach ($city->communities as $comm) {
            $freshLocationString = $comm->name . ($name ? ', ' . $name : '');
            \App\Models\Project::where('community_id', $comm->id)->update([
                'location' => $freshLocationString
            ]);
        }

        // Update Page
        $page = $city->page;
        if ($page) {
            $page->update([
                'title'            => $name,
                'slug'             => $slug,
                'status'           => $status,
                'is_published'     => $isActive,
                'meta_title'       => $request->input('meta_title') ?: ($name . ' Properties | Luxury Investment & Community Guide'),
                'meta_description' => $request->input('meta_description') ?: ("Explore luxury waterfront homes, real estate, and investment projects in {$name}."),
                'meta_keywords'    => $request->input('meta_keywords') ?: ("{$name}, real estate in {$name}, properties for sale in {$name}"),
            ]);

            // Hero
            $heroSec = $page->sections()->where('section_key', 'hero')->first();
            if ($heroSec) {
                $hContent = $heroSec->content ?? [];
                // Use cover_image_file (new style) if uploaded, else hero_image_file (legacy), else keep existing
                if ($coverImage !== $city->getOriginal('image')) {
                    $hContent['bg_image'] = $coverImage;
                } elseif ($request->hasFile('hero_image_file')) {
                    $file = $request->file('hero_image_file');
                    $filename = time() . '_hero_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/cities'), $filename);
                    $hContent['bg_image'] = '/images/cities/' . $filename;
                    $city->update(['image' => '/images/cities/' . $filename]);
                } else {
                    $hContent['bg_image'] = $coverImage ?: '';
                }
                $hContent['title'] = $request->input('sections.hero.title', '');
                $hContent['subtitle'] = $request->input('sections.hero.subtitle', '');
                $hContent['badge'] = $request->input('sections.hero.badge', '');
                $heroSec->update(['content' => $hContent]);
            }

            // TOC / Content
            $contentSec = $page->sections()->where('section_key', 'content')->first();
            if ($contentSec) {
                $cContent = $contentSec->content ?? [];
                $cContent['title'] = $request->input('sections.content.title', '');
                $cContent['intro'] = $request->input('sections.content.intro', '');
                $html = $request->input('sections.content.html', '');
                $cContent['html'] = $html;
                $cContent['body'] = $html;
                $cContent['appt_title'] = $request->input('sections.content.appt_title', '');
                $page->update(['body' => $html ?: null]);
                $contentSec->update(['content' => $cContent]);
            }

            // Project Cards (Featured Communities)
            $commSec = $page->sections()->where('section_key', 'communities')->first();
            if ($commSec) {
                $commContent = $commSec->content ?? [];
                $commContent['heading'] = $request->input('sections.communities.heading', '') ?: ($commContent['heading'] ?? 'Featured Communities');
                $commContent['subtitle'] = $request->input('sections.communities.subtitle', '') ?: ($commContent['subtitle'] ?? '');
                if ($request->has('featured_communities')) {
                    $commContent['selected_ids'] = $cleanFeatComms;
                    $commContent['project_ids'] = $cleanFeatComms;
                } elseif ($request->has('selected_project_ids')) {
                    $cleanSelectedIds = array_values(array_filter(array_map('intval', (array)$request->input('selected_project_ids'))));
                    $commContent['selected_ids'] = $cleanSelectedIds;
                    $commContent['project_ids'] = $cleanSelectedIds;
                }
                $commSec->update(['content' => $commContent]);
            }

            // About
            $aboutSec = $page->sections()->where('section_key', 'about')->first();
            if ($aboutSec) {
                $aContent = $aboutSec->content ?? [];
                $aHeading = $request->input('sections.about.heading') ?? $request->input('sections.about.title', '');
                $aContent['heading'] = $aHeading;
                $aContent['title'] = $aHeading;
                $aContent['description'] = $request->input('sections.about.description', '');
                $aContent['video_url'] = $request->input('sections.about.video_url', '');
                if ($request->hasFile('about_poster_file')) {
                    $file = $request->file('about_poster_file');
                    $safeName = time() . '_about_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
                    $file->move(public_path('images/cities'), $safeName);
                    $aContent['video_poster'] = '/images/cities/' . $safeName;
                    $aContent['poster_image'] = '/images/cities/' . $safeName;
                } elseif ($request->has('sections.about.poster_image')) {
                    $aPoster = $request->input('sections.about.poster_image', '');
                    $aContent['poster_image'] = $aPoster;
                    $aContent['video_poster'] = $aPoster;
                }
                $aboutSec->update(['content' => $aContent]);
            }

            // FAQ
            $faqSec = $page->sections()->where('section_key', 'faq')->first();
            if ($faqSec) {
                $fContent = $faqSec->content ?? [];
                $fTitle = $request->input('faq_heading') ?? $request->input('sections.faq.title') ?? $request->input('sections.faq.heading', '');
                $fContent['title'] = $fTitle;
                $fContent['heading'] = $fTitle;
                $fContent['subtitle'] = $request->input('faq_subtitle') ?? $request->input('sections.faq.subtitle', '');

                // New format: faqs[idx][question] / faqs[idx][answer]
                if ($request->has('faqs') && is_array($request->input('faqs'))) {
                    $faqItems = [];
                    foreach ($request->input('faqs') as $faq) {
                        $q = trim($faq['question'] ?? ($faq['q'] ?? ''));
                        $a = trim($faq['answer'] ?? ($faq['a'] ?? ''));
                        if ($q !== '') $faqItems[] = ['q' => $q, 'a' => $a];
                    }
                    $fContent['items'] = $faqItems;
                } elseif ($request->has('faq_q') && is_array($request->input('faq_q'))) {
                    $qs = (array) $request->input('faq_q');
                    $as = (array) $request->input('faq_a');
                    $items = [];
                    foreach ($qs as $idx => $q) {
                        $qText = trim($q);
                        $aText = trim($as[$idx] ?? '');
                        if ($qText !== '') {
                            $items[] = ['q' => $qText, 'a' => $aText];
                        }
                    }
                    $fContent['items'] = $items;
                } else {
                    $fContent['items'] = [];
                }
                $faqSec->update(['content' => $fContent]);
            }

            // Contact
            $contactSec = $page->sections()->where('section_key', 'contact')->first();
            if ($contactSec) {
                $ctContent = $contactSec->content ?? [];
                $cHeading = $request->input('sections.contact.heading') ?? $request->input('sections.contact.title', '');
                $ctContent['heading'] = $cHeading;
                $ctContent['title'] = $cHeading;
                $ctContent['subtitle'] = $request->input('sections.contact.subtitle', '');
                $cBtnText = $request->input('sections.contact.btn_text') ?? $request->input('sections.contact.button_text', '');
                $ctContent['btn_text'] = $cBtnText;
                $ctContent['button_text'] = $cBtnText;
                $ctContent['submit_button'] = $cBtnText;
                $ctContent['phone'] = $request->input('sections.contact.phone', '');
                $ctContent['email'] = $request->input('sections.contact.email', '');
                $contactSec->update(['content' => $ctContent]);
            }
        }

        $activeTab = $request->input('active_tab', $request->query('tab', 'general'));
        return redirect()->route('admin.cities.edit', ['city' => $city->id, 'tab' => $activeTab])
            ->with('success', "City '{$name}' updated successfully! Changes are saved.");
    }

    /**
     * Delete a City.
     */
    public function destroy(City $city)
    {
        $name = $city->name;
        if ($city->page) {
            $city->page->sections()->delete();
            $city->page->delete();
        }
        $city->delete();

        return redirect()->route('admin.cities.index')->with('success', "City '{$name}' deleted successfully!");
    }

    /**
     * Update status via ajax/patch.
     */
    public function updateStatus(Request $request, City $city)
    {
        $status = $request->input('status');
        if (!in_array($status, ['publish', 'draft', 'sold_out'])) {
            return response()->json(['success' => false, 'message' => 'Invalid status'], 422);
        }

        $isActive = ($status !== 'draft');
        $city->update([
            'status'    => $status,
            'is_active' => $isActive,
        ]);

        if ($city->page) {
            $city->page->update([
                'status'       => $status,
                'is_published' => $isActive,
            ]);
        }

        return response()->json(['success' => true, 'status' => $status]);
    }
}
