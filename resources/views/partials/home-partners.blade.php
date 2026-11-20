@php
    $partnerLogos = [
        '1794601998_logo_images-1.svg',
        '1794604532_logo_images-4.svg',
        '1794605094_logo_images-1-1.svg',
        'images (1).svg',
        'images (1) (1).svg',
    ];
@endphp
<!-- Home Page Static Partners Section -->
<section class="homePartners" aria-label="Our Partners">
    <style>
        .homePartners { background: #ffffff; padding: 60px 0 64px 0; }
        .homePartners .hpWrap { max-width: 1200px; margin: 0 auto; padding: 0 24px; }
        .homePartners .hpHead { text-align: center; margin-bottom: 34px; }
        .homePartners .hpHead h2 {
            font-size: clamp(24px, 3.4vw, 34px); font-weight: 700; color: #BFA16A; margin: 0;
            display: inline-flex; align-items: center; gap: 14px;
        }
        .homePartners .hpHead h2::before,
        .homePartners .hpHead h2::after { content: ""; width: 40px; height: 2px; background: #BFA16A; }
        .homePartners .hpGrid {
            display: grid; grid-template-columns: repeat(5, 1fr); gap: 18px; align-items: stretch;
        }
        .homePartners .hpCard {
            background: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px;
            height: 110px; padding: 18px; display: flex; align-items: center; justify-content: center;
            transition: border-color .25s ease, box-shadow .25s ease, transform .25s ease;
        }
        .homePartners .hpCard:hover {
            border-color: #BFA16A; box-shadow: 0 6px 18px rgba(191,161,106,.2); transform: translateY(-3px);
        }
        .homePartners .hpCard img { max-width: 100%; max-height: 100%; object-fit: contain; display: block; }
        @media (max-width: 991px) { .homePartners .hpGrid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 600px) {
            .homePartners { padding: 44px 0 46px 0; }
            .homePartners .hpWrap { padding: 0 14px; }
            .homePartners .hpGrid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
            .homePartners .hpGrid .hpCard:last-child { grid-column: 1 / -1; max-width: calc(50% - 6px); margin: 0 auto; width: 100%; }
            .homePartners .hpCard { height: 90px; padding: 12px; }
            .homePartners .hpHead h2::before, .homePartners .hpHead h2::after { width: 22px; }
        }
    </style>
    <div class="hpWrap">
        <div class="hpHead"><h2>Our Partners</h2></div>
        <div class="hpGrid">
            @foreach($partnerLogos as $i => $logo)
                <div class="hpCard">
                    <img src="{{ asset(rawurlencode($logo)) }}" alt="Partner {{ $i + 1 }} logo" loading="lazy">
                </div>
            @endforeach
        </div>
    </div>
</section>

