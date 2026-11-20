@php
    $heroBgImg = page_section('hero', 'bg_image', '', $page->slug);
    if (empty($heroBgImg) || $heroBgImg === '/hero.png') {
        $heroBgImg = !empty($project?->image) ? $project->image : '/images/hero/slide-1.jpg';
    }
    $heroBgUrl = (str_starts_with($heroBgImg, 'http') || str_starts_with($heroBgImg, '/')) ? $heroBgImg : asset($heroBgImg);
    $heroTitleRaw = page_section('hero', 'title', $page->title, $page->slug);
    $heroTitleClean = trim(preg_replace('/\s+/', ' ', strip_tags((string)$heroTitleRaw)));
    $heroSubtitle = page_section('hero', 'subtitle', '', $page->slug);
    $heroBadge = page_section('hero', 'badge', '', $page->slug);

    $projectTitle = $project?->title ?: ($page?->title ?: 'this project');
    $heroCurrentPath = ltrim(request()->path(), '/');
    $currentUrl = $heroCurrentPath ? ('https://fsadvisory.pk/' . $heroCurrentPath) : 'https://fsadvisory.pk';
    $waMessage = "Hello FS Advisory, I am interested in {$projectTitle}. Please share details.\n{$currentUrl}";
    $waUrl = 'https://wa.me/923322495575?text=' . rawurlencode($waMessage);

    // Title Splitting for Image 1 Parity (Line 1 dark #111827, Line 2 gold #BFA16A)
    $fullTitle = trim((string)$heroTitleClean);
    $pTitle = $project?->title ? trim((string)$project->title) : '';
    if (!empty($pTitle) && str_starts_with(strtolower($fullTitle), strtolower($pTitle)) && strlen($fullTitle) > strlen($pTitle)) {
        $line1 = substr($fullTitle, 0, strlen($pTitle));
        $line2 = trim(substr($fullTitle, strlen($pTitle)));
    } else {
        $rawLines = preg_split('/\r\n|\r|\n/', trim((string)$heroTitleRaw));
        if (count($rawLines) > 1) {
            $line1 = $rawLines[0];
            $line2 = implode(' ', array_slice($rawLines, 1));
        } else {
            $words = explode(' ', $fullTitle);
            if (count($words) >= 4) {
                $mid = ceil(count($words) / 2);
                $line1 = implode(' ', array_slice($words, 0, $mid));
                $line2 = implode(' ', array_slice($words, $mid));
            } else {
                $line1 = $fullTitle;
                $line2 = '';
            }
        }
    }
@endphp

