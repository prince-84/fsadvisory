@php
    $payTitle = page_section('payment_plan', 'title', '', $page->slug);
    $payDesc = page_section('payment_plan', 'description', '', $page->slug);
    
    // Dynamic breakdown cards (Image 1 style)
    $rawBreakdown = page_section('payment_plan', 'breakdown', page_section('payment_plan', 'items', [], $page->slug), $page->slug);
    $breakdownItems = is_array($rawBreakdown) ? array_values(array_filter($rawBreakdown, function($it) {
        return is_array($it) && (!empty(trim($it['title'] ?? '')) || !empty(trim($it['percentage'] ?? '')));
    })) : [];

    // Payment plan sheet images (Image 2 & 3 style)
    $rawPlanImages = page_section('payment_plan', 'plan_images', page_section('payment_plan', 'images', [], $page->slug), $page->slug);
    $planImages = [];
    if (is_array($rawPlanImages)) {
        foreach ($rawPlanImages as $pim) {
            $src = is_string($pim) ? $pim : ($pim['image'] ?? ($pim['src'] ?? ($pim['url'] ?? '')));
            if (!empty(trim($src))) {
                $planImages[] = trim($src);
            }
        }
    }

    $resolvedPlanImages = array_values(array_map(function($s) {
        return str_starts_with($s, 'http') ? $s : asset(ltrim($s, '/'));
    }, $planImages));
@endphp

@if(!empty($breakdownItems) || !empty($planImages) || !empty(trim(strip_tags((string)$payDesc))) || !empty(trim((string)$payTitle)))
@if(!($embedded ?? false))
<section id="paymentplan" class="fsPaymentPlanSection" style="padding: 24px 0 40px; background-color: #f8fafc;">
    <div class="container">
