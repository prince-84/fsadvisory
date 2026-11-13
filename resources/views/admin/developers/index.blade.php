@extends('admin.layouts.app')

@section('title', 'Manage Developers')

@push('styles')
<style>
    .adm-topbar { display: none !important; }
    .dev-list-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        margin-top: 20px;
        padding: 24px 28px;
    }
    .dev-search-bar {
        max-width: 260px;
        position: relative;
        margin-bottom: 24px;
    }
    .dev-search-input {
        width: 100%;
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 8px;
        padding: 9px 14px 9px 36px;
        font-size: 13.5px;
        color: #1e293b;
        outline: none;
        transition: all 0.2s ease;
    }
    .dev-search-input:focus {
        background: #ffffff;
        border-color: #38bdf8;
        box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.12);
    }
    .dev-search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        pointer-events: none;
    }
    .dev-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .dev-table th {
        padding: 14px 18px;
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        border-bottom: 1px solid #f1f5f9;
    }
    .dev-table td {
        padding: 16px 18px;
        font-size: 14px;
        color: #1e293b;
        border-bottom: 1px solid #f8fafc;
        vertical-align: middle;
    }
    .dev-table tr:hover td {
        background: #fafbfd;
    }
    .cms-action-btn {
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        border-radius: 6px;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .cms-action-btn:hover {
        color: #0284c7;
        background-color: #f0f9ff;
    }
    .cms-action-btn.cms-action-delete:hover {
        color: #ef4444 !important;
        background-color: #fef2f2 !important;
    }
    .add-dev-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 9px 18px;
        font-size: 13.5px;
        font-weight: 600;
        color: #0284c7;
        background: #ffffff;
        border: 1px solid #bae6fd;
        border-radius: 6px;
        text-decoration: none;
        transition: all 0.18s ease;
        box-shadow: 0 1px 2px rgba(2, 132, 199, 0.05);
    }
    .add-dev-btn:hover {
        background: #f0f9ff;
        border-color: #7dd3fc;
        color: #0369a1;
    }
</style>
@endpush

@section('content')
<div style="padding: 28px 32px;">
    @if(session('success'))
        <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 8px;">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Header Section (Matching Image 2) -->
    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 16px;">
        <div>
            <h1 style="font-size: 20px; font-weight: 700; color: #1e293b; margin: 0 0 4px 0; font-family: var(--font-display, 'Outfit', sans-serif); letter-spacing: -0.01em;">Developers</h1>
            <div style="font-size: 13px; color: #8c9ba5; font-weight: 400;">Home &ndash; Manage &ndash; Developers</div>
        </div>
        <div>
            <a href="{{ route('admin.developers.create') }}" class="add-dev-btn">
                Add Developer
            </a>
        </div>
    </div>

    <!-- Main Card Container -->
    <div class="dev-list-card">
        <!-- Search Input -->
        <div class="dev-search-bar">
            <svg class="dev-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
            <input type="text" id="devSearchInput" class="dev-search-input" placeholder="Search..." oninput="filterDevelopers(this.value)">
        </div>

        @if($developers->isEmpty())
            <!-- Empty state when no developer has been added yet -->
            <div style="padding: 60px 20px; text-align: center; color: #64748b;">
                <div style="width: 52px; height: 52px; margin: 0 auto 16px; border-radius: 12px; background: #f1f5f9; display: flex; align-items: center; justify-content: center; color: #94a3b8;">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="7" rx="2" ry="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/></svg>
                </div>
                <div style="font-weight: 700; font-size: 16px; color: #1e293b; margin-bottom: 20px;">No Developers Found</div>
                <a href="{{ route('admin.developers.create') }}" class="add-dev-btn" style="background: #0284c7; color: #ffffff; border-color: #0284c7;">
                    + Add Developer
                </a>
            </div>
        @else
            <!-- Table with strictly 3 Columns as requested: Number, Developer Name, Action -->
            <table class="dev-table" id="devTable">
                <thead>
                    <tr>
                        <th style="width: 80px;"># ^</th>
                        <th>DEVELOPER NAME</th>
                        <th style="width: 140px; text-align: right;">ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($developers as $index => $dev)
                        <tr class="dev-row-item">
                            <td style="color: #64748b; font-weight: 500;">{{ $index + 1 }}</td>
                            <td>
                                <strong style="color: #0f172a; font-weight: 600;" class="dev-name-text">{{ $dev->name }}</strong>
                                @if($dev->status === 'draft')
                                    <span style="display: inline-block; margin-left: 8px; font-size: 11px; padding: 2px 7px; border-radius: 4px; background: #fef3c7; color: #92400e; font-weight: 600; text-transform: uppercase;">Draft</span>
                                @endif
                            </td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; align-items: center; gap: 6px;">
                                    <a href="{{ route('admin.developers.edit', $dev->id) }}" class="cms-action-btn" title="Edit Developer">
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>
                                    </a>
                                    @if($dev->slug)
                                        <a href="{{ url('/developer/' . $dev->slug) }}" target="_blank" class="cms-action-btn" title="View Public Page">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="M9 9h6v6"/></svg>
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.developers.destroy', $dev->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete developer &quot;{{ $dev->name }}&quot;?');" style="margin: 0; display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="cms-action-btn cms-action-delete" style="border: none; background: transparent; cursor: pointer;" title="Delete Developer">
                                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 6h18M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterDevelopers(query) {
        const q = (query || '').toLowerCase().trim();
        const rows = document.querySelectorAll('.dev-row-item');
        rows.forEach(row => {
            const name = row.querySelector('.dev-name-text')?.textContent.toLowerCase() || '';
            if (name.includes(q)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }
</script>
@endpush
