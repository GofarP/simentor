<?php
namespace App\Repositories\ForwardInstruction;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Builder;

interface ForwardInstructionRepositoryInterface
{

    public function syncForwardedUsers(Instruction $instruction, array $pivotData);


    public function deleteByInstructionId(int $instructionId): bool;


    public function getQueryByInstructionId(int $instructionId): Builder;
}