<?php

use App\Modules\HR\Http\Controllers\HRDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'module.access:hr'])->prefix('hr')->group(function () {
    Route::get('/dashboard', [HRDashboardController::class, 'index'])
        ->name('hr.dashboard');
    // ->middleware('permission:view-hr');
});
