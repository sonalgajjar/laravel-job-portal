@extends('layouts.company-panel')

@section('title', 'Company Settings')
@section('page-title', 'Company Settings')

@section('content')
<div style="max-width:760px">

    <!-- Company Logo & Profile -->
    <div class="card" style="margin-bottom:20px">
        <div class="card-header">
            <div class="card-title">Company Profile & Logo</div>
        </div>
        <form method="POST" action="{{ route('company.settings.update') }}" enctype="multipart/form-data">
            @csrf

            <!-- Logo preview -->
            <div style="display:flex;align-items:center;gap:20px;margin-bottom:24px;padding:20px;background:rgba(16,185,129,0.05);border:1px solid rgba(16,185,129,0.1);border-radius:12px">
                <div style="width:80px;height:80px;border-radius:16px;background:linear-gradient(135deg,#10b981,#059669);display:flex;align-items:center;justify-content:center;font-size:36px;overflow:hidden;flex-shrink:0">
                    @if($company->logo)
                        <img src="{{ asset('storage/'.$company->logo) }}" style="width:100%;height:100%;object-fit:cover;border-radius:16px" alt="">
                    @else
                        🏢
                    @endif
                </div>
                <div style="flex:1">
                    <div style="font-size:14px;font-weight:600;color:#000;margin-bottom:6px">Company Logo</div>
                    <input type="file" name="logo" class="form-control" accept="image/*" style="padding:8px">
                    <div style="font-size:12px;color:#475569;margin-top:6px">PNG, JPG up to 2MB. Will be displayed on your job listings.</div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Company Name *</label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $company->name) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Industry</label>
                    <select name="industry" class="form-control">
                        <option value="">Select Industry</option>
                        @foreach(['Technology','Finance','Healthcare','Education','Manufacturing','Retail','Media','Other'] as $ind)
                            <option {{ old('industry', $company->industry) === $ind ? 'selected' : '' }}>{{ $ind }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Company Email *</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email', $company->email) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone', $company->phone) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Location</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $company->location) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Company Size</label>
                    <select name="company_size" class="form-control">
                        <option value="">Select Size</option>
                        @foreach(['1–10','11–50','51–200','201–500','500+'] as $sz)
                            <option {{ old('company_size', $company->company_size) === $sz ? 'selected' : '' }}>{{ $sz }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Website</label>
                <input type="url" name="website" class="form-control" placeholder="https://yourcompany.com" value="{{ old('website', $company->website) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Company Description</label>
                <textarea name="description" class="form-control" rows="4">{{ old('description', $company->description) }}</textarea>
            </div>

            <div style="border-top:1px solid rgba(16,185,129,0.1);padding-top:20px;margin-top:4px">
                <div style="font-size:14px;font-weight:700;color:#94a3b8;margin-bottom:16px">Change Password <span style="font-weight:400;font-size:13px">(leave blank to keep current)</span></div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Min 6 characters">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Repeat new password">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Save Settings</button>
        </form>
    </div>

    <!-- Account Status -->
    <div class="card">
        <div class="card-title" style="margin-bottom:16px">Account Information</div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px">
            <div style="padding:16px;background:rgba(16,185,129,0.05);border-radius:12px;border:1px solid rgba(16,185,129,0.1)">
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Account Status</div>
                <span class="badge badge-green" style="font-size:14px;padding:6px 14px">✓ Approved & Active</span>
            </div>
            <div style="padding:16px;background:rgba(16,185,129,0.05);border-radius:12px;border:1px solid rgba(16,185,129,0.1)">
                <div style="font-size:12px;color:#64748b;margin-bottom:4px">Member Since</div>
                <div style="font-size:15px;font-weight:600;color:#f1f5f9">{{ $company->created_at->format('M d, Y') }}</div>
            </div>
        </div>
    </div>

</div>
@endsection
