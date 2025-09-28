<?php
namespace App\Services\Role;

use Spatie\Permission\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RoleServiceInterface
{
    public function getAllRoles(?string $search = null, int $perPage = 10, bool $eager = false): LengthAwarePaginator|Collection;
    public function storeRole(array $data, array $permissionIds = []): Role;
    public function editRole(Role $role, array $data, array $permissionIds = []): Role;
    public function deleteRole(Role $role): bool;
}
