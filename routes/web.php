<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PermissionController;

Route::get('/', function () {
    return Auth::check()
        ? redirect()->route('home')
        : redirect()->route('login');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// User Controller
Route::resource("users", UserController::class)->middleware('auth');
Route::resource("roles", RoleController::class);
Route::resource("permissions", PermissionController::class);
Route::post('/roles/permissions/toggle', [RoleController::class, 'togglePermission'])->name('roles.permissions.toggle');


Route::middleware(['auth'])->group(function () {
    Route::resource('leaves', LeaveController::class)->parameters([
        'leaves' => 'leave' // 👈 force route model binding to use {leave}
    ]);

    Route::post('leaves/{id}/approve', [LeaveController::class, 'approve'])->name('leaves.approve');
    Route::post('leaves/{id}/reject', [LeaveController::class, 'reject'])->name('leaves.reject');
});
