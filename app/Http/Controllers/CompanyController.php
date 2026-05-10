<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Job;
use App\Models\Application;
use App\Models\Category;
use App\Models\ActivityLog;

class CompanyController extends Controller
{
    // ────────────────────────────────────────────
    // AUTH
    // ────────────────────────────────────────────

    public function showLogin()
    {
        if (session()->has('company_id')) {
            return redirect()->route('company.dashboard');
        }
        return view('company.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $company = Company::where('email', $request->email)->first();

        if (!$company || !Hash::check($request->password, $company->password)) {
            return back()->with('error', 'Invalid email or password.');
        }

        if ($company->status === 'pending') {
            return back()->with('error', 'Your account is pending admin verification. Please wait for approval.');
        }

        if ($company->status === 'rejected') {
            return back()->with('error', 'Your company registration has been rejected. Please contact support.');
        }

        $request->session()->regenerate();
        session(['company_id' => $company->id]);

        ActivityLog::record('company', $company->id, $company->name, 'Login', 'Company logged in.');

        return redirect()->route('company.dashboard');
    }

    public function showRegister()
    {
        if (session()->has('company_id')) {
            return redirect()->route('company.dashboard');
        }
        return view('company.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email',
            'password'     => 'required|min:6|confirmed',
            'phone'        => 'nullable|string|max:20',
            'location'     => 'nullable|string|max:255',
            'industry'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'website'      => 'nullable|url|max:255',
            'company_size' => 'nullable|string|max:50',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $company = Company::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'password'     => Hash::make($request->password),
            'phone'        => $request->phone,
            'location'     => $request->location,
            'industry'     => $request->industry,
            'description'  => $request->description,
            'website'      => $request->website,
            'company_size' => $request->company_size,
            'logo'         => $logoPath,
            'status'       => 'pending',
        ]);

        ActivityLog::record('company', $company->id, $company->name, 'Register', 'Company registered and awaiting admin approval.');

        return redirect()->route('company.login')
            ->with('success', 'Registration submitted! Please wait for admin approval before logging in.');
    }

