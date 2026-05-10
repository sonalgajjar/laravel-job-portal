<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Company Panel') — JobPortal Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{margin:0;padding:0;box-sizing:border-box}
        body{font-family:'Inter',sans-serif;background:#f1f5f9;color:#1e293b;display:flex;min-height:100vh}

        .sidebar{width:240px;background:#fff;border-right:1px solid #e2e8f0;display:flex;flex-direction:column;flex-shrink:0;position:fixed;height:100vh;left:0;top:0;z-index:100}
        .sidebar-logo{padding:20px 16px;border-bottom:1px solid #e2e8f0}
        .sidebar-logo a{display:flex;align-items:center;gap:9px;text-decoration:none;font-size:16px;font-weight:800;color:#1e293b}
        .logo-icon-sm{width:34px;height:34px;background:#059669;border-radius:9px;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}

        .sidebar-company{padding:14px 16px;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;gap:10px}
        .company-avatar{width:38px;height:38px;border-radius:9px;background:#059669;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;overflow:hidden}
        .company-avatar img{width:100%;height:100%;object-fit:cover;border-radius:9px}
        .company-name{font-size:13px;font-weight:600;color:#1e293b;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .company-role{font-size:11px;color:#64748b;margin-top:1px}

        .sidebar-nav{flex:1;padding:12px 10px;overflow-y:auto}
        .nav-section-label{font-size:10px;font-weight:700;color:#94a3b8;letter-spacing:0.8px;text-transform:uppercase;padding:10px 8px 4px;margin-top:4px}
        .nav-item{display:flex;align-items:center;gap:10px;padding:9px 12px;border-radius:8px;color:#64748b;text-decoration:none;font-size:14px;font-weight:500;transition:all 0.15s;margin-bottom:1px}
        .nav-item i{width:16px;text-align:center;font-size:14px;flex-shrink:0}
        .nav-item:hover{color:#1e293b;background:#f1f5f9}
        .nav-item.active{color:#059669;background:#f0fdf4;font-weight:600}
        .nav-item.active i{color:#059669}
        .sidebar-footer{padding:12px 10px;border-top:1px solid #e2e8f0}

        .main-content{flex:1;margin-left:240px;display:flex;flex-direction:column;min-height:100vh}
        .topbar{height:60px;background:#fff;border-bottom:1px solid #e2e8f0;display:flex;align-items:center;justify-content:space-between;padding:0 24px;position:sticky;top:0;z-index:50}
        .topbar-left{font-size:17px;font-weight:700;color:#1e293b}
        .topbar-right{display:flex;align-items:center;gap:10px}
        .topbar-btn{display:flex;align-items:center;gap:6px;color:#64748b;text-decoration:none;font-size:14px;padding:6px 12px;border-radius:8px;transition:all 0.15s}
        .topbar-btn:hover{color:#1e293b;background:#f1f5f9}

        .page-content{flex:1;padding:24px}

        .alert{padding:12px 16px;border-radius:8px;margin-bottom:16px;font-size:14px;display:flex;align-items:center;gap:8px}
        .alert-success{background:#f0fdf4;border:1px solid #bbf7d0;color:#166534}
        .alert-error{background:#fef2f2;border:1px solid #fecaca;color:#991b1b}

        .card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px}
        .card-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:16px}
        .card-title{font-size:16px;font-weight:700;color:#1e293b}

        .stats-row{display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:14px;margin-bottom:20px}
        .stat-card{background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:18px}
        .stat-icon{font-size:20px;margin-bottom:8px}
        .stat-val{font-size:26px;font-weight:800;color:#1e293b}
        .stat-lbl{font-size:12px;color:#64748b;margin-top:3px}

        .btn{display:inline-flex;align-items:center;gap:7px;padding:9px 18px;border-radius:8px;font-size:14px;font-weight:600;text-decoration:none;cursor:pointer;border:none;transition:all 0.15s;font-family:'Inter',sans-serif}
        .btn-primary{background:#059669;color:#fff}
        .btn-primary:hover{background:#047857}
        .btn-outline{background:#fff;color:#64748b;border:1px solid #e2e8f0}
        .btn-outline:hover{color:#1e293b;border-color:#cbd5e1;background:#f8fafc}
        .btn-danger{background:#fff;color:#ef4444;border:1px solid #fecaca}
        .btn-danger:hover{background:#fef2f2}
        .btn-sm{padding:6px 12px;font-size:13px}

        .table-wrap{overflow-x:auto}
        table{width:100%;border-collapse:collapse}
        th{padding:10px 14px;text-align:left;font-size:12px;font-weight:600;color:#64748b;text-transform:uppercase;letter-spacing:0.4px;border-bottom:1px solid #e2e8f0;background:#f8fafc}
        td{padding:12px 14px;border-bottom:1px solid #f1f5f9;font-size:14px;color:#475569}
        tr:last-child td{border-bottom:none}
        tr:hover td{background:#f8fafc}

        .badge{display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:12px;font-weight:600}
        .badge-green{background:#f0fdf4;color:#166534;border:1px solid #bbf7d0}
        .badge-yellow{background:#fffbeb;color:#92400e;border:1px solid #fde68a}
        .badge-red{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
        .badge-blue{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
        .badge-purple{background:#faf5ff;color:#6b21a8;border:1px solid #e9d5ff}
        .badge-gray{background:#f8fafc;color:#475569;border:1px solid #e2e8f0}

        .form-group{margin-bottom:18px}
        .form-label{display:block;font-size:13px;font-weight:600;color:#374151;margin-bottom:6px}
        .form-control{width:100%;background:#fff;border:1px solid #d1d5db;border-radius:8px;padding:10px 13px;color:#1e293b;font-size:14px;font-family:'Inter',sans-serif;transition:all 0.15s;outline:none}
        .form-control:focus{border-color:#059669;box-shadow:0 0 0 3px rgba(5,150,105,0.1)}
        .form-control::placeholder{color:#9ca3af}
        textarea.form-control{resize:vertical;min-height:100px}
        select.form-control{cursor:pointer;background:#fff}
        .form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}

        @media(max-width:768px){
            .sidebar{transform:translateX(-100%)}
            .main-content{margin-left:0}
            .form-row{grid-template-columns:1fr}
        }
    </style>
    @stack('styles')
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <a href="{{ route('company.dashboard') }}">
            <div class="logo-icon-sm">🏢</div>
            Company <span style="color:#64748b;font-size:11px;font-weight:600;margin-left:3px">Panel</span>
        </a>
    </div>

    @php $company = \App\Models\Company::find(session('company_id')); @endphp
    @if($company)
    <div class="sidebar-company">
        <div class="company-avatar">
            @if($company->logo)
                <img src="{{ asset('storage/'.$company->logo) }}" alt="">
            @else 🏢 @endif
        </div>
        <div style="min-width:0">
            <div class="company-name">{{ Str::limit($company->name,22) }}</div>
            <div class="company-role">{{ $company->industry ?: 'Company' }}</div>
        </div>
    </div>
    @endif

    <nav class="sidebar-nav">
        <div class="nav-section-label">Main</div>
        <a href="{{ route('company.dashboard') }}" class="nav-item {{ request()->routeIs('company.dashboard') ? 'active' : '' }}">
            <i class="fas fa-home"></i> Dashboard
        </a>
        <a href="{{ route('company.jobs') }}" class="nav-item {{ request()->routeIs('company.jobs*') ? 'active' : '' }}">
            <i class="fas fa-briefcase"></i> Job Listings
        </a>
        <a href="{{ route('company.jobs.create') }}" class="nav-item">
            <i class="fas fa-plus-circle"></i> Post a Job
        </a>
        <a href="{{ route('company.applications') }}" class="nav-item {{ request()->routeIs('company.applications*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Applications
        </a>

        <div class="nav-section-label">Account</div>
        <a href="{{ route('company.settings') }}" class="nav-item {{ request()->routeIs('company.settings') ? 'active' : '' }}">
            <i class="fas fa-cog"></i> Settings
        </a>
    </nav>

    <div class="sidebar-footer">
        <a href="{{ route('home') }}" class="nav-item"><i class="fas fa-globe"></i> Public Site</a>
        <form method="POST" action="{{ route('company.logout') }}">
            @csrf
            <button type="submit" class="nav-item" style="width:100%;background:none;cursor:pointer;border:none;text-align:left;color:#ef4444;font-family:'Inter',sans-serif">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
    </div>
</aside>

<div class="main-content">
    <header class="topbar">
        <div class="topbar-left">@yield('page-title', 'Dashboard')</div>
        <div class="topbar-right">
            <a href="{{ route('company.jobs.create') }}" class="topbar-btn"><i class="fas fa-plus"></i> Post Job</a>
            <a href="{{ route('company.settings') }}" class="topbar-btn"><i class="fas fa-cog"></i></a>
        </div>
    </header>

    <div class="page-content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                <ul style="margin:0;padding-left:16px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
            </div>
        @endif
        @yield('content')
    </div>
</div>

@stack('scripts')
</body>
</html>
