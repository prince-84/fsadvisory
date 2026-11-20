@php
    $navbarProjects = get_navbar_projects($page->slug ?? null, $page->id ?? null);
    $navbarCommercial = get_navbar_commercial($page->slug ?? null, $page->id ?? null);
    $navbarDevelopers = get_navbar_developers($page->slug ?? null);
    $isProjectDetailPage = isset($project) || request()->is('project/*') || (isset($page) && (\App\Models\Project::where('page_id', $page->id)->exists() || \App\Models\Project::where('slug', $page->slug)->exists()));
@endphp
<header id="siteHeader" class="header">
    <div class="container headerContainer">
        <!-- Logo on the left -->
        <a href="/" class="logoLink">
            <img src="{{ asset('FS LOGO n FAVICON-06.svg') }}" alt="FS Real Estate Advisory" class="logoImg">
        </a>

        <!-- Desktop Navigation aligned to the RIGHT -->
        <nav class="nav">
            <ul class="navList">
                <li class="navItem">
                    <a href="/" class="navLink {{ (request()->is('/') || request()->path() === '/') ? 'navLinkActive' : '' }}">HOME</a>
                </li>
                <li class="navItem" id="navProjectsItem">
                    <a href="/projects" class="navLink {{ (request()->is('projects') || request()->is('project*')) ? 'navLinkActive' : '' }}" id="navProjectsBtn">
                        PROJECTS
                        @if($navbarProjects->isNotEmpty())
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        @endif
                    </a>
                    @if($navbarProjects->isNotEmpty())
                        <div class="dropdownMenu" id="navProjectsDropdown">
                            @foreach($navbarProjects as $navProj)
                                <a href="{{ $navProj->url }}" class="dropdownItem">{{ $navProj->title }}</a>
                            @endforeach
                        </div>
                    @endif
                </li>
                @if($navbarCommercial->isNotEmpty())
                    <li class="navItem" id="navCommercialItem">
                        <button type="button" class="navLink {{ request()->is('commercial*') ? 'navLinkActive' : '' }}" id="navCommercialBtn" style="background: none; border: none; cursor: pointer;">
                            COMMERCIAL
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </button>
                        <div class="dropdownMenu" id="navCommercialDropdown">
                            @foreach($navbarCommercial as $navComm)
                                <a href="{{ $navComm->url }}" class="dropdownItem">{{ $navComm->title }}</a>
                            @endforeach
                        </div>
                    </li>
                @endif
                @if($navbarDevelopers->isNotEmpty())
                    <li class="navItem" id="navDevelopersItem">
                        <a href="/developers" class="navLink {{ (request()->is('developer*') || request()->is('developers*')) ? 'navLinkActive' : '' }}" id="navDevelopersBtn">
                            DEVELOPERS
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m6 9 6 6 6-6"/>
                            </svg>
                        </a>
                        <div class="dropdownMenu" id="navDevelopersDropdown">
                            @foreach($navbarDevelopers as $navDev)
                                <a href="{{ $navDev->url }}" class="dropdownItem">{{ $navDev->title }}</a>
                            @endforeach
                        </div>
                    </li>
                @else
                    <li class="navItem">
                        <a href="/developers" class="navLink {{ (request()->is('developer*') || request()->is('developers*')) ? 'navLinkActive' : '' }}">DEVELOPERS</a>
                    </li>
                @endif
                @if($isProjectDetailPage)
                    <li class="navItem">
                        <a href="#floorplans" class="navLink" onclick="fsScrollToNavSection(event, 'floorplans', 'floorplan')">FLOOR PLAN</a>
                    </li>
                    <li class="navItem">
                        <a href="#master" class="navLink" onclick="fsScrollToNavSection(event, 'master', 'masterplan')">MASTER PLAN</a>
                    </li>
                    <li class="navItem">
                        <a href="#paymentplan" class="navLink" onclick="fsScrollToNavSection(event, 'paymentplan', 'payment-plan')">PAYMENT PLAN</a>
                    </li>
                @endif
                <li class="navItem">
                    <a href="#faq" class="navLink" onclick="fsScrollToNavSection(event, 'faq')">FAQ</a>
                </li>
                <li class="navItem">
                    <a href="/contact-us" class="navLink {{ (request()->is('contact-us*') || request()->is('contact*')) ? 'navLinkActive' : '' }}">CONTACT US</a>
                </li>
                @if(!$isProjectDetailPage)
                <!-- LIST YOUR PROPERTY Button right beside Contact Us (Hidden on Project Detail Pages) -->
                <li class="navItem">
                    <button type="button" class="btn-get-started open-list-modal" onclick="window.openListModal ? window.openListModal() : null" style="font-size: 13px; padding: 8px 18px; font-weight: 600; cursor: pointer; white-space: nowrap; margin-left: 6px;">
                        LIST YOUR PROPERTY
                    </button>
                </li>
                @endif
            </ul>
        </nav>

        <!-- Mobile Menu Toggle Button (Visible ONLY on mobile <= 1024px) -->
        <button type="button" id="mobileMenuBtn" class="mobileToggle" aria-label="Toggle navigation menu">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
            </svg>
        </button>
    </div>
