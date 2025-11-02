<?php

namespace App\Services\Role;

use Spatie\Permission\Models\Role;
use App\Repositories\Role\RoleRepositoryInterface;
use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class RoleService implements RoleServiceInterface
{
    protected $roleRepository;
    protected $permissionRepository;

    public function __construct(
        RoleRepositoryInterface $roleRepository,
        PermissionRepositoryInterface $permissionRepository
    ) {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }


    public function getAllRoles(?string $search = '', int $perPage = 10, bool $eager = false)
    {
        $query = $this->roleRepository->query();

        $query->with('permissions');

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }


        if ($eager) {
            return $this->roleRepository->get($query);
        }

        return $this->roleRepository->paginate($query, $perPage);
    }


    public function storeRole(array $data, array $permissionIds = []): Role
    {
        return DB::transaction(function () use ($data, $permissionIds) {
            $role = $this->roleRepository->create($data);

            if (!empty($permissionIds)) {
                $permissionNames = $this->permissionRepository->getNamesByIds($permissionIds)->toArray();

                $this->roleRepository->syncPermissions($role, $permissionNames);
            }
            return $role;
        });
    }


    public function updateRole(Role $role, array $data, array $permissionIds = []): Role
    {
        return DB::transaction(function () use ($role, $data, $permissionIds) {
            $this->roleRepository->update($role, $data);

            $permissionNames = $this->permissionRepository->getNamesByIds($permissionIds)->toArray();

            $this->roleRepository->syncPermissions($role, $permissionNames);

            return $role;
        });
    }


    public function deleteRole(Role $role): bool
    {
        return $this->roleRepository->delete($role);
    }
}