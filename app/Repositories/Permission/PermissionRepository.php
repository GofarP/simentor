<?php

namespace App\Repositories;

use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function getAll(string $search = '', int $perPage = 10)
    {
        return Permission::where('name', 'like', '%' . $search . '%')
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->onEachSide(1);
    }

    public function storePermission(array $data)
    {
        return Permission::create($data);
    }

    public function editPermission(Permission $permission, array $data)
    {
        $permission->update($data);
        return $permission;
    }

    public function deletePermission(Permission $permission): bool
    {
        return $permission->delete();
    }
}
