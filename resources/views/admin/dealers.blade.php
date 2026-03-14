@extends('layouts.app')
@section('title', 'Dealers – Admin')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Dealers</h1>
        <p class="dashboard-subtitle">Dealer users and performance</p>
    </div>
</header>

<section class="dashboard-panel dashboard-table-panel">
    <div class="inquiries-search-section" style="margin-bottom:12px;">
        <div class="inquiries-search-row">
            <div class="inquiries-search-wrap">
                <span class="inquiries-search-icon"><i class="bi bi-search"></i></span>
                <input type="text" class="inquiries-search-input" id="dealersSearchInput" placeholder="Search table..." autocomplete="off">
            </div>
        </div>
    </div>
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table inquiries-table" id="dealersTable">
                <thead>
                    <tr class="inquiries-header-row">
                        <th data-col="userid" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">User ID</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="userid"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="email" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Email</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="email"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="postcode" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Postcode</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="postcode"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="city" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">City</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="city"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="active" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Active</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="active"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="company" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Company</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="company"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="alias" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Alias</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="alias"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="totallead" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Total lead</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="totallead"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="totalongoing" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Ongoing</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="totalongoing"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="totalclosed" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Total closed</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="totalclosed"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="totalfailed" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Failed</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="totalfailed"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                        <th data-col="conversionrate" class="inquiries-header-cell dashboard-table-sortable" title="Sort"><span class="inquiries-header-label">Conversion rate</span><span class="inquiries-filter-wrap"><input type="text" class="inquiries-grid-filter" data-col="conversionrate"><i class="bi bi-search inquiries-filter-icon"></i></span></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $r)
                        @php
                            $searchHaystack = strtolower(trim(($r->USERID ?? '').' '.($r->EMAIL ?? '').' '.($r->POSTCODE ?? '').' '.($r->CITY ?? '').' '.($r->COMPANY ?? '').' '.($r->ALIAS ?? '')));
                        @endphp
                        <tr class="dealer-row inquiry-row" data-search="{{ $searchHaystack }}">
                            <td data-col="userid">{{ $r->USERID }}</td>
                            <td data-col="email">{{ $r->EMAIL }}</td>
                            <td data-col="postcode">{{ $r->POSTCODE ?? '—' }}</td>
                            <td data-col="city">{{ $r->CITY ?? '—' }}</td>
                            <td data-col="active">{{ ($r->ISACTIVE ?? 0) ? 'Yes' : 'No' }}</td>
                            <td data-col="company">{{ $r->COMPANY ?? '—' }}</td>
                            <td data-col="alias">{{ $r->ALIAS ?? '—' }}</td>
                            <td data-col="totallead">{{ number_format((int)($r->TOTAL_LEAD ?? 0)) }}</td>
                            <td data-col="totalongoing">{{ number_format((int)($r->TOTAL_ONGOING ?? 0)) }}</td>
                            <td data-col="totalclosed">{{ number_format((int)($r->TOTAL_CLOSED ?? 0)) }}</td>
                            <td data-col="totalfailed">{{ number_format((int)($r->TOTAL_FAILED ?? 0)) }}</td>
                            <td data-col="conversionrate">{{ number_format((float)($r->CONVERSION_RATE ?? 0), 1) }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="12">No dealers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    var table = document.getElementById('dealersTable');
    if (!table) return;
    var state = { col: null, dir: 1 };

    function applyTableFilter() {
        var q = (document.getElementById('dealersSearchInput') && document.getElementById('dealersSearchInput').value) ? document.getElementById('dealersSearchInput').value.toLowerCase().trim() : '';
        var filters = {};
        table.querySelectorAll('thead .inquiries-grid-filter').forEach(function(inp) {
            var col = inp.getAttribute('data-col');
            var val = (inp.value || '').toLowerCase().trim();
            if (col && val) filters[col] = val;
        });
        table.querySelectorAll('tbody tr.dealer-row').forEach(function(row) {
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

    var searchInput = document.getElementById('dealersSearchInput');
    if (searchInput) searchInput.addEventListener('input', applyTableFilter);
    table.querySelectorAll('thead .inquiries-grid-filter').forEach(function(inp) {
        inp.addEventListener('input', applyTableFilter);
    });

    function getVal(row, col) {
        var cell = row.querySelector('td[data-col="' + col + '"]');
        return (cell && cell.textContent) ? cell.textContent.trim().toLowerCase() : '';
    }
    table.querySelectorAll('thead th[data-col]').forEach(function(th) {
        th.style.cursor = 'pointer';
        th.addEventListener('click', function() {
            var col = th.getAttribute('data-col');
            if (!col) return;
            state.dir = (state.col === col) ? -state.dir : 1;
            state.col = col;
            table.querySelectorAll('thead th[data-col]').forEach(function(h) {
                h.classList.remove('dashboard-sort-asc', 'dashboard-sort-desc');
                if (h.getAttribute('data-col') === col) {
                    h.classList.add(state.dir === 1 ? 'dashboard-sort-asc' : 'dashboard-sort-desc');
                }
            });
            var tbody = table.querySelector('tbody');
            var emptyRow = tbody.querySelector('tr:not(.dealer-row)');
            var rows = [].slice.call(tbody.querySelectorAll('tr.dealer-row'));
            rows.sort(function(a, b) {
                var va = getVal(a, col);
                var vb = getVal(b, col);
                var cmp = va.localeCompare(vb, undefined, { numeric: true });
                return state.dir * cmp;
            });
            rows.forEach(function(r) { tbody.appendChild(r); });
            if (emptyRow) tbody.appendChild(emptyRow);
        });
    });
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var openBtn = document.getElementById('openAddUserModal');
    var closeBtn = document.getElementById('closeAddUserModal');
    var modal = document.getElementById('addUserModal');
    if (!modal || !openBtn || !closeBtn) return;
    openBtn.addEventListener('click', function() { modal.style.display = 'flex'; });
    closeBtn.addEventListener('click', function() { modal.style.display = 'none'; });
    modal.addEventListener('click', function(e) {
        if (e.target === modal) modal.style.display = 'none';
    });
});
</script>
@endpush
@endsection
