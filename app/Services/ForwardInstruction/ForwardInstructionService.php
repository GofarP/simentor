<?php

namespace App\Services\ForwardInstruction;

use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
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

    public function getForwardInstruction(Instruction $instruction)
    {
        return $this->forwardInstructionRepository->getForwardInstruction($instruction);
    }
}
