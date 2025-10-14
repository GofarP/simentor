<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Models\Instruction;
use App\Models\Coordination;
use App\Policies\InstructionPolicy;
use App\Policies\CoordinationPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Coordination::class => CoordinationPolicy::class,
        Instruction::class => InstructionPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
