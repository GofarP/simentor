<?php

namespace App\Repositories\Role;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10, bool $eager = false): LengthAwarePaginator|Collection
    {
        $query = Role::query()->with('permissions'); // eager load permissions

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $query->orderByDesc('created_at');

        return $eager
            ? $query->get()
            : $query->paginate($perPage)->onEachSide(1);
    }

    public function store(array $data, array $permissionIds = []): Role
    {
        $role = Role::create($data);

        if (!empty($permissionIds)) {
            // Ambil nama permission berdasarkan ID dan paksa guard 'web'
            $permissionNames = Permission::whereIn('id', $permissionIds)
                ->where('guard_name', 'web')
                ->pluck('name')
                ->toArray();

            $role->syncPermissions($permissionNames); // sync ke role
        }

        return $role;
    }
    public function update(Role $role, array $data, array $permissionIds = []): Role
    {
    
        // update data role
        $role->update($data);

        if (!empty($permissionIds)) {
            // ambil Permission model langsung
            $permissions = Permission::whereIn('id', $permissionIds)
                ->where('guard_name', 'web')
                ->get();

            // sync ke role
            $role->syncPermissions($permissions);
        }

        return $role;
    }


    public function delete(Role $role): bool
    {
        return $role->delete();
    }

    public function syncPermissions(Role $role, array $permissionNames): Role
    {
        $role->syncPermissions($permissionNames);
        return $role;
    }
}
