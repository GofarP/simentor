<?php
namespace App\Services\ForwardCoordination;

use App\Models\Coordination;


interface ForwardCoordinationServiceInterface
{
    public function forwardCoordination(Coordination $coordination, array $data);

    public function deleteForwardCoordination(Coordination $coordination):bool;

    public function getForwardCoordination(Coordination $forwardCoordination);
}