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

        $this->app->bind(
            \App\Services\User\UserServiceInterface::class,
            \App\Services\User\UserService::class
        );

        $this->app->bind(
            \App\Services\Instruksi\InstruksiServiceInterface::class,
            \App\Services\Instruksi\InstruksiService::class
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

        $this->app->bind(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class
        );
        $this->app->bind(
            \App\Repositories\Instruksi\InstruksiRepositoryInterface::class,
            \App\Repositories\Instruksi\InstruksiRepository::class
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
