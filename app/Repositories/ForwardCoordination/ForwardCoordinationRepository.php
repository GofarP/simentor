<?php
namespace App\Repositories\ForwardCoordination;

use App\Models\Coordination;
use App\Models\ForwardCoordination;
use Illuminate\Database\Eloquent\Builder;



class ForwardCoordinationRepository implements ForwardCoordinationRepositoryInterface
{

    public function syncForwardedUsers(Coordination $instruction, array $pivotData)
    {
        return $instruction->forwardedUsers()->sync($pivotData);
    }


    public function deleteByCoordinationId(int $coordinationId): bool
    {
        return ForwardCoordination::where('coordination_id', $coordinationId)->delete();
    }


    public function getQueryByCoordinationId(int $coordinationId): Builder
    {
        return ForwardCoordination::where('coordination_id', $coordinationId);

    }

}