</header>

<!-- Mobile Navigation Backdrop -->
<div id="mobileBackdrop" class="mobileDrawerOverlay"></div>

<!-- Mobile Navigation Drawer -->
<aside id="mobileDrawer" class="mobileDrawer">
    <!-- Top Header inside Drawer: Logo on Left + Close X on Right -->
    <div class="mobileDrawerHeader" style="display: flex; align-items: center; justify-content: space-between; padding-bottom: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.12); margin-bottom: 10px; width: 100%;">
        <a href="/" style="display: flex; align-items: center; text-decoration: none;">
            <img src="{{ asset('FS LOGO n FAVICON-08.svg') }}" alt="FS Real Estate Advisory" style="height: 38px; width: auto; object-fit: contain;">
        </a>
        <button type="button" id="mobileDrawerClose" class="mobileCloseBtn" aria-label="Close menu" style="width: 36px; height: 36px; border-radius: 50%; background: rgba(255, 255, 255, 0.1); display: flex; align-items: center; justify-content: center; border: none; cursor: pointer;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
    </div>

    <!-- Clean Navigation Links -->
    <ul class="mobileNavList">
        <li>
            <a href="/" class="mobileNavLink">HOME</a>
        </li>
        <li>
            @if($navbarProjects->isNotEmpty())
                <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <a href="/projects" class="mobileNavLink" style="flex: 1;">PROJECTS</a>
                    <button type="button" id="mobileProjectsToggle" style="background: none; border: none; padding: 10px 12px; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;" aria-label="Toggle Projects Submenu">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="mobileChevronIcon" style="transition: transform 0.25s ease;">
                            <path d="m6 9 6 6 6-6"/>
                        </svg>
                    </button>
                </div>
                <div id="mobileProjectsSubmenu" class="mobileSubList" style="display: none;">
                    @foreach($navbarProjects as $navProj)
                        <a href="{{ $navProj->url }}" class="mobileSubItem">{{ $navProj->title }}</a>
                    @endforeach
                </div>
            @else
                <a href="/projects" class="mobileNavLink">PROJECTS</a>
            @endif
        </li>
        @if($navbarCommercial->isNotEmpty())
        <li>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <span class="mobileNavLink" style="flex: 1; cursor: pointer;" onclick="document.getElementById('mobileCommercialToggle')?.click()">COMMERCIAL</span>
                <button type="button" id="mobileCommercialToggle" style="background: none; border: none; padding: 10px 12px; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;" aria-label="Toggle Commercial Submenu">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="mobileCommChevronIcon" style="transition: transform 0.25s ease;">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>
            </div>
            <div id="mobileCommercialSubmenu" class="mobileSubList" style="display: none;">
                @foreach($navbarCommercial as $navComm)
                    <a href="{{ $navComm->url }}" class="mobileSubItem">{{ $navComm->title }}</a>
                @endforeach
            </div>
        </li>
        @endif
        @if($navbarDevelopers->isNotEmpty())
        <li>
            <div style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                <a href="/developers" class="mobileNavLink" style="flex: 1;">DEVELOPERS</a>
                <button type="button" id="mobileDevelopersToggle" style="background: none; border: none; padding: 10px 12px; color: #fff; cursor: pointer; display: flex; align-items: center; justify-content: center;" aria-label="Toggle Developers Submenu">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="mobileDevChevronIcon" style="transition: transform 0.25s ease;">
                        <path d="m6 9 6 6 6-6"/>
                    </svg>
                </button>
            </div>
            <div id="mobileDevelopersSubmenu" class="mobileSubList" style="display: none;">
                @foreach($navbarDevelopers as $navDev)
                    <a href="{{ $navDev->url }}" class="mobileSubItem">{{ $navDev->title }}</a>
                @endforeach
            </div>
        </li>
        @else
        <li>
            <a href="/developers" class="mobileNavLink">DEVELOPERS</a>
        </li>
        @endif
        @if($isProjectDetailPage)
        <li>
            <a href="#floorplans" class="mobileNavLink" onclick="fsScrollToNavSection(event, 'floorplans', 'floorplan')">FLOOR PLAN</a>
        </li>
        <li>
            <a href="#master" class="mobileNavLink" onclick="fsScrollToNavSection(event, 'master', 'masterplan')">MASTER PLAN</a>
        </li>
        <li>
            <a href="#paymentplan" class="mobileNavLink" onclick="fsScrollToNavSection(event, 'paymentplan', 'payment-plan')">PAYMENT PLAN</a>
        </li>
        @endif
        <li>
            <a href="#faq" class="mobileNavLink" onclick="fsScrollToNavSection(event, 'faq')">FAQ</a>
        </li>
        <li>
            <a href="/contact-us" class="mobileNavLink">CONTACT US</a>
        </li>
        @if(!$isProjectDetailPage)
        <li style="margin-top: 14px;">
            <button type="button" class="btn-get-started open-list-modal" onclick="window.openListModal ? window.openListModal() : null" style="font-size: 14px; padding: 12px 20px; font-weight: 700; width: 100%; border-radius: 6px; background-color: #BFA16A !important; color: #fff !important; cursor: pointer; text-align: center; border: none; letter-spacing: 0.5px; box-shadow: 0 4px 14px rgba(191, 161, 106, 0.4);">
                LIST YOUR PROPERTY
            </button>
        </li>
        @endif
    </ul>
