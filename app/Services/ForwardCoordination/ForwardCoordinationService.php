<?php

namespace App\Services\ForwardCoordination;

use App\Models\Coordination;
use App\Models\ForwardCoordination;
use App\Repositories\ForwardCoordination\ForwardCoordinationRepositoryInterface;

class ForwardCoordinationService implements ForwardCoordinationServiceInterface
{
    private ForwardCoordinationRepositoryInterface $forwardCoordinationRepository;

    public function __construct(ForwardCoordinationRepositoryInterface $forwardCoordinationRepository) {
        $this->forwardCoordinationRepository = $forwardCoordinationRepository;
    }

    public function forwardCoordination(Coordination $coordination, array $data)
    {
        return $this->forwardCoordinationRepository->forwardCoordination($coordination, $data);
    }

    public function deleteForwardCoordination(Coordination $coordination): bool
    {
        return $this->forwardCoordinationRepository->deleteForwardCoordination($coordination);
    }

    public function getForwardCoordination(Coordination $coordination){
        return $this->forwardCoordinationRepository->getForwardCoordination($coordination);
    }
}
