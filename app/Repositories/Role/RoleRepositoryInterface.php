<?php

namespace App\Repositories\Role; // Sesuaikan namespace Anda

use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface RoleRepositoryInterface
{

    public function query(): Builder;


    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;

    public function get(Builder $query): Collection;


    public function create(array $data): Role;


    public function update(Role $role, array $data): bool;


    public function delete(Role $role): bool;


    public function syncPermissions(Role $role, array $permissionNames): Role;
}