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
            \App\Services\Instruction\InstructionServiceInterface::class,
            \App\Services\Instruction\InstructionService::class
        );

        $this->app->bind(
            \App\Services\Coordination\CoordinationServiceInterface::class,
            \App\Services\Coordination\CoordinationService::class
        );

        $this->app->bind(
            \App\Services\ForwardInstruction\ForwardInstructionServiceInterface::class,
            \App\Services\ForwardInstruction\ForwardInstructionService::class
        );

        $this->app->bind(
            \App\Services\ForwardCoordination\ForwardCoordinationServiceInterface::class,
            \App\Services\ForwardCoordination\ForwardCoordinationService::class
        );
        $this->app->bind(
            \App\Services\FollowupInstruction\FollowupInstructionServiceInterface::class,
            \App\Services\FollowupInstruction\FollowupInstructionService::class
        );

        $this->app->bind(
            \App\Services\FollowupCoordination\FollowupCoordinationServiceInterface::class,
            \App\Services\FollowupCoordination\FollowupCoordinationService::class
        );

        $this->app->bind(
            \App\Services\ForwardFollowupInstruction\ForwardFollowupInstructionServiceInterface::class,
            \App\Services\ForwardFollowupInstruction\ForwardFollowupInstructionService::class,
        );

        $this->app->bind(
            \App\Services\ForwardFollowupCoordination\ForwardFollowupCoordinationServiceInterface::class,
            \App\Services\ForwardFollowupCoordination\ForwardFollowupCoordinationService::class,
        );
        $this->app->bind(
            \App\Services\FollowupInstructionScore\FollowupInstructionScoreServiceInterface::class,
            \App\Services\FollowupInstructionScore\FollowupInstructionScoreService::class,
        );
        $this->app->bind(
            \App\Services\InstructionScore\InstructionScoreServiceInterface::class,
            \App\Services\InstructionScore\InstructionScoreService::class,
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
            \App\Repositories\Instruction\InstructionRepositoryInterface::class,
            \App\Repositories\Instruction\InstructionRepository::class
        );
        $this->app->bind(
            \App\Repositories\Coordination\CoordinationRepositoryInterface::class,
            \App\Repositories\Coordination\CoordinationRepository::class
        );

        $this->app->bind(
            \App\Repositories\ForwardInstruction\ForwardInstructionRepositoryInterface::class,
            \App\Repositories\ForwardInstruction\ForwardInstructionRepository::class,
        );
        $this->app->bind(
            \App\Repositories\ForwardCoordination\ForwardCoordinationRepositoryInterface::class,
            \App\Repositories\ForwardCoordination\ForwardCoordinationRepository::class,
        );
        $this->app->bind(
            \App\Repositories\FollowupInstruction\FollowupInstructionRepositoryInterface::class,
            \App\Repositories\FollowupInstruction\FollowupInstructionRepository::class,
        );
        $this->app->bind(
            \App\Repositories\FollowupCoordination\FollowupCoordinationRepositoryInterface::class,
            \App\Repositories\FollowupCoordination\FollowupCoordinationRepository::class,
        );

        $this->app->bind(
            \App\Repositories\ForwardFollowupCoordination\ForwardFollowupCoordinationRepositoryInterface::class,
            \App\Repositories\ForwardFollowupCoordination\ForwardFollowupCoordinationRepository::class,
        );

        $this->app->bind(
            \App\Repositories\ForwardFollowupInstruction\ForwardFollowupInstructionRepositoryInterface::class,
            \App\Repositories\ForwardFollowupInstruction\ForwardFollowupInstructionRepository::class,
        );

        $this->app->bind(
            \App\Repositories\FollowupInstructionScore\FollowupInstructionScoreRepositoryInterface::class,
            \App\Repositories\FollowupInstructionScore\FollowupInstructionScoreRepository::class,
        );

        $this->app->bind(
            \App\Repositories\InstructionScore\InstructionScoreRepositoryInterface::class,
            \App\Repositories\InstructionScore\InstructionScoreRepository::class,
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
