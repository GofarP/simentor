<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Support\Collection;

class PermissionService implements PermissionServiceInterface
{
    protected $permissionRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }


    public function getAllPermissions(?string $search = '', int $perPage = 10, bool $eager = false)
    {
        $query = $this->permissionRepository->query();

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        if ($eager) {
            return $this->permissionRepository->get($query);
        }

        return $this->permissionRepository->paginate($query, $perPage);
    }


    public function storePermission(array $data): Permission
    {
        return $this->permissionRepository->create($data);
    }

    public function editPermission(Permission $permission, array $data): bool
    {
        return $this->permissionRepository->update($permission, $data);
    }


    public function deletePermission(Permission $permission): bool
    {
        return $this->permissionRepository->delete($permission);
    }


    public function getNamesByIds(array $ids): Collection
    {
        return $this->permissionRepository->getNamesByIds($ids);
    }
}