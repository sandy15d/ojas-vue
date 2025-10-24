<?php

use App\Modules\COGS\Http\Controllers\COGSDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'module.access:cogs'])->prefix('cogs')->group(function () {
    Route::get('/dashboard', [COGSDashboardController::class, 'index'])
        ->name('cogs.dashboard');
    // ->middleware('permission:view-cogs');
});
