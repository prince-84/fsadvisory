@php
$rawItems = page_section('highlights', 'items', null);
$items = [];

if (is_array($rawItems)) {
    foreach ($rawItems as $highlight) {
        $label = trim((string)($highlight['label'] ?? ($highlight['title'] ?? '')));
        $value = trim((string)($highlight['value'] ?? ($highlight['description'] ?? '')));
        if ($label !== '' || $value !== '') {
            $items[] = $highlight;
        }
    }
}
@endphp

@if(!empty($items))
<section class="highlightsSection" style="background-color: #f7f5f2; border-bottom: 1px solid #ebe6dd; padding: 24px 0;">
    <style>
    .highlightsGrid {
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 16px !important;
        align-items: stretch !important;
        justify-content: flex-start !important;
        width: 100% !important;
    }
    .highlightCard {
        flex: 1 1 calc(16.666% - 14px) !important;
        min-width: 175px !important;
        max-width: 100% !important;
        background: #ffffff !important;
        border: 1px solid #eeebe3 !important;
        border-radius: 12px !important;
        padding: 14px 18px !important;
        display: flex !important;
        align-items: center !important;
        gap: 14px !important;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04) !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
        box-sizing: border-box !important;
    }
    .highlightCard:hover {
        border-color: #BFA16A !important;
        transform: translateY(-2px) !important;
        box-shadow: 0 6px 18px rgba(191, 161, 106, 0.18) !important;
    }
    .highlightIconBox {
        width: 44px !important;
        height: 44px !important;
        min-width: 44px !important;
        min-height: 44px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        flex-shrink: 0 !important;
    }
    .highlightIconBox img {
        width: 44px !important;
        height: 44px !important;
        max-width: 44px !important;
        max-height: 44px !important;
        object-fit: contain !important;
        display: block !important;
        filter: none !important;
        -webkit-filter: none !important;
    }
    .highlightIconBox .defaultBadge {
        width: 40px !important;
        height: 40px !important;
        border-radius: 50% !important;
        background: #BFA16A !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        color: #ffffff !important;
    }
    .highlightInfo {
        display: flex !important;
        flex-direction: column !important;
        gap: 3px !important;
        min-width: 0 !important;
        flex: 1 !important;
    }
    .highlightLabel {
        font-size: 14.5px !important;
        font-weight: 700 !important;
        color: #111827 !important;
        line-height: 1.25 !important;
        display: block !important;
        margin: 0 !important;
    }
    .highlightValue {
        font-size: 13px !important;
        font-weight: 500 !important;
        color: #4b5563 !important;
        line-height: 1.35 !important;
        display: block !important;
        margin: 0 !important;
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    @media (max-width: 1200px) {
        .highlightCard {
            flex: 1 1 calc(33.333% - 12px) !important;
            min-width: 180px !important;
        }
    }
    @media (max-width: 768px) {
        .highlightCard {
            flex: 1 1 calc(50% - 8px) !important;
            min-width: 145px !important;
            padding: 12px 14px !important;
            gap: 10px !important;
        }
        .highlightIconBox,
        .highlightIconBox img {
            width: 38px !important;
            height: 38px !important;
            min-width: 38px !important;
            min-height: 38px !important;
        }
        .highlightLabel {
            font-size: 13.5px !important;
        }
        .highlightValue {
            font-size: 12px !important;
        }
    }
    @media (max-width: 480px) {
        .highlightCard {
            flex: 1 1 100% !important;
        }
    }
    </style>
    <div class="container">
        <div class="highlightsGrid">
            @foreach($items as $highlight)
                @php
                    $hKey = strtolower($highlight['key'] ?? '');
                    $hLabel = $highlight['label'] ?? ($highlight['title'] ?? 'Highlight');
                    $hValue = $highlight['value'] ?? ($highlight['description'] ?? '');
                    $hIcon = $highlight['icon'] ?? '';
                    if (!empty($hIcon) || !empty($hLabel)) {
                        $matchedAmenity = \App\Models\Amenity::where('is_active', true)
                            ->where(function($q) use ($hIcon, $hLabel) {
                                if (!empty($hIcon)) $q->where('icon', $hIcon);
                                if (!empty($hLabel)) $q->orWhereRaw('LOWER(name) = ?', [strtolower(trim($hLabel))]);
                            })->first();
                        if ($matchedAmenity) {
                            $hLabel = $matchedAmenity->name;
                            if (!empty($matchedAmenity->icon)) $hIcon = $matchedAmenity->icon;
                        }
                    }
                    $isImgFile = !empty($hIcon) && (str_starts_with($hIcon, '/') || str_starts_with($hIcon, 'http') || file_exists(public_path(ltrim($hIcon, '/'))));
                    $imgSrc = $isImgFile ? (str_starts_with($hIcon, 'http') ? $hIcon : asset(ltrim($hIcon, '/'))) : '';
                @endphp
                <div class="highlightCard">
                    @if(!empty($hIcon))
                        <div class="highlightIconBox">
                            @if($isImgFile)
                                <img src="{{ $imgSrc }}" alt="{{ $hLabel }}" loading="lazy">
                            @else
                                <div class="defaultBadge">
                                    @include('partials.highlight-icon', ['label' => $hLabel, 'icon' => $hIcon, 'index' => $loop->index, 'key' => $hKey])
                                </div>
                            @endif
                        </div>
                    @endif
                    <div class="highlightInfo">
                        <span class="highlightLabel">{{ $hLabel }}</span>
                        <span class="highlightValue" title="{{ $hValue }}">{{ $hValue }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif
