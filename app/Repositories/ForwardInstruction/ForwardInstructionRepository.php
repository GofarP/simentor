<?php
namespace App\Repositories\ForwardInstruction;

use App\Models\Instruction;
use App\Models\ForwardInstruction;
use Illuminate\Database\Eloquent\Builder;

class ForwardInstructionRepository implements ForwardInstructionRepositoryInterface
{
    /**
     * Method "Bodoh": Hanya tahu cara sync.
     */
    public function syncForwardedUsers(Instruction $instruction, array $pivotData)
    {
        // Logika sync dipindahkan ke sini
        return $instruction->forwardedUsers()->sync($pivotData);
    }

    /**
     * Method "Bodoh": Hanya tahu cara delete.
     */
    public function deleteByInstructionId(int $instructionId): bool
    {
        return ForwardInstruction::where('instruction_id', $instructionId)->delete();
    }

    /**
     * Method "Bodoh": Hanya tahu cara get query.
     */
    public function getQueryByInstructionId(int $instructionId): Builder
    {
        return ForwardInstruction::where('instruction_id', $instructionId);
    }
}