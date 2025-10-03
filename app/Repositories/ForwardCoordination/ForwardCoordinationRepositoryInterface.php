<?php

namespace App\Repositories\ForwardCoordination;

use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\ForwardCoordination;

interface ForwardCoordinationRepositoryInterface
{
    public function forwardCoordination(Coordination $coordination, array $data);
    public function deleteForwardCoordination(Coordination $forwardCoordination):bool;

    public function getForwardCoordination(Coordination $forwardCoordination);
}
