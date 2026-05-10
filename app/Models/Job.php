<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $fillable = [
        'company_id', 'category_id', 'title', 'company', 'location',
        'salary_range', 'job_type', 'description', 'requirements',
        'benefits', 'experience_required', 'skills_required',
        'deadline', 'vacancies', 'status',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function companyModel()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function savedByUsers()
    {
        return $this->belongsToMany(User::class, 'saved_jobs');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function getSalaryAttribute()
    {
        return $this->salary_range;
    }
}
