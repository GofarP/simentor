<?php

namespace App\Livewire\Permission;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\Permission\PermissionServiceInterface;

class Index extends Component
{
    use WithPagination;

    public string $search = '';
    protected PermissionServiceInterface $permissionService;


    public function boot(PermissionServiceInterface $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $permissions = $this->permissionService->getAllPermissions($this->search, 10);

        return view('livewire.permission.index', [
            'permissions' => $permissions,
        ]);
    }
}
