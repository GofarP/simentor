<?php

namespace App\Providers;

use App\Repositories\PermissionRepository;
use Illuminate\Support\ServiceProvider;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Service
        $this->app->bind(
            \App\Services\Permission\PermissionServiceInterface::class,
            \App\Services\Permission\PermissionService::class
        );

        $this->app->bind(
            \App\Services\Role\RoleServiceInterface::class,
            \App\Services\Role\RoleService::class
        );

        // Repository
        $this->app->bind(
            \App\Repositories\Permission\PermissionRepositoryInterface::class,
            \App\Repositories\Permission\PermissionRepository::class
        );

        $this->app->bind(
            \App\Repositories\Role\RoleRepositoryInterface::class,
            \App\Repositories\Role\RoleRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
