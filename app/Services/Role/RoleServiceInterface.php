<?php

namespace App\Services\Role;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Spatie\Permission\Models\Role;

interface RoleServiceInterface
{
    public function getAllRoles(string $search = null, int $perPage = 10);
    public function storeRole(array $data): Role;
    public function editRole(Role $role, array $data): Role;
    public function deleteRole(Role $role): bool;
}
