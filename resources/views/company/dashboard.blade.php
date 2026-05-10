@extends('layouts.company-panel')

@section('title', 'Company Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- Stats Row -->
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-icon">📋</div>
        <div class="stat-val">{{ $totalJobs }}</div>
        <div class="stat-lbl">Total Jobs Posted</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">✅</div>
        <div class="stat-val">{{ $activeJobs }}</div>
        <div class="stat-lbl">Active Jobs</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-val">{{ $applications }}</div>
        <div class="stat-lbl">Total Applications</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🏢</div>
        <div class="stat-val" style="font-size:18px">{{ Str::limit($company->name, 15) }}</div>
        <div class="stat-lbl">{{ $company->industry ?: 'Your Company' }}</div>
    </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

    <!-- Recent Jobs -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Recent Jobs</div>
            <a href="{{ route('company.jobs.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Post Job</a>
        </div>
        @forelse($recentJobs as $job)
        <div style="display:flex;align-items:center;justify-content:space-between;padding:12px 0;border-bottom:1px solid rgba(16,185,129,0.07)">
            <div>
                <div style="font-size:14px;font-weight:600;color:#000">{{ $job->title }}</div>
                <div style="font-size:12px;color:#64748b;margin-top:2px">{{ $job->location }} · {{ $job->job_type }}</div>
            </div>
            <div>
                @if($job->status === 'active')
                    <span class="badge badge-green">Active</span>
                @elseif($job->status === 'inactive')
                    <span class="badge badge-yellow">Inactive</span>
                @else
                    <span class="badge badge-gray">{{ ucfirst($job->status) }}</span>
                @endif
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:30px;color:#475569">
            <div style="font-size:36px;margin-bottom:12px">📭</div>
            <div>No jobs posted yet</div>
            <a href="{{ route('company.jobs.create') }}" class="btn btn-primary btn-sm" style="margin-top:12px"><i class="fas fa-plus"></i> Post First Job</a>
        </div>
        @endforelse
        @if($recentJobs->count() > 0)
        <div style="margin-top:14px;text-align:center">
            <a href="{{ route('company.jobs') }}" class="btn btn-outline btn-sm">View All Jobs</a>
        </div>
        @endif
    </div>

    <!-- Recent Applications -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Recent Applications</div>
            <a href="{{ route('company.applications') }}" class="btn btn-outline btn-sm">View All</a>
        </div>
        @forelse($recentApplications as $app)
        <div style="display:flex;align-items:center;gap:12px;padding:12px 0;border-bottom:1px solid rgba(16,185,129,0.07)">
            <div style="width:38px;height:38px;border-radius:10px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:16px;font-weight:700;color:#fff;flex-shrink:0">
                {{ strtoupper(substr($app->user->name ?? '?', 0, 1)) }}
            </div>
            <div style="flex:1;min-width:0">
                <div style="font-size:14px;font-weight:600;color:#f1f5f9">{{ $app->user->name ?? 'N/A' }}</div>
                <div style="font-size:12px;color:#64748b">{{ $app->job->title ?? 'N/A' }}</div>
            </div>
            @php
                $statusMap=['pending'=>'badge-yellow','reviewing'=>'badge-blue','shortlisted'=>'badge-purple','rejected'=>'badge-red','hired'=>'badge-green'];
            @endphp
            <span class="badge {{ $statusMap[$app->status] ?? 'badge-gray' }}">{{ ucfirst($app->status) }}</span>
        </div>
        @empty
        <div style="text-align:center;padding:30px;color:#475569">
            <div style="font-size:36px;margin-bottom:12px">📨</div>
            <div>No applications yet</div>
        </div>
        @endforelse
    </div>

</div>

<!-- Company Profile Summary -->
<div class="card" style="margin-top:20px">
    <div class="card-header">
        <div class="card-title">Company Profile</div>
        <a href="{{ route('company.settings') }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i> Edit</a>
    </div>
    <div style="display:grid;grid-template-columns:auto 1fr;gap:24px;align-items:start">
        <div style="width:80px;height:80px;border-radius:16px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:36px;overflow:hidden;flex-shrink:0">
            @if($company->logo)
                <img src="{{ asset('storage/'.$company->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:16px" alt="">
            @else
                🏢
            @endif
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px">
            <div>
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Company Name</div>
                <div style="font-size:15px;font-weight:600;color:#94a3b8">{{ $company->name }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Industry</div>
                <div style="font-size:15px;font-weight:600;color:#94a3b8">{{ $company->industry ?: '—' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Location</div>
                <div style="font-size:15px;font-weight:600;color:#94a3b8">{{ $company->location ?: '—' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Company Size</div>
                <div style="font-size:15px;font-weight:600;color:#94a3b8">{{ $company->company_size ?: '—' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Website</div>
                <div style="font-size:15px;font-weight:600;color:#94a3b8">{{ $company->website ?: '—' }}</div>
            </div>
            <div>
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Status</div>
                <span class="badge badge-green">Approved</span>
            </div>
        </div>
    </div>
</div>

@endsection
