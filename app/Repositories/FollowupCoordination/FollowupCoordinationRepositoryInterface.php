<?php

namespace App\Repositories\FollowupCoordination;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\FollowupCoordination;

interface FollowupCoordinationRepositoryInterface
{

    public function query(): Builder;


    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;


    public function storeFollowupCoordination(array $data): FollowupCoordination;


    public function editFollowupCoordination(FollowupCoordination $followupCoordination, array $data): bool;

    public function deleteFollowupCoordination(FollowupCoordination $followupCoordination): bool;
}
