<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;

class PermissionService implements PermissionServiceInterface
{
    public function getAllPermissions(string $search = null, int $perPage = 10)
    {
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->orderByDesc('created_at')->paginate($perPage)->onEachSide(1);
    }

    public function storePermission(array $data): Permission
    {
        return Permission::create($data);
    }

    public function editPermission(Permission $permission, array $data): Permission
    {
        $permission->update($data);
        return $permission;
    }

    public function deletePermission(Permission $permission): bool
    {
        return $permission->delete();
    }
}
