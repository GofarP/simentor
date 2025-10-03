<?php
namespace App\Services\ForwardCoordination;

use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\ForwardCoordination;
use Faker\Core\Coordinates;

interface ForwardCoordinationServiceInterface
{
    public function forwardCoordination(Coordination $coordination, array $data);

    public function deleteForwardCoordination(Coordination $coordination):bool;

    public function getForwardCoordination(Coordination $forwardCoordination);
}