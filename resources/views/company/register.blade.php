@extends('layouts.public')

@section('title', 'Register Company')

@push('styles')
<style>
.auth-page{padding:60px 20px;display:flex;justify-content:center}
.auth-card{width:100%;max-width:640px;background:rgba(30,41,59,0.7);border:1px solid rgba(16,185,129,0.15);border-radius:20px;padding:40px;backdrop-filter:blur(20px)}
.auth-logo{text-align:center;margin-bottom:28px}
.auth-logo-icon{width:64px;height:64px;background:linear-gradient(135deg,#10b981,#059669);border-radius:18px;display:flex;align-items:center;justify-content:center;font-size:28px;margin:0 auto 14px;box-shadow:0 8px 25px rgba(16,185,129,0.35)}
.auth-logo h1{font-size:24px;font-weight:800;color:#f1f5f9}
.auth-logo p{font-size:14px;color:#64748b;margin-top:4px}
.form-group{margin-bottom:18px}
.form-label{display:block;font-size:13px;font-weight:600;color:#94a3b8;margin-bottom:8px}
.form-control{width:100%;background:rgba(15,23,42,0.8);border:1px solid rgba(16,185,129,0.12);border-radius:10px;padding:12px 16px;color:#f1f5f9;font-size:14px;font-family:'Inter',sans-serif;outline:none;transition:all 0.2s}
.form-control:focus{border-color:rgba(16,185,129,0.4);box-shadow:0 0 0 3px rgba(16,185,129,0.08)}
.form-control::placeholder{color:#475569}
select.form-control option{background:#1e293b}
textarea.form-control{resize:vertical;min-height:80px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.btn-submit{width:100%;background:linear-gradient(135deg,#10b981,#059669);color:#fff;border:none;padding:14px;border-radius:12px;font-size:16px;font-weight:700;cursor:pointer;transition:all 0.2s;margin-top:8px;box-shadow:0 6px 20px rgba(16,185,129,0.3)}
.btn-submit:hover{transform:translateY(-1px);box-shadow:0 10px 28px rgba(16,185,129,0.45)}
.auth-links{text-align:center;margin-top:20px;font-size:14px;color:#64748b}
.auth-links a{color:#34d399;text-decoration:none;font-weight:600}
.section-head{font-size:13px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:0.5px;margin:24px 0 14px;padding-bottom:8px;border-bottom:1px solid rgba(16,185,129,0.1)}
.info-box{background:rgba(16,185,129,0.06);border:1px solid rgba(16,185,129,0.15);border-radius:10px;padding:14px 16px;font-size:13px;color:#64748b;margin-bottom:20px;display:flex;gap:10px;align-items:flex-start}
.alert-error{background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);color:#f87171;padding:12px 16px;border-radius:10px;margin-bottom:18px;font-size:14px}
@media(max-width:600px){.form-row{grid-template-columns:1fr}}
</style>
@endpush

@section('content')
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-logo">
            <div class="auth-logo-icon">🏢</div>
            <h1>Register Your Company</h1>
            <p>Start hiring top talent today</p>
        </div>

        @if($errors->any())
            <div class="alert-error">
                <ul style="margin:0;padding-left:16px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="info-box">
            <i class="fas fa-info-circle" style="color:#34d399;margin-top:1px;flex-shrink:0"></i>
            <span>After registration, your company will be reviewed by our admin team. You'll be able to login once approved — this ensures a trusted hiring environment.</span>
        </div>

        <form method="POST" action="{{ route('company.register.post') }}" enctype="multipart/form-data">
            @csrf

            <div class="section-head">Company Information</div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Company Name *</label>
                    <input type="text" name="name" class="form-control" placeholder="Acme Corp" value="{{ old('name') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Industry</label>
                    <select name="industry" class="form-control">
                        <option value="">Select Industry</option>
                        <option {{ old('industry')=='Technology' ? 'selected' : '' }}>Technology</option>
                        <option {{ old('industry')=='Finance' ? 'selected' : '' }}>Finance</option>
                        <option {{ old('industry')=='Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option {{ old('industry')=='Education' ? 'selected' : '' }}>Education</option>
                        <option {{ old('industry')=='Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                        <option {{ old('industry')=='Retail' ? 'selected' : '' }}>Retail</option>
                        <option {{ old('industry')=='Media' ? 'selected' : '' }}>Media</option>
                        <option {{ old('industry')=='Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Company Size</label>
                    <select name="company_size" class="form-control">
                        <option value="">Select Size</option>
                        <option>1–10</option>
                        <option>11–50</option>
                        <option>51–200</option>
                        <option>201–500</option>
                        <option>500+</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" placeholder="Mumbai, India" value="{{ old('location') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" placeholder="+91 9876543210" value="{{ old('phone') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Website</label>
                    <input type="url" name="website" class="form-control" placeholder="https://yourcompany.com" value="{{ old('website') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Company Description</label>
                <textarea name="description" class="form-control" placeholder="Brief description of your company...">{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Company Logo</label>
                <input type="file" name="logo" class="form-control" accept="image/*" style="padding:8px">
            </div>

            <div class="section-head">Login Credentials</div>
            <div class="form-group">
                <label class="form-label">Company Email *</label>
                <input type="email" name="email" class="form-control" placeholder="hr@yourcompany.com" value="{{ old('email') }}" required>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Password *</label>
                    <input type="password" name="password" class="form-control" placeholder="Min 6 characters" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Confirm Password *</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat password" required>
                </div>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-building"></i> Submit Registration</button>
        </form>

        <div class="auth-links">
            Already registered? <a href="{{ route('company.login') }}">Login here</a>
        </div>
    </div>
</div>
@endsection
