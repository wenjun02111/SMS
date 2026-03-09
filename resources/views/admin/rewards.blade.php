@extends('layouts.app')
@section('title', 'Rewards – Admin')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Referrer Payouts</h1>
        <p class="dashboard-subtitle">Recent payouts (latest 100)</p>
    </div>
</header>

<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Deal Submission</th>
                        <th>User</th>
                        <th>Referrer</th>
                        <th>Status</th>
                        <th>Generated</th>
                        <th>Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $r)
                        <tr>
                            <td>{{ $r->REFERRERPAYOUTID }}</td>
                            <td>{{ $r->DEALSUBMISSIONID ?? '—' }}</td>
                            <td>{{ $r->USERID ?? '—' }}</td>
                            <td>{{ $r->REFERRERID ?? '—' }}</td>
                            <td>{{ $r->STATUS ?? '—' }}</td>
                            <td>{{ $r->DATEGENERATED ? date('Y-m-d', strtotime($r->DATEGENERATED)) : '—' }}</td>
                            <td>{{ $r->DATEPAID ? date('Y-m-d', strtotime($r->DATEPAID)) : '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No payouts yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
