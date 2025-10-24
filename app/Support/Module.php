<?php

namespace App\Support;

abstract class Module
{
    abstract public function getName(): string;

    abstract public function getIdentifier(): string;

    abstract public function getIcon(): string;

    abstract public function getPermissions(): array;

    abstract public function getRoutes(): string;

    abstract public function getDashboardRoute(): string;

    /**
     * Get the menu items for this module.
     *
     * Return format:
     * [
     *     [
     *         'title' => 'Section Name',
     *         'url' => '#',
     *         'icon' => 'LayoutDashboard', // Lucide icon name
     *         'items' => [
     *             ['title' => 'Submenu Item', 'url' => '/path'],
     *         ],
     *     ],
     * ]
     */
    public function getMenuItems(): array
    {
        return [];
    }

    /**
     * Get additional sidebar projects/sections for this module.
     */
    public function getProjects(): array
    {
        return [];
    }

    public function getConfig(): array
    {
        return [];
    }

    public function boot(): void
    {
        //
    }

    public function register(): void
    {
        //
    }
}
