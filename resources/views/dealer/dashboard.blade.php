@extends('layouts.app')
@section('title', 'Dashboard – SQL LMS Dealer Console')
@section('content')
<div class="dashboard-content dealer-dashboard-content">
    <header class="dashboard-header">
        <div>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">Overview of inquiries and performance metrics</p>
        </div>
    </header>

    {{-- Summary Cards --}}
    <div class="dealer-metrics">
        <div class="dealer-metric-card">
            <div class="dealer-metric-header">
                <div class="dealer-metric-icon dealer-metric-icon-inquiries">
                    <i class="bi bi-people"></i>
                </div>
                <span class="dealer-metric-trend dealer-metric-trend-up">+12% <i class="bi bi-arrow-up"></i></span>
            </div>
            <div class="dealer-metric-label">My Active Inquiries</div>
            <div class="dealer-metric-value">{{ $metrics['activeInquiries'] ?? 42 }}</div>
        </div>
        <div class="dealer-metric-card">
            <div class="dealer-metric-header">
                <div class="dealer-metric-icon dealer-metric-icon-pending">
                    <i class="bi bi-clock"></i>
                </div>
                <span class="dealer-metric-trend dealer-metric-trend-critical">CRITICAL</span>
            </div>
            <div class="dealer-metric-label">Pending Follow-ups</div>
            <div class="dealer-metric-value">{{ $metrics['pendingFollowups'] ?? 8 }}</div>
        </div>
        <div class="dealer-metric-card">
            <div class="dealer-metric-header">
                <div class="dealer-metric-icon dealer-metric-icon-demos">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <span class="dealer-metric-trend dealer-metric-trend-up">+5 <i class="bi bi-arrow-up"></i></span>
            </div>
            <div class="dealer-metric-label">My Closed Case</div>
            <div class="dealer-metric-value">{{ $metrics['closedCaseCount'] ?? 0 }}</div>
        </div>
        <div class="dealer-metric-card">
            <div class="dealer-metric-header">
                <div class="dealer-metric-icon dealer-metric-icon-conversion">
                    <i class="bi bi-graph-up"></i>
                </div>
                <span class="dealer-metric-trend dealer-metric-trend-down">-2% <i class="bi bi-arrow-down"></i></span>
            </div>
            <div class="dealer-metric-label">My Conversion Rate</div>
            <div class="dealer-metric-value">{{ $metrics['conversionRate'] ?? 0 }}%</div>
        </div>
    </div>

    {{-- Main Row: My Inquiries + Upcoming Demos --}}
    <div class="dealer-dashboard-main">
        <div class="dealer-dashboard-main-left">
            <div class="dealer-panel dealer-inquiries-panel">
                <div class="dealer-panel-header">
                    <div class="dealer-panel-title-row">
                        <div class="dealer-panel-icon dealer-panel-icon-demos">
                            <i class="bi bi-folder2"></i>
                        </div>
                        <h2 class="dealer-panel-title">My Inquiries</h2>
                    </div>
                    <a href="{{ route('dealer.inquiries') }}" class="dealer-link-btn">View All Inquiries</a>
                </div>
                <div class="dealer-table-wrapper">
                    <div class="dealer-table-header">
                        <span>INQUIRY ID</span>
                        <span>CUSTOMER</span>
                        <span>LAST STATUS UPDATE</span>
                        <span>PROGRESS STAGE</span>
                        <span>NEXT FOLLOW-UP</span>
                    </div>
                    @forelse(($leads ?? []) as $i => $r)
                        @php
                            $status = strtoupper($r->CURRENTSTATUS ?? 'PENDING');
                            $stages = ['PENDING','FOLLOW UP','DEMO','CASE CONFIRMED','CASE COMPLETED','REWARD DISTRIBUTED'];
                            $idx = array_search($status, $stages);
                            $idx = $idx !== false ? $idx : 0;
                            $filledCount = $idx + 1;
                            $displayStatus = in_array($status, $stages) ? $status : 'PENDING';
                            $rowPage = (int) floor($i / ($inquiriesPerPage ?? 6)) + 1;
                        @endphp
                        <div class="dealer-table-row dealer-inquiry-row" data-page="{{ $rowPage }}">
                            <span class="dealer-inquiry-id">#LX-{{ $r->LEADID }}</span>
                            <span>{{ $r->CONTACTNAME ? 'Mr/Ms ' . $r->CONTACTNAME : ($r->COMPANYNAME ?? '—') }}</span>
                            <span>{{ $r->LASTMODIFIED ? date('M j, Y', strtotime($r->LASTMODIFIED)) : '—' }}</span>
                            <div class="dealer-progress-cell">
                                <span class="dealer-progress-text">{{ $displayStatus }}</span>
                                <div class="dealer-status-bar">
                                    @for($i = 0; $i < 6; $i++)
                                        @php
                                            $isFilled = $i < $filledCount;
                                            $segmentColor = $i < 2 ? 'red' : ($i < 4 ? 'yellow' : 'green');
                                        @endphp
                                        <div class="dealer-status-segment dealer-status-segment--{{ $segmentColor }} {{ $isFilled ? 'dealer-status-segment--filled' : '' }}"></div>
                                    @endfor
                                </div>
                            </div>
                            <span>{{ $idx < 4 ? ($r->LASTMODIFIED ? date('M j, Y', strtotime($r->LASTMODIFIED . ' +3 days')) : 'N/A') : 'N/A' }}</span>
                        </div>
                    @empty
                        <div class="dealer-table-empty">No inquiries assigned yet.</div>
                    @endforelse
                </div>
                <div class="dealer-table-footer">
                    @php
                        $leadsTotal = $leadsTotal ?? 0;
                        $inquiriesTotalPages = max(1, $inquiriesTotalPages ?? 1);
                        $inquiriesPerPage = $inquiriesPerPage ?? 6;
                    @endphp
                    <span class="dealer-table-count" id="inquiriesCountText">Showing 0 of {{ $leadsTotal }} inquiries</span>
                    <div class="dealer-pagination" id="inquiriesPagination"
                         data-total="{{ $leadsTotal }}"
                         data-per-page="{{ $inquiriesPerPage }}"
                         data-total-pages="{{ $inquiriesTotalPages }}">
                        <button type="button" class="dealer-pagination-btn" id="inquiriesPrevBtn" title="Previous page"><i class="bi bi-chevron-left"></i></button>
                        <div class="dealer-pagination-pages" id="inquiriesPageNumbers"></div>
                        <button type="button" class="dealer-pagination-btn" id="inquiriesNextBtn" title="Next page"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="dealer-dashboard-main-right">
            <div class="dealer-panel dealer-closed-case-panel">
                <div class="dealer-panel-header dealer-panel-header--no-action">
                    <div class="dealer-panel-title-row">
                        <div class="dealer-panel-icon dealer-panel-icon-demos">
                            <i class="bi bi-bar-chart-fill"></i>
                        </div>
                        <h2 class="dealer-panel-title">My Closed Case</h2>
                    </div>
                    <div class="dealer-chart-period-selector">
                        <button type="button" class="dealer-chart-period-btn dealer-chart-period-btn--active" data-period="week">Week</button>
                        <button type="button" class="dealer-chart-period-btn" data-period="month">Month</button>
                        <button type="button" class="dealer-chart-period-btn" data-period="year">Year</button>
                    </div>
                </div>
                <div class="dealer-closed-case-chart dealer-chart-period-week" id="closedCaseChart"
                     data-week="{{ json_encode($closedCaseChartData['week'] ?? []) }}"
                     data-month="{{ json_encode($closedCaseChartData['month'] ?? []) }}"
                     data-year="{{ json_encode($closedCaseChartData['year'] ?? []) }}">
                    @php
                        $chartData = $closedCaseChartData['week'] ?? [];
                        $maxCount = max(1, collect($chartData)->pluck('count')->max() ?? 1);
                    @endphp
                    <div class="dealer-bar-chart-bars" id="closedCaseChartBars">
                        @foreach($chartData as $item)
                            <div class="dealer-bar-chart-bar-wrap">
                                <div class="dealer-bar-chart-bar" style="height: {{ ($item->count / $maxCount) * 100 }}%"></div>
                            </div>
                        @endforeach
                    </div>
                    <div class="dealer-bar-chart-xaxis" id="closedCaseChartXaxis">
                        @foreach($chartData as $item)
                            <span>{{ $item->label }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="dealer-panel dealer-alert-panel">
                <div class="dealer-panel-header dealer-panel-header--simple">
                    <div class="dealer-panel-title-row">
                        <span class="dealer-alert-panel-icon"><i class="bi bi-exclamation-circle-fill"></i></span>
                        <h2 class="dealer-panel-title">High Priority Follow-ups</h2>
                    </div>
                </div>
                <div class="dealer-alert-list">
                    @foreach($highPriorityFollowups ?? [] as $h)
                        <div class="dealer-alert-item dealer-alert-item--{{ strtolower(str_replace(' ', '-', $h->status)) }}">
                            <div class="dealer-alert-top">
                                <span class="dealer-alert-badge dealer-alert-badge--{{ $h->status === 'OVERDUE' ? 'overdue' : 'due' }}">{{ $h->status }}</span>
                                <span class="dealer-alert-time">{{ $h->time }}</span>
                            </div>
                            <div class="dealer-alert-main">
                                <span class="dealer-alert-title">{{ $h->inquiryId }} {{ $h->contact }}</span>
                                <span class="dealer-alert-subtitle">{{ $h->product }}</span>
                            </div>
                            <div class="dealer-alert-actions">
                                <button type="button" class="dealer-primary-pill">Email Now</button>
                                <button type="button" class="dealer-secondary-pill">Skip</button>
                            </div>
                        </div>
                    @endforeach
                    @if(empty($highPriorityFollowups))
                        <div class="dealer-alert-empty">No follow-ups due at the moment.</div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <footer class="dashboard-bottombar">
        <div class="dashboard-bottombar-left">
            <button type="button" class="dashboard-sync-btn" title="Refresh"><i class="bi bi-arrow-clockwise dashboard-sync-icon"></i></button>
            <div class="dashboard-sync-text">
                <span class="dashboard-sync-title">SYSTEM SYNC STATUS</span>
                <span class="dashboard-sync-time">Last synced: {{ date('M j, Y, g:i A') }}</span>
            </div>
        </div>
        <div class="dashboard-bottombar-right">
            © Copyright {{ date('Y') }} SQL Lead Management System. All rights reserved.
        </div>
    </footer>
</div>
@push('scripts')
<script>
(function() {
    var chartEl = document.getElementById('closedCaseChart');
    var barsEl = document.getElementById('closedCaseChartBars');
    var xaxisEl = document.getElementById('closedCaseChartXaxis');
    var periodBtns = document.querySelectorAll('.dealer-chart-period-btn');
    if (!chartEl || !barsEl || !xaxisEl || !periodBtns.length) return;

    var data = {
        week: JSON.parse(chartEl.getAttribute('data-week') || '[]'),
        month: JSON.parse(chartEl.getAttribute('data-month') || '[]'),
        year: JSON.parse(chartEl.getAttribute('data-year') || '[]')
    };

    function renderChart(period) {
        var items = data[period] || [];
        var maxCount = Math.max(1, Math.max.apply(null, items.map(function(i) { return i.count || 0; })));

        chartEl.classList.remove('dealer-chart-period-week', 'dealer-chart-period-month', 'dealer-chart-period-year');
        chartEl.classList.add('dealer-chart-period-' + period);

        barsEl.innerHTML = items.map(function(item) {
            var pct = ((item.count || 0) / maxCount) * 100;
            return '<div class="dealer-bar-chart-bar-wrap"><div class="dealer-bar-chart-bar" style="height:' + pct + '%"></div></div>';
        }).join('');

        xaxisEl.innerHTML = items.map(function(item) {
            return '<span>' + (item.label || '') + '</span>';
        }).join('');
    }

    periodBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var period = this.getAttribute('data-period');
            periodBtns.forEach(function(b) { b.classList.remove('dealer-chart-period-btn--active'); });
            this.classList.add('dealer-chart-period-btn--active');
            renderChart(period);
        });
    });
})();

