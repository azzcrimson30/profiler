@extends('layouts.dashboard')

@section('title', 'Dashboard - ' . config('app.name'))

@section('content')
<div class="page-header">
    <h1>Dashboard</h1>
    <p>Welcome back, {{ auth()->user()->name }}. Here's your overview.</p>
</div>

{{-- Stats Grid --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-info">
            <h3>Total Users</h3>
            <div class="stat-value">{{ $stats['total_users'] }}</div>
            <div class="stat-change up">↑ 12% from last month</div>
        </div>
        <div class="stat-icon blue">👥</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-info">
            <h3>Admin Users</h3>
            <div class="stat-value">{{ $stats['total_admins'] }}</div>
            <div class="stat-change up">↑ 2 new this week</div>
        </div>
        <div class="stat-icon purple">🛡️</div>
    </div>
    <div class="stat-card">
        <div class="stat-card-info">
            <h3>Regular Users</h3>
            <div class="stat-value">{{ $stats['total_regular_users'] }}</div>
            <div class="stat-change up">↑ 8% from last month</div>
        </div>
        <div class="stat-icon green">👤</div>
    </div>
    <a href="{{ route('profiles.index') }}" class="stat-card text-decoration-none" style="color:inherit;">
        <div class="stat-card-info">
            <h3>My Profiles</h3>
            <div class="stat-value">{{ $stats['my_profiles'] }}</div>
            <div class="stat-change text-primary">Click to manage →</div>
        </div>
        <div class="stat-icon green">📋</div>
    </a>
</div>

{{-- Quick Actions --}}
<div class="card">
    <div class="card-header">
        <h2>Quick Actions</h2>
    </div>
    <div class="quick-actions">
        @if(auth()->user()->isAdmin())
        <a href="{{ route('admin.users.create') }}" class="quick-action"><div class="quick-action-icon">➕</div><span>Add User</span></a>
        <a href="{{ route('admin.users.index') }}" class="quick-action"><div class="quick-action-icon">👥</div><span>Manage Users</span></a>
        @endif
        <a href="{{ route('profiles.index') }}" class="quick-action"><div class="quick-action-icon">📋</div><span>My Profiles</span></a>
        <a href="{{ route('profiles.create') }}" class="quick-action"><div class="quick-action-icon">➕</div><span>New Profile</span></a>
        <a href="#" class="quick-action opacity-50 pointer-events-none"><div class="quick-action-icon">📋</div><span>Module A</span></a>
        <a href="#" class="quick-action opacity-50 pointer-events-none"><div class="quick-action-icon">📄</div><span>Module B</span></a>
        <a href="#" class="quick-action opacity-50 pointer-events-none"><div class="quick-action-icon">📈</div><span>Module C</span></a>
    </div>
</div>

{{-- Recent Users + Activity --}}
<div class="card-grid">
    <div class="card">
        <div class="card-header">
            <h2>Recent Users</h2>
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">View All</a>
            @endif
        </div>
        <table class="table">
            <thead><tr><th>Name</th><th>Username</th><th>Role</th><th>Joined</th></tr></thead>
            <tbody>
                @forelse($stats['recent_users'] as $user)
                    <tr>
                        <td><strong>{{ $user->name }}</strong></td>
                        <td>{{ $user->username }}</td>
                        <td>
                            @if($user->role && $user->role->slug === 'administrator')
                                <span class="badge badge-admin">Administrator</span>
                            @else
                                <span class="badge badge-user">{{ $user->role_name }}</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center text-muted p-1.5">No users yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header"><h2>Recent Activity</h2></div>
        <div class="d-flex flex-column gap-1">
            <div class="d-flex align-start gap-0.75">
                <div class="activity-dot activity-dot-success mt-0.35"></div>
                <div><div class="text-sm font-semibold">System initialized</div><div class="text-xs text-muted">Just now</div></div>
            </div>
            <div class="d-flex align-start gap-0.75">
                <div class="activity-dot activity-dot-primary mt-0.35"></div>
                <div><div class="text-sm font-semibold">Database migrations completed</div><div class="text-xs text-muted">Just now</div></div>
            </div>
            <div class="d-flex align-start gap-0.75">
                <div class="activity-dot activity-dot-info mt-0.35"></div>
                <div><div class="text-sm font-semibold">Admin user created</div><div class="text-xs text-muted">Just now</div></div>
            </div>
            <div class="d-flex align-start gap-0.75">
                <div class="activity-dot activity-dot-warning mt-0.35"></div>
                <div><div class="text-sm font-semibold">Security headers configured</div><div class="text-xs text-muted">Just now</div></div>
            </div>
            <div class="d-flex align-start gap-0.75">
                <div class="activity-dot activity-dot-success mt-0.35"></div>
                <div><div class="text-sm font-semibold">Authentication module active</div><div class="text-xs text-muted">Just now</div></div>
            </div>
        </div>
    </div>
</div>

{{-- System Overview --}}
<div class="card">
    <div class="card-header"><h2>System Overview</h2><span class="badge badge-info">Live</span></div>
    <div class="d-grid" style="grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;">
        <div class="text-center p-1.5">
            <div class="text-2xl font-bold text-primary">99.9%</div>
            <div class="text-sm text-muted mt-0.25">Uptime</div>
            <div class="mt-0.75 rounded" style="height:4px;background:var(--border);overflow:hidden;"><div style="height:100%;width:99.9%;background:var(--primary);border-radius:2px;"></div></div>
        </div>
        <div class="text-center p-1.5">
            <div class="text-2xl font-bold text-success">45ms</div>
            <div class="text-sm text-muted mt-0.25">Avg Response Time</div>
            <div class="mt-0.75 rounded" style="height:4px;background:var(--border);overflow:hidden;"><div style="height:100%;width:15%;background:var(--success);border-radius:2px;"></div></div>
        </div>
        <div class="text-center p-1.5">
            <div class="text-2xl font-bold" style="color:var(--warning);">1.2GB</div>
            <div class="text-sm text-muted mt-0.25">Storage Used</div>
            <div class="mt-0.75 rounded" style="height:4px;background:var(--border);overflow:hidden;"><div style="height:100%;width:24%;background:var(--warning);border-radius:2px;"></div></div>
        </div>
        <div class="text-center p-1.5">
            <div class="text-2xl font-bold text-info">0</div>
            <div class="text-sm text-muted mt-0.25">Security Alerts</div>
            <div class="mt-0.75 rounded" style="height:4px;background:var(--border);overflow:hidden;"><div style="height:100%;width:0%;background:var(--info);border-radius:2px;"></div></div>
        </div>
    </div>
</div>
@endsection