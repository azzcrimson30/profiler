<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="{{ config('app.name') }} - Built with Laravel for scalability and security.">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body>
    <nav class="navbar" role="navigation" aria-label="Main navigation">
        <a href="{{ url('/') }}" class="navbar-brand">{{ config('app.name') }}</a>
        <ul class="navbar-links">
            <li><a href="#features">Features</a></li>
            <li><a href="#tech-stack">Tech Stack</a></li>
            @auth
                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if(auth()->user()->isAdmin())
                    <li><a href="{{ route('admin.users.index') }}">Admin</a></li>
                @endif
                <li>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <a href="#" onclick="this.closest('form').submit(); return false;" class="link-muted">Logout</a>
                    </form>
                </li>
            @else
                <li><a href="{{ route('login') }}" class="btn btn-primary btn-compact">Sign In</a></li>
            @endauth
        </ul>
    </nav>

    <section class="hero">
        <div class="hero-content">
            <div class="hero-badge">System Online</div>
            <h1>Build Something<br><span>Extraordinary</span></h1>
            <p>A clean, scalable Laravel foundation engineered with industry-standard security practices and modern architecture. Ready for your next idea.</p>
            <div class="hero-actions">
                @auth
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">
                        Go to Dashboard
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Get Started
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M6 12L10 8L6 4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-secondary">Create Account</a>
                @endauth
            </div>
        </div>
    </section>

    <section id="features" class="features">
        <div class="features-header">
            <h2>Built for Production</h2>
            <p>Security, scalability, and maintainability baked in from the start.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card"><div class="feature-icon blue">🔒</div><h3>Security First</h3><p>CSRF protection, XSS prevention, security headers, encrypted sessions, and input validation applied across the application.</p></div>
            <div class="feature-card"><div class="feature-icon green">⚡</div><h3>Scalable Architecture</h3><p>Clean MVC structure with service-ready patterns, database caching, queue system, and optimized autoloading.</p></div>
            <div class="feature-card"><div class="feature-icon purple">🛠️</div><h3>Maintainable Code</h3><p>Strict typing, PSR-12 standards, comprehensive documentation, and modular design for long-term maintainability.</p></div>
            <div class="feature-card"><div class="feature-icon cyan">🗄️</div><h3>MySQL Database</h3><p>Persistent, production-ready MySQL database with migrations, UTF-8 support, and proper indexing.</p></div>
            <div class="feature-card"><div class="feature-icon blue">🚀</div><h3>Modern Stack</h3><p>Built on Laravel 13 with PHP 8.3, Vite asset bundling, and the latest Symfony components underneath.</p></div>
            <div class="feature-card"><div class="feature-icon green">🔒</div><h3>Session Security</h3><p>Encrypted database-backed sessions with CSRF token verification and secure cookie handling.</p></div>
        </div>
    </section>

    <section id="tech-stack" class="tech-stack">
        <div class="tech-stack-header">
            <h2>Tech Stack</h2>
            <p>Powered by battle-tested technologies.</p>
        </div>
        <div class="tech-grid">
            <div class="tech-item"><span class="tech-item-icon">🐘</span><div class="tech-item-info"><h4>PHP 8.3</h4><p>Latest stable PHP</p></div></div>
            <div class="tech-item"><span class="tech-item-icon">🔺</span><div class="tech-item-info"><h4>Laravel 13</h4><p>Latest framework</p></div></div>
            <div class="tech-item"><span class="tech-item-icon">🐬</span><div class="tech-item-info"><h4>MySQL</h4><p>Production database</p></div></div>
            <div class="tech-item"><span class="tech-item-icon">⚡</span><div class="tech-item-info"><h4>Vite</h4><p>Asset bundling</p></div></div>
        </div>
    </section>

    <footer class="footer">
        <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Built with Laravel {{ app()->version() }}.</p>
    </footer>

    <script src="{{ asset('js/script.js') }}"></script>
</body>
</html>