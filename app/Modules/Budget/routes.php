<?php

use App\Modules\Budget\Http\Controllers\BudgetDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'module.access:budget'])->prefix('budget')->group(function () {
    Route::get('/dashboard', [BudgetDashboardController::class, 'index'])
        ->name('budget.dashboard');
    // ->middleware('permission:view-budget');
});
