<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use OwenIt\Auditing\Contracts\Auditable;

class Amenity extends Model implements Auditable
{
    use HasFactory, \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'svg_content',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    protected static function booted(): void
    {
        static::saving(function (Amenity $amenity) {
            if (empty($amenity->slug) && !empty($amenity->name)) {
                $amenity->slug = Str::slug($amenity->name);
            }
        });
    }

    /**
     * Get clean inline SVG markup or fallback img tag.
     */
    public function getRenderedSvgAttribute(): string
    {
        if (!empty($this->svg_content)) {
            return $this->svg_content;
        }

        if (!empty($this->icon)) {
            $relativePath = ltrim($this->icon, '/');
            $fullPath = public_path($relativePath);
            if (file_exists($fullPath) && is_file($fullPath)) {
                $content = @file_get_contents($fullPath);
                if ($content && str_contains($content, '<svg')) {
                    return $content;
                }
            }
            return '<img src="' . e($this->icon) . '" alt="' . e($this->name) . '" style="width:100%;height:100%;object-fit:contain;" />';
        }

        // Auto green checkmark fallback when no logo was uploaded
        $autoCheckPath = public_path('uploads/amenities/auto-check.svg');
        if (file_exists($autoCheckPath)) {
            return file_get_contents($autoCheckPath);
        }

        return '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="11" fill="#FAF5EB" stroke="#DFCFB2" stroke-width="1.2"/><path d="M7.5 12.5L10.5 15.5L16.5 9.5" stroke="#BFA16A" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round"/></svg>';
    }
}
