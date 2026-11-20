<!-- Static Off-Plan Advisor Banner (Placed below contact options, above FAQs) -->
<section class="advisorBannerSection" aria-label="Talk to an Advisor">
    <style>
        .advisorBannerSection {
            background: #ffffff !important;
            padding: 60px 20px 70px 20px !important;
        }
        .advisorBannerCard {
            max-width: 1100px;
            margin: 0 auto;
            background: radial-gradient(ellipse at 50% 25%, #2a2217 0%, #17120a 55%, #0d0a06 100%) !important;
            border: 2px solid #BFA16A !important;
            border-radius: 24px;
            padding: 65px 32px;
            text-align: center;
            box-shadow: 0 16px 44px rgba(191, 161, 106, 0.22), 0 8px 30px rgba(0, 0, 0, 0.14);
            position: relative;
            overflow: hidden;
        }
        .advisorBannerCard::before {
            content: '';
            position: absolute;
            top: -50%;
            left: 50%;
            transform: translateX(-50%);
            width: 600px;
            height: 350px;
            background: radial-gradient(circle, rgba(191, 161, 106, 0.28) 0%, transparent 70%);
            pointer-events: none;
        }
        .advisorBannerTitle {
            font-family: var(--font-display, 'Outfit', sans-serif);
            font-size: clamp(24px, 3.4vw, 38px);
            font-weight: 800;
            color: #ffffff;
            margin: 0 0 14px 0;
            line-height: 1.25;
            letter-spacing: -0.01em;
            position: relative;
            z-index: 1;
        }
        .advisorBannerSubtitle {
            font-size: clamp(14.5px, 1.4vw, 17px);
            color: rgba(255, 255, 255, 0.88);
            line-height: 1.65;
            max-width: 720px;
            margin: 0 auto 30px auto;
            font-weight: 400;
            position: relative;
            z-index: 1;
        }
        .advisorBannerBtn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: #BFA16A !important;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 700;
            padding: 14px 40px;
            border-radius: 999px;
            border: 1.5px solid #BFA16A !important;
            cursor: pointer;
            box-shadow: 0 4px 20px rgba(191, 161, 106, 0.55);
            transition: all 0.25s ease;
            text-decoration: none;
            position: relative;
            z-index: 1;
        }
        .advisorBannerBtn:hover {
            background: #aa8d58 !important;
            border-color: #aa8d58 !important;
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(191, 161, 106, 0.7);
        }
        @media (max-width: 768px) {
            .advisorBannerSection {
                padding: 45px 14px 50px 14px !important;
            }
            .advisorBannerCard {
                padding: 42px 20px;
                border-radius: 18px;
            }
            .advisorBannerBtn {
                width: 100%;
                max-width: 320px;
                padding: 13px 24px;
                font-size: 14px;
            }
        }
    </style>
    <div class="advisorBannerCard">
        <h2 class="advisorBannerTitle">Interested in an off-plan investment?</h2>
        <p class="advisorBannerSubtitle">
            Tell us your budget and goals — a FS Advisory consultant will match you with the right project.
        </p>
        <button type="button" class="advisorBannerBtn" onclick="openAdvisorModal()">
            Talk to an advisor
        </button>
    </div>
</section>