(function() {
    var pagination = document.getElementById('inquiriesPagination');
    var rows = document.querySelectorAll('.dealer-inquiry-row');
    var countText = document.getElementById('inquiriesCountText');
    var prevBtn = document.getElementById('inquiriesPrevBtn');
    var nextBtn = document.getElementById('inquiriesNextBtn');
    var pageNumbersEl = document.getElementById('inquiriesPageNumbers');
    if (!pagination || !countText) return;

    var total = parseInt(pagination.getAttribute('data-total') || '0', 10);
    var perPage = parseInt(pagination.getAttribute('data-per-page') || '6', 10);
    var totalPages = parseInt(pagination.getAttribute('data-total-pages') || '1', 10);
    var currentPage = 1;

    function goToPage(page) {
        currentPage = Math.max(1, Math.min(page, totalPages));
        rows.forEach(function(row) {
            row.style.display = parseInt(row.getAttribute('data-page'), 10) === currentPage ? '' : 'none';
        });
        var from = total > 0 ? ((currentPage - 1) * perPage) + 1 : 0;
        var to = Math.min(currentPage * perPage, total);
        countText.textContent = 'Showing ' + (total > 0 ? from + '-' + to + ' of ' : '0 of ') + total + ' inquiries';
        prevBtn.disabled = currentPage <= 1;
        nextBtn.disabled = currentPage >= totalPages;
        var btns = pageNumbersEl.querySelectorAll('button');
        btns.forEach(function(b) {
            b.classList.toggle('dealer-pagination-btn--active', parseInt(b.getAttribute('data-page'), 10) === currentPage);
        });
    }

    function buildPageNumbers() {
        pageNumbersEl.innerHTML = '';
        for (var p = 1; p <= Math.min(totalPages, 5); p++) {
            var btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'dealer-pagination-btn' + (p === 1 ? ' dealer-pagination-btn--active' : '');
            btn.setAttribute('data-page', p);
            btn.textContent = p;
            btn.addEventListener('click', function() { goToPage(parseInt(this.getAttribute('data-page'), 10)); });
            pageNumbersEl.appendChild(btn);
        }
    }

    prevBtn.addEventListener('click', function() { if (!this.disabled) goToPage(currentPage - 1); });
    nextBtn.addEventListener('click', function() { if (!this.disabled) goToPage(currentPage + 1); });
    buildPageNumbers();
    goToPage(1);
})();
</script>
@endpush
@endsection
