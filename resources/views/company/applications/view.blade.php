@extends('layouts.company-panel')

@section('title', 'Application Detail')
@section('page-title', 'Application Detail')

@section('content')
<div style="max-width:760px">
    <div style="margin-bottom:16px">
        <a href="{{ route('company.applications') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Applications</a>
    </div>

    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <div class="card-title">Applicant Profile</div>
            @php
                $statusMap=['pending'=>'badge-yellow','reviewing'=>'badge-blue','shortlisted'=>'badge-purple','rejected'=>'badge-red','hired'=>'badge-green'];
            @endphp
            <span class="badge {{ $statusMap[$application->status] ?? 'badge-gray' }}" style="font-size:14px;padding:6px 14px">
                {{ ucfirst($application->status) }}
            </span>
        </div>

        <div style="display:flex;gap:20px;align-items:flex-start;flex-wrap:wrap">
            <div style="width:80px;height:80px;border-radius:16px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden">
                @if($application->user && $application->user->profile_image)
                    <img src="{{ asset('storage/'.$application->user->profile_image) }}" style="width:100%;height:100%;object-fit:cover" alt="">
                @else
                    {{ strtoupper(substr($application->user->name ?? '?', 0, 1)) }}
                @endif
            </div>
            <div style="flex:1">
                <div style="font-size:22px;font-weight:800;color:#f1f5f9;margin-bottom:6px">{{ $application->user->name ?? 'N/A' }}</div>
                <div style="font-size:14px;color:#64748b;margin-bottom:4px"><i class="fas fa-envelope" style="margin-right:6px;color:#818cf8"></i>{{ $application->user->email ?? '—' }}</div>
                @if($application->user && $application->user->phone)
                <div style="font-size:14px;color:#64748b;margin-bottom:4px"><i class="fas fa-phone" style="margin-right:6px;color:#818cf8"></i>{{ $application->user->phone }}</div>
                @endif
                @if($application->user && $application->user->address)
                <div style="font-size:14px;color:#64748b"><i class="fas fa-map-marker-alt" style="margin-right:6px;color:#818cf8"></i>{{ $application->user->address }}</div>
                @endif
            </div>
        </div>

        @if($application->user && $application->user->bio)
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid rgba(16,185,129,0.1)">
            <div style="font-size:13px;font-weight:600;color:#64748b;margin-bottom:8px">BIO</div>
            <p style="font-size:14px;color:#94a3b8;line-height:1.7">{{ $application->user->bio }}</p>
        </div>
        @endif

        @if($application->user && $application->user->skills)
        <div style="margin-top:16px">
            <div style="font-size:13px;font-weight:600;color:#64748b;margin-bottom:8px">SKILLS</div>
            <div style="display:flex;gap:8px;flex-wrap:wrap">
                @foreach(explode(',', $application->user->skills) as $skill)
                    <span class="badge badge-blue">{{ trim($skill) }}</span>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <!-- Job Details -->
    <div class="card" style="margin-bottom:20px">
        <div class="card-title" style="margin-bottom:16px">Applied For</div>
        <div style="background:rgba(16,185,129,0.05);border:1px solid rgba(16,185,129,0.1);border-radius:12px;padding:16px">
            <div style="font-size:18px;font-weight:700;color:#f1f5f9;margin-bottom:8px">{{ $application->job->title ?? 'N/A' }}</div>
            <div style="display:flex;gap:20px;flex-wrap:wrap">
                <span style="font-size:13px;color:#64748b"><i class="fas fa-map-marker-alt" style="margin-right:4px;color:#34d399"></i>{{ $application->job->location ?? '—' }}</span>
                <span style="font-size:13px;color:#64748b"><i class="fas fa-briefcase" style="margin-right:4px;color:#34d399"></i>{{ $application->job->job_type ?? '—' }}</span>
                <span style="font-size:13px;color:#64748b"><i class="fas fa-dollar-sign" style="margin-right:4px;color:#34d399"></i>{{ $application->job->salary_range ?: 'Negotiable' }}</span>
            </div>
        </div>
        <div style="margin-top:12px;font-size:13px;color:#64748b">
            Applied on: <strong style="color:#94a3b8">{{ $application->created_at->format('M d, Y h:i A') }}</strong>
        </div>
    </div>

    <!-- Experience & Education -->
    @if($application->user && ($application->user->experience_info || $application->user->education_info))
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px">
        @if($application->user->experience_info)
        <div class="card">
            <div class="card-title" style="margin-bottom:12px"><i class="fas fa-briefcase" style="color:#34d399;margin-right:8px"></i>Experience</div>
            <p style="font-size:14px;color:#94a3b8;line-height:1.7;white-space:pre-line">{{ $application->user->experience_info }}</p>
        </div>
        @endif
        @if($application->user->education_info)
        <div class="card">
            <div class="card-title" style="margin-bottom:12px"><i class="fas fa-graduation-cap" style="color:#34d399;margin-right:8px"></i>Education</div>
            <p style="font-size:14px;color:#94a3b8;line-height:1.7;white-space:pre-line">{{ $application->user->education_info }}</p>
        </div>
        @endif
    </div>
    @endif

    <!-- Cover Letter -->
    @if($application->cover_letter)
    <div class="card" style="margin-bottom:20px">
        <div class="card-title" style="margin-bottom:12px"><i class="fas fa-file-alt" style="color:#34d399;margin-right:8px"></i>Cover Letter</div>
        <p style="font-size:14px;color:#94a3b8;line-height:1.7">{{ $application->cover_letter }}</p>
    </div>
    @endif

    <!-- Resume & Status Update -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Resume & Action</div>
        </div>
        <div style="display:flex;gap:16px;align-items:center;flex-wrap:wrap">
            @if($application->user && $application->user->resume)
                <a href="{{ asset('storage/'.$application->user->resume) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Resume
                </a>
            @elseif($application->resume)
                <a href="{{ asset('storage/'.$application->resume) }}" target="_blank" class="btn btn-primary">
                    <i class="fas fa-download"></i> Download Resume
                </a>
            @else
                <span style="color:#475569;font-size:14px"><i class="fas fa-info-circle" style="margin-right:6px"></i>No resume file uploaded</span>
            @endif
        </div>

        <div style="margin-top:20px;padding-top:20px;border-top:1px solid rgba(16,185,129,0.1)">
            <div style="font-size:13px;font-weight:600;color:#64748b;margin-bottom:12px">UPDATE STATUS</div>
            <form method="POST" action="{{ route('company.applications.status', $application->id) }}" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap">
                @csrf
                <select name="status" class="form-control" style="max-width:200px">
                    @foreach(['pending','reviewing','shortlisted','rejected','hired'] as $s)
                        <option {{ $application->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                    @endforeach
                </select>
                <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> Update Status</button>
            </form>
        </div>
    </div>
</div>

@endsection
