<?php

namespace App\Services\Permission;

use App\Repositories\Permission\PermissionRepositoryInterface;
use Spatie\Permission\Models\Permission;


class PermissionService implements PermissionServiceInterface
{
    protected PermissionRepositoryInterface $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    public function getAllPermissions( $search = null, int $perPage = 10, bool $eager = false)
    {
        return $this->permissionRepository->getAll($search, $perPage, $eager);
    }

    public function storePermission(array $data): Permission
    {
        return $this->permissionRepository->storePermission($data);
    }

    public function editPermission(Permission $permission, array $data): Permission
    {
        return $this->permissionRepository->editPermission($permission, $data);
    }

    public function deletePermission(Permission $permission): bool
    {
        return $this->permissionRepository->deletePermission($permission);
    }
}
