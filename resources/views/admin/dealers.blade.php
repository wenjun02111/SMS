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
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Email</th>
                        <th>Postcode</th>
                        <th>City</th>
                        <th>Active</th>
                        <th>Company name</th>
                        <th>Alias</th>
                        <th>Total lead</th>
                        <th>Total closed</th>
                        <th>Conversion rate</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $r)
                        <tr>
                            <td>{{ $r->USERID }}</td>
                            <td>{{ $r->EMAIL }}</td>
                            <td>{{ $r->POSTCODE ?? '—' }}</td>
                            <td>{{ $r->CITY ?? '—' }}</td>
                            <td>{{ ($r->ISACTIVE ?? 0) ? 'Yes' : 'No' }}</td>
                            <td>{{ $r->COMPANY ?? '—' }}</td>
                            <td>{{ $r->ALIAS ?? '—' }}</td>
                            <td>{{ number_format((int)($r->TOTAL_LEAD ?? 0)) }}</td>
                            <td>{{ number_format((int)($r->TOTAL_CLOSED ?? 0)) }}</td>
                            <td>{{ number_format((float)($r->CONVERSION_RATE ?? 0), 1) }}%</td>
                        </tr>
                    @empty
                        <tr><td colspan="10">No dealers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
