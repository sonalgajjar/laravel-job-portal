<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\SavedJob;
use App\Models\Category;
use App\Models\Application;


class JobController extends Controller
{
    // 🔹 HOME
    public function home()
    {
        $jobs = Job::with(['category', 'companyModel'])
            ->where('status', 'active')
            ->latest()
            ->take(9)
            ->get();

        return view('home', compact('jobs'));
    }
    // 🔹 JOB LIST (USER SIDE)
    public function index(Request $request)
    {
        $query = Job::with(['category', 'companyModel'])->whereIn('status', ['active', 'Active', 'Approved', 'approved']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('company', 'like', '%' . $request->search . '%')
                  ->orWhere('skills_required', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->location) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }

        if ($request->type) {
            $query->where('job_type', $request->type);
        }

        $jobs = $query->latest()->paginate(12)->withQueryString();

        return view('jobs.index', compact('jobs'));
    }

    // 🔹 JOB DETAILS
   public function show($id)
{
    $job = Job::findOrFail($id);

    // ✅ Check if already applied
    $alreadyApplied = false;

    if (auth()->check()) {
        $alreadyApplied = \App\Models\Application::where('user_id', auth()->id())
            ->where('job_id', $job->id)
            ->exists();
    }

    return view('jobs.show', compact('job', 'alreadyApplied'));
}
    // 🔹 SAVE JOB
    public function save($id)
{
    $job = Job::findOrFail($id);
    $user = auth()->user();

    if ($user->savedJobs()->where('job_id', $id)->exists()) {
        $user->savedJobs()->detach($id);

        return response()->json([
            'status' => 'removed'
        ]);
    } else {
        $user->savedJobs()->attach($id);

        return response()->json([
            'status' => 'saved'
        ]);
    }
}
    /*
    |--------------------------------------------------------------------------
    | 🔥 ADMIN JOB CRUD
    |--------------------------------------------------------------------------
    */

    // 🔹 Admin Job List
    
     public function adminIndex(Request $request)
   {
    $categories = Category::all();

    $jobs = Job::with(['category', 'companyModel']);

    // 🔍 Search
    if ($request->search) {
        $jobs->where(function ($q) use ($request) {
            $q->where('title', 'like', '%' . $request->search . '%')
              ->orWhere('company', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->category) {
        $jobs->where('category_id', $request->category);
    }

    if ($request->status) {
        $jobs->where('status', $request->status);
    }

    $jobs = $jobs->latest()->get();

    return view('admin.jobs.index', compact('jobs', 'categories'));
}

    // 🔹 Create Page (✅ UPDATED ONLY THIS)
   public function create()
{
    $categories = Category::all(); // DB se categories lao
    return view('admin.jobs.create', compact('categories'));
}

    public function store(Request $req)
    {
        $req->validate([
            'title'    => 'required|string|max:255',
            'company'  => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
        ]);

        Job::create([
            'title'               => $req->title,
            'company'             => $req->company,
            'location'            => $req->location,
            'salary_range'        => $req->salary_range,
            'job_type'            => $req->job_type,
            'description'         => $req->description,
            'requirements'        => $req->requirements,
            'benefits'            => $req->benefits,
            'skills_required'     => $req->skills_required,
            'experience_required' => $req->experience_required,
            'vacancies'           => $req->vacancies,
            'deadline'            => $req->deadline ?: null,
            'category_id'         => $req->category_id,
            'status'              => $req->status ?? 'active',
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Job posted successfully!');
    }

    // 🔹 Edit Page
   public function edit($id)
{
    $job = Job::findOrFail($id);
    $categories = Category::all(); // agar category dropdown hai

    return view('admin.jobs.edit', compact('job', 'categories'));
}
    public function update(Request $req, $id)
    {
        $req->validate([
            'title'    => 'required|string|max:255',
            'company'  => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'job_type' => 'required|string',
        ]);

        $job = Job::findOrFail($id);

        $job->update([
            'title'               => $req->title,
            'company'             => $req->company,
            'location'            => $req->location,
            'salary_range'        => $req->salary_range,
            'job_type'            => $req->job_type,
            'description'         => $req->description,
            'requirements'        => $req->requirements,
            'benefits'            => $req->benefits,
            'skills_required'     => $req->skills_required,
            'experience_required' => $req->experience_required,
            'vacancies'           => $req->vacancies,
            'deadline'            => $req->deadline ?: null,
            'category_id'         => $req->category_id,
            'status'              => $req->status ?? 'active',
        ]);

        return redirect()->route('admin.jobs.index')->with('success', 'Job updated successfully!');
    }

    // 🔹 Delete Job
    public function delete($id)
    {
        Job::findOrFail($id)->delete();
        return back()->with('success', 'Job Deleted Successfully');
    }
    public function dashboard()
{
    $jobs = Job::latest()->get();

    $appliedCount = Application::where('user_id', auth()->id())->count();

    $savedCount = auth()->user()->savedJobs()->count();

    return view('user.dashboard', compact('jobs','appliedCount','savedCount'));
}
}