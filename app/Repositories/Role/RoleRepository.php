<?php

namespace App\Repositories\Role; // Sesuaikan namespace Anda

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class RoleRepository implements RoleRepositoryInterface
{
    public function query(): Builder
    {
        return Role::query();
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

    public function create(array $data): Role
    {
        return Role::create($data);
    }

    public function update(Role $role, array $data): bool
    {
        return $role->update($data);
    }

    public function delete(Role $role): bool
    {
       return $role->delete();
    }

    public function syncPermissions(Role $role, array $permissionNames): Role
    {
        return $role->syncPermissions($permissionNames);
    }
}