<?php

namespace App\Modules\Sales;

use App\Support\Module;

class SalesModule extends Module
{
    public function getName(): string
    {
        return 'Sales';
    }

    public function getIdentifier(): string
    {
        return 'sales';
    }

    public function getIcon(): string
    {
        return 'ShoppingCart';
    }

    public function getPermissions(): array
    {
        return [
            'view-sales',
            'manage-sales',
            'create-sales',
            'edit-sales',
            'delete-sales',
        ];
    }

    public function getRoutes(): string
    {
        return __DIR__.'/routes.php';
    }

    public function getDashboardRoute(): string
    {
        return '/sales/dashboard';
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
                        'url' => '/sales/dashboard',
                        'permission' => 'view-sales',
                    ],
                ],
            ],
            [
                'title' => 'Orders',
                'url' => '#',
                'icon' => 'ShoppingCart',
                'items' => [
                    [
                        'title' => 'All Orders',
                        'url' => '/sales/orders',
                        'permission' => 'view-sales',
                    ],
                    [
                        'title' => 'Create Order',
                        'url' => '/sales/orders/create',
                        'permission' => 'create-sales',
                    ],
                    [
                        'title' => 'Pending Orders',
                        'url' => '/sales/orders/pending',
                        'permission' => 'view-sales',
                    ],
                ],
            ],
            [
                'title' => 'Customers',
                'url' => '#',
                'icon' => 'Users',
                'items' => [
                    [
                        'title' => 'All Customers',
                        'url' => '/sales/customers',
                        'permission' => 'view-sales',
                    ],
                    [
                        'title' => 'Add Customer',
                        'url' => '/sales/customers/create',
                        'permission' => 'create-sales',
                    ],
                ],
            ],
            [
                'title' => 'Reports',
                'url' => '#',
                'icon' => 'PieChart',
                'items' => [
                    [
                        'title' => 'Sales Report',
                        'url' => '/sales/reports',
                        'permission' => 'view-sales',
                    ],
                    [
                        'title' => 'Analytics',
                        'url' => '/sales/analytics',
                        'permission' => 'view-sales',
                    ],
                ],
            ],
        ];
    }

    public function getProjects(): array
    {
        return [
            [
                'name' => 'Sales Targets',
                'url' => '/sales/targets',
                'icon' => 'Target',
            ],
            [
                'name' => 'Campaigns',
                'url' => '/sales/campaigns',
                'icon' => 'Megaphone',
            ],
        ];
    }
}
