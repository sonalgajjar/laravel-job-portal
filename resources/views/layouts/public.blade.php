<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'JobPortal Pro') — Find Your Dream Job</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Inter', sans-serif;
            background: #f8fafc;
            color: #1e293b;
            overflow-x: hidden;
        }

        /* ── HEADER ── */
        .site-header {
            background: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }

        .header-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 64px;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .logo-icon {
            width: 38px; height: 38px;
            background: #6366f1;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px;
        }

        .logo-text {
            font-size: 20px; font-weight: 800; color: #1e293b;
        }
        .logo-text span { color: #6366f1; }

        .nav-links { display: flex; align-items: center; gap: 2px; }

        .nav-link {
            color: #64748b;
            text-decoration: none;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.15s;
        }

        .nav-link:hover { color: #1e293b; background: #f1f5f9; }
        .nav-link.active { color: #6366f1; background: #eef2ff; font-weight: 600; }

        .nav-actions { display: flex; align-items: center; gap: 8px; }

        .btn-ghost {
            color: #64748b;
            text-decoration: none;
            padding: 7px 16px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid #e2e8f0;
            transition: all 0.15s;
            background: #fff;
        }

        .btn-ghost:hover { color: #1e293b; border-color: #cbd5e1; background: #f8fafc; }

        .btn-primary-nav {
            background: #6366f1;
            color: #fff;
            text-decoration: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.15s;
            border: none;
            cursor: pointer;
        }

        .btn-primary-nav:hover { background: #4f46e5; }

        /* Panel dropdowns */
        .panel-dropdown { position: relative; }

        .panel-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #64748b;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.15s;
            font-family: 'Inter', sans-serif;
        }

        .panel-btn:hover { background: #f8fafc; border-color: #cbd5e1; color: #1e293b; }

        .panel-menu {
            display: none;
            position: absolute;
            right: 0;
            top: calc(100% + 4px);
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 6px;
            min-width: 170px;
            box-shadow: 0 8px 24px rgba(0,0,0,0.1);
            z-index: 200;
        }

        .panel-menu.open { display: block; }

        .panel-menu a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            color: #475569;
            text-decoration: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.12s;
        }

        .panel-menu a i { color: #6366f1; width: 16px; text-align: center; }
        .panel-menu a:hover { background: #f1f5f9; color: #1e293b; }

        .btn-register {
            background: #6366f1;
            color: #fff;
            border-color: #6366f1;
        }
        .btn-register:hover { background: #4f46e5; border-color: #4f46e5; color: #fff; }

        /* ── MAIN ── */
        .site-main { min-height: calc(100vh - 64px - 280px); }

        /* ── FOOTER ── */
        .site-footer {
            background: #1e293b;
            color: #94a3b8;
            padding: 48px 24px 24px;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 32px;
        }

        .footer-brand-name {
            font-size: 18px; font-weight: 800; color: #fff; margin-bottom: 10px;
        }
        .footer-brand-name span { color: #818cf8; }

        .footer-tagline { font-size: 14px; color: #64748b; line-height: 1.7; margin-bottom: 18px; }

        .footer-social { display: flex; gap: 10px; }
        .social-btn {
            width: 34px; height: 34px;
            background: rgba(255,255,255,0.07);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #64748b; text-decoration: none; font-size: 14px;
            transition: all 0.15s;
        }
        .social-btn:hover { background: rgba(255,255,255,0.12); color: #fff; }

        .footer-col h4 { font-size: 13px; font-weight: 600; color: #e2e8f0; margin-bottom: 14px; }
        .footer-col ul { list-style: none; }
        .footer-col ul li { margin-bottom: 8px; }
        .footer-col ul li a { color: #64748b; text-decoration: none; font-size: 14px; transition: color 0.15s; }
        .footer-col ul li a:hover { color: #fff; }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.08);
            padding-top: 20px;
            font-size: 13px;
            color: #475569;
            text-align: center;
        }

        /* Alert */
        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 16px; font-size: 14px; display: flex; align-items: center; gap: 8px; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; }
        .alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

        /* Page wrapper */
        .page-wrapper { max-width: 1200px; margin: 0 auto; padding: 0 24px; }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 24px; }
            .footer-brand { grid-column: 1 / -1; }
        }

        @media (max-width: 480px) {
            .footer-grid { grid-template-columns: 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>

<header class="site-header">
    <div class="header-inner">

        <a href="{{ route('home') }}" class="logo">
            <div class="logo-icon">💼</div>
            <div class="logo-text">Job<span>Portal</span></div>
        </a>

        <nav class="nav-links">
            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('jobs.index') }}" class="nav-link {{ request()->routeIs('jobs.*') ? 'active' : '' }}">Browse Jobs</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
        </nav>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="btn-ghost">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline">
                    @csrf
                    <button type="submit" class="btn-ghost" style="cursor:pointer;font-family:inherit">Logout</button>
                </form>
            @else
                <div class="panel-dropdown">
                    <button type="button" class="panel-btn" onclick="toggleDropdown(this)">
                        <i class="fas fa-sign-in-alt"></i> Login <i class="fas fa-chevron-down" style="font-size:10px;margin-left:2px"></i>
                    </button>
                    <div class="panel-menu">
                        <a href="{{ route('user.login') }}"><i class="fas fa-user"></i> Job Seeker</a>
                        <a href="{{ route('company.login') }}"><i class="fas fa-building"></i> Company</a>
                        <a href="{{ route('admin.login') }}"><i class="fas fa-shield-alt"></i> Admin</a>
                    </div>
                </div>

                <div class="panel-dropdown">
                    <button type="button" class="panel-btn btn-register" onclick="toggleDropdown(this)">
                        <i class="fas fa-user-plus"></i> Register <i class="fas fa-chevron-down" style="font-size:10px;margin-left:2px"></i>
                    </button>
                    <div class="panel-menu">
                        <a href="{{ route('user.register') }}"><i class="fas fa-user-plus"></i> Job Seeker</a>
                        <a href="{{ route('company.register') }}"><i class="fas fa-building"></i> Company</a>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</header>

<main class="site-main">
    @if(session('success'))
        <div class="page-wrapper" style="padding-top:16px">
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        </div>
    @endif
    @if(session('error'))
        <div class="page-wrapper" style="padding-top:16px">
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        </div>
    @endif
    @yield('content')
</main>

<footer class="site-footer">
    <div class="footer-inner">
        <div class="footer-grid">
            <div class="footer-brand">
                <div class="footer-brand-name">Job<span>Portal</span> Pro</div>
                <p class="footer-tagline">Connecting talented professionals with top companies. Your career journey starts here.</p>
                <div class="footer-social">
                    <a href="#" class="social-btn"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-linkedin"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="social-btn"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Navigation</h4>
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li><a href="{{ route('jobs.index') }}">Browse Jobs</a></li>
                    <li><a href="{{ route('about') }}">About Us</a></li>
                    <li><a href="{{ route('contact') }}">Contact</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Job Seekers</h4>
                <ul>
                    <li><a href="{{ route('user.register') }}">Create Account</a></li>
                    <li><a href="{{ route('user.login') }}">Login</a></li>
                    <li><a href="{{ route('jobs.index') }}">Find Jobs</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Employers</h4>
                <ul>
                    <li><a href="{{ route('company.register') }}">Register Company</a></li>
                    <li><a href="{{ route('company.login') }}">Company Login</a></li>
                    <li><a href="{{ route('admin.login') }}">Admin Panel</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © {{ date('Y') }} JobPortal Pro. All rights reserved.
        </div>
    </div>
</footer>

<script>
function toggleDropdown(btn) {
    const menu = btn.nextElementSibling;
    const isOpen = menu.classList.contains('open');
    document.querySelectorAll('.panel-menu.open').forEach(m => m.classList.remove('open'));
    if (!isOpen) menu.classList.add('open');
}
document.addEventListener('click', function(e) {
    if (!e.target.closest('.panel-dropdown')) {
        document.querySelectorAll('.panel-menu.open').forEach(m => m.classList.remove('open'));
    }
});
</script>

@stack('scripts')
</body>
</html>
