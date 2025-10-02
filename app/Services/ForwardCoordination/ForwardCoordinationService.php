<?php

namespace App\Services\ForwardCoordination;

use App\Models\Coordination;
use App\Models\ForwardInstruction;
use App\Repositories\ForwardCoordination\ForwardCoordinationRepositoryInterface;
use Faker\Core\Coordinates;

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
        return $this->deleteForwardCoordination($coordination);
    }
}
