@extends('layouts.company-panel')

@section('title', 'Job Listings')
@section('page-title', 'Job Listings')

@section('content')

<div class="card-header" style="margin-bottom:20px;display:flex;align-items:center;justify-content:space-between">
    <div>
        <div style="font-size:24px;font-weight:800;color:#f1f5f9">Your Jobs</div>
        <div style="font-size:14px;color:#64748b;margin-top:4px">{{ $jobs->total() }} total listings</div>
    </div>
    <a href="{{ route('company.jobs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Post New Job</a>
</div>

<div class="card">
    @if($jobs->count() > 0)
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Applications</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                <tr>
                    <td>
                        <div style="font-size:14px;font-weight:600;color:#000">{{ $job->title }}</div>
                        <div style="font-size:12px;color:#64748b;margin-top:2px">{{ $job->salary_range ?: 'Salary Negotiable' }}</div>
                    </td>
                    <td>{{ $job->location }}</td>
                    <td><span class="badge badge-blue">{{ $job->job_type }}</span></td>
                    <td>
                        <a href="{{ route('company.applications', ['job_id' => $job->id]) }}" style="color:#34d399;text-decoration:none;font-weight:600">
                            {{ $job->applications->count() }} applied
                        </a>
                    </td>
                    <td>{{ $job->deadline ? \Carbon\Carbon::parse($job->deadline)->format('M d, Y') : '—' }}</td>
                    <td>
                        @if($job->status === 'active')
                            <span class="badge badge-green">Active</span>
                        @elseif($job->status === 'inactive')
                            <span class="badge badge-yellow">Inactive</span>
                        @else
                            <span class="badge badge-gray">{{ ucfirst($job->status) }}</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('company.jobs.edit', $job->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-edit"></i></a>
                            <form method="POST" action="{{ route('company.jobs.delete', $job->id) }}" onsubmit="return confirm('Delete this job?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px">{{ $jobs->links() }}</div>
    @else
    <div style="text-align:center;padding:60px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">📋</div>
        <div style="font-size:18px;font-weight:600;color:#64748b;margin-bottom:8px">No jobs posted yet</div>
        <p style="font-size:14px;margin-bottom:20px">Start attracting top talent by posting your first job listing</p>
        <a href="{{ route('company.jobs.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Post Your First Job</a>
    </div>
    @endif
</div>

@endsection
