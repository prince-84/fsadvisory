@php
    $aboutTitle  = page_section('about', 'heading', page_section('about', 'title', $page->title ?? 'About', $page->slug ?? ''), $page->slug ?? '');
    $aboutDesc   = page_section('about', 'description', '', $page->slug ?? '');
    $aboutPoster = page_section('about', 'poster_image', page_section('about', 'video_poster', '', $page->slug ?? ''), $page->slug ?? '');
    $aboutVideo  = page_section('about', 'video_url', page_section('about', 'video_src', '', $page->slug ?? ''), $page->slug ?? '');
    $isEmbedded  = $embedded ?? false;

    // Detect if this is a project detail page
    $isProjectPage = !empty($isProjectContext)
        || request()->is('project/*')
        || request()->routeIs('project.*')
        || request()->routeIs('admin.projects.*')
        || !empty($isProjectDetailPage)
        || (isset($page) && \App\Models\Project::where('page_id', $page->id)->orWhere('slug', $page->slug)->exists())
        || (isset($project) && !empty($project));

    // Resolve project data for project detail page
    $projectObj = $project ?? null;
    if ($isProjectPage && !$projectObj && isset($page) && $page) {
        $projectObj = \App\Models\Project::where('page_id', $page->id)->orWhere('slug', $page->slug)->first();
    }

    $projectTitle = $projectObj?->title ?: ($page?->title ?: 'Project');

    // Developer resolution from CMS
    $projectDev = $projectObj?->developerRel ?: ($projectObj?->developer_id ? \App\Models\Developer::find($projectObj->developer_id) : ($projectObj?->developer ? \App\Models\Developer::where('name', $projectObj->developer)->first() : null));
    $projectDevName = $projectDev?->name ?: ($projectObj?->developer ?: '');
    $projectDevUrl = $projectDev ? url('/developer/' . $projectDev->slug) : null;

    // Community / Neighbourhood resolution from CMS
    $projectComm = $projectObj?->community ?: ($projectObj?->community_id ? \App\Models\Community::with('city')->find($projectObj->community_id) : null);
    if (!$projectComm && !empty($projectObj?->location)) {
        $rawLoc = trim($projectObj->location);
        $commNameCandidate = trim(explode(',', $rawLoc)[0]);
        $projectComm = \App\Models\Community::with('city')->where('name', $rawLoc)->orWhere('name', $commNameCandidate)->first();
    }
    $projectCommName = $projectComm ? ($projectComm->name . ($projectComm->city ? ', ' . $projectComm->city->name : '')) : ($projectObj?->location ?: '');
    $projectCommUrl = $projectComm?->url ?: null;

    $hasContent = !empty(trim(strip_tags((string)$aboutDesc)));
    $hasPoster  = !empty(trim((string)$aboutPoster)) && !$isProjectPage;

    // Auto append "Read more" right at the end of the short content text
    $shortContentOutput = $aboutDesc;
    if ($isProjectPage && $hasContent) {
        $readMoreHtml = ' <a href="#mainContentArticle" onclick="fsScrollToContentArticle(event)" class="fsShortContentReadMore" style="color: #BFA16A; font-weight: 700; text-decoration: underline; margin-left: 4px; cursor: pointer; white-space: nowrap; font-size: inherit; display: inline;">Read more</a>';

        if (preg_match('/(\s*(?:<\/(?:p|div|h[1-6]|span|li|b|strong|em|i)>\s*)+)$/i', trim($shortContentOutput))) {
            $shortContentOutput = preg_replace('/(\s*(?:<\/(?:p|div|h[1-6]|span|li|b|strong|em|i)>\s*)+)$/i', $readMoreHtml . '$1', trim($shortContentOutput), 1);
        } else {
            $shortContentOutput = trim($shortContentOutput) . $readMoreHtml;
        }
    }
@endphp

