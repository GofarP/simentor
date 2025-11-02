<?php

namespace App\Repositories\Permission; // Sesuaikan namespace

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface PermissionRepositoryInterface
{
   
    public function query(): Builder;


    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;


    public function get(Builder $query): Collection;


    public function create(array $data): Permission;


    public function update(Permission $permission, array $data): bool;


    public function delete(Permission $permission): bool;


    public function getNamesByIds(array $ids): Collection;
}