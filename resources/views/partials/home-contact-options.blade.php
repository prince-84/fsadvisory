<!-- Home Page Static Contact Options Section (Call / Consultation / Message) -->
<section class="homeContactOptions" aria-label="Contact FS Advisory">
    <style>
        .homeContactOptions {
            background: #0d0d0d;
            padding: 0 20px 70px 20px;
        }
        .homeContactOptions .hcoCard {
            max-width: 1100px;
            margin: 0 auto;
            background: #ffffff;
            border: 6px solid rgba(191, 161, 106, 0.55);
            border-radius: 28px;
            padding: 46px 30px 42px 30px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 34px;
            text-align: center;
        }
        .homeContactOptions .hcoItem {
            display: flex;
            flex-direction: column;
            align-items: center;
            height: 100%;
        }
        .homeContactOptions .hcoText { flex-grow: 1; }
        .homeContactOptions .hcoBtn { margin-top: auto; }
        .homeContactOptions .hcoIcon {
            width: 66px;
            height: 66px;
            border-radius: 50%;
            background: #BFA16A;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px auto;
        }
        .homeContactOptions .hcoTitle {
            font-size: 21px;
            font-weight: 700;
            color: #111111;
            margin: 0 0 12px 0;
        }
        .homeContactOptions .hcoText {
            font-size: 14.5px;
            line-height: 1.75;
            color: #4b5563;
            margin: 0 0 22px 0;
        }
        .homeContactOptions .hcoBtn {
            display: inline-block;
            background: #BFA16A !important;
            color: #ffffff !important;
            font-size: 13.5px;
            font-weight: 700;
            padding: 11px 28px;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .homeContactOptions .hcoBtn:hover {
            background: #aa8d58 !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(191, 161, 106, 0.4);
        }
        .homeContactOptions .hcoNumber {
            display: block;
            font-size: 15px;
            font-weight: 700;
            color: #BFA16A;
            margin-bottom: 14px;
        }
        @media (max-width: 900px) {
            .homeContactOptions .hcoCard {
                grid-template-columns: 1fr;
                gap: 38px;
                padding: 36px 22px;
                border-width: 4px;
                border-radius: 22px;
            }
            .homeContactOptions { padding: 0 14px 50px 14px; }
        }
    </style>
    <div class="hcoCard">
        <div class="hcoItem">
            <div class="hcoIcon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="currentColor"><path d="M6.6 10.8a15.1 15.1 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.25c1.1.37 2.3.57 3.6.57a1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.25.2 2.45.57 3.57a1 1 0 0 1-.25 1z"/></svg>
            </div>
            <h3 class="hcoTitle">Call Our Experts</h3>
            <p class="hcoText">Get in touch with FS Advisory for professional real estate guidance, investment insights, and answers to your property-related questions.</p>
            <span class="hcoNumber">+92 332 2495575</span>
            <a href="{{ request()->is('/') ? '#contact' : url('/contact-us') }}" class="hcoBtn">Call Us Now</a>
        </div>
        <div class="hcoItem">
            <div class="hcoIcon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <h3 class="hcoTitle">Book a Consultation</h3>
            <p class="hcoText">Schedule a one-on-one consultation with our property advisors to discuss your investment goals and explore suitable real estate opportunities.</p>
            <a href="{{ request()->is('/') ? '#contact' : url('/contact-us') }}" class="hcoBtn">Book a Consultation</a>
        </div>
        <div class="hcoItem">
            <div class="hcoIcon">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
            </div>
            <h3 class="hcoTitle">Send Us a Message</h3>
            <p class="hcoText">Have a question or need assistance? Connect with our team to learn more about our advisory services and available investment opportunities.</p>
            <a href="{{ request()->is('/') ? '#contact' : url('/contact-us') }}" class="hcoBtn">Contact Our Team</a>
        </div>
    </div>
</section>

