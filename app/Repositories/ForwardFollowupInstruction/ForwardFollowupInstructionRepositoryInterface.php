<?php
namespace App\Repositories\ForwardFollowupInstruction;

use App\Enums\MessageType;
use App\Models\ForwardFollowupInstruction;
use App\Models\FollowupInstruction;

interface ForwardFollowupInstructionRepositoryInterface{
    public function forwardFollowupInstruction(FollowupInstruction $followupInstruction);
    public function deleteForwardFollowupInstruction(FollowupInstruction $followupInstruction);
    public function getForwardFollowupInstruction(FollowupInstruction $followupInstruction);
}
