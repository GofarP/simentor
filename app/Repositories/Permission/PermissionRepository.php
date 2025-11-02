<?php

namespace App\Repositories\Permission; // Sesuaikan namespace

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function query(): Builder
    {
        return Permission::query();
    }

    public function paginate(Builder $query, int $perPage): LengthAwarePaginator
    {
        return $query->orderByDesc('created_at')
                     ->paginate($perPage)
                     ->onEachSide(1);
    }

    public function get(Builder $query): Collection
    {
        return $query->orderByDesc('created_at')->get();
    }

    public function create(array $data): Permission
    {
        return Permission::create($data);
    }

    public function update(Permission $permission, array $data): bool
    {
        return $permission->update($data);
    }

    public function delete(Permission $permission): bool
    {
       return $permission->delete();
    }

    public function getNamesByIds(array $ids): Collection
    {
        return Permission::whereIn('id', $ids)->pluck('name');
    }
}