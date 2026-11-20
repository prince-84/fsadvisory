@php
$faqsDefault = [
    [
        'q' => "What is Saima Builders and Developers?",
        'a' => "Saima Builders and Developers is a premier residential and commercial real estate development group in Pakistan, delivering quality residential communities, modern luxury apartments, townhouses, and high-yield commercial projects across Karachi.",
    ],
    [
        'q' => "Where are Saima Builders and Developers projects located?",
        'a' => "Saima projects are situated across prime urban destinations in Karachi, including North Nazimabad, Scheme 33, Gulshan-e-Iqbal, Gulistan-e-Johar, Gadap Town, DHA, and along major corridors like Main Shahrah-e-Faisal and Memon Goth Road.",
    ],
    [
        'q' => "What types of properties does Saima Builders offer?",
        'a' => "Saima provides a diverse portfolio spanning 2, 3, 4, and 5-room luxury apartments, independent executive villas, residential plots (120, 175, 240 Sq. Yds.), and prime commercial retail showrooms and corporate office spaces.",
    ],
    [
        'q' => "Are Saima Builders apartments available for sale in Karachi?",
        'a' => "Yes, multiple ready-to-move and off-plan residential apartment developments are actively available with flexible construction-linked payment plans.",
    ],
    [
        'q' => "What are the prices of Saima Builders properties?",
        'a' => "Prices vary depending on the project location, category, and unit layout, starting with convenient initial booking deposits and easy monthly installments spanning 36 to 48 months.",
    ],
    [
        'q' => "Does Saima Builders offer flexible payment plans?",
        'a' => "Yes, all major projects feature easy 3-year to 4-year installment structures designed to accommodate buyers, families, and long-term property investors.",
    ],
    [
        'q' => "Does Saima Builders have new upcoming projects in Karachi?",
        'a' => "Yes, new residential plotted communities, luxury high-rises, and prime commercial centers are regularly announced across high-demand growth sectors in Karachi.",
    ],
];

$pageSlug = isset($slug) ? $slug : (isset($page) && $page instanceof \App\Models\Page ? $page->slug : null);
$rawFaqs = $customFaqs ?? page_section('faq', 'items', null, $pageSlug);
$faqHeading = $customHeading ?? page_section('faq', 'heading', page_section('faq', 'title', 'Frequently Asked Questions', $pageSlug), $pageSlug);
$faqSub = $customSubtitle ?? page_section('faq', 'subtitle', page_section('faq', 'description', '', $pageSlug), $pageSlug);

$dbFaqs = [];
if (is_array($rawFaqs)) {
    foreach ($rawFaqs as $f) {
        $q = trim((string)($f['question'] ?? ($f['q'] ?? '')));
        $a = trim((string)($f['answer'] ?? ($f['a'] ?? '')));
        if ($q !== '' || $a !== '') {
            $dbFaqs[] = ['q' => $q, 'a' => $a];
        }
    }
}

if (empty($dbFaqs) && ($pageSlug === null || $pageSlug === '/' || $pageSlug === 'home')) {
    $dbFaqs = $faqsDefault;
}

$faqUniq = 'faq_' . substr(md5($faqHeading . $pageSlug), 0, 8);
@endphp

