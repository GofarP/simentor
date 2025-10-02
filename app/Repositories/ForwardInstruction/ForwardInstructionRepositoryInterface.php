<?php

namespace App\Repositories\ForwardInstruction;

use App\Models\Instruction;

interface ForwardInstructionRepositoryInterface
{
    public function forwardInstruction(Instruction $forwardInstruction, array $data);
    public function deleteForwardInstruction(Instruction $forwardInstruction):bool;
}
