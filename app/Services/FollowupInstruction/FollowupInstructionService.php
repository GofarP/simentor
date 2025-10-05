<?php

namespace App\Services\FollowupInstruction;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use App\Repositories\FollowupInstruction\FollowupInstructionRepositoryInterface;

class FollowupInstructionService implements FollowupInstructionServiceInterface
{
    private FollowupInstructionRepositoryInterface $followupInstructionRepository;
    public function __construct(FollowupInstructionRepositoryInterface $followupInstructionRepository)
    {
        $this->followupInstructionRepository = $followupInstructionRepository;
    }

    public function getAll(?string $search = null, MessageType $messageType, int $perPage, bool $eager = false)
    {
        return $this->followupInstructionRepository->getAll($search, $perPage, $messageType, false);
    }

    public function storeFollowupInstruction(array $data) {
        return $this->followupInstructionRepository->storeFollowupInstruction($data);
    }

    public function editFollowupInstruction(FollowupInstruction $followupInstruction, array $data) {
        return $this->followupInstructionRepository->editFollowupInstruction($followupInstruction, $data);
    }

    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction) {
        return $this->followupInstructionRepository->deleteFollowupInstruction($followupInstruction);
    }
}
