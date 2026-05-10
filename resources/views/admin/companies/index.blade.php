@extends('admin.layout')

@section('title', 'Companies')
@section('page-title', 'Companies')

@section('content')

<!-- Filters -->
<div class="card" style="margin-bottom:20px">
    <form method="GET" action="{{ route('admin.companies') }}" style="display:flex;gap:12px;flex-wrap:wrap;align-items:flex-end">
        <div style="flex:2;min-width:200px">
            <label class="form-label">Search</label>
            <input type="text" name="search" class="form-control" placeholder="Company name or email..." value="{{ request('search') }}">
        </div>
        <div style="flex:1;min-width:140px">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="">All Statuses</option>
                <option {{ request('status') === 'pending' ? 'selected' : '' }}>pending</option>
                <option {{ request('status') === 'approved' ? 'selected' : '' }}>approved</option>
                <option {{ request('status') === 'rejected' ? 'selected' : '' }}>rejected</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary" style="margin-top:auto">Filter</button>
        <a href="{{ route('admin.companies') }}" class="btn btn-outline" style="margin-top:auto">Reset</a>
    </form>
</div>

<div class="card">
    <div class="card-header">
        <div class="card-title">All Companies ({{ $companies->total() }})</div>
    </div>
    @if($companies->count() > 0)
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Company</th>
                    <th>Industry</th>
                    <th>Location</th>
                    <th>Jobs</th>
                    <th>Registered</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($companies as $co)
                <tr>
                    <td>
                        <div style="display:flex;align-items:center;gap:10px">
                            <div style="width:40px;height:40px;border-radius:10px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;overflow:hidden">
                                @if($co->logo)
                                    <img src="{{ asset('storage/'.$co->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:10px" alt="">
                                @else
                                    🏢
                                @endif
                            </div>
                            <div>
                                <div style="font-size:14px;font-weight:600;color:#000">{{ $co->name }}</div>
                                <div style="font-size:12px;color:#64748b">{{ $co->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td>{{ $co->industry ?: '—' }}</td>
                    <td>{{ $co->location ?: '—' }}</td>
                    <td>{{ $co->jobs->count() }} jobs</td>
                    <td>{{ $co->created_at->format('M d, Y') }}</td>
                    <td>
                        @if($co->status === 'approved')
                            <span class="badge badge-green">Approved</span>
                        @elseif($co->status === 'pending')
                            <span class="badge badge-yellow">Pending</span>
                        @else
                            <span class="badge badge-red">Rejected</span>
                        @endif
                    </td>
                    <td>
                        <div style="display:flex;gap:6px;flex-wrap:wrap">
                            <a href="{{ route('admin.companies.show', $co->id) }}" class="btn btn-outline btn-sm"><i class="fas fa-eye"></i></a>
                            @if($co->status !== 'approved')
                            <form method="POST" action="{{ route('admin.companies.approve', $co->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm"><i class="fas fa-check"></i> Approve</button>
                            </form>
                            @endif
                            @if($co->status !== 'rejected')
                            <form method="POST" action="{{ route('admin.companies.reject', $co->id) }}">
                                @csrf
                                <button type="submit" class="btn btn-outline btn-sm" style="color:#fbbf24;border-color:rgba(245,158,11,0.3)"><i class="fas fa-ban"></i> Reject</button>
                            </form>
                            @endif
                            <form method="POST" action="{{ route('admin.companies.delete', $co->id) }}" onsubmit="return confirm('Delete {{ addslashes($co->name) }} and all its jobs?')">
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
    <div style="margin-top:20px">{{ $companies->links() }}</div>
    @else
    <div style="text-align:center;padding:60px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">🏢</div>
        <div style="font-size:18px;font-weight:600;color:#64748b">No companies found</div>
    </div>
    @endif
</div>

@endsection
