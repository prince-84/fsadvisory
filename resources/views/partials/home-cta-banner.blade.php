<!-- Home Page Static CTA Banner Section (Directly Above Form & Footer) -->
<section class="homeCtaSection" style="background: #0d0d0d; color: #ffffff; padding: 60px 20px 24px 20px; text-align: center; border-top: 1px solid rgba(191, 161, 106, 0.22); position: relative; z-index: 2;">
    <style>
        .homeCtaSection {
            background: #0d0d0d !important;
            padding: 60px 20px 24px 20px !important;
        }
        .homeCtaTitle {
            font-family: var(--font-display, 'Outfit', sans-serif);
            font-size: clamp(24px, 4vw, 38px);
            font-weight: 800;
            color: #ffffff;
            line-height: 1.25;
            margin: 0 0 14px 0;
            letter-spacing: -0.01em;
        }
        .homeCtaText {
            font-size: clamp(14.5px, 1.8vw, 16px);
            color: #d1d5db;
            line-height: 1.75;
            max-width: 860px;
            margin: 0 auto 0 auto;
            font-weight: 400;
        }
        .homeCtaBtn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            background: #BFA16A !important;
            color: #ffffff !important;
            font-size: 15px;
            font-weight: 700;
            padding: 13px 32px;
            border-radius: 999px;
            text-decoration: none;
            box-shadow: 0 4px 18px rgba(191, 161, 106, 0.35);
            transition: all 0.25s ease;
            border: none;
        }
        .homeCtaBtn:hover {
            background: #aa8d58 !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 24px rgba(191, 161, 106, 0.45);
        }
        @media (max-width: 768px) {
            .homeCtaSection {
                padding: 45px 18px 18px 18px !important;
            }
            .homeCtaBtn {
                padding: 12px 24px !important;
                font-size: 14px !important;
                width: 100%;
                max-width: 340px;
            }
        }
    </style>
    <div class="container" style="max-width: 960px; margin: 0 auto;">
        <h2 class="homeCtaTitle">
            {{ $ctaTitle ?? 'Ready to Make Your Next Real Estate Move?' }}
        </h2>
        <p class="homeCtaText">
            Whether you are planning to buy, sell, or invest in property, FS Advisory provides professional real estate consultancy and investment guidance. Our team helps you explore opportunities, make informed decisions, and achieve your property investment goals.
        </p>
    </div>
</section>

