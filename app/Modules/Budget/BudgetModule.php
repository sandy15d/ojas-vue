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
                'url' => '#',
                'icon' => 'LayoutGrid',
                'items' => [
                    [
                        'title' => 'Overview',
                        'url' => '/budget/dashboard',
                        'permission' => 'view-budget',
                    ],
                ],
            ],
            [
                'title' => 'Budget Plans',
                'url' => '#',
                'icon' => 'FileText',
                'items' => [
                    [
                        'title' => 'All Plans',
                        'url' => '/budget/plans',
                        'permission' => 'view-budget',
                    ],
                    [
                        'title' => 'Create Plan',
                        'url' => '/budget/plans/create',
                        'permission' => 'create-budget',
                    ],
                    [
                        'title' => 'Active Plans',
                        'url' => '/budget/plans/active',
                        'permission' => 'view-budget',
                    ],
                ],
            ],
            [
                'title' => 'Expenses',
                'url' => '#',
                'icon' => 'CreditCard',
                'items' => [
                    [
                        'title' => 'All Expenses',
                        'url' => '/budget/expenses',
                        'permission' => 'view-budget',
                    ],
                    [
                        'title' => 'Add Expense',
                        'url' => '/budget/expenses/create',
                        'permission' => 'create-budget',
                    ],
                    [
                        'title' => 'Categories',
                        'url' => '/budget/expenses/categories',
                        'permission' => 'view-budget',
                    ],
                ],
            ],
            [
                'title' => 'Forecasts',
                'url' => '#',
                'icon' => 'TrendingUp',
                'items' => [
                    [
                        'title' => 'Financial Forecast',
                        'url' => '/budget/forecasts',
                        'permission' => 'view-budget',
                    ],
                    [
                        'title' => 'Variance Analysis',
                        'url' => '/budget/variance',
                        'permission' => 'view-budget',
                    ],
                ],
            ],
        ];
    }

    public function getProjects(): array
    {
        return [
            [
                'name' => 'Annual Planning',
                'url' => '/budget/annual-planning',
                'icon' => 'CalendarDays',
            ],
            [
                'name' => 'Cost Optimization',
                'url' => '/budget/optimization',
                'icon' => 'Zap',
            ],
        ];
    }
}
