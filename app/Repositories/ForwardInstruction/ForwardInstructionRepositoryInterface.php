<?php

namespace App\Repositories\ForwardInstruction;

use App\Enums\MessageType;
use App\Models\Instruction;
use App\Models\ForwardInstruction;

interface ForwardInstructionRepositoryInterface
{
    public function forwardInstruction(Instruction $forwardInstruction, array $data);
    public function deleteForwardInstruction(Instruction $forwardInstruction):bool;
}
