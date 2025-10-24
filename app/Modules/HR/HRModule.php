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
                'url' => '#',
                'icon' => 'LayoutGrid',
                'items' => [
                    [
                        'title' => 'Overview',
                        'url' => '/hr/dashboard',
                        'permission' => 'view-hr',
                    ],
                ],
            ],
            [
                'title' => 'Employees',
                'url' => '#',
                'icon' => 'Users',
                'items' => [
                    [
                        'title' => 'All Employees',
                        'url' => '/hr/employees',
                        'permission' => 'view-hr',
                    ],
                    [
                        'title' => 'Add Employee',
                        'url' => '/hr/employees/create',
                        'permission' => 'create-hr',
                    ],
                    [
                        'title' => 'Departments',
                        'url' => '/hr/departments',
                        'permission' => 'view-hr',
                    ],
                ],
            ],
            [
                'title' => 'Attendance',
                'url' => '#',
                'icon' => 'Calendar',
                'items' => [
                    [
                        'title' => 'View Attendance',
                        'url' => '/hr/attendance',
                        'permission' => 'view-hr',
                    ],
                    [
                        'title' => 'Leave Requests',
                        'url' => '/hr/leave-requests',
                        'permission' => 'view-hr',
                    ],
                ],
            ],
            [
                'title' => 'Payroll',
                'url' => '#',
                'icon' => 'Wallet',
                'items' => [
                    [
                        'title' => 'Payroll Overview',
                        'url' => '/hr/payroll',
                        'permission' => 'view-hr',
                    ],
                    [
                        'title' => 'Generate Payroll',
                        'url' => '/hr/payroll/generate',
                        'permission' => 'manage-hr',
                    ],
                ],
            ],
        ];
    }

    public function getProjects(): array
    {
        return [
            [
                'name' => 'Recruitment',
                'url' => '/hr/recruitment',
                'icon' => 'UserPlus',
            ],
            [
                'name' => 'Training',
                'url' => '/hr/training',
                'icon' => 'GraduationCap',
            ],
        ];
    }
}
