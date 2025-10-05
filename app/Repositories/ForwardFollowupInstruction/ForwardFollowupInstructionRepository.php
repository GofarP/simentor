<?php

namespace App\Repositories\ForwardFollowupInstruction;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use App\Models\ForwardFollowupInstruction;
use Illuminate\Support\Facades\Auth;
use App\Repositories\FollowupInstruction\FollowupInstructionRepositoryInterface;

class ForwardFollowupInstructionRepository implements ForwardFollowupInstructionRepositoryInterface
{
    public function forwardFollowupInstruction(FollowupInstruction $followupInstruction) {

    }

    public function deleteForwardFollowupInstruction(FollowupInstruction $followupInstruction)
    {
        return false;
    }

    public function getForwardFollowupInstruction(FollowupInstruction $followupInstruction) {

    }
}
