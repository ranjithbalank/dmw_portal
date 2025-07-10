<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\AssetTicketController;

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
Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // Users
    Route::resource("users", UserController::class);

    // Roles & Permissions
    Route::resource("roles", RoleController::class);
    Route::resource("permissions", PermissionController::class);
    Route::post('/roles/permissions/toggle', [RoleController::class, 'togglePermission'])->name('roles.permissions.toggle');

    // // Leave Management
    // Route::resource('leaves', LeaveController::class)->parameters([
    //     'leaves' => 'leave'
    // ]);
    // Route::post('leaves/{id}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    // Route::post('leaves/{id}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');

    // Leave Management
    Route::resource('leaves', LeaveController::class)->parameters([
        'leaves' => 'leave'
    ]);

    // Manager approval routes
    Route::post('leaves/{leave}/manager-decision', [LeaveController::class, 'managerDecision'])->name('leaves.manager.decision');
    Route::post('leaves/{leave}/hr-decision', [LeaveController::class, 'hrDecision'])->name('leaves.hr.decision');

    // Holidays
    Route::resource('holidays', HolidayController::class);

    //Asset Ticket Management
    Route::resource('asset-tickets', AssetTicketController::class);

    // ✅ Add more modules here: assets, attendance, payroll, etc.


});
