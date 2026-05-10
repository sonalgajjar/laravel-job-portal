@extends('layouts.company-panel')

@section('title', 'Edit Job')
@section('page-title', 'Edit Job')

@section('content')
<div style="max-width:780px">
    <div class="card">
        <div class="card-header">
            <div class="card-title">Edit: {{ $job->title }}</div>
            <a href="{{ route('company.jobs') }}" class="btn btn-outline btn-sm"><i class="fas fa-arrow-left"></i> Back</a>
        </div>

        <form method="POST" action="{{ route('company.jobs.update', $job->id) }}">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Job Title *</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $job->title) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Category *</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (old('category_id', $job->category_id) == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Location *</label>
                    <input type="text" name="location" class="form-control" value="{{ old('location', $job->location) }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Job Type *</label>
                    <select name="job_type" class="form-control" required>
                        @foreach(['Full-Time','Part-Time','Contract','Internship','Remote','Hybrid'] as $t)
                            <option {{ old('job_type', $job->job_type) === $t ? 'selected' : '' }}>{{ $t }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Salary Range</label>
                    <input type="text" name="salary_range" class="form-control" value="{{ old('salary_range', $job->salary_range) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">Experience Required</label>
                    <input type="text" name="experience_required" class="form-control" value="{{ old('experience_required', $job->experience_required) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">Vacancies</label>
                    <input type="number" name="vacancies" class="form-control" value="{{ old('vacancies', $job->vacancies) }}" min="1">
                </div>
                <div class="form-group">
                    <label class="form-label">Application Deadline</label>
                    <input type="date" name="deadline" class="form-control" value="{{ old('deadline', $job->deadline) }}">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Skills Required</label>
                <input type="text" name="skills_required" class="form-control" value="{{ old('skills_required', $job->skills_required) }}">
            </div>

            <div class="form-group">
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="active" {{ old('status', $job->status) === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $job->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="closed" {{ old('status', $job->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="form-group">
                <label class="form-label">Job Description *</label>
                <textarea name="description" class="form-control" rows="5" required>{{ old('description', $job->description) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Requirements</label>
                <textarea name="requirements" class="form-control" rows="4">{{ old('requirements', $job->requirements) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Benefits & Perks</label>
                <textarea name="benefits" class="form-control" rows="3">{{ old('benefits', $job->benefits) }}</textarea>
            </div>

            <div style="display:flex;gap:12px">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Job</button>
                <a href="{{ route('company.jobs') }}" class="btn btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
