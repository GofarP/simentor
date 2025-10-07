<?php

namespace App\Repositories\ForwardFollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;
use App\Models\FollowupInstruction;
use App\Models\ForwardFollowupCoordination;
use App\Models\ForwardFollowupInstruction;
use Illuminate\Support\Facades\Auth;

class ForwardFollowupCoordinationRepository implements ForwardFollowupCoordinationRepositoryInterface
{
    public function forwardFollowupCoordination(FollowupCoordination $followupCoordination, array $data) {
        $forwardedTo=$data['forwarded_to'] ?? [];
        $followupCoordination->forwardedUsers->sync(
            collect($forwardedTo)->mapWithKeys(function($receiverId){
                return [$receiverId=>['forwarded_by'=>Auth::id()]];
            })->toArray()
        );

        return $followupCoordination->forwardedUsers;
    }

    public function deleteForwardFollowupCoordination(FollowupCoordination $followupCoordination)
    {
        return ForwardFollowupCoordination::where('followup_coordination_id',$followupCoordination->id);
    }

    public function getForwardFollowupCoordination(FollowupCoordination $followupCoordination){
        return FollowupInstruction::where('followup_coordination_id',$followupCoordination->id);
    }
}
