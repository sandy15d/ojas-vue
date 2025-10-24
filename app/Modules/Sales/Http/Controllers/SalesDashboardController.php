<?php

namespace App\Modules\Sales\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class SalesDashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('modules/Sales/Dashboard', [
            'module' => 'sales',
        ]);
    }
}
