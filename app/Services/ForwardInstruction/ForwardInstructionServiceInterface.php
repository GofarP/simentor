<?php
namespace App\Services\ForwardInstruction;

use App\Enums\MessageType;
use App\Models\ForwardInstruction;
use App\Models\Instruction;

interface ForwardInstructionServiceInterface
{
    public function forwardInstruction(Instruction $instruction, array $data);

    public function deleteForwardInstruction(Instruction $instruction):bool;
}