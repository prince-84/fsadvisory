<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') · Saima Admin</title>
    <meta name="description" content="Saima admin panel for managing website content, table of contents and leads.">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ file_exists(public_path('favicon.png')) ? filemtime(public_path('favicon.png')) : time() }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('favicon.png') }}?v={{ file_exists(public_path('favicon.png')) ? filemtime(public_path('favicon.png')) : time() }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v={{ file_exists(public_path('favicon.ico')) ? filemtime(public_path('favicon.ico')) : time() }}">
    <link rel="apple-touch-icon" href="{{ asset('favicon.png') }}?v={{ file_exists(public_path('favicon.png')) ? filemtime(public_path('favicon.png')) : time() }}">
    <script>
        if (!sessionStorage.getItem('saima_favicon_v2')) {
            fetch('{{ asset("favicon.ico") }}', { cache: 'reload', credentials: 'same-origin' }).catch(function(){});
            fetch('{{ asset("favicon.png") }}', { cache: 'reload', credentials: 'same-origin' }).catch(function(){});
            sessionStorage.setItem('saima_favicon_v2', '1');
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
    <!-- Summernote Lite WYSIWYG Editor Styles -->
    <link rel="stylesheet" href="{{ asset('vendor/summernote/summernote-lite.min.css') }}">
    <style>
        /* Summernote Clean Theme Overrides for Saima Admin */
        .note-editor.note-frame {
            border: 1px solid #d1d5db !important;
            border-radius: 8px !important;
            overflow: visible !important;
            background: #ffffff;
            font-family: inherit;
        }
        .note-editor.note-frame.codeview .note-editing-area .note-codable {
            background-color: #1f2937;
            color: #f3f4f6;
            font-family: monospace;
            padding: 12px;
        }
        .note-toolbar {
            background: #faf8f5 !important;
            border-bottom: 1px solid #e5e7eb !important;
            padding: 6px 10px !important;
            position: relative !important;
            z-index: 25 !important;
            overflow: visible !important;
        }
        .note-dropdown-menu, .note-editor .dropdown-menu {
            max-height: 380px !important;
            overflow-y: auto !important;
            z-index: 99999 !important;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            background: #ffffff !important;
        }
        .note-dropdown-menu .dropdown-item, .note-dropdown-menu a {
            padding: 8px 14px !important;
            font-size: 13px !important;
            color: #1e293b !important;
            display: block !important;
            text-decoration: none !important;
        }
        .note-dropdown-menu .dropdown-item:hover, .note-dropdown-menu a:hover {
            background-color: #f1f5f9 !important;
            color: #0284c7 !important;
        }
        .note-btn {
            border: 1px solid #e5e7eb !important;
            background: #ffffff !important;
            border-radius: 4px !important;
            padding: 4px 8px !important;
            font-size: 12px !important;
            color: #374151 !important;
        }
        .note-btn:hover, .note-btn.active {
            background: #ede8e1 !important;
            color: #1a4731 !important;
            border-color: #d6cbbe !important;
        }
        .note-editable {
            font-family: inherit !important;
            font-size: 14px !important;
            line-height: 1.7 !important;
            color: #1f2937 !important;
            padding: 14px !important;
            background: #ffffff !important;
        }
        .note-editable h1, .note-editable h2, .note-editable h3, .note-editable h4, .note-editable h5, .note-editable h6 {
            color: #111827;
            margin-top: 0.5em;
            margin-bottom: 0.3em;
        }
        .note-editable h1 {
            font-size: 28px !important;
            font-weight: 800 !important;
            color: #0f172a !important;
            margin-top: 20px !important;
            margin-bottom: 12px !important;
            line-height: 1.25 !important;
        }
        .note-editable h2 {
            font-size: 24px !important;
            font-weight: 700 !important;
            color: #0f172a !important;
            margin-top: 18px !important;
            margin-bottom: 10px !important;
            line-height: 1.3 !important;
        }
        .note-editable h3 {
            font-size: 20px !important;
            font-weight: 600 !important;
            color: #1e293b !important;
            margin-top: 14px !important;
            margin-bottom: 8px !important;
            line-height: 1.35 !important;
        }
        .note-editable h4 {
            font-size: 17px !important;
            font-weight: 600 !important;
            color: #334155 !important;
            margin-top: 12px !important;
            margin-bottom: 6px !important;
            line-height: 1.4 !important;
        }
        .note-editable h5 {
            font-size: 15px !important;
            font-weight: 600 !important;
            color: #475569 !important;
            margin-top: 10px !important;
            margin-bottom: 5px !important;
            line-height: 1.4 !important;
        }
        .note-editable h6 {
            font-size: 13px !important;
            font-weight: 600 !important;
            color: #64748b !important;
            text-transform: uppercase !important;
            margin-top: 8px !important;
            margin-bottom: 4px !important;
            line-height: 1.4 !important;
        }
        .note-editable table {
            width: 100% !important;
            border-collapse: collapse !important;
            margin: 12px 0 !important;
        }
        .note-editable table th,
        .note-editable table td {
            border: 1px solid #cbd5e1 !important;
            padding: 8px 12px !important;
            text-align: left !important;
        }
        .note-editable ul {
            list-style-type: disc !important;
            padding-left: 24px !important;
            margin: 10px 0 !important;
        }
        .note-editable ol {
            list-style-type: decimal !important;
            padding-left: 24px !important;
            margin: 10px 0 !important;
        }
        .note-editable li {
            margin-bottom: 4px !important;
        }
        .note-editable a {
            color: #0284c7 !important;
            text-decoration: underline !important;
        }
        .note-editable img {
            max-width: 100% !important;
            height: auto !important;
            border-radius: 6px !important;
            margin: 10px 0 !important;
        }
        .note-editable p {
            margin-bottom: 0.75em;
        }

        /* Image 1 Exact Site Settings Styling */
        .site-settings-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 12px 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #5d5fef !important;
        }
        .site-settings-header svg {
            stroke: #5d5fef;
            opacity: 0.9;
        }
        .adm-nav-link.site-settings-link {
            font-size: 13.5px;
            font-weight: 500;
            color: #374151;
            padding: 11px 14px;
            border-radius: 12px;
            margin-bottom: 4px;
            transition: all 0.2s ease;
        }
        .adm-nav-link.site-settings-link svg {
            stroke: #6b7280;
            width: 19px;
            height: 19px;
        }
        .adm-nav-link.site-settings-link:hover {
            background: #f3f4f6;
            color: #111827;
        }
        .adm-nav-link.site-settings-link.is-active {
            background: #6366f1 !important;
            color: #ffffff !important;
            font-weight: 600;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(99, 102, 241, 0.35);
        }
        .adm-nav-link.site-settings-link.is-active::before {
            display: none !important;
        }
        .adm-nav-link.site-settings-link.is-active svg {
            stroke: #ffffff !important;
            opacity: 1;
        }

        /* CMS Sidebar Complete Solid White Background & Thin Scrollbar (Patla Scrollbar) */
        .adm-sidebar {
            background: #ffffff !important;
            background-color: #ffffff !important;
            height: 100vh !important;
            max-height: 100vh !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            position: sticky !important;
            top: 0 !important;
            scrollbar-width: thin !important;
            scrollbar-color: #cbd5e1 #ffffff !important;
        }
        .adm-sidebar::-webkit-scrollbar {
            width: 4px !important;
        }
        .adm-sidebar::-webkit-scrollbar-track {
            background: #ffffff !important;
        }
        .adm-sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1 !important;
            border-radius: 99px !important;
        }
        .adm-sidebar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8 !important;
        }
        .adm-sidebar-foot {
            background: #ffffff !important;
            background-color: #ffffff !important;
            flex-shrink: 0 !important;
            padding-bottom: 24px !important;
        }
        .adm-sidebar-foot .adm-user {
            background: #f8fafc !important;
            border: 1px solid #e2e8f0 !important;
        }
    </style>
    @stack('styles')
