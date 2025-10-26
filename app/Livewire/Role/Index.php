<?php

namespace App\Livewire\Role;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Role\RoleServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    protected RoleServiceInterface $roleService;

    /**
     * Dependency Injection lewat boot()
     */



    public function boot(RoleServiceInterface $roleService)
    {
        $this->roleService = $roleService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $roles = $this->roleService->getAllRoles($this->search, 10);

        return view('livewire.role.index', [
            'roles' => $roles,
        ]);
    }
}
