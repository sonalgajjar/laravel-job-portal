<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'JobPortal Pro')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #0f172a; color: #040f1e; min-height: 100vh; }

        .navbar {
            background: rgba(15,23,42,0.9);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(99,102,241,0.15);
            padding: 0 24px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .nav-brand { font-size: 20px; font-weight: 800; color: #fff; text-decoration: none; display: flex; align-items: center; gap: 8px; }
        .nav-brand span { color: #818cf8; }
        .nav-links { display: flex; align-items: center; gap: 4px; }
        .nav-links a {
            color: #94a3b8; text-decoration: none; padding: 7px 14px;
            border-radius: 8px; font-size: 14px; font-weight: 500; transition: all 0.2s;
        }
        .nav-links a:hover { color: #fff; background: rgba(99,102,241,0.12); }
        .nav-links a.active { color: #818cf8; background: rgba(99,102,241,0.12); }

        .page-body { max-width: 1200px; margin: 0 auto; padding: 32px 24px; }

        .site-footer {
            background: #020617;
            border-top: 1px solid rgba(99,102,241,0.1);
            text-align: center;
            padding: 20px;
            color: #475569;
            font-size: 13px;
            margin-top: 60px;
        }

        .card {
            background: rgba(30,41,59,0.6);
            border: 1px solid rgba(99,102,241,0.12);
            border-radius: 16px;
            padding: 24px;
            transition: all 0.2s;
        }
        .card:hover { border-color: rgba(99,102,241,0.25); box-shadow: 0 12px 30px rgba(0,0,0,0.3); }
    </style>
    @stack('styles')
</head>
<body>

<nav class="navbar">
    <a href="{{ route('home') }}" class="nav-brand">💼 Job<span>Portal</span></a>
    <div class="nav-links">
        <a href="{{ route('jobs.index') }}" class="{{ request()->routeIs('jobs.*') ? 'active' : '' }}">Jobs</a>
        <a href="{{ route('my.jobs') }}" class="{{ request()->routeIs('my.jobs') ? 'active' : '' }}">My Jobs</a>
        <a href="{{ route('profile') }}" class="{{ request()->routeIs('profile') ? 'active' : '' }}">Profile</a>
        @auth
        <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit" style="background:none;border:none;color:#94a3b8;font-size:14px;font-weight:500;cursor:pointer;padding:7px 14px;border-radius:8px;font-family:inherit;transition:all 0.2s" onmouseover="this.style.color='#fff';this.style.background='rgba(239,68,68,0.1)'" onmouseout="this.style.color='#94a3b8';this.style.background='none'">Logout</button>
        </form>
        @endauth
    </div>
</nav>

<div class="page-body">
    @yield('content')
</div>

<div class="site-footer">© {{ date('Y') }} JobPortal Pro</div>

@stack('scripts')
</body>
</html>
