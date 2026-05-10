@extends('admin.layout')

@section('title', 'Activity Logs')
@section('page-title', 'Activity Logs')

@section('content')

<!-- Filters -->
<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('admin.activity-logs') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:2;min-width:200px">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Name, action, description..." value="{{ request('search') }}">
        </div>
        <div style="flex:1;min-width:140px">
            <label class="form-label">Actor Type</label>
            <select name="actor_type" class="form-control">
                <option value="">All Types</option>
                <option value="user" {{ request('actor_type') === 'user' ? 'selected' : '' }}>Users</option>
                <option value="company" {{ request('actor_type') === 'company' ? 'selected' : '' }}>Companies</option>
                <option value="admin" {{ request('actor_type') === 'admin' ? 'selected' : '' }}>Admins</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:auto">Filter</button>
        <a href="{{ route('admin.activity-logs') }}" class="btn btn-outline" style="margin-top:auto">Reset</a>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">Activity Logs ({{ $logs->total() }})</div>
    </div>
    @if($logs->count() > 0)
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Actor</th>
                    <th>Type</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Time</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                @php
                    $typeColor=['user'=>'badge-blue','company'=>'badge-green','admin'=>'badge-orange'];
                    $typeIcon=['user'=>'fas fa-user','company'=>'fas fa-building','admin'=>'fas fa-shield-alt'];
                @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:8px">
                            <div style="width:32px;height:32px;border-radius:8px;background:rgba(245,158,11,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0">
                                <i class="{{ $typeIcon[$log->actor_type] ?? 'fas fa-user' }}" style="font-size:13px;color:#fbbf24"></i>
                            </div>
                            <div style="font-size:14px;font-weight:600;color:#f1f5f9">{{ $log->actor_name }}</div>
                        </div>
                    </td>
                    <td><span class="badge {{ $typeColor[$log->actor_type] ?? 'badge-gray' }}">{{ ucfirst($log->actor_type) }}</span></td>
                    <td style="font-weight:600;color:#94a3b8">{{ $log->action }}</td>
                    <td style="max-width:250px;font-size:13px">{{ Str::limit($log->description, 60) }}</td>
                    <td style="font-size:13px;color:#475569;font-family:monospace">{{ $log->ip_address ?: '—' }}</td>
                    <td style="font-size:13px;white-space:nowrap">
                        <div>{{ $log->created_at->format('M d, Y') }}</div>
                        <div style="color:#475569">{{ $log->created_at->format('h:i A') }}</div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px">{{ $logs->links() }}</div>
    @else
    <div style="text-align:center;padding:60px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">📋</div>
        <div style="font-size:18px;font-weight:600;color:#64748b">No activity logs found</div>
    </div>
    @endif
</div>

@endsection
