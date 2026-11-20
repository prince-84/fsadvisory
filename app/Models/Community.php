<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Community extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'city_id',
        'page_id',
        'name',
        'slug',
        'image',
        'status',
        'order',
        'is_active',
        'h1',
        'tagline',
        'short_content',
        'full_content',
        'featured_projects',
        'faqs',
        'faq_heading',
        'faq_subtitle',
    ];

    protected $casts = [
        'is_active'         => 'boolean',
        'order'             => 'integer',
        'city_id'           => 'integer',
        'page_id'           => 'integer',
        'featured_projects' => 'array',
        'faqs'              => 'array',
    ];

    protected $appends = [
        'url',
    ];

    /**
     * The City this neighbourhood/community belongs to.
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Projects linked to this community.
     */
    public function projects()
    {
        return $this->hasMany(Project::class, 'community_id');
    }

    /**
     * The detail Page linked to this community.
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    /**
     * Target dynamic page URL.
     */
    public function getUrlAttribute(): string
    {
        $slug = ltrim($this->slug ?? '', '/');
        $cleanSlug = ltrim(preg_replace('#^area/#', '', $slug), '/');
        return url('/area/' . $cleanSlug);
    }
}
