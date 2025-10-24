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
                'url' => '/cogs/dashboard',
                'permission' => 'view-cogs',
            ],
            [
                'title' => 'Inventory',
                'url' => '/cogs/inventory',
                'permission' => 'view-cogs',
            ],
            [
                'title' => 'Suppliers',
                'url' => '/cogs/suppliers',
                'permission' => 'view-cogs',
            ],
            [
                'title' => 'Analysis',
                'url' => '/cogs/analysis',
                'permission' => 'view-cogs',
            ],
        ];
    }
}
