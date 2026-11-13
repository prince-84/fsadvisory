@extends('admin.layouts.app')

@section('title', 'Add Developer')

@push('styles')
<style>
    .adm-topbar { display: none !important; }
    .dev-form-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        display: flex;
        align-items: stretch;
        min-height: 620px;
        margin-top: 18px;
    }
    .dev-sidebar {
        width: 230px;
        flex-shrink: 0;
        padding: 24px 16px;
        border-right: 1px solid #f1f5f9;
        background: #ffffff;
        border-top-left-radius: 12px;
        border-bottom-left-radius: 12px;
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .dev-tab-btn {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 11px 14px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 500;
        color: #475569;
        background: transparent;
        border: none;
        width: 100%;
        text-align: left;
        position: relative;
        cursor: pointer;
        user-select: none;
        transition: all 0.18s ease;
    }
    .dev-tab-btn:hover {
        background: #f8fafc;
        color: #1e293b;
    }
    .dev-tab-btn.is-active {
        background: #f0f9ff;
        color: #0284c7;
        font-weight: 600;
    }
    .dev-tab-btn.is-active::after {
        content: '';
        position: absolute;
        right: -8px;
        top: 50%;
        transform: translateY(-50%);
        width: 0;
        height: 0;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
        border-left: 8px solid #f0f9ff;
    }
    .dev-tab-icon {
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: all 0.18s ease;
    }
    .dev-tab-btn.is-active .dev-tab-icon {
        background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
        color: #ffffff;
        box-shadow: 0 2px 4px rgba(2, 132, 199, 0.25);
    }
    .dev-tab-btn:not(.is-active) .dev-tab-icon {
        background: #f1f5f9;
        color: #64748b;
    }
    .dev-content-area {
        flex: 1;
        padding: 28px 36px 36px 36px;
        min-width: 0;
    }
    .dev-section-title {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 24px 0;
    }
    .dev-row {
        display: grid;
        grid-template-columns: 200px 1fr;
        align-items: center;
        gap: 20px;
        margin-bottom: 20px;
    }
    .dev-row.dev-row-align-top {
        align-items: flex-start;
    }
    .dev-label {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
    }
    .dev-label .req {
        color: #ef4444;
        margin-left: 2px;
    }
    .dev-input {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        transition: all 0.2s ease;
    }
    .dev-input:focus {
        background: #ffffff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
    }
    .dev-textarea {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 12px 14px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: inherit;
        outline: none;
        resize: vertical;
        min-height: 100px;
        transition: all 0.2s ease;
    }
    .dev-textarea:focus {
        background: #ffffff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
    }
    .dev-slug-wrapper {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.2s ease;
    }
    .dev-slug-wrapper:focus-within {
        background: #ffffff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
    }
    .dev-slug-prefix {
        padding: 0 12px;
        color: #64748b;
        font-size: 13px;
        font-family: monospace;
        background: #f1f5f9;
        height: 42px;
        display: flex;
        align-items: center;
        border-right: 1px solid #e2e8f0;
        user-select: none;
    }
    .dev-slug-input {
        flex: 1;
        border: none !important;
        background: transparent !important;
        outline: none !important;
        padding: 10px 14px;
        font-size: 13.5px;
        color: #1e293b;
        font-family: inherit;
    }
    .dev-list-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 600;
        color: #0284c7;
        background: #ffffff;
        border: 1px solid #bae6fd;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.18s ease;
        box-shadow: 0 1px 2px rgba(2, 132, 199, 0.05);
    }
    .dev-list-btn:hover {
        background: #f0f9ff;
        border-color: #7dd3fc;
        color: #0369a1;
    }
    .dev-status-select {
        padding: 8px 14px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 6px;
        border: 1px solid #cbd5e1;
        background: #ffffff;
        color: #1e293b;
        cursor: pointer;
        outline: none;
        transition: all 0.2s ease;
    }
    .dev-status-select:focus {
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.15);
    }
    .dev-upload-box {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
        padding: 10px 14px;
        transition: all 0.2s ease;
    }
    .dev-upload-box:hover {
        border-color: #38bdf8;
        background: #f0f9ff;
    }
    .dev-faq-card {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 16px 18px;
        margin-bottom: 14px;
        position: relative;
    }
    .note-editor.note-frame {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        overflow: hidden;
    }
</style>
@endpush

