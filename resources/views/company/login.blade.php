@extends('layouts.public')

@section('title', 'Company Login')

@push('styles')
<style>
.auth-page{min-height:100vh;display:flex;align-items:center;justify-content:center;padding:40px 20px}
.auth-card{width:100%;max-width:460px;background:rgba(30,41,59,0.7);border:1px solid rgba(16,185,129,0.15);border-radius:20px;padding:40px;backdrop-filter:blur(20px);box-shadow:0 30px 60px rgba(0,0,0,0.4)}
.auth-logo{text-align:center;margin-bottom:28px}
.auth-logo-icon{width:64px;height:64px;background:linear-gradient(135deg,#10b981,#059669);border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 14px;box-shadow:0 8px 25px rgba(16,185,129,0.35)}
.auth-logo h1{font-size:24px;font-weight:800;color:#f1f5f9}
.auth-logo p{font-size:14px;color:#64748b;margin-top:4px}
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:13px;font-weight:600;color:#94a3b8;margin-bottom:8px}
.form-control{width:100%;background:rgba(15,23,42,0.8);border:1px solid rgba(16,185,129,0.12);border-radius:10px;padding:12px 16px;color:#f1f5f9;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:all 0.2s}
.form-control:focus{border-color:rgba(16,185,129,0.4);box-shadow:0 0 0 3px rgba(16,185,129,0.08)}
.form-control::placeholder{color:#475569}
.btn-submit{width:100%;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;padding:14px;border-radius:12px;font-size:16px;font-weight:700;cursor:pointer;transition:all 0.2s;box-shadow:0 6px 20px rgba(16,185,129,0.3)}
.btn-submit:hover{transform:translateY(-1px);box-shadow:0 10px 28px rgba(16,185,129,0.45)}
.auth-links{text-align:center;margin-top:20px;font-size:14px;color:#64748b}
.auth-links a{color:#34d399;text-decoration:none;font-weight:600}
.auth-links a:hover{text-decoration:underline}
.alert{padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:14px;display:flex;align-items:center;gap:8px}
.alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171}
.alert-success{background:rgba(16,185,129,0.1);border:1px solid rgba(16,185,129,0.2);color:#34d399}
.divider{display:flex;align-items:center;gap:12px;margin:20px 0;color:#475569;font-size:13px}
.divider::before,.divider::after{content:'';flex:1;height:1px;background:rgba(99,102,241,0.1)}
.panel-links{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:8px}
.panel-link{display:flex;align-items:center;gap:8px;padding:10px 12px;border:1px solid rgba(99,102,241,0.15);border-radius:10px;color:#64748b;text-decoration:none;font-size:13px;font-weight:500;transition:all 0.2s}
.panel-link:hover{border-color:rgba(99,102,241,0.35);color:#e2e8f0;background:rgba(99,102,241,0.06)}
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon">🏢</div>
            <h1>Company Login</h1>
            <p>Access your hiring dashboard</p>
        </div>

        @if(session('error'))
            <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('company.login.post') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Company Email</label>
                <input type="email" name="email" class="form-control" placeholder="company@example.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn-submit"><i class="fas fa-sign-in-alt"></i> Login to Dashboard</button>
        </form>

        <div class="auth-links" style="margin-top:16px">
            Don't have a company account? <a href="{{ route('company.register') }}">Register here</a>
        </div>

        <div class="divider">or login as</div>
        <div class="panel-links">
            <a href="{{ route('user.login') }}" class="panel-link"><i class="fas fa-user"></i> Job Seeker</a>
            <a href="{{ route('admin.login') }}" class="panel-link"><i class="fas fa-shield-alt"></i> Admin</a>
        </div>
    </div>
</div>
@endsection
