@extends('layouts.app')
@section('title', 'Report - Dealer Revenue Production')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/report_dealer_revenue_production.css') }}">
@endpush
@section('content')
<div class="rrp-page">
    <div class="reports-tabs-row rrp-tabs-row">
        <nav class="reports-tabs-nav" aria-label="Report views">
            <a href="{{ route('admin.reports') }}"
               class="reports-tab-link {{ request()->routeIs('admin.reports') ? 'is-active' : '' }}">
                Monthly Performance
            </a>
            <a href="{{ route('admin.reports.v2') }}"
               class="reports-tab-link {{ request()->routeIs('admin.reports.v2') ? 'is-active' : '' }}">
                Dealer Sales Overtime
            </a>
            <a href="{{ route('admin.reports.revenue') }}"
               class="reports-tab-link {{ request()->routeIs('admin.reports.revenue') ? 'is-active' : '' }}">
                Dealer Revenue Production
            </a>
        </nav>
    </div>

    <section class="rrp-top-grid">
        <div class="rrp-metric-card">
            <div class="rrp-metric-label">Total Volume Accepted</div>
            <div class="rrp-metric-value">{{ number_format($totalVolume) }}</div>
            <div class="rrp-metric-sub">Total leads assigned to dealers in {{ $selectedQuarter ?? 'Q3' }}, {{ $selectedYear ?? now()->format('Y') }}</div>
        </div>
        <div class="rrp-metric-card">
            <div class="rrp-metric-label">Avg Rejection Rate</div>
            <div class="rrp-metric-value">{{ number_format($avgRejectionRate, 1) }}%</div>
            <div class="rrp-metric-sub">Across active dealers in {{ $selectedQuarter ?? 'Q3' }}, {{ $selectedYear ?? now()->format('Y') }}</div>
        </div>
        <div class="rrp-metric-card">
            <div class="rrp-metric-label">Top Performing Dealer</div>
            <div class="rrp-metric-value">{{ $topDealer['name'] ?? $topDealer['email'] ?? '—' }}</div>
            <div class="rrp-metric-sub">Highest revenue (closed volume)</div>
        </div>
    </section>

    <section class="rrp-panel">
        <div class="rrp-panel-header">
            <div>
                <div class="rrp-panel-title">Volume vs. Revenue Analysis</div>
                <div class="rrp-panel-subtitle">Performance by leading dealer branches</div>
            </div>
            <div class="rrp-legend">
                <span class="rrp-legend-item"><span class="rrp-dot rrp-dot-purple"></span> Total Volume</span>
                <span class="rrp-legend-item"><span class="rrp-dot rrp-dot-gold"></span> Closed Volume</span>
                <span class="rrp-legend-item"><span class="rrp-dot rrp-dot-green"></span> Rewarded Only</span>
            </div>
        </div>
        <div class="rrp-panel-body">
            <canvas id="rrpVolumeChart"></canvas>
        </div>
    </section>

    <section class="rrp-panel">
        <div class="rrp-panel-header">
            <div>
                <div class="rrp-panel-title">Dealer Rankings</div>
                <div class="rrp-panel-subtitle">Sorted by total revenue (closed volume × 1,000)</div>
            </div>
            <div class="rrp-pill rrp-pill-filter">
                All Territories
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true" xmlns="http://www.w3.org/2000/svg">
                    <path d="m19 9-7 7-7-7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="rrp-panel-body">
            <div class="table-responsive">
                <table class="dashboard-table rrp-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Total Leads</th>
                            <th>Agreements Closed</th>
                            <th>Rejection Rate</th>
                            <th>Total Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rankings as $row)
                            <tr>
                                <td>
                                    <div class="rrp-dealer-name">{{ $row['name'] ?? $row['email'] }}</div>
                                    <div class="rrp-dealer-id">ID: {{ $row['dealer_id'] }}</div>
                                </td>
                                <td>{{ number_format($row['total']) }}</td>
                                <td>{{ number_format($row['closed']) }}</td>
                                <td>{{ number_format($row['rejection_rate'], 1) }}%</td>
                                <td>${{ number_format($row['revenue']) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No dealer data for the selected period.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Title dropdown (shared across reports)
            const dropdownBtn = document.getElementById('dropdownHoverButton');
            const dropdown = document.getElementById('dropdownHover');
            const titleHover = document.getElementById('reportsTitleHover');
            if (dropdownBtn && dropdown) {
                const closeDropdown = () => {
                    dropdown.classList.remove('is-open');
                    dropdownBtn.classList.remove('is-open');
                    if (titleHover) titleHover.classList.remove('is-open');
                };
                const toggleDropdown = (e) => {
                    if (e) e.preventDefault();
                    const open = dropdown.classList.toggle('is-open');
                    dropdownBtn.classList.toggle('is-open', open);
                    if (titleHover) titleHover.classList.toggle('is-open', open);
                };
                dropdownBtn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    toggleDropdown(e);
                });
                if (titleHover) {
                    titleHover.addEventListener('click', function (e) {
                        if (dropdown.contains(e.target)) return;
                        if (dropdownBtn.contains(e.target)) return;
                        toggleDropdown(e);
                    });
                }
                document.addEventListener('click', function (e) {
                    if (!dropdown.contains(e.target) && !dropdownBtn.contains(e.target) && !(titleHover && titleHover.contains(e.target))) {
                        closeDropdown();
                    }
                });
                window.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeDropdown();
                });
            }
            const labels = @json($chartLabels);
            const volume = @json($chartVolume);
            const closed = @json($chartClosed);
            const rewarded = @json($chartRewarded);

            // Total bar first (main), then Closed and Rewarded; same categoryPercentage so each dealer's bars stick together
            const data = {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Volume',
                        data: volume,
                        backgroundColor: 'rgba(124, 58, 237, 0.9)',
                        barPercentage: 0.85,
                        categoryPercentage: 0.9,
                    },
                    {
                        label: 'Closed Volume',
                        data: closed,
                        backgroundColor: 'rgba(234, 179, 8, 0.9)',
                        barPercentage: 0.85,
                        categoryPercentage: 0.9,
                    },
                    {
                        label: 'Rewarded Only',
                        data: rewarded,
                        backgroundColor: 'rgba(34, 197, 94, 0.9)',
                        barPercentage: 0.85,
                        categoryPercentage: 0.9,
                    }
                ]
            };

            const config = {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                        },
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                        },
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e5e7eb' },
                        },
                    },
                },
            };

            const el = document.getElementById('rrpVolumeChart');
            if (el && window.Chart) {
                new Chart(el.getContext('2d'), config);
            }
        });
    </script>
@endpush
