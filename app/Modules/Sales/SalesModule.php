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
                'url' => '/sales/dashboard',
                'permission' => 'view-sales',
            ],
            [
                'title' => 'Orders',
                'url' => '/sales/orders',
                'permission' => 'view-sales',
            ],
            [
                'title' => 'Customers',
                'url' => '/sales/customers',
                'permission' => 'view-sales',
            ],
            [
                'title' => 'Reports',
                'url' => '/sales/reports',
                'permission' => 'view-sales',
            ],
        ];
    }
}
