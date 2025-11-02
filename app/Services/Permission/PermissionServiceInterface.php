<?php

namespace App\Services\Permission;

use Spatie\Permission\Models\Permission;
use Illuminate\Support\Collection;

// Interface ini akan mencerminkan method yang Anda berikan
interface PermissionServiceInterface
{

    public function getAllPermissions(?string $search, int $perPage, bool $eager);


    public function storePermission(array $data): Permission;


    public function editPermission(Permission $permission, array $data): bool;


    public function deletePermission(Permission $permission): bool;

  
    public function getNamesByIds(array $ids): Collection;
}