@extends('layouts.public')
@section('title', 'Create Account')

@push('styles')
<style>
.auth-wrap { min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 48px 24px; }
.auth-card { width: 100%; max-width: 460px; background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 36px; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
.auth-icon { width: 56px; height: 56px; background: #6366f1; border-radius: 14px; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 14px; }
.auth-title { text-align: center; margin-bottom: 24px; }
.auth-title h1 { font-size: 22px; font-weight: 800; color: #0f172a; }
.auth-title p { font-size: 14px; color: #64748b; margin-top: 4px; }
.form-group { margin-bottom: 16px; }
.form-group label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
.form-group input { width: 100%; background: #f8fafc; border: 1px solid #d1d5db; border-radius: 8px; padding: 11px 14px; color: #1e293b; font-size: 14px; font-family: 'Inter',sans-serif; outline: none; transition: border 0.15s; }
.form-group input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.form-group input::placeholder { color: #9ca3af; }
.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
.btn-submit { width: 100%; background: #6366f1; color: #fff; border: none; padding: 13px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: 'Inter',sans-serif; transition: background 0.15s; }
.btn-submit:hover { background: #4f46e5; }
.auth-link { text-align: center; margin-top: 14px; font-size: 14px; color: #64748b; }
.auth-link a { color: #6366f1; text-decoration: none; font-weight: 600; }
.alert-error { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; padding: 11px 14px; border-radius: 8px; font-size: 14px; margin-bottom: 16px; }
@media(max-width:480px){ .form-row { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-icon">🚀</div>
        <div class="auth-title">
            <h1>Create Free Account</h1>
            <p>Start your job search journey today</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin:0;padding-left:16px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.user') }}">
            @csrf
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" placeholder="John Doe" value="{{ old('name') }}" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="john@example.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Min 6 chars" required>
                </div>
                <div class="form-group">
                    <label>Confirm</label>
                    <input type="password" name="password_confirmation" placeholder="Repeat" required>
                </div>
            </div>
            <button type="submit" class="btn-submit">Create Account</button>
        </form>

        <div class="auth-link">Already have an account? <a href="{{ route('user.login') }}">Login</a></div>
        <div class="auth-link" style="margin-top:8px">Hiring? <a href="{{ route('company.register') }}">Register as Company</a></div>
    </div>
</div>
@endsection
