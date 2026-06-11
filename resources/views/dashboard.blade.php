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
    <a href="{{ route('profiles.index') }}" class="stat-card" style="text-decoration:none;color:inherit;">
        <div class="stat-card-info">
            <h3>My Profiles</h3>
            <div class="stat-value">{{ $stats['my_profiles'] }}</div>
            <div class="stat-change" style="color:var(--primary);">Click to manage →</div>
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
        <a href="{{ route('admin.users.create') }}" class="quick-action">
            <div class="quick-action-icon">➕</div>
            <span>Add User</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="quick-action">
            <div class="quick-action-icon">👥</div>
            <span>Manage Users</span>
        </a>
        @endif
        <a href="{{ route('profiles.index') }}" class="quick-action">
            <div class="quick-action-icon">📋</div>
            <span>My Profiles</span>
        </a>
        <a href="{{ route('profiles.create') }}" class="quick-action">
            <div class="quick-action-icon">➕</div>
            <span>New Profile</span>
        </a>
        <a href="#" class="quick-action" style="opacity:0.5;pointer-events:none;">
            <div class="quick-action-icon">�</div>
            <span>Module A</span>
        </a>
        <a href="#" class="quick-action" style="opacity:0.5;pointer-events:none;">
            <div class="quick-action-icon">📄</div>
            <span>Module B</span>
        </a>
        <a href="#" class="quick-action" style="opacity:0.5;pointer-events:none;">
            <div class="quick-action-icon">�📈</div>
            <span>Module C</span>
        </a>
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
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>
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
                    <tr>
                        <td colspan="4" style="text-align:center;color:var(--text-muted);padding:1.5rem;">No users yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-header">
            <h2>Recent Activity</h2>
        </div>
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--success);margin-top:6px;flex-shrink:0;"></div>
                <div>
                    <div style="font-size:0.875rem;font-weight:500;">System initialized</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">Just now</div>
                </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--primary);margin-top:6px;flex-shrink:0;"></div>
                <div>
                    <div style="font-size:0.875rem;font-weight:500;">Database migrations completed</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">Just now</div>
                </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--info);margin-top:6px;flex-shrink:0;"></div>
                <div>
                    <div style="font-size:0.875rem;font-weight:500;">Admin user created</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">Just now</div>
                </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--warning);margin-top:6px;flex-shrink:0;"></div>
                <div>
                    <div style="font-size:0.875rem;font-weight:500;">Security headers configured</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">Just now</div>
                </div>
            </div>
            <div style="display:flex;align-items:flex-start;gap:0.75rem;">
                <div style="width:8px;height:8px;border-radius:50%;background:var(--success);margin-top:6px;flex-shrink:0;"></div>
                <div>
                    <div style="font-size:0.875rem;font-weight:500;">Authentication module active</div>
                    <div style="font-size:0.75rem;color:var(--text-muted);">Just now</div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Dummy Charts Section --}}
<div class="card">
    <div class="card-header">
        <h2>System Overview</h2>
        <span class="badge badge-info">Live</span>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.5rem;">
        <div style="text-align:center;padding:1.5rem;">
            <div style="font-size:2.5rem;font-weight:700;color:var(--primary);">99.9%</div>
            <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.25rem;">Uptime</div>
            <div style="height:4px;background:var(--border);border-radius:2px;margin-top:0.75rem;overflow:hidden;">
                <div style="height:100%;width:99.9%;background:var(--primary);border-radius:2px;"></div>
            </div>
        </div>
        <div style="text-align:center;padding:1.5rem;">
            <div style="font-size:2.5rem;font-weight:700;color:var(--success);">45ms</div>
            <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.25rem;">Avg Response Time</div>
            <div style="height:4px;background:var(--border);border-radius:2px;margin-top:0.75rem;overflow:hidden;">
                <div style="height:100%;width:15%;background:var(--success);border-radius:2px;"></div>
            </div>
        </div>
        <div style="text-align:center;padding:1.5rem;">
            <div style="font-size:2.5rem;font-weight:700;color:var(--warning);">1.2GB</div>
            <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.25rem;">Storage Used</div>
            <div style="height:4px;background:var(--border);border-radius:2px;margin-top:0.75rem;overflow:hidden;">
                <div style="height:100%;width:24%;background:var(--warning);border-radius:2px;"></div>
            </div>
        </div>
        <div style="text-align:center;padding:1.5rem;">
            <div style="font-size:2.5rem;font-weight:700;color:var(--info);">0</div>
            <div style="font-size:0.85rem;color:var(--text-muted);margin-top:0.25rem;">Security Alerts</div>
            <div style="height:4px;background:var(--border);border-radius:2px;margin-top:0.75rem;overflow:hidden;">
                <div style="height:100%;width:0%;background:var(--info);border-radius:2px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection