@extends('layouts.app')
@section('title', 'Dashboard – Admin')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Overview of system metrics</p>
    </div>
</header>

<section class="dashboard-metrics">
    <div class="dashboard-metric-card">
        <div class="dashboard-metric-icon dashboard-metric-icon-leads"><i class="bi bi-graph-up-arrow"></i></div>
        <div class="dashboard-metric-label">Total Leads</div>
        <div class="dashboard-metric-value-row">
            <div class="dashboard-metric-value">{{ $totalLeads }}</div>
        </div>
    </div>
    <div class="dashboard-metric-card">
        <div class="dashboard-metric-icon dashboard-metric-icon-closed"><i class="bi bi-cash-stack"></i></div>
        <div class="dashboard-metric-label">Lead Activities</div>
        <div class="dashboard-metric-value-row">
            <div class="dashboard-metric-value">{{ $totalActivities }}</div>
        </div>
    </div>
    <div class="dashboard-metric-card">
        <div class="dashboard-metric-icon dashboard-metric-icon-inquiries"><i class="bi bi-people"></i></div>
        <div class="dashboard-metric-label">Users</div>
        <div class="dashboard-metric-value-row">
            <div class="dashboard-metric-value">{{ $totalUsers }}</div>
        </div>
    </div>
    <div class="dashboard-metric-card">
        <div class="dashboard-metric-icon dashboard-metric-icon-inquiries"><i class="bi bi-gift"></i></div>
        <div class="dashboard-metric-label">Referrer Payouts</div>
        <div class="dashboard-metric-value-row">
            <div class="dashboard-metric-value">{{ $totalPayouts }}</div>
        </div>
    </div>
</section>

<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-header">
        <div class="dashboard-panel-title">Quick links</div>
    </div>
    <div class="dashboard-panel-body">
        <p><a href="{{ route('admin.inquiries') }}">Leads</a> · <a href="{{ route('admin.dealers') }}">Users</a> · <a href="{{ route('admin.rewards') }}">Payouts</a> · <a href="{{ route('admin.history') }}">Lead Activities</a> · <a href="{{ route('admin.fulldatabase') }}">Full Database</a></p>
    </div>
</section>
@endsection
