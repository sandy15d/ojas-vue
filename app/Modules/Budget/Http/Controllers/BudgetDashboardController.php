<?php

namespace App\Modules\Budget\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class BudgetDashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('modules/Budget/Dashboard', [
            'module' => 'budget',
        ]);
    }
}
