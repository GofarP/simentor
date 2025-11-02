<?php

namespace App\Services\Role; // Sesuaikan namespace Anda

use Spatie\Permission\Models\Role;
use Illuminate\Support\Collection;

interface RoleServiceInterface
{

    public function getAllRoles(?string $search, int $perPage, bool $eager);


    public function storeRole(array $data, array $permissionIds = []): Role;


    public function updateRole(Role $role, array $data, array $permissionIds = []): Role;


    public function deleteRole(Role $role): bool;
}