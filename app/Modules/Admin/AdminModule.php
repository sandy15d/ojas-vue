<?php

namespace App\Modules\Admin;

use App\Support\Module;

class AdminModule extends Module
{
    public function getName(): string
    {
        return 'Admin';
    }

    public function getIdentifier(): string
    {
        return 'admin';
    }

    public function getIcon(): string
    {
        return 'Settings2';
    }

    public function getPermissions(): array
    {
        return [
            'view-admin',
            'manage-admin',
            'create-admin',
            'edit-admin',
            'delete-admin',
        ];
    }

    public function getRoutes(): string
    {
        return __DIR__.'/routes.php';
    }

    public function getDashboardRoute(): string
    {
        return '/admin/dashboard';
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
                        'url' => '/admin/dashboard',
                        'permission' => 'view-admin',
                    ],
                ],
            ],
            [
                'title' => 'Access Management',
                'url' => '#',
                'icon' => 'Lock',
                'items' => [
                    [
                        'title' => 'Users',
                        'url' => '/admin/users',
                        'permission' => 'view-admin',
                    ],

                ],
            ],

        ];
    }
}
