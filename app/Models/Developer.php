<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Developer extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'slug',
        'h1',
        'tagline',
        'logo',
        'cover_image',
        'og_image',
        'short_content',
        'full_content',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'canonical_url',
        'featured_projects',
        'faqs',
        'faq_heading',
        'faq_subtitle',
        'image',
        'status',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'order'             => 'integer',
        'featured_projects' => 'array',
        'faqs'              => 'array',
    ];

    /**
     * Projects associated with this developer.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'developer_id');
    }

    /**
     * Get auto OG image URL from cover image or fallback
     */
    public function getOgImageUrlAttribute(): string
    {
        $img = $this->og_image ?: $this->cover_image;
        if (!$img) {
            return asset('images/hero/slide-1.jpg');
        }
        return str_starts_with($img, 'http') ? $img : asset($img);
    }
}

