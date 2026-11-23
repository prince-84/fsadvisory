@php
    $sbPageTitle = $page->title ?? ($community->name ?? ($city->name ?? ($project->title ?? ($developer->name ?? 'this property'))));
    $sbCurrentPath = ltrim(request()->path(), '/');
    $sbCurrentUrl = $sbCurrentPath ? ('https://fsadvisory.pk/' . $sbCurrentPath) : 'https://fsadvisory.pk';
    $sbAreaName = $project->community?->name ?? 'R. Hills';
    $sbWaMessage = "Hello FS Advisory, I am interested in {$sbPageTitle}. Please share details.\n{$sbCurrentUrl}";
    $sbWaUrl = 'https://wa.me/923322495575?text=' . rawurlencode($sbWaMessage);
@endphp

<div class="saimaStickySidebar" style="display: flex; flex-direction: column; gap: 16px;">
    <style>
        .fsSidebarCallBtn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            height: 46px;
            background: #ffffff;
            color: #0c2340 !important;
            font-size: 15px;
            font-weight: 700;
            border: 1.5px solid #0c2340;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.25s ease !important;
        }
        .fsSidebarCallBtn:hover {
            background: #BFA16A !important;
            color: #ffffff !important;
            border-color: #BFA16A !important;
            box-shadow: 0 4px 14px rgba(191, 161, 106, 0.3) !important;
        }
        .fsSidebarCallBtn:hover svg {
            stroke: #ffffff !important;
        }
        .saimaCustomLinksHeader {
            background: rgba(191, 161, 106, 0.12) !important;
            padding: 11px 16px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            color: #BFA16A !important;
            text-transform: uppercase !important;
            letter-spacing: 0.5px !important;
            border-bottom: 1px solid rgba(191, 161, 106, 0.25) !important;
        }
    </style>
    <!-- 1. Top Quick Actions (Image 2: WhatsApp & Call Buttons) -->
    <div class="fsSidebarActions" style="display: flex; flex-direction: column; gap: 8px;">
        <!-- WhatsApp Button -->
        <a href="{{ $sbWaUrl }}" target="_blank" rel="noopener noreferrer" class="fsSidebarWaBtn" style="display: flex; align-items: center; justify-content: center; gap: 8px; width: 100%; height: 42px; background: #25D366; color: #ffffff !important; font-size: 14.5px; font-weight: 700; border-radius: 8px; text-decoration: none; box-shadow: 0 4px 12px rgba(37, 211, 102, 0.28); transition: all 0.2s ease;">
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24" fill="currentColor">
                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.316 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.818-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
            </svg>
            <span>WhatsApp</span>
        </a>

        <!-- Call Button (Redirects/Scrolls down to Form) -->
        <button type="button" onclick="fsScrollToSidebarForm();" class="fsSidebarCallBtn" style="height: 42px; font-size: 14.5px;" onmouseover="this.style.background='#BFA16A'; this.style.borderColor='#BFA16A'; this.style.color='#ffffff';" onmouseout="this.style.background='#ffffff'; this.style.borderColor='#0c2340'; this.style.color='#0c2340';">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/>
            </svg>
            <span>Call +92 332 2495575</span>
        </button>
    </div>

    <!-- 2. Appointment Form Card -->
    <div class="saimaApptCard" id="saimaApptCardContainer" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 18px 16px; box-shadow: 0 4px 18px rgba(0,0,0,0.04);">
        <h3 class="saimaApptTitle" style="margin: 0 0 10px 0; font-size: 16.5px; font-weight: 800; color: #0c2340; letter-spacing: 0.5px; text-transform: uppercase;">BOOK AN APPOINTMENT</h3>
        
        <form id="saimaAppointmentForm" class="saimaApptForm" style="display: flex; flex-direction: column; gap: 9px;">
            <input type="text" name="name" class="saimaInput" placeholder="Name" required style="width: 100%; height: 38px; padding: 0 12px; border: 1px solid #dcdcdc; border-radius: 6px; font-size: 13.5px; color: #333; box-sizing: border-box; outline: none;">
            
            <div class="phoneUnifiedContainer" style="margin-bottom: 0; height: 38px !important; background: #fff !important; border: 1px solid #dcdcdc !important; border-radius: 6px !important; display: flex; align-items: center; box-sizing: border-box; width: 100%; max-width: 100%;">
                <div class="countryTriggerWrapper" style="position: relative; height: 100%;">
                    <button type="button" class="countryTriggerBtn" id="sidebarCountryBtn" aria-label="Country selector" style="height: 100%;">
                        <span class="flagSlot" id="sidebarFlagSlot">
                            <img src="https://flagcdn.com/w40/pk.png" srcset="https://flagcdn.com/w80/pk.png 2x" width="22" height="15" alt="Pakistan" class="flagImgUniversal" style="border-radius:2px;object-fit:cover;display:inline-block;vertical-align:middle;box-shadow:0 1px 2px rgba(0,0,0,0.18);flex-shrink:0;">
                        </span>
                        <span class="caretDown"></span>
                    </button>
                    <ul class="countryDropdownMenu" id="sidebarCountryDropdown" style="display: none; position: absolute; top: 100%; left: 0; background: #fff; border: 1px solid #ddd; max-height: 240px; overflow-y: auto; z-index: 1000; width: 280px; box-shadow: 0 8px 24px rgba(0,0,0,0.12); padding: 0; margin: 4px 0 0 0; list-style: none;"></ul>
                </div>
                <input type="tel" name="phone" id="saimaPhoneInput" class="phoneInputField" value="+92 " placeholder="+92 300 1234567" required style="flex: 1; min-width: 0; height: 100%; border: none; padding: 0 10px; font-size: 13.5px; outline: none; background: transparent; box-sizing: border-box;">
            </div>

            <input type="email" name="email" class="saimaInput" placeholder="Email" required style="width: 100%; height: 38px; padding: 0 12px; border: 1px solid #dcdcdc; border-radius: 6px; font-size: 13.5px; color: #333; box-sizing: border-box; outline: none;">

            <textarea name="comment" class="saimaTextarea" placeholder="Leave a comment here" rows="2" style="width: 100%; min-height: 48px; max-height: 72px; padding: 7px 12px; border: 1px solid #dcdcdc; border-radius: 6px; font-size: 13.5px; color: #333; resize: vertical; box-sizing: border-box; outline: none; font-family: inherit;"></textarea>

            <button type="submit" class="saimaSubmitBtn" style="width: 100%; height: 40px; background: #BFA16A; color: #fff; font-size: 13.5px; font-weight: 700; border: none; border-radius: 6px; cursor: pointer; letter-spacing: 0.5px; text-transform: uppercase; transition: background 0.2s ease;">SUBMIT</button>

            <div id="saimaFormSuccess" class="saimaSuccessMsg" style="display: none; padding: 10px; background: #f0fdf4; border: 1px solid #86efac; border-radius: 6px; color: #166534; font-size: 13px; text-align: center; font-weight: 600;">
                Thank you! Your appointment request has been submitted successfully.
            </div>
        </form>
    </div>

    <!-- 3. Latest 10 Area / Developer / Project Links (auto from CMS) -->
    @php
        $sbLinkStyle = 'color: #64748b; text-decoration: none; font-size: 13.5px; line-height: 1.4; transition: color 0.15s;';
        $sbLatestAreas = collect();
        $sbLatestDevs = collect();
        $sbLatestProjects = collect();
        try {
            $sbLatestAreas = \App\Models\Community::where('is_active', true)
                ->where(function ($q) { $q->whereNull('status')->orWhere('status', '!=', 'draft'); })
                ->orderBy('id', 'desc')->take(10)->get()
                ->map(fn($c) => ['name' => $c->name, 'url' => $c->url]);
            $sbLatestDevs = \App\Models\Developer::where('is_active', true)
                ->where(function ($q) { $q->whereNull('status')->orWhere('status', '!=', 'draft'); })
                ->orderBy('id', 'desc')->take(10)->get()
                ->map(fn($d) => ['name' => $d->name, 'url' => url('/developer/' . $d->slug)]);
            $sbLatestProjects = \App\Models\Project::where('is_active', true)
                ->where(function ($q) { $q->whereNull('status')->orWhere('status', '!=', 'draft'); })
                ->orderBy('id', 'desc')->take(10)->get()
                ->map(fn($p) => ['name' => $p->title, 'url' => $p->url]);
        } catch (\Throwable $e) {}
        $sbBlocks = [
            'AREA / COMMUNITY' => $sbLatestAreas,
            'DEVELOPER' => $sbLatestDevs,
            'PROJECT' => $sbLatestProjects,
        ];
    @endphp
    <div class="saimaCustomLinksWidget" style="background: #ffffff; border: 1px solid #e2e8f0; border-radius: 10px; box-shadow: 0 4px 18px rgba(0,0,0,0.04);">
        @foreach($sbBlocks as $sbHeading => $sbItems)
            @if($sbItems->isNotEmpty())
            <div class="saimaCustomLinksBlock" @if(!$loop->first) style="border-top: 1px solid rgba(191,161,106,0.2);" @endif>
                <div class="saimaCustomLinksHeader">{{ $sbHeading }}</div>
                <ul style="list-style: none; padding: 12px 16px; margin: 0; display: flex; flex-direction: column; gap: 9px;">
                    @foreach($sbItems as $sbItem)
                        <li><a href="{{ $sbItem['url'] }}" style="{{ $sbLinkStyle }}" onmouseover="this.style.color='#BFA16A'" onmouseout="this.style.color='#64748b'">{{ $sbItem['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
            @endif
        @endforeach
    </div>
</div>

<script>
function fsScrollToSidebarForm() {
    const card = document.getElementById('saimaApptCardContainer') || document.getElementById('saimaAppointmentForm');
    if (card) {
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
        setTimeout(() => {
            const phoneInput = card.querySelector('input[name="phone"]') || card.querySelector('input[name="name"]');
            if (phoneInput) phoneInput.focus();
        }, 400);
    }
}
</script>

