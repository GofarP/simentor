<?php

namespace App\Repositories\Role;

use Spatie\Permission\Models\Role;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10, bool $eager = false): LengthAwarePaginator|Collection;
    public function store(array $data,  array $permissionIds = []): Role;
    public function update(Role $role, array $data,  array $permissionIds = []): Role;
    public function delete(Role $role): bool;
    public function syncPermissions(Role $role, array $permissionNames): Role;
}
