@extends('layouts.public')
@section('title', $job->title)

@push('styles')
<style>
.job-detail { max-width: 1100px; margin: 0 auto; padding: 32px 24px; }
.back-link { display: inline-flex; align-items: center; gap: 7px; color: #64748b; text-decoration: none; font-size: 14px; margin-bottom: 20px; transition: color 0.15s; }
.back-link:hover { color: #6366f1; }

.detail-grid { display: grid; grid-template-columns: 1fr 300px; gap: 20px; }

/* Main card */
.job-main { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 28px; }
.job-head { display: flex; gap: 16px; margin-bottom: 20px; }
.job-logo { width: 64px; height: 64px; border-radius: 10px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 26px; flex-shrink: 0; overflow: hidden; }
.job-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 10px; }
.job-title { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 4px; line-height: 1.3; }
.job-company { font-size: 15px; color: #6366f1; font-weight: 600; margin-bottom: 8px; }
.job-tags { display: flex; gap: 6px; flex-wrap: wrap; }
.tag { display: inline-block; padding: 3px 10px; border-radius: 5px; font-size: 12px; font-weight: 600; }
.tag-blue { background: #eff6ff; color: #1d4ed8; }
.tag-green { background: #f0fdf4; color: #166534; }
.tag-purple { background: #faf5ff; color: #6b21a8; }

.meta-strip { display: flex; gap: 20px; flex-wrap: wrap; padding: 16px 0; border-top: 1px solid #f1f5f9; border-bottom: 1px solid #f1f5f9; margin: 16px 0; }
.meta-item { display: flex; align-items: center; gap: 7px; font-size: 14px; color: #475569; }
.meta-item i { color: #6366f1; width: 14px; text-align: center; }
.meta-item strong { color: #1e293b; }

.section-title { font-size: 15px; font-weight: 700; color: #0f172a; margin: 22px 0 10px; display: flex; align-items: center; gap: 7px; }
.section-title i { color: #6366f1; }
.section-body { font-size: 14px; color: #475569; line-height: 1.8; white-space: pre-line; }

.skills-list { display: flex; gap: 8px; flex-wrap: wrap; margin-top: 8px; }
.skill-chip { background: #f1f5f9; border: 1px solid #e2e8f0; color: #374151; padding: 5px 12px; border-radius: 20px; font-size: 13px; font-weight: 500; }

/* Sidebar */
.job-sidebar { display: flex; flex-direction: column; gap: 14px; }
.sidebar-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; }
.sidebar-card-title { font-size: 14px; font-weight: 700; color: #0f172a; margin-bottom: 14px; }

.btn-apply { display: block; width: 100%; text-align: center; background: #6366f1; color: #fff; padding: 13px; border-radius: 8px; font-size: 15px; font-weight: 700; text-decoration: none; transition: background 0.15s; margin-bottom: 8px; }
.btn-apply:hover { background: #4f46e5; }
.btn-apply.applied { background: #059669; cursor: default; }
.btn-save { display: block; width: 100%; text-align: center; background: #fff; border: 1px solid #e2e8f0; color: #64748b; padding: 10px; border-radius: 8px; font-size: 14px; font-weight: 600; cursor: pointer; transition: all 0.15s; font-family: 'Inter',sans-serif; }
.btn-save:hover { border-color: #6366f1; color: #6366f1; background: #eef2ff; }

.info-row { display: flex; justify-content: space-between; align-items: center; padding: 9px 0; border-bottom: 1px solid #f1f5f9; font-size: 13px; }
.info-row:last-child { border-bottom: none; }
.info-label { color: #64748b; }
.info-value { color: #1e293b; font-weight: 600; }

@media(max-width:900px){
    .detail-grid { grid-template-columns: 1fr; }
    .job-sidebar { order: -1; }
}
@media(max-width:500px){ .job-title { font-size: 18px; } }
</style>
@endpush

@section('content')
<div class="job-detail">
    <a href="{{ route('jobs.index') }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Jobs</a>

    <div class="detail-grid">
        <div class="job-main">
            <div class="job-head">
                <div class="job-logo">
                    @if($job->companyModel && $job->companyModel->logo)
                        <img src="{{ asset('storage/'.$job->companyModel->logo) }}" alt="">
                    @else 🏢 @endif
                </div>
                <div>
                    <div class="job-title">{{ $job->title }}</div>
                    <div class="job-company">{{ $job->company }}</div>
                    <div class="job-tags">
                        <span class="tag tag-blue">{{ $job->job_type }}</span>
                        @if($job->category)<span class="tag tag-purple">{{ $job->category->name }}</span>@endif
                        @if(in_array($job->status, ['active','Active','Approved']))<span class="tag tag-green">Actively Hiring</span>@endif
                    </div>
                </div>
            </div>

            <div class="meta-strip">
                <div class="meta-item"><i class="fas fa-map-marker-alt"></i><strong>{{ $job->location }}</strong></div>
                <div class="meta-item"><i class="fas fa-money-bill-wave"></i><strong>{{ $job->salary_range ?: 'Negotiable' }}</strong></div>
                @if($job->experience_required)<div class="meta-item"><i class="fas fa-user-clock"></i><strong>{{ $job->experience_required }}</strong></div>@endif
                @if($job->vacancies)<div class="meta-item"><i class="fas fa-users"></i><strong>{{ $job->vacancies }} Openings</strong></div>@endif
                @if($job->deadline)<div class="meta-item"><i class="fas fa-calendar"></i><strong>Deadline: {{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</strong></div>@endif
            </div>

            @if($job->description)
            <div class="section-title"><i class="fas fa-file-alt"></i> Job Description</div>
            <div class="section-body">{{ $job->description }}</div>
            @endif

            @if($job->requirements)
            <div class="section-title"><i class="fas fa-clipboard-list"></i> Requirements</div>
            <div class="section-body">{{ $job->requirements }}</div>
            @endif

            @if($job->skills_required)
            <div class="section-title"><i class="fas fa-code"></i> Required Skills</div>
            <div class="skills-list">
                @foreach(explode(',', $job->skills_required) as $sk)
                    <span class="skill-chip">{{ trim($sk) }}</span>
                @endforeach
            </div>
            @endif

            @if($job->benefits)
            <div class="section-title"><i class="fas fa-gift"></i> Benefits</div>
            <div class="section-body">{{ $job->benefits }}</div>
            @endif
        </div>

        <div class="job-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-card-title">Apply for this Job</div>
                @auth
                    @if($alreadyApplied)
                        <div class="btn-apply applied"><i class="fas fa-check-circle"></i> Already Applied</div>
                    @else
                        <a href="{{ route('applications.create', $job->id) }}" class="btn-apply">
                            <i class="fas fa-paper-plane"></i> Apply Now
                        </a>
                    @endif
                    <form method="POST" action="{{ route('jobs.save', $job->id) }}">
                        @csrf
                        <button type="submit" class="btn-save"><i class="fas fa-bookmark"></i> Save Job</button>
                    </form>
                @else
                    <a href="{{ route('user.login') }}" class="btn-apply"><i class="fas fa-sign-in-alt"></i> Login to Apply</a>
                    <div style="text-align:center;margin-top:10px;font-size:13px;color:#64748b">
                        New here? <a href="{{ route('user.register') }}" style="color:#6366f1;font-weight:600">Create free account</a>
                    </div>
                @endauth
            </div>

            <div class="sidebar-card">
                <div class="sidebar-card-title">Job Overview</div>
                <div class="info-row"><span class="info-label">Posted</span><span class="info-value">{{ $job->created_at->format('M d, Y') }}</span></div>
                <div class="info-row"><span class="info-label">Type</span><span class="info-value">{{ $job->job_type }}</span></div>
                <div class="info-row"><span class="info-label">Location</span><span class="info-value">{{ $job->location }}</span></div>
                @if($job->salary_range)<div class="info-row"><span class="info-label">Salary</span><span class="info-value" style="color:#059669">{{ $job->salary_range }}</span></div>@endif
                @if($job->experience_required)<div class="info-row"><span class="info-label">Experience</span><span class="info-value">{{ $job->experience_required }}</span></div>@endif
                @if($job->vacancies)<div class="info-row"><span class="info-label">Vacancies</span><span class="info-value">{{ $job->vacancies }}</span></div>@endif
                @if($job->deadline)<div class="info-row"><span class="info-label">Deadline</span><span class="info-value" style="color:#dc2626">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</span></div>@endif
            </div>

            @if($job->companyModel)
            <div class="sidebar-card">
                <div class="sidebar-card-title">About the Company</div>
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
                    <div style="width:44px;height:44px;border-radius:8px;background:#f1f5f9;border:1px solid #e2e8f0;display:flex;align-items:center;justify-content:center;font-size:20px;overflow:hidden;flex-shrink:0">
                        @if($job->companyModel->logo)<img src="{{ asset('storage/'.$job->companyModel->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:8px" alt="">@else 🏢 @endif
                    </div>
                    <div>
                        <div style="font-size:14px;font-weight:700;color:#0f172a">{{ $job->companyModel->name }}</div>
                        @if($job->companyModel->industry)<div style="font-size:12px;color:#64748b">{{ $job->companyModel->industry }}</div>@endif
                    </div>
                </div>
                @if($job->companyModel->description)<p style="font-size:13px;color:#64748b;line-height:1.6">{{ Str::limit($job->companyModel->description, 120) }}</p>@endif
                @if($job->companyModel->website)
                <a href="{{ $job->companyModel->website }}" target="_blank" style="display:inline-flex;align-items:center;gap:5px;color:#6366f1;font-size:13px;text-decoration:none;margin-top:10px;font-weight:600">
                    <i class="fas fa-globe"></i> Visit Website
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
