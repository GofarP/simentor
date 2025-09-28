<?php

namespace App\Repositories\Role;

use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class RoleRepository implements RoleRepositoryInterface
{
    public function getAll(string $search = '', int $perPage = 10): LengthAwarePaginator
    {
        return Role::where('name', 'like', '%' . $search . '%')
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->onEachSide(1);
    }

    public function storeRole(array $data)
    {
        return Role::create($data);
    }

    public function editRole(Role $role, array $data)
    {
        $role->update($data);
        return $role;
    }

    public function deleteRole(Role $role): bool
    {
        return $role->delete();
    }
}
