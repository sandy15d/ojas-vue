<?php

namespace App\Modules\HR;

use App\Support\Module;

class HRModule extends Module
{
    public function getName(): string
    {
        return 'HR';
    }

    public function getIdentifier(): string
    {
        return 'hr';
    }

    public function getIcon(): string
    {
        return 'Users';
    }

    public function getPermissions(): array
    {
        return [
            'view-hr',
            'manage-hr',
            'create-hr',
            'edit-hr',
            'delete-hr',
        ];
    }

    public function getRoutes(): string
    {
        return __DIR__.'/routes.php';
    }

    public function getDashboardRoute(): string
    {
        return '/hr/dashboard';
    }

    public function getMenuItems(): array
    {
        return [
            [
                'title' => 'Dashboard',
                'url' => '/hr/dashboard',
                'permission' => 'view-hr',
            ],
            [
                'title' => 'Employees',
                'url' => '/hr/employees',
                'permission' => 'view-hr',
            ],
            [
                'title' => 'Attendance',
                'url' => '/hr/attendance',
                'permission' => 'view-hr',
            ],
            [
                'title' => 'Payroll',
                'url' => '/hr/payroll',
                'permission' => 'view-hr',
            ],
        ];
    }
}
