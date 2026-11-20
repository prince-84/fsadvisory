@php
    $__p = $proj;
    $__rawSlug = $__p->slug ?: ($__p->page?->slug ?? '');
    $__cleanSlug = ltrim(preg_replace('#^project/#', '', ltrim($__rawSlug, '/')), '/');
    $__full = $__cleanSlug ? ('https://fsadvisory.pk/project/' . $__cleanSlug) : 'https://fsadvisory.pk';
    $__wa = 'https://wa.me/923322495575?text=' . rawurlencode("Hello FS Advisory, I am interested in {$__p->title}. Please share details.\n{$__full}");
@endphp
<div class="cardBtnRow">
    <a href="{{ $href }}" class="cardBookBtn" onclick="event.stopPropagation()">Details</a>
    <a href="{{ $__wa }}" target="_blank" rel="noopener" class="cardBookBtn cardWaBtn" onclick="event.stopPropagation()">WhatsApp</a>
</div>
@once
<style>
.cardCustom { position: relative; }
.cardCustom .cardBtnRow { display: flex; gap: 10px; width: 100%; margin-top: 10px; position: relative; z-index: 10; }
.cardCustom .cardBtnRow .cardBookBtn {
    flex: 1 1 0; width: auto; margin-top: 0; padding: 11px 10px; text-decoration: none;
    cursor: pointer; font-size: 12.5px; position: relative; z-index: 10; pointer-events: auto;
}
.cardCustom .cardBtnRow .cardWaBtn { background: transparent !important; color: #ffffff !important; border: 1.5px solid #BFA16A !important; box-shadow: none !important; }
.cardCustom .cardBtnRow .cardWaBtn:hover { background: #BFA16A !important; color: #ffffff !important; }
.cardCustom .cardBtnRow .cardBookBtn:not(.cardWaBtn):hover { background: #aa8d58 !important; }
@media (max-width: 400px) { .cardCustom .cardBtnRow .cardBookBtn { font-size: 11.5px; letter-spacing: 0.4px; } }
</style>
@endonce

