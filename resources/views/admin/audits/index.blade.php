@extends('admin.layouts.app')

@section('title', 'Audit Logs & Activity History')
@section('eyebrow', 'Site Settings')
@section('heading', 'Audit Logs & Activity History')
@section('subheading', 'Real-time automatic tracking of all CRUD actions (Create, Update, Delete) across CMS models with old vs new changes.')

@section('content')
<!-- Stats Overview Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <div class="adm-card" style="padding: 18px; display: flex; align-items: center; gap: 14px; border-left: 4px solid #1a4731;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #e8f5e9; color: #1a4731; display: flex; align-items: center; justify-content: center;">
            @include('admin.partials.icon', ['name' => 'shield', 'size' => 22])
        </div>
        <div>
            <div style="font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase;">Total Logs</div>
            <div style="font-size: 24px; font-weight: 800; color: #111827;">{{ number_format($stats['total']) }}</div>
        </div>
    </div>

    <div class="adm-card" style="padding: 18px; display: flex; align-items: center; gap: 14px; border-left: 4px solid #10b981;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #ecfdf5; color: #10b981; display: flex; align-items: center; justify-content: center;">
            @include('admin.partials.icon', ['name' => 'plus', 'size' => 20])
        </div>
        <div>
            <div style="font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase;">Created</div>
            <div style="font-size: 24px; font-weight: 800; color: #10b981;">{{ number_format($stats['created']) }}</div>
        </div>
    </div>

    <div class="adm-card" style="padding: 18px; display: flex; align-items: center; gap: 14px; border-left: 4px solid #3b82f6;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #eff6ff; color: #3b82f6; display: flex; align-items: center; justify-content: center;">
            @include('admin.partials.icon', ['name' => 'edit', 'size' => 20])
        </div>
        <div>
            <div style="font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase;">Updated</div>
            <div style="font-size: 24px; font-weight: 800; color: #3b82f6;">{{ number_format($stats['updated']) }}</div>
        </div>
    </div>

    <div class="adm-card" style="padding: 18px; display: flex; align-items: center; gap: 14px; border-left: 4px solid #ef4444;">
        <div style="width: 44px; height: 44px; border-radius: 10px; background: #fef2f2; color: #ef4444; display: flex; align-items: center; justify-content: center;">
            @include('admin.partials.icon', ['name' => 'trash', 'size' => 20])
        </div>
        <div>
            <div style="font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase;">Deleted</div>
            <div style="font-size: 24px; font-weight: 800; color: #ef4444;">{{ number_format($stats['deleted']) }}</div>
        </div>
    </div>
</div>

