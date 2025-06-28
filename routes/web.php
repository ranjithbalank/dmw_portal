<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

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

    // Leave Management
    Route::resource('leaves', LeaveController::class)->parameters([
        'leaves' => 'leave'
    ]);
    Route::post('leaves/{id}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{id}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');

    // Holidays
    Route::resource('holidays', HolidayController::class);

    // ✅ Add more modules here: assets, attendance, payroll, etc.
});
