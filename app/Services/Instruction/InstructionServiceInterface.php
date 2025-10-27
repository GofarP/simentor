<?php
namespace App\Services\Instruction;

use App\Enums\MessageType;
use App\Models\Instruction;

interface InstructionServiceInterface
{
    public function getAllInstruction($search=null, int $perPage=10,MessageType $messageType, bool $eager=false);
    public function getInstructionsWithFollowupCounts(?string $search = '', int $perPage = 10);
    public function storeInstruction(array $data):Instruction;
    public function editInstruction(Instruction $instruction, array $data):Instruction;
    public function deleteInstruction(Instruction $instruction):bool;
    public function getSenderIdByInstruction(int $instructionId):?int;

}