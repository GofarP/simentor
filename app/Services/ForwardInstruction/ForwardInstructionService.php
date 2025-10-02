<?php

namespace App\Services\ForwardInstruction;

use App\Models\Instruction;
use App\Repositories\ForwardInstruction\ForwardInstructionRepositoryInterface;

class ForwardInstructionService implements ForwardInstructionServiceInterface
{
    private ForwardInstructionRepositoryInterface $forwardInstructionRepository;

    public function __construct(ForwardInstructionRepositoryInterface $forwardInstructionRepository)
    {
        $this->forwardInstructionRepository = $forwardInstructionRepository;
    }

    public function forwardInstruction(Instruction $instruction, array $data)
    {
        return $this->forwardInstructionRepository->forwardInstruction($instruction, $data);
    }

    public function deleteForwardInstruction(Instruction $instruction): bool
    {
        return $this->forwardInstructionRepository->deleteForwardInstruction($instruction);
    }
}
