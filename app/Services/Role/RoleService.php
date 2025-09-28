<?php

namespace App\Services\Role;

use App\Repositories\Role\RoleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

class RoleService implements RoleServiceInterface
{
    public function getAllRoles(string $search = null, int $perPage = 10)
    {
        $query = Role::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        return $query->orderByDesc('created_at')->paginate($perPage)->onEachSide(1);
    }

    public function storeRole(array $data): Role
    {
        return Role::create($data);
    }

    public function editRole(Role $role, array $data): Role
    {
        $role->update($data);
        return $role;
    }

    public function deleteRole(Role $role): bool
    {
        return $role->delete();
    }
}
