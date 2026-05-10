@extends('layouts.user-panel')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')
<div style="max-width:800px">

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf

        <!-- Profile Photo -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header">
                <div class="card-title">Profile Photo</div>
            </div>
            <div style="display:flex;align-items:center;gap:20px;flex-wrap:wrap">
                <div style="width:90px;height:90px;border-radius:20px;background:linear-gradient(135deg,#6366f1,#8b5cf6);display:flex;align-items:center;justify-content:center;font-size:36px;font-weight:700;color:#fff;flex-shrink:0;overflow:hidden">
                    @if($user->profile_image)
                        <img src="{{ asset('storage/'.$user->profile_image) }}" style="width:100%;height:100%;object-fit:cover" alt="" id="photo-preview">
                    @else
                        <span id="photo-initial">{{ strtoupper(substr($user->name,0,1)) }}</span>
                        <img id="photo-preview" src="" style="display:none;width:100%;height:100%;object-fit:cover" alt="">
                    @endif
                </div>
                <div style="flex:1">
                    <div style="font-size:14px;font-weight:600;color:#000;margin-bottom:6px">Upload Profile Photo</div>
                    <input type="file" name="profile_image" class="form-control" accept="image/*" style="padding:8px" onchange="previewPhoto(this)">
                    <div style="font-size:12px;color:#475569;margin-top:6px">PNG, JPG up to 2MB. Displayed on your profile and applications.</div>
                </div>
            </div>
        </div>

        <!-- Basic Info -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header">
                <div class="card-title">Basic Information</div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="+91 9876543210" value="{{ old('phone', $user->phone) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Address / Location</label>
                    <input type="text" name="address" class="form-control" placeholder="Mumbai, India" value="{{ old('address', $user->address) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Bio / Summary</label>
                <textarea name="bio" class="form-control" rows="3" placeholder="Brief professional summary about yourself...">{{ old('bio', $user->bio) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Skills <span style="font-size:12px;color:#475569">(comma-separated)</span></label>
                <input type="text" name="skills" class="form-control" placeholder="PHP, Laravel, React, MySQL, Git..." value="{{ old('skills', $user->skills) }}">
            </div>
        </div>

        <!-- Experience & Education -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header">
                <div class="card-title">Experience & Education</div>
            </div>

            <div class="form-group">
                <label class="form-label">Work Experience</label>
                <textarea name="experience_info" class="form-control" rows="5" placeholder="Describe your work experience, roles, and achievements...">{{ old('experience_info', $user->experience_info) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Education</label>
                <textarea name="education_info" class="form-control" rows="4" placeholder="Your educational background, degrees, certifications...">{{ old('education_info', $user->education_info) }}</textarea>
            </div>
        </div>

        <!-- Resume -->
        <div class="card" style="margin-bottom:20px">
            <div class="card-header">
                <div class="card-title">Resume</div>
            </div>

            <!-- Upload file -->
            <div style="margin-bottom:20px;padding:16px;background:rgba(99,102,241,0.05);border:1px solid rgba(99,102,241,0.12);border-radius:12px">
                <div style="font-size:14px;font-weight:600;color:#f1f5f9;margin-bottom:8px">
                    <i class="fas fa-upload" style="color:#818cf8;margin-right:8px"></i>Upload Resume File
                </div>
                @if($user->resume)
                <div style="margin-bottom:10px;display:flex;align-items:center;gap:10px">
                    <i class="fas fa-file-pdf" style="color:#f87171;font-size:20px"></i>
                    <a href="{{ asset('storage/'.$user->resume) }}" target="_blank" style="color:#818cf8;text-decoration:none;font-size:14px">View current resume</a>
                </div>
                @endif
                <input type="file" name="resume" class="form-control" accept=".pdf,.doc,.docx" style="padding:8px">
                <div style="font-size:12px;color:#475569;margin-top:6px">PDF, DOC, DOCX up to 5MB</div>
            </div>

            <!-- Manual resume -->
            <div>
                <div style="font-size:14px;font-weight:600;color:#f1f5f9;margin-bottom:8px">
                    <i class="fas fa-keyboard" style="color:#818cf8;margin-right:8px"></i>Or Fill Resume Manually
                </div>
                <textarea name="resume_text" class="form-control" rows="8" placeholder="Paste or type your resume content here. Include your work history, skills, education, and achievements...">{{ old('resume_text', $user->resume_text) }}</textarea>
                <div style="font-size:12px;color:#475569;margin-top:6px">This will be shown to employers when no file is uploaded</div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Profile</button>
    </form>
</div>

@push('scripts')
<script>
function previewPhoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById('photo-preview');
            const initial = document.getElementById('photo-initial');
            if (preview) { preview.src = e.target.result; preview.style.display = 'block'; }
            if (initial) initial.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush

@endsection
