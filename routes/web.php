<?php
//  namespaces - live
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\UserController;
use Spatie\Permission\Models\Permission;
use App\Http\Controllers\EventController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\CircularController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AssetTicketController;
use App\Http\Controllers\LeaveExportController;
use App\Http\Controllers\InternalJobPostingController;

// commented NAMESPACES
// use App\Exports\JobApplicantsExport;
// use Maatwebsite\Excel\Facades\Excel;
// use Illuminate\Support\Facades\Request;
// use Illuminate\Notifications\DatabaseNotification;


// -------------------------------------------------------------------------------------------------------------------------------------------------------------------
Route::get('/setup-super-admin', function () {
    // Avoid duplicate user
    if (User::where('email', 'admin@example.com')->exists()) {
        return '⚠️ Super Admin already exists.';
    }

    // 1️⃣ Create Super Admin User
    $admin = User::create([
        'name' => 'Super Admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
        'employee_id' => 1,
        'designation' => 'Administrator',
        'doj' => now(),
        'type_emp' => 'General',
        'status' => 'active',
    ]);

    // 2️⃣ Create All Roles (only store)
    $roles = ['Admin', 'HR', 'Manager', 'Technician', 'Employee'];
    foreach ($roles as $roleName) {
        Role::firstOrCreate(['name' => $roleName]);
    }

    // 3️⃣ Create a permission (optional)
    Permission::firstOrCreate(['name' => 'create']);

    // 4️⃣ Assign only the 'Admin' role to Super Admin
    $admin->assignRole('Admin');

    return '✅ Super Admin created and all roles stored.';
});
// ----------------------------------------------------------------------------------------------------------------------------------------------------------------------------
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
    // Departments
    Route::resource('departments', DepartmentController::class);
    // Units
    Route::resource('unit', UnitController::class);
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
    Route::get('/export-applicants', [InternalJobPostingController::class, 'exportApplicants'])->name('export.applicants');
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
