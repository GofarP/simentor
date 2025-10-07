<?php
namespace App\Services\ForwardFollowupInstruction;

use App\Models\FollowupCoordination;
use App\Services\ForwardFollowupCoordination\ForwardFollowupCoordinationServiceInterface;


class ForwardFollowupCoordinationService implements ForwardFollowupCoordinationServiceInterface
{
    private ForwardFollowupCoordinationServiceInterface $forwardFollowupCoordinationService;

    public function __construct(ForwardFollowupCoordinationServiceInterface $forwardFollowupCoordinationService){
        $this->$forwardFollowupCoordinationService= $forwardFollowupCoordinationService;
    }


    public function forwardFollowupCoordination(FollowupCoordination $followupCoordination, array $data){
        return $this->forwardFollowupCoordinationService->forwardFollowupCoordination($followupCoordination, $data);
    }

    public function getForwardFollowupCoordination(FollowupCoordination $followupCoordination){
        return $this->forwardFollowupCoordinationService->getForwardFollowupCoordination($followupCoordination);
    }

    public function deleteForwardFollowupCoordination(FollowupCoordination $followupCoordination){
        return $this->forwardFollowupCoordinationService->deleteForwardFollowupCoordination($followupCoordination);
    }

    
}