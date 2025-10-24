<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return redirect('/login');
})->name('home');

Route::get('dashboard', function () {
    $user = auth()->user();
    $defaultModule = $user->getDefaultModule();

    if ($defaultModule) {
        $modules = app('modules');
        $module = $modules->get($defaultModule);

        if ($module) {
            return redirect($module->getDashboardRoute());
        }
    }

    return Inertia::render('Dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
