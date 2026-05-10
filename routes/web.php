<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [JobController::class, 'home'])->name('home');

Route::prefix('jobs')->group(function () {
    Route::get('/', [JobController::class, 'index'])->name('jobs.index');
    Route::get('/{id}', [JobController::class, 'show'])->name('jobs.show');
});

Route::view('/about', 'about')->name('about');
Route::view('/contact', 'contact')->name('contact');
Route::post('/contact', function () {
    return back()->with('success', 'Message sent successfully!');
})->name('contact.submit');

/*
|--------------------------------------------------------------------------
| USER AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login/user', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('user.login');
})->name('user.login');

Route::post('/login/user', [UserController::class, 'loginUser'])->name('login.user');

Route::get('/register', function () {
    return auth()->check() ? redirect()->route('dashboard') : view('user.register');
})->name('user.register');

Route::post('/register', [UserController::class, 'registerUser'])->name('register.user');

/*
|--------------------------------------------------------------------------
| USER ROUTES (AUTH)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    Route::get('/applications/create/{job}', [ApplicationController::class, 'create'])
        ->name('applications.create');

    Route::post('/applications/store', [ApplicationController::class, 'store'])
        ->name('apply.store');

    Route::get('/my-jobs', [ApplicationController::class, 'myJobs'])->name('my.jobs');
    Route::get('/saved-jobs', [ApplicationController::class, 'savedJobs'])->name('saved.jobs');

    Route::post('/save/{job}', [JobController::class, 'save'])->name('jobs.save');

    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::post('/profile', [UserController::class, 'updateProfile'])->name('profile.update');

    Route::get('/settings', [UserController::class, 'settings'])->name('user.settings');
    Route::post('/settings', [UserController::class, 'updateSettings'])->name('user.settings.update');

    Route::post('/logout', function () {
        Auth::logout();
        return redirect()->route('user.login');
    })->name('logout');
});

/*
|--------------------------------------------------------------------------
| COMPANY AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('company')->group(function () {
    Route::get('/login', [CompanyController::class, 'showLogin'])->name('company.login');
    Route::post('/login', [CompanyController::class, 'login'])->name('company.login.post');

    Route::get('/register', [CompanyController::class, 'showRegister'])->name('company.register');
    Route::post('/register', [CompanyController::class, 'register'])->name('company.register.post');

    Route::post('/logout', [CompanyController::class, 'logout'])->name('company.logout');
});

/*
|--------------------------------------------------------------------------
| COMPANY ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/

Route::middleware(['company'])->prefix('company')->group(function () {

    Route::get('/dashboard', [CompanyController::class, 'dashboard'])->name('company.dashboard');

    // Jobs
    Route::get('/jobs', [CompanyController::class, 'jobs'])->name('company.jobs');
    Route::get('/jobs/create', [CompanyController::class, 'createJob'])->name('company.jobs.create');
    Route::post('/jobs/store', [CompanyController::class, 'storeJob'])->name('company.jobs.store');
    Route::get('/jobs/edit/{id}', [CompanyController::class, 'editJob'])->name('company.jobs.edit');
    Route::post('/jobs/update/{id}', [CompanyController::class, 'updateJob'])->name('company.jobs.update');
    Route::delete('/jobs/delete/{id}', [CompanyController::class, 'deleteJob'])->name('company.jobs.delete');

    // Applications
    Route::get('/applications', [CompanyController::class, 'applications'])->name('company.applications');
    Route::get('/applications/{id}', [CompanyController::class, 'viewApplication'])->name('company.applications.view');
    Route::post('/applications/{id}/status', [CompanyController::class, 'updateApplicationStatus'])->name('company.applications.status');

    // Settings
    Route::get('/settings', [CompanyController::class, 'settings'])->name('company.settings');
    Route::post('/settings', [CompanyController::class, 'updateSettings'])->name('company.settings.update');
});

/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'showLogin'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login'])->name('admin.login.post');
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES (PROTECTED)
|--------------------------------------------------------------------------
*/

Route::middleware(['admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    // Jobs
    Route::prefix('jobs')->group(function () {
        Route::get('/', [JobController::class, 'adminIndex'])->name('admin.jobs.index');
        Route::get('/create', [JobController::class, 'create'])->name('admin.jobs.create');
        Route::post('/store', [JobController::class, 'store'])->name('admin.jobs.store');
        Route::get('/edit/{id}', [JobController::class, 'edit'])->name('admin.jobs.edit');
        Route::post('/update/{id}', [JobController::class, 'update'])->name('admin.jobs.update');
        Route::delete('/delete/{id}', [JobController::class, 'delete'])->name('admin.jobs.delete');
    });

    // Users
    Route::prefix('users')->group(function () {
        Route::get('/', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('admin.users.update');
        Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
        Route::get('/toggle-role/{id}', [AdminController::class, 'toggleRole'])->name('admin.users.toggleRole');
    });

    // Companies
    Route::prefix('companies')->group(function () {
        Route::get('/', [AdminController::class, 'companies'])->name('admin.companies');
        Route::get('/{id}', [AdminController::class, 'showCompany'])->name('admin.companies.show');
        Route::post('/{id}/approve', [AdminController::class, 'approveCompany'])->name('admin.companies.approve');
        Route::post('/{id}/reject', [AdminController::class, 'rejectCompany'])->name('admin.companies.reject');
        Route::delete('/{id}/delete', [AdminController::class, 'deleteCompany'])->name('admin.companies.delete');
    });

    // Applications
    Route::prefix('applications')->group(function () {
        Route::get('/', [ApplicationController::class, 'index'])->name('admin.applications');
        Route::get('/view/{id}', [ApplicationController::class, 'view'])->name('admin.applications.view');
        Route::post('/update-status/{id}', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
    });

    // Activity Logs
    Route::get('/activity-logs', [AdminController::class, 'activityLogs'])->name('admin.activity-logs');

    // Settings
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/settings/update', [AdminController::class, 'updateSettings'])->name('admin.settings.update');
});

// auth.php removed — using fully custom auth for user/company/admin panels
