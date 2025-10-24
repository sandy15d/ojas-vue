<?php

namespace App\Providers;

use App\Support\Module;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ModuleServiceProvider extends ServiceProvider
{
    protected array $modules = [];

    public function register(): void
    {
        $this->app->singleton('modules', function () {
            return collect($this->modules);
        });
    }

    public function boot(): void
    {
        $this->discoverModules();
        $this->registerModules();
        $this->bootModules();
        $this->loadModuleRoutes();
    }

    protected function discoverModules(): void
    {
        $modulesPath = app_path('Modules');

        if (! File::isDirectory($modulesPath)) {
            return;
        }

        $moduleDirectories = File::directories($modulesPath);

        foreach ($moduleDirectories as $moduleDirectory) {
            $moduleName = basename($moduleDirectory);
            $moduleClass = "App\\Modules\\{$moduleName}\\{$moduleName}Module";

            if (class_exists($moduleClass)) {
                $module = app($moduleClass);

                if ($module instanceof Module) {
                    $this->modules[$module->getIdentifier()] = $module;
                }
            }
        }
    }

    protected function registerModules(): void
    {
        foreach ($this->modules as $module) {
            $module->register();
        }
    }

    protected function bootModules(): void
    {
        foreach ($this->modules as $module) {
            $module->boot();
        }
    }

    protected function loadModuleRoutes(): void
    {
        foreach ($this->modules as $module) {
            $routesFile = $module->getRoutes();

            if (file_exists($routesFile)) {
                Route::middleware('web')->group(function () use ($routesFile) {
                    require $routesFile;
                });
            }
        }
    }
}