<!-- Modal: Talk to an Advisor -->
<div id="advisorLeadModal" style="display: none; position: fixed; inset: 0; z-index: 999999; align-items: center; justify-content: center;">
    <!-- Backdrop -->
    <div class="advisorModalBackdrop" onclick="closeAdvisorModal()" style="position: absolute; inset: 0; background: rgba(0, 0, 0, 0.72); backdrop-filter: blur(4px);"></div>

    <!-- Modal Box -->
    <div class="advisorModalBox" style="position: relative; z-index: 2; background: #ffffff; border: 2px solid #BFA16A; border-radius: 20px; max-width: 480px; width: 92%; padding: 34px 30px; box-shadow: 0 24px 60px rgba(0,0,0,0.4); box-sizing: border-box; max-height: 90vh; overflow-y: auto;">
        <!-- Close Button -->
        <button type="button" onclick="closeAdvisorModal()" aria-label="Close modal" style="position: absolute; top: 16px; right: 18px; background: none; border: none; font-size: 24px; line-height: 1; color: #94a3b8; cursor: pointer; padding: 4px; transition: color 0.2s;" onmouseover="this.style.color='#111827'" onmouseout="this.style.color='#94a3b8'">✕</button>

        <!-- Header -->
        <div style="text-align: center; margin-bottom: 24px;">
            <h3 style="font-family: var(--font-display, 'Outfit', sans-serif); font-size: 24px; font-weight: 800; color: #111827; margin: 0 0 6px 0;">
                Talk to an Advisor
            </h3>
            <p style="font-size: 13.5px; color: #64748b; margin: 0; line-height: 1.5;">
                Tell us your budget and goals — a FS Advisory consultant will match you with the right project.
            </p>
        </div>

        <!-- Form (Full Name, Email, Contact Number with Flag Dropdown) -->
        <form id="advisorModalForm" style="display: flex; flex-direction: column; gap: 18px;">
            @csrf
            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Full Name *
                </label>
                <input type="text" name="name" required placeholder="Enter your full name" style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; color: #111827; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#BFA16A'" onblur="this.style.borderColor='#d1d5db'">
            </div>

            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Email Address *
                </label>
                <input type="email" name="email" required placeholder="Enter your email address" style="width: 100%; height: 44px; padding: 0 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; color: #111827; box-sizing: border-box; outline: none; transition: border-color 0.2s;" onfocus="this.style.borderColor='#BFA16A'" onblur="this.style.borderColor='#d1d5db'">
            </div>

            <div>
                <label style="display: block; font-size: 12.5px; font-weight: 700; color: #374151; margin-bottom: 6px;">
                    Contact Number *
                </label>
                <div class="phoneUnifiedContainer" style="height: 44px; background: #ffffff; border: 1px solid #d1d5db; border-radius: 8px; display: flex; align-items: center; width: 100%; position: relative; box-sizing: border-box;">
                    <div class="countryTriggerWrapper" style="position: relative; height: 100%;">
                        <button type="button" class="countryTriggerBtn" id="advisorCountryBtn" aria-label="Country selector" style="height: 100%; padding: 0 10px; display: flex; align-items: center; gap: 6px; background: transparent; border: none; cursor: pointer;">
                            <span class="flagSlot" id="advisorFlagSlot"></span>
                            <span class="caretDown" style="border-top-color: #6b7280;"></span>
                        </button>
                        <ul class="countryDropdownMenu" id="advisorCountryDropdown" style="display: none; position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid #ddd; max-height: 240px; overflow-y: auto; z-index: 1000000; width: 280px; box-shadow: 0 8px 24px rgba(0,0,0,0.15); padding: 0; margin: 4px 0 0 0; list-style: none;"></ul>
                    </div>
                    <input type="tel" name="phone" id="advisorPhoneInput" class="phoneInputField" value="+92 " required style="flex: 1; min-width: 0; height: 100%; border: none; padding: 0 12px; font-size: 14px; outline: none; background: transparent; color: #111827; box-sizing: border-box;">
                </div>
            </div>

            <button type="submit" id="advisorModalSubmitBtn" style="width: 100%; height: 46px; background: #BFA16A; color: #ffffff; border: none; border-radius: 8px; font-size: 14px; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; cursor: pointer; transition: all 0.25s ease; box-shadow: 0 4px 14px rgba(191,161,106,0.35); margin-top: 6px;">
                SUBMIT INQUIRY
            </button>
        </form>

        <!-- Success Box -->
        <div id="advisorSuccessBox" style="display: none; background: #f0fdf4; border: 1.5px solid #86efac; border-radius: 12px; padding: 24px 20px; text-align: center; color: #166534; font-size: 14px; line-height: 1.6;">
            <div style="font-size: 36px; margin-bottom: 8px; color: #15803d;">✓</div>
            <strong style="display: block; font-size: 17px; margin-bottom: 6px; color: #14532d;">Inquiry Received!</strong>
            Thank you! Your request has been sent to our team. A senior FS Advisory consultant will contact you shortly.
        </div>
    </div>
</div>

<script>
(function() {
    window.openAdvisorModal = function() {
        const modal = document.getElementById('advisorLeadModal');
        if (modal) {
            modal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            if (typeof window.setupPhoneSelector === 'function') {
                window.setupPhoneSelector('advisorCountryBtn', 'advisorCountryDropdown', 'advisorFlagSlot', 'advisorPhoneInput');
            }
        }
    };

    window.closeAdvisorModal = function() {
        const modal = document.getElementById('advisorLeadModal');
        if (modal) {
            modal.style.display = 'none';
            document.body.style.overflow = '';
        }
    };

    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            window.closeAdvisorModal();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof window.setupPhoneSelector === 'function') {
            window.setupPhoneSelector('advisorCountryBtn', 'advisorCountryDropdown', 'advisorFlagSlot', 'advisorPhoneInput');
        }

        const advisorForm = document.getElementById('advisorModalForm');
        if (advisorForm) {
            advisorForm.addEventListener('submit', async function(e) {
                e.preventDefault();
                const submitBtn = document.getElementById('advisorModalSubmitBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.textContent = 'SUBMITTING...';
                }

                const formData = new FormData(advisorForm);
                formData.append('project', 'Projects Main Page - Off-Plan Investment Advisor');
                formData.append('community', 'Projects Main Page');
                formData.append('source', 'Website');
                formData.append('sub_source', 'project main page');
                formData.append('page_url', window.location.href);
                formData.append('campaign_url', window.location.href);
                formData.append('activity_description', 'Interested in an off-plan investment - Talk to an Advisor Lead');
                formData.append('key_requirement', 'Talk to an Advisor Consultation Form (Projects Page)');

                try {
                    const resp = await fetch('/api/leads', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                            'Accept': 'application/json'
                        },
                        body: formData
                    });

                    advisorForm.style.display = 'none';
                    document.getElementById('advisorSuccessBox').style.display = 'block';

                    setTimeout(function() {
                        window.closeAdvisorModal();
                        advisorForm.reset();
                        advisorForm.style.display = 'flex';
                        document.getElementById('advisorSuccessBox').style.display = 'none';
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'SUBMIT INQUIRY';
                        }
                    }, 3500);
                } catch (err) {
                    console.error('Lead submission error:', err);
                    advisorForm.style.display = 'none';
                    document.getElementById('advisorSuccessBox').style.display = 'block';
                    setTimeout(function() {
                        window.closeAdvisorModal();
                        advisorForm.reset();
                        advisorForm.style.display = 'flex';
                        document.getElementById('advisorSuccessBox').style.display = 'none';
                        if (submitBtn) {
                            submitBtn.disabled = false;
                            submitBtn.textContent = 'SUBMIT INQUIRY';
                        }
                    }, 3500);
                }
            });
        }
    });
})();
</script>

