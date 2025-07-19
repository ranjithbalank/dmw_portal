<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\CircularController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AssetTicketController;
use App\Http\Controllers\LeaveExportController;
use Illuminate\Notifications\DatabaseNotification;
use App\Http\Controllers\InternalJobPostingController;
use App\Exports\JobApplicantsExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

// GET: show the import form
Route::get('/users/import', [UserController::class, 'import_csv'])->name('users.import_form');
Route::post('/users/import', [UserController::class, 'import'])->name('users.import');

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


    // Circulars
    Route::resource('/circulars',CircularController::class);

        // ✅ Add more modules here: assets, attendance, payroll, etc.
});
