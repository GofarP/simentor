<?php
namespace App\Services\Instruction;

use App\Enums\InstructionType;
use App\Models\Instruction;

interface InstructionServiceInterface
{
    public function getAllInstruction($search=null, int $perPage=10,InstructionType $messageType, bool $eager=false);
    public function storeInstruction(array $data):Instruction;
    public function editInstruction(Instruction $instruction, array $data):Instruction;
    public function deleteInstruction(Instruction $instruction):bool;
    public function forwardInstruction(Instruction $instruction, array $data);
}