    public function logout(Request $request)
    {
        $companyId   = session('company_id');
        $companyName = '';
        if ($companyId) {
            $c           = Company::find($companyId);
            $companyName = $c ? $c->name : '';
            if ($c) {
                ActivityLog::record('company', $c->id, $c->name, 'Logout', 'Company logged out.');
            }
        }

        session()->forget('company_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('company.login');
    }

    // ────────────────────────────────────────────
    // DASHBOARD
    // ────────────────────────────────────────────

    public function dashboard()
    {
        $company      = Company::findOrFail(session('company_id'));
        $totalJobs    = Job::where('company_id', $company->id)->count();
        $activeJobs   = Job::where('company_id', $company->id)->where('status', 'active')->count();
        $applications = Application::whereHas('job', fn($q) => $q->where('company_id', $company->id))->count();
        $recentJobs   = Job::where('company_id', $company->id)->latest()->take(5)->get();

        $recentApplications = Application::whereHas('job', fn($q) => $q->where('company_id', $company->id))
            ->with(['user', 'job'])
            ->latest()
            ->take(5)
            ->get();

        return view('company.dashboard', compact(
            'company', 'totalJobs', 'activeJobs', 'applications', 'recentJobs', 'recentApplications'
        ));
    }

    // ────────────────────────────────────────────
    // JOBS
    // ────────────────────────────────────────────

    public function jobs()
    {
        $company = Company::findOrFail(session('company_id'));
        $jobs    = Job::where('company_id', $company->id)->with('category')->latest()->paginate(10);
        return view('company.jobs.index', compact('company', 'jobs'));
    }

    public function createJob()
    {
        $categories = Category::all();
        return view('company.jobs.create', compact('categories'));
    }

    public function storeJob(Request $request)
    {
        $company = Company::findOrFail(session('company_id'));

        $request->validate([
            'title'               => 'required|string|max:255',
            'location'            => 'required|string|max:255',
            'job_type'            => 'required|string',
            'category_id'         => 'required|exists:categories,id',
            'description'         => 'required|string',
            'salary_range'        => 'nullable|string|max:100',
            'requirements'        => 'nullable|string',
            'benefits'            => 'nullable|string',
            'experience_required' => 'nullable|string|max:100',
            'skills_required'     => 'nullable|string|max:255',
            'deadline'            => 'nullable|date',
            'vacancies'           => 'nullable|integer|min:1',
        ]);

        $job = Job::create([
            'company_id'          => $company->id,
            'category_id'         => $request->category_id,
            'title'               => $request->title,
            'company'             => $company->name,
            'location'            => $request->location,
            'job_type'            => $request->job_type,
            'salary_range'        => $request->salary_range,
            'description'         => $request->description,
            'requirements'        => $request->requirements,
            'benefits'            => $request->benefits,
            'experience_required' => $request->experience_required,
            'skills_required'     => $request->skills_required,
            'deadline'            => $request->deadline,
            'vacancies'           => $request->vacancies ?? 1,
            'status'              => 'active',
        ]);

        ActivityLog::record('company', $company->id, $company->name, 'Job Posted', "Posted job: {$job->title}");

        return redirect()->route('company.jobs')->with('success', 'Job posted successfully!');
    }

    public function editJob($id)
    {
        $company    = Company::findOrFail(session('company_id'));
        $job        = Job::where('company_id', $company->id)->findOrFail($id);
        $categories = Category::all();
        return view('company.jobs.edit', compact('company', 'job', 'categories'));
    }

    public function updateJob(Request $request, $id)
    {
        $company = Company::findOrFail(session('company_id'));
        $job     = Job::where('company_id', $company->id)->findOrFail($id);

        $request->validate([
            'title'               => 'required|string|max:255',
            'location'            => 'required|string|max:255',
            'job_type'            => 'required|string',
            'category_id'         => 'required|exists:categories,id',
            'description'         => 'required|string',
            'salary_range'        => 'nullable|string|max:100',
            'requirements'        => 'nullable|string',
            'benefits'            => 'nullable|string',
            'experience_required' => 'nullable|string|max:100',
            'skills_required'     => 'nullable|string|max:255',
            'deadline'            => 'nullable|date',
            'vacancies'           => 'nullable|integer|min:1',
            'status'              => 'required|in:active,inactive,closed',
        ]);

        $job->update($request->only([
            'category_id','title','location','job_type','salary_range','description',
            'requirements','benefits','experience_required','skills_required',
            'deadline','vacancies','status',
        ]));

        ActivityLog::record('company', $company->id, $company->name, 'Job Updated', "Updated job: {$job->title}");

        return redirect()->route('company.jobs')->with('success', 'Job updated successfully!');
    }

    public function deleteJob($id)
    {
        $company = Company::findOrFail(session('company_id'));
        $job     = Job::where('company_id', $company->id)->findOrFail($id);
        $title   = $job->title;
        $job->delete();

        ActivityLog::record('company', $company->id, $company->name, 'Job Deleted', "Deleted job: {$title}");

        return back()->with('success', 'Job deleted successfully!');
    }

    // ────────────────────────────────────────────
    // APPLICATIONS
    // ────────────────────────────────────────────

    public function applications(Request $request)
    {
        $company = Company::findOrFail(session('company_id'));

        $query = Application::whereHas('job', fn($q) => $q->where('company_id', $company->id))
            ->with(['user', 'job']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->job_id) {
            $query->where('job_id', $request->job_id);
        }

        $applications = $query->latest()->paginate(15);
        $jobs         = Job::where('company_id', $company->id)->get();

        return view('company.applications.index', compact('company', 'applications', 'jobs'));
    }

    public function viewApplication($id)
    {
        $company     = Company::findOrFail(session('company_id'));
        $application = Application::whereHas('job', fn($q) => $q->where('company_id', $company->id))
            ->with(['user', 'job'])
            ->findOrFail($id);

        return view('company.applications.view', compact('company', 'application'));
    }

    public function updateApplicationStatus(Request $request, $id)
    {
        $company     = Company::findOrFail(session('company_id'));
        $application = Application::whereHas('job', fn($q) => $q->where('company_id', $company->id))
            ->findOrFail($id);

        $request->validate(['status' => 'required|in:pending,reviewing,shortlisted,rejected,hired']);

        $application->update(['status' => $request->status]);

        ActivityLog::record(
            'company', $company->id, $company->name,
            'Application Status Updated',
            "Set application #{$id} to {$request->status}"
        );

        return back()->with('success', 'Application status updated!');
    }

    // ────────────────────────────────────────────
    // SETTINGS
    // ────────────────────────────────────────────

    public function settings()
    {
        $company = Company::findOrFail(session('company_id'));
        return view('company.settings', compact('company'));
    }

    public function updateSettings(Request $request)
    {
        $company = Company::findOrFail(session('company_id'));

        $request->validate([
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|unique:companies,email,' . $company->id,
            'phone'        => 'nullable|string|max:20',
            'location'     => 'nullable|string|max:255',
            'industry'     => 'nullable|string|max:255',
            'description'  => 'nullable|string',
            'website'      => 'nullable|url|max:255',
            'company_size' => 'nullable|string|max:50',
            'password'     => 'nullable|string|min:6|confirmed',
            'logo'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $logoPath       = $request->file('logo')->store('logos', 'public');
            $company->logo  = $logoPath;
        }

        $company->fill([
            'name'         => $request->name,
            'email'        => $request->email,
            'phone'        => $request->phone,
            'location'     => $request->location,
            'industry'     => $request->industry,
            'description'  => $request->description,
            'website'      => $request->website,
            'company_size' => $request->company_size,
        ]);

        if ($request->filled('password')) {
            $company->password = Hash::make($request->password);
        }

        $company->save();

        ActivityLog::record('company', $company->id, $company->name, 'Settings Updated', 'Company updated their profile settings.');

        return back()->with('success', 'Settings updated successfully!');
    }
}
