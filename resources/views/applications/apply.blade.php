@extends('layouts.public')
@section('title', 'Apply — ' . $job->title)

@push('styles')
<style>
.apply-page { max-width: 860px; margin: 0 auto; padding: 32px 24px; }
.back-link { display: inline-flex; align-items: center; gap: 7px; color: #64748b; text-decoration: none; font-size: 14px; margin-bottom: 20px; transition: color 0.15s; }
.back-link:hover { color: #6366f1; }

.apply-grid { display: grid; grid-template-columns: 1fr 280px; gap: 18px; }

.apply-card { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 28px; }
.apply-card h2 { font-size: 20px; font-weight: 800; color: #0f172a; margin-bottom: 4px; }
.apply-card > p { font-size: 14px; color: #64748b; margin-bottom: 24px; }

.field-group { margin-bottom: 18px; }
.field-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
.field-input { width: 100%; background: #f8fafc; border: 1px solid #d1d5db; border-radius: 8px; padding: 11px 13px; color: #1e293b; font-size: 14px; font-family: 'Inter',sans-serif; outline: none; transition: border 0.15s; }
.field-input:focus { border-color: #6366f1; background: #fff; box-shadow: 0 0 0 3px rgba(99,102,241,0.08); }
.field-input::placeholder { color: #9ca3af; }

.file-zone { border: 2px dashed #d1d5db; border-radius: 8px; padding: 24px; text-align: center; cursor: pointer; transition: all 0.15s; background: #f8fafc; }
.file-zone:hover { border-color: #6366f1; background: #eef2ff; }
.file-zone input { display: none; }
.file-zone-icon { font-size: 28px; color: #6366f1; margin-bottom: 8px; }
.file-zone-text { font-size: 14px; color: #64748b; }
.file-zone-hint { font-size: 12px; color: #94a3b8; margin-top: 4px; }

.btn-submit { width: 100%; background: #6366f1; color: #fff; border: none; padding: 13px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; font-family: 'Inter',sans-serif; transition: background 0.15s; margin-top: 6px; display: flex; align-items: center; justify-content: center; gap: 8px; }
.btn-submit:hover { background: #4f46e5; }

.already-badge { background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px; border-radius: 8px; font-size: 14px; font-weight: 600; text-align: center; }

/* Sidebar */
.job-mini { background: #fff; border: 1px solid #e2e8f0; border-radius: 10px; padding: 20px; }
.mini-head { display: flex; align-items: center; gap: 10px; margin-bottom: 14px; padding-bottom: 14px; border-bottom: 1px solid #f1f5f9; }
.mini-logo { width: 44px; height: 44px; border-radius: 8px; background: #f1f5f9; border: 1px solid #e2e8f0; display: flex; align-items: center; justify-content: center; font-size: 20px; overflow: hidden; flex-shrink: 0; }
.mini-logo img { width: 100%; height: 100%; object-fit: cover; border-radius: 8px; }
.mini-title { font-size: 14px; font-weight: 700; color: #0f172a; }
.mini-company { font-size: 12px; color: #6366f1; font-weight: 500; }
.info-row { display: flex; gap: 8px; align-items: center; padding: 8px 0; border-bottom: 1px solid #f8fafc; font-size: 13px; }
.info-row:last-child { border-bottom: none; }
.info-row i { color: #6366f1; width: 14px; text-align: center; font-size: 12px; flex-shrink: 0; }
.info-row .lbl { color: #64748b; flex: 1; }
.info-row .val { color: #1e293b; font-weight: 600; }

.privacy-note { margin-top: 12px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 12px 14px; font-size: 13px; color: #166534; }

@media(max-width:700px) { .apply-grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="apply-page">
    <a href="{{ route('jobs.show', $job->id) }}" class="back-link"><i class="fas fa-arrow-left"></i> Back to Job</a>

    <div class="apply-grid">
        <div class="apply-card">
            <h2>Apply for this Position</h2>
            <p>{{ $job->title }} at {{ $job->company }}</p>

            @php
                $alreadyApplied = \App\Models\Application::where('user_id', auth()->id())->where('job_id', $job->id)->exists();
            @endphp

            @if($alreadyApplied)
                <div class="already-badge"><i class="fas fa-check-circle" style="margin-right:7px"></i> You've already applied for this job</div>
                <div style="text-align:center;margin-top:14px">
                    <a href="{{ route('my.jobs') }}" style="color:#6366f1;font-size:14px;font-weight:600;text-decoration:none"><i class="fas fa-list" style="margin-right:5px"></i> View My Applications</a>
                </div>
            @else
                <form method="POST" action="{{ route('apply.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="job_id" value="{{ $job->id }}">

                    <div class="field-group">
                        <label class="field-label">Upload Resume <span style="color:#dc2626">*</span> <span style="font-weight:400;color:#94a3b8">(PDF / DOC / DOCX)</span></label>
                        <label class="file-zone" id="fileZone">
                            <input type="file" name="resume" id="resumeInput" accept=".pdf,.doc,.docx" required onchange="updateFileLabel(this)">
                            <div id="fileLabel">
                                <div class="file-zone-icon"><i class="fas fa-cloud-upload-alt"></i></div>
                                <div class="file-zone-text">Click to upload or drag & drop</div>
                                <div class="file-zone-hint">PDF, DOC, DOCX — max 2MB</div>
                            </div>
                        </label>
                        @error('resume')<div style="color:#dc2626;font-size:12px;margin-top:5px">{{ $message }}</div>@enderror
                    </div>

                    <div class="field-group">
                        <label class="field-label">Cover Letter <span style="font-weight:400;color:#94a3b8">(optional)</span></label>
                        <textarea name="cover_letter" class="field-input" rows="5" placeholder="Tell us why you're the perfect fit for this role...">{{ old('cover_letter') }}</textarea>
                    </div>

                    <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Submit Application</button>
                </form>
            @endif
        </div>

        <div>
            <div class="job-mini">
                <div class="mini-head">
                    <div class="mini-logo">
                        @if($job->companyModel && $job->companyModel->logo)
                            <img src="{{ asset('storage/'.$job->companyModel->logo) }}" alt="">
                        @else 🏢 @endif
                    </div>
                    <div>
                        <div class="mini-title">{{ $job->title }}</div>
                        <div class="mini-company">{{ $job->company }}</div>
                    </div>
                </div>
                <div class="info-row"><i class="fas fa-map-marker-alt"></i><span class="lbl">Location</span><span class="val">{{ $job->location }}</span></div>
                <div class="info-row"><i class="fas fa-briefcase"></i><span class="lbl">Type</span><span class="val">{{ $job->job_type }}</span></div>
                <div class="info-row"><i class="fas fa-money-bill-wave"></i><span class="lbl">Salary</span><span class="val">{{ $job->salary_range ?: 'Negotiable' }}</span></div>
                @if($job->experience_required)<div class="info-row"><i class="fas fa-user-clock"></i><span class="lbl">Experience</span><span class="val">{{ $job->experience_required }}</span></div>@endif
                @if($job->deadline)<div class="info-row"><i class="fas fa-calendar"></i><span class="lbl">Deadline</span><span class="val" style="color:#dc2626">{{ \Carbon\Carbon::parse($job->deadline)->format('M d, Y') }}</span></div>@endif

                @if($job->skills_required)
                <div style="margin-top:14px;padding-top:12px;border-top:1px solid #f1f5f9">
                    <div style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:8px">Skills</div>
                    <div style="display:flex;flex-wrap:wrap;gap:5px">
                        @foreach(explode(',', $job->skills_required) as $sk)
                            <span style="background:#f1f5f9;border:1px solid #e2e8f0;color:#374151;padding:3px 9px;border-radius:5px;font-size:12px">{{ trim($sk) }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="privacy-note"><i class="fas fa-lock" style="margin-right:6px"></i> Your application is private and only visible to the hiring company.</div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function updateFileLabel(input) {
    const label = document.getElementById('fileLabel');
    if (input.files && input.files[0]) {
        label.innerHTML = `<div style="font-size:24px;color:#059669;margin-bottom:8px"><i class="fas fa-check-circle"></i></div><div style="font-size:14px;color:#059669;font-weight:600">${input.files[0].name}</div><div style="font-size:12px;color:#94a3b8;margin-top:4px">Click to change file</div>`;
    }
}
</script>
@endpush
@endsection
