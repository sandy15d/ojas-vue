<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Inertia::share([
            'modules' => function () {
                if (! Auth::check()) {
                    return [];
                }

                try {
                    $user = Auth::user();
                    $modules = app('modules');

                    return $modules->map(function ($module) use ($user) {
                        if (! $user->hasModuleAccess($module->getIdentifier())) {
                            return null;
                        }

                        return [
                            'name' => $module->getName(),
                            'identifier' => $module->getIdentifier(),
                            'icon' => $module->getIcon(),
                            'dashboardRoute' => $module->getDashboardRoute(),
                            'menuItems' => collect($module->getMenuItems())
                                ->filter(function ($item) use ($user) {
                                    if (! isset($item['permission'])) {
                                        return true;
                                    }

                                    return $user->can($item['permission']);
                                })
                                ->values()
                                ->toArray(),
                        ];
                    })->filter()->values()->toArray();
                } catch (\Exception $e) {
                    return [];
                }
            },
        ]);
    }
}
