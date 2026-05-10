@extends('layouts.company-panel')

@section('title', 'Post New Job')
@section('page-title', 'Post New Job')

@section('content')
<div style="max-width:780px">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Job Details</div>
            <a href="{{ route('company.jobs') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>

        <form method="POST" action="{{ route('company.jobs.store') }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Job Title *</label>
                    <input type="text" name="title" class="form-control" placeholder="e.g. Senior React Developer" value="{{ old('title') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control" required>
                        <option value="">Select Category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Location *</label>
                    <input type="text" name="location" class="form-control" placeholder="Mumbai, India or Remote" value="{{ old('location') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Job Type *</label>
                    <select name="job_type" class="form-control" required>
                        <option value="">Select Type</option>
                        <option {{ old('job_type')=='Full-Time' ? 'selected' : '' }}>Full-Time</option>
                        <option {{ old('job_type')=='Part-Time' ? 'selected' : '' }}>Part-Time</option>
                        <option {{ old('job_type')=='Contract' ? 'selected' : '' }}>Contract</option>
                        <option {{ old('job_type')=='Internship' ? 'selected' : '' }}>Internship</option>
                        <option {{ old('job_type')=='Remote' ? 'selected' : '' }}>Remote</option>
                        <option {{ old('job_type')=='Hybrid' ? 'selected' : '' }}>Hybrid</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Salary Range</label>
                    <input type="text" name="salary_range" class="form-control" placeholder="e.g. ₹8L–₹12L or $80k–$100k" value="{{ old('salary_range') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Experience Required</label>
                    <input type="text" name="experience_required" class="form-control" placeholder="e.g. 2–4 years" value="{{ old('experience_required') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Vacancies</label>
                    <input type="number" name="vacancies" class="form-control" placeholder="1" value="{{ old('vacancies', 1) }}" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline') }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Skills Required</label>
                <input type="text" name="skills_required" class="form-control" placeholder="e.g. React, Node.js, TypeScript" value="{{ old('skills_required') }}">
            </div>

            <div class="form-group">
                <label class="form-label">Job Description *</label>
                <textarea name="description" class="form-control" rows="5" placeholder="Describe the role, responsibilities, and day-to-day tasks..." required>{{ old('description') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Requirements</label>
                <textarea name="requirements" class="form-control" rows="4" placeholder="List qualifications, education, or certifications required...">{{ old('requirements') }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Benefits & Perks</label>
                <textarea name="benefits" class="form-control" rows="3" placeholder="Health insurance, flexible hours, WFH, stock options...">{{ old('benefits') }}</textarea>
            </div>

            <div style="display:flex;gap:12px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Post Job</button>
                <a href="{{ route('company.jobs') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
