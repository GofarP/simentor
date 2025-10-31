<?php

namespace App\Repositories\Coordination;

use App\Models\Coordination;
use Faker\Core\Coordinates;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;


interface CoordinationRepositoryInterface
{
     public function query(): Builder;

   
    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;

    public function getCoordinationById(int $coordinationId): ?Coordination;


    public function create(array $data): Coordination;


    public function update(Coordination $coordination, array $data): bool;


    public function delete(Coordination $coordination): bool;


    public function syncReceivers(Coordination $coordination, array $pivotData): void;
}