</head>
<body>
@php
    $adminUser = auth()->user();
@endphp
<div class="adm-shell" id="admShell">
    <aside class="adm-sidebar" id="admSidebar" aria-label="Admin navigation">
        <a href="{{ route('admin.dashboard') }}" class="adm-brand" id="admBrandLink">
            <div class="adm-brand-mark" style="padding: 4px; display: flex; align-items: center; justify-content: center;">
                <img src="{{ asset('favicon.png') }}?v={{ file_exists(public_path('favicon.png')) ? filemtime(public_path('favicon.png')) : time() }}" alt="Saima" style="width: 22px; height: 22px; object-fit: contain;">
            </div>
            <div class="adm-brand-text">
                <strong>CMS</strong>
            </div>
        </a>

        <div class="adm-nav-label">Overview</div>
        <a href="{{ route('admin.dashboard') }}" id="navDashboard" class="adm-nav-link {{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
            @include('admin.partials.icon', ['name' => 'grid']) Dashboard
        </a>

        <div class="adm-nav-label">Content</div>
        @if($adminUser->hasPermission('pages'))
            @php
                $isPagesActive = request()->routeIs('admin.pages.*');
                $isProjectsActive = request()->routeIs('admin.projects.*');
                $isCitiesActive = request()->routeIs('admin.cities.*');
                $isCommunitiesActive = request()->routeIs('admin.communities.*');
                $isDevelopersActive = request()->routeIs('admin.developers.*');
                $isAmenitiesActive = request()->routeIs('admin.amenities.*');
                $isBlogsActive = request()->routeIs('admin.blogs.*');
            @endphp
            <a href="{{ route('admin.pages.index') }}" id="navPages" class="adm-nav-link {{ $isPagesActive ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'file']) Pages
            </a>
            <a href="{{ route('admin.projects.index') }}" id="navProjects" class="adm-nav-link {{ $isProjectsActive ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'building']) Projects
            </a>
            <a href="{{ route('admin.cities.index') }}" id="navCities" class="adm-nav-link {{ $isCitiesActive ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'map-pin']) Cities
            </a>
            <a href="{{ route('admin.communities.index') }}" id="navCommunities" class="adm-nav-link {{ $isCommunitiesActive ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'compass']) Neighbourhood/Community
            </a>
            <a href="{{ route('admin.developers.index') }}" id="navDevelopers" class="adm-nav-link {{ $isDevelopersActive ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'developer']) Developer
            </a>
            <a href="{{ route('admin.amenities.index') }}" id="navAmenities" class="adm-nav-link {{ $isAmenitiesActive ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'amenities', 'size' => 16]) Amenities
            </a>
            <a href="{{ route('admin.blogs.index') }}" id="navBlogs" class="adm-nav-link {{ $isBlogsActive ? 'is-active' : '' }}">
                @include('admin.partials.icon', ['name' => 'book']) Blog
            </a>
        @endif


        {{-- SITE SETTINGS (Matching Image 1) --}}
        @if($adminUser->hasPermission('seo') || $adminUser->hasPermission('footer') || $adminUser->hasPermission('users') || $adminUser->hasPermission('audits'))
            <div class="site-settings-header">
                <span>SITE SETTINGS</span>
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="18 15 12 9 6 15"/></svg>
            </div>

            @if($adminUser->hasPermission('seo'))
                <a href="{{ route('admin.seo.index') }}" id="navSeo" class="adm-nav-link site-settings-link {{ request()->routeIs('admin.seo.*') ? 'is-active' : '' }}">
                    @include('admin.partials.icon', ['name' => 'globe', 'size' => 19]) Global SEO & Indexing
                </a>
            @endif

            @if($adminUser->hasPermission('footer'))
                <a href="{{ route('admin.footer.index') }}" id="navFooter" class="adm-nav-link site-settings-link {{ request()->routeIs('admin.footer.*') ? 'is-active' : '' }}">
                    @include('admin.partials.icon', ['name' => 'panels', 'size' => 19]) Footer & Newsletter
                </a>
            @endif

            @if($adminUser->hasPermission('users'))
                <a href="{{ route('admin.users.index') }}" id="navUsers" class="adm-nav-link site-settings-link {{ request()->routeIs('admin.users.*') ? 'is-active' : '' }}">
                    @include('admin.partials.icon', ['name' => 'users', 'size' => 19]) Users & Permissions
                </a>
            @endif

            @if($adminUser->hasPermission('audits'))
                <a href="{{ route('admin.audits.index') }}" id="navAudits" class="adm-nav-link site-settings-link {{ request()->routeIs('admin.audits.*') ? 'is-active' : '' }}">
                    @include('admin.partials.icon', ['name' => 'shield', 'size' => 19]) Audit Logs
                </a>
            @endif
        @endif

        <div class="adm-sidebar-foot">
            <a href="{{ url('/') }}" target="_blank" rel="noopener" class="adm-nav-link" id="navViewSite">
                @include('admin.partials.icon', ['name' => 'globe']) View Website
            </a>
            <div class="adm-user">
                <div class="adm-avatar">{{ strtoupper(substr($adminUser->name ?? 'A', 0, 1)) }}</div>
                <div class="adm-user-info">
                    <strong>{{ $adminUser->name }}</strong>
                    <span>{{ $adminUser->email }}</span>
                </div>
            </div>
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="adm-btn adm-btn-ghost adm-btn-block" id="logoutBtn">
                    @include('admin.partials.icon', ['name' => 'logout']) Sign out
                </button>
            </form>
        </div>
    </aside>

    <main class="adm-main">
        <div class="adm-topbar">
            <div>
                <button type="button" class="adm-btn adm-btn-ghost adm-btn-sm adm-mobile-toggle" id="admNavToggle" aria-label="Open navigation" style="margin-bottom:12px">
                    @include('admin.partials.icon', ['name' => 'menu']) Menu
                </button>
                <div class="adm-eyebrow">@yield('eyebrow', 'Saima')</div>
                <h1 class="adm-title">@yield('heading')</h1>
                @hasSection('subheading')
                    <p class="adm-subtitle">@yield('subheading')</p>
                @endif
            </div>
            <div class="adm-actions">@yield('actions')</div>
        </div>

        @if(session('success'))
            <div class="adm-alert adm-alert-success" role="status">
                @include('admin.partials.icon', ['name' => 'check'])
                <div>{{ session('success') }}</div>
                <button type="button" class="adm-alert-close" aria-label="Dismiss" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if(session('error'))
            <div class="adm-alert adm-alert-error" role="alert">
                @include('admin.partials.icon', ['name' => 'alert'])
                <div>{{ session('error') }}</div>
                <button type="button" class="adm-alert-close" aria-label="Dismiss" onclick="this.parentElement.remove()">×</button>
            </div>
        @endif
        @if($errors->any())
            <div class="adm-alert adm-alert-error" role="alert">
                @include('admin.partials.icon', ['name' => 'alert'])
                <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    // Mobile navigation
    document.getElementById('admNavToggle')?.addEventListener('click', (e) => {
        e.stopPropagation();
        document.getElementById('admShell').classList.toggle('is-nav-open');
    });
    document.addEventListener('click', (e) => {
        const shell = document.getElementById('admShell');
        if (shell.classList.contains('is-nav-open') && !e.target.closest('#admSidebar')) {
            shell.classList.remove('is-nav-open');
        }
    });
    // Confirm destructive actions
    document.querySelectorAll('form[data-confirm]').forEach((form) => {
        form.addEventListener('submit', (e) => {
            if (!confirm(form.dataset.confirm)) e.preventDefault();
        });
    });
    // Auto-dismiss success alerts
    setTimeout(() => document.querySelectorAll('.adm-alert-success').forEach((el) => {
        el.style.transition = 'opacity .4s'; el.style.opacity = '0'; setTimeout(() => el.remove(), 400);
    }), 6000);
