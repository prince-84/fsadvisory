@extends('layouts.app')

@section('title', $blog->meta_title ?: $blog->title)
@section('meta_description', $blog->meta_description ?: ($blog->short_content ?: \Illuminate\Support\Str::limit(strip_tags($blog->content), 160)))

@section('content')
<style>
.blogDetailWrapper {
    width: 100%;
    background-color: #ffffff;
    font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
    color: #2b2b2b;
    line-height: 1.8;
}

/* Hero Banner with Cover Image Background */
.blogDetailHero {
    position: relative;
    background-size: cover;
    background-position: center center;
    background-repeat: no-repeat;
    color: #ffffff;
    padding: 135px 0 120px 0;
    min-height: 420px;
    display: flex;
    align-items: center;
    overflow: hidden;
}

.blogDetailHero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(10, 26, 17, 0.70) 0%, rgba(10, 26, 17, 0.85) 100%);
    z-index: 1;
}

.blogDetailHeroContainer {
    max-width: 1440px;
    width: 100%;
    margin: 0 auto;
    padding: 0 36px;
    position: relative;
    z-index: 2;
    box-sizing: border-box;
}

.blogCategoryBadge {
    display: inline-flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.18);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.35);
    padding: 6px 16px;
    border-radius: 999px;
    font-size: 12.5px;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    margin-bottom: 18px;
    backdrop-filter: blur(8px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.blogDetailTitle {
    font-family: var(--font-display, 'Outfit', sans-serif);
    font-size: 40px;
    font-weight: 800;
    line-height: 1.25;
    color: #ffffff;
    margin: 0;
    letter-spacing: -0.02em;
    text-shadow: 0 2px 12px rgba(0, 0, 0, 0.35);
    max-width: 950px;
}

/* Main Body Section & 2-Column Grid (matching Project Details) */
.blogDetailBodySection {
    padding: 50px 0 80px 0;
}

.blogDetailContainer {
    max-width: 1440px;
    margin: 0 auto;
    padding: 0 36px;
    box-sizing: border-box;
}

.blogMainGrid {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 380px;
    gap: 40px;
    align-items: start;
}

.blogContentCol {
    min-width: 0;
}

/* Short Content Lead Paragraphs (Above Long Content - matching site standards) */
.blogShortContentLead {
    font-size: 15px;
    line-height: 1.6;
    color: #111111;
    margin-top: 18px;
    margin-bottom: 14px;
    font-weight: 400;
}

.blogShortContentLead p {
    margin-bottom: 10px;
}

.blogShortContentLead p:last-child {
    margin-bottom: 0;
}

/* Table of Contents Box (Exact Project Style) */
.saimaTocBox {
    border: 1px solid #dcdcdc;
    border-radius: 6px;
    background-color: #ffffff;
    padding: 18px 24px;
    margin-bottom: 36px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.03);
}

.saimaTocHeader {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding-bottom: 12px;
    border-bottom: 1px solid #eeeeee;
}

.saimaTocTitle {
    font-size: 22px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
    line-height: 1.3;
}

.saimaTocToggle {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 6px 14px;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    background: #f9fafb;
    cursor: pointer;
    color: #374151;
    font-size: 14px;
    font-weight: 600;
    transition: all 0.2s ease;
    font-family: inherit;
}

.saimaTocToggle:hover {
    background-color: #f3f4f6;
    border-color: #9ca3af;
    color: #111827;
}

.saimaTocToggle svg {
    transition: transform 0.25s ease;
}

.saimaTocToggle.is-open svg {
    transform: rotate(180deg);
}

/* TOC Content: Collapsed by Default */
#saimaTocContent {
    display: none;
    margin-top: 16px;
}

.saimaTocList {
    list-style: none;
    margin: 0;
    padding: 0;
}

.saimaTocList > li {
    margin-bottom: 12px;
    font-size: 17px;
    line-height: 1.6;
}

.saimaTocList a {
    color: #222222 !important;
    text-decoration: none !important;
    font-weight: 500;
    display: inline-block;
    padding: 2px 0;
    transition: color 0.15s ease, transform 0.15s ease;
}

.saimaTocList a:hover {
    color: #BFA16A !important;
    text-decoration: underline !important;
    transform: translateX(3px);
}

/* Rich Blog Article Content Styles (Standardized with Project & Site Pages) */
.blogArticleContent {
    font-size: 15px;
    line-height: 1.6;
    color: #111111;
}