@endif
    <style>
        .fsPaymentPlanCard {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 14px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04) !important;
            padding: 32px 36px 36px !important;
            box-sizing: border-box !important;
        }
        .fsPaymentPlanTitle {
            font-size: 24px !important;
            font-weight: 700 !important;
            color: #BFA16A !important;
            margin: 0 !important;
            line-height: 1.25 !important;
            letter-spacing: -0.01em !important;
            font-family: inherit !important;
        }
        .fsPaymentPlanSubtitle {
            font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
            font-size: 14.5px !important;
            color: #2b2b2b !important;
            margin: 6px 0 16px 0 !important;
            line-height: 1.6 !important;
            font-weight: 400 !important;
        }
        /* Top Segmented Progress Bar (Image 1) */
        .fsPaymentProgressBar {
            display: flex !important;
            height: 42px !important;
            border-radius: 8px !important;
            overflow: hidden !important;
            margin-top: 22px !important;
            margin-bottom: 22px !important;
            width: 100% !important;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.06) !important;
        }
        .fsPaymentProgressSegment {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            color: #ffffff !important;
            font-weight: 700 !important;
            font-size: 14.5px !important;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2) !important;
            transition: opacity 0.2s ease !important;
            min-width: 44px !important;
        }
        .fsPaymentProgressSegment:hover {
            opacity: 0.92 !important;
        }
        /* Breakdown Cards Grid (Image 1) */
        .fsPaymentCardsGrid {
            display: grid !important;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr)) !important;
            gap: 16px !important;
            margin-bottom: 28px !important;
        }
        .fsPaymentCardItem {
            background: #ffffff !important;
            border: 1px solid #e8ecf2 !important;
            border-radius: 12px !important;
            padding: 20px 22px !important;
            box-sizing: border-box !important;
            transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease !important;
        }
        .fsPaymentCardItem:hover {
            border-color: #BFA16A !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 14px rgba(191, 161, 106, 0.12) !important;
        }
        .fsPaymentCardDotHeader {
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
            margin-bottom: 8px !important;
        }
        .fsPaymentCardDot {
            width: 12px !important;
            height: 12px !important;
            min-width: 12px !important;
            border-radius: 3px !important;
            display: inline-block !important;
        }
        .fsPaymentCardLabel {
            font-size: 14px !important;
            font-weight: 600 !important;
            color: #475569 !important;
        }
        .fsPaymentCardPercentage {
            font-size: 26px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            line-height: 1.15 !important;
            margin: 4px 0 6px 0 !important;
        }
        .fsPaymentCardNote {
            font-size: 13.5px !important;
            font-weight: 500 !important;
            color: #64748b !important;
            line-height: 1.35 !important;
        }
        /* Sheets / Images Section (Image 2) */
        .fsPaymentSheetsWrapper {
            margin-top: 24px !important;
            padding-top: 24px !important;
            border-top: 1px solid #edf2f7 !important;
        }
        .fsPaymentSheetsGrid {
            display: flex !important;
            gap: 14px !important;
            flex-wrap: wrap !important;
            align-items: stretch !important;
        }
        .fsPaymentSheetCard {
            width: 130px !important;
            max-width: 100% !important;
            height: 175px !important;
            border-radius: 12px !important;
            overflow: hidden !important;
            border: 1px solid #e2e8f0 !important;
            background: #f8fafc !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05) !important;
            cursor: pointer !important;
            transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
            position: relative !important;
        }
        .fsPaymentSheetCard:hover {
            transform: translateY(-4px) !important;
            box-shadow: 0 10px 24px rgba(0, 0, 0, 0.12) !important;
            border-color: #BFA16A !important;
        }
        .fsPaymentSheetCard img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: top center !important;
            display: block !important;
        }
        .fsPaymentSheetsPrompt {
            font-size: 13.5px !important;
            color: #64748b !important;
            margin-top: 14px !important;
            margin-bottom: 0 !important;
        }
        /* Fullscreen Lightbox Modal (Image 3) */
        .fsPaymentLightboxModal {
            position: fixed !important;
            inset: 0 !important;
            background: rgba(8, 16, 30, 0.94) !important;
            z-index: 9999999 !important;
            display: none;
            flex-direction: column !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 20px !important;
            box-sizing: border-box !important;
            backdrop-filter: blur(6px) !important;
        }
        .fsPaymentLightboxModal.is-open {
            display: flex !important;
            animation: fsLbFadeIn .2s ease-out;
        }
        @keyframes fsLbFadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .fsLightboxTopBar {
            width: 100% !important;
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            z-index: 10 !important;
        }
        .fsLightboxCounter {
            color: #ffffff !important;
            font-size: 15px !important;
            font-weight: 600 !important;
            letter-spacing: 0.5px !important;
        }
        .fsLightboxActions {
            display: flex !important;
            align-items: center !important;
            gap: 12px !important;
        }
        .fsLightboxBtn {
            width: 38px !important;
            height: 38px !important;
            border-radius: 50% !important;
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            font-size: 18px !important;
            transition: all .15s ease !important;
        }
        .fsLightboxBtn:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            transform: scale(1.05) !important;
        }
        .fsLightboxCloseBtn {
            width: 38px !important;
            height: 38px !important;
            border-radius: 50% !important;
            background: #ffffff !important;
            border: none !important;
            color: #0b1320 !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            font-size: 16px !important;
            font-weight: 700 !important;
            transition: all .15s ease !important;
        }
        .fsLightboxCloseBtn:hover {
            background: #BFA16A !important;
            color: #ffffff !important;
            transform: scale(1.05) !important;
        }
        .fsLightboxCenterStage {
            flex: 1 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            position: relative !important;
            overflow: hidden !important;
            padding: 10px !important;
            box-sizing: border-box !important;
        }
        .fsLightboxMainImg {
            max-width: 90vw !important;
            max-height: 74vh !important;
            object-fit: contain !important;
            border-radius: 6px !important;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.6) !important;
            transition: transform 0.2s ease !important;
            transform-origin: center center !important;
            user-select: none !important;
        }
        .fsLightboxNavBtn {
            position: absolute !important;
            top: 50% !important;
            transform: translateY(-50%) !important;
            width: 46px !important;
            height: 46px !important;
            border-radius: 50% !important;
            background: rgba(255, 255, 255, 0.12) !important;
            border: 1px solid rgba(255, 255, 255, 0.22) !important;
            color: #ffffff !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            cursor: pointer !important;
            z-index: 10 !important;
            transition: all .2s ease !important;
        }
        .fsLightboxNavBtn:hover {
            background: rgba(255, 255, 255, 0.25) !important;
            border-color: #BFA16A !important;
        }
        .fsLightboxPrev { left: 24px !important; }
        .fsLightboxNext { right: 24px !important; }
        .fsLightboxBottomStrip {
            display: flex !important;
            gap: 12px !important;
            align-items: center !important;
            justify-content: center !important;
            padding: 10px 0 !important;
            z-index: 10 !important;
            flex-wrap: wrap !important;
        }
        .fsLightboxThumbItem {
            width: 48px !important;
            height: 48px !important;
            border-radius: 6px !important;
            overflow: hidden !important;
            border: 2px solid rgba(255, 255, 255, 0.3) !important;
            cursor: pointer !important;
            opacity: 0.6 !important;
            transition: all .2s ease !important;
            background: #ffffff !important;
        }
        .fsLightboxThumbItem.is-active, .fsLightboxThumbItem:hover {
            opacity: 1 !important;
            border-color: #BFA16A !important;
            box-shadow: 0 0 10px rgba(191, 161, 106, 0.6) !important;
            transform: scale(1.05) !important;
        }
        .fsLightboxThumbItem img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            object-position: top !important;
            display: block !important;
        }
        @media (max-width: 768px) {
            .fsPaymentPlanCard { padding: 22px 20px 24px !important; }
            .fsPaymentPlanTitle { font-size: 20px !important; }
            .fsPaymentCardsGrid { grid-template-columns: 1fr !important; }
            .fsPaymentSheetCard { width: 120px !important; height: 160px !important; }
            .fsLightboxNavBtn { width: 38px !important; height: 38px !important; }
            .fsLightboxPrev { left: 10px !important; }
            .fsLightboxNext { right: 10px !important; }
        }
    </style>
        <div class="fsPaymentPlanCard">
            @if(!empty(trim((string)$payTitle)))
            <h2 class="fsPaymentPlanTitle">{{ $payTitle }}</h2>
            @endif
            @if(!empty(trim(strip_tags((string)$payDesc))))
                <div class="fsPaymentPlanSubtitle">{!! $payDesc !!}</div>
            @endif

            @if(!empty($breakdownItems))
                @php
                    $colorPalette = ['#0B2545', '#BFA16A', '#4B6B94', '#64748B', '#1E293B'];
                @endphp
                {{-- Breakdown cards grid --}}
                <div class="fsPaymentCardsGrid">
                    @foreach($breakdownItems as $bIdx => $bItem)
                        @php
                            $bColor = !empty($bItem['color']) ? $bItem['color'] : ($colorPalette[$bIdx % count($colorPalette)]);
                        @endphp
                        <div class="fsPaymentCardItem">
                            <div class="fsPaymentCardDotHeader">
                                <span class="fsPaymentCardDot" style="background: {{ $bColor }};"></span>
                                <span class="fsPaymentCardLabel">{{ $bItem['title'] ?? '' }}</span>
                            </div>
                            <div class="fsPaymentCardPercentage">{{ $bItem['percentage'] ?? '' }}</div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- 3. Payment Plan Sheet Images (Image 2) --}}
            @if(!empty($planImages))
                <div class="fsPaymentSheetsWrapper">
                    <div class="fsPaymentSheetsGrid">
                        @foreach($planImages as $imgIdx => $imgSrc)
                            @php
                                $resolvedSrc = str_starts_with($imgSrc, 'http') ? $imgSrc : asset(ltrim($imgSrc, '/'));
                            @endphp
                            <div class="fsPaymentSheetCard" onclick="openPaymentLightbox({{ $imgIdx }})" title="Click to view full size">
                                <img src="{{ $resolvedSrc }}" alt="Payment Plan {{ $imgIdx + 1 }}" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- 4. Fullscreen Lightbox Modal (Image 3) --}}
                <div id="fsPaymentLightbox" class="fsPaymentLightboxModal" onclick="if(event.target === this) closePaymentLightbox()">
                    <div class="fsLightboxTopBar">
                        <div class="fsLightboxCounter" id="fsLightboxCounter">1 / {{ count($planImages) }}</div>
                        <div class="fsLightboxActions">
                            <button type="button" class="fsLightboxBtn" onclick="zoomPaymentLightbox(0.25)" title="Zoom In">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </button>
                            <button type="button" class="fsLightboxBtn" onclick="zoomPaymentLightbox(-0.25)" title="Zoom Out">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            </button>
                            <button type="button" class="fsLightboxCloseBtn" onclick="closePaymentLightbox()" title="Close">✕</button>
                        </div>
                    </div>

                    @if(count($planImages) > 1)
                        <button type="button" class="fsLightboxNavBtn fsLightboxPrev" onclick="navigatePaymentLightbox(-1)" title="Previous">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        </button>
                        <button type="button" class="fsLightboxNavBtn fsLightboxNext" onclick="navigatePaymentLightbox(1)" title="Next">
                            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </button>
                    @endif

                    <div class="fsLightboxCenterStage" onclick="if(event.target === this) closePaymentLightbox()">
                        <img id="fsLightboxMainImg" class="fsLightboxMainImg" src="" alt="Payment Plan Full View">
                    </div>

                    @if(count($planImages) > 1)
                        <div class="fsLightboxBottomStrip">
                            @foreach($planImages as $tIdx => $tSrc)
                                @php
                                    $tResolved = str_starts_with($tSrc, 'http') ? $tSrc : asset(ltrim($tSrc, '/'));
                                @endphp
                                <div class="fsLightboxThumbItem" id="fsLbThumb_{{ $tIdx }}" onclick="switchPaymentLightboxIndex({{ $tIdx }})">
                                    <img src="{{ $tResolved }}" alt="thumb">
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <script>
                    (function() {
                        const planImages = {!! json_encode($resolvedPlanImages) !!};
                        let currentLbIndex = 0;
                        let currentZoom = 1;

                        window.openPaymentLightbox = function(idx) {
                            currentLbIndex = (idx >= 0 && idx < planImages.length) ? idx : 0;
                            currentZoom = 1;
                            updateLightboxView();
                            const modal = document.getElementById('fsPaymentLightbox');
                            if (modal) {
                                modal.classList.add('is-open');
                                document.body.style.overflow = 'hidden';
                            }
                        };

                        window.closePaymentLightbox = function() {
                            const modal = document.getElementById('fsPaymentLightbox');
                            if (modal) {
                                modal.classList.remove('is-open');
                                document.body.style.overflow = '';
                            }
                        };

                        window.navigatePaymentLightbox = function(delta) {
                            currentLbIndex = (currentLbIndex + delta + planImages.length) % planImages.length;
                            currentZoom = 1;
                            updateLightboxView();
                        };

                        window.switchPaymentLightboxIndex = function(idx) {
                            if (idx >= 0 && idx < planImages.length) {
                                currentLbIndex = idx;
                                currentZoom = 1;
                                updateLightboxView();
                            }
                        };

                        window.zoomPaymentLightbox = function(delta) {
                            currentZoom = Math.min(3.0, Math.max(0.75, currentZoom + delta));
                            const img = document.getElementById('fsLightboxMainImg');
                            if (img) img.style.transform = `scale(${currentZoom})`;
                        };

                        function updateLightboxView() {
                            const img = document.getElementById('fsLightboxMainImg');
                            const counter = document.getElementById('fsLightboxCounter');
                            if (img) {
                                img.src = planImages[currentLbIndex];
                                img.style.transform = `scale(${currentZoom})`;
                            }
                            if (counter) {
                                counter.textContent = `${currentLbIndex + 1} / ${planImages.length}`;
                            }
                            document.querySelectorAll('.fsLightboxThumbItem').forEach((el, i) => {
                                el.classList.toggle('is-active', i === currentLbIndex);
                            });
                        }

                        document.addEventListener('keydown', function(e) {
                            const modal = document.getElementById('fsPaymentLightbox');
                            if (!modal || !modal.classList.contains('is-open')) return;
                            if (e.key === 'Escape') closePaymentLightbox();
                            if (e.key === 'ArrowLeft') navigatePaymentLightbox(-1);
                            if (e.key === 'ArrowRight') navigatePaymentLightbox(1);
                        });
                    })();
                </script>
            @endif
        </div>
@if(!($embedded ?? false))
    </div>
</section>
@endif
@endif
