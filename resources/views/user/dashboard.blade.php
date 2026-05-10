@extends('layouts.user-panel')

@section('title', 'Dashboard')
@section('page-title', 'My Dashboard')

@section('content')

<!-- Welcome -->
<div style="background:linear-gradient(135deg,rgba(99,102,241,0.1),rgba(139,92,246,0.1));border:1px solid rgba(99,102,241,0.2);border-radius:16px;padding:24px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px">
    <div>
        <div style="font-size:22px;font-weight:800;color:#f1f5f9;margin-bottom:4px">Welcome back, {{ auth()->user()->name }}! 👋</div>
        <div style="font-size:14px;color:#64748b">Find your next opportunity and take your career to the next level.</div>
    </div>
    <a href="{{ route('jobs.index') }}" class="btn btn-primary"><i class="fas fa-search"></i> Browse Jobs</a>
</div>

<!-- Stats -->
<div class="stats-row" style="grid-template-columns:repeat(3,1fr)">
    <div class="stat-card blue">
        <div class="stat-icon">📨</div>
        <div class="stat-val">{{ $appliedCount }}</div>
        <div class="stat-lbl">Jobs Applied</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon">🔖</div>
        <div class="stat-val">{{ $savedCount }}</div>
        <div class="stat-lbl">Saved Jobs</div>
    </div>
    <div class="stat-card yellow">
        <div class="stat-icon">✅</div>
        <div class="stat-val">
            @php
                $profile = auth()->user();
                $filled = collect([$profile->phone,$profile->bio,$profile->skills,$profile->resume,$profile->experience_info,$profile->education_info])->filter()->count();
                echo round($filled / 6 * 100);
            @endphp%
        </div>
        <div class="stat-lbl">Profile Complete</div>
    </div>
</div>

<!-- Profile Completion Tip -->
@php
$user = auth()->user();
$missing = [];
if(!$user->phone) $missing[] = 'Phone number';
if(!$user->bio) $missing[] = 'Bio';
if(!$user->skills) $missing[] = 'Skills';
if(!$user->resume && !$user->resume_text) $missing[] = 'Resume';
@endphp
@if(count($missing) > 0)
<div style="background:rgba(245,158,11,0.06);border:1px solid rgba(245,158,11,0.2);border-radius:14px;padding:16px 20px;margin-bottom:24px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px">
    <div>
        <div style="font-size:14px;font-weight:600;color:#fbbf24;margin-bottom:4px">Complete your profile to get noticed by employers</div>
        <div style="font-size:13px;color:#64748b">Missing: {{ implode(', ', $missing) }}</div>
    </div>
    <a href="{{ route('profile') }}" class="btn btn-outline btn-sm" style="color:#fbbf24;border-color:rgba(245,158,11,0.3)"><i class="fas fa-user-edit"></i> Update Profile</a>
</div>
@endif

<!-- Latest Jobs -->
<div class="card">
    <div class="card-header">
        <div class="card-title">Latest Job Openings</div>
        <a href="{{ route('jobs.index') }}" class="btn btn-outline btn-sm">View All Jobs</a>
    </div>

    @forelse($jobs as $job)
    <div style="display:flex;align-items:center;gap:14px;padding:14px 0;border-bottom:1px solid rgba(99,102,241,0.07)">
        <div style="width:46px;height:46px;border-radius:12px;background:linear-gradient(135deg,#1e293b,#334155);border:1px solid rgba(99,102,241,0.2);display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0;overflow:hidden">
            @if($job->companyModel && $job->companyModel->logo)
                <img src="{{ asset('storage/'.$job->companyModel->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:12px" alt="">
            @else
                🏢
            @endif
        </div>
        <div style="flex:1;min-width:0">
            <div style="font-size:15px;font-weight:700;color:#000">{{ $job->title }}</div>
            <div style="font-size:13px;color:#64748b;margin-top:2px">
                {{ $job->company }} · {{ $job->location }} · {{ $job->job_type }}
            </div>
        </div>
        <div style="text-align:right;flex-shrink:0">
            <div style="font-size:14px;font-weight:700;color:#34d399;margin-bottom:6px">{{ $job->salary_range ?: 'Negotiable' }}</div>
            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">Apply</a>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:40px;color:#475569">
        <div style="font-size:40px;margin-bottom:12px">📭</div>
        <div>No jobs available right now</div>
    </div>
    @endforelse
</div>

@endsection
