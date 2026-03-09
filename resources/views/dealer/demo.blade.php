@extends('layouts.app')
@section('title', 'Demo Schedule – Dealer')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Demo Schedule</h1>
        <p class="dashboard-subtitle">Leads with demo mode</p>
    </div>
</header>

<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Lead ID</th>
                        <th>Company</th>
                        <th>Status</th>
                        <th>Demo mode</th>
                        <th>Last modified</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($leads as $r)
                        <tr>
                            <td>{{ $r->LEADID }}</td>
                            <td>{{ $r->COMPANYNAME }}</td>
                            <td>{{ $r->CURRENTSTATUS ?? '—' }}</td>
                            <td>{{ $r->DEMOMODE ?? '—' }}</td>
                            <td>{{ $r->LASTMODIFIED ? date('Y-m-d', strtotime($r->LASTMODIFIED)) : '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No demo leads found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
