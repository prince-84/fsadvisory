@extends('admin.layouts.app')

@section('title', 'Add City')

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
        display: flex; align-items: center; gap: 12px;
        padding: 11px 14px; border-radius: 8px; font-size: 13.5px; font-weight: 500;
        color: #475569; background: transparent; border: none;
        width: 100%; text-align: left; position: relative;
        cursor: pointer; user-select: none; transition: all 0.18s ease;
    }
    .dev-tab-btn:hover { background: #f8fafc; color: #1e293b; }
    .dev-tab-btn.is-active { background: #f0f9ff; color: #0284c7; font-weight: 600; }
    .dev-tab-btn.is-active::after {
        content: ''; position: absolute; right: -8px; top: 50%;
        transform: translateY(-50%); width: 0; height: 0;
        border-top: 8px solid transparent; border-bottom: 8px solid transparent;
        border-left: 8px solid #f0f9ff;
    }
    .dev-tab-icon {
        width: 28px; height: 28px; border-radius: 6px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; transition: all 0.18s ease;
    }
    .dev-tab-btn.is-active .dev-tab-icon {
        background: linear-gradient(135deg, #38bdf8 0%, #0284c7 100%);
        color: #ffffff; box-shadow: 0 2px 4px rgba(2,132,199,0.25);
    }
    .dev-tab-btn:not(.is-active) .dev-tab-icon { background: #f1f5f9; color: #64748b; }
    .dev-content-area { flex: 1; padding: 28px 36px 36px 36px; min-width: 0; }
    .dev-section-title { font-size: 15px; font-weight: 700; color: #1e293b; margin: 0 0 24px 0; }
    .dev-row { display: grid; grid-template-columns: 200px 1fr; align-items: center; gap: 20px; margin-bottom: 20px; }
    .dev-row.dev-row-align-top { align-items: flex-start; }
    .dev-label { font-size: 13.5px; font-weight: 600; color: #1e293b; }
    .dev-label .req { color: #ef4444; margin-left: 2px; }
    .dev-input {
        width: 100%; background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 8px; padding: 10px 14px; font-size: 13.5px;
        color: #1e293b; font-family: inherit; outline: none; transition: all 0.2s ease;
    }
    .dev-input:focus { background: #ffffff; border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.15); }
    .dev-textarea {
        width: 100%; background: #f8fafc; border: 1px solid #e2e8f0;
        border-radius: 8px; padding: 12px 14px; font-size: 13.5px;
        color: #1e293b; font-family: inherit; outline: none; resize: vertical;
        min-height: 100px; transition: all 0.2s ease;
    }
    .dev-textarea:focus { background: #ffffff; border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.15); }
    .dev-slug-wrapper {
        display: flex; align-items: center; background: #f8fafc;
        border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; transition: all 0.2s ease;
    }
    .dev-slug-wrapper:focus-within { background: #ffffff; border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.15); }
    .dev-slug-prefix {
        padding: 0 12px; color: #64748b; font-size: 13px; font-family: monospace;
        background: #f1f5f9; height: 42px; display: flex; align-items: center;
        border-right: 1px solid #e2e8f0; user-select: none;
    }
    .dev-slug-input { flex: 1; border: none !important; background: transparent !important; outline: none !important; padding: 10px 14px; font-size: 13.5px; color: #1e293b; font-family: inherit; }
    .dev-list-btn, .dev-live-btn {
        display: inline-flex; align-items: center; gap: 6px; padding: 8px 18px;
        font-size: 13px; font-weight: 600; color: #0284c7; background: #ffffff;
        border: 1px solid #bae6fd; border-radius: 6px; text-decoration: none;
        transition: all 0.18s ease; box-shadow: 0 1px 2px rgba(2,132,199,0.05);
    }
    .dev-list-btn:hover, .dev-live-btn:hover { background: #f0f9ff; border-color: #7dd3fc; color: #0369a1; }
    .dev-status-select {
        padding: 8px 14px; font-size: 13px; font-weight: 600; border-radius: 6px;
        border: 1px solid #cbd5e1; background: #ffffff; color: #1e293b;
        cursor: pointer; outline: none; transition: all 0.2s ease;
    }
    .dev-status-select:focus { border-color: #38bdf8; box-shadow: 0 0 0 3px rgba(56,189,248,0.15); }
    .dev-upload-box {
        display: flex; align-items: center; gap: 12px; background: #f8fafc;
        border: 1px dashed #cbd5e1; border-radius: 8px; padding: 10px 14px; transition: all 0.2s ease;
    }
    .dev-upload-box:hover { border-color: #38bdf8; background: #f0f9ff; }
    .note-editor.note-frame { border: 1px solid #e2e8f0 !important; border-radius: 8px !important; }
    .faq-drag-handle:active { cursor: grabbing; }
    .faq-repeater-row.drag-over-top { border-top: 2px solid #0284c7 !important; }
    .faq-repeater-row.drag-over-bottom { border-bottom: 2px solid #0284c7 !important; }
    .faq-repeater-row.is-dragging { opacity: 0.35; }
</style>
@endpush

@section('content')
<div style="padding: 24px 32px;">

    <!-- Alerts -->
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

    <!-- Top Bar -->
    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
        <div>
            <h1 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0;">Add City</h1>
            <div style="font-size: 13px; color: #8c9ba5;">Home &ndash; Manage &ndash; City</div>
        </div>
        <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
            <select name="status" id="city_status" class="dev-status-select" form="cityForm">
                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="publish" {{ old('status') === 'publish' ? 'selected' : '' }}>Publish</option>
                <option value="sold_out" {{ old('status') === 'sold_out' ? 'selected' : '' }}>Sold Out</option>
            </select>
            <a href="{{ route('admin.cities.index') }}" class="dev-list-btn">Cities List</a>
        </div>
    </div>

    <!-- Main Card -->
    <div class="dev-form-card">
        <!-- Left Sidebar Tabs -->
        <div class="dev-sidebar">
            <button type="button" class="dev-tab-btn is-active" data-tab="basic" onclick="switchCityTab('basic')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/><path d="M6 6h10"/><path d="M6 10h10"/></svg>
                </div>
                <span>Basic Details</span>
            </button>
            <button type="button" class="dev-tab-btn" data-tab="seo" onclick="switchCityTab('seo')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <span>SEO</span>
            </button>
            <button type="button" class="dev-tab-btn" data-tab="communities" onclick="switchCityTab('communities')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <span>Featured Communities</span>
            </button>
            <button type="button" class="dev-tab-btn" data-tab="faqs" onclick="switchCityTab('faqs')">
                <div class="dev-tab-icon">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                </div>
                <span>FAQs</span>
            </button>
        </div>

        <!-- Right Content -->
        <div class="dev-content-area">
            <form action="{{ route('admin.cities.store') }}" method="POST" id="cityForm" enctype="multipart/form-data">
                @csrf

                <!-- TAB 1: BASIC DETAILS -->
                <div class="dev-tab-pane" id="city_tab_pane_basic">
                    <h2 class="dev-section-title">City Details</h2>

                    <!-- Name -->
                    <div class="dev-row">
                        <label class="dev-label" for="city_name">City Name <span class="req">*</span></label>
                        <input type="text" id="city_name" name="name" required class="dev-input" value="{{ old('name') }}" placeholder="e.g. Dubai">
                    </div>

                    <!-- Slug -->
                    <div class="dev-row">
                        <label class="dev-label" for="city_slug">Slug <span class="req">*</span></label>
                        <div class="dev-slug-wrapper">
                            <span class="dev-slug-prefix">city/</span>
                            <input type="text" id="city_slug" name="slug" class="dev-slug-input" value="{{ old('slug') }}" placeholder="dubai">
                        </div>
                    </div>

                    <!-- H1 -->
                    <div class="dev-row">
                        <label class="dev-label" for="city_h1">H1</label>
                        <input type="text" id="city_h1" name="h1" class="dev-input" value="{{ old('h1') }}" placeholder="e.g. Real Estate and Communities in Dubai">
                    </div>

                    <!-- Tagline -->
                    <div class="dev-row">
                        <label class="dev-label" for="city_tagline">Tagline</label>
                        <input type="text" id="city_tagline" name="tagline" class="dev-input" value="{{ old('tagline') }}" placeholder="e.g. World-class architecture and lifestyle">
                    </div>

                    <!-- Short Content -->
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="city_short_content" style="padding-top: 10px;">Short Content</label>
                        <div style="flex: 1; min-width: 0;">
                            <textarea id="city_short_content" name="short_content" class="adm-summernote" data-height="180">{{ old('short_content') }}</textarea>
                        </div>
                    </div>

                    <!-- Full Content -->
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="city_full_content" style="padding-top: 10px;">Full Content</label>
                        <div style="flex: 1; min-width: 0;">
                            <textarea id="city_full_content" name="full_content" class="adm-summernote" data-height="350">{{ old('full_content') }}</textarea>
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="city_cover_image_file" style="padding-top: 10px;">Cover Image</label>
                        <div style="flex: 1; min-width: 0;">
                            <div class="dev-upload-box">
                                <input type="file" id="city_cover_image_file" name="cover_image_file" accept="image/*" style="font-size: 13px;" onchange="previewCityCoverFile(this)">
                            </div>
                            <div id="cityCoverPreviewContainer" style="margin-top: 8px; display: none;">
                                <img id="cityCoverPreviewImg" src="" alt="Cover Preview" style="max-height: 120px; max-width: 240px; object-fit: cover; border-radius: 8px; border: 1px solid #e2e8f0;">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 2: SEO -->
                <div class="dev-tab-pane" id="city_tab_pane_seo" style="display: none;">
                    <h2 class="dev-section-title">SEO &amp; Meta Details</h2>
                    <div class="dev-row">
                        <label class="dev-label" for="city_meta_title">Meta Title</label>
                        <input type="text" id="city_meta_title" name="meta_title" class="dev-input" value="{{ old('meta_title') }}" placeholder="Meta Title for SEO">
                    </div>
                    <div class="dev-row dev-row-align-top">
                        <label class="dev-label" for="city_meta_description" style="padding-top: 10px;">Meta Description</label>
                        <textarea id="city_meta_description" name="meta_description" class="dev-textarea" placeholder="Meta description for search engines">{{ old('meta_description') }}</textarea>
                    </div>
                    <div class="dev-row">
                        <label class="dev-label" for="city_meta_keywords">Meta Keywords</label>
                        <input type="text" id="city_meta_keywords" name="meta_keywords" class="dev-input" value="{{ old('meta_keywords') }}" placeholder="comma, separated, keywords">
                    </div>
                </div>

                <!-- TAB 3: FEATURED COMMUNITIES -->
                <div class="dev-tab-pane" id="city_tab_pane_communities" style="display: none;">
                    <div style="margin-bottom: 20px;">
                        <h2 class="dev-section-title" style="margin: 0;">Featured Communities</h2>
                    </div>

                    @php
                        $assignedComms = $assignedCommunities ?? collect();
                        $selectedCityCommIds = (array) old('featured_communities', []);
                        $selectedCityCommIds = array_map('intval', $selectedCityCommIds);
                        $unselectedCityComms = $assignedComms->whereNotIn('id', $selectedCityCommIds)->values();
                        $selectedCityComms   = $assignedComms->whereIn('id', $selectedCityCommIds)->values();
                    @endphp

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <!-- BOX 1: Available Communities -->
                        <div style="background: #f8fafc; border: 1.5px dashed #cbd5e1; border-radius: 12px; padding: 16px; display: flex; flex-direction: column;">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #e2e8f0;">
                                <div>
                                    <strong style="font-size: 13.5px; color: #1e293b; display: flex; align-items: center; gap: 6px;">
                                        Available Communities ( <span id="availableCityCommCount">{{ $unselectedCityComms->count() }}</span> )
                                    </strong>
                                </div>
                                <button type="button" onclick="selectAllCityComms()" style="background: none; border: none; font-size: 11.5px; color: #15803d; cursor: pointer; text-decoration: underline; font-weight: 600;">+ Select All</button>
                            </div>
                            <div id="box1_availableCityComms" ondragover="allowDropCityComm(event)" ondrop="dropCityCommToAvailable(event)" style="display: flex; flex-direction: column; gap: 8px; min-height: 320px; max-height: 500px; overflow-y: auto; padding: 4px;">
                                @forelse($unselectedCityComms as $comm)
                                    <div class="dual-city-comm" id="city_comm_card_{{ $comm->id }}" data-id="{{ $comm->id }}" draggable="true" ondragstart="dragCityCommStart(event)" ondragend="dragCityCommEnd(event)" style="display: flex; align-items: center; gap: 10px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 8px; padding: 9px 12px; cursor: grab; box-shadow: 0 1px 2px rgba(0,0,0,0.03); transition: all 0.15s ease;">
                                        <span style="color: #94a3b8; font-size: 14px; cursor: grab; user-select: none;">⠿</span>
                                        @if($comm->image)
                                            <img src="{{ str_starts_with($comm->image, 'http') ? $comm->image : asset(ltrim($comm->image,'/')) }}" alt="" style="width: 48px; height: 34px; object-fit: cover; border-radius: 5px; border: 1px solid #cbd5e1; flex-shrink: 0; background: #f1f5f9;">
                                        @else
                                            <div style="width: 48px; height: 34px; background: #f1f5f9; border-radius: 5px; border: 1px solid #cbd5e1; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                            </div>
                                        @endif
                                        <div style="flex: 1; min-width: 0;">
                                            <strong style="display: block; font-size: 13px; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $comm->name }}</strong>
                                        </div>
                                        <button type="button" onclick="moveCityCommToSelected({{ $comm->id }})" title="Add to featured" style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; border-radius: 6px; padding: 5px 11px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; flex-shrink: 0;">+ Add</button>
                                    </div>
                                @empty
                                    <div style="text-align: center; padding: 40px 16px; border: 2px dashed #e2e8f0; border-radius: 8px; color: #94a3b8;">
                                        <strong style="display: block; font-size: 13px; color: #475569;">No Communities Available</strong>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        <!-- BOX 2: Selected Communities -->
                        <div style="background: #ffffff; border: 1.5px solid #0284c7; border-radius: 12px; padding: 16px; display: flex; flex-direction: column; box-shadow: 0 4px 14px rgba(2,132,199,0.05);">
                            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; padding-bottom: 10px; border-bottom: 1px solid #f1f5f9;">
                                <div>
                                    <strong style="font-size: 13.5px; color: #0284c7; display: flex; align-items: center; gap: 6px;">
                                        ✓ Featured on This Page ( <span id="selectedCityCommCount">{{ $selectedCityComms->count() }}</span> )
                                    </strong>
                                </div>
                                <button type="button" onclick="clearAllCityComms()" style="background: none; border: none; font-size: 11.5px; color: #ef4444; cursor: pointer; text-decoration: underline;">Clear All</button>
                            </div>
                            <div id="box2_selectedCityComms" ondragover="allowDropCityComm(event)" ondrop="dropCityCommToSelected(event)" style="display: flex; flex-direction: column; gap: 8px; min-height: 320px; max-height: 500px; overflow-y: auto; padding: 4px; border-radius: 8px;">
                                <div id="selectedCityCommsEmptyState" style="text-align: center; padding: 60px 20px; border: 2px dashed #e2e8f0; border-radius: 8px; color: #94a3b8; {{ $selectedCityComms->isEmpty() ? '' : 'display: none;' }}">
                                    <strong style="display: block; font-size: 14px; color: #475569;">Drag Cards Here</strong>
                                </div>
                                @foreach($selectedCityComms as $comm)
                                    <div class="dual-city-comm" id="city_comm_card_{{ $comm->id }}" data-id="{{ $comm->id }}" draggable="true" ondragstart="dragCityCommStart(event)" ondragend="dragCityCommEnd(event)" style="display: flex; align-items: center; gap: 10px; background: #f0f9ff; border: 1px solid #bae6fd; border-radius: 8px; padding: 9px 12px; cursor: grab; box-shadow: 0 1px 2px rgba(0,0,0,0.03); transition: all 0.15s ease;">
                                        <span style="color: #94a3b8; font-size: 14px; cursor: grab; user-select: none;">⠿</span>
                                        @if($comm->image)
                                            <img src="{{ str_starts_with($comm->image, 'http') ? $comm->image : asset(ltrim($comm->image,'/')) }}" alt="" style="width: 48px; height: 34px; object-fit: cover; border-radius: 5px; border: 1px solid #cbd5e1; flex-shrink: 0; background: #f1f5f9;">
                                        @else
                                            <div style="width: 48px; height: 34px; background: #f1f5f9; border-radius: 5px; border: 1px solid #cbd5e1; display: flex; align-items: center; justify-content: center; color: #94a3b8; flex-shrink: 0;">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                            </div>
                                        @endif
                                        <div style="flex: 1; min-width: 0;">
                                            <strong style="display: block; font-size: 13px; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $comm->name }}</strong>
                                        </div>
                                        <button type="button" onclick="moveCityCommToAvailable({{ $comm->id }})" title="Remove" style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; border-radius: 6px; padding: 5px 11px; font-size: 12px; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 4px; flex-shrink: 0;">✕ Remove</button>
                                    </div>
                                @endforeach
                                <div id="selectedCityCommsInputsContainer"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TAB 4: FAQs -->
                <div class="dev-tab-pane" id="city_tab_pane_faqs" style="display: none;">
                    <h2 class="dev-section-title">FAQs</h2>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 20px;">
                        <div>
                            <label class="dev-label" style="display: block; margin-bottom: 6px;">FAQ Section Heading</label>
                            <input type="text" name="faq_heading" class="dev-input" value="{{ old('faq_heading', 'Frequently Asked Questions') }}" placeholder="e.g. Frequently Asked Questions">
                        </div>
                        <div>
                            <label class="dev-label" style="display: block; margin-bottom: 6px;">FAQ Subtitle</label>
                            <input type="text" name="faq_subtitle" class="dev-input" value="{{ old('faq_subtitle') }}" placeholder="e.g. Find answers below...">
                        </div>
                    </div>

                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; border-bottom: 1px solid #e5e7eb; padding-bottom: 8px;">
                        <span style="font-size: 12.5px; font-weight: 700; color: #0284c7; text-transform: uppercase; letter-spacing: 0.5px;">Questions &amp; Answers:</span>
                        <span style="font-size: 11.5px; color: #6b7280;">Drag ⇅ to reorder, ✕ to delete</span>
                    </div>

                    <div style="display: grid; grid-template-columns: 34px minmax(0, 1fr) minmax(0, 1.5fr) 34px; gap: 10px; padding: 0 6px; margin-bottom: 6px; font-size: 11px; font-weight: 700; text-transform: uppercase; color: #6b7280;" aria-hidden="true">
                        <span></span><span>Question</span><span>Answer</span><span></span>
                    </div>

                    <div id="cityFaqItemsContainer" style="display: flex; flex-direction: column; gap: 8px; margin-bottom: 12px;">
                        @php
                            $cityFaqItems = old('faqs', []);
                            if (!is_array($cityFaqItems)) $cityFaqItems = [];
                        @endphp
                        @foreach($cityFaqItems as $idx => $item)
                            <div class="faq-repeater-row" style="display: grid; grid-template-columns: 34px minmax(0, 1fr) minmax(0, 1.5fr) 34px; gap: 10px; align-items: center; background: #faf8f5; border: 1px solid #e5e7eb; border-radius: 8px; padding: 6px 10px;">
                                <div class="faq-drag-handle" draggable="true" style="display: flex; align-items: center; justify-content: center; width: 34px; height: 36px; border: 1px solid #d1d5db; background: #ffffff; border-radius: 6px; color: #0284c7; cursor: grab; user-select: none;" title="Drag to reorder">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 20V4m0 0L3 8m4-4l4 4"/><path d="M17 4v16m0 0l4-4m-4 4l-4-4"/></svg>
                                </div>
                                <input type="text" name="faqs[{{ $idx }}][question]" value="{{ $item['question'] ?? ($item['q'] ?? '') }}" class="dev-input" placeholder="Question" style="margin: 0; min-height: 36px; font-size: 13px; padding: 8px 12px;">
                                <textarea name="faqs[{{ $idx }}][answer]" class="dev-textarea" rows="1" placeholder="Answer" style="margin: 0; min-height: 36px; font-size: 13px; resize: vertical; line-height: 1.4; padding: 8px 12px;">{{ $item['answer'] ?? ($item['a'] ?? '') }}</textarea>
                                <button type="button" onclick="this.closest('.faq-repeater-row').remove(); updateCityFaqIndexes();" title="Delete" style="width: 34px; height: 36px; border: 1px solid #fecaca; background: #fef2f2; color: #b91c1c; border-radius: 6px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center;">&#10005;</button>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="addCityFaqRow()" style="padding: 6px 14px; font-size: 12.5px; font-weight: 600; cursor: pointer; border: 1.5px dashed #0284c7; color: #0284c7; background: #f0f9ff; border-radius: 8px; display: inline-flex; align-items: center; gap: 6px;">
                        + Add Row
                    </button>
                </div>

            </form>

            <!-- Save Bar -->
            <div style="position: sticky; bottom: 0; background: #ffffff; border-top: 1px solid #e2e8f0; padding: 16px 0 0 0; display: flex; justify-content: space-between; align-items: center; margin-top: 32px;">
                <div style="font-size: 13.5px; color: #64748b;">
                    Creating New City
                </div>
                <div style="display: flex; gap: 10px;">
                    <a href="{{ route('admin.cities.index') }}" style="background: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; padding: 8px 18px; border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600;">Cancel</a>
                    <button type="submit" form="cityForm" style="background: #0284c7; color: #ffffff; border: none; padding: 8px 24px; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer;">Save City</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Tab switching
    function switchCityTab(tabId) {
        document.querySelectorAll('.dev-tab-btn').forEach(btn => {
            btn.classList.toggle('is-active', btn.getAttribute('data-tab') === tabId);
        });
        document.querySelectorAll('.dev-tab-pane').forEach(pane => {
            pane.style.display = 'none';
        });
        const pane = document.getElementById('city_tab_pane_' + tabId);
        if (pane) {
            pane.style.display = 'block';
            if ((tabId === 'basic') && window.initSummernote) {
                setTimeout(() => window.initSummernote(), 100);
            }
        }
    }

    // Auto-generate slug from name
    document.getElementById('city_name')?.addEventListener('input', function() {
        const slugInput = document.getElementById('city_slug');
        if (slugInput && !slugInput.dataset.manuallyEdited) {
            slugInput.value = this.value
                .toLowerCase()
                .trim()
                .replace(/[^\w\s-]/g, '')
                .replace(/[\s_-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }
    });
    document.getElementById('city_slug')?.addEventListener('input', function() {
        this.dataset.manuallyEdited = 'true';
    });

    // Cover image preview
    function previewCityCoverFile(input) {
        if (input.files && input.files[0]) {
            const r = new FileReader();
            r.onload = e => {
                const img = document.getElementById('cityCoverPreviewImg');
                const container = document.getElementById('cityCoverPreviewContainer');
                img.src = e.target.result;
                container.style.display = 'block';
            };
            r.readAsDataURL(input.files[0]);
        }
    }

    // ===== DUAL BOX FEATURED COMMUNITIES =====
    let draggedCityComm = null;

    function dragCityCommStart(e) {
        draggedCityComm = e.currentTarget;
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/plain', e.currentTarget.getAttribute('data-id'));
        setTimeout(() => { if (draggedCityComm) draggedCityComm.style.opacity = '0.4'; }, 0);
    }

    function dragCityCommEnd(e) {
        if (e.currentTarget) e.currentTarget.style.opacity = '1';
        draggedCityComm = null;
    }

    function allowDropCityComm(e) {
        e.preventDefault();
        e.dataTransfer.dropEffect = 'move';
    }

    function dropCityCommToSelected(e) {
        e.preventDefault();
        const card = draggedCityComm;
        if (!card) return;
        const box2 = document.getElementById('box2_selectedCityComms');
        if (!box2) return;
        const targetCard = e.target.closest('.dual-city-comm');
        if (targetCard && targetCard.parentNode === box2 && targetCard !== card) {
            box2.insertBefore(card, targetCard);
        } else {
            box2.appendChild(card);
        }
        setCityCommSelectedStyle(card, card.getAttribute('data-id'));
        updateCityCommBoxState();
    }

    function dropCityCommToAvailable(e) {
        e.preventDefault();
        const card = draggedCityComm;
        if (!card) return;
        document.getElementById('box1_availableCityComms').appendChild(card);
        setCityCommAvailableStyle(card, card.getAttribute('data-id'));
        updateCityCommBoxState();
    }

    function moveCityCommToSelected(id) {
        const card = document.getElementById('city_comm_card_' + id);
        const box2 = document.getElementById('box2_selectedCityComms');
        if (!card || !box2) return;
        box2.appendChild(card);
        setCityCommSelectedStyle(card, id);
        updateCityCommBoxState();
    }

    function moveCityCommToAvailable(id) {
        const card = document.getElementById('city_comm_card_' + id);
        const box1 = document.getElementById('box1_availableCityComms');
        if (!card || !box1) return;
        box1.appendChild(card);
        setCityCommAvailableStyle(card, id);
        updateCityCommBoxState();
    }

    function selectAllCityComms() {
        const box1 = document.getElementById('box1_availableCityComms');
        const box2 = document.getElementById('box2_selectedCityComms');
        Array.from(box1.querySelectorAll('.dual-city-comm')).forEach(card => {
            box2.appendChild(card);
            setCityCommSelectedStyle(card, card.getAttribute('data-id'));
        });
        updateCityCommBoxState();
    }

    function clearAllCityComms() {
        const box1 = document.getElementById('box1_availableCityComms');
        const box2 = document.getElementById('box2_selectedCityComms');
        Array.from(box2.querySelectorAll('.dual-city-comm')).forEach(card => {
            box1.appendChild(card);
            setCityCommAvailableStyle(card, card.getAttribute('data-id'));
        });
        updateCityCommBoxState();
    }

    function setCityCommSelectedStyle(card, id) {
        card.style.background = '#f0f9ff';
        card.style.borderColor = '#bae6fd';
        const btn = card.querySelector('button');
        if (btn) {
            btn.setAttribute('onclick', `moveCityCommToAvailable(${id})`);
            btn.setAttribute('title', 'Remove');
            btn.style.background = '#fef2f2';
            btn.style.borderColor = '#fecaca';
            btn.style.color = '#dc2626';
            btn.innerHTML = '✕ Remove';
        }
    }

    function setCityCommAvailableStyle(card, id) {
        card.style.background = '#ffffff';
        card.style.borderColor = '#e2e8f0';
        const btn = card.querySelector('button');
        if (btn) {
            btn.setAttribute('onclick', `moveCityCommToSelected(${id})`);
            btn.setAttribute('title', 'Add to featured');
            btn.style.background = '#f0fdf4';
            btn.style.borderColor = '#bbf7d0';
            btn.style.color = '#15803d';
            btn.innerHTML = '+ Add';
        }
    }

    function updateCityCommBoxState() {
        const box1 = document.getElementById('box1_availableCityComms');
        const box2 = document.getElementById('box2_selectedCityComms');
        const availSpan = document.getElementById('availableCityCommCount');
        const selSpan   = document.getElementById('selectedCityCommCount');
        const emptyState = document.getElementById('selectedCityCommsEmptyState');
        const inputsContainer = document.getElementById('selectedCityCommsInputsContainer');
        if (!box1 || !box2) return;

        const availCards = box1.querySelectorAll('.dual-city-comm');
        const selCards   = box2.querySelectorAll('.dual-city-comm');
        if (availSpan) availSpan.textContent = availCards.length;
        if (selSpan) selSpan.textContent = selCards.length;
        if (emptyState) emptyState.style.display = selCards.length === 0 ? 'block' : 'none';

        if (inputsContainer) {
            inputsContainer.innerHTML = '';
            selCards.forEach(card => {
                const id = card.getAttribute('data-id');
                if (id) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'featured_communities[]';
                    input.value = id;
                    inputsContainer.appendChild(input);
                }
            });
        }
    }

    // ===== FAQ =====
    let cityFaqRowIndex = 0;

    function addCityFaqRow() {
        const container = document.getElementById('cityFaqItemsContainer');
        const idx = cityFaqRowIndex++;
        const div = document.createElement('div');
        div.className = 'faq-repeater-row';
        div.style.cssText = 'display: grid; grid-template-columns: 34px minmax(0, 1fr) minmax(0, 1.5fr) 34px; gap: 10px; align-items: center; background: #faf8f5; border: 1px solid #e5e7eb; border-radius: 8px; padding: 6px 10px;';
        div.innerHTML = `
            <div class="faq-drag-handle" draggable="true" style="display: flex; align-items: center; justify-content: center; width: 34px; height: 36px; border: 1px solid #d1d5db; background: #ffffff; border-radius: 6px; color: #0284c7; cursor: grab; user-select: none;" title="Drag to reorder">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M7 20V4m0 0L3 8m4-4l4 4"/><path d="M17 4v16m0 0l4-4m-4 4l-4-4"/></svg>
            </div>
            <input type="text" name="faqs[${idx}][question]" class="dev-input" placeholder="Question" style="margin: 0; min-height: 36px; font-size: 13px; padding: 8px 12px;">
            <textarea name="faqs[${idx}][answer]" class="dev-textarea" rows="1" placeholder="Answer" style="margin: 0; min-height: 36px; font-size: 13px; resize: vertical; line-height: 1.4; padding: 8px 12px;"></textarea>
            <button type="button" onclick="this.closest('.faq-repeater-row').remove(); updateCityFaqIndexes();" title="Delete" style="width: 34px; height: 36px; border: 1px solid #fecaca; background: #fef2f2; color: #b91c1c; border-radius: 6px; cursor: pointer; font-size: 14px; display: flex; align-items: center; justify-content: center;">&#10005;</button>
        `;
        container.appendChild(div);
        bindCityFaqDragEvents(div);
        div.querySelector('input')?.focus();
        updateCityFaqIndexes();
    }

    function updateCityFaqIndexes() {
        const rows = document.querySelectorAll('#cityFaqItemsContainer .faq-repeater-row');
        rows.forEach((row, i) => {
            row.querySelectorAll('[name]').forEach(el => {
                el.name = el.name.replace(/faqs\[\d+\]/, `faqs[${i}]`);
            });
        });
        cityFaqRowIndex = rows.length;
    }

    let draggedCityFaqRow = null;
    function bindCityFaqDragEvents(row) {
        const handle = row.querySelector('.faq-drag-handle');
        if (!handle) return;
        handle.setAttribute('draggable', 'true');
        handle.addEventListener('dragstart', e => {
            draggedCityFaqRow = row;
            row.classList.add('is-dragging');
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/plain', '');
        });
        handle.addEventListener('dragend', () => {
            if (draggedCityFaqRow) draggedCityFaqRow.classList.remove('is-dragging');
            document.querySelectorAll('.faq-repeater-row').forEach(r => r.classList.remove('drag-over-top', 'drag-over-bottom', 'is-dragging'));
            draggedCityFaqRow = null;
        });
        row.addEventListener('dragover', e => {
            if (!draggedCityFaqRow || draggedCityFaqRow === row || draggedCityFaqRow.parentNode !== row.parentNode) return;
            e.preventDefault();
            e.dataTransfer.dropEffect = 'move';
            const rect = row.getBoundingClientRect();
            if (e.clientY < rect.top + rect.height / 2) {
                row.classList.add('drag-over-top'); row.classList.remove('drag-over-bottom');
            } else {
                row.classList.add('drag-over-bottom'); row.classList.remove('drag-over-top');
            }
        });
        row.addEventListener('dragleave', () => row.classList.remove('drag-over-top', 'drag-over-bottom'));
        row.addEventListener('drop', e => {
            if (!draggedCityFaqRow || draggedCityFaqRow === row || draggedCityFaqRow.parentNode !== row.parentNode) return;
            e.preventDefault();
            row.classList.remove('drag-over-top', 'drag-over-bottom');
            const list = row.parentNode;
            const rect = row.getBoundingClientRect();
            if (e.clientY < rect.top + rect.height / 2) {
                list.insertBefore(draggedCityFaqRow, row);
            } else {
                list.insertBefore(draggedCityFaqRow, row.nextSibling);
            }
            updateCityFaqIndexes();
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        updateCityCommBoxState();
        document.querySelectorAll('#cityFaqItemsContainer .faq-repeater-row').forEach(bindCityFaqDragEvents);
    });
</script>
@endsection

