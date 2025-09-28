<?php

namespace App\Repositories\Permission;

use App\Repositories\Permission\PermissionRepositoryInterface;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, bool $eager = false)
    {
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $query->orderByDesc('created_at');

        if ($eager) {
            return $query->get();
        }

        return $query->paginate($perPage)->onEachSide(1);
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

    public function getNamesByIds(array $ids): Collection
    {
        return Permission::whereIn('id', $ids)->pluck('name');
    }
}
