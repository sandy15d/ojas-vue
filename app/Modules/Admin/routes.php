<?php

use App\Modules\Admin\Http\Controllers\AdminDashboardController;
use App\Modules\Admin\Http\Controllers\AdminUserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'module.access:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('admin.dashboard');
    // ->middleware('permission:view-admin');

    // User Management Routes
    Route::resource('users', AdminUserController::class)
        ->except(['create', 'show'])
        ->names([
            'index' => 'admin.users.index',
            'store' => 'admin.users.store',
            'edit' => 'admin.users.edit',
            'update' => 'admin.users.update',
            'destroy' => 'admin.users.destroy',
        ]);

    // User Password Routes
    Route::get('/users/{user}/password', [AdminUserController::class, 'editPassword'])
        ->name('admin.users.password.edit');
    Route::put('/users/{user}/password', [AdminUserController::class, 'updatePassword'])
        ->name('admin.users.password.update');

    // User Permissions Routes
    Route::get('/users/{user}/permissions', [AdminUserController::class, 'editPermissions'])
        ->name('admin.users.permissions.edit');
    Route::put('/users/{user}/permissions', [AdminUserController::class, 'updatePermissions'])
        ->name('admin.users.permissions.update');

    // User Export
    Route::get('/users-export', [AdminUserController::class, 'export'])
        ->name('admin.users.export');
});
