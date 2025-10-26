<?php

namespace App\Repositories\ForwardFollowupInstruction;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use App\Models\ForwardFollowupInstruction;
use App\Models\ForwardInstruction;
use App\Policies\FollowupInstructionPolicy;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FollowupInstruction\FollowupInstructionRepositoryInterface;

class ForwardFollowupInstructionRepository implements ForwardFollowupInstructionRepositoryInterface
{
    public function forwardFollowupInstruction(FollowupInstruction $followupInstruction, array $data)
    {
        $forwardedTo = $data['forwarded_to'] ?? [];
        $followupInstruction->forwardedUsers()->sync(
            collect($forwardedTo)->mapWithKeys(function ($receiverId) {
                return [$receiverId => ['forwarded_by' => Auth::id()]];
            })->toArray()
        );

        return $followupInstruction->forwardedUsers;
    }

    public function deleteForwardFollowupInstruction(FollowupInstruction $followupInstruction)
    {
        return ForwardFollowupInstruction::where('followup_instruction_id', $followupInstruction->id);
    }

    public function getForwardFollowupInstruction(FollowupInstruction $followupInstruction)
    {
        return ForwardFollowupInstruction::where('followup_instruction_id', $followupInstruction->id);
    }
}
