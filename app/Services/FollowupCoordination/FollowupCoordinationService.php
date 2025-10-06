<?php

namespace App\Services\FollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;
use App\Repositories\FollowupCoordination\FollowupCoordinationRepositoryInterface;

class FollowupCoordinationService implements FollowupCoordinationServiceInterface
{
    private FollowupCoordinationRepositoryInterface $followupCoordinationRepository;

    public function __construct(FollowupCoordinationRepositoryInterface $followupCoordinationRepository)
    {
        $this->followupCoordinationRepository = $followupCoordinationRepository;
    }

    public function getAll(?string $search = null, MessageType $messageType, int $perPage, bool $eager = false)
    {
        $this->followupCoordinationRepository->getAll($search, $perPage, $messageType, false);
    }
    public function storeFollowupCoordination(array $data)
    {
        return $this->followupCoordinationRepository->storeFollowupCoordination($data);
    }

    public function editFollowupCoordination(FollowupCoordination $followupCoordination, array $data)
    {
        return $this->followupCoordinationRepository->editFollowupCoordination($followupCoordination, $data);
    }

    public function deleteFollowupCoordination(FollowupCoordination $followupCoordination) {
        return $this->followupCoordinationRepository->deleteFollowupCoordination($followupCoordination);
    }
}
