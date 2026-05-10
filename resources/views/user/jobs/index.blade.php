@extends('user.layout')

@section('content')

<div class="container mt-5">

    <!-- 🔥 Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold">💼 Explore Jobs</h2>
            <p class="text-muted mb-0">Find your dream job easily</p>
        </div>
        <span class="badge bg-dark px-3 py-2">
            {{ count($jobs) }} Jobs
        </span>
    </div>

    <div class="row g-4">
    @foreach($jobs as $job)
        <div class="col-md-4">

            <div class="job-card p-4 h-100 d-flex flex-column justify-content-between">

                <!-- Top -->
                <div>
                    <span class="badge-job mb-3">🔥 New</span>

                    <h5 class="fw-bold mb-2">{{ $job->title }}</h5>

                    <p class="text-muted mb-2">
                        🏢 {{ $job->company ?? 'Company Name' }}
                    </p>

                    <p class="text-muted small">
                        {{ Str::limit($job->description, 90) }}
                    </p>
                </div>

                <!-- Bottom -->
                <div class="mt-3">
                    <a href="/jobs/{{ $job->id }}" class="btn btn-main w-100">
                        View Details →
                    </a>
                </div>

            </div>

        </div>
    @endforeach
    </div>

</div>

<!-- 🔥 MODERN CSS -->
<style>

body {
    background: linear-gradient(135deg, #f8fafc, #eef2ff);
}

/* Card */
.job-card {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(12px);
    border-radius: 20px;
    transition: all 0.3s ease;
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
    border: 1px solid rgba(255,255,255,0.3);
}

.job-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 25px 50px rgba(0,0,0,0.15);
}

/* Badge */
.badge-job {
    background: linear-gradient(45deg,#6366f1,#8b5cf6);
    color: black;
    padding: 6px 14px;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 500;
}

/* Button */
.btn-main {
    background: linear-gradient(45deg,#4f46e5,#7c3aed);
    color: white;
    border-radius: 30px;
    border: none;
    padding: 10px;
    font-weight: 600;
    transition: 0.3s;
}

.btn-main:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 25px rgba(99,102,241,0.4);
}

/* Smooth spacing */
h5 {
    font-size: 18px;
}

</style>

@endsection