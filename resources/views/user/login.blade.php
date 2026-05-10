@extends('layouts.public')
@section('title', 'Job Seeker Login')

@push('styles')
<style>
.auth-wrap { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 48px 24px; }
.auth-card { width: 100%; max-width: 420px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 36px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
.auth-icon { width: 56px; height: 56px; background: #6366f1; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 14px; }
.auth-title { text-align: center; margin-bottom: 24px; }
.auth-title h1 { font-size: 22px; font-weight: 800; color: #0f172a; }
.auth-title p { font-size: 14px; color: #64748b; margin-top: 4px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
.form-group input { width: 100%; background: #f8fafc; border: 1px solid #d1d5db; border-radius: 8px; padding: 11px 14px; color: #1e293b; font-size: 14px; font-family: 'Inter',sans-serif; outline: none; transition: border 0.15s; }
.form-group input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.form-group input::placeholder { color: #9ca3af; }
.btn-submit { width: 100%; background: #6366f1; color: #fff; border: none; padding: 13px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: 'Inter',sans-serif; transition: background 0.15s; }
.btn-submit:hover { background: #4f46e5; }
.auth-link { text-align: center; margin-top: 16px; font-size: 14px; color: #64748b; }
.auth-link a { color: #6366f1; text-decoration: none; font-weight: 600; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 11px 14px; border-radius: 8px; font-size: 14px; margin-bottom: 16px; }
.divider { display: flex; align-items: center; gap: 10px; margin: 18px 0; color: #94a3b8; font-size: 13px; }
.divider::before, .divider::after { content: ''; flex: 1; height: 1px; background: #e2e8f0; }
.panel-links { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
.panel-link { display: flex; align-items: center; gap: 7px; padding: 9px 12px; border: 1px solid #e2e8f0; border-radius: 8px; color: #64748b; text-decoration: none; font-size: 13px; font-weight: 500; transition: all 0.15s; }
.panel-link:hover { border-color: #6366f1; color: #6366f1; background: #eef2ff; }
.panel-link i { color: #6366f1; }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-icon">👤</div>
        <div class="auth-title">
            <h1>Job Seeker Login</h1>
            <p>Access your dashboard and applications</p>
        </div>

        @if($errors->any())
            <div class="alert-error">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.user') }}">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="your@email.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn-submit">Login</button>
        </form>

        <div class="auth-link">Don't have an account? <a href="{{ route('user.register') }}">Register Free</a></div>

        <div class="divider">or login as</div>
        <div class="panel-links">
            <a href="{{ route('company.login') }}" class="panel-link"><i class="fas fa-building"></i> Company</a>
            <a href="{{ route('admin.login') }}" class="panel-link"><i class="fas fa-shield-alt"></i> Admin</a>
        </div>
    </div>
</div>
@endsection
