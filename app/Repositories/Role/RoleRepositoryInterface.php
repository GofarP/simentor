<?php

namespace App\Repositories\Role;

use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface RoleRepositoryInterface
{
    public function getAll(string $search = '', int $perPage = 10): LengthAwarePaginator;
    public function storeRole(array $data);
    public function editRole(Role $role, array $data);
    public function deleteRole(Role $role): bool;
}
