<?php

namespace App\Modules\HR\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class HRDashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('modules/HR/Dashboard', [
            'module' => 'hr',
        ]);
    }
}
