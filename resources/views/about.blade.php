@extends('layouts.public')
@section('title', 'About Us')

@push('styles')
<style>
.about-page { max-width: 1100px; margin: 0 auto; padding: 48px 24px; }

.about-hero { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 48px 40px; text-align: center; margin-bottom: 40px; }
.about-hero h1 { font-size: 38px; font-weight: 800; color: #0f172a; margin-bottom: 14px; }
.about-hero h1 span { color: #6366f1; }
.about-hero p { font-size: 17px; color: #64748b; max-width: 560px; margin: 0 auto 28px; line-height: 1.7; }
.stats-row { display: flex; justify-content: center; gap: 40px; flex-wrap: wrap; }
.stat-item { text-align: center; }
.stat-num { font-size: 30px; font-weight: 800; color: #6366f1; }
.stat-lbl { font-size: 13px; color: #64748b; margin-top: 3px; }

.section-title { font-size: 22px; font-weight: 800; color: #0f172a; margin-bottom: 6px; }
.section-sub { font-size: 14px; color: #64748b; margin-bottom: 28px; }

.cards-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 16px; margin-bottom: 40px; }
.feature-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 24px; transition: all 0.15s; }
.feature-card:hover { border-color: #6366f1; box-shadow: 0 4px 14px rgba(99,102,241,0.1); }
.feature-icon { font-size: 28px; margin-bottom: 12px; }
.feature-card h3 { font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 6px; }
.feature-card p { font-size: 14px; color: #64748b; line-height: 1.6; }

.mv-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 40px; }
.mv-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 28px 24px; }
.mv-card h3 { font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 10px; }
.mv-card p { font-size: 14px; color: #64748b; line-height: 1.8; }

.team-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 16px; margin-bottom: 40px; }
.team-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 24px 16px; text-align: center; transition: all 0.15s; }
.team-card:hover { border-color: #6366f1; box-shadow: 0 4px 14px rgba(99,102,241,0.08); }
.team-avatar { width: 64px; height: 64px; border-radius: 50%; margin: 0 auto 12px; background: #6366f1; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; color: #fff; }
.team-card h4 { font-size: 15px; font-weight: 700; color: #0f172a; margin-bottom: 3px; }
.team-card p { font-size: 13px; color: #6366f1; font-weight: 500; }

.cta-box { background: #0f172a; border-radius: 12px; padding: 48px 40px; text-align: center; }
.cta-box h2 { font-size: 26px; font-weight: 800; color: #fff; margin-bottom: 10px; }
.cta-box p { font-size: 15px; color: #94a3b8; margin-bottom: 24px; }
.cta-btns { display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
.btn-white { background: #fff; color: #1e293b; padding: 11px 26px; border-radius: 8px; font-size: 14px; font-weight: 700; text-decoration: none; transition: background 0.15s; }
.btn-white:hover { background: #f1f5f9; }
.btn-ghost-white { background: transparent; border: 1px solid rgba(255,255,255,0.3); color: #fff; padding: 11px 26px; border-radius: 8px; font-size: 14px; font-weight: 600; text-decoration: none; transition: all 0.15s; }
.btn-ghost-white:hover { border-color: rgba(255,255,255,0.6); }

@media(max-width:768px) {
    .about-hero h1 { font-size: 26px; }
    .about-hero { padding: 32px 20px; }
    .mv-grid { grid-template-columns: 1fr; }
    .stats-row { gap: 24px; }
    .cta-box { padding: 32px 20px; }
}
</style>
@endpush

@section('content')
<div class="about-page">

    <div class="about-hero">
        <h1>About <span>JobPortal Pro</span></h1>
        <p>We connect talented professionals with the world's best companies. Your dream career starts here.</p>
        <div class="stats-row">
            <div class="stat-item"><div class="stat-num">50K+</div><div class="stat-lbl">Jobs Listed</div></div>
            <div class="stat-item"><div class="stat-num">12K+</div><div class="stat-lbl">Companies</div></div>
            <div class="stat-item"><div class="stat-num">200K+</div><div class="stat-lbl">Job Seekers</div></div>
            <div class="stat-item"><div class="stat-num">95%</div><div class="stat-lbl">Success Rate</div></div>
        </div>
    </div>

    <div class="section-title">Why Choose Us</div>
    <div class="section-sub">Built for the modern job seeker and recruiter</div>
    <div class="cards-grid">
        @foreach([['🚀','Fast Hiring','Smart matching connects you with the right opportunity faster.'],['🏢','Top Companies','Thousands of verified companies from startups to Fortune 500s.'],['🔒','Secure & Private','Your data stays safe. We never share without your consent.'],['📱','Works Everywhere','Fully responsive on every device — phone, tablet, or desktop.'],['📄','Easy Applications','One profile, apply to hundreds of jobs instantly.'],['📊','Track Progress','Follow every application in real time, from submitted to hired.']] as $f)
        <div class="feature-card">
            <div class="feature-icon">{{ $f[0] }}</div>
            <h3>{{ $f[1] }}</h3>
            <p>{{ $f[2] }}</p>
        </div>
        @endforeach
    </div>

    <div class="section-title">Mission & Vision</div>
    <div class="section-sub">What drives us every day</div>
    <div class="mv-grid">
        <div class="mv-card">
            <h3>🎯 Our Mission</h3>
            <p>To simplify the job search process and create equal access to career opportunities for everyone — regardless of background or location. We believe talent is universal, but opportunity shouldn't be scarce.</p>
        </div>
        <div class="mv-card">
            <h3>🌍 Our Vision</h3>
            <p>A world where every qualified person finds meaningful work, and every great company finds the talent they need. We're building the most trusted, transparent job platform available.</p>
        </div>
    </div>

    <div class="section-title">Meet Our Team</div>
    <div class="section-sub">The people building the future of hiring</div>
    <div class="team-grid">
        @foreach([['S','Sonal Suthar','Founder & CEO'],['R','Rajesh Patel','Chief Technology Officer'],['A','Anita Sharma','Head of HR'],['V','Vishal Karpe','Lead Developer']] as $t)
        <div class="team-card">
            <div class="team-avatar">{{ $t[0] }}</div>
            <h4>{{ $t[1] }}</h4>
            <p>{{ $t[2] }}</p>
        </div>
        @endforeach
    </div>

    <div class="cta-box">
        <h2>Ready to start your journey?</h2>
        <p>Join thousands of professionals who found their dream job through JobPortal Pro.</p>
        <div class="cta-btns">
            <a href="{{ route('user.register') }}" class="btn-white">Get Started Free</a>
            <a href="{{ route('jobs.index') }}" class="btn-ghost-white">Browse Jobs</a>
        </div>
    </div>

</div>
@endsection