</script>

<style>
    /* Prevent Summernote modal backdrop from freezing or greying out the page */
    .note-modal-backdrop {
        display: none !important;
        pointer-events: none !important;
        visibility: hidden !important;
        opacity: 0 !important;
        width: 0 !important;
        height: 0 !important;
    }

    /* Elevate active editor and its toolbar so dropdowns float on top of subsequent editors */
    .note-editor {
        position: relative !important;
        z-index: 10 !important;
    }
    .note-editor:focus-within,
    .note-editor:has(.note-btn-group.open),
    .note-editor:has(.note-btn-group.show),
    .note-editor:has(.note-dropdown-menu.show),
    .note-editor:has(.note-dropdown-menu[style*="display: block"]) {
        z-index: 9999 !important;
    }
    .note-toolbar {
        position: relative !important;
        z-index: 20 !important;
    }
    .note-btn-group.open,
    .note-btn-group.show {
        position: relative !important;
        z-index: 99999 !important;
    }

    /* Summernote Style Dropdown - compact, clean list matching user's reference (Image 1) */
    .note-dropdown-menu.note-check,
    .note-dropdown-menu {
        z-index: 999999 !important;
        max-height: none !important;
        overflow-y: visible !important;
        min-width: 135px !important;
        width: auto !important;
        padding: 4px 3px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        box-shadow: 0 12px 28px -4px rgba(0, 0, 0, 0.15), 0 8px 10px -6px rgba(0, 0, 0, 0.06) !important;
        background: #ffffff !important;
    }

    .note-dropdown-menu .dropdown-item,
    .note-dropdown-menu a {
        display: block !important;
        padding: 2px 10px !important;
        margin: 0 !important;
        text-decoration: none !important;
        color: #1e293b !important;
        border-radius: 4px !important;
        line-height: 1.2 !important;
        background: transparent !important;
        transition: background-color 0.15s ease !important;
    }

    .note-dropdown-menu .dropdown-item:hover,
    .note-dropdown-menu a:hover {
        background-color: #f1f5f9 !important;
    }

    .note-dropdown-menu p,
    .note-dropdown-menu .dropdown-item p {
        font-size: 14px !important;
        font-weight: 400 !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.25 !important;
        color: #1e293b !important;
    }

    .note-dropdown-menu blockquote,
    .note-dropdown-menu .dropdown-item blockquote {
        font-size: 13px !important;
        font-style: italic !important;
        margin: 0 !important;
        padding: 1px 0 1px 6px !important;
        border-left: 2px solid #cbd5e1 !important;
        line-height: 1.25 !important;
        color: #475569 !important;
    }

    .note-dropdown-menu pre,
    .note-dropdown-menu .dropdown-item pre {
        font-size: 12px !important;
        font-family: monospace !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.25 !important;
        color: #0f172a !important;
        background: transparent !important;
        border: none !important;
    }

    .note-dropdown-menu h1,
    .note-dropdown-menu .dropdown-item h1 {
        font-size: 17px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.2 !important;
        color: #1e293b !important;
    }

    .note-dropdown-menu h2,
    .note-dropdown-menu .dropdown-item h2 {
        font-size: 16px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.2 !important;
        color: #1e293b !important;
    }

    .note-dropdown-menu h3,
    .note-dropdown-menu .dropdown-item h3 {
        font-size: 15px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.2 !important;
        color: #1e293b !important;
    }

    .note-dropdown-menu h4,
    .note-dropdown-menu .dropdown-item h4 {
        font-size: 14px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.2 !important;
        color: #1e293b !important;
    }

    .note-dropdown-menu h5,
    .note-dropdown-menu .dropdown-item h5 {
        font-size: 13px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.2 !important;
        color: #1e293b !important;
    }

    .note-dropdown-menu h6,
    .note-dropdown-menu .dropdown-item h6 {
        font-size: 12px !important;
        font-weight: 700 !important;
        margin: 0 !important;
        padding: 1px 0 !important;
        line-height: 1.2 !important;
        color: #1e293b !important;
    }