</aside>

<script>
    // 1. Projects Dropdown Hover & Click on Desktop
    const projectsItem = document.getElementById('navProjectsItem');
    const projectsDropdown = document.getElementById('navProjectsDropdown');
    const projectsBtn = document.getElementById('navProjectsBtn');

    // 2. Commercial Dropdown Hover & Click on Desktop
    const commercialItem = document.getElementById('navCommercialItem');
    const commercialDropdown = document.getElementById('navCommercialDropdown');
    const commercialBtn = document.getElementById('navCommercialBtn');

    // 3. Developers Dropdown Hover & Click on Desktop
    const developersItem = document.getElementById('navDevelopersItem');
    const developersDropdown = document.getElementById('navDevelopersDropdown');
    const developersBtn = document.getElementById('navDevelopersBtn');

    const closeAllDesktopDropdowns = () => {
        projectsDropdown?.classList.remove('dropdownOpen');
        commercialDropdown?.classList.remove('dropdownOpen');
        developersDropdown?.classList.remove('dropdownOpen');
    };

    // Projects: Hover opens dropdown; Click navigates to /projects
    projectsItem?.addEventListener('mouseenter', () => {
        closeAllDesktopDropdowns();
        projectsDropdown?.classList.add('dropdownOpen');
    });

    projectsItem?.addEventListener('mouseleave', () => {
        projectsDropdown?.classList.remove('dropdownOpen');
    });

    commercialBtn?.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = commercialDropdown?.classList.contains('dropdownOpen');
        closeAllDesktopDropdowns();
        if (!isOpen) commercialDropdown?.classList.add('dropdownOpen');
    });

    commercialItem?.addEventListener('mouseenter', () => {
        closeAllDesktopDropdowns();
        commercialDropdown?.classList.add('dropdownOpen');
    });

    commercialItem?.addEventListener('mouseleave', () => {
        commercialDropdown?.classList.remove('dropdownOpen');
    });

    // Developers: Hover opens dropdown; Click navigates to /developers
    developersItem?.addEventListener('mouseenter', () => {
        closeAllDesktopDropdowns();
        developersDropdown?.classList.add('dropdownOpen');
    });

    developersItem?.addEventListener('mouseleave', () => {
        developersDropdown?.classList.remove('dropdownOpen');
    });

    document.addEventListener('click', () => {
        closeAllDesktopDropdowns();
    });

    // 4. STICKY NAVBAR ON SCROLL
    const siteHeader = document.getElementById('siteHeader');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            siteHeader?.classList.add('sticky-header');
        } else {
            siteHeader?.classList.remove('sticky-header');
        }
    });

    // 5. Mobile Navigation Drawer Controls
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileDrawer = document.getElementById('mobileDrawer');
    const mobileBackdrop = document.getElementById('mobileBackdrop');
    const mobileDrawerClose = document.getElementById('mobileDrawerClose');

    const mobileProjectsToggle = document.getElementById('mobileProjectsToggle');
    const mobileProjectsSubmenu = document.getElementById('mobileProjectsSubmenu');
    const mobileChevronIcon = document.getElementById('mobileChevronIcon');

    const mobileCommercialToggle = document.getElementById('mobileCommercialToggle');
    const mobileCommercialSubmenu = document.getElementById('mobileCommercialSubmenu');
    const mobileCommChevronIcon = document.getElementById('mobileCommChevronIcon');

    const mobileDevelopersToggle = document.getElementById('mobileDevelopersToggle');
    const mobileDevelopersSubmenu = document.getElementById('mobileDevelopersSubmenu');
    const mobileDevChevronIcon = document.getElementById('mobileDevChevronIcon');

    const openMenu = () => {
        mobileDrawer?.classList.add('mobileDrawerOpen');
        mobileBackdrop?.classList.add('mobileDrawerOverlayActive');
        document.body.style.overflow = 'hidden';
    };

    const closeMenu = () => {
        mobileDrawer?.classList.remove('mobileDrawerOpen');
        mobileBackdrop?.classList.remove('mobileDrawerOverlayActive');
        document.body.style.overflow = '';
    };

    mobileMenuBtn?.addEventListener('click', openMenu);
    mobileDrawerClose?.addEventListener('click', closeMenu);
    mobileBackdrop?.addEventListener('click', closeMenu);

    // Close on any link click
    document.querySelectorAll('.mobileNavLink, .mobileSubItem').forEach(item => {
        if (item.id !== 'mobileProjectsToggle' && item.id !== 'mobileCommercialToggle' && item.id !== 'mobileDevelopersToggle') {
            item.addEventListener('click', closeMenu);
        }
    });

    // Toggle Mobile Projects Submenu
    mobileProjectsToggle?.addEventListener('click', (e) => {
        e.preventDefault();
        const isOpen = mobileProjectsSubmenu.style.display === 'flex';
        mobileProjectsSubmenu.style.display = isOpen ? 'none' : 'flex';
        mobileChevronIcon.style.transform = isOpen ? 'none' : 'rotate(180deg)';
    });

    // Toggle Mobile Commercial Submenu
    mobileCommercialToggle?.addEventListener('click', (e) => {
        e.preventDefault();
        const isOpen = mobileCommercialSubmenu.style.display === 'flex';
        mobileCommercialSubmenu.style.display = isOpen ? 'none' : 'flex';
        mobileCommChevronIcon.style.transform = isOpen ? 'none' : 'rotate(180deg)';
    });

    // Toggle Mobile Developers Submenu
    mobileDevelopersToggle?.addEventListener('click', (e) => {
        e.preventDefault();
        const isOpen = mobileDevelopersSubmenu.style.display === 'flex';
        mobileDevelopersSubmenu.style.display = isOpen ? 'none' : 'flex';
        mobileDevChevronIcon.style.transform = isOpen ? 'none' : 'rotate(180deg)';
    });

    // 6. Smooth Scroll for Project Detail Nav Anchors
    window.fsScrollToNavSection = function(e, ...ids) {
        for (let id of ids) {
            const el = document.getElementById(id);
            if (el) {
                if (e) e.preventDefault();
                const yOffset = -85;
                const y = el.getBoundingClientRect().top + window.pageYOffset + yOffset;
                window.scrollTo({ top: y, behavior: 'smooth' });
                return;
            }
        }
    };
