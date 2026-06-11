<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name') . ' Dashboard')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>
<body>
    <nav class="dashboard-navbar">
        <div class="d-flex align-center gap-1">
            <button class="menu-toggle" aria-label="Toggle menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 12h18M3 6h18M3 18h18"/></svg>
            </button>
            <a href="{{ route('dashboard') }}" class="navbar-brand">{{ config('app.name') }}</a>
        </div>
        <div class="navbar-right">
            <div class="navbar-user">
                <div class="navbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <div class="navbar-user-info">
                    <div class="navbar-user-name">{{ auth()->user()->name }}</div>
                    <div class="navbar-user-role">{{ auth()->user()->role_name }}</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </nav>

    <aside class="sidebar">
        <div class="sidebar-section">
            <div class="sidebar-section-title">Main</div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg> Dashboard</a></li>
            </ul>
        </div>
        <div class="sidebar-section">
            <div class="sidebar-section-title">Modules</div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('profiles.index') }}" class="{{ request()->routeIs('profiles.*') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg> Profiling</a></li>
                <li><a href="#" class="opacity-50 pointer-events-none"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg> Module A <small class="text-muted" style="font-size:0.65rem;margin-left:auto;">Soon</small></a></li>
                <li><a href="#" class="opacity-50 pointer-events-none"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg> Module B <small class="text-muted" style="font-size:0.65rem;margin-left:auto;">Soon</small></a></li>
                <li><a href="#" class="opacity-50 pointer-events-none"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20V10"/><path d="M18 20V4"/><path d="M6 20v-4"/></svg> Module C <small class="text-muted" style="font-size:0.65rem;margin-left:auto;">Soon</small></a></li>
            </ul>
        </div>
        @if(auth()->user()->isAdmin())
        <div class="sidebar-section">
            <div class="sidebar-section-title">Administration</div>
            <ul class="sidebar-nav">
                <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.*') ? 'active' : '' }}"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4-4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg> User Management</a></li>
            </ul>
        </div>
        @endif
    </aside>

    <main class="dashboard-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @yield('content')
    </main>

    <footer class="dashboard-footer">
        &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
    </footer>

    @stack('scripts')
    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>