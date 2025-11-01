<?php
namespace App\Repositories\ForwardInstruction;

use App\Models\Instruction;
use App\Models\ForwardInstruction;
use Illuminate\Database\Eloquent\Builder;



class ForwardInstructionRepository implements ForwardInstructionRepositoryInterface
{

    public function syncForwardedUsers(Instruction $instruction, array $pivotData)
    {
        return $instruction->forwardedUsers()->sync($pivotData);
    }


    public function deleteByInstructionId(int $instructionId): bool
    {
        return ForwardInstruction::where('instruction_id', $instructionId)->delete();
    }


    public function getQueryByInstructionId(int $instructionId): Builder
    {
        return ForwardInstruction::where('instruction_id', $instructionId);

    }

}