<!-- Filters Card -->
<div class="adm-card" style="margin-bottom: 20px; padding: 18px;">
    <form method="GET" action="{{ route('admin.audits.index') }}" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: flex-end;">
        <div style="flex: 1; min-width: 180px;">
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px;">Search Keywords / IP / ID</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="e.g. 127.0.0.1 or Saima" class="adm-input" style="height: 38px; font-size: 13px;">
        </div>

        <div style="width: 150px;">
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px;">Action Event</label>
            <select name="event" class="adm-input" style="height: 38px; font-size: 13px;">
                <option value="">All Events</option>
                <option value="created" {{ request('event') === 'created' ? 'selected' : '' }}>Created</option>
                <option value="updated" {{ request('event') === 'updated' ? 'selected' : '' }}>Updated</option>
                <option value="deleted" {{ request('event') === 'deleted' ? 'selected' : '' }}>Deleted</option>
            </select>
        </div>

        <div style="width: 170px;">
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px;">Model Section</label>
            <select name="model" class="adm-input" style="height: 38px; font-size: 13px;">
                <option value="">All Models</option>
                @foreach($availableModels as $key => $label)
                    <option value="{{ $key }}" {{ request('model') === $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div style="width: 140px;">
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px;">From Date</label>
            <input type="date" name="from_date" value="{{ request('from_date') }}" class="adm-input" style="height: 38px; font-size: 13px;">
        </div>

        <div style="width: 140px;">
            <label style="display: block; font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 5px;">To Date</label>
            <input type="date" name="to_date" value="{{ request('to_date') }}" class="adm-input" style="height: 38px; font-size: 13px;">
        </div>

        <div style="display: flex; gap: 8px;">
            <button type="submit" class="adm-btn adm-btn-primary" style="height: 38px; padding: 0 16px;">
                @include('admin.partials.icon', ['name' => 'search']) Filter
            </button>
            @if(request()->hasAny(['search', 'event', 'model', 'from_date', 'to_date']))
                <a href="{{ route('admin.audits.index') }}" class="adm-btn" style="height: 38px; padding: 0 14px; background: #f3f4f6; color: #374151;">
                    Reset
                </a>
            @endif
        </div>
    </form>
</div>

<!-- Logs Table -->
<div class="adm-card">
    <div style="overflow-x: auto;">
        <table class="adm-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="width: 60px;">#ID</th>
                    <th style="width: 180px;">User</th>
                    <th style="width: 110px;">Action</th>
                    <th>Model / Item</th>
                    <th>Modified Fields</th>
                    <th style="width: 140px;">IP Address</th>
                    <th style="width: 160px;">Date & Time</th>
                    <th style="text-align: right; width: 110px;">Details</th>
                </tr>
            </thead>
            <tbody>
                @forelse($audits as $audit)
                    @php
                        $modelName = class_basename($audit->auditable_type);
                        $badgeBg = '#f3f4f6';
                        $badgeColor = '#374151';
                        if ($audit->event === 'created') {
                            $badgeBg = '#dcfce7'; $badgeColor = '#15803d';
                        } elseif ($audit->event === 'updated') {
                            $badgeBg = '#dbeafe'; $badgeColor = '#1d4ed8';
                        } elseif ($audit->event === 'deleted') {
                            $badgeBg = '#fee2e2'; $badgeColor = '#b91c1c';
                        }
                        $oldVals = (array) ($audit->old_values ?? []);
                        $newVals = (array) ($audit->new_values ?? []);
                        $changedKeys = array_unique(array_merge(array_keys($oldVals), array_keys($newVals)));
                    @endphp
                    <tr>
                        <td style="color: #6b7280; font-size: 12px; font-weight: 600;">#{{ $audit->id }}</td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: #1a4731; color: #ffffff; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 13px;">
                                    {{ strtoupper(substr($audit->user->name ?? 'S', 0, 1)) }}
                                </div>
                                <div>
                                    <strong style="color: #111827; font-size: 13px; display: block;">{{ $audit->user->name ?? 'System / Guest' }}</strong>
                                    <span style="font-size: 11px; color: #6b7280;">{{ $audit->user->email ?? '-' }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="adm-chip" style="background: {{ $badgeBg }}; color: {{ $badgeColor }}; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 4px 10px; border-radius: 6px;">
                                {{ $audit->event }}
                            </span>
                        </td>
                        <td>
                            <strong style="color: #1f2937; font-size: 13px;">{{ $modelName }}</strong>
                            <span style="color: #6b7280; font-size: 12px;">(ID: #{{ $audit->auditable_id }})</span>
                        </td>
                        <td>
                            <div style="display: flex; flex-wrap: wrap; gap: 4px; max-width: 320px;">
                                @if(empty($changedKeys))
                                    <span style="color: #9ca3af; font-size: 12px;">No fields changed</span>
                                @else
                                    @foreach(array_slice($changedKeys, 0, 4) as $k)
                                        <span style="background: #f3f4f6; color: #374151; font-size: 11px; padding: 2px 7px; border-radius: 4px; border: 1px solid #e5e7eb; font-family: monospace;">{{ $k }}</span>
                                    @endforeach
                                    @if(count($changedKeys) > 4)
                                        <span style="color: #6b7280; font-size: 11px;">+{{ count($changedKeys) - 4 }} more</span>
                                    @endif
                                @endif
                            </div>
                        </td>
                        <td>
                            <code style="font-size: 12px; color: #4b5563; background: #f9fafb; padding: 2px 6px; border-radius: 4px; border: 1px solid #e5e7eb;">{{ $audit->ip_address ?? '127.0.0.1' }}</code>
                        </td>
                        <td>
                            <div style="font-size: 12.5px; color: #111827; font-weight: 500;">{{ $audit->created_at->format('M d, Y h:i A') }}</div>
                            <div style="font-size: 11px; color: #9ca3af;">{{ $audit->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="text-align: right;">
                            <button type="button" class="adm-btn" onclick="openAuditModal({{ $audit->id }})" style="padding: 5px 12px; font-size: 12px; background: #faf8f5; border: 1px solid #ede8e1; color: #1a4731; font-weight: 600;">
                                @include('admin.partials.icon', ['name' => 'eye', 'size' => 14]) View
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; padding: 40px 20px; color: #6b7280;">
                            <div style="font-size: 15px; font-weight: 600; margin-bottom: 4px;">No audit records found</div>
                            <div style="font-size: 13px;">Changes made to pages, projects, blogs, amenities, or settings will automatically appear here.</div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($audits->hasPages())
        <div style="padding: 16px 20px; border-top: 1px solid #e5e7eb;">
            {{ $audits->links() }}
        </div>
    @endif
</div>

<!-- Modal: Old Values vs New Values Comparison -->
<div id="auditDetailModal" style="display: none; position: fixed; inset: 0; z-index: 9999; background: rgba(0, 0, 0, 0.55); align-items: center; justify-content: center; padding: 20px;">
    <div style="background: #ffffff; border-radius: 12px; max-width: 800px; width: 100%; max-height: 90vh; display: flex; flex-direction: column; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2);">
        
        <!-- Modal Header -->
        <div style="padding: 18px 24px; border-bottom: 1px solid #e5e7eb; display: flex; align-items: center; justify-content: space-between;">
            <div>
                <h3 id="modalTitle" style="margin: 0; font-size: 17px; font-weight: 700; color: #111827;">Audit Record Details</h3>
                <span id="modalSubtitle" style="font-size: 12px; color: #6b7280;"></span>
            </div>
            <button type="button" onclick="closeAuditModal()" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #9ca3af; line-height: 1;">&times;</button>
        </div>

        <!-- Modal Body -->
        <div style="padding: 20px 24px; overflow-y: auto; flex: 1;">
            <!-- Meta Details Grid -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; background: #faf8f5; border: 1px solid #ede8e1; border-radius: 8px; padding: 14px; margin-bottom: 20px;">
                <div>
                    <span style="display: block; font-size: 11px; text-transform: uppercase; color: #6b7280; font-weight: 700;">User</span>
                    <strong id="modalUser" style="font-size: 13px; color: #111827;">-</strong>
                </div>
                <div>
                    <span style="display: block; font-size: 11px; text-transform: uppercase; color: #6b7280; font-weight: 700;">Event Action</span>
                    <span id="modalEvent" style="font-size: 12px; font-weight: 700; text-transform: uppercase;">-</span>
                </div>
                <div>
                    <span style="display: block; font-size: 11px; text-transform: uppercase; color: #6b7280; font-weight: 700;">IP Address</span>
                    <span id="modalIp" style="font-size: 12.5px; font-family: monospace; color: #111827;">-</span>
                </div>
                <div>
                    <span style="display: block; font-size: 11px; text-transform: uppercase; color: #6b7280; font-weight: 700;">Date & Time</span>
                    <span id="modalDate" style="font-size: 12.5px; color: #111827;">-</span>
                </div>
            </div>

            <!-- Old vs New Values Comparison Table -->
            <h4 style="margin: 0 0 10px 0; font-size: 14px; font-weight: 700; color: #1f2937;">Changes Comparison (Old vs New)</h4>
            <div style="border: 1px solid #e5e7eb; border-radius: 8px; overflow: hidden;">
                <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                    <thead>
                        <tr style="background: #f9fafb; border-bottom: 1px solid #e5e7eb; text-align: left;">
                            <th style="padding: 10px 14px; width: 22%;">Field</th>
                            <th style="padding: 10px 14px; width: 39%; background: #fef2f2; color: #991b1b;">Old Value (Before)</th>
                            <th style="padding: 10px 14px; width: 39%; background: #f0fdf4; color: #166534;">New Value (After)</th>
                        </tr>
                    </thead>
                    <tbody id="modalDiffBody">
                        <!-- Loaded dynamically -->
                    </tbody>
                </table>
            </div>

            <!-- URL Details -->
            <div style="margin-top: 16px; font-size: 12px; color: #6b7280;">
                <strong>Request URL:</strong> <code id="modalUrl" style="background: #f3f4f6; padding: 2px 6px; border-radius: 4px; word-break: break-all;"></code>
            </div>
        </div>

        <!-- Modal Footer -->
        <div style="padding: 14px 24px; border-top: 1px solid #e5e7eb; text-align: right; background: #fafafa; border-radius: 0 0 12px 12px;">
            <button type="button" onclick="closeAuditModal()" class="adm-btn" style="background: #ffffff; border: 1px solid #d1d5db; color: #374151;">Close</button>
        </div>
    </div>
</div>

<script>
function openAuditModal(auditId) {
    const modal = document.getElementById('auditDetailModal');
    const tbody = document.getElementById('modalDiffBody');
    tbody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px; color:#6b7280;">Loading details...</td></tr>';
    modal.style.display = 'flex';

    fetch(`/admin/audits/${auditId}`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('modalTitle').textContent = `Audit #${data.id} — ${data.model} (#${data.model_id})`;
            document.getElementById('modalSubtitle').textContent = `Action: ${data.event.toUpperCase()} • ${data.date_formatted} (${data.date_diff})`;
            document.getElementById('modalUser').textContent = `${data.user_name} (${data.user_email})`;
            document.getElementById('modalEvent').textContent = data.event;
            document.getElementById('modalIp').textContent = data.ip_address;
            document.getElementById('modalDate').textContent = data.date_formatted;
            document.getElementById('modalUrl').textContent = data.url || '-';

            // Event color styling
            const evEl = document.getElementById('modalEvent');
            if (data.event === 'created') {
                evEl.style.color = '#15803d';
            } else if (data.event === 'updated') {
                evEl.style.color = '#1d4ed8';
            } else if (data.event === 'deleted') {
                evEl.style.color = '#b91c1c';
            }

            const oldVals = data.old_values || {};
            const newVals = data.new_values || {};
            const allKeys = Array.from(new Set([...Object.keys(oldVals), ...Object.keys(newVals)]));

            if (allKeys.length === 0) {
                tbody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px; color:#6b7280;">No field modifications recorded.</td></tr>';
                return;
            }

            let html = '';
            allKeys.forEach(key => {
                const oldV = formatVal(oldVals[key]);
                const newV = formatVal(newVals[key]);

                html += `
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 10px 14px; font-weight: 600; color: #374151; font-family: monospace;">${escapeHtml(key)}</td>
                        <td style="padding: 10px 14px; background: #fff5f5; color: #991b1b; word-break: break-all;">${oldV}</td>
                        <td style="padding: 10px 14px; background: #f6fef9; color: #166534; word-break: break-all;">${newV}</td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        })
        .catch(err => {
            tbody.innerHTML = '<tr><td colspan="3" style="text-align:center; padding:20px; color:#ef4444;">Failed to load audit record.</td></tr>';
        });
}

function closeAuditModal() {
    document.getElementById('auditDetailModal').style.display = 'none';
}

function formatVal(v) {
    if (v === undefined || v === null) return '<em style="color:#9ca3af;">(none)</em>';
    if (typeof v === 'boolean') return v ? 'true' : 'false';
    if (typeof v === 'object') return '<pre style="margin:0; font-size:11px; white-space:pre-wrap;">' + escapeHtml(JSON.stringify(v, null, 2)) + '</pre>';
    const str = String(v);
    if (str.trim() === '') return '<em style="color:#9ca3af;">(empty)</em>';
    return escapeHtml(str);
}

function escapeHtml(str) {
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') closeAuditModal();
});
</script>
@endsection

