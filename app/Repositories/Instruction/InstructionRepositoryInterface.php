<?php
namespace App\Repositories\Instruction;
use App\Enums\MessageType;
use App\Models\Instruction;

interface InstructionRepositoryInterface
{

    public function getAll(? string $search=null, int $perPage=10, MessageType $messageType  ,bool $eager=false);
    
    public function getInstructionsWithFollowupCounts(?string $search = '', int $perPage = 10);

    public function storeInstruction(array $data);

    public function editInstruction(Instruction $instruction, array $data);

    public function deleteInstruction(Instruction $instruction):bool;

    public function getSenderIdByInstruction(int $instructionId):?int;


}
