@extends('layouts.app')
@section('title', 'Leads – Admin')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Leads</h1>
        <p class="dashboard-subtitle">Recent leads (latest 100)</p>
    </div>
</header>

<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Company</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>City</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Created</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $r)
                        <tr>
                            <td>{{ $r->LEADID }}</td>
                            <td>{{ $r->COMPANYNAME }}</td>
                            <td>{{ $r->CONTACTNAME }}</td>
                            <td>{{ $r->EMAIL }}</td>
                            <td>{{ $r->CITY ?? '—' }}</td>
                            <td>{{ $r->CURRENTSTATUS ?? '—' }}</td>
                            <td>{{ $r->ASSIGNED_TO ?? '—' }}</td>
                            <td>{{ $r->CREATEDAT ? date('Y-m-d H:i', strtotime($r->CREATEDAT)) : '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="8">No leads yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
