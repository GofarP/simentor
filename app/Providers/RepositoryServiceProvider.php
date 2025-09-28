<?php

namespace App\Providers;

use App\Services\Role\RoleService;
use Illuminate\Support\ServiceProvider;
use App\Services\Role\RoleServiceInterface;
use App\Services\Permission\PermissionService;
use App\Services\Permission\PermissionServiceInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            PermissionServiceInterface::class,
            PermissionService::class
        );

        $this->app->bind(
            RoleServiceInterface::class,
            RoleService::class
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
