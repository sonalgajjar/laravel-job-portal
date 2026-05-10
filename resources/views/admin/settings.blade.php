@extends('admin.layout')

@section('title', 'Admin Settings')
@section('page-title', 'Settings')

@section('content')
<div style="max-width:600px">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Admin Profile & Password</div>
        </div>

        <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;padding:20px;background:rgba(245,158,11,0.05);border:1px solid rgba(245,158,11,0.1);border-radius:12px">
            <div style="width:64px;height:64px;border-radius:16px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:700;color:#fff;flex-shrink:0">
                {{ strtoupper(substr($admin->name, 0, 1)) }}
            </div>
            <div>
                <div style="font-size:18px;font-weight:700;color:#000">{{ $admin->name }}</div>
                <div style="font-size:14px;color:#64748b;margin-top:2px">{{ $admin->email }}</div>
                <span class="badge badge-orange" style="margin-top:6px">Super Administrator</span>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $admin->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $admin->email) }}" required>
            </div>

            <div style="border-top:1px solid rgba(245,158,11,0.1);padding-top:20px;margin:4px 0 20px">
                <div style="font-size:14px;font-weight:700;color:#94a3b8;margin-bottom:16px">
                    Change Password <span style="font-weight:400;font-size:13px">(leave blank to keep current)</span>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 6 characters">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
        </form>
    </div>
</div>
@endsection
