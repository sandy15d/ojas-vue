<?php

namespace App\Modules\COGS;

use App\Support\Module;

class COGSModule extends Module
{
    public function getName(): string
    {
        return 'COGS';
    }

    public function getIdentifier(): string
    {
        return 'cogs';
    }

    public function getIcon(): string
    {
        return 'Package';
    }

    public function getPermissions(): array
    {
        return [
            'view-cogs',
            'manage-cogs',
            'create-cogs',
            'edit-cogs',
            'delete-cogs',
        ];
    }

    public function getRoutes(): string
    {
        return __DIR__.'/routes.php';
    }

    public function getDashboardRoute(): string
    {
        return '/cogs/dashboard';
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
                        'url' => '/cogs/dashboard',
                        'permission' => 'view-cogs',
                    ],
                ],
            ],
            [
                'title' => 'Inventory',
                'url' => '#',
                'icon' => 'Package',
                'items' => [
                    [
                        'title' => 'All Items',
                        'url' => '/cogs/inventory',
                        'permission' => 'view-cogs',
                    ],
                    [
                        'title' => 'Add Item',
                        'url' => '/cogs/inventory/create',
                        'permission' => 'create-cogs',
                    ],
                    [
                        'title' => 'Stock Levels',
                        'url' => '/cogs/inventory/stock',
                        'permission' => 'view-cogs',
                    ],
                ],
            ],
            [
                'title' => 'Suppliers',
                'url' => '#',
                'icon' => 'Truck',
                'items' => [
                    [
                        'title' => 'All Suppliers',
                        'url' => '/cogs/suppliers',
                        'permission' => 'view-cogs',
                    ],
                    [
                        'title' => 'Add Supplier',
                        'url' => '/cogs/suppliers/create',
                        'permission' => 'create-cogs',
                    ],
                ],
            ],
            [
                'title' => 'Analysis',
                'url' => '#',
                'icon' => 'BarChart',
                'items' => [
                    [
                        'title' => 'Cost Analysis',
                        'url' => '/cogs/analysis',
                        'permission' => 'view-cogs',
                    ],
                    [
                        'title' => 'Trends',
                        'url' => '/cogs/trends',
                        'permission' => 'view-cogs',
                    ],
                ],
            ],
        ];
    }

    public function getProjects(): array
    {
        return [
            [
                'name' => 'Cost Reduction',
                'url' => '/cogs/cost-reduction',
                'icon' => 'TrendingDown',
            ],
            [
                'name' => 'Quality Control',
                'url' => '/cogs/quality',
                'icon' => 'Award',
            ],
        ];
    }
}
