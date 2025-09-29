<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;

interface PermissionServiceInterface
{
    public function getAllPermissions( $search = null, int $perPage = 10, bool $eager=false);
    public function storePermission(array $data): Permission;
    public function editPermission(Permission $permission, array $data): Permission;
    public function deletePermission(Permission $permission): bool;

}
