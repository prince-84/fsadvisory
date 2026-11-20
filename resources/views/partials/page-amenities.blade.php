@php
    $amTitle = page_section('amenities', 'title', '', $page->slug ?? '');
    $amSub = page_section('amenities', 'subtitle', '', $page->slug ?? '');
    $rawAmItems = page_section('amenities', 'items', [], $page->slug ?? '');
    $amItems = array_values(array_filter((array)$rawAmItems, fn($item) => is_array($item) && !empty(trim($item['name'] ?? ''))));
    $isEmbedded = $embedded ?? false;
@endphp

@if(!empty($amItems) || !empty(trim((string)$amTitle)) || !empty(trim((string)$amSub)))
@if(!$isEmbedded)
<section id="features-amenities" class="fsFeaturesAmenitiesSection" style="padding: 36px 0 20px; background-color: #f8fafc;">
    <div class="container">
@endif
        <style>
            .fsFeaturesAmenitiesCard {
                background: #ffffff !important;
                border: 1px solid #e2e8f0 !important;
                border-radius: 14px !important;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
                padding: 32px 36px 36px !important;
                box-sizing: border-box !important;
                margin-bottom: {{ $isEmbedded ? '0' : '24px' }} !important;
            }
            .fsFeaturesAmenitiesTitle {
                font-size: 24px !important;
                font-weight: 700 !important;
                color: #BFA16A !important;
                margin: 0 !important;
                line-height: 1.25 !important;
                letter-spacing: -0.01em !important;
                font-family: inherit !important;
            }
            .fsFeaturesAmenitiesSubtitle {
                font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
                font-size: 14.5px !important;
                color: #2b2b2b !important;
                margin: 6px 0 16px 0 !important;
                line-height: 1.6 !important;
                font-weight: 400 !important;
            }
            .fsFeaturesAmenitiesDivider {
                height: 1px !important;
                background: #f1f5f9 !important;
                margin: 18px 0 26px 0 !important;
                width: 100% !important;
            }
            .fsFeaturesAmenitiesGrid {
                display: grid !important;
                grid-template-columns: repeat(2, 1fr) !important;
                column-gap: 48px !important;
                row-gap: 20px !important;
            }
            .fsAmenityRow {
                display: flex !important;
                align-items: center !important;
                gap: 14px !important;
                min-width: 0 !important;
            }
            .fsAmenityCheckBadge {
                width: 22px !important;
                height: 22px !important;
                min-width: 22px !important;
                border-radius: 50% !important;
                background: #FAF5EB !important;
                border: 1px solid #DFCFB2 !important;
                display: inline-flex !important;
                align-items: center !important;
                justify-content: center !important;
                flex-shrink: 0 !important;
            }
            .fsAmenityCustomIcon {
                width: 24px !important;
                height: 24px !important;
                min-width: 24px !important;
                object-fit: contain !important;
                flex-shrink: 0 !important;
            }
            .fsAmenityText {
                font-size: 15px !important;
                font-weight: 500 !important;
                color: #1e293b !important;
                line-height: 1.4 !important;
                word-break: break-word !important;
            }
            @media (max-width: 768px) {
                .fsFeaturesAmenitiesCard {
                    padding: 24px 20px !important;
                }
                .fsFeaturesAmenitiesGrid {
                    grid-template-columns: 1fr !important;
                    row-gap: 16px !important;
                }
            }
        </style>

        <div class="fsFeaturesAmenitiesCard">
            @if(!empty(trim((string)$amTitle)))
                <h2 class="fsFeaturesAmenitiesTitle">{{ $amTitle }}</h2>
            @endif
            @if(!empty($amSub))
                <p class="fsFeaturesAmenitiesSubtitle">{{ $amSub }}</p>
            @endif
            <div class="fsFeaturesAmenitiesDivider"></div>

            <div class="fsFeaturesAmenitiesGrid">
                @foreach($amItems as $amItem)
                    @php
                        $aName = trim($amItem['name'] ?? '');
                        $aIcon = trim($amItem['icon'] ?? '');
                        
                        if (empty($aIcon)) {
                            $dbAmenity = \App\Models\Amenity::where('name', $aName)->first();
                            if ($dbAmenity && !empty($dbAmenity->icon)) {
                                $aIcon = $dbAmenity->icon;
                            }
                        }

                        $isAutoCheck = empty($aIcon) || str_contains($aIcon, 'auto-check') || str_contains($aIcon, 'check');
                        $isCustomImg = !$isAutoCheck && (!empty($aIcon) && (str_starts_with($aIcon, '/') || str_starts_with($aIcon, 'http') || file_exists(public_path(ltrim($aIcon, '/')))));
                        $imgSrc = $isCustomImg ? (str_starts_with($aIcon, 'http') ? $aIcon : asset(ltrim($aIcon, '/'))) : '';
                    @endphp
                    <div class="fsAmenityRow">
                        @if($isCustomImg)
                            <img src="{{ $imgSrc }}" alt="{{ $aName }}" class="fsAmenityCustomIcon" loading="lazy">
                        @else
                            <span class="fsAmenityCheckBadge">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#BFA16A" stroke-width="2.6" stroke-linecap="round" stroke-linejoin="round">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </span>
                        @endif
                        <span class="fsAmenityText">{{ $aName }}</span>
                    </div>
                @endforeach
            </div>
        </div>
@if(!$isEmbedded)
    </div>
</section>
@endif
@endif
