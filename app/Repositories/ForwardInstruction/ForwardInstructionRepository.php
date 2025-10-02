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
    public function  forwardInstruction(Instruction $instruction, array $data)
    {
        $forwardedRecords = [];

        foreach ($data['forwarded_to'] as $receiverId) {
            $forwardedRecords[] = ForwardInstruction::create([
                'instruction_id' => $instruction->id,
                'forwarded_by' => Auth::id(),
                'forwarded_to' => $receiverId,
            ]);
        }

        return $forwardedRecords;
    }

    public function deleteForwardInstruction(Instruction $instruction): bool
    {
        return ForwardInstruction::where('instruction_id',$instruction->id)->delete();
    }
}
