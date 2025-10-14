<?php
namespace App\Services\ForwardFollowupCoordination;

use App\Models\FollowupCoordination;
use App\Services\ForwardFollowupCoordination\ForwardFollowupCoordinationServiceInterface;
use App\Repositories\ForwardFollowupCoordination\ForwardFollowupCoordinationRepositoryInterface;

class ForwardFollowupCoordinationService implements ForwardFollowupCoordinationServiceInterface
{
    private ForwardFollowupCoordinationRepositoryInterface $forwardFollowupCoordinationRepository;

    public function __construct(ForwardFollowupCoordinationRepositoryInterface $forwardFollowupCoordinationRepository){
        $this->forwardFollowupCoordinationRepository= $forwardFollowupCoordinationRepository;
    }


    public function forwardFollowupCoordination(FollowupCoordination $followupCoordination, array $data){
        return $this->forwardFollowupCoordinationRepository->forwardFollowupCoordination($followupCoordination, $data);
    }

    public function getForwardFollowupCoordination(FollowupCoordination $followupCoordination){
        return $this->forwardFollowupCoordinationRepository->getForwardFollowupCoordination($followupCoordination);
    }

    public function deleteForwardFollowupCoordination(FollowupCoordination $followupCoordination){
        return $this->forwardFollowupCoordinationRepository->deleteForwardFollowupCoordination($followupCoordination);
    }


}