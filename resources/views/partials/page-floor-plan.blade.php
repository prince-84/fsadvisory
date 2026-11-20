@php
    $fpTitle    = page_section('floor_plan', 'title', '', $page->slug);
    $fpDesc     = page_section('floor_plan', 'description', '', $page->slug);

    // Floor plan sheet images
    $rawFpImages = page_section('floor_plan', 'plan_images', [], $page->slug);
    $fpImages = [];
    if (is_array($rawFpImages)) {
        foreach ($rawFpImages as $fpi) {
            $src = is_string($fpi) ? $fpi : ($fpi['image'] ?? ($fpi['src'] ?? ($fpi['url'] ?? '')));
            if (!empty(trim($src))) {
                $fpImages[] = trim($src);
            }
        }
    }

    $resolvedFpImages = array_values(array_map(function($s) {
        return str_starts_with($s, 'http') ? $s : asset(ltrim($s, '/'));
    }, $fpImages));
@endphp

@if(!empty($fpImages) || !empty(trim((string)$fpTitle)) || !empty(trim(strip_tags((string)$fpDesc))))
<style>
    .fsFpCard {
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        box-shadow: 0 4px 20px rgba(0,0,0,0.04) !important;
        padding: 32px 36px 36px !important;
        box-sizing: border-box !important;
    }
    .fsFpTitle {
        font-size: 24px !important;
        font-weight: 700 !important;
        color: #BFA16A !important;
        margin: 0 !important;
        line-height: 1.25 !important;
        letter-spacing: -0.01em !important;
    }
    .fsFpSubtitle {
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        font-size: 14.5px !important;
        color: #2b2b2b !important;
        margin: 6px 0 16px 0 !important;
        line-height: 1.6 !important;
        font-weight: 400 !important;
    }
    /* Sheet thumbnails grid */
    .fsFpSheetsWrapper {
        margin-top: 24px !important;
        padding-top: 24px !important;
        border-top: 1px solid #edf2f7 !important;
    }
    .fsFpSheetsGrid {
        display: flex !important;
        gap: 14px !important;
        flex-wrap: wrap !important;
        align-items: stretch !important;
    }
    .fsFpSheetCard {
        width: 130px !important;
        max-width: 100% !important;
        height: 175px !important;
        border-radius: 12px !important;
        overflow: hidden !important;
        border: 1px solid #e2e8f0 !important;
        background: #f8fafc !important;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05) !important;
        cursor: pointer !important;
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease !important;
        position: relative !important;
    }
    .fsFpSheetCard:hover {
        transform: translateY(-4px) !important;
        box-shadow: 0 10px 24px rgba(0,0,0,0.12) !important;
        border-color: #BFA16A !important;
    }
    .fsFpSheetCard img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover !important;
        object-position: top center !important;
        display: block !important;
    }
    /* Lightbox */
    .fsFpLightboxModal {
        position: fixed !important;
        inset: 0 !important;
        background: rgba(8,16,30,0.94) !important;
        z-index: 9999999 !important;
        display: none;
        flex-direction: column !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 20px !important;
        box-sizing: border-box !important;
        backdrop-filter: blur(6px) !important;
    }
    .fsFpLightboxModal.is-open {
        display: flex !important;
        animation: fsFpLbFadeIn .2s ease-out;
    }
    @keyframes fsFpLbFadeIn { from { opacity:0; } to { opacity:1; } }
    .fsFpLbTopBar { width:100% !important; display:flex !important; justify-content:space-between !important; align-items:center !important; z-index:10 !important; }
    .fsFpLbCounter { color:#fff !important; font-size:15px !important; font-weight:600 !important; letter-spacing:.5px !important; }
    .fsFpLbActions { display:flex !important; align-items:center !important; gap:12px !important; }
    .fsFpLbBtn { width:38px !important; height:38px !important; border-radius:50% !important; background:rgba(255,255,255,0.12) !important; border:1px solid rgba(255,255,255,0.2) !important; color:#fff !important; display:inline-flex !important; align-items:center !important; justify-content:center !important; cursor:pointer !important; font-size:18px !important; transition:all .15s ease !important; }
    .fsFpLbBtn:hover { background:rgba(255,255,255,0.25) !important; transform:scale(1.05) !important; }
    .fsFpLbCloseBtn { width:38px !important; height:38px !important; border-radius:50% !important; background:#fff !important; border:none !important; color:#0b1320 !important; display:inline-flex !important; align-items:center !important; justify-content:center !important; cursor:pointer !important; font-size:16px !important; font-weight:700 !important; transition:all .15s ease !important; }
    .fsFpLbCloseBtn:hover { background:#BFA16A !important; color:#fff !important; transform:scale(1.05) !important; }
    .fsFpLbCenterStage { flex:1 !important; display:flex !important; align-items:center !important; justify-content:center !important; width:100% !important; position:relative !important; overflow:hidden !important; padding:10px !important; box-sizing:border-box !important; }
    .fsFpLbMainImg { max-width:90vw !important; max-height:74vh !important; object-fit:contain !important; border-radius:6px !important; box-shadow:0 10px 40px rgba(0,0,0,0.6) !important; transition:transform 0.2s ease !important; transform-origin:center center !important; user-select:none !important; }
    .fsFpLbNavBtn { position:absolute !important; top:50% !important; transform:translateY(-50%) !important; width:46px !important; height:46px !important; border-radius:50% !important; background:rgba(255,255,255,0.12) !important; border:1px solid rgba(255,255,255,0.22) !important; color:#fff !important; display:flex !important; align-items:center !important; justify-content:center !important; cursor:pointer !important; z-index:10 !important; transition:all .2s ease !important; }
    .fsFpLbNavBtn:hover { background:rgba(255,255,255,0.25) !important; border-color:#BFA16A !important; }
    .fsFpLbPrev { left:24px !important; }
    .fsFpLbNext { right:24px !important; }
    .fsFpLbBottomStrip { display:flex !important; gap:12px !important; align-items:center !important; justify-content:center !important; padding:10px 0 !important; z-index:10 !important; flex-wrap:wrap !important; }
    .fsFpLbThumb { width:48px !important; height:48px !important; border-radius:6px !important; overflow:hidden !important; border:2px solid rgba(255,255,255,0.3) !important; cursor:pointer !important; opacity:.6 !important; transition:all .2s ease !important; }
    .fsFpLbThumb.is-active, .fsFpLbThumb:hover { opacity:1 !important; border-color:#BFA16A !important; box-shadow:0 0 10px rgba(191,161,106,0.6) !important; transform:scale(1.05) !important; }
    .fsFpLbThumb img { width:100% !important; height:100% !important; object-fit:cover !important; object-position:top !important; display:block !important; }
    @media(max-width:768px){
        .fsFpCard { padding:22px 20px 24px !important; }
        .fsFpTitle { font-size:20px !important; }
        .fsFpSheetCard { width:120px !important; height:160px !important; }
        .fsFpLbNavBtn { width:38px !important; height:38px !important; }
        .fsFpLbPrev { left:10px !important; }
        .fsFpLbNext { right:10px !important; }
    }
</style>

<div class="fsFpCard">
    @if(!empty(trim((string)$fpTitle)))
        <h2 class="fsFpTitle">{{ $fpTitle }}</h2>
    @endif

    @if(!empty(trim(strip_tags((string)$fpDesc))))
        <div class="fsFpSubtitle">{!! $fpDesc !!}</div>
    @endif

    @if(!empty($fpImages))
        <div class="fsFpSheetsWrapper">
            <div class="fsFpSheetsGrid">
                @foreach($fpImages as $fIdx => $fSrc)
                    @php $resolvedSrc = str_starts_with($fSrc, 'http') ? $fSrc : asset(ltrim($fSrc, '/')); @endphp
                    <div class="fsFpSheetCard" onclick="openFpLightbox({{ $fIdx }})" title="Click to view full size">
                        <img src="{{ $resolvedSrc }}" alt="Floor Plan {{ $fIdx + 1 }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Lightbox Modal --}}
        <div id="fsFpLightbox" class="fsFpLightboxModal" onclick="if(event.target===this) closeFpLightbox()">
            <div class="fsFpLbTopBar">
                <div class="fsFpLbCounter" id="fsFpLbCounter">1 / {{ count($fpImages) }}</div>
                <div class="fsFpLbActions">
                    <button type="button" class="fsFpLbBtn" onclick="zoomFpLightbox(0.25)" title="Zoom In">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <button type="button" class="fsFpLbBtn" onclick="zoomFpLightbox(-0.25)" title="Zoom Out">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    </button>
                    <button type="button" class="fsFpLbCloseBtn" onclick="closeFpLightbox()" title="Close">✕</button>
                </div>
            </div>

            @if(count($fpImages) > 1)
                <button type="button" class="fsFpLbNavBtn fsFpLbPrev" onclick="navigateFpLightbox(-1)" title="Previous">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                </button>
                <button type="button" class="fsFpLbNavBtn fsFpLbNext" onclick="navigateFpLightbox(1)" title="Next">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            @endif

            <div class="fsFpLbCenterStage" onclick="if(event.target===this) closeFpLightbox()">
                <img id="fsFpLbMainImg" class="fsFpLbMainImg" src="" alt="Floor Plan Full View">
            </div>

            @if(count($fpImages) > 1)
                <div class="fsFpLbBottomStrip">
                    @foreach($fpImages as $tIdx => $tSrc)
                        @php $tResolved = str_starts_with($tSrc, 'http') ? $tSrc : asset(ltrim($tSrc, '/')); @endphp
                        <div class="fsFpLbThumb" id="fsFpLbThumb_{{ $tIdx }}" onclick="switchFpLightboxIndex({{ $tIdx }})">
                            <img src="{{ $tResolved }}" alt="thumb">
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <script>
        (function(){
            const fpImages = {!! json_encode($resolvedFpImages) !!};
            let curIdx = 0, curZoom = 1;

            window.openFpLightbox = function(idx) {
                curIdx = (idx >= 0 && idx < fpImages.length) ? idx : 0;
                curZoom = 1;
                updateFpLbView();
                document.getElementById('fsFpLightbox').classList.add('is-open');
                document.body.style.overflow = 'hidden';
            };
            window.closeFpLightbox = function() {
                document.getElementById('fsFpLightbox').classList.remove('is-open');
                document.body.style.overflow = '';
            };
            window.navigateFpLightbox = function(delta) {
                curIdx = (curIdx + delta + fpImages.length) % fpImages.length;
                curZoom = 1;
                updateFpLbView();
            };
            window.switchFpLightboxIndex = function(idx) {
                if (idx >= 0 && idx < fpImages.length) { curIdx = idx; curZoom = 1; updateFpLbView(); }
            };
            window.zoomFpLightbox = function(delta) {
                curZoom = Math.min(3, Math.max(0.5, curZoom + delta));
                const img = document.getElementById('fsFpLbMainImg');
                if (img) img.style.transform = `scale(${curZoom})`;
            };
            function updateFpLbView() {
                const img = document.getElementById('fsFpLbMainImg');
                const counter = document.getElementById('fsFpLbCounter');
                if (img) { img.src = fpImages[curIdx]; img.style.transform = `scale(${curZoom})`; }
                if (counter) counter.textContent = `${curIdx + 1} / ${fpImages.length}`;
                document.querySelectorAll('.fsFpLbThumb').forEach((el, i) => {
                    el.classList.toggle('is-active', i === curIdx);
                });
            }
            document.addEventListener('keydown', function(e) {
                const lb = document.getElementById('fsFpLightbox');
                if (!lb || !lb.classList.contains('is-open')) return;
                if (e.key === 'Escape') closeFpLightbox();
                if (e.key === 'ArrowLeft') navigateFpLightbox(-1);
                if (e.key === 'ArrowRight') navigateFpLightbox(1);
            });
        })();
        </script>
    @endif
</div>
@endif