.blogArticleContent h1,
.blogArticleContent h2 {
    font-family: var(--font-display, 'Outfit', sans-serif);
    font-size: 26px !important;
    font-weight: 700 !important;
    color: #BFA16A !important;
    margin-top: 28px !important;
    margin-bottom: 12px !important;
    line-height: 1.35 !important;
    letter-spacing: -0.2px !important;
    scroll-margin-top: 100px;
}

/* Reduce gap before the first heading right under short content */
.blogArticleContent > h1:first-child,
.blogArticleContent > h2:first-child,
.blogArticleContent > h3:first-child,
.blogArticleContent > p:first-child:has(h1, h2, h3),
.blogArticleContent > div:first-child:has(h1, h2, h3) {
    margin-top: 10px !important;
}

.blogArticleContent h3 {
    font-family: var(--font-display, 'Outfit', sans-serif);
    font-size: 20px !important;
    font-weight: 700 !important;
    color: #BFA16A !important;
    margin-top: 22px !important;
    margin-bottom: 10px !important;
    line-height: 1.4 !important;
    scroll-margin-top: 100px;
}

.blogArticleContent h4 {
    font-family: var(--font-display, 'Outfit', sans-serif);
    font-size: 17px !important;
    font-weight: 700 !important;
    color: #BFA16A !important;
    margin-top: 18px !important;
    margin-bottom: 8px !important;
    line-height: 1.4 !important;
    scroll-margin-top: 100px;
}

.blogArticleContent h5,
.blogArticleContent h6 {
    font-family: var(--font-display, 'Outfit', sans-serif);
    font-size: 15px !important;
    font-weight: 700 !important;
    color: #BFA16A !important;
    margin-top: 16px !important;
    margin-bottom: 6px !important;
    line-height: 1.4 !important;
    scroll-margin-top: 100px;
}

/* Ensure ALL inner elements of headings (spans, b, strong, a, etc.) remain brand gold #BFA16A */
.blogArticleContent h1 *,
.blogArticleContent h2 *,
.blogArticleContent h3 *,
.blogArticleContent h4 *,
.blogArticleContent h5 *,
.blogArticleContent h6 * {
    color: #BFA16A !important;
}

.blogArticleContent p {
    font-size: 15px;
    line-height: 1.6;
    color: #111111;
    margin-bottom: 14px;
}

.blogArticleContent ul:not(.saimaTocList) {
    list-style-type: disc !important;
    list-style-position: outside !important;
    margin: 10px 0 16px 0 !important;
    padding-left: 26px !important;
}

.blogArticleContent ol:not(.saimaTocList) {
    list-style-type: decimal !important;
    list-style-position: outside !important;
    margin: 10px 0 16px 0 !important;
    padding-left: 26px !important;
}

.blogArticleContent li {
    display: list-item !important;
    margin-bottom: 6px !important;
    line-height: 1.6 !important;
    color: #111111 !important;
    font-size: 15px !important;
}

.blogArticleContent ul ul {
    list-style-type: circle !important;
    margin: 6px 0 6px 0 !important;
    padding-left: 22px !important;
}

.blogArticleContent ul ol,
.blogArticleContent ol ul,
.blogArticleContent ol ol {
    margin: 6px 0 6px 0 !important;
    padding-left: 22px !important;
}

.blogArticleContent img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 24px auto;
    display: block;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
}

.blogArticleContent blockquote {
    border-left: 4px solid #BFA16A;
    background: #f8fafc;
    padding: 16px 22px;
    margin: 20px 0;
    border-radius: 0 8px 8px 0;
    font-style: italic;
    color: #475569;
}



.blogFaqItem {
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    margin-bottom: 14px;
    overflow: hidden;
    background: #ffffff;
    transition: all 0.2s ease;
}

.blogFaqItem:hover {
    border-color: #cbd5e1;
    box-shadow: 0 2px 8px rgba(0,0,0,0.03);
}

.blogFaqQuestion {
    padding: 18px 22px;
    font-size: 16.5px;
    font-weight: 700;
    color: #1e293b;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 12px;
    user-select: none;
}

.blogFaqIcon {
    width: 20px;
    height: 20px;
    color: #BFA16A;
    transition: transform 0.25s ease;
    flex-shrink: 0;
}

.blogFaqAnswer {
    padding: 0 22px 18px 22px;
    font-size: 15.5px;
    line-height: 1.75;
    color: #475569;
    display: none;
}

.blogFaqItem.active .blogFaqIcon {
    transform: rotate(180deg);
}

.blogFaqItem.active .blogFaqAnswer {
    display: block;
}

