<?php
namespace App\Repositories\ForwardFollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;

interface ForwardFollowupCoordinationRepositoryInterface{
    public function forwardFollowupCoordination(FollowupCoordination $followupCoordination, array $data);
    public function deleteForwardFollowupCoordination(FollowupCoordination $followupCoordination);
    public function getForwardFollowupCoordination(FollowupCoordination $followupCoordination);
}
