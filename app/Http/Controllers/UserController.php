<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\SavedJob;
use App\Models\Job;
use App\Models\Application;
use App\Models\ActivityLog;

class UserController extends Controller
{
    // ────────────────────────────────────────────
    // DASHBOARD
    // ────────────────────────────────────────────

    public function dashboard()
    {
        $jobs         = Job::where('status', 'active')->latest()->take(8)->get();
        $appliedCount = auth()->user()->applications()->count();
        $savedCount   = SavedJob::where('user_id', auth()->id())->count();

        return view('user.dashboard', compact('jobs', 'appliedCount', 'savedCount'));
    }

    // ────────────────────────────────────────────
    // PROFILE
    // ────────────────────────────────────────────

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'           => 'required|string|max:255',
            'email'          => 'required|email|unique:users,email,' . $user->id,
            'phone'          => 'nullable|string|max:20',
            'bio'            => 'nullable|string|max:1000',
            'address'        => 'nullable|string|max:255',
            'skills'         => 'nullable|string|max:500',
            'experience_info'=> 'nullable|string',
            'education_info' => 'nullable|string',
            'profile_image'  => 'nullable|image|max:2048',
            'resume'         => 'nullable|mimes:pdf,doc,docx|max:5120',
        ]);

        if ($request->hasFile('profile_image')) {
            $path               = $request->file('profile_image')->store('profiles', 'public');
            $user->profile_image = $path;
        }

        if ($request->hasFile('resume')) {
            $path        = $request->file('resume')->store('resumes', 'public');
            $user->resume = $path;
        }

        $user->fill([
            'name'            => $request->name,
            'email'           => $request->email,
            'phone'           => $request->phone,
            'bio'             => $request->bio,
            'address'         => $request->address,
            'skills'          => $request->skills,
            'experience_info' => $request->experience_info,
            'education_info'  => $request->education_info,
            'resume_text'     => $request->resume_text,
        ]);

        $user->save();

        ActivityLog::record('user', $user->id, $user->name, 'Profile Updated', 'User updated their profile.');

        return back()->with('success', 'Profile updated successfully!');
    }

    // ────────────────────────────────────────────
    // SETTINGS (change password)
    // ────────────────────────────────────────────

    public function settings()
    {
        $user = Auth::user();
        return view('user.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => 'required',
            'password'         => 'required|min:6|confirmed',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        ActivityLog::record('user', $user->id, $user->name, 'Password Changed', 'User changed their password.');

        return back()->with('success', 'Password changed successfully!');
    }

    // ────────────────────────────────────────────
    // AUTH
    // ────────────────────────────────────────────

    public function loginUser(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {
            $request->session()->regenerate();
            ActivityLog::record('user', Auth::id(), Auth::user()->name, 'Login', 'User logged in.');
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
    }

    public function registerUser(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);
        ActivityLog::record('user', $user->id, $user->name, 'Register', 'New user registered.');

        return redirect('/dashboard');
    }

    // ────────────────────────────────────────────
    // ADMIN: User management
    // ────────────────────────────────────────────

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role'  => in_array($request->role, ['admin', 'user']) ? $request->role : 'user',
        ]);

        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }

    public function delete($id)
    {
        Application::where('user_id', $id)->delete();
        SavedJob::where('user_id', $id)->delete();
        User::findOrFail($id)->delete();

        return back()->with('success', 'User deleted successfully');
    }
}
