<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class FooterSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_title',
        'brand_description',
        'newsletter_title',
        'newsletter_subtitle',
        'newsletter_enabled',
        'social_links',
        'columns',
        'disclaimer_text',
        'copyright_text',
    ];

    protected $casts = [
        'newsletter_enabled' => 'boolean',
        'social_links' => 'array',
        'columns' => 'array',
    ];

    public static function current(): self
    {
        try {
            return Cache::rememberForever('footer_section_current', function () {
                $record = static::first();
                if (!$record) {
                    $record = static::create([
                        'brand_title' => 'Saima',
                        'brand_description' => 'Saima Group trusted property advisory serving local and international buyers. We specialize in residential and investment properties, offering clear guidance, market insight, and long term value.',
                        'newsletter_title' => 'Subscribe to Our Newsletter',
                        'newsletter_subtitle' => 'Get the latest updates and property offers delivered to your inbox.',
                        'newsletter_enabled' => false,
                        'social_links' => [
                            ['platform' => 'facebook', 'url' => ''],
                            ['platform' => 'instagram', 'url' => ''],
                            ['platform' => 'twitter', 'url' => ''],
                            ['platform' => 'linkedin', 'url' => ''],
                        ],
                        'columns' => static::defaultColumns(),
                        'disclaimer_text' => null,
                        'copyright_text' => '© 2026 fsadvisory.pk All Rights Reserved.',
                    ]);
                }
                return $record;
            });
        } catch (\Throwable $e) {
            $fallback = new static([
                'brand_title' => 'Saima',
                'brand_description' => 'Saima Group trusted property advisory serving local and international buyers. We specialize in residential and investment properties, offering clear guidance, market insight, and long term value.',
                'newsletter_title' => 'Subscribe to Our Newsletter',
                'newsletter_subtitle' => 'Get the latest updates and property offers delivered to your inbox.',
                'newsletter_enabled' => false,
                'social_links' => [],
                'columns' => static::defaultColumns(),
                'disclaimer_text' => null,
                'copyright_text' => '© 2026 fsadvisory.pk All Rights Reserved.',
            ]);
            return $fallback;
        }
    }

    public static function defaultColumns(): array
    {
        return [
            [
                'header' => 'About Saima',
                'links' => [
                    ['label' => 'Home', 'url' => '/'],
                    ['label' => 'Projects', 'url' => '/#communities'],
                    ['label' => 'About Us', 'url' => '/about-us'],
                    ['label' => 'Contact Us', 'url' => '/contact-us'],
                    ['label' => 'Privacy Policy', 'url' => '/privacy-policy'],
                    ['label' => 'Terms & Condition', 'url' => '/terms-and-conditions'],
                ]
            ],
            [
                'header' => 'Quick Links',
                'links' => [
                    ['label' => 'Home', 'url' => '/'],
                    ['label' => 'Projects', 'url' => '/#communities'],
                    ['label' => 'Contact Us', 'url' => '/contact-us'],
                ]
            ],
            [
                'header' => 'Connect With Us',
                'links' => [
                    ['label' => 'Contact Us', 'url' => '/contact-us'],
                ]
            ]
        ];
    }

    public static function flushCache(): void
    {
        Cache::forget('footer_section_current');
    }
}
