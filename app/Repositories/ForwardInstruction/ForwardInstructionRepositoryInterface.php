<?php

namespace App\Repositories\ForwardInstruction;

use App\Models\Instruction;

interface ForwardInstructionRepositoryInterface
{
    public function forwardInstruction(Instruction $instruction, array $data);
    public function deleteForwardInstruction(Instruction $instruction):bool;

    public function getForwardInstruction(Instruction $instruction);
}
