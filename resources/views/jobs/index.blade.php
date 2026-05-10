@extends('layouts.public')
@section('title', 'Browse Jobs')

@push('styles')
<style>
.jobs-page { max-width: 1200px; margin: 0 auto; padding: 32px 24px; }
.page-head { margin-bottom: 24px; }
.page-head h1 { font-size: 26px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
.page-head p { font-size: 15px; color: #64748b; }

.filter-bar { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 20px; }
.filter-row { display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end; }
.filter-group { flex: 1; min-width: 150px; }
.filter-label { font-size: 12px; font-weight: 600; color: #64748b; margin-bottom: 5px; display: block; text-transform: uppercase; letter-spacing: 0.4px; }
.filter-input { width: 100%; background: #f8fafc; border: 1px solid #d1d5db; border-radius: 7px; padding: 9px 12px; color: #1e293b; font-size: 14px; font-family: 'Inter',sans-serif; outline: none; transition: border 0.15s; }
.filter-input:focus { border-color: #6366f1; background: #fff; }
.filter-input::placeholder { color: #9ca3af; }
.filter-input option { background: #fff; }
.btn-filter { background: #6366f1; color: #fff; border: none; padding: 9px 20px; border-radius: 7px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter',sans-serif; display: flex; align-items: center; gap: 6px; transition: background 0.15s; white-space: nowrap; }
.btn-filter:hover { background: #4f46e5; }
.btn-reset { background: #fff; border: 1px solid #e2e8f0; color: #64748b; padding: 9px 16px; border-radius: 7px; font-size: 14px; cursor: pointer; text-decoration: none; display: flex; align-items: center; gap: 5px; transition: all 0.15s; white-space: nowrap; }
.btn-reset:hover { border-color: #cbd5e1; color: #1e293b; }

.results-count { font-size: 14px; color: #64748b; margin-bottom: 16px; }
.results-count strong { color: #1e293b; }

.jobs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 14px; }
.job-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; transition: all 0.15s; }
.job-card:hover { border-color: #6366f1; box-shadow: 0 4px 14px rgba(99,102,241,0.1); }
.jc-logo { width: 46px; height: 46px; border-radius: 8px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; overflow: hidden; }
.jc-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
.jc-head { display: flex; gap: 12px; margin-bottom: 12px; align-items: flex-start; }
.jc-company { font-size: 12px; color: #64748b; margin-bottom: 2px; }
.jc-title { font-size: 15px; font-weight: 700; color: #0f172a; line-height: 1.3; }
.jc-meta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 12px; }
.jc-meta span { font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 4px; }
.jc-meta i { color: #6366f1; font-size: 11px; }
.jc-tags { display: flex; gap: 6px; flex-wrap: wrap; margin-bottom: 14px; }
.tag { display: inline-block; padding: 3px 9px; border-radius: 5px; font-size: 12px; font-weight: 500; }
.tag-blue { background: #eff6ff; color: #1d4ed8; }
.tag-green { background: #f0fdf4; color: #166534; }
.tag-purple { background: #faf5ff; color: #6b21a8; }
.tag-yellow { background: #fffbeb; color: #92400e; }
.jc-foot { display: flex; justify-content: space-between; align-items: center; }
.jc-salary { font-size: 14px; font-weight: 700; color: #059669; }
.btn-view { display: inline-flex; align-items: center; gap: 5px; background: #6366f1; color: #fff; padding: 7px 14px; border-radius: 7px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background 0.15s; }
.btn-view:hover { background: #4f46e5; }

.deadline-badge { font-size: 12px; color: #dc2626; display: flex; align-items: center; gap: 3px; margin-bottom: 10px; }

.empty-state { grid-column: 1/-1; text-align: center; padding: 60px 24px; background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; }
.empty-state .icon { font-size: 44px; margin-bottom: 12px; }
.empty-state h3 { font-size: 16px; font-weight: 700; color: #374151; margin-bottom: 6px; }
.empty-state p { font-size: 14px; color: #64748b; }

.pagination-wrap { margin-top: 24px; display: flex; justify-content: center; }

@media(max-width:640px){
    .filter-row { flex-direction: column; }
    .jobs-grid { grid-template-columns: 1fr; }
    .page-head h1 { font-size: 22px; }
}
</style>
@endpush

@section('content')
<div class="jobs-page">

    <div class="page-head">
        <h1>Browse Jobs</h1>
        <p>Find the perfect role from thousands of verified listings</p>
    </div>

    <div class="filter-bar">
        <form method="GET" action="{{ route('jobs.index') }}">
            <div class="filter-row">
                <div class="filter-group" style="flex:2">
                    <label class="filter-label">Search</label>
                    <input type="text" name="search" class="filter-input" placeholder="Title, skill, or company..." value="{{ request('search') }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Location</label>
                    <input type="text" name="location" class="filter-input" placeholder="City or Remote" value="{{ request('location') }}">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Type</label>
                    <select name="type" class="filter-input">
                        <option value="">All Types</option>
                        @foreach(['Full-Time','Part-Time','Contract','Internship','Remote','Hybrid'] as $t)
                            <option {{ request('type') === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn-filter"><i class="fas fa-search"></i> Search</button>
                <a href="{{ route('jobs.index') }}" class="btn-reset"><i class="fas fa-times"></i> Reset</a>
            </div>
        </form>
    </div>

    <div class="results-count">
        Showing <strong>{{ $jobs->total() ?? count($jobs) }}</strong> jobs
        @if(request('search')) for "<strong>{{ request('search') }}</strong>"@endif
    </div>

    <div class="jobs-grid">
        @forelse($jobs as $job)
        <div class="job-card">
            <div class="jc-head">
                <div class="jc-logo">
                    @if($job->companyModel && $job->companyModel->logo)
                        <img src="{{ asset('storage/'.$job->companyModel->logo) }}" alt="">
                    @else 🏢 @endif
                </div>
                <div style="flex:1;min-width:0">
                    <div class="jc-company">{{ $job->company }}</div>
                    <div class="jc-title">{{ $job->title }}</div>
                </div>
            </div>
            <div class="jc-meta">
                <span><i class="fas fa-map-marker-alt"></i>{{ $job->location }}</span>
                <span><i class="fas fa-briefcase"></i>{{ $job->job_type }}</span>
                @if($job->experience_required)<span><i class="fas fa-user-clock"></i>{{ $job->experience_required }}</span>@endif
            </div>
            <div class="jc-tags">
                <span class="tag tag-blue">{{ $job->job_type }}</span>
                @if($job->category)<span class="tag tag-purple">{{ $job->category->name }}</span>@endif
                @if($job->skills_required)
                    @foreach(array_slice(explode(',', $job->skills_required), 0, 2) as $sk)
                        <span class="tag tag-yellow">{{ trim($sk) }}</span>
                    @endforeach
                @endif
            </div>
            @if($job->deadline)
            <div class="deadline-badge"><i class="fas fa-clock"></i> Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</div>
            @endif
            <div class="jc-foot">
                <div class="jc-salary">{{ $job->salary_range ?: 'Negotiable' }}</div>
                <a href="{{ route('jobs.show', $job->id) }}" class="btn-view">View <i class="fas fa-arrow-right"></i></a>
            </div>
        </div>
        @empty
        <div class="empty-state">
            <div class="icon">🔍</div>
            <h3>No jobs found</h3>
            <p>Try different search terms or clear the filters</p>
        </div>
        @endforelse
    </div>

    @if(method_exists($jobs, 'links'))
    <div class="pagination-wrap">{{ $jobs->withQueryString()->links() }}</div>
    @endif

</div>
@endsection
