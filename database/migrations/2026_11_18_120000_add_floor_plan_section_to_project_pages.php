<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $slugs = \App\Models\Page::projectSlugs();
        foreach ($slugs as $slug) {
            $page = \App\Models\Page::where('slug', $slug)->first();
            if (!$page) continue;

            // Skip if already exists
            $exists = \App\Models\PageSection::where('page_id', $page->id)
                ->where('section_key', 'floor_plan')
                ->exists();
            if ($exists) continue;

            // Shift orders >= 6 up by 1 (content=6 -> 7, gallery=7 -> 8, etc.)
            \App\Models\PageSection::where('page_id', $page->id)
                ->where('order', '>=', 6)
                ->increment('order');

            // Insert floor_plan at order 6 (between payment_plan=5 and content=7)
            \App\Models\PageSection::create([
                'page_id'      => $page->id,
                'section_key'  => 'floor_plan',
                'section_name' => 'Floor Plan',
                'order'        => 6,
                'is_active'    => true,
                'is_visible'   => true,
                'content'      => [
                    'title'       => '',
                    'description' => '',
                    'plan_images' => [],
                ],
            ]);
        }
    }

    public function down(): void
    {
        $slugs = \App\Models\Page::projectSlugs();
        foreach ($slugs as $slug) {
            $page = \App\Models\Page::where('slug', $slug)->first();
            if (!$page) continue;

            \App\Models\PageSection::where('page_id', $page->id)
                ->where('section_key', 'floor_plan')
                ->delete();

            // Shift orders back
            \App\Models\PageSection::where('page_id', $page->id)
                ->where('order', '>=', 7)
                ->decrement('order');
        }
    }
};
