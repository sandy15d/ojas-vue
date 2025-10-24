<?php

use App\Modules\Sales\Http\Controllers\SalesDashboardController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'module.access:sales'])->prefix('sales')->group(function () {
    Route::get('/dashboard', [SalesDashboardController::class, 'index'])
        ->name('sales.dashboard');
    // ->middleware('permission:view-sales');
});