/* Right Sticky Sidebar (Exact Project Style) */
.saimaSidebarCol {
    min-width: 0;
    align-self: stretch;
    position: relative;
}

.saimaStickySidebar {
    position: -webkit-sticky;
    position: sticky;
    top: 95px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    z-index: 20;
    width: 100%;
    box-sizing: border-box;
}

/* Book an Appointment Card */
.saimaApptCard {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 26px 22px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
}

.saimaApptTitle {
    font-size: 18px;
    font-weight: 700;
    text-align: center;
    color: #111827;
    margin: 0 0 18px 0;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.saimaApptForm {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.saimaInput {
    width: 100%;
    box-sizing: border-box;
    padding: 13px 15px;
    font-size: 15.5px;
    color: #111827;
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    outline: none;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    font-family: inherit;
}

.saimaInput:focus {
    border-color: #BFA16A;
    box-shadow: 0 0 0 3px rgba(191, 161, 106, 0.15);
}

.saimaTextarea {
    width: 100%;
    box-sizing: border-box;
    padding: 13px 15px;
    font-size: 15.5px;
    color: #111827;
    background-color: #ffffff;
    border: 1px solid #d1d5db;
    border-radius: 5px;
    outline: none;
    resize: vertical;
    min-height: 105px;
    transition: border-color 0.2s ease, box-shadow 0.2s ease;
    font-family: inherit;
}

.saimaTextarea:focus {
    border-color: #BFA16A;
    box-shadow: 0 0 0 3px rgba(191, 161, 106, 0.15);
}

.saimaSubmitBtn {
    background-color: #BFA16A !important;
    color: #ffffff !important;
    font-size: 15px;
    font-weight: 700;
    letter-spacing: 1px;
    padding: 14px 18px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    text-transform: uppercase;
    transition: all 0.25s ease;
    box-shadow: 0 4px 12px rgba(191, 161, 106, 0.25);
}

.saimaSubmitBtn:hover {
    background-color: #aa8d58 !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(191, 161, 106, 0.35);
}

.saimaSubmitBtn:active {
    transform: scale(0.99);
}

.saimaSuccessMsg {
    display: none;
    background: #ecfdf5;
    border: 1px solid #a7f3d0;
    color: #065f46;
    padding: 12px;
    border-radius: 6px;
    font-size: 14px;
    text-align: center;
    margin-top: 10px;
}

/* Latest Projects Card */
.saimaProjectsWidget {
    background: #ffffff;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 22px 20px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.04);
}

.saimaProjectsHeader {
    font-size: 18px;
    font-weight: 700;
    color: #111827;
    margin: 0 0 16px 0;
    padding-bottom: 10px;
    border-bottom: 2px solid #f3f4f6;
}

.saimaProjectList {
    display: flex;
    flex-direction: column;
    gap: 14px;
}

.saimaProjectItem {
    display: flex;
    gap: 14px;
    text-decoration: none;
    color: inherit;
    align-items: center;
    padding: 10px;
    border-radius: 7px;
    border: 1px solid #f3f4f6;
    background: #ffffff;
    transition: all 0.2s ease;
}

.saimaProjectItem:hover {
    border-color: #e5e7eb;
    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    transform: translateY(-2px);
}

.saimaProjectThumb {
    width: 90px;
    height: 75px;
    border-radius: 6px;
    object-fit: cover;
    flex-shrink: 0;
    border: 1px solid #e5e7eb;
    box-shadow: 0 2px 6px rgba(0,0,0,0.06);
    background-color: #f9fafb;
}

.saimaProjectMeta {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.saimaProjectItemTitle {
    font-size: 13.5px;
    font-weight: 700;
    color: #111827;
    line-height: 1.35;
    margin-bottom: 4px;
}

.saimaProjectItemDesc {
    font-size: 12px;
    color: #6b7280;
    line-height: 1.45;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* FAQ Accordion Section (Clean section below 2-column article grid) */
.blogFaqSection {
    margin-top: 48px;
    padding-top: 40px;
    border-top: 1px solid #e5e7eb;
    max-width: 960px;
    margin-left: auto;
    margin-right: auto;
}

.blogFaqHeading {
    font-family: var(--font-display, 'Outfit', sans-serif);
    font-size: 26px;
    font-weight: 700;
    color: #BFA16A;
    margin: 0 0 20px 0;
    line-height: 1.35;
    letter-spacing: -0.2px;
}

@media (max-width: 991px) {
    .blogMainGrid {
        grid-template-columns: 1fr;
        gap: 36px;
    }
    .saimaSidebarCol {
        height: auto;
    }
    .saimaStickySidebar {
        position: static;
        top: auto;
    }
}

@media (max-width: 768px) {
    .blogDetailContainer,
    .blogDetailHeroContainer {
        padding: 0 20px;
    }
    .blogDetailTitle {
        font-size: 30px;
    }
    .blogDetailHero {
        padding: 85px 0 75px 0;
        min-height: 290px;
    }
    .blogArticleContent h1,
    .blogArticleContent h2 {
        font-size: 22px !important;
        margin-top: 22px !important;
        margin-bottom: 10px !important;
    }
    .blogArticleContent h3 {
        font-size: 18px !important;
        margin-top: 18px !important;
        margin-bottom: 8px !important;
    }
    .blogArticleContent h4 {
        font-size: 16px !important;
    }
    .blogArticleContent p,
    .blogArticleContent li,
    .blogShortContentLead {
        font-size: 14.5px !important;
        line-height: 1.6 !important;
    }
    .blogFaqHeading {
        font-size: 22px !important;
    }
}
</style>

@php
    $coverImageSrc = $blog->cover_image ? asset($blog->cover_image) : asset('/images/Saima-Island---Marsana-East-Beach---Sign---Sunset-2.jpg');
@endphp

<div class="blogDetailWrapper">
    <!-- Hero Banner with Cover Image Background -->
    <section class="blogDetailHero" style="background-image: url('{{ $coverImageSrc }}');">
        <div class="blogDetailHeroContainer">
            <h1 class="blogDetailTitle">{{ $blog->title }}</h1>
        </div>
    </section>

    <!-- Main Content Section: 2-Column Grid (Article on Left, Sticky Sidebar on Right) -->
    <main class="blogDetailBodySection">
        <div class="blogDetailContainer">
            <div class="blogMainGrid">

                <!-- Left Column: Table of Contents, Short Content & Long Content -->
                <div class="blogContentCol">

                    <!-- 1. Table of Contents (Exact Project Page Style) -->
                    <div class="saimaTocBox" id="saimaToc">
                        <div class="saimaTocHeader">
                            <span class="saimaTocTitle">Table of Contents</span>
                            <button type="button" class="saimaTocToggle" id="saimaTocToggleBtn" aria-label="Toggle Table of Contents" aria-expanded="false">
                                <span id="saimaTocToggleText">Show</span>
                                <svg id="saimaTocChevron" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m6 9 6 6 6-6"/>
                                </svg>
                            </button>
                        </div>

                        <div id="saimaTocContent">
                            <ol class="saimaTocList" id="saimaTocList">
                                <!-- Dynamically populated by JS from article headings -->
                            </ol>
                        </div>
                    </div>

                    <!-- 2. Short Content (Placed directly above 'About the Developers' / Long Content) -->
                    @if(!empty($blog->short_content))
                        <div class="blogShortContentLead" style="margin-top: 24px; margin-bottom: 6px;">
                            {!! nl2br(e($blog->short_content)) !!}
                        </div>
                    @endif

                    <!-- 3. Long Content (Full Article) -->
                    <article class="blogArticleContent">
                        {!! $blog->content !!}
                    </article>

                </div>

                <!-- Right Column: Sticky Sidebar (WhatsApp & Call Buttons, Appointment Form & Custom Searches) -->
                <aside class="saimaSidebarCol">
                    @include('partials.sidebar-form-widget', ['sbPageTitle' => $blog->title])
                </aside>

            </div>

            <!-- 4. Optional FAQs Accordion (Standardized with Home Page styling) -->
            @if(is_array($blog->faqs) && count($blog->faqs) > 0)
                <div style="margin-top: 40px; border-top: 1px solid #e2e8f0; padding-top: 20px;">
                    @include('partials.faq', [
                        'customFaqs' => $blog->faqs,
                        'customHeading' => 'Frequently Asked Questions'
                    ])
                </div>
            @endif

        </div>
    </main>

    <!-- Contact Section Below FAQ (Full Width outside restricted container) -->
    @include('partials.contact')
</div>


<script>
// Toggle FAQs
function toggleBlogFaq(el) {
    el.classList.toggle('active');
}

document.addEventListener('DOMContentLoaded', function() {
    // 1. Table of Contents Toggle Collapse/Expand
    const tocToggleBtn = document.getElementById('saimaTocToggleBtn');
    const tocContent = document.getElementById('saimaTocContent');
    const tocText = document.getElementById('saimaTocToggleText');

    if (tocToggleBtn && tocContent) {
        tocToggleBtn.addEventListener('click', function() {
            const isHidden = window.getComputedStyle(tocContent).display === 'none';
            if (isHidden) {
                tocContent.style.display = 'block';
                tocToggleBtn.classList.add('is-open');
                if (tocText) tocText.textContent = 'Hide';
                tocToggleBtn.setAttribute('aria-expanded', 'true');
            } else {
                tocContent.style.display = 'none';
                tocToggleBtn.classList.remove('is-open');
                if (tocText) tocText.textContent = 'Show';
                tocToggleBtn.setAttribute('aria-expanded', 'false');
            }
        });
    }

    // 2. Discover all article Headings & populate TOC List dynamically
    const articleBody = document.querySelector('.blogArticleContent');
    const tocBox = document.getElementById('saimaToc');
    const tocList = document.getElementById('saimaTocList');

    if (articleBody && tocList && tocBox) {
        const headings = Array.from(articleBody.querySelectorAll('h1, h2, h3, h4'));
        if (headings.length > 0) {
            tocList.innerHTML = '';
            const usedIds = {};

            headings.forEach(function(h, idx) {
                let text = h.textContent.trim();
                if (!text) return;

                let id = h.getAttribute('id');
                if (!id) {
                    id = text.toLowerCase()
                        .replace(/[^\w\s-]/g, '')
                        .trim()
                        .replace(/[\s_-]+/g, '-')
                        .replace(/^-+|-+$/g, '');
                    if (!id) id = 'heading-' + (idx + 1);
                }

                let uniqueId = id;
                let c = 1;
                while (usedIds[uniqueId]) {
                    uniqueId = id + '-' + (++c);
                }
                usedIds[uniqueId] = true;
                h.setAttribute('id', uniqueId);

                const li = document.createElement('li');
                const tag = h.tagName.toLowerCase();
                if (tag === 'h3' || tag === 'h4') {
                    li.style.paddingLeft = '18px';
                    li.style.fontSize = '15.5px';
                }

                const a = document.createElement('a');
                a.href = '#' + uniqueId;
                a.className = 'saimaTocLink';
                a.textContent = (idx + 1) + '. ' + text;

                a.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetEl = document.getElementById(uniqueId);
                    if (targetEl) {
                        targetEl.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        try {
                            window.history.pushState(null, null, '#' + uniqueId);
                        } catch (err) {}
                    }
                });

                li.appendChild(a);
                tocList.appendChild(li);
            });
        } else {
            // If no headings inside full content, provide standard section jumps or keep default
            tocBox.style.display = 'none';
        }
    }

    // 3. Appointment Form AJAX Submission
    const apptForm = document.getElementById('saimaAppointmentForm');
    const successMsg = document.getElementById('saimaFormSuccess');
    if (apptForm) {
        apptForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const btn = apptForm.querySelector('button[type="submit"]');
            const originalText = btn.textContent;
            btn.textContent = 'SUBMITTING...';
            btn.disabled = true;

            const formData = {
                name: apptForm.querySelector('input[name="name"]')?.value || '',
                phone: apptForm.querySelector('input[name="phone"]')?.value || '',
                email: apptForm.querySelector('input[name="email"]')?.value || '',
                key_requirement: apptForm.querySelector('textarea[name="comment"]')?.value || '',
                comment: apptForm.querySelector('textarea[name="comment"]')?.value || '',
                source: 'Website',
                sub_source: 'fsadvisory.pk',
                page_url: window.location.href,
                campaign_url: window.location.href,
                utm_campaign: new URLSearchParams(window.location.search).get('utm_campaign') || '',
                project: '{{ isset($blog) ? addslashes($blog->title) : "Saima" }}',
                developer: 'Modon Properties',
                community: 'Saima',
                property_type: 'Blog Inquiry',
                activity_description: 'Blog Appointment Sidebar Request'
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

            fetch('/api/leads', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(formData)
            })
            .then(res => res.json())
            .then(data => {
                btn.textContent = originalText;
                btn.disabled = false;
                if (successMsg) successMsg.style.display = 'block';
                apptForm.reset();
                setTimeout(() => {
                    if (successMsg) successMsg.style.display = 'none';
                }, 6000);
            })
            .catch(err => {
                btn.textContent = originalText;
                btn.disabled = false;
                if (successMsg) successMsg.style.display = 'block';
                apptForm.reset();
            });
        });
    }
});
</script>
@endsection