<section id="hero" class="fsProjectHeroSection">
    <!-- Background image on right with half-white fade overlay on left (Image 1 Parity) -->
    <div class="fsProjectHeroBg" style="background-image: url('{{ $heroBgUrl }}');"></div>
    <div class="fsProjectHeroOverlay"></div>

    <div class="container fsProjectHeroContainer">
        <div class="fsProjectHeroContent">
            @if(!empty(trim((string)$heroBadge)))
                <div class="fsProjectHeroBadge">
                    <span>{{ $heroBadge }}</span>
                </div>
            @endif

            <!-- Title strictly brand golden #BFA16A -->
            <h1 class="fsProjectHeroTitle">
                <span class="fsHeroTitleGold">{{ $line1 }}</span>
                @if(!empty($line2))
                    <span class="fsHeroTitleGold">{{ $line2 }}</span>
                @endif
            </h1>

            @if(!empty(trim((string)$heroSubtitle)))
                <p class="fsProjectHeroSubtitle">
                    {{ $heroSubtitle }}
                </p>
            @endif

            <!-- Two Action Buttons (Image 1 & Image 2 Parity) -->
            <div class="fsProjectHeroBtnRow">
                <!-- Button 1: Book Consultation (Opens Modal Popup) -->
                <button type="button" class="fsHeroBookBtn" onclick="openHeroConsultModal();">
                    BOOK CONSULTATION
                </button>

                <!-- Button 2: WhatsApp (White with outline, on hover turns GOLDEN #BFA16A) -->
                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="fsHeroWaBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.316 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.818-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>WHATSAPP</span>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Modal Popup Form with Universal Phone Flag Dropdown (Image 1 & Image 2 Parity) -->
<div id="fsHeroConsultModal" class="fsHeroModalOverlay" onclick="if(event.target === this) closeHeroConsultModal();">
    <div class="fsHeroModalBox">
        <button type="button" class="fsHeroModalCloseBtn" onclick="closeHeroConsultModal();" aria-label="Close dialog">&times;</button>
        
        <div class="fsHeroModalHeader">
            <span class="fsHeroModalKicker">REQUEST A CALL BACK</span>
            <h3 class="fsHeroModalTitle">BOOK CONSULTATION</h3>
            <p class="fsHeroModalSub">Leave your contact details and our senior property advisor will reach out to you shortly.</p>
        </div>

        <form id="fsHeroConsultForm" onsubmit="handleHeroConsultSubmit(event);">
            @csrf
            <input type="hidden" name="project" value="{{ $projectTitle }}">
            <input type="hidden" name="page_url" value="{{ $currentUrl }}">

            <!-- 1. Full Name -->
            <div class="fsHeroModalField">
                <input type="text" name="name" class="fsHeroModalInput" placeholder="Full Name *" required>
            </div>

            <!-- 2. E-mail -->
            <div class="fsHeroModalField">
                <input type="email" name="email" class="fsHeroModalInput" placeholder="E-mail *" required>
            </div>

            <!-- 3. Phone Number with Universal Flag Selector (Exact Other Forms Parity) -->
            <div class="fsHeroModalField">
                <div class="phoneUnifiedContainer" style="margin-bottom: 0; height: 44px !important; background: #ffffff !important; border: 1px solid #dcdcdc !important; border-radius: 6px !important; display: flex; align-items: center; box-sizing: border-box; width: 100%;">
                    <div class="countryTriggerWrapper" style="position: relative; height: 100%; display: flex; align-items: center;">
                        <button type="button" class="countryTriggerBtn" id="heroModalCountryBtn" aria-label="Country selector" style="height: 100%; border: none; background: transparent; padding: 0 10px; display: flex; align-items: center; gap: 5px; cursor: pointer;">
                            <span class="flagSlot" id="heroModalFlagSlot">
                                <svg width="22" height="15" viewBox="0 0 24 16" class="flagSvg">
                                    <rect width="24" height="5.33" fill="#00732f"/>
                                    <rect y="5.33" width="24" height="5.33" fill="#ffffff"/>
                                    <rect y="10.66" width="24" height="5.34" fill="#000000"/>
                                    <rect width="6" height="16" fill="#fe0000"/>
                                </svg>
                            </span>
                            <span class="caretDown" style="border-left: 4px solid transparent; border-right: 4px solid transparent; border-top: 5px solid #555; display: inline-block;"></span>
                        </button>
                        <ul class="countryDropdownMenu" id="heroModalCountryDropdown" style="display: none;"></ul>
                    </div>
                    <input type="tel" name="phone" id="heroModalPhoneInput" class="phoneInputField" value="+971 " required style="flex: 1; height: 100%; border: none; padding: 0 12px; font-size: 14px; outline: none; background: transparent; color: #1e293b; width: 100%; box-sizing: border-box;">
                </div>
            </div>

            <button type="submit" id="fsHeroModalSubmitBtn" class="fsHeroModalSubmitBtn">
                REQUEST NOW
            </button>

            <!-- Success Notification -->
            <div id="fsHeroModalSuccess" class="fsHeroModalSuccessMsg" style="display: none;">
                ✓ Thank you! Your consultation request has been received. Our property specialist will contact you shortly.
            </div>
        </form>
    </div>
</div>

<style>
/* Hero Section: Half White / Half Image Layout (Image 1 Parity) */
.fsProjectHeroSection {
    position: relative;
    min-height: 540px;
    display: flex;
    align-items: center;
    background-color: #ffffff;
    overflow: hidden;
    padding: 100px 0 90px;
    box-sizing: border-box;
}
.fsProjectHeroBg {
    position: absolute;
    inset: 0;
    background-size: cover;
    background-position: center right;
    background-repeat: no-repeat;
    z-index: 1;
}
.fsProjectHeroOverlay {
    position: absolute;
    inset: 0;
    /* Smooth half-white on left to reveal building image on right */
    background: linear-gradient(90deg, #FFFFFF 0%, #FFFFFF 36%, rgba(255, 255, 255, 0.96) 48%, rgba(255, 255, 255, 0.45) 66%, rgba(255, 255, 255, 0) 84%);
    z-index: 2;
}
.fsProjectHeroContainer {
    position: relative;
    z-index: 3;
    max-width: 1440px;
    padding: 0 40px;
    width: 100%;
    box-sizing: border-box;
}
.fsProjectHeroContent {
    max-width: 660px;
}
.fsProjectHeroBadge {
    display: inline-block;
    background: rgba(191, 161, 106, 0.12);
    border: 1px solid #BFA16A;
    color: #BFA16A;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    padding: 6px 14px;
    border-radius: 4px;
    margin-bottom: 18px;
}
.fsProjectHeroTitle {
    font-family: 'Playfair Display', Georgia, 'Times New Roman', serif;
    font-size: 42px;
    font-weight: 700;
    line-height: 1.25;
    margin: 0 0 16px 0;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.fsHeroTitleDark,
.fsHeroTitleGold {
    display: block;
    color: #BFA16A !important;
    text-shadow: none;
    margin-top: 4px;
}
.fsProjectHeroSubtitle {
    font-size: 15px;
    font-weight: 400;
    color: #475569 !important;
    line-height: 1.65;
    margin: 0 0 32px 0;
    max-width: 580px;
    text-shadow: none;
}

/* Two Action Buttons Row */
.fsProjectHeroBtnRow {
    display: flex;
    flex-direction: row;
    align-items: center;
    gap: 16px;
}
.fsHeroBookBtn {
    background: #BFA16A !important;
    color: #ffffff !important;
    border: 1.5px solid #BFA16A !important;
    border-radius: 8px !important;
    padding: 14px 32px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    letter-spacing: 0.8px !important;
    text-transform: uppercase !important;
    cursor: pointer !important;
    transition: all 0.25s ease !important;
    box-shadow: 0 4px 14px rgba(191, 161, 106, 0.35) !important;
    outline: none !important;
    white-space: nowrap !important;
}
.fsHeroBookBtn:hover {
    background: #a8884d !important;
    border-color: #a8884d !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 18px rgba(191, 161, 106, 0.45) !important;
}
.fsHeroWaBtn {
    background: #ffffff !important;
    color: #1e293b !important;
    border: 1.5px solid #d1d5db !important;
    border-radius: 8px !important;
    padding: 14px 32px !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    letter-spacing: 0.8px !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    cursor: pointer !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 8px !important;
    transition: all 0.25s ease !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06) !important;
    white-space: nowrap !important;
}
.fsHeroWaBtn svg {
    color: #25D366 !important;
    fill: #25D366 !important;
    transition: all 0.2s ease !important;
}
/* USER REQUIREMENT 1: WhatsApp button hover is GOLDEN, NOT green */
.fsHeroWaBtn:hover {
    background: #BFA16A !important;
    color: #ffffff !important;
    border-color: #BFA16A !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(191, 161, 106, 0.4) !important;
}
.fsHeroWaBtn:hover svg {
    color: #ffffff !important;
    fill: #ffffff !important;
    transform: scale(1.08) !important;
}

/* Mobile Responsiveness (Image 3 Parity & Seamless White Merge) */
@media (max-width: 768px) {
    .fsProjectHeroSection {
        min-height: 440px !important;
        padding: 50px 0 50px !important;
        margin-top: 0 !important;
        border-top: none !important;
    }
    .fsProjectHeroOverlay {
        /* Pure 100% Solid White at top so it seamlessly joins navbar with zero blue line */
        background: linear-gradient(180deg, #FFFFFF 0%, #FFFFFF 25%, rgba(255, 255, 255, 0.96) 55%, rgba(255, 255, 255, 0.82) 100%) !important;
    }
    .fsProjectHeroContainer {
        padding: 0 20px !important;
    }
    .fsProjectHeroTitle {
        font-size: 28px !important;
        margin-bottom: 12px !important;
    }
    .fsProjectHeroSubtitle {
        font-size: 14px !important;
        margin-bottom: 24px !important;
    }
    .fsProjectHeroBtnRow {
        flex-direction: column !important;
        width: 100% !important;
        gap: 12px !important;
    }
    .fsHeroBookBtn,
    .fsHeroWaBtn {
        width: 100% !important;
        box-sizing: border-box !important;
        justify-content: center !important;
        text-align: center !important;
        padding: 14px 20px !important;
    }
}

/* Modal Popup Styles */
.fsHeroModalOverlay {
    position: fixed;
    inset: 0;
    background: rgba(0, 0, 0, 0.72);
    backdrop-filter: blur(4px);
    z-index: 999999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    box-sizing: border-box;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.25s ease;
}
.fsHeroModalOverlay.is-open {
    opacity: 1;
    pointer-events: auto;
}
.fsHeroModalBox {
    background: #ffffff;
    width: 100%;
    max-width: 440px;
    border-radius: 12px;
    padding: 32px 28px;
    box-sizing: border-box;
    position: relative;
    box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35);
    transform: translateY(20px);
    transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}
.fsHeroModalOverlay.is-open .fsHeroModalBox {
    transform: translateY(0);
}
.fsHeroModalCloseBtn {
    position: absolute;
    top: 14px;
    right: 14px;
    width: 32px;
    height: 32px;
    border: none;
    background: #f1f5f9;
    color: #475569;
    border-radius: 50%;
    font-size: 22px;
    line-height: 1;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.15s ease;
}
.fsHeroModalCloseBtn:hover {
    background: #e2e8f0;
    color: #0f172a;
}
.fsHeroModalHeader {
    margin-bottom: 20px;
}
.fsHeroModalKicker {
    display: block;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: #BFA16A;
    text-transform: uppercase;
    margin-bottom: 4px;
}
.fsHeroModalTitle {
    font-size: 20px;
    font-weight: 800;
    color: #0c2340;
    margin: 0 0 6px 0;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
.fsHeroModalSub {
    font-size: 13px;
    color: #64748b;
    margin: 0;
    line-height: 1.5;
}
.fsHeroModalField {
    margin-bottom: 12px;
}
.fsHeroModalInput {
    width: 100%;
    height: 44px;
    padding: 0 14px;
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    font-size: 14px;
    color: #1e293b;
    box-sizing: border-box;
    outline: none;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    background: #ffffff;
}
.fsHeroModalInput:focus,
.phoneUnifiedContainer:focus-within {
    border-color: #BFA16A !important;
    box-shadow: 0 0 0 3px rgba(191, 161, 106, 0.18) !important;
}
.fsHeroModalSubmitBtn {
    width: 100%;
    height: 46px;
    background: #BFA16A;
    color: #ffffff;
    font-size: 14px;
    font-weight: 700;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    letter-spacing: 0.8px;
    text-transform: uppercase;
    transition: all 0.2s ease;
    margin-top: 6px;
    box-shadow: 0 4px 12px rgba(191, 161, 106, 0.3);
}
.fsHeroModalSubmitBtn:hover {
    background: #a8884d;
    box-shadow: 0 6px 16px rgba(191, 161, 106, 0.45);
}
.fsHeroModalSuccessMsg {
    margin-top: 14px;
    padding: 12px;
    background: #f0fdf4;
    border: 1px solid #86efac;
    border-radius: 6px;
    color: #166534;
    font-size: 13px;
    text-align: center;
    font-weight: 600;
    line-height: 1.4;
}
</style>

<script>
function openHeroConsultModal() {
    const modal = document.getElementById('fsHeroConsultModal');
    if (modal) {
        modal.classList.add('is-open');
        document.body.style.overflow = 'hidden';
        if (window.initAllPhoneSelectors) {
            window.initAllPhoneSelectors();
        }
        setTimeout(() => {
            const firstInput = modal.querySelector('input[name="name"]');
            if (firstInput) firstInput.focus();
        }, 150);
    }
}

function closeHeroConsultModal() {
    const modal = document.getElementById('fsHeroConsultModal');
    if (modal) {
        modal.classList.remove('is-open');
        document.body.style.overflow = '';
    }
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeHeroConsultModal();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    if (window.initAllPhoneSelectors) {
        window.initAllPhoneSelectors();
    }
});

async function handleHeroConsultSubmit(e) {
    e.preventDefault();
    const form = e.target;
    const btn = document.getElementById('fsHeroModalSubmitBtn');
    const successMsg = document.getElementById('fsHeroModalSuccess');

    const formData = new FormData(form);
    const data = Object.fromEntries(formData.entries());

    if (btn) {
        btn.disabled = true;
        btn.textContent = 'SUBMITTING...';
    }

    try {
        const response = await fetch('/api/leads', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
            },
            body: JSON.stringify(data)
        });

        if (response.ok) {
            form.reset();
            if (btn) btn.style.display = 'none';
            if (successMsg) successMsg.style.display = 'block';
            setTimeout(() => {
                closeHeroConsultModal();
                if (btn) {
                    btn.disabled = false;
                    btn.textContent = 'REQUEST NOW';
                    btn.style.display = 'block';
                }
                if (successMsg) successMsg.style.display = 'none';
            }, 3000);
        } else {
            alert('There was a problem submitting your request. Please try again or contact us directly on WhatsApp.');
            if (btn) {
                btn.disabled = false;
                btn.textContent = 'REQUEST NOW';
            }
        }
    } catch (err) {
        console.error('Lead submit error:', err);
        alert('There was a problem submitting your request. Please contact us via WhatsApp.');
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'REQUEST NOW';
        }
    }
}
</script>

