<?php
namespace App\Repositories\Permission;

use Spatie\Permission\Models\Permission;


interface PermissionRepositoryInterface
{
    public function getAll(string $search = '', int $perPage = 10);
    public function storePermission(array $data);
    public function editPermission(Permission $permission, array $data);
    public function deletePermission(Permission $permission): bool;
}
