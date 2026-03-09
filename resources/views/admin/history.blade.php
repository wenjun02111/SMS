@extends('layouts.app')
@section('title', 'Lead Activities – Admin')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Lead Activities</h1>
        <p class="dashboard-subtitle">Recent activities (latest 100)</p>
    </div>
</header>

<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Lead</th>
                        <th>User</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $r)
                        <tr>
                            <td>{{ $r->LEAD_ACTID }}</td>
                            <td>{{ $r->LEADID }}</td>
                            <td>{{ $r->USERID }}</td>
                            <td>{{ $r->SUBJECT ?? '—' }}</td>
                            <td>{{ $r->STATUS ?? '—' }}</td>
                            <td>{{ $r->CREATIONDATE ? date('Y-m-d H:i', strtotime($r->CREATIONDATE)) : '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="6">No activities yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
