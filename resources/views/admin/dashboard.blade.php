@extends('admin.layout')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Stats -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-val">{{ $totalUsers }}</div>
        <div class="stat-lbl">Total Users</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🏢</div>
        <div class="stat-val">{{ $totalCompanies }}</div>
        <div class="stat-lbl">Companies</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">⏳</div>
        <div class="stat-val" style="color:#fbbf24">{{ $pendingCompanies }}</div>
        <div class="stat-lbl">Pending Approval</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💼</div>
        <div class="stat-val">{{ $totalJobs }}</div>
        <div class="stat-lbl">Total Jobs</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-val">{{ $activeJobs }}</div>
        <div class="stat-lbl">Active Jobs</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📨</div>
        <div class="stat-val">{{ $applications }}</div>
        <div class="stat-lbl">Applications</div>
    </div>
</div>

<!-- Pending Companies Alert -->
@if($pendingCompanies > 0)
<div style="background:rgba(245,158,11,0.08);border:1px solid rgba(245,158,11,0.25);border-radius:14px;padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between">
    <div style="display:flex;align-items:center;gap:12px">
        <i class="fas fa-clock" style="color:#fbbf24;font-size:20px"></i>
        <div>
            <div style="font-size:15px;font-weight:700;color:#fbbf24">{{ $pendingCompanies }} Company Registration{{ $pendingCompanies > 1 ? 's' : '' }} Pending Review</div>
            <div style="font-size:13px;color:#92400e">Review and approve companies so they can start hiring</div>
        </div>
    </div>
    <a href="{{ route('admin.companies', ['status'=>'pending']) }}" class="btn btn-primary btn-sm">Review Now</a>
</div>
@endif

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;margin-bottom:20px">

    <!-- Pending Companies -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Pending Companies</div>
            <a href="{{ route('admin.companies') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        @forelse($recentCompanies as $co)
        <div style="display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid rgba(245,158,11,0.06)">
            <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;overflow:hidden">
                @if($co->logo)
                    <img src="{{ asset('storage/'.$co->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px" alt="">
                @else
                    🏢
                @endif
            </div>
            <div style="flex:1;min-width:0">
                <div style="font-size:14px;font-weight:600;color:#f1f5f9">{{ $co->name }}</div>
                <div style="font-size:12px;color:#64748b">{{ $co->email }}</div>
            </div>
            <div style="display:flex;gap:6px">
                <form method="POST" action="{{ route('admin.companies.approve', $co->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>
                </form>
                <form method="POST" action="{{ route('admin.companies.reject', $co->id) }}">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-times"></i></button>
                </form>
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:30px;color:#475569">
            <div style="font-size:32px;margin-bottom:10px">✅</div>
            <div>All companies reviewed</div>
        </div>
        @endforelse
    </div>

    <!-- Recent Jobs -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Recent Jobs</div>
            <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        @forelse($recentJobs as $job)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(245,158,11,0.06)">
            <div>
                <div style="font-size:14px;font-weight:600;color:#000">{{ $job->title }}</div>
                <div style="font-size:12px;color:#64748b">{{ $job->company }} · {{ $job->location }}</div>
            </div>
            @if($job->status === 'active')
                <span class="badge badge-green">Active</span>
            @else
                <span class="badge badge-gray">{{ ucfirst($job->status) }}</span>
            @endif
        </div>
        @empty
        <div style="text-align:center;padding:30px;color:#475569">No jobs yet</div>
        @endforelse
    </div>

</div>

<!-- Recent Activity Logs -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Recent Activity</div>
        <a href="{{ route('admin.activity-logs') }}" class="btn btn-outline btn-sm">View All Logs</a>
    </div>
    @forelse($recentLogs as $log)
    @php
        $iconMap=['user'=>'fas fa-user','company'=>'fas fa-building','admin'=>'fas fa-shield-alt'];
        $colorMap=['user'=>'#818cf8','company'=>'#34d399','admin'=>'#fbbf24'];
    @endphp
    <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid rgba(245,158,11,0.06)">
        <div style="width:36px;height:36px;border-radius:10px;background:rgba(245,158,11,0.08);display:flex;align-items:center;justify-content:center;flex-shrink:0">
            <i class="{{ $iconMap[$log->actor_type] ?? 'fas fa-user' }}" style="color:{{ $colorMap[$log->actor_type] ?? '#64748b' }};font-size:14px"></i>
        </div>
        <div style="flex:1">
            <div style="font-size:14px;font-weight:600;color:#f1f5f9">
                <span style="color:{{ $colorMap[$log->actor_type] ?? '#64748b' }}">{{ $log->actor_name }}</span>
                · {{ $log->action }}
            </div>
            @if($log->description)
            <div style="font-size:13px;color:#64748b;margin-top:2px">{{ $log->description }}</div>
            @endif
        </div>
        <div style="font-size:12px;color:#475569;white-space:nowrap">{{ $log->created_at->diffForHumans() }}</div>
    </div>
    @empty
    <div style="text-align:center;padding:30px;color:#475569">No activity logs yet</div>
    @endforelse
</div>

@endsection