@if($isProjectPage)
    {{-- ========================================================================= --}}
    {{-- PROJECT DETAIL PAGE: Summary Header (Image 2) + Overview (Image 3) + Short Content --}}
    {{-- ========================================================================= --}}
    <style>
    .fsProjectSummaryWrapper {
        width: 100% !important;
        margin-bottom: 24px !important;
    }
    .fsProjectSummaryTitle {
        font-size: 26px !important;
        font-weight: 800 !important;
        color: #111827 !important;
        margin: 0 0 10px 0 !important;
        line-height: 1.25 !important;
        font-family: inherit !important;
        letter-spacing: -0.01em !important;
    }
    .fsProjectSummaryMeta {
        font-size: 14.5px !important;
        color: #64748b !important;
        display: flex !important;
        align-items: center !important;
        gap: 8px !important;
        flex-wrap: wrap !important;
        line-height: 1.4 !important;
    }
    .fsProjectSummaryMeta a {
        color: #0f172a !important;
        font-weight: 700 !important;
        text-decoration: none !important;
        transition: color 0.15s ease !important;
    }
    .fsProjectSummaryMeta a:hover {
        color: #BFA16A !important;
        text-decoration: underline !important;
    }
    .fsProjectOverviewWrap {
        border-bottom: 1.5px solid #e5e7eb !important;
        margin: 28px 0 18px 0 !important;
        width: 100% !important;
        display: block !important;
    }
    .fsProjectOverviewTitle {
        display: inline-block !important;
        font-size: 24px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        padding-bottom: 8px !important;
        border-bottom: 3px solid #BFA16A !important;
        margin-bottom: -1.5px !important;
        line-height: 1.2 !important;
    }
    .fsAboutDesc {
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
        font-size: 15px !important;
        color: #2b2b2b !important;
        line-height: 1.8 !important;
    }
    .fsAboutDesc p {
        margin-top: 0 !important;
        margin-bottom: 16px !important;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        line-height: 1.6 !important;
        color: #2B2B2B !important;
        font-size: 14.5px !important;
        font-weight: 400 !important;
    }
    .fsAboutDesc p:last-child {
        margin-bottom: 0 !important;
    }
    .fsAboutDesc a,
    .fsAboutDesc p a {
        color: #BFA16A !important;
        text-decoration: underline !important;
        font-weight: 600 !important;
        transition: color 0.15s ease !important;
    }
    .fsAboutDesc a:hover,
    .fsAboutDesc p a:hover {
        color: #aa8d58 !important;
    }
    .fsAboutDesc h1, .fsAboutDesc h2, .fsAboutDesc h3, .fsAboutDesc h4, .fsAboutDesc h5, .fsAboutDesc h6 {
        color: #BFA16A !important;
        font-weight: 700 !important;
        margin-top: 24px !important;
        margin-bottom: 14px !important;
        line-height: 1.3 !important;
    }
    .fsAboutDesc table {
        width: 100% !important;
        max-width: 100% !important;
        border-collapse: collapse !important;
        margin: 18px 0 24px 0 !important;
        background: #ffffff !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 6px !important;
        overflow: hidden !important;
    }
    .fsAboutDesc table th, .fsAboutDesc table td {
        border: 1px solid #e2e8f0 !important;
        padding: 11px 16px !important;
        font-size: 14px !important;
        line-height: 1.5 !important;
        text-align: left !important;
    }
    .fsAboutDesc table th {
        background: #f8fafc !important;
        font-weight: 700 !important;
        color: #0c2340 !important;
    }
    .fsAboutDesc table td {
        color: #334155 !important;
    }
    .fsAboutDesc table tr:hover td {
        background: #fafaf9 !important;
    }
    .fsShortContentReadMore:hover {
        color: #9a7837 !important;
    }
    </style>

    @if(($part ?? 'all') !== 'body')
    <div id="alt-services" class="fsProjectSummaryWrapper" style="margin-bottom: 0 !important;">
        <!-- 1. Project Title Summary (Image 2 Style) -->
        <h1 class="fsProjectSummaryTitle">
            {{ $projectTitle }} Summary
        </h1>

        <!-- 2. Developer & Community Subtitle Line (Image 2 Style) -->
        <div class="fsProjectSummaryMeta">
            @if(!empty($projectDevName))
                <span title="Developer" style="display: inline-flex; align-items: center; color: #111827;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="flex-shrink: 0;">
                        <path d="M4 21V5a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v16"/>
                        <path d="M14 10h5a1 1 0 0 1 1 1v10"/>
                        <path d="M2 21h20"/>
                        <path d="M8 8h2M8 12h2M8 16h2M17 14h1M17 17h1"/>
                    </svg>
                </span>
                @if($projectDevUrl)
                    <a href="{{ $projectDevUrl }}" title="View Developer: {{ $projectDevName }}">
                        {{ $projectDevName }}
                    </a>
                @else
                    <strong style="color: #0f172a; font-weight: 700;">{{ $projectDevName }}</strong>
                @endif
            @endif

            @if(!empty($projectDevName) && !empty($projectCommName))
                <span style="color: #cbd5e1; margin: 0 4px; font-weight: 400;">|</span>
            @endif

            @if(!empty($projectCommName))
                <span style="display: inline-flex; align-items: center; gap: 4px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="currentColor" style="color: #111827; flex-shrink: 0; display: inline-block; vertical-align: -1px;">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    @if($projectCommUrl)
                        <a href="{{ $projectCommUrl }}" title="View Community: {{ $projectCommName }}">
                            {{ $projectCommName }}
                        </a>
                    @else
                        <strong style="color: #0f172a; font-weight: 700;">{{ $projectCommName }}</strong>
                    @endif
                </span>
            @endif
        </div>

        </div>
    @endif
    @if(($part ?? 'all') !== 'header')
    <div class="fsProjectSummaryWrapper">
        <!-- 3. Overview -->
        @if($hasContent)
        <div class="fsProjectOverviewWrap">
            <span class="fsProjectOverviewTitle">
                Overview
            </span>
        </div>

        <!-- 4. Short Content Text with auto 'Read more' appended at end -->
        <div class="fsAboutDesc">
            {!! $shortContentOutput !!}
        </div>
        @endif
    </div>

    <script>
    function fsScrollToContentArticle(e) {
        if (e) e.preventDefault();
        const target = document.getElementById('mainContentArticle') 
            || document.getElementById('pageLongContent') 
            || document.querySelector('.saimaContentCol') 
            || document.querySelector('article')
            || document.getElementById('content');
        if (target) {
            target.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
    </script>
    @endif

@elseif($hasContent || $hasPoster || !empty($aboutVideo))
    {{-- ========================================================================= --}}
    {{-- NON-PROJECT PAGE (Standard About Community Layout)                        --}}
    {{-- ========================================================================= --}}
    <style>
    .fsAboutDesc {
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif !important;
        font-size: 15px !important;
        color: #2b2b2b !important;
        line-height: 1.8 !important;
    }
    .fsAboutDesc p {
        margin-top: 0 !important;
        margin-bottom: 16px !important;
        font-family: 'Open Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif !important;
        line-height: 1.6 !important;
        color: #2B2B2B !important;
        font-size: 14.5px !important;
        font-weight: 400 !important;
    }
    .fsAboutDesc p:last-child {
        margin-bottom: 0 !important;
    }
    .fsAboutDesc a,
    .fsAboutDesc p a {
        color: #BFA16A !important;
        text-decoration: underline !important;
        font-weight: 600 !important;
        transition: color 0.15s ease !important;
    }
    .fsAboutDesc a:hover,
    .fsAboutDesc p a:hover {
        color: #aa8d58 !important;
    }
    </style>

    @if($isEmbedded)
    <div id="alt-services" class="fsAboutCard" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 14px; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04); padding: 28px 28px; box-sizing: border-box;">
        <div class="GolfAboutVideo-module__mC9tiq__aboutGrid" style="display: grid; grid-template-columns: {{ $hasPoster ? 'repeat(auto-fit, minmax(300px, 1fr))' : '1fr' }}; gap: 32px; align-items: center;">
            <div class="GolfAboutVideo-module__mC9tiq__leftCol">
                <h2 class="GolfAboutVideo-module__mC9tiq__title" style="font-size: 24px; font-weight: 700; color: #BFA16A; margin: 0 0 16px 0; line-height: 1.3;">{!! $aboutTitle !!}</h2>
                <div class="fsAboutDesc GolfAboutVideo-module__mC9tiq__description">
                    {!! $aboutDesc !!}
                </div>
            </div>
            @if($hasPoster)
            <div class="GolfAboutVideo-module__mC9tiq__rightCol">
                <div class="GolfAboutVideo-module__mC9tiq__videoWrapper" style="position: relative; border-radius: 10px; overflow: hidden; aspect-ratio: 4 / 3; width: 100%; background: #f1f5f9;">
                    <div class="GolfAboutVideo-module__mC9tiq__videoContainer" style="width: 100%; height: 100%;">
                        <img src="{{ $aboutPoster }}" alt="{{ $page->title ?? 'About' }}" class="GolfAboutVideo-module__mC9tiq__videoPlayer" style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: 10px;">
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
    @else
    <section id="alt-services" class="GolfAboutVideo-module__mC9tiq__aboutSection">
        <div class="container">
            <div class="GolfAboutVideo-module__mC9tiq__aboutGrid">
                <div class="GolfAboutVideo-module__mC9tiq__leftCol">
                    <h2 class="GolfAboutVideo-module__mC9tiq__title" style="color: #BFA16A;">{!! $aboutTitle !!}</h2>
                    <div class="fsAboutDesc GolfAboutVideo-module__mC9tiq__description">
                        {!! $aboutDesc !!}
                    </div>
                </div>
                @if($hasPoster)
                <div class="GolfAboutVideo-module__mC9tiq__rightCol">
                    <div class="GolfAboutVideo-module__mC9tiq__videoWrapper">
                        <div class="GolfAboutVideo-module__mC9tiq__brownBackdrop"></div>
                        <div class="GolfAboutVideo-module__mC9tiq__videoContainer">
                            <img src="{{ $aboutPoster }}" alt="{{ $page->title ?? 'About' }}" class="GolfAboutVideo-module__mC9tiq__videoPlayer" style="width: 100%; height: 100%; object-fit: cover; display: block; border-radius: inherit;">
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif
@endif

