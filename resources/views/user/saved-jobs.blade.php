@extends('layouts.user-panel')

@section('title', 'Saved Jobs')
@section('page-title', 'Saved Jobs')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">Saved Jobs ({{ count($jobs) }})</div>
        <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Browse More</a>
    </div>

    @forelse($jobs as $job)
    <div style="display:flex;align-items:center;gap:16px;padding:16px 0;border-bottom:1px solid rgba(99,102,241,0.07)">
        <div style="width:52px;height:52px;border-radius:12px;background:linear-gradient(135deg,#1e293b,#334155);border:1px solid rgba(99,102,241,0.2);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;overflow:hidden">
            @if($job->companyModel && $job->companyModel->logo)
                <img src="{{ asset('storage/'.$job->companyModel->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:12px" alt="">
            @else
                🏢
            @endif
        </div>
        <div style="flex:1;min-width:0">
            <div style="font-size:16px;font-weight:700;color:#000">{{ $job->title }}</div>
            <div style="font-size:13px;color:#64748b;margin-top:3px;display:flex;gap:14px;flex-wrap:wrap">
                <span><i class="fas fa-building" style="margin-right:4px;color:#818cf8"></i>{{ $job->company }}</span>
                <span><i class="fas fa-map-marker-alt" style="margin-right:4px;color:#818cf8"></i>{{ $job->location }}</span>
                <span><i class="fas fa-briefcase" style="margin-right:4px;color:#818cf8"></i>{{ $job->job_type }}</span>
            </div>
        </div>
        <div style="text-align:right;flex-shrink:0">
            <div style="font-size:14px;font-weight:700;color:#34d399;margin-bottom:8px">{{ $job->salary_range ?: 'Negotiable' }}</div>
            <a href="{{ route('jobs.show', $job->id) }}" class="btn btn-primary btn-sm">Apply Now</a>
        </div>
    </div>
    @empty
    <div style="text-align:center;padding:60px 20px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">🔖</div>
        <div style="font-size:18px;font-weight:600;color:#64748b;margin-bottom:8px">No saved jobs yet</div>
        <p style="font-size:14px;margin-bottom:24px">Save jobs you like to review them later</p>
        <a href="{{ route('jobs.index') }}" class="btn btn-primary"><i class="fas fa-search"></i> Browse Jobs</a>
    </div>
    @endforelse
</div>

@endsection
