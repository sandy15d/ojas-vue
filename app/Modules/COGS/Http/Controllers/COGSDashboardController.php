<?php

namespace App\Modules\COGS\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class COGSDashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('modules/COGS/Dashboard', [
            'module' => 'cogs',
        ]);
    }
}
