<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Developer;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DeveloperController extends Controller
{
    /**
     * Display a listing of developers (3 columns: #, Developer Name, Actions).
     */
    public function index(Request $request)
    {
        $developers = Developer::orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();

        $totalDevelopers = $developers->count();

        return view('admin.developers.index', compact('developers', 'totalDevelopers'));
    }

    /**
     * Show the form for creating a new developer.
     */
    public function create()
    {
        $assignedProjects = collect();
        return view('admin.developers.create', compact('assignedProjects'));
    }

    /**
     * Store a newly created developer in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', 'unique:developers,slug'],
            'h1'                => ['nullable', 'string', 'max:255'],
            'tagline'           => ['nullable', 'string', 'max:255'],
            'logo_file'         => ['nullable', 'file', 'mimes:svg', 'max:5120'],
            'cover_image_file'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'short_content'     => ['nullable', 'string'],
            'full_content'      => ['nullable', 'string'],
            'status'            => ['nullable', 'string', 'in:draft,publish'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string'],
            'meta_keywords'     => ['nullable', 'string', 'max:255'],
            'canonical_url'     => ['nullable', 'string', 'max:255'],
            'featured_projects' => ['nullable', 'array'],
            'faqs'              => ['nullable', 'array'],
        ]);

        $name = trim($validated['name']);
        $rawSlug = trim($request->input('slug') ?: $name);
        $cleanSlug = Str::slug($rawSlug);

        // Ensure unique slug
        $baseSlug = $cleanSlug;
        $counter = 1;
        while (Developer::where('slug', $cleanSlug)->exists()) {
            $cleanSlug = $baseSlug . '-' . $counter;
            $counter++;
        }

        // Handle Developer Logo (Only SVG allowed)
        $logo = null;
        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $filename = time() . '_logo_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.svg';
            $dest = public_path('uploads/developers');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            $logo = 'uploads/developers/' . $filename;
        }

        // Handle Cover Image (Auto OG Image sync)
        $coverImage = null;
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $filename = time() . '_cover_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/developers');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            $coverImage = 'uploads/developers/' . $filename;
        }

        $ogImage = $coverImage;

        // Clean FAQs
        $faqs = [];
        if ($request->has('faqs') && is_array($request->input('faqs'))) {
            foreach ($request->input('faqs') as $faq) {
                if (!empty(trim($faq['question'] ?? '')) || !empty(trim($faq['answer'] ?? ''))) {
                    $faqs[] = [
                        'question' => trim($faq['question'] ?? ''),
                        'answer'   => trim($faq['answer'] ?? ''),
                    ];
                }
            }
        }

        $status = $request->input('status', 'draft');
        if (!in_array($status, ['draft', 'publish'])) {
            $status = 'draft';
        }

        $featProjs = $request->input('featured_projects', []);
        if (is_string($featProjs)) {
            $featProjs = json_decode($featProjs, true) ?: [];
        }
        $cleanFeaturedProjs = is_array($featProjs) ? array_values(array_filter(array_map('intval', $featProjs))) : [];

        $developer = Developer::create([
            'name'              => $name,
            'slug'              => $cleanSlug,
            'h1'                => $request->input('h1'),
            'tagline'           => $request->input('tagline'),
            'logo'              => $logo,
            'cover_image'       => $coverImage,
            'og_image'          => $ogImage,
            'short_content'     => $request->input('short_content'),
            'full_content'      => $request->input('full_content'),
            'meta_title'        => $request->input('meta_title'),
            'meta_description'  => $request->input('meta_description'),
            'meta_keywords'     => $request->input('meta_keywords'),
            'canonical_url'     => $request->input('canonical_url'),
            'featured_projects' => $cleanFeaturedProjs,
            'faqs'              => $faqs,
            'faq_heading'       => $request->input('faq_heading'),
            'faq_subtitle'      => $request->input('faq_subtitle'),
            'status'            => $status,
            'is_active'         => ($status === 'publish'),
            'order'             => 0,
        ]);

        return redirect()->route('admin.developers.index')
            ->with('success', 'Developer "' . $developer->name . '" has been created successfully!');
    }

    /**
     * Show the form for editing the specified developer.
     */
    public function edit(Developer $developer)
    {
        $assignedProjects = Project::where('developer_id', $developer->id)
            ->orWhere(function($query) use ($developer) {
                if (!empty($developer->name)) {
                    $query->where('developer', $developer->name);
                }
            })
            ->orderBy('order', 'asc')
            ->orderBy('title', 'asc')
            ->get();

        return view('admin.developers.edit', compact('developer', 'assignedProjects'));
    }

    /**
     * Update the specified developer in storage.
     */
    public function update(Request $request, Developer $developer)
    {
        $validated = $request->validate([
            'name'              => ['required', 'string', 'max:255'],
            'slug'              => ['nullable', 'string', 'max:255', 'unique:developers,slug,' . $developer->id],
            'h1'                => ['nullable', 'string', 'max:255'],
            'tagline'           => ['nullable', 'string', 'max:255'],
            'logo_file'         => ['nullable', 'file', 'mimes:svg', 'max:5120'],
            'cover_image_file'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:15360'],
            'short_content'     => ['nullable', 'string'],
            'full_content'      => ['nullable', 'string'],
            'status'            => ['nullable', 'string', 'in:draft,publish'],
            'meta_title'        => ['nullable', 'string', 'max:255'],
            'meta_description'  => ['nullable', 'string'],
            'meta_keywords'     => ['nullable', 'string', 'max:255'],
            'canonical_url'     => ['nullable', 'string', 'max:255'],
            'featured_projects' => ['nullable', 'array'],
            'faqs'              => ['nullable', 'array'],
        ]);

        $name = trim($validated['name']);
        $rawSlug = trim($request->input('slug') ?: $name);
        $cleanSlug = Str::slug($rawSlug);

        // Handle Developer Logo (Only SVG allowed)
        $logo = $developer->logo;
        if ($request->hasFile('logo_file')) {
            $file = $request->file('logo_file');
            $filename = time() . '_logo_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.svg';
            $dest = public_path('uploads/developers');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            $logo = 'uploads/developers/' . $filename;
        }

        // Handle Cover Image (Auto OG Image sync)
        $coverImage = $developer->cover_image;
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $filename = time() . '_cover_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->getClientOriginalExtension();
            $dest = public_path('uploads/developers');
            if (!file_exists($dest)) {
                mkdir($dest, 0755, true);
            }
            $file->move($dest, $filename);
            $coverImage = 'uploads/developers/' . $filename;
        }

        $ogImage = $coverImage ?: $developer->og_image;

        // Clean FAQs
        $faqs = [];
        if ($request->has('faqs') && is_array($request->input('faqs'))) {
            foreach ($request->input('faqs') as $faq) {
                if (!empty(trim($faq['question'] ?? '')) || !empty(trim($faq['answer'] ?? ''))) {
                    $faqs[] = [
                        'question' => trim($faq['question'] ?? ''),
                        'answer'   => trim($faq['answer'] ?? ''),
                    ];
                }
            }
        }

        $status = $request->input('status', $developer->status ?? 'draft');
        if (!in_array($status, ['draft', 'publish'])) {
            $status = 'draft';
        }

        $featProjs = $request->input('featured_projects', []);
        if (is_string($featProjs)) {
            $featProjs = json_decode($featProjs, true) ?: [];
        }
        $cleanFeaturedProjs = is_array($featProjs) ? array_values(array_filter(array_map('intval', $featProjs))) : [];

        $developer->update([
            'name'              => $name,
            'slug'              => $cleanSlug,
            'h1'                => $request->input('h1'),
            'tagline'           => $request->input('tagline'),
            'logo'              => $logo,
            'cover_image'       => $coverImage,
            'og_image'          => $ogImage,
            'short_content'     => $request->input('short_content'),
            'full_content'      => $request->input('full_content'),
            'meta_title'        => $request->input('meta_title'),
            'meta_description'  => $request->input('meta_description'),
            'meta_keywords'     => $request->input('meta_keywords'),
            'canonical_url'     => $request->input('canonical_url'),
            'featured_projects' => $cleanFeaturedProjs,
            'faqs'              => $faqs,
            'faq_heading'       => $request->input('faq_heading'),
            'faq_subtitle'      => $request->input('faq_subtitle'),
            'status'            => $status,
            'is_active'         => ($status === 'publish'),
        ]);

        return redirect()->back()
            ->with('success', 'Developer "' . $developer->name . '" updated successfully!');
    }

    /**
     * Remove the specified developer from storage.
     */
    public function destroy(Developer $developer)
    {
        $name = $developer->name;
        $developer->delete();

        return redirect()->route('admin.developers.index')
            ->with('success', 'Developer "' . $name . '" deleted successfully!');
    }
}
