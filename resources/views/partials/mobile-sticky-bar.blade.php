<!-- GLOBAL MOBILE STICKY BOTTOM ACTION BAR (ONLY ON MOBILE RESPONSIVE <= 768px, HIDDEN ON DESKTOP/LAPTOP) -->
<div id="fsMobileStickyBottomBar" class="fsMobileStickyBottomBar" aria-label="Mobile Bottom Actions">
    <button type="button" id="fsMobileStickyRegisterBtn" class="fsMobileStickyBarBtn fsMobileStickyRegisterBtn" onclick="openMobileStickyRegisterModal();">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
            <circle cx="9" cy="7" r="4"></circle>
            <polyline points="16 11 18 13 22 9"></polyline>
        </svg>
        <span>REGISTER NOW</span>
    </button>
    <a href="#" id="fsMobileStickyWaBtn" class="fsMobileStickyBarBtn fsMobileStickyWaBtn" onclick="handleMobileStickyWhatsApp(event);">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.316 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.818-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
        </svg>
        <span>WHATSAPP</span>
    </a>
</div>

<!-- GLOBAL MOBILE STICKY REGISTER MODAL (STRICTLY CLOSED BY DEFAULT, OPENS ONLY ON REGISTER NOW CLICK IN MOBILE VIEW) -->
<div id="fsMobileStickyRegisterModal" class="fsMobileStickyModalOverlay" aria-hidden="true" onclick="if(event.target === this) closeMobileStickyRegisterModal();">
    <div class="fsMobileStickyModalBox">
        <button type="button" class="fsMobileStickyModalClose" onclick="closeMobileStickyRegisterModal();" aria-label="Close modal">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>

        <h3 class="fsMobileStickyModalTitle">REGISTER YOUR INTEREST</h3>
        <p class="fsMobileStickyModalSubtitle">Connect with our luxury property specialists today.</p>

        <form id="fsMobileStickyRegisterForm" class="fsMobileStickyForm">
            <div class="fsMobileStickyField">
                <input type="text" name="name" required placeholder="Full Name *" class="fsMobileStickyInput">
            </div>

            <div class="fsMobileStickyField">
                <input type="email" name="email" required placeholder="Email Address *" class="fsMobileStickyInput">
            </div>

            <div class="fsMobileStickyField">
                <div class="phoneUnifiedContainer" style="height: 44px !important; background: #fff !important; border: 1px solid #dcdcdc !important; border-radius: 6px !important;">
                    <div class="countryTriggerWrapper">
                        <button type="button" class="countryTriggerBtn" id="mobileStickyCountryBtn" aria-label="Country selector">
                            <span class="flagSlot" id="mobileStickyFlagSlot">
                                <img src="https://flagcdn.com/w40/pk.png" srcset="https://flagcdn.com/w80/pk.png 2x" width="22" height="15" alt="Pakistan" class="flagImgUniversal" style="border-radius:2px;object-fit:cover;display:inline-block;vertical-align:middle;box-shadow:0 1px 2px rgba(0,0,0,0.18);flex-shrink:0;">
                            </span>
                            <span class="caretDown"></span>
                        </button>
                        <ul class="countryDropdownMenu" id="mobileStickyCountryDropdown" style="display: none;"></ul>
                    </div>
                    <input type="tel" name="phone" id="mobileStickyPhoneInput" class="phoneInputField" value="+92 " placeholder="+92 300 1234567" required>
                </div>
            </div>

            <button type="submit" id="fsMobileStickySubmitBtn" class="fsMobileStickySubmitBtn">
                SUBMIT NOW
            </button>
        </form>

        <div id="fsMobileStickySuccessBox" style="display: none; padding: 14px 16px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; color: #166534; font-size: 13.5px; text-align: center; font-weight: 600; margin-top: 12px;">
            ✓ Thank you! Your request has been received. Our advisory team will contact you shortly.
        </div>
    </div>
</div>

<style id="fs-mobile-sticky-styles">
/* STRICTLY HIDDEN BY DEFAULT ON ALL SCREENS */
#fsMobileStickyBottomBar,
.fsMobileStickyBottomBar,
#fsMobileStickyRegisterModal,
.fsMobileStickyModalOverlay {
    display: none !important;
    visibility: hidden !important;
    opacity: 0 !important;
    pointer-events: none !important;
}

/* DESKTOP / LAPTOP (> 768px): ALWAYS FORCE-HIDE EVEN IF OPEN CLASS EXISTS */
@media (min-width: 769px) {
    #fsMobileStickyBottomBar,
    .fsMobileStickyBottomBar,
    #fsMobileStickyRegisterModal,
    .fsMobileStickyModalOverlay,
    #fsMobileStickyRegisterModal.isModalOpen,
    .fsMobileStickyModalOverlay.isModalOpen {
        display: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        pointer-events: none !important;
    }
}

