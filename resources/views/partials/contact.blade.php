<section id="contact" aria-label="Contact Us and Request Callback" class="contactSection">
    @php
        $contactBg = page_section('contact', 'bg_image', '/images/form image.jpg');
        if ($contactBg && !str_starts_with($contactBg, 'http') && !str_starts_with($contactBg, '/')) {
            $contactBg = asset($contactBg);
        }
    @endphp
    <!-- Full Background Image -->
    <div class="contactBgImageWrapper">
        <img src="{{ $contactBg }}" alt="Saima Waterfront Destination" class="contactBgImage">
        <div class="contactOverlay"></div>
    </div>

    <div class="container contactContainerContent">
        <div class="contactGrid">
            <!-- Left: Text Info -->
            <div class="contactTextCol">
                @php
                    $contactPre = page_section('contact', 'pretitle', '', $page->slug ?? null);
                    $contactHeading = page_section('contact', 'heading', page_section('contact', 'title', '', $page->slug ?? null), $page->slug ?? null);
                    $contactSub = page_section('contact', 'subtitle', '', $page->slug ?? null);
                @endphp
                @if(!empty(trim((string)$contactPre)))
                    <span class="contactPreTitle">{{ $contactPre }}</span>
                @endif
                @if(!empty(trim((string)$contactHeading)))
                    <h2 class="contactMainTitle">{{ $contactHeading }}</h2>
                @endif
                @if(!empty(trim((string)$contactSub)))
                    <p class="contactMainSubtitle">{{ $contactSub }}</p>
                @endif
            </div>

            <!-- Right: Form Card -->
            <div class="contactFormCol">
                <div class="contactFormCard">
                    <p class="contactTitleSmall">{{ page_section('contact', 'form_small', 'REQUEST') }}</p>
                    <div class="contactTitleLarge">{{ page_section('contact', 'form_large', 'A CALL BACK') }}</div>

                    <form id="contactLeadForm" class="contactForm" aria-label="Contact Form">
                        <div class="formGroup">
                            <input type="text" name="name" required placeholder="Full Name" class="inputField">
                        </div>
                        <div class="formGroup">
                            <input type="email" name="email" required placeholder="E-mail" class="inputField">
                        </div>
                        <div class="formGroup">
                            <div class="phoneUnifiedContainer">
                                <div class="countryTriggerWrapper">
                                    <button type="button" class="countryTriggerBtn" id="contactCountryBtn" aria-label="Country selector">
                                        <span class="flagSlot" id="contactFlagSlot">
                                            <img src="https://flagcdn.com/w40/pk.png" srcset="https://flagcdn.com/w80/pk.png 2x" width="22" height="15" alt="Pakistan" class="flagImgUniversal" style="border-radius:2px;object-fit:cover;display:inline-block;vertical-align:middle;box-shadow:0 1px 2px rgba(0,0,0,0.18);flex-shrink:0;">
                                        </span>
                                        <span class="caretDown"></span>
                                    </button>
                                    <ul class="countryDropdownMenu" id="contactCountryDropdown" style="display: none;"></ul>
                                </div>
                                <input type="tel" name="phone" id="contactPhoneInput" class="phoneInputField" value="+92 " placeholder="+92 300 1234567" required>
                            </div>
                        </div>
                        <button type="submit" class="submitBtn">{{ page_section('contact', 'submit_button', 'REQUEST NOW') }}</button>
                    </form>

                    <div id="contactSuccessMsg" class="contactSuccessMsg" style="display: none; margin-top: 14px;">
                        ✓ Thank you! Your request has been received. Our advisory team will contact you shortly.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    (function() {
        function initContactPhone() {
            if (typeof window.setupPhoneSelector === 'function') {
                window.setupPhoneSelector('contactCountryBtn', 'contactCountryDropdown', 'contactFlagSlot', 'contactPhoneInput');
            }
        }
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                if (typeof window.setupPhoneSelector === 'function') {
                    initContactPhone();
                } else {
                    const s = document.createElement('script');
                    s.src = "{{ asset('js/universal-phone-selector.js') }}?v={{ time() }}";
                    s.onload = initContactPhone;
                    document.head.appendChild(s);
                }
            });
        } else {
            if (typeof window.setupPhoneSelector === 'function') {
                initContactPhone();
            } else {
                const s = document.createElement('script');
                s.src = "{{ asset('js/universal-phone-selector.js') }}?v={{ time() }}";
                s.onload = initContactPhone;
                document.head.appendChild(s);
            }
        }
    })();

    const contactForm = document.getElementById('contactLeadForm');
    contactForm?.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(contactForm);
        const submitBtn = contactForm.querySelector('button[type="submit"]');
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
                    project: '{{ isset($page) ? addslashes($page->title) : 'Saima' }}',
                    developer: '{{ (isset($page) && isset($page->project) && !empty($page->project->developer)) ? addslashes($page->project->developer) : 'Modon Properties' }}',
                    community: '{{ isset($page) ? addslashes($page->title) : 'Saima' }}',
                    property_type: '{{ (isset($page) && isset($page->project) && !empty($page->project->property_type)) ? addslashes($page->project->property_type) : 'Residential' }}',
                    key_requirement: formData.get('comment') || formData.get('message') || '',
                    activity_description: 'General Contact Section Call Back Request'
                })
            });

            document.getElementById('contactSuccessMsg').style.display = 'block';
            contactForm.reset();
            if (window._activeCountry) {
                document.getElementById('contactPhoneInput').value = window._activeCountry.dial + ' ';
            } else {
                document.getElementById('contactPhoneInput').value = '+92 ';
            }
            setTimeout(() => {
                document.getElementById('contactSuccessMsg').style.display = 'none';
            }, 5000);
        } catch (err) {
            console.error(err);
            document.getElementById('contactSuccessMsg').style.display = 'block';
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = 'REQUEST NOW';
        }
    });
</script>