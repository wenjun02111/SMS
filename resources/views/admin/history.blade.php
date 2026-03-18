@extends('layouts.app')
@section('title', 'History - Admin')
@push('styles')
<style>
    #historyTable th[data-col="id"],
    #historyTable td[data-col="id"] {
        width: 88px;
        min-width: 88px;
    }
    #historyTable th[data-col="inquiryid"],
    #historyTable td[data-col="inquiryid"] {
        width: 120px;
        min-width: 120px;
    }
    #historyTable th[data-col="user"],
    #historyTable td[data-col="user"] {
        width: 96px;
        min-width: 96px;
    }

    #historyTable th[data-col="id"] .inquiries-filter-wrap input {
        width: 64px;
        max-width: 64px;
    }
    #historyTable th[data-col="inquiryid"] .inquiries-filter-wrap input {
        width: 92px;
        max-width: 92px;
    }
    #historyTable th[data-col="user"] .inquiries-filter-wrap input {
        width: 72px;
        max-width: 72px;
    }
    #historyTable th[data-col="id"] .inquiries-filter-wrap,
    #historyTable th[data-col="inquiryid"] .inquiries-filter-wrap,
    #historyTable th[data-col="user"] .inquiries-filter-wrap {
        width: fit-content;
    }
</style>
@endpush
@section('content')
<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table inquiries-table" id="historyTable">
                <thead>
                    <tr class="inquiries-header-row">
                        <th data-col="id" class="inquiries-header-cell"><span class="inquiries-header-label">ID</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="id"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="inquiryid" class="inquiries-header-cell"><span class="inquiries-header-label">Inquiry ID</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="inquiryid"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="user" class="inquiries-header-cell"><span class="inquiries-header-label">User</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="user"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="subject" class="inquiries-header-cell"><span class="inquiries-header-label">Subject</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="subject"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="description" class="inquiries-header-cell"><span class="inquiries-header-label">Description</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="description"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="status" class="inquiries-header-cell"><span class="inquiries-header-label">Status</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="status"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="date" class="inquiries-header-cell"><span class="inquiries-header-label">Date</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="date"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $r)
                        @php
                            $dateStr = $r->CREATIONDATE ? date('Y-m-d H:i', strtotime($r->CREATIONDATE)) : '';
                            $inquiryId = isset($r->LEADID) ? ('#SQL-' . $r->LEADID) : '';
                            $fullDesc = (string) ($r->DESCRIPTION ?? '');
                            $fullDescTrim = trim($fullDesc);
                            $descPreview = $fullDescTrim === '' ? '-' : (mb_strlen($fullDescTrim) > 50 ? (mb_substr($fullDescTrim, 0, 50) . '...') : $fullDescTrim);
                            $isLongDesc = $fullDescTrim !== '' && mb_strlen($fullDescTrim) > 50;
                            $searchHaystack = strtolower(($r->LEAD_ACTID ?? '').' '.$inquiryId.' '.($r->USERID ?? '').' '.($r->SUBJECT ?? '').' '.$fullDescTrim.' '.($r->STATUS ?? '').' '.$dateStr);
                        @endphp
                        <tr class="history-row inquiry-row" data-search="{{ $searchHaystack }}">
                            <td data-col="id">{{ $r->LEAD_ACTID }}</td>
                            <td data-col="inquiryid">{{ $inquiryId }}</td>
                            <td data-col="user">{{ $r->USERID }}</td>
                            <td data-col="subject">{{ $r->SUBJECT ?? '-' }}</td>
                            <td data-col="description"
                                class="inquiries-msg-cell {{ $isLongDesc ? 'inquiries-msg-clickable' : '' }}"
                                @if($isLongDesc) data-full-message="{{ e($fullDescTrim) }}" @endif>
                                {{ $descPreview }}
                            </td>
                            <td data-col="status">{{ $r->STATUS ?? '-' }}</td>
                            <td data-col="date">{{ $dateStr ?: '-' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No activities yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = document.getElementById('historyTable');
    if (!table) return;
    function applyTableFilter() {
        var searchInput = document.getElementById('historySearchInput');
        var q = (searchInput && searchInput.value) ? searchInput.value.toLowerCase().trim() : '';
        var filters = {};
        table.querySelectorAll('thead .inquiries-grid-filter').forEach(function(inp) {
            var col = inp.getAttribute('data-col');
            var val = (inp.value || '').toLowerCase().trim();
            if (col && val) filters[col] = val;
        });
        table.querySelectorAll('tbody tr.history-row').forEach(function(row) {
            var hay = (row.getAttribute('data-search') || '').toLowerCase();
            var searchMatch = !q || hay.indexOf(q) !== -1;
            var colMatch = true;
            for (var col in filters) {
                var cell = row.querySelector('td[data-col="' + col + '"]');
                var cellText = (cell && cell.textContent) ? cell.textContent.toLowerCase().trim() : '';
                if (cellText.indexOf(filters[col]) === -1) { colMatch = false; break; }
            }
            row.style.display = (searchMatch && colMatch) ? '' : 'none';
        });
    }
    var searchInput = document.getElementById('historySearchInput');
    if (searchInput) searchInput.addEventListener('input', applyTableFilter);
    table.querySelectorAll('thead .inquiries-grid-filter').forEach(function(inp) {
        inp.addEventListener('input', applyTableFilter);
    });

    (function initMessageModal() {
        if (document.getElementById('inquiryMessageModal')) return;
        var modal = document.createElement('div');
        modal.id = 'inquiryMessageModal';
        modal.className = 'inquiries-msg-modal';
        modal.hidden = true;
        modal.innerHTML = ''
            + '<div class="inquiries-msg-modal-backdrop" data-close="1"></div>'
            + '<div class="inquiries-msg-modal-window" role="dialog" aria-modal="true" aria-labelledby="inquiriesMsgModalTitle">'
            + '  <div class="inquiries-msg-modal-header">'
            + '    <div class="inquiries-msg-modal-title" id="inquiriesMsgModalTitle">Description</div>'
            + '    <button type="button" class="inquiries-msg-modal-close" aria-label="Close" data-close="1">&times;</button>'
            + '  </div>'
            + '  <div class="inquiries-msg-modal-body"><pre class="inquiries-msg-modal-text" id="inquiriesMsgModalText"></pre></div>'
            + '</div>';
        document.body.appendChild(modal);

        function close() { modal.hidden = true; }
        function open(text) {
            var el = document.getElementById('inquiriesMsgModalText');
            if (el) el.textContent = text || '';
            modal.hidden = false;
        }

        document.addEventListener('click', function(e) {
            var cell = e.target && e.target.closest ? e.target.closest('.inquiries-msg-clickable[data-full-message]') : null;
            if (cell) {
                open(cell.getAttribute('data-full-message') || '');
                return;
            }
            var closer = e.target && e.target.closest ? e.target.closest('[data-close="1"]') : null;
            if (closer && modal && !modal.hidden && modal.contains(closer)) close();
        });
        window.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.hidden) close();
        });
    })();
});
</script>
@endpush