</script>

<style>
/* Refined Global & Project Detail Header Styling */
.header,
#siteHeader {
    position: sticky !important;
    top: 0 !important;
    left: 0 !important;
    right: 0 !important;
    width: 100% !important;
    background: #ffffff !important;
    background-color: #ffffff !important;
    z-index: 9999 !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.08) !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04) !important;
    padding: 10px 0 !important;
    transition: all 0.3s ease !important;
}

.headerContainer {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    max-width: 1440px !important;
    width: 100% !important;
    margin: 0 auto !important;
    padding: 0 32px !important;
    box-sizing: border-box !important;
}

.logoLink {
    display: flex !important;
    align-items: center !important;
    flex-shrink: 0 !important;
    margin-right: 36px !important;
    cursor: pointer !important;
    text-decoration: none !important;
}

.logoImg {
    height: 48px !important;
    width: auto !important;
    max-width: 220px !important;
    object-fit: contain !important;
    display: block !important;
}

.nav {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    flex: 1 !important;
    min-width: 0 !important;
}

.navList {
    display: flex !important;
    align-items: center !important;
    justify-content: flex-end !important;
    gap: 22px !important;
    margin: 0 !important;
    padding: 0 !important;
    list-style: none !important;
    flex-wrap: nowrap !important;
}

