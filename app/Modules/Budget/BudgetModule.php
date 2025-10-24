<?php

namespace App\Modules\Budget;

use App\Support\Module;

class BudgetModule extends Module
{
    public function getName(): string
    {
        return 'Budget';
    }

    public function getIdentifier(): string
    {
        return 'budget';
    }

    public function getIcon(): string
    {
        return 'DollarSign';
    }

    public function getPermissions(): array
    {
        return [
            'view-budget',
            'manage-budget',
            'create-budget',
            'edit-budget',
            'delete-budget',
        ];
    }

    public function getRoutes(): string
    {
        return __DIR__.'/routes.php';
    }

    public function getDashboardRoute(): string
    {
        return '/budget/dashboard';
    }

    public function getMenuItems(): array
    {
        return [
            [
                'title' => 'Dashboard',
                'url' => '/budget/dashboard',
                'permission' => 'view-budget',
            ],
            [
                'title' => 'Budget Plans',
                'url' => '/budget/plans',
                'permission' => 'view-budget',
            ],
            [
                'title' => 'Expenses',
                'url' => '/budget/expenses',
                'permission' => 'view-budget',
            ],
            [
                'title' => 'Forecasts',
                'url' => '/budget/forecasts',
                'permission' => 'view-budget',
            ],
        ];
    }
}
