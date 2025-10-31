<?php

namespace App\Repositories\FollowupCoordination;

use App\Models\FollowupCoordination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;



class FollowupCoordinationRepository implements FollowupCoordinationRepositoryInterface
{
    public function query(): Builder
    {
        return FollowupCoordination::query();
    }


    public function paginate(Builder $query, int $perPage): LengthAwarePaginator
    {
        return $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->onEachSide(1);
    }


    public function storeFollowupCoordination(array $data): FollowupCoordination
    {
        return FollowupCoordination::create($data);
    }


    public function editFollowupCoordination(FollowupCoordination $followupCoordination, array $data): bool
    {
        return $followupCoordination->update($data);
    }

    public function deleteFollowupCoordination(FollowupCoordination $followupCoordination): bool
    {
       return $followupCoordination->delete();
    }

}
