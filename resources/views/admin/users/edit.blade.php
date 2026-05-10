@extends('admin.layout')

@section('title', 'Edit User')
@section('page-title', 'Edit User')

@section('content')

<div style="max-width:600px">
    <div class="card">
        <div class="card-header">
            <div class="card-title"><i class="fas fa-user-edit" style="color:#f59e0b;margin-right:8px"></i>Edit User</div>
            <a href="{{ route('admin.users') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>

        <div style="display:flex;align-items:center;gap:16px;padding:16px 0;margin-bottom:20px;border-bottom:1px solid rgba(245,158,11,0.1)">
            <div style="width:56px;height:56px;border-radius:14px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:22px;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden">
                @if($user->profile_image)
                    <img src="{{ asset('storage/'.$user->profile_image) }}" style="width:100%;height:100%;object-fit:cover;border-radius:14px" alt="">
                @else
                    {{ strtoupper(substr($user->name,0,1)) }}
                @endif
            </div>
            <div>
                <div style="font-size:16px;font-weight:700;color:#f1f5f9">{{ $user->name }}</div>
                <div style="font-size:13px;color:#64748b">Joined {{ $user->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
            @csrf

            <div class="form-group">
                <label class="form-label">Full Name *</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Email Address *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Phone</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placeholder="Optional">
            </div>

            <div class="form-group">
                <label class="form-label">Role</label>
                <div style="display:flex;align-items:center;gap:14px;margin-top:4px">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="radio" name="role" value="user" {{ old('role', $user->role) === 'user' ? 'checked' : '' }}
                               style="accent-color:#f59e0b;width:16px;height:16px">
                        <span style="font-size:14px;color:#94a3b8">User</span>
                    </label>
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
                        <input type="radio" name="role" value="admin" {{ old('role', $user->role) === 'admin' ? 'checked' : '' }}
                               style="accent-color:#f59e0b;width:16px;height:16px">
                        <span style="font-size:14px;color:#94a3b8">Admin</span>
                    </label>
                </div>
            </div>

            <div style="background:rgba(245,158,11,0.05);border:1px solid rgba(245,158,11,0.1);border-radius:10px;padding:12px 14px;margin-bottom:20px;font-size:13px;color:#94a3b8">
                <i class="fas fa-lock" style="color:#f59e0b;margin-right:6px"></i>Password cannot be changed from here for security reasons.
            </div>

            <div style="display:flex;justify-content:flex-end;gap:12px">
                <a href="{{ route('admin.users') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update User</button>
            </div>
        </form>
    </div>
</div>

@endsection
