<?php

namespace App\Services\Role;

use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Spatie\Permission\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class RoleService implements RoleServiceInterface
{
    public function __construct(
        protected RoleRepositoryInterface $roleRepository,
        protected PermissionRepositoryInterface $permissionRepository
    ) {
    }

    public function getAllRoles(?string $search = null, int $perPage = 10, bool $eager = false): LengthAwarePaginator|Collection
    {
        return $this->roleRepository->getAll($search, $perPage, $eager);
    }

    public function storeRole(array $data, array $permissionIds = []): Role
    {
        return $this->roleRepository->store($data, $permissionIds);
    }

    public function editRole(Role $role, array $data, array $permissionIds = []): Role
    {
        return $this->roleRepository->update($role, $data, $permissionIds);
    }

    public function deleteRole(Role $role): bool
    {
        return $this->roleRepository->delete($role);
    }
}