/* MOBILE RESPONSIVE (<= 768px): FIXED BOTTOM ACTION BAR */
@media (max-width: 768px) {
    #fsMobileStickyBottomBar,
    .fsMobileStickyBottomBar {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        pointer-events: auto !important;
        position: fixed !important;
        bottom: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        z-index: 99990 !important;
        background: #ffffff !important;
        border-top: 1px solid #e2e8f0 !important;
        padding: 9px 12px !important;
        box-shadow: 0 -4px 18px rgba(0, 0, 0, 0.12) !important;
        gap: 10px !important;
        box-sizing: border-box !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding-bottom: max(9px, env(safe-area-inset-bottom)) !important;
    }

    body {
        padding-bottom: 64px !important;
    }

    #scrollTopBtn,
    .ScrollToTop-module__bPaVnG__scrollTopBtn {
        bottom: 74px !important;
    }

    .fsMobileStickyBarBtn {
        flex: 1 !important;
        height: 44px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 8px !important;
        border-radius: 8px !important;
        font-size: 13px !important;
        font-weight: 700 !important;
        letter-spacing: 0.5px !important;
        text-transform: uppercase !important;
        cursor: pointer !important;
        text-decoration: none !important;
        box-sizing: border-box !important;
        transition: transform 0.15s ease, opacity 0.2s ease !important;
    }

    .fsMobileStickyBarBtn:active {
        transform: scale(0.98) !important;
    }

    .fsMobileStickyRegisterBtn {
        background: #BFA16A !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 3px 10px rgba(191, 161, 106, 0.3) !important;
    }

    .fsMobileStickyWaBtn {
        background: #25D366 !important;
        color: #ffffff !important;
        border: none !important;
        box-shadow: 0 3px 10px rgba(37, 211, 102, 0.3) !important;
    }

    /* MODAL OPENS ONLY WHEN USER EXPLICITLY CLICKS REGISTER NOW */
    #fsMobileStickyRegisterModal.isModalOpen,
    .fsMobileStickyModalOverlay.isModalOpen {
        display: flex !important;
        visibility: visible !important;
        opacity: 1 !important;
        pointer-events: auto !important;
    }
}

/* Modal Overlay Base Positioning (kept hidden by default above) */
.fsMobileStickyModalOverlay {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    bottom: 0 !important;
    width: 100vw !important;
    height: 100vh !important;
    background: rgba(12, 35, 64, 0.65) !important;
    backdrop-filter: blur(4px) !important;
    -webkit-backdrop-filter: blur(4px) !important;
    z-index: 999999 !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 16px !important;
    box-sizing: border-box !important;
    transition: opacity 0.2s ease !important;
}

.fsMobileStickyModalBox {
    background: #ffffff !important;
    border-radius: 12px !important;
    width: 100% !important;
    max-width: 420px !important;
    padding: 24px 20px !important;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.28) !important;
    position: relative !important;
    box-sizing: border-box !important;
    animation: fsModalFadeIn 0.25s ease-out !important;
}

@keyframes fsModalFadeIn {
    from { opacity: 0; transform: translateY(16px); }
    to { opacity: 1; transform: translateY(0); }
}

.fsMobileStickyModalClose {
    position: absolute !important;
    top: 14px !important;
    right: 14px !important;
    width: 32px !important;
    height: 32px !important;
    border-radius: 50% !important;
    background: #f1f5f9 !important;
    border: none !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    color: #475569 !important;
    cursor: pointer !important;
    transition: background 0.2s ease !important;
}

.fsMobileStickyModalClose:hover {
    background: #e2e8f0 !important;
    color: #0f172a !important;
}

.fsMobileStickyModalTitle {
    font-size: 17px !important;
    font-weight: 800 !important;
    color: #0c2340 !important;
    margin: 0 0 4px 0 !important;
    letter-spacing: 0.5px !important;
    text-transform: uppercase !important;
}

.fsMobileStickyModalSubtitle {
    font-size: 13px !important;
    color: #64748b !important;
    margin: 0 0 16px 0 !important;
}

.fsMobileStickyForm {
    display: flex !important;
    flex-direction: column !important;
    gap: 11px !important;
}

.fsMobileStickyInput {
    width: 100% !important;
    height: 44px !important;
    border: 1px solid #dcdcdc !important;
    border-radius: 6px !important;
    padding: 0 14px !important;
    font-size: 13.5px !important;
    color: #1e293b !important;
    box-sizing: border-box !important;
    outline: none !important;
}

.fsMobileStickyInput:focus {
    border-color: #BFA16A !important;
    box-shadow: 0 0 0 3px rgba(191, 161, 106, 0.15) !important;
}

