@extends('layouts.user-panel')

@section('title', 'My Applications')
@section('page-title', 'My Applications')

@section('content')

<div class="card">
    <div class="card-header">
        <div class="card-title">All Applications ({{ count($applications) }})</div>
        <a href="{{ route('jobs.index') }}" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Find More Jobs</a>
    </div>

    @forelse($applications as $app)
    @php
        $statusMap = [
            'pending'     => ['badge-yellow', 'clock',        'Pending'],
            'Pending'     => ['badge-yellow', 'clock',        'Pending'],
            'reviewing'   => ['badge-blue',   'eye',          'Under Review'],
            'shortlisted' => ['badge-purple', 'star',         'Shortlisted'],
            'rejected'    => ['badge-red',    'times-circle', 'Rejected'],
            'hired'       => ['badge-green',  'check-circle', 'Hired!'],
            'approved'    => ['badge-green',  'check-circle', 'Approved'],
        ];
        $s = $statusMap[$app->status] ?? ['badge-gray', 'question-circle', ucfirst($app->status ?? 'Unknown')];
    @endphp
    <div style="display:flex;align-items:center;gap:16px;padding:16px 0;border-bottom:1px solid rgba(99,102,241,0.07)">
        <div style="width:52px;height:52px;border-radius:12px;background:linear-gradient(135deg,#1e293b,#334155);border:1px solid rgba(99,102,241,0.2);display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0">
            🏢
        </div>
        <div style="flex:1;min-width:0">
            <div style="font-size:16px;font-weight:700;color:#000">{{ $app->job->title ?? 'Job no longer available' }}</div>
            <div style="font-size:13px;color:#64748b;margin-top:3px;display:flex;gap:14px;flex-wrap:wrap">
                <span><i class="fas fa-building" style="margin-right:4px;color:#818cf8"></i>{{ $app->job->company ?? '—' }}</span>
                <span><i class="fas fa-map-marker-alt" style="margin-right:4px;color:#818cf8"></i>{{ $app->job->location ?? '—' }}</span>
                <span><i class="fas fa-calendar" style="margin-right:4px;color:#818cf8"></i>Applied {{ $app->created_at->diffForHumans() }}</span>
            </div>
        </div>
        <div style="flex-shrink:0">
            <span class="badge {{ $s[0] }}" style="font-size:13px;padding:6px 14px">
                <i class="fas fa-{{ $s[1] }}" style="margin-right:5px"></i>{{ $s[2] }}
            </span>
        </div>
        @if($app->job)
        <a href="{{ route('jobs.show', $app->job->id) }}" class="btn btn-outline btn-sm" style="flex-shrink:0">
            <i class="fas fa-eye"></i>
        </a>
        @endif
    </div>
    @empty
    <div style="text-align:center;padding:60px 20px;color:#475569">
        <div style="font-size:56px;margin-bottom:16px">📭</div>
        <div style="font-size:18px;font-weight:600;color:#64748b;margin-bottom:8px">No applications yet</div>
        <p style="font-size:14px;margin-bottom:24px">Start applying to jobs and track your progress here</p>
        <a href="{{ route('jobs.index') }}" class="btn btn-primary"><i class="fas fa-search"></i> Browse Jobs</a>
    </div>
    @endforelse
</div>

@endsection