</style>

<!-- jQuery & Summernote Lite Scripts -->
<script src="{{ asset('vendor/summernote/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('vendor/summernote/summernote-lite.min.js') }}?v={{ filemtime(public_path('vendor/summernote/summernote-lite.min.js')) }}"></script>
<script>
    $(document).ready(function() {
        function stripAutoTagAttrs(html) {
            if (!html || typeof html !== 'string') return html;
            return html
                .replace(/<table\s+class=["'](?:table\s+table-bordered|table-bordered\s+table|table|table-bordered)["']/gi, '<table')
                .replace(/<(h[1-6])\s+id=["'][^"']*["']/gi, '<$1')
                .replace(/\s+(?:id|class)=["']\s*["']/gi, '');
        }

        function cleanupAllModalsAndBackdrops() {
            $('.note-modal-backdrop, .modal-backdrop, .note-modal').remove();
            $('body').removeClass('modal-open').css('overflow', '');
        }

        // Keep track of active Summernote editor and its saved range
        window.currentActiveSummernote = null;

        // Ensure active editor and its dropdowns always sit on top of neighboring editors
        $(document).on('click focusin mousedown', '.note-editor', function() {
            $('.note-editor').css('z-index', '10');
            $(this).css('z-index', '9999');
        });

        // Continuously save cursor range and track active editor on every click/typing
        $(document).on('focus in keyup mouseup click', '.note-editable', function() {
            const $ed = $(this).closest('.note-editor').prev('textarea.adm-summernote, textarea.summernote');
            if ($ed.length) {
                window.currentActiveSummernote = $ed;
                $ed.summernote('saveRange');
            }
        });

        // Global Image Upload Handler for Summernote WYSIWYG
        window.uploadAndInsertSummernoteFile = function(file, $editor) {
            if (!file) return;

            // Target the designated editor, or last active, or first visible
            let $target = ($editor && $editor.length) ? $editor : window.currentActiveSummernote;
            if (!$target || !$target.length) {
                $target = $('textarea.adm-summernote:visible:first');
            }

            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}');

            const origCursor = document.body.style.cursor;
            document.body.style.cursor = 'wait';

            $.ajax({
                url: '{{ route("admin.upload-content-image") }}',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(res) {
                    document.body.style.cursor = origCursor;
                    if (res && res.url) {
                        // 1. Focus editor and restore exact saved cursor position
                        $target.summernote('focus');
                        $target.summernote('restoreRange');

                        // 2. Insert image at exact cursor location
                        $target.summernote('insertImage', res.url, function($img) {
                            $img.css({
                                'max-width': '100%',
                                'height': 'auto',
                                'border-radius': '8px',
                                'margin': '15px 0',
                                'display': 'block'
                            });
                        });

                        // 3. Keep textarea synchronized
                        const clean = stripAutoTagAttrs($target.summernote('code'));
                        $target.val(clean);

                        // 4. Clean up any open Summernote modal and backdrops
                        cleanupAllModalsAndBackdrops();
                    }
                },
                error: function(err) {
                    document.body.style.cursor = origCursor;
                    cleanupAllModalsAndBackdrops();
                    alert('Image upload failed: ' + (err.responseJSON?.message || 'Please check file size and format (max 15MB).'));
                }
            });
        };

        // Initialize Summernote on all textareas with .adm-summernote or .summernote
        function initSummernote(selector = '.adm-summernote, .summernote') {
            $(selector).each(function() {
                if (!$(this).data('summernote-initialized')) {
                    const customHeight = $(this).data('height') || 200;
                    const $thisTextarea = $(this);
                    let defaultStyleTags = [
                        { title: 'Normal', tag: 'p', className: '', value: 'p' },
                        { title: 'Quote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                        { title: 'Code', tag: 'pre', className: '', value: 'pre' },
                        { title: 'Header 1', tag: 'h1', className: '', value: 'h1' },
                        { title: 'Header 2', tag: 'h2', className: '', value: 'h2' },
                        { title: 'Header 3', tag: 'h3', className: '', value: 'h3' },
                        { title: 'Header 4', tag: 'h4', className: '', value: 'h4' },
                        { title: 'Header 5', tag: 'h5', className: '', value: 'h5' },
                        { title: 'Header 6', tag: 'h6', className: '', value: 'h6' }
                    ];

                    $thisTextarea.summernote({
                        height: customHeight,
                        minHeight: 120,
                        tabsize: 2,
                        tableClassName: '', // Do NOT add default class="table table-bordered" to tables
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'hr']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ],
                        styleTags: defaultStyleTags,
                        callbacks: {
                            onInit: function() {
                                cleanupAllModalsAndBackdrops();
                                const ctx = $thisTextarea.data('summernote');
                                if (ctx && ctx.modules && ctx.modules.editor) {
                                    const origFormatBlock = ctx.modules.editor.formatBlock.bind(ctx.modules.editor);
                                    ctx.modules.editor.formatBlock = function(tagName, $target) {
                                        const range = ctx.modules.editor.createRange ? ctx.modules.editor.createRange() : null;
                                        if (!range || range.isCollapsed()) {
                                            return origFormatBlock(tagName, $target);
                                        }

                                        const sel = window.getSelection();
                                        if (!sel || !sel.rangeCount) {
                                            return origFormatBlock(tagName, $target);
                                        }

                                        const nativeRange = sel.getRangeAt(0);
                                        const selectedText = (sel.toString() || '').trim();
                                        if (!selectedText) {
                                            return origFormatBlock(tagName, $target);
                                        }

                                        const tag = (tagName || 'p').toLowerCase();

                                        const headingStyles = {
                                            'h1': { fontSize: '28px', fontWeight: '800', lineHeight: '1.2' },
                                            'h2': { fontSize: '24px', fontWeight: '700', lineHeight: '1.25' },
                                            'h3': { fontSize: '20px', fontWeight: '700', lineHeight: '1.3' },
                                            'h4': { fontSize: '17px', fontWeight: '700', lineHeight: '1.35' },
                                            'h5': { fontSize: '15px', fontWeight: '600', lineHeight: '1.4' },
                                            'h6': { fontSize: '13px', fontWeight: '600', lineHeight: '1.4', textTransform: 'uppercase' },
                                            'p':  { fontSize: 'inherit', fontWeight: 'normal', lineHeight: 'inherit', fontStyle: 'normal', textTransform: 'none' },
                                            'blockquote': { fontStyle: 'italic', color: '#475569' },
                                            'pre': { fontFamily: 'monospace', backgroundColor: '#f1f5f9', padding: '2px 4px', borderRadius: '4px' }
                                        };

                                        const conf = headingStyles[tag] || headingStyles['p'];
                                        const span = document.createElement('span');
                                        span.className = 'heading-inline heading-' + tag;
                                        span.style.display = 'inline';
                                        if (conf.fontSize) span.style.fontSize = conf.fontSize;
                                        if (conf.fontWeight) span.style.fontWeight = conf.fontWeight;
                                        if (conf.lineHeight) span.style.lineHeight = conf.lineHeight;
                                        if (conf.textTransform) span.style.textTransform = conf.textTransform;
                                        if (conf.fontStyle) span.style.fontStyle = conf.fontStyle;
                                        if (conf.fontFamily) span.style.fontFamily = conf.fontFamily;
                                        if (conf.backgroundColor) span.style.backgroundColor = conf.backgroundColor;
                                        if (conf.padding) span.style.padding = conf.padding;
                                        if (conf.borderRadius) span.style.borderRadius = conf.borderRadius;
                                        if (conf.color) span.style.color = conf.color;

                                        const extracted = nativeRange.extractContents();
                                        span.appendChild(extracted);

                                        // Unwrap any duplicate nested heading-inline spans
                                        $(span).find('.heading-inline').contents().unwrap();

                                        nativeRange.insertNode(span);

                                        // Keep selection on the newly styled text
                                        const newRange = document.createRange();
                                        newRange.selectNodeContents(span);
                                        sel.removeAllRanges();
                                        sel.addRange(newRange);

                                        ctx.modules.editor.saveRange();
                                        ctx.invoke('editor.afterCommand');
                                        const clean = stripAutoTagAttrs($thisTextarea.summernote('code'));
                                        $thisTextarea.val(clean);
                                    };
                                }
                            },
                            onFocus: function() {
                                window.currentActiveSummernote = $thisTextarea;
                                $thisTextarea.summernote('saveRange');
                            },
                            onImageUpload: function(files) {
                                for (let i = 0; i < files.length; i++) {
                                    window.uploadAndInsertSummernoteFile(files[i], $thisTextarea);
                                }
                            },
                            onChange: function(contents) {
                                const clean = stripAutoTagAttrs(contents);
                                $thisTextarea.val(clean);
                            },
                            onBlur: function() {
                                $thisTextarea.summernote('saveRange');
                            },
                            onKeyUp: function() {
                                $thisTextarea.summernote('saveRange');
                            },
                            onMouseUp: function() {
                                $thisTextarea.summernote('saveRange');
                            }
                        }
                    });
                    $thisTextarea.data('summernote-initialized', true);
                }
            });
        }

        initSummernote();

        // Intercept Summernote toolbar picture button to save range and open OS File Picker directly
        $(document).on('mousedown', '.note-btn[data-original-title="Picture"], .note-btn[aria-label="Picture"], button[data-name="picture"], button[data-event="showImageDialog"]', function() {
            const $editor = $(this).closest('.note-editor').prev('textarea.adm-summernote, textarea.summernote');
            if ($editor.length) {
                window.currentActiveSummernote = $editor;
                $editor.summernote('saveRange');
            }
        });

        $(document).on('click', '.note-btn[data-original-title="Picture"], .note-btn[aria-label="Picture"], button[data-name="picture"], button[data-event="showImageDialog"]', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const $editor = $(this).closest('.note-editor').prev('textarea.adm-summernote, textarea.summernote');
            if ($editor.length) {
                window.currentActiveSummernote = $editor;
                $editor.summernote('saveRange');
            }
            let $hiddenInput = $('#summernote_global_file_picker');
            if (!$hiddenInput.length) {
                $hiddenInput = $('<input type="file" id="summernote_global_file_picker" accept="image/*" style="display:none;">').appendTo('body');
            }
            $hiddenInput.off('change').on('change', function() {
                if (this.files && this.files[0]) {
                    window.uploadAndInsertSummernoteFile(this.files[0], window.currentActiveSummernote || $editor);
                    this.value = '';
                }
            });
            $hiddenInput.trigger('click');
            cleanupAllModalsAndBackdrops();
            return false;
        });

        // Fallback: If file is selected inside any Summernote modal, upload immediately to active editor
        $(document).on('change', '.note-modal input[type="file"]', function() {
            if (this.files && this.files[0]) {
                window.uploadAndInsertSummernoteFile(this.files[0], window.currentActiveSummernote);
                cleanupAllModalsAndBackdrops();
            }
        });

        // Ensure backdrop is killed if any modal ever attempts to open
        $(document).on('DOMNodeInserted', function(e) {
            if ($(e.target).hasClass('note-modal-backdrop') || $(e.target).hasClass('modal-backdrop')) {
                $(e.target).remove();
            }
        });

        // Ensure clean pure tags when toggling Code View
        $(document).on('click', '.note-btn[data-original-title="Code View"], .note-btn[aria-label="Code View"], .btn-codeview', function() {
            const $editor = $(this).closest('.note-editor').prev('textarea.adm-summernote, textarea.summernote');
            if ($editor.length) {
                setTimeout(function() {
                    const $codable = $editor.next('.note-editor').find('textarea.note-codable');
                    if ($codable.length) {
                        const val = stripAutoTagAttrs($codable.val());
                        $codable.val(val);
                        $editor.val(val);
                    }
                }, 30);
            }
        });

        // Ensure cursor location is preserved before toolbar table dropdown or dimension picker is clicked
        $(document).on('mousedown', '.note-btn[aria-label="Table"], .note-btn[data-original-title="Table"], .note-table .dropdown-toggle', function() {
            const $editor = $(this).closest('.note-editor').prev('textarea.adm-summernote, textarea.summernote');
            if ($editor.length) {
                $editor.summernote('saveRange');
            }
        });

        $(document).on('mousedown', '.note-dimension-picker-mousecatcher', function() {
            const $editor = $(this).closest('.note-editor').prev('textarea.adm-summernote, textarea.summernote');
            if ($editor.length) {
                $editor.summernote('restoreRange');
            }
        });

        // Ensure Summernote code is cleaned and synced before any form submission
        $('form').on('submit', function() {
            $('.adm-summernote, .summernote').each(function() {
                if ($(this).data('summernote')) {
                    const clean = stripAutoTagAttrs($(this).summernote('code'));
                    $(this).val(clean);
                }
            });
        });

        // Expose initSummernote globally for dynamically shown elements/tabs
        window.initSummernote = initSummernote;
    });
</script>
@stack('scripts')
</body>
</html>