.fsMobileStickySubmitBtn {
    width: 100% !important;
    height: 44px !important;
    background: #BFA16A !important;
    color: #ffffff !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    letter-spacing: 0.6px !important;
    text-transform: uppercase !important;
    border: none !important;
    border-radius: 6px !important;
    cursor: pointer !important;
    box-shadow: 0 4px 12px rgba(191, 161, 106, 0.35) !important;
    transition: background 0.2s ease !important;
    margin-top: 4px !important;
}

.fsMobileStickySubmitBtn:hover {
    background: #aa8d58 !important;
}
</style>

<script>
(function() {
    if (window._fsMobileStickyInitialized) return;
    window._fsMobileStickyInitialized = true;

    window.openMobileStickyRegisterModal = function() {
        if (window.innerWidth > 768) return; // Strictly mobile only
        const modal = document.getElementById('fsMobileStickyRegisterModal');
        if (modal) {
            modal.classList.add('isModalOpen');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            if (typeof window.setupPhoneSelector === 'function') {
                window.setupPhoneSelector('mobileStickyCountryBtn', 'mobileStickyCountryDropdown', 'mobileStickyFlagSlot', 'mobileStickyPhoneInput');
            }
            if (window._activeCountry && typeof window.setUniversalCountry === 'function') {
                window.setUniversalCountry(window._activeCountry.code);
            }
        }
    };

    window.closeMobileStickyRegisterModal = function() {
        const modal = document.getElementById('fsMobileStickyRegisterModal');
        if (modal) {
            modal.classList.remove('isModalOpen');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        }
    };

    // Auto-close modal immediately whenever viewport expands to desktop (e.g. closing DevTools inspect)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            window.closeMobileStickyRegisterModal();
        }
    });

    if (window.matchMedia) {
        const desktopMq = window.matchMedia('(min-width: 769px)');
        const handleDesktopChange = function(e) {
            if (e.matches) window.closeMobileStickyRegisterModal();
        };
        if (desktopMq.addEventListener) {
            desktopMq.addEventListener('change', handleDesktopChange);
        } else if (desktopMq.addListener) {
            desktopMq.addListener(handleDesktopChange);
        }
    }

    window.handleMobileStickyWhatsApp = function(e) {
        if (e) e.preventDefault();
        const pageTitle = (document.title || 'FS Real Estate Advisory').replace(/\s*\|\s*FS Real Estate Advisory.*$/i, '').replace(/\s*\|\s*FS Advisory.*$/i, '').trim();
        const cleanPath = (window.location.pathname || '/').replace(/^\/+/, '');
        const pageUrl = cleanPath ? ('https://fsadvisory.pk/' + cleanPath) : 'https://fsadvisory.pk';
        const msg = "Hello FS Advisory, I am interested in " + pageTitle + ".\nPlease share details.\n" + pageUrl;
        const waUrl = "https://wa.me/923322495575?text=" + encodeURIComponent(msg);
        window.open(waUrl, '_blank');
    };

    document.addEventListener("DOMContentLoaded", function() {
        // Ensure strictly closed on initial load
        window.closeMobileStickyRegisterModal();

        // Initialize mobile sticky phone selector if present
        if (typeof window.setupPhoneSelector === 'function') {
            window.setupPhoneSelector('mobileStickyCountryBtn', 'mobileStickyCountryDropdown', 'mobileStickyFlagSlot', 'mobileStickyPhoneInput');
        }

        // Handle Mobile Register Form Submit
        const regForm = document.getElementById("fsMobileStickyRegisterForm");
        regForm?.addEventListener("submit", async function(e) {
            e.preventDefault();
            const formData = new FormData(regForm);
            formData.append('source', 'Website');
            formData.append('sub_source', 'fsadvisory.pk');
            formData.append('page_url', window.location.href);
            formData.append('campaign_url', window.location.href);
            formData.append('utm_campaign', new URLSearchParams(window.location.search).get('utm_campaign') || '');
            formData.append('activity_description', 'Mobile Bottom Bar Inquiry Submission');

            const submitBtn = document.getElementById("fsMobileStickySubmitBtn");
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.textContent = "SUBMITTING...";
            }

            try {
                await fetch("/api/leads", {
                    method: "POST",
                    headers: {
                        "Accept": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]')?.getAttribute("content") || ""
                    },
                    body: formData
                });

                regForm.style.display = "none";
                const successBox = document.getElementById("fsMobileStickySuccessBox");
                if (successBox) successBox.style.display = "block";

                setTimeout(() => {
                    window.closeMobileStickyRegisterModal();
                    regForm.reset();
                    regForm.style.display = "flex";
                    if (successBox) successBox.style.display = "none";
                    if (submitBtn) {
                        submitBtn.disabled = false;
                        submitBtn.textContent = "SUBMIT NOW";
                    }
                }, 3000);
            } catch (err) {
                console.error(err);
                regForm.style.display = "none";
                const successBox = document.getElementById("fsMobileStickySuccessBox");
                if (successBox) successBox.style.display = "block";
            }
        });
    });
})();
</script>

