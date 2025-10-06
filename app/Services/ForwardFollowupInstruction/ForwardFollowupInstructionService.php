<?php
namespace App\Services\ForwardFollowupInstruction;

use App\Models\FollowupInstruction;
use App\Repositories\ForwardFollowupInstruction\ForwardFollowupInstructionRepository;

class ForwardFollowupInstructionService implements ForwardFollowupInstructionServiceInterface
{

    private ForwardFollowupInstructionRepository $forwardFollowupInstruction;

    public function __construct(ForwardFollowupInstructionRepository $forwardFollowupInstruction)
    {
        $this->forwardFollowupInstruction = $forwardFollowupInstruction;
    }

    public function forwardFollowupInstruction(FollowupInstruction $followupInstruction, array $data)
    {
        return $this->forwardFollowupInstruction->forwardFollowupInstruction($followupInstruction, $data);
    }

    public function deleteForwardFollowupInstruction(FollowupInstruction $followupInstruction)
    {
        return $this->forwardFollowupInstruction->deleteForwardFollowupInstruction($followupInstruction);
    }

    public function getForwardFollowupInstruction(FollowupInstruction $followupInstruction)
    {
        return $this->forwardFollowupInstruction->getForwardFollowupInstruction($followupInstruction);
    }

}