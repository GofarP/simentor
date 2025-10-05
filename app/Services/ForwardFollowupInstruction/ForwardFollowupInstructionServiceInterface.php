<?php
namespace App\Services\ForwardFollowupInstruction;

use App\Models\FollowupInstruction;

interface ForwardFollowupInstructionServiceInterface{
    public function forwardFollowupInstruction(FollowupInstruction $followupInstruction);
    public function deleteForwardFollowupInstruction(FollowupInstruction $followupInstruction);
    public function getForwardFollowupInstruction(FollowupInstruction $followupInstruction);
}
