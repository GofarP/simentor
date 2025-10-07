<?php
namespace App\Services\ForwardFollowupCoordination;

use App\Models\FollowupCoordination;


interface ForwardFollowupCoordinationServiceInterface{
    public function forwardFollowupCoordination(FollowupCoordination $followupCoordination, array $data);
    public function deleteForwardFollowupCoordination(FollowupCoordination $followupCoordination);
    public function getForwardFollowupCoordination(FollowupCoordination $followupCoordination);
}
