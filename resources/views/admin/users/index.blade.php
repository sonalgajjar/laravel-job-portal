@extends('admin.layout')

@section('title', 'Users')
@section('page-title', 'Users')

@section('content')

<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('admin.users') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:2;min-width:200px">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Name or email..." value="{{ request('search') }}">
        </div>
        <div style="flex:1;min-width:140px">
            <label class="form-label">Role</label>
            <select name="role" class="form-control">
                <option value="">All Roles</option>
                <option {{ request('role')==='user' ? 'selected' : '' }}>user</option>
                <option {{ request('role')==='admin' ? 'selected' : '' }}>admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:auto">Filter</button>
        <a href="{{ route('admin.users') }}" class="btn btn-outline" style="margin-top:auto">Reset</a>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">All Users ({{ $users->total() }})</div>
    </div>
    @if($users->count() > 0)
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Joined</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden">
                                @if($user->profile_image)
                                    <img src="{{ asset('storage/'.$user->profile_image) }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px" alt="">
                                @else
                                    {{ strtoupper(substr($user->name,0,1)) }}
                                @endif
                            </div>
                            <div>
                                <div style="font-size:14px;font-weight:600;color:#000">{{ $user->name }}</div>
                                <div style="font-size:12px;color:#64748b">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $user->phone ?: '—' }}</td>
                    <td>
                        @if($user->role === 'admin')
                            <span class="badge badge-orange">Admin</span>
                        @else
                            <span class="badge badge-blue">User</span>
                        @endif
                    </td>
                    <td>
                        @if($user->status === 'active')
                            <span class="badge badge-green">Active</span>
                        @else
                            <span class="badge badge-red">{{ ucfirst($user->status) }}</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                            <a href="{{ route('admin.users.toggleRole', $user->id) }}" class="btn btn-outline btn-sm" title="Toggle Role"><i class="fas fa-exchange-alt"></i></a>
                            <form method="POST" action="{{ route('admin.users.delete', $user->id) }}" onsubmit="return confirm('Delete {{ addslashes($user->name) }}?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px">{{ $users->links() }}</div>
    @else
    <div style="text-align:center;padding:60px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">👥</div>
        <div style="font-size:18px;font-weight:600;color:#64748b">No users found</div>
    </div>
    @endif
</div>

@endsection
