<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Project extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'page_id',
        'title',
        'slug',
        'location',
        'price',
        'delivery_date',
        'developer',
        'developer_id',
        'community_id',
        'payment_plan',
        'image',
        'badges',
        'order',
        'is_active',
        'status',
        'show_in_projects',
        'show_in_commercial',
    ];

    protected $casts = [
        'is_active'          => 'boolean',
        'show_in_projects'   => 'boolean',
        'show_in_commercial' => 'boolean',
        'order'              => 'integer',
        'page_id'            => 'integer',
        'developer_id'       => 'integer',
        'community_id'       => 'integer',
        'badges'             => 'array',
    ];

    protected $appends = [
        'url',
        'image_url',
        'headline',
    ];

    /**
     * The detail Page linked to this property card.
     */
    public function page()
    {
        return $this->belongsTo(Page::class, 'page_id');
    }

    /**
     * The Developer linked to this property.
     */
    public function developerRel()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }

    /**
     * The Community linked to this property.
     */
    public function community()
    {
        return $this->belongsTo(Community::class, 'community_id');
    }

    /**
     * Get live formatted location from linked Community & City.
     */
    public function getLocationAttribute($value): ?string
    {
        if ($this->community_id) {
            $comm = $this->relationLoaded('community') ? $this->community : $this->community()->with('city')->first();
            if ($comm) {
                return $comm->name . ($comm->city ? ', ' . $comm->city->name : '');
            }
        }

        return $value;
    }

    /**
     * Get target dynamic page URL.
     */
    public function getUrlAttribute(): string
    {
        $rawSlug = $this->slug ?: ($this->page?->slug ?? '');
        $cleanSlug = ltrim(preg_replace('#^project/#', '', ltrim($rawSlug, '/')), '/');
        if ($cleanSlug !== '') {
            return url('/project/' . $cleanSlug);
        }

        return '#';
    }

    /**
     * Helper for formatted image URL.
     */
    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return '';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        return asset(ltrim($this->image, '/'));
    }

    /**
     * Get the headline from the linked page's hero section.
     */
    public function getHeadlineAttribute(): string
    {
        if ($this->page) {
            $hero = $this->page->relationLoaded('sections')
                ? $this->page->sections->firstWhere('section_key', 'hero')
                : $this->page->sections()->where('section_key', 'hero')->first();

            return (string) ($hero?->content['subtitle'] ?? '');
        }

        return '';
    }

    /**
     * Helper to retrieve metrics from linked page highlights if empty on card.
     */
    public function getHighlightValue(array $aliases): ?string
    {
        if (!$this->page) return null;
        $hlSec = $this->page->relationLoaded('sections')
            ? $this->page->sections->firstWhere('section_key', 'highlights')
            : $this->page->sections()->where('section_key', 'highlights')->first();

        $items = $hlSec?->content['items'] ?? [];
        if (!is_array($items)) return null;

        foreach ($items as $item) {
            $label = strtolower(trim($item['label'] ?? ''));
            $val = trim($item['value'] ?? '');
            if (!$val) continue;

            foreach ($aliases as $alias) {
                if (str_contains($label, strtolower($alias))) {
                    return $val;
                }
            }
        }

        return null;
    }

    public function getPriceAttribute($value): ?string
    {
        if (!empty($value)) return $value;
        return $this->getHighlightValue(['price', 'launch price', 'cost']);
    }

    public function getDeliveryDateAttribute($value): ?string
    {
        if (!empty($value)) return $value;
        return $this->getHighlightValue(['delivery', 'handover', 'completion']);
    }

    public function getDeveloperAttribute($value): ?string
    {
        if (!empty($value) && trim($value) !== 'Modon Properties') {
            return $value;
        }

        if ($this->developer_id) {
            $dev = $this->relationLoaded('developerRel') ? $this->developerRel : $this->developerRel()->first();
            if ($dev) {
                return $dev->name;
            }
        }

        $hl = $this->getHighlightValue(['developer']);
        if ($hl && trim($hl) !== 'Modon Properties') {
            return $hl;
        }

        return null;
    }

    public function getPaymentPlanAttribute($value): ?string
    {
        if (!empty($value)) return $value;
        return $this->getHighlightValue(['payment plan', 'payment']);
    }
}
