@extends('layouts.user-panel')

@section('title', 'Settings')
@section('page-title', 'Account Settings')

@section('content')
<div style="max-width:560px">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Change Password</div>
        </div>

        <div style="display:flex;align-items:center;gap:14px;margin-bottom:24px;padding:16px;background:rgba(99,102,241,0.05);border:1px solid rgba(99,102,241,0.1);border-radius:12px">
            <div style="width:52px;height:52px;border-radius:12px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden">
                @if(auth()->user()->profile_image)
                    <img src="{{ asset('storage/'.auth()->user()->profile_image) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                @else
                    {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                @endif
            </div>
            <div>
                <div style="font-size:16px;font-weight:700;color:#f1f5f9">{{ auth()->user()->name }}</div>
                <div style="font-size:13px;color:#64748b">{{ auth()->user()->email }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('user.settings.update') }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Current Password</label>
                <input type="password" name="current_password" class="form-control" placeholder="Enter your current password" required>
            </div>

            <div class="form-group">
                <label class="form-label">New Password</label>
                <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
            </div>

            <div class="form-group">
                <label class="form-label">Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password" required>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-key"></i> Change Password</button>
        </form>
    </div>

    <div class="card" style="margin-top:20px">
        <div class="card-title" style="margin-bottom:16px">Quick Links</div>
        <div style="display:flex;flex-direction:column;gap:10px">
            <a href="{{ route('profile') }}" class="btn btn-outline"><i class="fas fa-user"></i> Edit Profile & Resume</a>
            <a href="{{ route('my.jobs') }}" class="btn btn-outline"><i class="fas fa-file-alt"></i> My Applications</a>
            <a href="{{ route('saved.jobs') }}" class="btn btn-outline"><i class="fas fa-bookmark"></i> Saved Jobs</a>
        </div>
    </div>
</div>
@endsection
