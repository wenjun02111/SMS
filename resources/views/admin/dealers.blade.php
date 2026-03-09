@extends('layouts.app')
@section('title', 'Users – Admin')
@section('content')
<header class="dashboard-header">
    <div>
        <h1 class="dashboard-title">Users</h1>
        <p class="dashboard-subtitle">All users</p>
    </div>
</header>

<section class="dashboard-panel dashboard-table-panel">
    <div class="dashboard-panel-body">
        <div class="table-responsive">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Active</th>
                        <th>Last login</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $r)
                        <tr>
                            <td>{{ $r->USERID }}</td>
                            <td>{{ $r->EMAIL }}</td>
                            <td>{{ $r->SYSTEMROLE ?? '—' }}</td>
                            <td>{{ ($r->ISACTIVE ?? 0) ? 'Yes' : 'No' }}</td>
                            <td>{{ $r->LASTLOGIN ? date('Y-m-d H:i', strtotime($r->LASTLOGIN)) : '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No users yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