@section('content')
<div style="padding: 24px 32px;">
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if(isset($errors) && $errors->any())
        <div style="background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header Section with Developers List & Status Dropdown -->
    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
        <div>
            <h1 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0; font-family: var(--font-display, 'Outfit', sans-serif); letter-spacing: -0.01em;">Add Developer</h1>
            <div style="font-size: 13px; color: #8c9ba5; font-weight: 400;">Home &ndash; Manage &ndash; Developer</div>
        </div>
        <div style="display: flex; align-items: center; gap: 12px;">
            <!-- Status dropdown (by default Draft) -->
            <select name="status" id="dev_status" class="dev-status-select" form="developerForm">
                <option value="draft" selected>Draft</option>
                <option value="publish">Publish</option>
            </select>

            <a href="{{ route('admin.developers.index') }}" class="dev-list-btn">
                Developers List
            </a>
        </div>
    </div>

    <!-- Main Card Container -->
    <div class="dev-form-card">
        <!-- Left Sidebar / Vertical Tabs (Matching Image 3) -->
        <div class="dev-sidebar">
            <!-- 1. Basic Details -->
            <button type="button" class="dev-tab-btn is-active" data-tab="basic" onclick="switchDevTab('basic')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
                </div>
                <span>Basic Details</span>
            </button>

            <!-- 2. SEO -->
            <button type="button" class="dev-tab-btn" data-tab="seo" onclick="switchDevTab('seo')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <span>SEO</span>
            </button>

            <!-- 3. Featured Projects -->
            <button type="button" class="dev-tab-btn" data-tab="projects" onclick="switchDevTab('projects')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/></svg>
                </div>
                <span>Featured Projects</span>
            </button>

            <!-- 4. FAQs (Renamed from Developer Detail L2) -->
            <button type="button" class="dev-tab-btn" data-tab="faqs" onclick="switchDevTab('faqs')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <span>FAQs</span>
            </button>
        </div>

        <!-- Right Content Area -->
        <div class="dev-content-area">
            <form action="{{ route('admin.developers.store') }}" method="POST" id="developerForm" enctype="multipart/form-data">
                @csrf

                <!-- TAB 1: BASIC DETAILS (Pattern: Name -> Slug -> H1 -> Tagline -> Short Content -> Long Content -> Cover Image -> Developer Logo) -->
                <div class="dev-tab-pane" id="tab_pane_basic">
                    <h2 class="dev-section-title">Developer Details</h2>

                    <!-- 1. Developer Name -->
                    <div class="dev-row">
                        <label class="dev-label" for="dev_name">Developer Name <span class="req">*</span></label>
                        <input type="text" id="dev_name" name="name" required class="dev-input" value="{{ old('name') }}" placeholder="" oninput="autoGenerateSlug(this.value)">
                    </div>

                    <!-- 2. Slug -->
                    <div class="dev-row">
                        <label class="dev-label" for="dev_slug">Slug <span class="req">*</span></label>
                        <div class="dev-slug-wrapper">
                            <span class="dev-slug-prefix">developer/</span>
                            <input type="text" id="dev_slug" name="slug" required class="dev-slug-input" value="{{ old('slug') }}" placeholder="">
                        </div>
                    </div>

                    <!-- 3. H1 -->
                    <div class="dev-row">
                        <label class="dev-label" for="dev_h1">H1</label>
                        <input type="text" id="dev_h1" name="h1" class="dev-input" value="{{ old('h1') }}" placeholder="">
                    </div>

                    <!-- 4. Tagline -->
                    <div class="dev-row">
                        <label class="dev-label" for="dev_tagline">Tagline</label>
                        <input type="text" id="dev_tagline" name="tagline" class="dev-input" value="{{ old('tagline') }}" placeholder="">
                    </div>

                    <!-- 5. Short Content (Summernote Editor with H1-H6, images, tables, bullets, links) -->
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="dev_short_content" style="padding-top: 10px;">Short Content</label>
                        <div style="flex: 1; min-width: 0;">
                            <textarea id="dev_short_content" name="short_content" class="adm-summernote" data-height="180">{{ old('short_content') }}</textarea>
                        </div>
                    </div>

                    <!-- 6. Long Content (Full Content Summernote Editor with H1-H6) -->
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="dev_full_content" style="padding-top: 10px;">Full Content</label>
                        <div style="flex: 1; min-width: 0;">
                            <textarea id="dev_full_content" name="full_content" class="adm-summernote" data-height="350">{{ old('full_content') }}</textarea>
                        </div>
                    </div>

                    <!-- 7. Cover Image (Only file chooser) -->
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="dev_cover_image_file" style="padding-top: 10px;">Cover Image</label>
                        <div style="flex: 1; min-width: 0;">
                            <div class="dev-upload-box">
                                <input type="file" id="dev_cover_image_file" name="cover_image_file" accept="image/*" style="font-size: 13px;" onchange="previewCoverFile(this)">
                            </div>
                            <div id="coverPreviewContainer" style="margin-top: 8px; display: none;">
                                <img id="coverPreviewImg" src="" alt="Cover Preview" style="max-height: 120px; max-width: 240px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            </div>
                        </div>
                    </div>

                    <!-- 8. Developer Logo (SVG only; file chooser only) -->
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="dev_logo_file" style="padding-top: 10px;">Developer Logo (SVG)</label>
                        <div style="flex: 1; min-width: 0;">
                            <div class="dev-upload-box">
                                <input type="file" id="dev_logo_file" name="logo_file" accept=".svg,image/svg+xml" style="font-size: 13px;" onchange="previewLogoFile(this)">
                            </div>
                            <div id="logoPreviewContainer" style="margin-top: 8px; display: none;">
                                <img id="logoPreviewImg" src="" alt="Logo Preview" style="max-height: 50px; max-width: 180px; object-fit: contain; padding: 4px; border: 1px solid #e2e8f0; border-radius: 6px; background: #ffffff;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: SEO -->
                <div class="dev-tab-pane" id="tab_pane_seo" style="display: none;">
                    <h2 class="dev-section-title">SEO &amp; Meta Details</h2>

                    <div class="dev-row">
                        <label class="dev-label" for="dev_meta_title">Meta Title</label>
                        <input type="text" id="dev_meta_title" name="meta_title" class="dev-input" value="{{ old('meta_title') }}" placeholder="">
                    </div>

                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="dev_meta_description" style="padding-top: 10px;">Meta Description</label>
                        <textarea id="dev_meta_description" name="meta_description" class="dev-textarea" placeholder="">{{ old('meta_description') }}</textarea>
                    </div>

                    <div class="dev-row">
                        <label class="dev-label" for="dev_meta_keywords">Meta Keywords</label>
                        <input type="text" id="dev_meta_keywords" name="meta_keywords" class="dev-input" value="{{ old('meta_keywords') }}" placeholder="">
                    </div>
                </div>

                <!-- TAB 3: FEATURED PROJECTS (Dual Box matching Image 2: Available on Left, Selected on Right) -->
                <div class="dev-tab-pane" id="tab_pane_projects" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <h2 class="dev-section-title" style="margin: 0 0 6px 0;">Featured Projects</h2>
                        <p style="font-size: 13px; color: #64748b; margin: 0;">Projects assigned to this developer in project card settings. Add projects to display them on this developer's page.</p>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        
                        <!-- BOX 1: Available Property Cards -->
                        <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 16px; display: flex; flex-direction: column;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                                <div>
                                    <strong style="font-size: 13.5px; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                                        📁 Available Property Cards ( <span id="availableDevCount">0</span> )
                                    </strong>
                                    <span style="font-size: 11.5px; color: #64748b;">Cards assigned to this developer in project settings</span>
                                </div>
                                <span style="font-size: 11.5px; color: #94a3b8; font-weight: 600;">+ Select All</span>
                            </div>

                            <div style="text-align: center; padding: 80px 20px; border: 2px dashed #e2e8f0; border-radius: 8px; color: #64748b;">
                                <div style="width: 44px; height: 44px; margin: 0 auto 12px; border-radius: 10px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                </div>
                                <strong style="display: block; font-size: 14px; color: #1e293b; margin-bottom: 4px;">Pehle Developer Save Karein</strong>
                                <span style="font-size: 12px; color: #64748b;">Developer create karne ke baad project card settings me is developer ko select karein. Phir wo cards yahan Available Cards me show honge.</span>
                            </div>
                        </div>

                        <!-- BOX 2: Selected Cards for This Page -->
                        <div style="background: #ffffff; border: 1.5px solid #1a4731; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; box-shadow: 0 4px 14px rgba(26, 71, 49, 0.05);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9;">
                                <div>
                                    <strong style="font-size: 13.5px; color: #1a4731; display: flex; align-items: center; gap: 6px;">
                                        ✓ Selected Cards for This Page ( <span id="selectedDevCount">0</span> )
                                    </strong>
                                    <span style="font-size: 11.5px; color: #64748b;">Cards displayed on this page</span>
                                </div>
                                <span style="font-size: 11.5px; color: #94a3b8;">Clear All</span>
                            </div>

                            <div style="text-align: center; padding: 80px 20px; border: 2px dashed #e2e8f0; border-radius: 8px; color: #94a3b8;">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#94a3b8" stroke-width="1.8" style="margin: 0 auto 10px; display: block;"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>
                                <strong style="display: block; font-size: 14px; color: #475569; margin-bottom: 4px;">Drag Cards Here</strong>
                                <span style="font-size: 12px; color: #94a3b8;">Drag cards from the available box and drop them here</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: FAQs (Button below the items as requested) -->
                <div class="dev-tab-pane" id="tab_pane_faqs" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <h2 class="dev-section-title" style="margin: 0 0 4px 0;">Frequently Asked Questions (FAQs)</h2>
                        <div style="font-size: 13px; color: #64748b;">Add FAQs related to this developer and their projects.</div>
                    </div>

                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 18px 20px; margin-bottom: 22px;">
                        <div style="margin-bottom: 14px;">
                            <label class="dev-label" for="faq_heading">FAQ Heading</label>
                            <input type="text" name="faq_heading" id="faq_heading" value="{{ old('faq_heading', 'Frequently Asked Questions') }}" class="dev-input" placeholder="e.g. Frequently Asked Questions">
                        </div>
                        <div>
                            <label class="dev-label" for="faq_subtitle">FAQ Subtitle</label>
                            <input type="text" name="faq_subtitle" id="faq_subtitle" value="{{ old('faq_subtitle', '') }}" class="dev-input" placeholder="e.g. Got questions about this developer? Find helpful answers below.">
                        </div>
                    </div>

                    <div id="faqItemsContainer">
                        <!-- Populated by JavaScript or left empty initially -->
                    </div>

                    <!-- Add FAQ Button BELOW the items -->
                    <div style="margin-top: 14px;">
                        <button type="button" class="adm-btn" onclick="addFaqItem()" style="background: #f0f9ff; color: #0284c7; border: 1px solid #bae6fd; padding: 8px 16px; font-size: 13px; font-weight: 600; border-radius: 6px; cursor: pointer; display: inline-flex; align-items: center; gap: 6px;">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M12 5v14M5 12h14"/></svg>
                            + Add FAQ Item
                        </button>
                    </div>
                </div>

                <!-- Save Action Button -->
                <div class="dev-row" style="margin-top: 32px;">
                    <div></div>
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <button type="submit" class="adm-btn" style="background: #1a4731; color: #ffffff; padding: 10px 26px; font-size: 13.5px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; box-shadow: 0 2px 4px rgba(26,71,49,0.2);">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                            Save Developer
                        </button>
                        <a href="{{ route('admin.developers.index') }}" style="padding: 10px 20px; font-size: 13.5px; font-weight: 600; color: #64748b; text-decoration: none; border-radius: 8px; background: #f1f5f9;">
                            Cancel
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let slugTouched = false;

    document.getElementById('dev_slug').addEventListener('input', function() {
        slugTouched = true;
    });

    function autoGenerateSlug(name) {
        if (!slugTouched) {
            const slug = name.toString().toLowerCase().trim()
                .replace(/&/g, '-and-')
                .replace(/[\s\W-]+/g, '-')
                .replace(/^-+|-+$/g, '');
            document.getElementById('dev_slug').value = slug;
        }
    }

    function switchDevTab(tabId) {
        document.querySelectorAll('.dev-tab-btn').forEach(btn => {
            btn.classList.remove('is-active');
        });
        const activeBtn = document.querySelector(`.dev-tab-btn[data-tab="${tabId}"]`);
        if (activeBtn) activeBtn.classList.add('is-active');

        document.querySelectorAll('.dev-tab-pane').forEach(pane => {
            pane.style.display = 'none';
        });
        const activePane = document.getElementById(`tab_pane_${tabId}`);
        if (activePane) activePane.style.display = 'block';

        if (window.initSummernote) {
            window.initSummernote();
        }
    }

    function previewLogoFile(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (!file.name.toLowerCase().endsWith('.svg') && file.type !== 'image/svg+xml') {
                alert('Only .svg files are allowed for Developer Logo.');
                input.value = '';
                document.getElementById('logoPreviewContainer').style.display = 'none';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('logoPreviewImg').src = e.target.result;
                document.getElementById('logoPreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }

    function previewCoverFile(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('coverPreviewImg').src = e.target.result;
                document.getElementById('coverPreviewContainer').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    let faqIndex = 0;
    function addFaqItem(q = '', a = '') {
        const container = document.getElementById('faqItemsContainer');
        const div = document.createElement('div');
        div.className = 'dev-faq-card';
        div.innerHTML = `
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <span style="font-size: 12.5px; font-weight: 700; color: #475569;">FAQ Item</span>
                <button type="button" onclick="this.closest('.dev-faq-card').remove()" style="background: none; border: none; color: #ef4444; font-size: 12px; font-weight: 600; cursor: pointer;">Remove</button>
            </div>
            <div style="margin-bottom: 10px;">
                <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Question</label>
                <input type="text" name="faqs[${faqIndex}][question]" value="${q.replace(/"/g, '&quot;')}" class="dev-input" placeholder="">
            </div>
            <div>
                <label style="display: block; font-size: 12px; font-weight: 600; color: #475569; margin-bottom: 4px;">Answer</label>
                <textarea name="faqs[${faqIndex}][answer]" rows="3" class="dev-textarea" placeholder="">${a}</textarea>
            </div>
        `;
        container.appendChild(div);
        faqIndex++;
    }
</script>
@endpush
