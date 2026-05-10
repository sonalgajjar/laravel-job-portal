@extends('admin.layout')

@section('title', 'Company Details')
@section('page-title', 'Company Details')

@section('content')
<div style="max-width:900px">
    <div style="margin-bottom:16px">
        <a href="{{ route('admin.companies') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back to Companies</a>
    </div>

    <!-- Company Header -->
    <div class="card" style="margin-bottom:20px">
        <div style="display:flex;align-items:flex-start;gap:20px;flex-wrap:wrap">
            <div style="width:80px;height:80px;border-radius:16px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:36px;flex-shrink:0;overflow:hidden">
                @if($company->logo)
                    <img src="{{ asset('storage/'.$company->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:16px" alt="">
                @else 🏢 @endif
            </div>
            <div style="flex:1">
                <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;flex-wrap:wrap">
                    <div style="font-size:26px;font-weight:800;color:#f1f5f9">{{ $company->name }}</div>
                    @if($company->status === 'approved')
                        <span class="badge badge-green" style="font-size:13px;padding:6px 14px">✓ Approved</span>
                    @elseif($company->status === 'pending')
                        <span class="badge badge-yellow" style="font-size:13px;padding:6px 14px">⏳ Pending</span>
                    @else
                        <span class="badge badge-red" style="font-size:13px;padding:6px 14px">✗ Rejected</span>
                    @endif
                </div>
                <div style="display:flex;gap:20px;flex-wrap:wrap">
                    <span style="font-size:14px;color:#64748b"><i class="fas fa-envelope" style="color:#f59e0b;margin-right:6px"></i>{{ $company->email }}</span>
                    @if($company->phone)<span style="font-size:14px;color:#64748b"><i class="fas fa-phone" style="color:#f59e0b;margin-right:6px"></i>{{ $company->phone }}</span>@endif
                    @if($company->location)<span style="font-size:14px;color:#64748b"><i class="fas fa-map-marker-alt" style="color:#f59e0b;margin-right:6px"></i>{{ $company->location }}</span>@endif
                    @if($company->website)<a href="{{ $company->website }}" target="_blank" style="font-size:14px;color:#818cf8;text-decoration:none"><i class="fas fa-globe" style="margin-right:6px"></i>{{ $company->website }}</a>@endif
                </div>
            </div>
        </div>

        @if($company->description)
        <div style="margin-top:20px;padding-top:20px;border-top:1px solid rgba(245,158,11,0.1)">
            <div style="font-size:13px;font-weight:600;color:#64748b;margin-bottom:8px">ABOUT</div>
            <p style="font-size:14px;color:#94a3b8;line-height:1.7">{{ $company->description }}</p>
        </div>
        @endif

        <div style="margin-top:20px;display:grid;grid-template-columns:repeat(3,1fr);gap:12px">
            <div style="padding:14px;background:rgba(245,158,11,0.05);border-radius:10px;border:1px solid rgba(245,158,11,0.1)">
                <div style="font-size:12px;color:#64748b">Industry</div>
                <div style="font-size:14px;font-weight:600;color:#f1f5f9;margin-top:4px">{{ $company->industry ?: '—' }}</div>
            </div>
            <div style="padding:14px;background:rgba(245,158,11,0.05);border-radius:10px;border:1px solid rgba(245,158,11,0.1)">
                <div style="font-size:12px;color:#64748b">Company Size</div>
                <div style="font-size:14px;font-weight:600;color:#f1f5f9;margin-top:4px">{{ $company->company_size ?: '—' }}</div>
            </div>
            <div style="padding:14px;background:rgba(245,158,11,0.05);border-radius:10px;border:1px solid rgba(245,158,11,0.1)">
                <div style="font-size:12px;color:#64748b">Registered On</div>
                <div style="font-size:14px;font-weight:600;color:#f1f5f9;margin-top:4px">{{ $company->created_at->format('M d, Y') }}</div>
            </div>
        </div>

        <!-- Actions -->
        <div style="margin-top:20px;display:flex;gap:10px;flex-wrap:wrap">
            @if($company->status !== 'approved')
            <form method="POST" action="{{ route('admin.companies.approve', $company->id) }}">
                @csrf
                <button type="submit" class="btn btn-success"><i class="fas fa-check"></i> Approve Company</button>
            </form>
            @endif
            @if($company->status !== 'rejected')
            <form method="POST" action="{{ route('admin.companies.reject', $company->id) }}">
                @csrf
                <button type="submit" class="btn btn-outline" style="color:#fbbf24;border-color:rgba(245,158,11,0.3)"><i class="fas fa-ban"></i> Reject</button>
            </form>
            @endif
            <form method="POST" action="{{ route('admin.companies.delete', $company->id) }}" onsubmit="return confirm('Delete this company and all its jobs?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete Company</button>
            </form>
        </div>
    </div>

    <!-- Jobs Posted -->
    <div class="card">
        <div class="card-header">
            <div class="card-title">Jobs Posted ({{ $company->jobs->count() }})</div>
        </div>
        @if($company->jobs->count() > 0)
        <div class="table-wrap">
            <table>
                <thead>
                    <tr><th>Job Title</th><th>Location</th><th>Type</th><th>Status</th><th>Posted</th></tr>
                </thead>
                <tbody>
                    @foreach($company->jobs as $job)
                    <tr>
                        <td style="font-size:14px;font-weight:600;color:#f1f5f9">{{ $job->title }}</td>
                        <td>{{ $job->location }}</td>
                        <td><span class="badge badge-blue">{{ $job->job_type }}</span></td>
                        <td>
                            @if($job->status === 'active')<span class="badge badge-green">Active</span>
                            @else<span class="badge badge-gray">{{ ucfirst($job->status) }}</span>@endif
                        </td>
                        <td>{{ $job->created_at->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="text-align:center;padding:30px;color:#475569">No jobs posted yet</div>
        @endif
    </div>
</div>
@endsection
