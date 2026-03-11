@extends('layouts.app')
@section('title', 'Reports – SQL LMS Dealer Console')
@section('content')
<div class="dashboard-content reports-page">
    <header class="reports-header">
        <div>
            <h1 class="dashboard-title">Performance Analytics</h1>
            <p class="dashboard-subtitle">Real-time stage metrics and conversion reports</p>
        </div>
        <div class="reports-header-actions">
            <div class="reports-period-dropdown">
                <button type="button" class="reports-period-btn" id="reportsPeriodBtn" aria-expanded="false" aria-haspopup="listbox">
                    <i class="bi bi-calendar3"></i>
                    <span class="reports-period-label">Current Month</span>
                    <i class="bi bi-chevron-down"></i>
                </button>
                <div class="reports-period-menu" id="reportsPeriodMenu" role="listbox" hidden>
                    <button type="button" class="reports-period-option" data-value="week">Current Week</button>
                    <button type="button" class="reports-period-option" data-value="month">Current Month</button>
                    <button type="button" class="reports-period-option" data-value="year">Current Year</button>
                    <button type="button" class="reports-period-option reports-period-option-range" data-value="range">Range</button>
                    <div class="reports-range-panel" id="reportsRangePanel" hidden>
                        <div class="reports-range-inputs">
                            <label>
                                <span>From</span>
                                <input type="date" id="reportsRangeFrom" class="reports-range-input">
                            </label>
                            <label>
                                <span>To</span>
                                <input type="date" id="reportsRangeTo" class="reports-range-input">
                            </label>
                        </div>
                        <div class="reports-range-actions">
                            <button type="button" class="reports-range-back" id="reportsRangeBack">Back</button>
                            <button type="button" class="reports-range-apply" id="reportsRangeApply">Apply</button>
                        </div>
                    </div>
                </div>
            </div>
            <button type="button" class="reports-download-btn">
                <i class="bi bi-download"></i>
                Download Report
            </button>
        </div>
    </header>

    {{-- Metric Cards --}}
    <section class="reports-metrics">
        <div class="reports-metric-card">
            <div class="reports-metric-icon reports-metric-icon-pending"><i class="bi bi-file-earmark"></i></div>
            <div class="reports-metric-value">—</div>
            <div class="reports-metric-label">PENDING</div>
        </div>
        <div class="reports-metric-card">
            <div class="reports-metric-icon reports-metric-icon-followup"><i class="bi bi-calendar-event"></i></div>
            <div class="reports-metric-value">—</div>
            <div class="reports-metric-label">FOLLOW UP</div>
        </div>
        <div class="reports-metric-card">
            <div class="reports-metric-icon reports-metric-icon-demo"><i class="bi bi-person-video2"></i></div>
            <div class="reports-metric-value">—</div>
            <div class="reports-metric-label">DEMO</div>
        </div>
        <div class="reports-metric-card">
            <div class="reports-metric-icon reports-metric-icon-confirmed"><i class="bi bi-check-circle"></i></div>
            <div class="reports-metric-value">—</div>
            <div class="reports-metric-label">CONFIRMED</div>
        </div>
        <div class="reports-metric-card">
            <div class="reports-metric-icon reports-metric-icon-completed"><i class="bi bi-box-seam"></i></div>
            <div class="reports-metric-value">—</div>
            <div class="reports-metric-label">COMPLETED</div>
        </div>
        <div class="reports-metric-card">
            <div class="reports-metric-icon reports-metric-icon-reward"><i class="bi bi-gift"></i></div>
            <div class="reports-metric-value">—</div>
            <div class="reports-metric-label">REWARD</div>
        </div>
    </section>

    {{-- Charts Row --}}
    <section class="reports-charts-row">
        <div class="reports-panel reports-chart-panel">
            <div class="reports-chart-header">
                <h2 class="reports-chart-title">Inquiry Trends</h2>
            </div>
            <div class="reports-line-chart-placeholder">
                <div class="reports-line-chart-main">
                    <div class="reports-line-chart-yaxis">
                        <span>160</span>
                        <span>120</span>
                        <span>80</span>
                        <span>40</span>
                        <span>0</span>
                    </div>
                    <div class="reports-line-chart-area">
                        <div class="reports-line-chart-line"></div>
                    </div>
                </div>
                <div class="reports-line-chart-xaxis">
                    <span>Week 1</span>
                    <span>Week 2</span>
                    <span>Week 3</span>
                    <span>Week 4</span>
                </div>
            </div>
        </div>
        <div class="reports-panel reports-chart-panel">
            <div class="reports-chart-header">
                <h2 class="reports-chart-title">Status Report</h2>
            </div>
            <div class="reports-donut-placeholder">
                <div class="reports-donut-ring"></div>
                <div class="reports-donut-legend">
                    <span class="reports-legend-item"><i class="bi bi-circle-fill" style="color:#b8b8d4"></i> Pending</span>
                    <span class="reports-legend-item"><i class="bi bi-circle-fill" style="color:#c8c0e0"></i> Follow Up</span>
                    <span class="reports-legend-item"><i class="bi bi-circle-fill" style="color:#93c5fd"></i> Demo</span>
                    <span class="reports-legend-item"><i class="bi bi-circle-fill" style="color:#7f5af0"></i> Confirmed</span>
                    <span class="reports-legend-item"><i class="bi bi-circle-fill" style="color:#86efac"></i> Completed</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Product Conversion Chart --}}
    <section class="reports-panel reports-product-panel">
        <h2 class="reports-chart-title">Product Conversion</h2>
        <div class="reports-bar-chart-placeholder">
            <div class="reports-bar-chart-content">
                <div class="reports-bar-chart-yaxis">
                    <span>SQL Account</span>
                    <span>SQL Payroll</span>
                    <span>SQL Production</span>
                    <span>Mobile Sales</span>
                    <span>SQL Ecommerce</span>
                    <span>SQL EBI Wellness POS</span>
                    <span>SQL X Suduai</span>
                    <span>SQL X-Store</span>
                    <span>SQL Vision</span>
                    <span>SQL HRMS</span>
                    <span>Others</span>
                </div>
                <div class="reports-bar-chart-bars">
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                    <div class="reports-bar-row"><div class="reports-bar-fill" style="width:0%"></div></div>
                </div>
            </div>
            <div class="reports-bar-chart-xaxis">
                <span>0</span>
                <span>10</span>
                <span>20</span>
                <span>30</span>
            </div>
        </div>
    </section>

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
    var btn = document.getElementById('reportsPeriodBtn');
    var menu = document.getElementById('reportsPeriodMenu');
    var label = document.querySelector('.reports-period-label');
    var options = document.querySelectorAll('.reports-period-option:not(.reports-period-option-range)');
    var rangeOption = document.querySelector('.reports-period-option-range');
    var rangePanel = document.getElementById('reportsRangePanel');
    var rangeFrom = document.getElementById('reportsRangeFrom');
    var rangeTo = document.getElementById('reportsRangeTo');
    var rangeApply = document.getElementById('reportsRangeApply');
    var rangeBack = document.getElementById('reportsRangeBack');

    var labels = { week: 'Current Week', month: 'Current Month', year: 'Current Year' };
    var currentValue = 'month';

    function closeMenu() {
        menu.hidden = true;
        btn.setAttribute('aria-expanded', 'false');
        rangePanel.hidden = true;
        options.forEach(function(o) { o.hidden = false; });
        if (rangeOption) rangeOption.hidden = false;
    }

    function showRangeOnly() {
        options.forEach(function(o) { o.hidden = true; });
        if (rangeOption) rangeOption.hidden = true;
        rangePanel.hidden = false;
    }

    function showOptionsOnly() {
        options.forEach(function(o) { o.hidden = false; });
        if (rangeOption) rangeOption.hidden = false;
        rangePanel.hidden = true;
    }

    btn.addEventListener('click', function() {
        var open = !menu.hidden;
        if (open) {
            closeMenu();
        } else {
            menu.hidden = false;
            btn.setAttribute('aria-expanded', 'true');
            showOptionsOnly();
        }
    });

    options.forEach(function(opt) {
        opt.addEventListener('click', function() {
            currentValue = opt.dataset.value;
            label.textContent = labels[currentValue];
            closeMenu();
        });
    });

    rangeOption.addEventListener('click', function(e) {
        e.stopPropagation();
        showRangeOnly();
    });

    rangeApply.addEventListener('click', function() {
        var from = rangeFrom.value;
        var to = rangeTo.value;
        if (from && to) {
            currentValue = 'range';
            label.textContent = from + ' to ' + to;
            closeMenu();
        }
    });

    rangeBack.addEventListener('click', function() {
        showOptionsOnly();
    });

    document.addEventListener('click', function(e) {
        if (!btn.contains(e.target) && !menu.contains(e.target)) closeMenu();
    });
})();
</script>
@endpush
@endsection
