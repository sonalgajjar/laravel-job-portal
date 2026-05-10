@extends('layouts.public')
@section('title', 'Find Your Dream Job')

@push('styles')
<style>
/* Hero */
.hero { background: #fff; border-bottom: 1px solid #e2e8f0; padding: 72px 24px 60px; text-align: center; }
.hero-tag { display: inline-flex; align-items: center; gap: 6px; background: #eef2ff; color: #6366f1; border: 1px solid #c7d2fe; border-radius: 20px; padding: 5px 14px; font-size: 13px; font-weight: 600; margin-bottom: 20px; }
.hero h1 { font-size: 52px; font-weight: 800; color: #0f172a; line-height: 1.1; margin-bottom: 18px; }
.hero h1 span { color: #6366f1; }
.hero p { font-size: 18px; color: #64748b; max-width: 560px; margin: 0 auto 36px; line-height: 1.7; }

/* Search bar */
.search-bar { display: flex; gap: 8px; max-width: 700px; margin: 0 auto 28px; background: #fff; border: 1px solid #d1d5db; border-radius: 10px; padding: 6px 6px 6px 16px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); }
.search-bar input { flex: 1; border: none; outline: none; font-size: 15px; color: #1e293b; font-family: 'Inter',sans-serif; background: transparent; }
.search-bar input::placeholder { color: #9ca3af; }
.search-bar select { border: none; outline: none; background: #f8fafc; border-radius: 7px; padding: 8px 12px; font-size: 14px; color: #475569; font-family: 'Inter',sans-serif; cursor: pointer; border-left: 1px solid #e2e8f0; }
.search-bar button { background: #6366f1; color: #fff; border: none; border-radius: 8px; padding: 10px 22px; font-size: 14px; font-weight: 600; cursor: pointer; font-family: 'Inter',sans-serif; transition: background 0.15s; white-space: nowrap; }
.search-bar button:hover { background: #4f46e5; }

.hero-stats { display: flex; gap: 32px; justify-content: center; flex-wrap: wrap; }
.stat-item { text-align: center; }
.stat-num { font-size: 24px; font-weight: 800; color: #0f172a; }
.stat-lbl { font-size: 13px; color: #64748b; margin-top: 2px; }

/* Sections */
.section { padding: 56px 24px; }
.section-inner { max-width: 1200px; margin: 0 auto; }
.section-head { margin-bottom: 32px; }
.section-head h2 { font-size: 28px; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
.section-head p { font-size: 15px; color: #64748b; }

/* Job cards */
.jobs-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 16px; }
.job-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; transition: all 0.15s; text-decoration: none; display: block; color: inherit; }
.job-card:hover { border-color: #6366f1; box-shadow: 0 4px 16px rgba(99,102,241,0.12); }
.jc-head { display: flex; align-items: flex-start; gap: 12px; margin-bottom: 12px; }
.jc-logo { width: 46px; height: 46px; border-radius: 8px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 20px; flex-shrink: 0; overflow: hidden; }
.jc-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
.jc-company { font-size: 12px; color: #64748b; margin-bottom: 2px; }
.jc-title { font-size: 15px; font-weight: 700; color: #0f172a; line-height: 1.3; }
.jc-meta { display: flex; gap: 12px; flex-wrap: wrap; margin-bottom: 12px; }
.jc-meta span { font-size: 13px; color: #64748b; display: flex; align-items: center; gap: 4px; }
.jc-meta i { color: #6366f1; font-size: 11px; }
.jc-foot { display: flex; justify-content: space-between; align-items: center; }
.jc-salary { font-size: 14px; font-weight: 700; color: #059669; }
.tag { display: inline-block; padding: 3px 9px; border-radius: 5px; font-size: 12px; font-weight: 500; }
.tag-blue { background: #eff6ff; color: #1d4ed8; }
.tag-green { background: #f0fdf4; color: #166534; }
.tag-purple { background: #faf5ff; color: #6b21a8; }

/* CTA */
.cta-section { background: #0f172a; padding: 56px 24px; text-align: center; }
.cta-section h2 { font-size: 30px; font-weight: 800; color: #fff; margin-bottom: 12px; }
.cta-section p { font-size: 16px; color: #94a3b8; margin-bottom: 28px; }
.cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-cta-white { background: #fff; color: #1e293b; padding: 12px 28px; border-radius: 8px; font-size: 15px; font-weight: 700; text-decoration: none; transition: background 0.15s; }
.btn-cta-white:hover { background: #f1f5f9; }
.btn-cta-outline { background: transparent; color: #fff; border: 1px solid rgba(255,255,255,0.3); padding: 12px 28px; border-radius: 8px; font-size: 15px; font-weight: 600; text-decoration: none; transition: all 0.15s; }
.btn-cta-outline:hover { border-color: rgba(255,255,255,0.6); background: rgba(255,255,255,0.05); }
.btn-apply { display: inline-flex; align-items: center; gap: 5px; background: #6366f1; color: #fff; padding: 8px 16px; border-radius: 7px; font-size: 13px; font-weight: 600; text-decoration: none; transition: background 0.15s; }
.btn-apply:hover { background: #4f46e5; }

/* Alt section bg */
.section-alt { background: #f8fafc; border-top: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0; }

@media(max-width:768px){
    .hero h1 { font-size: 34px; }
    .search-bar { flex-direction: column; padding: 10px; }
    .search-bar select { border-left: none; border-top: 1px solid #e2e8f0; }
    .hero-stats { gap: 20px; }
    .jobs-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')

<!-- Hero -->
<section class="hero">
    <div class="hero-tag"><i class="fas fa-bolt"></i> 50,000+ Active Jobs</div>
    <h1>Find Your <span>Dream Job</span><br>Today</h1>
    <p>Connect with top companies, apply with one click, and track your applications — all in one place.</p>

    <form action="{{ route('jobs.index') }}" method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Job title, skill or company..." value="{{ request('search') }}">
        <select name="location">
            <option value="">All Locations</option>
            <option>Remote</option><option>Mumbai</option><option>Delhi</option>
            <option>Bangalore</option><option>Hyderabad</option><option>Pune</option>
        </select>
        <button type="submit"><i class="fas fa-search"></i> Search</button>
    </form>

    <div class="hero-stats">
        <div class="stat-item"><div class="stat-num">50K+</div><div class="stat-lbl">Active Jobs</div></div>
        <div class="stat-item"><div class="stat-num">12K+</div><div class="stat-lbl">Companies</div></div>
        <div class="stat-item"><div class="stat-num">200K+</div><div class="stat-lbl">Job Seekers</div></div>
        <div class="stat-item"><div class="stat-num">95%</div><div class="stat-lbl">Success Rate</div></div>
    </div>
</section>

<!-- Latest Jobs -->
<section class="section">
    <div class="section-inner">
        <div class="section-head">
            <h2>Latest Job Openings</h2>
            <p>Fresh opportunities posted by top companies</p>
        </div>
        <div class="jobs-grid">
            @forelse($jobs ?? [] as $job)
            <a href="{{ route('jobs.show', $job->id) }}" class="job-card">
                <div class="jc-head">
                    <div class="jc-logo">
                        @if($job->companyModel && $job->companyModel->logo)
                            <img src="{{ asset('storage/'.$job->companyModel->logo) }}" alt="">
                        @else 🏢 @endif
                    </div>
                    <div>
                        <div class="jc-company">{{ $job->company }}</div>
                        <div class="jc-title">{{ $job->title }}</div>
                    </div>
                </div>
                <div class="jc-meta">
                    <span><i class="fas fa-map-marker-alt"></i> {{ $job->location }}</span>
                    <span><i class="fas fa-briefcase"></i> {{ $job->job_type }}</span>
                    @if($job->experience_required)<span><i class="fas fa-user-clock"></i> {{ $job->experience_required }}</span>@endif
                </div>
                <div class="jc-foot">
                    <div>
                        <span class="tag tag-blue">{{ $job->job_type }}</span>
                        @if($job->category) <span class="tag tag-purple">{{ $job->category->name }}</span>@endif
                    </div>
                    <div class="jc-salary">{{ $job->salary_range ?: 'Negotiable' }}</div>
                </div>
            </a>
            @empty
            <div style="grid-column:1/-1;text-align:center;padding:48px;color:#94a3b8">
                <div style="font-size:40px;margin-bottom:12px">📭</div>
                <div style="font-size:16px;font-weight:600;color:#64748b">No jobs yet — check back soon</div>
            </div>
            @endforelse
        </div>
        @if(!empty($jobs) && count($jobs) > 0)
        <div style="text-align:center;margin-top:28px">
            <a href="{{ route('jobs.index') }}" class="btn-apply" style="display:inline-flex;font-size:14px;padding:10px 24px">View All Jobs <i class="fas fa-arrow-right"></i></a>
        </div>
        @endif
    </div>
</section>

<!-- How it works -->
<section class="section section-alt">
    <div class="section-inner">
        <div class="section-head" style="text-align:center">
            <h2>How It Works</h2>
            <p>Get hired in 3 simple steps</p>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:20px;text-align:center">
            @foreach([['👤','Create Profile','Sign up free and build your profile with resume and skills.'],['🔍','Find Jobs','Browse thousands of job listings filtered by your preferences.'],['🚀','Apply & Get Hired','Apply in one click and track your application status live.']] as $step)
            <div style="background:#fff;border:1px solid #e2e8f0;border-radius:10px;padding:28px 20px">
                <div style="font-size:32px;margin-bottom:12px">{{ $step[0] }}</div>
                <div style="font-size:15px;font-weight:700;color:#0f172a;margin-bottom:8px">{{ $step[1] }}</div>
                <div style="font-size:14px;color:#64748b;line-height:1.6">{{ $step[2] }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <h2>Ready to Start?</h2>
    <p>Join 200,000+ professionals who found their career through JobPortal Pro</p>
    <div class="cta-btns">
        <a href="{{ route('user.register') }}" class="btn-cta-white">Get Started Free</a>
        <a href="{{ route('company.register') }}" class="btn-cta-outline">Hire Talent</a>
    </div>
</section>

@endsection
