<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;

interface PermissionServiceInterface
{
    public function getAllPermissions(string $search = null, int $perPage = 10);
    public function storePermission(array $data): Permission;
    public function editPermission(Permission $permission, array $data): Permission;
    public function deletePermission(Permission $permission): bool;
}