.navItem {
    position: relative !important;
    flex-shrink: 0 !important;
}

.navLink {
    color: #1a1a1a !important;
    font-size: 13px !important;
    font-weight: 700 !important;
    text-transform: uppercase !important;
    letter-spacing: 0.35px !important;
    display: inline-flex !important;
    align-items: center !important;
    gap: 4px !important;
    padding: 6px 0 !important;
    position: relative !important;
    white-space: nowrap !important;
    text-decoration: none !important;
    transition: color 0.2s ease !important;
}

.navLink:hover,
.navLinkActive {
    color: #BFA16A !important;
}

.navLink::after {
    content: "" !important;
    position: absolute !important;
    bottom: -2px !important;
    left: 0 !important;
    width: 0% !important;
    height: 2.5px !important;
    background: #BFA16A !important;
    background-color: #BFA16A !important;
    transition: width 0.25s ease !important;
}

.navLink:hover::after,
.navLinkActive::after {
    width: 100% !important;
}

@media (max-width: 1360px) {
    .headerContainer {
        padding: 0 20px !important;
    }
    .logoLink {
        margin-right: 22px !important;
    }
    .logoImg {
        height: 44px !important;
    }
    .navList {
        gap: 15px !important;
    }
    .navLink {
        font-size: 12px !important;
        letter-spacing: 0.2px !important;
    }
}

@media (max-width: 1140px) {
    .headerContainer {
        padding: 0 16px !important;
    }
    .logoLink {
        margin-right: 14px !important;
    }
    .logoImg {
        height: 40px !important;
    }
    .navList {
        gap: 11px !important;
    }
    .navLink {
        font-size: 11px !important;
        letter-spacing: 0px !important;
    }
}

@media (max-width: 1024px) {
    .nav {
        display: none !important;
    }
    .mobileToggle {
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        background: none !important;
        border: none !important;
        cursor: pointer !important;
        color: #1a1a1a !important;
        padding: 6px !important;
    }
}
</style>