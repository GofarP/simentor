<?php

namespace App\Repositories\ForwardInstruction;

use App\Enums\MessageType;
use App\Models\ForwardCoordination;
use App\Models\ForwardInstruction;
use App\Models\Instruction;
use App\Repositories\ForwardCoordination\ForwardCoordinationRepositoryInterface;
use App\Repositories\ForwardInstruction\ForwardInstructionRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ForwardInstructionRepository implements ForwardInstructionRepositoryInterface
{
    public function forwardInstruction(Instruction $instruction, array $data)
    {
        $forwardedTo = $data['forwarded_to'] ?? [];

        $instruction->forwardedUsers()->sync(
            collect($forwardedTo)->mapWithKeys(function ($receiverId) {
                return [$receiverId => ['forwarded_by' => Auth::id()]];
            })->toArray()
        );

        return $instruction->forwardedUsers;
    }

    public function deleteForwardInstruction(Instruction $instruction): bool
    {
        return ForwardInstruction::where('instruction_id', $instruction->id)->delete();
    }


    public function getForwardInstruction(Instruction $instruction)
    {
        return ForwardInstruction::where('instruction_id', $instruction->id);
    }
}
