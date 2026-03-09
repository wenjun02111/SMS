@extends('layouts.app')
@section('title', 'Dashboard – Dealer')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Dashboard</h1>
        <p class="dashboard-subtitle">Your assigned leads</p>
    </div>
</header>

<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-header">
        <div class="dashboard-panel-title">My Leads</div>
    </div>
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Lead ID</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>City</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $r)
                        <tr>
                            <td>{{ $r->LEADID }}</td>
                            <td>{{ $r->COMPANYNAME }}</td>
                            <td>{{ $r->CURRENTSTATUS ?? '—' }}</td>
                            <td>{{ $r->CITY ?? '—' }}</td>
                            <td>{{ $r->CREATEDAT ? date('Y-m-d', strtotime($r->CREATEDAT)) : '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No leads assigned yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
