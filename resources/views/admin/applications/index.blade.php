@extends('admin.layout')

@section('title', 'Applications')
@section('page-title', 'Applications')

@section('content')

<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('admin.applications') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:2;min-width:200px">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="User name, job title..." value="{{ request('search') }}">
        </div>
        <div style="flex:1;min-width:140px">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option {{ request('status')==='pending'   ? 'selected' : '' }} value="pending">Pending</option>
                <option {{ request('status')==='reviewing' ? 'selected' : '' }} value="reviewing">Reviewing</option>
                <option {{ request('status')==='shortlisted' ? 'selected' : '' }} value="shortlisted">Shortlisted</option>
                <option {{ request('status')==='hired'     ? 'selected' : '' }} value="hired">Hired</option>
                <option {{ request('status')==='rejected'  ? 'selected' : '' }} value="rejected">Rejected</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:auto">Filter</button>
        <a href="{{ route('admin.applications') }}" class="btn btn-outline" style="margin-top:auto">Reset</a>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">All Applications ({{ $applications->count() }})</div>
    </div>

    @if($applications->count() > 0)
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Applicant</th>
                    <th>Job</th>
                    <th>Company</th>
                    <th>Resume</th>
                    <th>Applied</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($applications as $app)
                @php
                    $statusMap = [
                        'pending'     => 'badge-yellow',
                        'Pending'     => 'badge-yellow',
                        'reviewing'   => 'badge-blue',
                        'shortlisted' => 'badge-purple',
                        'hired'       => 'badge-green',
                        'approved'    => 'badge-green',
                        'rejected'    => 'badge-red',
                    ];
                    $badgeClass = $statusMap[$app->status] ?? 'badge-gray';
                @endphp
                <tr>
                    <td>
                        <div style="font-size:14px;font-weight:600;color:#000">{{ $app->user->name ?? '—' }}</div>
                        <div style="font-size:12px;color:#64748b">{{ $app->user->email ?? '' }}</div>
                    </td>
                    <td style="font-weight:600;color:#94a3b8">{{ $app->job->title ?? 'Job removed' }}</td>
                    <td style="color:#94a3b8">{{ $app->job->company ?? '—' }}</td>
                    <td>
                        @if($app->resume)
                            <a href="{{ asset('storage/'.$app->resume) }}" target="_blank" class="btn btn-outline btn-sm">
                                <i class="fas fa-file-pdf"></i> View
                            </a>
                        @else
                            <span style="color:#475569;font-size:13px">No file</span>
                        @endif
                    </td>
                    <td>{{ $app->created_at->format('M d, Y') }}</td>
                    <td><span class="badge {{ $badgeClass }}">{{ ucfirst($app->status) }}</span></td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            <a href="{{ route('admin.applications.view', $app->id) }}" class="btn btn-outline btn-sm" title="View Details">
                                <i class="fas fa-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('applications.updateStatus', $app->id) }}" style="display:inline">
                                @csrf
                                <select name="status" onchange="this.form.submit()" class="form-control" style="padding:6px 10px;font-size:12px;width:auto">
                                    <option value="pending"     {{ $app->status=='pending'     ? 'selected' : '' }}>Pending</option>
                                    <option value="reviewing"   {{ $app->status=='reviewing'   ? 'selected' : '' }}>Reviewing</option>
                                    <option value="shortlisted" {{ $app->status=='shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                    <option value="hired"       {{ $app->status=='hired'       ? 'selected' : '' }}>Hired</option>
                                    <option value="rejected"    {{ $app->status=='rejected'    ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div style="text-align:center;padding:60px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">📭</div>
        <div style="font-size:18px;font-weight:600;color:#64748b">No applications found</div>
    </div>
    @endif
</div>

@endsection