@if(!empty($dbFaqs))
<section id="faq" aria-label="{{ $faqHeading }}" class="faqSection">
    <div class="container">
        <div class="section-header">
            <h2>{{ $faqHeading }}</h2>
            @if(!empty(trim((string)$faqSub)))
                {!! str_contains($faqSub, '<p') ? $faqSub : '<p>' . e($faqSub) . '</p>' !!}
            @endif
        </div>

        <style>
            /* Universal FAQ Section Styling (Standardized across Homepage, Project Details & Developer Pages) */
            .faqSection {
                padding: 60px 0 70px 0 !important;
                background: #ffffff !important;
            }
            .faqSection .faqContainer {
                max-width: 900px !important;
                margin: 0 auto !important;
                padding: 0 16px !important;
            }
            .faqSection .faqList {
                display: flex !important;
                flex-direction: column !important;
                gap: 12px !important;
            }
            .faqSection .faqItem {
                background: #ffffff !important;
                border: 1px solid #e5e7eb !important;
                border-radius: 8px !important;
                overflow: hidden !important;
                transition: border-color 0.25s ease, box-shadow 0.25s ease !important;
                margin-bottom: 0 !important;
            }
            .faqSection .faqItem:hover {
                border-color: #d1d5db !important;
            }
            /* When Open: Light Brand Gold Border and soft glow */
            .faqSection .faqItem.faqItemOpen,
            .faqSection .faqItemOpen {
                border-color: #BFA16A !important;
                box-shadow: 0 4px 18px rgba(191, 161, 106, 0.16) !important;
            }
            .faqSection .faqQuestion,
            .faqSection button.faqQuestion {
                width: 100% !important;
                display: flex !important;
                align-items: center !important;
                justify-content: space-between !important;
                padding: 18px 24px !important;
                background: transparent !important;
                background-color: transparent !important;
                border: none !important;
                box-shadow: none !important;
                transform: none !important;
                text-align: left !important;
                font-size: 16.5px !important;
                font-weight: 600 !important;
                color: #1a1a1a !important;
                cursor: pointer !important;
                transition: color 0.2s ease !important;
            }
            .faqSection .faqQuestion:hover,
            .faqSection button.faqQuestion:hover {
                background: transparent !important;
                background-color: transparent !important;
                color: #BFA16A !important;
                box-shadow: none !important;
                transform: none !important;
            }
            .faqSection .faqItemOpen .faqQuestion,
            .faqSection .faqItemOpen button.faqQuestion {
                color: #BFA16A !important;
                background: transparent !important;
                background-color: transparent !important;
            }
            .faqSection .faqIcon {
                display: flex !important;
                align-items: center !important;
                justify-content: center !important;
                width: 28px !important;
                height: 28px !important;
                border-radius: 50% !important;
                background: #f3f4f6 !important;
                color: #555555 !important;
                flex-shrink: 0 !important;
                margin-left: 16px !important;
                transition: all 0.25s ease !important;
            }
            .faqSection .faqIcon svg {
                stroke: #555555 !important;
                transition: stroke 0.25s ease !important;
            }
            .faqSection .faqQuestion:hover .faqIcon {
                background: rgba(191, 161, 106, 0.15) !important;
                color: #BFA16A !important;
            }
            .faqSection .faqQuestion:hover .faqIcon svg {
                stroke: #BFA16A !important;
            }
            .faqSection .faqItemOpen .faqIcon {
                background: #BFA16A !important;
                color: #ffffff !important;
                transform: rotate(45deg) !important;
            }
            .faqSection .faqItemOpen .faqIcon svg {
                stroke: #ffffff !important;
            }
            .faqSection .faqAnswer {
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.35s cubic-bezier(0, 1, 0, 1);
            }
            .faqSection .faqAnswer.faqAnswerOpen,
            .faqSection .faqAnswerOpen {
                max-height: 800px !important;
                border-top: 1px solid rgba(191, 161, 106, 0.15) !important;
                transition: max-height 0.35s cubic-bezier(1, 0, 1, 0) !important;
            }
            .faqSection .faqAnswerText {
                padding: 16px 24px 20px 24px !important;
                color: #555555 !important;
                font-size: 15px !important;
                line-height: 1.7 !important;
                margin: 0 !important;
            }

            /* Responsive Mobile View: Adjusted Heading, Dashes & Font Proportions */
            @media (max-width: 768px) {
                .faqSection {
                    padding: 45px 0 55px 0 !important;
                }
                .section-header {
                    padding-bottom: 22px !important;
                }
                .section-header h2 {
                    font-size: clamp(19px, 5.2vw, 26px) !important;
                    line-height: 1.25 !important;
                    display: inline-flex !important;
                    align-items: center !important;
                    justify-content: center !important;
                    flex-wrap: nowrap !important;
                    gap: 8px !important;
                    max-width: 100% !important;
                    white-space: nowrap !important;
                    margin-bottom: 10px !important;
                }
                .section-header h2::before,
                .section-header h2::after {
                    content: "" !important;
                    width: 20px !important;
                    height: 2px !important;
                    background: #BFA16A !important;
                    display: inline-block !important;
                    flex-shrink: 0 !important;
                    margin: 0 !important;
                }
                .section-header p {
                    font-size: 14px !important;
                    padding: 0 10px !important;
                }
                .faqSection .faqQuestion,
                .faqSection button.faqQuestion {
                    padding: 15px 18px !important;
                    font-size: 15px !important;
                }
                .faqSection .faqAnswerText {
                    padding: 14px 18px 18px 18px !important;
                    font-size: 14px !important;
                }
                .faqSection .faqIcon {
                    width: 26px !important;
                    height: 26px !important;
                    margin-left: 10px !important;
                }
            }

            @media (max-width: 420px) {
                .section-header h2 {
                    font-size: clamp(16px, 4.8vw, 19px) !important;
                    gap: 6px !important;
                }
                .section-header h2::before,
                .section-header h2::after {
                    width: 14px !important;
                }
            }
        </style>

        <div class="faqContainer">
            <div class="faqList">
                @foreach($dbFaqs as $index => $faq)
                    <div class="faqItem {{ $index === 0 ? 'faqItemOpen' : '' }}" id="{{ $faqUniq }}-item-{{ $index }}">
                        <button type="button" class="faqQuestion" onclick="toggleUniversalFaq(this, event)" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                            <span>{{ $faq['q'] ?? $faq['question'] ?? '' }}</span>
                            <span class="faqIcon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </span>
                        </button>
                        <div class="faqAnswer {{ $index === 0 ? 'faqAnswerOpen' : '' }}" id="{{ $faqUniq }}-ans-{{ $index }}">
                            <p class="faqAnswerText">{!! $faq['a'] ?? $faq['answer'] ?? '' !!}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    if (typeof window.toggleUniversalFaq !== 'function') {
        window.toggleUniversalFaq = function(btn, e) {
            if (e) {
                e.preventDefault();
                e.stopPropagation();
            }
            const item = btn.closest('.faqItem');
            if (!item) return;
            const answer = item.querySelector('.faqAnswer');
            if (!answer) return;
            const isOpen = item.classList.contains('faqItemOpen');

            answer.style.removeProperty('display');

            if (isOpen) {
                item.classList.remove('faqItemOpen');
                answer.classList.remove('faqAnswerOpen');
                btn.setAttribute('aria-expanded', 'false');
            } else {
                item.classList.add('faqItemOpen');
                answer.classList.add('faqAnswerOpen');
                btn.setAttribute('aria-expanded', 'true');
            }
        };
    }
    // Backward compatibility with legacy index toggle
    if (typeof window.toggleFaq !== 'function') {
        window.toggleFaq = function(index, e) {
            const item = document.getElementById('faqItem-' + index);
            if (item) {
                const btn = item.querySelector('.faqQuestion');
                if (btn) window.toggleUniversalFaq(btn, e);
            }
        };
    }
</script>
@endif
