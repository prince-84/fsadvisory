@extends('layouts.app')

@section('title', 'Real Estate Developers in Pakistan | Saima Group')
@section('meta_description', 'Discover the Developers Shaping Pakistan\'s Real Estate Landscape. Explore recognised property developers, verified development projects, and updated developer profiles.')

@section('content')
<style>
    /* Developer Main Page Hero */
    .devMainHero {
        position: relative;
        min-height: 480px;
        display: flex;
        align-items: center;
        justify-content: center;
        background-image: url('{{ asset("develoepr_main_hero_image.jpeg") }}');
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        text-align: center;
        color: #ffffff;
    }
    .devMainHeroOverlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, rgba(0, 0, 0, 0.42) 0%, rgba(0, 0, 0, 0.62) 100%);
        z-index: 1;
    }
    .devMainHeroContent {
        position: relative;
        z-index: 2;
        max-width: 960px;
        margin: 0 auto;
        padding: 120px 20px 90px;
    }
    .devMainHeroH1 {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(32px, 4.4vw, 54px) !important;
        font-weight: 700 !important;
        color: #ffffff !important;
        line-height: 1.2 !important;
        margin: 0 0 16px 0 !important;
        letter-spacing: -0.015em !important;
        text-shadow: 0 2px 14px rgba(0, 0, 0, 0.65) !important;
    }
    .devMainHeroTagline {
        font-size: clamp(16px, 1.35vw, 21px) !important;
        font-weight: 400 !important;
        color: rgba(255, 255, 255, 0.95) !important;
        line-height: 1.5 !important;
        margin: 0 !important;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.6) !important;
    }

    /* Stats Bar (Beneath Hero - Reference Parity) */
    .devStatsBar {
        background: #ffffff;
        border-bottom: 1px solid #eef2f6;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.03);
    }
    .devStatsContainer {
        max-width: 1200px;
        margin: 0 auto;
        padding: 30px 24px;
        display: flex;
        justify-content: space-around;
        align-items: center;
        gap: 28px;
    }
    .devStatItem {
        display: flex;
        align-items: baseline;
        gap: 10px;
    }
    .devStatNumber {
        font-size: clamp(24px, 2.3vw, 30px);
        font-weight: 800;
        color: #111827;
        letter-spacing: -0.02em;
        line-height: 1;
    }
    .devStatLabel {
        font-size: clamp(14px, 1.1vw, 15.5px);
        font-weight: 400;
        color: #64748b;
        letter-spacing: -0.005em;
        line-height: 1.3;
    }

    /* Featured Developers Section */
    .featuredDevSection {
        padding: 60px 0 75px 0;
        background: #fbfbfc;
    }
    .featuredDevContainer {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .featuredDevHeader {
        margin-bottom: 36px;
    }
    .featuredDevTitle {
        font-size: clamp(28px, 2.6vw, 36px);
        font-weight: 700;
        color: #000000;
        margin: 0 0 10px 0;
        letter-spacing: -0.015em;
    }
    .featuredDevSubtitle {
        font-size: 15.5px;
        font-weight: 400;
        color: #000000;
        margin: 0;
        line-height: 1.5;
    }

    /* Developer Cards List */
    .devListWrapper {
        display: flex;
        flex-direction: column;
        gap: 26px;
    }
    .devCardItem {
        display: flex;
        gap: 28px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 24px;
        box-shadow: 0 3px 16px rgba(0, 0, 0, 0.04);
        transition: transform 0.25s ease, box-shadow 0.25s ease, border-color 0.25s ease;
    }
    .devCardItem:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.07);
        border-color: #cbd5e1;
    }

    /* Left: Cover Media + Floating Logo Badge */
    .devCardMedia {
        position: relative;
        flex-shrink: 0;
        width: 290px;
        height: 250px;
        border-radius: 14px;
        overflow: hidden;
        background: #f1f5f9;
    }
    .devCardCover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .devCardItem:hover .devCardCover {
        transform: scale(1.04);
    }
    .devCardLogoBadge {
        position: absolute;
        bottom: 12px;
        left: 12px;
        background: #ffffff;
        padding: 6px 14px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.16);
        display: flex;
        align-items: center;
        justify-content: center;
        max-width: 130px;
        min-height: 38px;
        z-index: 2;
        border: 1px solid rgba(0, 0, 0, 0.04);
    }
    .devCardLogoImg {
        max-height: 28px;
        max-width: 100px;
        object-fit: contain;
        display: block;
    }

    /* Right: Body Content */
    .devCardBody {
        flex: 1;
        min-width: 0;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .devCardTop {
        margin-bottom: 12px;
    }
    .devCardTitle {
        font-family: 'Playfair Display', Georgia, serif;
        font-size: clamp(22px, 2vw, 27px);
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.25;
    }
    .devCardTitle a {
        text-decoration: none;
        color: inherit;
        transition: color 0.2s ease;
    }
    .devCardTitle a:hover {
        color: #0284c7;
    }
    .devCardDesc {
        font-size: 14.5px;
        color: #4b5563;
        line-height: 1.65;
        margin: 0 0 16px 0;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .devCardDivider {
        border-top: 1px solid #eef2f6;
        margin: auto 0 16px 0;
    }
    .devCardFooter {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }
    .devCardBtn {
        background: #0284c7;
        color: #ffffff !important;
        padding: 10px 22px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s ease, transform 0.15s ease;
        box-shadow: 0 2px 6px rgba(2, 132, 199, 0.25);
    }
    .devCardBtn:hover {
        background: #0369a1;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(2, 132, 199, 0.35);
    }

    /* Long Content Section (Exact Page Parity: Green Headings, Clean Typography, Bullet Discs) */
    .devLongContentSection {
        padding: 55px 0 75px 0;
        background: #ffffff;
        border-top: 1px solid #f0ebe4;
    }
    .devLongContentContainer {
        max-width: 1140px;
        margin: 0 auto;
        padding: 0 20px;
    }
    .devEditorialBody {
        font-size: 15.5px;
        line-height: 1.55;
        color: #374151;
    }
    .devEditorialBody h2 {
        font-family: inherit;
        font-size: 23px;
        font-weight: 700;
        color: #1a4731 !important;
        line-height: 1.3;
        margin: 22px 0 6px 0;
        letter-spacing: -0.01em;
    }
    .devEditorialBody h2:first-of-type {
        margin-top: 0;
    }
    .devEditorialBody h3 {
        font-family: inherit;
        font-size: 17.5px;
        font-weight: 700;
        color: #1a4731 !important;
        line-height: 1.35;
        margin: 12px 0 4px 0;
    }
    .devEditorialBody h2 + h3 {
        margin-top: 2px;
    }
    .devEditorialBody h4 {
        font-family: inherit;
        font-size: 16px;
        font-weight: 700;
        color: #1a4731 !important;
        line-height: 1.35;
        margin: 10px 0 2px 0;
    }
    .devEditorialBody p {
        font-size: 15px;
        line-height: 1.52;
        color: #374151;
        margin: 0 0 6px 0;
    }
    .devEditorialBody h3 + p,
    .devEditorialBody h4 + p {
        margin-top: 2px;
    }
    .devEditorialBody ul {
        list-style-type: disc !important;
        padding-left: 24px;
        margin: 6px 0 12px 0;
    }
    .devEditorialBody ul ul {
        list-style-type: circle !important;
        padding-left: 20px;
        margin: 4px 0 4px 0;
    }
    .devEditorialBody ol {
        list-style-type: decimal !important;
        padding-left: 24px;
        margin: 6px 0 12px 0;
    }
    .devEditorialBody li {
        font-size: 15px;
        line-height: 1.5;
        color: #374151;
        margin-bottom: 4px;
    }
    .devEditorialBody strong,
    .devEditorialBody b {
        color: #111827;
        font-weight: 700;
    }

    /* Responsive */
    @media (max-width: 860px) {
        .devCardItem {
            flex-direction: column;
            gap: 20px;
            padding: 20px;
        }
        .devCardMedia {
            width: 100%;
            height: 220px;
        }
    }
    @media (max-width: 768px) {
        .devMainHero {
            min-height: 380px;
        }
        .devMainHeroContent {
            padding: 90px 16px 60px;
        }
        .devStatsContainer {
            flex-direction: column;
            align-items: center;
            gap: 18px;
            padding: 24px 16px;
        }
        .devStatItem {
            justify-content: center;
            text-align: center;
        }
        .featuredDevSection {
            padding: 45px 0 60px 0;
        }
        .devLongContentSection {
            padding: 45px 0 60px 0;
        }
        .devEditorialBody h2 {
            font-size: 22px;
            margin: 32px 0 14px 0;
        }
        .devEditorialBody h3 {
            font-size: 18.5px;
        }
        .devEditorialBody h4 {
            font-size: 16.5px;
        }
    }
</style>

<!-- 1. Static Hero Section -->
<section class="devMainHero">
    <div class="devMainHeroOverlay"></div>
    <div class="devMainHeroContent">
        <h1 class="devMainHeroH1">Real Estate Developers in Pakistan</h1>
        <p class="devMainHeroTagline">Discover the Developers Shaping Pakistan's Real Estate Landscape</p>
    </div>
</section>

<!-- 2. Stats Bar (Directly beneath Hero) -->
<section class="devStatsBar">
    <div class="devStatsContainer">
        <!-- Stat 1 -->
        <div class="devStatItem">
            <span class="devStatNumber">566</span>
            <span class="devStatLabel">Property Developers</span>
        </div>

        <!-- Stat 2 -->
        <div class="devStatItem">
            <span class="devStatNumber">Verified</span>
            <span class="devStatLabel">Listed Development Projects</span>
        </div>

        <!-- Stat 3 -->
        <div class="devStatItem">
            <span class="devStatNumber">Regularly</span>
            <span class="devStatLabel">Updated Developer Profiles</span>
        </div>
    </div>
</section>

<!-- 3. Featured Developers Section (Dynamic Cards from Database, Newest on Top) -->
<section class="featuredDevSection">
    <div class="featuredDevContainer">
        <div class="featuredDevHeader">
            <h2 class="featuredDevTitle">Featured Developers</h2>
            <p class="featuredDevSubtitle">Discover some of Pakistan's recognised real estate developers and development companies Cards</p>
        </div>

        @if(isset($developers) && $developers->isNotEmpty())
            <div class="devListWrapper">
                @foreach($developers as $dev)
                    @php
                        $devH1 = $dev->h1 ?: $dev->name;
                        $devCover = $dev->cover_image
                            ? (str_starts_with($dev->cover_image, 'http') ? $dev->cover_image : asset($dev->cover_image))
                            : asset('develoepr_main_hero_image.jpeg');
                        $devLogo = $dev->logo
                            ? (str_starts_with($dev->logo, 'http') ? $dev->logo : asset($dev->logo))
                            : null;
                        $devUrl = url('/developer/' . ltrim($dev->slug, '/'));
                        $cleanShortContent = trim(strip_tags((string)$dev->short_content));
                    @endphp
                    <div class="devCardItem">
                        <!-- Left: Cover image with floating Logo badge -->
                        <div class="devCardMedia">
                            <a href="{{ $devUrl }}" style="display: block; width: 100%; height: 100%;" aria-label="{{ $devH1 }}">
                                <img src="{{ $devCover }}" alt="{{ $devH1 }}" class="devCardCover" loading="lazy">
                            </a>
                            @if($devLogo)
                                <div class="devCardLogoBadge">
                                    <img src="{{ $devLogo }}" alt="{{ $dev->name }} logo" class="devCardLogoImg">
                                </div>
                            @endif
                        </div>

                        <!-- Right: Developer details -->
                        <div class="devCardBody">
                            <div>
                                <div class="devCardTop">
                                    <h3 class="devCardTitle">
                                        <a href="{{ $devUrl }}">{{ $devH1 }}</a>
                                    </h3>
                                </div>

                                @if(!empty($cleanShortContent))
                                    <p class="devCardDesc">{{ $cleanShortContent }}</p>
                                @endif
                            </div>

                            <div>
                                <div class="devCardDivider"></div>
                                <div class="devCardFooter">
                                    <a href="{{ $devUrl }}" class="devCardBtn">
                                        View Developer
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                                            <line x1="7" y1="17" x2="17" y2="7"></line>
                                            <polyline points="7 7 17 7 17 17"></polyline>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div style="background: #ffffff; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 48px 24px; text-align: center; color: #64748b;">
                <p style="margin: 0; font-size: 16px;">No developers currently available. Check back soon for updated profiles.</p>
            </div>
        @endif
    </div>
</section>

<!-- 4. Long Content Section (Exact Page Parity: Green Headings, Bullet Discs, Clean Typography) -->
<section class="devLongContentSection">
    <div class="devLongContentContainer">
        <article class="devEditorialBody saimaDynamicContent devContentArea">
            
            <!-- Section 1 -->
            <h2>Real Estate Development in Pakistan</h2>
            <p>Pakistan's real estate development industry plays an important role in the country's residential, commercial, and infrastructure landscape. From planned housing societies and residential communities to high-rise apartment developments and commercial projects, developers contribute to the changing urban environment of major Pakistani cities. Real estate developers are responsible for planning, managing, and delivering different types of property development projects. Their work may involve land development, infrastructure planning, residential construction, commercial development, and the creation of integrated communities.</p>
            <p>Pakistan's property development market includes private development companies, construction groups, housing organisations, and public development authorities. Each operates under different responsibilities and regulatory frameworks. Major urban markets such as Karachi, Lahore, Islamabad, and Rawalpindi continue to offer a variety of residential and commercial development opportunities. Developers operating in these markets may focus on different property categories, including residential plots, apartment complexes, luxury houses, commercial buildings, and large-scale housing communities.</p>
            <p>Choosing a suitable developer is an important part of researching a property project. Buyers and investors should consider the company's previous development experience, project delivery history, financial arrangements, construction progress, and applicable regulatory approvals. Our platform brings developer profiles and project information together to help users research Pakistan's real estate development industry. Explore established property developers, compare their project portfolios, discover new housing developments, and review residential and commercial projects across different cities. Whether you are researching property development companies or exploring potential investment opportunities, our developer directory provides a starting point for informed property research.</p>

            <h3>Explore Our Developer Categories:</h3>
            <ul>
                <li>Real Estate Developers in Pakistan</li>
                <li>Housing Society Developers</li>
                <li>Residential Property Developers</li>
                <li>Commercial Property Developers</li>
                <li>Apartment Developers</li>
                <li>Infrastructure and Construction Companies</li>
                <li>New Housing Project Developers</li>
            </ul>

            <!-- Section 2 -->
            <h2>Why Choose the Right Property Developer in Pakistan?</h2>
            <h3>Important Factors to Consider When Selecting a Real Estate Developer</h3>
            <p>Choosing a property developer is one of the most important steps when researching a residential or commercial property project. A developer's experience, planning approach, documentation, and project execution can influence the overall development experience. Here are some important factors buyers and investors should consider before selecting a property developer.</p>

            <h4>1. Development Experience and Track Record</h4>
            <p>A developer's previous projects can provide useful information about its experience and development capabilities. Review completed projects, construction quality, infrastructure delivery, and the company's history of fulfilling its development commitments. A strong development track record can help buyers understand the company's approach to project execution.</p>

            <h4>2. Project Approvals and Documentation</h4>
            <p>Legal documentation and project approvals are essential considerations when evaluating a housing society or property development. Check the relevant No Objection Certificate (NOC), approved layout plan, land ownership documents, and applicable permissions from the relevant development authority. Approval status should be verified for the specific project, phase, or block rather than relying only on the developer's name.</p>

            <h4>3. Quality of Infrastructure and Construction</h4>
            <p>Infrastructure and construction quality are important indicators of a development project's overall planning. Consider road networks, drainage systems, water supply, electricity arrangements, sewerage infrastructure, and construction standards. For residential communities, also review the availability and development status of parks, educational facilities, healthcare facilities, and commercial areas.</p>

            <h4>4. Project Development Progress</h4>
            <p>Understanding the current development status helps buyers evaluate the project's progress and expected timelines. Review recent construction updates, infrastructure completion, site photographs, and official project announcements. Different blocks and phases may have different development timelines, so verify the exact location you are considering.</p>

            <h4>5. Transparent Pricing and Payment Plans</h4>
            <p>A reliable developer should provide clear information about property prices, booking requirements, instalment schedules, development charges, and applicable transfer fees. Review the complete financial commitment before making a booking. Compare payment plans across different projects and understand all contractual conditions.</p>

            <h4>6. Customer Support and Communication</h4>
            <p>Effective communication can make the property purchasing process easier. Consider how the developer handles customer enquiries, documentation requests, payment confirmations, possession information, and project updates. Access to clear and consistent information can help buyers make better decisions. Together, these factors can help buyers and investors compare property development companies and identify projects that match their requirements.</p>

            <!-- Section 3 -->
            <h2>How to Choose a Property Developer in Pakistan</h2>
            <h3>A Step-by-Step Guide to Evaluating Real Estate Developers</h3>
            <p>Selecting a developer requires research beyond promotional material and advertised property prices. Follow these steps to evaluate different companies and their development projects.</p>

            <h4>Step 01 – Identify Your Property Requirements</h4>
            <p>Start by identifying your preferred city, property category, and investment budget. Decide whether you are interested in residential plots, apartments, constructed houses, commercial projects, or large-scale housing communities. Having clear requirements will help narrow down relevant developers.</p>

            <h4>Step 02 – Research Developer Profiles</h4>
            <p>Explore different property developers and review their company background, previous projects, and development portfolios. Look for information about completed developments, ongoing projects, construction experience, and company operations. Compare developers based on their actual development history rather than marketing claims alone.</p>

            <h4>Step 03 – Verify Project Approvals</h4>
            <p>Check the legal status of the specific housing project with the relevant development authority. Review applicable NOCs, approved layout plans, land ownership records, and project permissions. For example, development approval requirements differ between CDA, LDA, RDA, KDA, and other relevant authorities.</p>

            <h4>Step 04 – Compare Development Projects</h4>
            <p>Compare projects offered by different developers according to their locations, property categories, infrastructure, development progress, and available facilities. Review the exact project phase or block you are interested in.</p>

            <h4>Step 05 – Review Prices and Payment Arrangements</h4>
            <p>Examine the complete property price and payment structure. Check booking amounts, down payments, instalments, development charges, transfer fees, and possession-related payments. Always review the written agreement and obtain official payment receipts.</p>

            <!-- Section 4 -->
            <h2>Residential vs. Commercial Property Developers</h2>
            <h3>Explore Different Types of Real Estate Development Companies</h3>
            <p>Pakistan's real estate industry includes developers working across different property categories. Understanding the differences between these development segments can help buyers identify companies that match their property interests.</p>

            <h4>Residential Property Developers</h4>
            <p>Residential developers focus on creating homes and communities for individuals and families. Their projects may include residential plots, apartment buildings, villas, townhouses, and planned housing societies. These developers often focus on community infrastructure, residential facilities, accessibility, and neighbourhood planning. Explore residential developers if you are researching housing societies, family homes, residential plots, or apartment developments.</p>

            <h4>Commercial Property Developers</h4>
            <p>Commercial developers focus on projects designed for business and commercial activities. Their developments may include shopping centres, office buildings, retail outlets, commercial plazas, and mixed-use developments. These projects are generally designed around business accessibility, commercial infrastructure, customer activity, and professional requirements. Explore commercial developers if you are researching retail investments, office spaces, or commercial property opportunities.</p>

            <h4>Mixed-Use Property Developers</h4>
            <p>Mixed-use developers create developments that combine residential, commercial, and lifestyle facilities within a planned project. These developments may feature apartments, retail spaces, offices, recreational facilities, and community amenities. Their purpose is to integrate different activities within a coordinated development environment.</p>

            <h4>Infrastructure and Housing Developers</h4>
            <p>Some companies specialise in large-scale infrastructure and housing development. Their work may involve land development, road networks, utilities, residential infrastructure, and master-planned communities. Understanding a developer's specialisation can help you identify companies with experience relevant to your intended property purchase.</p>

            <!-- Section 5 -->
            <h2>Popular Real Estate Markets in Pakistan</h2>
            <h3>Explore Leading Property Development Locations</h3>
            <p>Pakistan's real estate development industry spans several major cities and emerging residential markets. Explore some of the most recognised locations where developers and housing organisations operate.</p>

            <h4>Karachi</h4>
            <p>Karachi is Pakistan's largest metropolitan city and an important residential and commercial property market. The city features a wide variety of development projects, including apartment complexes, residential communities, commercial buildings, and housing societies. Explore DHA Karachi, Bahria Town Karachi, and other residential and commercial development areas.</p>

            <h4>Lahore</h4>
            <p>Lahore is a major centre for residential development and planned housing communities. The city's real estate market includes established housing societies, modern apartment projects, commercial developments, and large-scale residential communities. Explore developers operating in DHA Lahore, Bahria Town Lahore, Lake City, and other residential locations.</p>

            <h4>Islamabad</h4>
            <p>Islamabad offers residential and commercial development opportunities across established sectors and planned housing communities. The market includes residential plots, apartment projects, modern housing developments, and commercial properties. Explore DHA Islamabad, Capital Smart City, Bahria Enclave, and other development projects.</p>

            <h4>Rawalpindi</h4>
            <p>Rawalpindi has an active residential development market with a range of housing communities and property development projects. Explore developers and projects in Bahria Town Rawalpindi, DHA Rawalpindi, and surrounding residential areas.</p>

            <h4>Faisalabad</h4>
            <p>Faisalabad is an important industrial and commercial city with residential development opportunities. Explore housing societies, residential projects, commercial developments, and property developers operating in the city.</p>

            <h4>Multan</h4>
            <p>Multan's real estate market includes residential communities, housing societies, apartment projects, and commercial developments. Explore developers offering residential opportunities and planned communities in the region.</p>

            <h4>Peshawar</h4>
            <p>Peshawar offers different residential and commercial property development opportunities. Explore housing organisations, residential communities, and development companies operating across the city.</p>

            <h4>Gwadar</h4>
            <p>Gwadar attracts interest from buyers and investors exploring property opportunities connected with regional infrastructure and development initiatives. Research the relevant developer, land ownership, project documentation, and approval status before considering a property purchase.</p>

            <!-- Section 6 -->
            <h2>Leading Real Estate Developers in Pakistan</h2>
            <h3>Discover Recognised Property Development Companies</h3>
            <p>Explore some of the recognised names associated with Pakistan's real estate and property development industry.</p>

            <h4>Bahria Town</h4>
            <p>Discover large-scale residential communities, housing projects, and commercial developments across Pakistan.</p>

            <h4>Defence Housing Authority (DHA)</h4>
            <p>Explore residential and commercial development projects across different DHA locations. DHA is a development authority and should be distinguished from private developer companies.</p>

            <h4>Habib Rafiq Group</h4>
            <p>Discover the group's involvement in construction, engineering, infrastructure, and real estate development.</p>

            <h4>Zameen Developments</h4>
            <p>Explore residential and mixed-use development projects associated with Zameen Developments.</p>

            <h4>Future Developments Holdings (FDHL)</h4>
            <p>Discover the company associated with Capital Smart City and its planned residential and industrial development initiatives.</p>

            <h4>Royal Developers & Builders</h4>
            <p>Explore housing developments and planned residential communities associated with Royal Developers & Builders.</p>

            <h4>Lake City Holdings</h4>
            <p>Discover residential community and property development opportunities associated with Lake City in Lahore.</p>

            <p style="margin-top: 16px;">Compare company backgrounds, project portfolios, locations, and development information to understand the different opportunities available across Pakistan.</p>

        </article>
    </div>
</section>

<!-- 5. Frequently Asked Questions Section (Matching Site-Wide FAQ Component) -->
<section id="faq" aria-label="Frequently Asked Questions About Real Estate Developers in Pakistan" class="faqSection">
    <div class="container">
        <div class="section-header" style="text-align: center; margin-bottom: 35px;">
            <h2 style="font-size: 32px; font-weight: 700; color: #1a4731;">Frequently Asked Questions</h2>
            <p style="font-size: 15px; color: #666; margin-top: 8px;">Frequently Asked Questions About Real Estate Developers in Pakistan</p>
        </div>

        <div class="faqContainer">
            <div class="faqList">
                @php
                    $devMainFaqs = [
                        [
                            'q' => 'What is a real estate developer?',
                            'a' => 'A real estate developer is a company or organisation involved in planning, managing, and delivering property development projects. Its activities may include residential construction, housing societies, commercial developments, and infrastructure planning.',
                        ],
                        [
                            'q' => 'Who are the leading property developers in Pakistan?',
                            'a' => 'Some recognised names associated with Pakistan\'s property development industry include Bahria Town, Habib Rafiq Group, Zameen Developments, Royal Developers & Builders, and other development companies and organisations.',
                        ],
                        [
                            'q' => 'How can I find property developers in Pakistan?',
                            'a' => 'You can explore developer directories, official company websites, housing project information, and relevant property development resources. Compare company profiles and project portfolios to identify suitable developers.',
                        ],
                        [
                            'q' => 'How can I verify a property developer?',
                            'a' => 'Review the company\'s development history, completed projects, official documentation, relevant project approvals, land ownership information, and construction progress.',
                        ],
                        [
                            'q' => 'What is the difference between a developer and a housing society?',
                            'a' => 'A developer is a company or organisation responsible for planning and executing development projects. A housing society is a residential development or community that may be managed by a private developer, cooperative organisation, or public authority.',
                        ],
                        [
                            'q' => 'Are all housing societies in Pakistan approved?',
                            'a' => 'No. Not every advertised housing society or development project has the necessary approvals. Buyers should verify the current NOC and approved layout plan with the relevant development authority.',
                        ],
                        [
                            'q' => 'What information should I check before choosing a developer?',
                            'a' => 'Review the company\'s previous projects, legal documentation, approval status, construction quality, project progress, payment terms, and customer communication.',
                        ],
                        [
                            'q' => 'Can I compare different property developers online?',
                            'a' => 'Yes. Developer directories and official company websites can help you compare company profiles, project locations, development categories, and available project information.',
                        ],
                        [
                            'q' => 'Do property developers offer instalment plans?',
                            'a' => 'Many developers offer instalment-based payment arrangements for selected projects. The payment schedule, booking amount, and additional charges depend on the individual project.',
                        ],
                        [
                            'q' => 'Can overseas Pakistanis explore property developers in Pakistan?',
                            'a' => 'Yes. Overseas Pakistanis can research developers and housing projects through online resources and official company information. They should independently verify legal documentation and use secure payment channels.',
                        ],
                        [
                            'q' => 'How do I choose between residential and commercial developers?',
                            'a' => 'Your choice depends on your property requirements. Residential developers focus on housing and communities, while commercial developers specialise in business and retail properties. Some companies operate in both segments.',
                        ],
                    ];
                @endphp

                @foreach($devMainFaqs as $index => $faq)
                    <div class="faqItem {{ $index === 0 ? 'faqItemOpen' : '' }}" id="faqItem-{{ $index }}">
                        <button type="button" class="faqQuestion" onclick="toggleFaq({{ $index }}, event)" aria-expanded="{{ $index === 0 ? 'true' : 'false' }}">
                            <span>{{ $faq['q'] }}</span>
                            <span class="faqIcon">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </span>
                        </button>
                        <div class="faqAnswer {{ $index === 0 ? 'faqAnswerOpen' : '' }}" id="faqAnswer-{{ $index }}" style="{{ $index === 0 ? 'max-height: 500px;' : '' }}">
                            <p class="faqAnswerText">{{ $faq['a'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<script>
    function toggleFaq(index, e) {
        if (e) {
            e.preventDefault();
            e.stopPropagation();
        }
        const item = document.getElementById('faqItem-' + index);
        const answer = document.getElementById('faqAnswer-' + index);
        if (!item || !answer) return;
        const btn = item.querySelector('.faqQuestion');
        const isOpen = item.classList.contains('faqItemOpen');

        answer.style.removeProperty('display');

        if (isOpen) {
            item.classList.remove('faqItemOpen');
            answer.classList.remove('faqAnswerOpen');
            answer.style.maxHeight = '0px';
            btn?.setAttribute('aria-expanded', 'false');
        } else {
            item.classList.add('faqItemOpen');
            answer.classList.add('faqAnswerOpen');
            answer.style.maxHeight = '500px';
            btn?.setAttribute('aria-expanded', 'true');
        }
    }
</script>
@endsection
