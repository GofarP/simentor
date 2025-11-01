<?php

namespace App\Repositories\ForwardCoordination;


use App\Models\Coordination;
use Illuminate\Database\Eloquent\Builder;

interface ForwardCoordinationRepositoryInterface
{
    public function syncForwardedUsers(Coordination $coordination, array $pivotData);


    public function deleteByCoordinationId(int $coordinationId): bool;


    public function getQueryByCoordinationId(int $coordinationId): Builder;
}
