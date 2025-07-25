<?php

use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Exports\JobApplicantsExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveController;
use  App\Http\Controllers\EventController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\CircularController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AssetTicketController;
use App\Http\Controllers\LeaveExportController;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\InternalJobPostingController;
use Spatie\Permission\Models\Permission;

Route::get('/setup-super-admin', function () {
    if (User::where('email', 'admin@example.com')->exists()) {
        return '⚠️ Super Admin already exists.';
    }

    $admin = User::create([
        'name' => 'Super Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
        'employee_id' => 1, // must be integer
        'designation' => 'Administrator',
        'doj' => now(),
        'type_emp' => 'General',
        'status' => 'active',
    ]);

    // Create the super-admin role if it doesn't exist
    $role = Role::firstOrCreate(['name' => 'Admin']);
    $permission = Permission::findOrCreate('create');
    $admin->assignRole($role);

    return '✅ Super Admin created successfully.';
});


Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

// Only users with "Admin" role can access these routes
Route::middleware(['auth'])->group(function () {
    Route::get('/users/import', [UserController::class, 'import_csv'])->name('users.import_form');
    Route::post('/users/import', [UserController::class, 'import'])->name('users.import');
});


Auth::routes();

// ✅ Everything below requires login
Route::middleware(['auth', 'check.user.status'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Users
    Route::resource('users', UserController::class);

    // Roles & Permissions
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    Route::post('/roles/permissions/toggle', [RoleController::class, 'togglePermission'])->name('roles.permissions.toggle');

    // Leave Management
    Route::resource('leaves', LeaveController::class)->parameters(['leaves' => 'leave']);
    Route::post('leaves/{leave}/manager-decision', [LeaveController::class, 'managerDecision'])->name('leaves.manager.decision');
    Route::post('leaves/{leave}/hr-decision', [LeaveController::class, 'hrDecision'])->name('leaves.hr.decision');
    Route::get('/leaves/export/excel', [LeaveExportController::class, 'exportExcel'])->name('leaves.export.excel');
    Route::get('/leaves/export/pdf', [LeaveExportController::class, 'exportPDF'])->name('leaves.export.pdf');

    // Holidays
    Route::resource('holidays', HolidayController::class);

    // Asset Ticket Management
    Route::resource('asset-tickets', AssetTicketController::class);

    // Internal Job Posting
    Route::resource('internal-jobs', InternalJobPostingController::class);
    Route::post('/internal-jobs/apply/{job}', [InternalJobPostingController::class, 'apply'])
        ->name('internal-jobs.apply');
    Route::get('/export-applicants', function () {
        return Excel::download(new JobApplicantsExport, 'internal_job_applicants.xlsx');
    })->name('export.applicants');
    Route::get('/export-applicants-pdf', [InternalJobPostingController::class, 'exportApplicantsPdf'])->name('export.applicants.pdf');
    // ✅ Correct route method for file upload
    Route::post('/import-applicants-pdf', [InternalJobPostingController::class, 'uploadFinalStatus'])
        ->name('import.applicants.pdf');



    // Circulars
    Route::resource('/circulars',CircularController::class);

    // Calendar Events
    Route::resource('events', EventController::class);
    Route::get('/events-data', [EventController::class, 'fetchEvents'])->name('events.data');



        // ✅ Add more modules here: assets, attendance, payroll, etc.
});
