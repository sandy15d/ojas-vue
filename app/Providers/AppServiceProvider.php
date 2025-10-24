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
                                ->map(function ($item) use ($user) {
                                    // Filter sub-items based on permissions
                                    if (isset($item['items'])) {
                                        $item['items'] = collect($item['items'])
                                            ->filter(function ($subItem) use ($user) {
                                                if (! isset($subItem['permission'])) {
                                                    return true;
                                                }

                                                return $user->can($subItem['permission']);
                                            })
                                            ->values()
                                            ->toArray();
                                    }

                                    return $item;
                                })
                                ->filter(function ($item) {
                                    // Remove menu items that have no sub-items after filtering
                                    return ! isset($item['items']) || count($item['items']) > 0;
                                })
                                ->values()
                                ->toArray(),
                            'projects' => $module->getProjects(),
                        ];
                    })->filter()->values()->toArray();
                } catch (\Exception $e) {
                    return [];
                }
            },
        ]);
    }
}
