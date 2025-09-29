<?php
namespace App\Repositories\Permission;

use Illuminate\Support\Collection;
use Spatie\Permission\Models\Permission;


interface PermissionRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, bool $eager=false);
    public function storePermission(array $data);
    public function editPermission(Permission $permission, array $data);
    public function deletePermission(Permission $permission): bool;
    public function getNamesByIds(array $ids): Collection;
}
