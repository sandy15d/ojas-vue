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

    public function getMenuItems(): array
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
