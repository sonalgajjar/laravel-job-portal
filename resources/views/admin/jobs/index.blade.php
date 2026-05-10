@extends('admin.layout')

@section('title', 'Manage Jobs')
@section('page-title', 'Manage Jobs')

@section('content')

<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('admin.jobs.index') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:2;min-width:200px">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Job title or company..." value="{{ request('search') }}">
        </div>
        <div style="flex:1;min-width:140px">
            <label class="form-label">Category</label>
            <select name="category" class="form-control">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>
        <div style="flex:1;min-width:120px">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All Status</option>
                <option {{ request('status')==='active'   ? 'selected' : '' }} value="active">Active</option>
                <option {{ request('status')==='inactive' ? 'selected' : '' }} value="inactive">Inactive</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:auto">Filter</button>
        <a href="{{ route('admin.jobs.index') }}" class="btn btn-outline" style="margin-top:auto">Reset</a>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">All Jobs ({{ count($jobs) }})</div>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Add Job</a>
    </div>

    @if(count($jobs) > 0)
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Job</th>
                    <th>Company</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Category</th>
                    <th>Salary</th>
                    <th>Status</th>
                    <th>Posted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                <tr>
                    <td>
                        <div style="font-size:14px;font-weight:600;color:#000">{{ $job->title }}</div>
                        @if($job->vacancies)
                            <div style="font-size:12px;color:#64748b">{{ $job->vacancies }} opening{{ $job->vacancies > 1 ? 's' : '' }}</div>
                        @endif
                    </td>
                    <td style="color:#94a3b8">{{ $job->company }}</td>
                    <td style="color:#94a3b8">{{ $job->location }}</td>
                    <td><span class="badge badge-blue">{{ $job->job_type }}</span></td>
                    <td style="color:#94a3b8">{{ $job->category->name ?? '—' }}</td>
                    <td style="color:#34d399;font-weight:600">{{ $job->salary_range ?: '—' }}</td>
                    <td>
                        @if($job->status === 'active')
                            <span class="badge badge-green">Active</span>
                        @else
                            <span class="badge badge-gray">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $job->created_at->format('M d, Y') }}</td>
                    <td>
                        <div style="display:flex;gap:6px">
                            <a href="{{ route('admin.jobs.edit', $job->id) }}" class="btn btn-outline btn-sm" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form method="POST" action="{{ route('admin.jobs.delete', $job->id) }}" onsubmit="return confirm('Delete this job?')">
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
    @else
    <div style="text-align:center;padding:60px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">💼</div>
        <div style="font-size:18px;font-weight:600;color:#64748b">No jobs found</div>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary" style="margin-top:20px"><i class="fas fa-plus"></i> Post First Job</a>
    </div>
    @endif
</div>

@endsection
