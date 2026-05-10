<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Job;
use App\Models\User;
use App\Models\Company;
use App\Models\Application;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    // ────────────────────────────────────────────
    // AUTH
    // ────────────────────────────────────────────

    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $req)
    {
        $req->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $admin = Admin::where('email', $req->email)->first();

        if (!$admin || !Hash::check($req->password, $admin->password)) {
            return back()->with('error', 'Invalid Email or Password');
        }

        $req->session()->regenerate();
        session(['admin_id' => $admin->id]);

        ActivityLog::record('admin', $admin->id, $admin->name, 'Login', 'Admin logged in.');

        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $request)
    {
        $adminId = session('admin_id');
        if ($adminId) {
            $admin = Admin::find($adminId);
            if ($admin) {
                ActivityLog::record('admin', $admin->id, $admin->name, 'Logout', 'Admin logged out.');
            }
        }

        session()->forget('admin_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    // ────────────────────────────────────────────
    // DASHBOARD
    // ────────────────────────────────────────────

    public function dashboard()
    {
        $totalJobs      = Job::count();
        $totalUsers     = User::count();
        $totalCompanies = Company::count();
        $pendingCompanies = Company::where('status', 'pending')->count();
        $applications   = Application::count();
        $activeJobs     = Job::where('status', 'active')->count();
        $recentJobs     = Job::latest()->take(5)->get();
        $recentLogs     = ActivityLog::latest()->take(10)->get();
        $recentCompanies = Company::where('status', 'pending')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalJobs', 'totalUsers', 'totalCompanies', 'pendingCompanies',
            'applications', 'activeJobs', 'recentJobs', 'recentLogs', 'recentCompanies'
        ));
    }

    // ────────────────────────────────────────────
    // SETTINGS
    // ────────────────────────────────────────────

    public function settings()
    {
        $admin = Admin::findOrFail(session('admin_id'));
        return view('admin.settings', compact('admin'));
    }

    public function updateSettings(Request $request)
    {
        $admin = Admin::findOrFail(session('admin_id'));

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:admins,email,' . $admin->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $admin->update([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
        ]);

        ActivityLog::record('admin', $admin->id, $admin->name, 'Settings Updated', 'Admin updated their settings.');

        return back()->with('success', 'Settings updated successfully!');
    }

    // ────────────────────────────────────────────
    // USERS
    // ────────────────────────────────────────────

    public function users(Request $request)
    {
        $query = User::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->role) {
            $query->where('role', $request->role);
        }

        $users = $query->latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function toggleRole($id)
    {
        $user       = User::findOrFail($id);
        $user->role = ($user->role == 'admin') ? 'user' : 'admin';
        $user->save();

        return back()->with('success', 'User role updated successfully!');
    }

    // ────────────────────────────────────────────
    // COMPANIES
    // ────────────────────────────────────────────

    public function companies(Request $request)
    {
        $query = Company::query();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $companies = $query->latest()->paginate(10);

        return view('admin.companies.index', compact('companies'));
    }

    public function showCompany($id)
    {
        $company = Company::with('jobs')->findOrFail($id);
        return view('admin.companies.show', compact('company'));
    }

    public function approveCompany($id)
    {
        $company         = Company::findOrFail($id);
        $company->status = 'approved';
        $company->save();

        $admin = Admin::findOrFail(session('admin_id'));
        ActivityLog::record('admin', $admin->id, $admin->name, 'Company Approved', "Approved company: {$company->name}");
        ActivityLog::record('company', $company->id, $company->name, 'Account Approved', 'Account was approved by admin.');

        return back()->with('success', "{$company->name} has been approved!");
    }

    public function rejectCompany($id)
    {
        $company         = Company::findOrFail($id);
        $company->status = 'rejected';
        $company->save();

        $admin = Admin::findOrFail(session('admin_id'));
        ActivityLog::record('admin', $admin->id, $admin->name, 'Company Rejected', "Rejected company: {$company->name}");

        return back()->with('success', "{$company->name} has been rejected.");
    }

    public function deleteCompany($id)
    {
        $company = Company::findOrFail($id);
        $name    = $company->name;
        Job::where('company_id', $id)->delete();
        $company->delete();

        $admin = Admin::findOrFail(session('admin_id'));
        ActivityLog::record('admin', $admin->id, $admin->name, 'Company Deleted', "Deleted company: {$name}");

        return back()->with('success', "Company {$name} deleted.");
    }

    // ────────────────────────────────────────────
    // ACTIVITY LOGS
    // ────────────────────────────────────────────

    public function activityLogs(Request $request)
    {
        $query = ActivityLog::query();

        if ($request->actor_type) {
            $query->where('actor_type', $request->actor_type);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('actor_name', 'like', '%' . $request->search . '%')
                  ->orWhere('action', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $logs = $query->latest()->paginate(20);

        return view('admin.activity-logs', compact('logs'));
    }
}
