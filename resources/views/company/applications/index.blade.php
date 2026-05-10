@extends('layouts.company-panel')

@section('title', 'Applications')
@section('page-title', 'Applications')

@section('content')

<!-- Filters -->
<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('company.applications') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:1;min-width:160px">
            <label class="form-label">Filter by Job</label>
            <select name="job_id" class="form-control">
                <option value="">All Jobs</option>
                @foreach($jobs as $j)
                    <option value="{{ $j->id }}" {{ request('job_id') == $j->id ? 'selected' : '' }}>{{ $j->title }}</option>
                @endforeach
            </select>
        </div>
        <div style="flex:1;min-width:140px">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                @foreach(['pending','reviewing','shortlisted','rejected','hired'] as $s)
                    <option {{ request('status') === $s ? 'selected' : '' }}>{{ $s }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:auto">Filter</button>
        <a href="{{ route('company.applications') }}" class="btn btn-outline" style="margin-top:auto">Reset</a>
    </form>
</div>

<div class="card">
    @if($applications->count() > 0)
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Job Applied</th>
                    <th>Applied On</th>
                    <th>Resume</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                @php
                    $statusMap=['pending'=>'badge-yellow','reviewing'=>'badge-blue','shortlisted'=>'badge-purple','rejected'=>'badge-red','hired'=>'badge-green'];
                @endphp
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:15px;font-weight:700;color:#fff;flex-shrink:0">
                                {{ strtoupper(substr($app->user->name ?? '?', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:14px;font-weight:600;color:#000">{{ $app->user->name ?? 'N/A' }}</div>
                                <div style="font-size:12px;color:#64748b">{{ $app->user->email ?? '' }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-size:14px;font-weight:500;color:#f1f5f9">{{ $app->job->title ?? 'N/A' }}</div>
                    </td>
                    <td>{{ $app->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($app->user && $app->user->resume)
                            <a href="{{ asset('storage/'.$app->user->resume) }}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-file"></i> View</a>
                        @elseif($app->resume)
                            <a href="{{ asset('storage/'.$app->resume) }}" target="_blank" class="btn btn-outline btn-sm"><i class="fas fa-file"></i> View</a>
                        @else
                            <span style="color:#475569;font-size:13px">No file</span>
                        @endif
                    </td>
                    <td><span class="badge {{ $statusMap[$app->status] ?? 'badge-gray' }}">{{ ucfirst($app->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('company.applications.view', $app->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                            <form method="POST" action="{{ route('company.applications.status', $app->id) }}" style="display:flex;gap:4px;align-items:center">
                                @csrf
                                <select name="status" class="form-control" style="padding:5px 8px;border-radius:8px;font-size:12px;min-width:100px">
                                    @foreach(['pending','reviewing','shortlisted','rejected','hired'] as $s)
                                        <option {{ $app->status === $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Set</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div style="margin-top:20px">{{ $applications->links() }}</div>
    @else
    <div style="text-align:center;padding:60px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">📨</div>
        <div style="font-size:18px;font-weight:600;color:#64748b">No applications yet</div>
        <p style="font-size:14px;margin-top:8px">Applications will appear here once candidates apply to your jobs</p>
    </div>
    @endif
</div>

@endsection
