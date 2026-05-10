@extends('layouts.app')

@section('content')

<style>
/* 🌌 Background */
body {
    background: linear-gradient(135deg, #0f172a, #020617);
    font-family: 'Poppins', sans-serif;
    color: #e2e8f0;
}

/* 🌟 Container */
.job-container {
    max-width: 1100px;
    margin: 50px auto;
    padding: 20px;
}

/* 💎 Glass Card */
.job-card {
    background: rgba(255, 255, 255, 0.05);
    backdrop-filter: blur(18px);
    border-radius: 20px;
    padding: 35px;
    border: 1px solid rgba(255,255,255,0.08);
    box-shadow: 0 20px 40px rgba(0,0,0,0.5);
    transition: 0.4s ease;
    opacity: 0;
    transform: translateY(50px);
}

.job-card.show {
    opacity: 1;
    transform: translateY(0);
}

/* 🔥 Hover Glow */
.job-card:hover {
    box-shadow: 0 0 30px rgba(34,197,94,0.6);
}

/* 🧾 Title */
.job-title {
    font-size: 30px;
    font-weight: 700;
    color: #22c55e;
}

/* 🏢 Company */
.company-name {
    font-size: 18px;
    color: #94a3b8;
    margin-bottom: 10px;
}

/* 📌 Meta Info */
.job-meta {
    display: flex;
    gap: 20px;
    flex-wrap: wrap;
    margin: 15px 0;
}

.meta-box {
    background: rgba(255,255,255,0.05);
    padding: 10px 15px;
    border-radius: 10px;
    font-size: 14px;
}

/* 📄 Description */
.job-desc {
    margin-top: 25px;
    line-height: 1.8;
    color: #cbd5f5;
}

/* 🎯 Apply Button */
.apply-btn {
    display: inline-block;
    margin-top: 25px;
    padding: 12px 30px;
    background: linear-gradient(135deg, #22c55e, #4ade80);
    color: #022c22;
    border-radius: 30px;
    font-weight: 600;
    transition: 0.3s;
    text-decoration: none;
}

.apply-btn:hover {
    transform: scale(1.08);
    box-shadow: 0 0 20px #22c55e;
}

/* 🔙 Back Button */
.back-btn {
    display: inline-block;
    margin-bottom: 20px;
    color: #94a3b8;
    text-decoration: none;
}

.back-btn:hover {
    color: #22c55e;
}

/* ✨ Fade Animation Delay */
.delay {
    transition-delay: 0.2s;
}

</style>

<div class="job-container">

    <a href="{{ route('user.jobs.index') }}" class="back-btn">← Back to Jobs</a>

    <div class="job-card" id="jobCard">

        <div class="job-title">
            {{ $job->title }}
        </div>

        <div class="company-name">
            {{ $job->company_name ?? 'Company Name' }}
        </div>

        <div class="job-meta">
            <div class="meta-box">📍 {{ $job->location }}</div>
            <div class="meta-box">💼 {{ $job->category->name ?? 'Category' }}</div>
            <div class="meta-box">💰 ₹{{ $job->salary ?? 'Not disclosed' }}</div>
            <div class="meta-box">🕒 {{ $job->created_at->diffForHumans() }}</div>
        </div>

        <div class="job-desc">
            {!! nl2br(e($job->description)) !!}
        </div>

        <a href="#" class="apply-btn">
            Apply Now 🚀
        </a>

    </div>

</div>

<script>

/* 🎬 Scroll Animation */
window.addEventListener('load', () => {
    document.getElementById('jobCard').classList.add('show');
});

/* ✨ Mouse Move Glow Effect */
document.addEventListener("mousemove", (e) => {
    const card = document.querySelector(".job-card");
    const x = e.clientX / window.innerWidth;
    const y = e.clientY / window.innerHeight;

    card.style.transform = `rotateY(${(x - 0.5) * 10}deg) rotateX(${(0.5 - y) * 10}deg)`;
});

/* 🔥 Reset on Leave */
document.querySelector(".job-card").addEventListener("mouseleave", () => {
    document.querySelector(".job-card").style.transform = "rotateY(0deg) rotateX(0deg)";
});

</script>

@endsection