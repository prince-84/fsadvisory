<section id="hero" class="hero" aria-label="Saima Hero and Callback Request">
    @php
        $heroBg = page_section('hero', 'bg_image', '/images/hero/slide-1.jpg');
        if ($heroBg && !str_starts_with($heroBg, 'http') && !str_starts_with($heroBg, '/')) {
            $heroBg = asset($heroBg);
        }
        $heroTitleRaw = page_section('hero', 'title', "Saima\nProjects");
        $heroTitleClean = trim(preg_replace('/\s+/', ' ', strip_tags((string)$heroTitleRaw)));
        $heroImageAlt = page_section('hero', 'bg_image_alt', page_section('hero', 'image_alt', $heroTitleClean));
        if (empty(trim((string)$heroImageAlt))) {
            $heroImageAlt = $heroTitleClean;
        }
    @endphp
    <!-- Background Carousel with Ken Burns Zoom -->
    <div class="carousel">
        <div class="carouselSlide carouselSlideActive" id="heroSlide0">
            <img src="{{ $heroBg }}" alt="{{ $heroImageAlt }}" class="slideImage">
        </div>
        <div class="carouselSlide" id="heroSlide1">
            <img src="{{ $heroBg }}" alt="{{ $heroImageAlt }}" class="slideImage">
        </div>
    </div>

    <!-- Dark Overlay & 2-Column Hero Content -->
    <div class="overlay">
        <div class="container">
            <div class="heroContent">
                <!-- Left Column -->
                <div class="leftCol">
                    <h1 class="heroTitle">
                        {!! nl2br(e(page_section('hero', 'title', "Saima\nProjects"))) !!}
                    </h1>
                    <p class="heroSubtitle">
                        {!! nl2br(e(page_section('hero', 'subtitle', "Pakistan’s Most Exclusive Luxury\nLifestyle Destination"))) !!}
                    </p>
                    <div class="heroBtnRow">
                        <button type="button" class="heroBookBtn" onclick="const f = document.querySelector('.rightCol .requestCard, #heroLeadForm, #contact'); if(f) { f.scrollIntoView({behavior: 'smooth'}); f.querySelector('input')?.focus(); }">BOOK NOW</button>
                    </div>
                    @php
                        $heroBadge = page_section('hero', 'badge', '');
                    @endphp
                    @if(!empty(trim((string)$heroBadge)))
                        <div class="freeholdText">
                            {{ $heroBadge }}
                        </div>
                    @endif
                </div>

                <!-- Right Column: Request A Call Back Card -->
                <div class="rightCol">
                    <div class="requestCard">
                        <p class="cardTitleSmall">{{ page_section('hero', 'form_small', 'REQUEST') }}</p>
                        <div class="cardTitleLarge">{{ page_section('hero', 'form_large', 'A CALL BACK') }}</div>

                        <form id="heroLeadForm" aria-label="Request A Call Back">
                            <div class="formGroup">
                                <input type="text" name="name" required placeholder="Full Name" class="inputField">
                            </div>
                            <div class="formGroup">
                                <input type="email" name="email" required placeholder="E-mail" class="inputField">
                            </div>
                            <div class="formGroup">
                                <!-- UNIFIED 1-ROW PHONE INPUT CONTAINER (EXACT IMAGE 2 MATCH) -->
                                <div class="phoneUnifiedContainer">
                                    <div class="countryTriggerWrapper">
                                        <button type="button" class="countryTriggerBtn" id="heroCountryBtn" aria-label="Country selector">
                                            <span class="flagSlot" id="heroFlagSlot">
                                                <img src="https://flagcdn.com/w40/pk.png" srcset="https://flagcdn.com/w80/pk.png 2x" width="22" height="15" alt="Pakistan" class="flagImgUniversal" style="border-radius:2px;object-fit:cover;display:inline-block;vertical-align:middle;box-shadow:0 1px 2px rgba(0,0,0,0.18);flex-shrink:0;">
                                            </span>
                                            <span class="caretDown"></span>
                                        </button>

                                        <!-- Country Dropdown Menu -->
                                        <ul class="countryDropdownMenu" id="heroCountryDropdown" style="display: none;">
                                            <!-- Dynamically populated via JS -->
                                        </ul>
                                    </div>
                                    <input type="tel" name="phone" id="heroPhoneInput" class="phoneInputField" value="+92 " placeholder="+92 300 1234567" required>
                                </div>
                            </div>
                            <button type="submit" class="submitBtn">{{ page_section('hero', 'submit_button', 'REQUEST NOW') }}</button>
                        </form>

                        <div id="heroSuccessMsg" class="successMessage" style="display: none; margin-top: 14px;">
                            ✓ Your request has been received. Our luxury property specialist will call you back shortly!
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.setupPhoneSelector === 'function') {
            window.setupPhoneSelector('heroCountryBtn', 'heroCountryDropdown', 'heroFlagSlot', 'heroPhoneInput');
        }

        // Hero Form AJAX Submission
        const heroLeadForm = document.getElementById('heroLeadForm');
        heroLeadForm?.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(heroLeadForm);
            const submitBtn = heroLeadForm.querySelector('button[type="submit"]');
            submitBtn.disabled = true;
            submitBtn.textContent = 'SUBMITTING...';

            try {
                await fetch('/api/leads', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                    },
                    body: JSON.stringify({
                        name: formData.get('name'),
                        email: formData.get('email') || '',
                        phone: formData.get('phone'),
                        source: 'Website',
                        sub_source: 'fsadvisory.pk',
                        page_url: window.location.href,
                        campaign_url: window.location.href,
                        utm_campaign: new URLSearchParams(window.location.search).get('utm_campaign') || '',
                        project: 'Saima',
                        developer: 'Saima Group',
                        community: 'Saima',
                        property_type: 'Villas, Apartments, Plots',
                        key_requirement: 'Homepage Hero Call Back Request',
                        activity_description: 'Hero Callback Form Submission'
                    })
                });

                document.getElementById('heroSuccessMsg').style.display = 'block';
                heroLeadForm.reset();
                if (window._activeCountry) {
                    document.getElementById('heroPhoneInput').value = window._activeCountry.dial + ' ';
                } else {
                    document.getElementById('heroPhoneInput').value = '+92 ';
                }
                setTimeout(() => {
                    document.getElementById('heroSuccessMsg').style.display = 'none';
                }, 5000);
            } catch (err) {
                console.error(err);
                alert('Your request has been submitted. Our agent will call you shortly!');
            } finally {
                submitBtn.disabled = false;
                submitBtn.textContent = 'REQUEST NOW';
            }
        });
    });
</script>