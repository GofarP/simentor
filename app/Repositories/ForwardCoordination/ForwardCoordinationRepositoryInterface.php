<?php

namespace App\Repositories\ForwardCoordination;

use App\Enums\MessageType;
use App\Models\ForwardCoordination;

interface ForwardCoordinationRepositoryInterface
{
    public function forwardCoordination(ForwardCoordination $coordination, array $data);
    public function deleteForwardCoordination(ForwardCoordination $forwardCoordination):bool;
}
