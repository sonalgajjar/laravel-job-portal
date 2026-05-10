<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Application;  // Make sure ye model import ho
use App\Models\User;
use App\Models\Job;


class ApplicationController extends Controller
{
   public function create($jobId)
{
    $job = \App\Models\Job::findOrFail($jobId);
    return view('applications.apply', compact('job'));
}
   public function apply($jobId)
{
    $job = Job::findOrFail($jobId);

    // 👇 YE ADD KARO
    $alreadyApplied = Application::where('user_id', auth()->id())
        ->where('job_id', $job->id)
        ->exists();

    return view('applications.apply', compact('job','alreadyApplied'));
}
//public function store(Request $request)
/*{
    $request->validate([
        'job_id' => 'required|exists:jobs,id',
        'resume' => 'required|mimes:pdf,doc,docx|max:2048',
        'cover_letter' => 'nullable'
    ]);

    $jobId = $request->job_id;

    // Duplicate check
    if (Application::where('user_id', auth()->id())
        ->where('job_id', $jobId)
        ->exists()) {

        return back()->with('error', 'Already Applied!');
    }

    // Upload
    $path = null;
    if ($request->hasFile('resume')) {
        $path = $request->file('resume')->store('resumes', 'public');
    }

    // Save
    Application::create([
        'user_id' => auth()->id(),
        'job_id' => $jobId,
        'resume' => $path,
        'cover_letter' => $request->cover_letter,
        'status' => 'pending'
    ]);

    return back()->with('success', 'Applied Successfully!');
}*/
public function store(Request $request)
{
    $request->validate([
        'job_id' => 'required|exists:jobs,id',
        'resume' => 'required|mimes:pdf,doc,docx|max:2048',
        'cover_letter' => 'nullable'
    ]);

    $jobId = $request->job_id;

    if (Application::where('user_id', auth()->id())
        ->where('job_id', $jobId)
        ->exists()) {

        return back()->with('error', 'Already Applied!');
    }

    $path = null;
    if ($request->hasFile('resume')) {
        $path = $request->file('resume')->store('resumes', 'public');
    }

    Application::create([
        'user_id' => auth()->id(),
        'job_id' => $jobId,
        'resume' => $path,
        'cover_letter' => $request->cover_letter,
        'status' => 'pending'
    ]);

    return back()->with('success', 'Applied Successfully!');
}
    // -------------------------------
    // ADMIN-SIDE METHODS
    // -------------------------------

    // List all applications
    public function index(Request $request)
    {
        $query = Application::with(['user', 'job']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            })->orWhereHas('job', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%');
            });
        }

        $applications = $query->latest()->get();

        return view('admin.applications.index', compact('applications'));
    }
    // View single application (optional)
    public function view($id)
    {
        $application = Application::with('user', 'job')->findOrFail($id);
        return view('admin.applications.view', compact('application'));
    }

    // Delete an application (optional)
    public function delete($id)
    {
        $application = Application::findOrFail($id);
        $application->delete();

        return redirect()->route('admin.applications.index')->with('success', 'Application deleted successfully.');
    }
    public function approve($id)
{
    $app = Application::findOrFail($id);
    $app->status = 'approved';
    $app->save();

    return back()->with('success', 'Application Approved');
}

public function reject($id)
{
    $app = Application::findOrFail($id);
    $app->status = 'rejected';
    $app->save();

    return back()->with('success', 'Application Rejected');
}
public function updateStatus(Request $request, $id)
{
    $app = Application::findOrFail($id);

    $app->status = $request->status;
    $app->save();

    return back()->with('success', 'Status Updated Successfully');
}
public function myJobs()
{
    $applications = Application::with('job')
        ->where('user_id', auth()->id())
        ->latest()
        ->get();

    return view('user.my-jobs', compact('applications'));
}

public function savedJobs()
{
    $jobs = Job::whereHas('savedByUsers', function($q){
        $q->where('user_id', auth()->id());
    })->get();

    return view('user.saved-jobs', compact('jobs'));
}

}