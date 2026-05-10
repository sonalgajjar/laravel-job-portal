@extends('admin.layout')

@section('title', 'Application Details')
@section('page-title', 'Application Details')

@section('content')

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px">

    <!-- Main Card -->
    <div>
        <div class="card" style="margin-bottom:20px">
            <div class="card-header">
                <div class="card-title"><i class="fas fa-user" style="color:#f59e0b;margin-right:8px"></i>Applicant Info</div>
                <a href="{{ route('admin.applications') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
            </div>

            <div style="display:flex;align-items:center;gap:16px;margin-bottom:24px">
                <div style="width:60px;height:60px;border-radius:14px;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;font-size:24px;font-weight:800;color:#fff;flex-shrink:0;overflow:hidden">
                    @if($application->user && $application->user->profile_image)
                        <img src="{{ asset('storage/'.$application->user->profile_image) }}" style="width:100%;height:100%;object-fit:cover;border-radius:14px" alt="">
                    @else
                        {{ strtoupper(substr($application->user->name ?? 'U', 0, 1)) }}
                    @endif
                </div>
                <div>
                    <div style="font-size:18px;font-weight:700;color:#f1f5f9">{{ $application->user->name ?? 'Unknown User' }}</div>
                    <div style="font-size:13px;color:#64748b;margin-top:3px">{{ $application->user->email ?? '' }}</div>
                    @if($application->user && $application->user->phone)
                        <div style="font-size:13px;color:#64748b;margin-top:2px"><i class="fas fa-phone" style="color:#f59e0b;margin-right:4px"></i>{{ $application->user->phone }}</div>
                    @endif
                </div>
            </div>

            @if($application->user && $application->user->bio)
            <div style="margin-bottom:16px">
                <div style="font-size:13px;font-weight:600;color:#94a3b8;margin-bottom:6px">Bio</div>
                <div style="font-size:14px;color:#94a3b8;line-height:1.7">{{ $application->user->bio }}</div>
            </div>
            @endif

            @if($application->user && $application->user->skills)
            <div style="margin-bottom:16px">
                <div style="font-size:13px;font-weight:600;color:#94a3b8;margin-bottom:8px">Skills</div>
                <div style="display:flex;gap:8px;flex-wrap:wrap">
                    @foreach(explode(',', $application->user->skills) as $skill)
                        <span style="background:rgba(245,158,11,0.1);border:1px solid rgba(245,158,11,0.2);color:#fbbf24;padding:4px 12px;border-radius:20px;font-size:12px">{{ trim($skill) }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($application->user && $application->user->experience_info)
            <div style="margin-bottom:16px">
                <div style="font-size:13px;font-weight:600;color:#94a3b8;margin-bottom:6px">Experience</div>
                <div style="font-size:14px;color:#94a3b8;line-height:1.7;white-space:pre-line">{{ $application->user->experience_info }}</div>
            </div>
            @endif

            @if($application->user && $application->user->education_info)
            <div>
                <div style="font-size:13px;font-weight:600;color:#94a3b8;margin-bottom:6px">Education</div>
                <div style="font-size:14px;color:#94a3b8;line-height:1.7;white-space:pre-line">{{ $application->user->education_info }}</div>
            </div>
            @endif
        </div>

        <!-- Cover Letter -->
        @if($application->cover_letter)
        <div class="card">
            <div class="card-title" style="margin-bottom:14px"><i class="fas fa-envelope-open-text" style="color:#f59e0b;margin-right:8px"></i>Cover Letter</div>
            <div style="font-size:14px;color:#94a3b8;line-height:1.8;white-space:pre-line">{{ $application->cover_letter }}</div>
        </div>
        @endif

        <!-- Resume Text -->
        @if($application->user && $application->user->resume_text)
        <div class="card" style="margin-top:20px">
            <div class="card-title" style="margin-bottom:14px"><i class="fas fa-file-alt" style="color:#f59e0b;margin-right:8px"></i>Resume (Text)</div>
            <div style="font-size:14px;color:#94a3b8;line-height:1.8;white-space:pre-line">{{ $application->user->resume_text }}</div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div style="display:flex;flex-direction:column;gap:16px">

        <!-- Status Card -->
        <div class="card">
            <div class="card-title" style="margin-bottom:16px">Application Status</div>
            @php
                $statusMap = [
                    'pending'     => ['badge-yellow', 'Pending Review'],
                    'Pending'     => ['badge-yellow', 'Pending Review'],
                    'reviewing'   => ['badge-blue',   'Under Review'],
                    'shortlisted' => ['badge-purple', 'Shortlisted'],
                    'hired'       => ['badge-green',  'Hired'],
                    'approved'    => ['badge-green',  'Approved'],
                    'rejected'    => ['badge-red',    'Rejected'],
                ];
                $s = $statusMap[$application->status] ?? ['badge-gray', ucfirst($application->status)];
            @endphp
            <div style="text-align:center;margin-bottom:20px">
                <span class="badge {{ $s[0] }}" style="font-size:14px;padding:8px 20px">{{ $s[1] }}</span>
            </div>
            <form method="POST" action="{{ route('applications.updateStatus', $application->id) }}">
                @csrf
                <div class="form-group">
                    <label class="form-label">Update Status</label>
                    <select name="status" class="form-control">
                        <option value="pending"     {{ $application->status=='pending'     ? 'selected' : '' }}>Pending</option>
                        <option value="reviewing"   {{ $application->status=='reviewing'   ? 'selected' : '' }}>Reviewing</option>
                        <option value="shortlisted" {{ $application->status=='shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                        <option value="hired"       {{ $application->status=='hired'       ? 'selected' : '' }}>Hired</option>
                        <option value="rejected"    {{ $application->status=='rejected'    ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%">Update Status</button>
            </form>
        </div>

        <!-- Job Details -->
        @if($application->job)
        <div class="card">
            <div class="card-title" style="margin-bottom:14px"><i class="fas fa-briefcase" style="color:#f59e0b;margin-right:8px"></i>Job Details</div>
            <div style="font-size:15px;font-weight:700;color:#f1f5f9;margin-bottom:6px">{{ $application->job->title }}</div>
            <div style="font-size:13px;color:#64748b;margin-bottom:12px">{{ $application->job->company }}</div>
            <div style="display:flex;flex-direction:column;gap:8px">
                <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid rgba(245,158,11,0.07)">
                    <span style="color:#64748b">Location</span>
                    <span style="color:#f1f5f9;font-weight:600">{{ $application->job->location }}</span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid rgba(245,158,11,0.07)">
                    <span style="color:#64748b">Type</span>
                    <span style="color:#f1f5f9;font-weight:600">{{ $application->job->job_type }}</span>
                </div>
                @if($application->job->salary_range)
                <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0">
                    <span style="color:#64748b">Salary</span>
                    <span style="color:#34d399;font-weight:700">{{ $application->job->salary_range }}</span>
                </div>
                @endif
            </div>
            <a href="{{ route('jobs.show', $application->job->id) }}" target="_blank" class="btn btn-outline btn-sm" style="margin-top:14px;width:100%;justify-content:center">
                <i class="fas fa-external-link-alt"></i> View Job
            </a>
        </div>
        @endif

        <!-- Resume File -->
        <div class="card">
            <div class="card-title" style="margin-bottom:14px"><i class="fas fa-file-pdf" style="color:#f59e0b;margin-right:8px"></i>Resume File</div>
            @if($application->resume)
                <a href="{{ asset('storage/'.$application->resume) }}" target="_blank" class="btn btn-success" style="width:100%;justify-content:center">
                    <i class="fas fa-download"></i> Download Resume
                </a>
            @else
                <div style="text-align:center;color:#475569;font-size:14px;padding:12px 0">No resume uploaded</div>
            @endif
        </div>

        <!-- Application Meta -->
        <div class="card">
            <div class="card-title" style="margin-bottom:14px">Application Info</div>
            <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0;border-bottom:1px solid rgba(245,158,11,0.07)">
                <span style="color:#64748b">Applied On</span>
                <span style="color:#f1f5f9;font-weight:600">{{ $application->created_at->format('M d, Y') }}</span>
            </div>
            <div style="display:flex;justify-content:space-between;font-size:13px;padding:8px 0">
                <span style="color:#64748b">Application ID</span>
                <span style="color:#64748b">#{{ $application->id }}</span>
            </div>
        </div>
    </div>
</div>

@endsection
