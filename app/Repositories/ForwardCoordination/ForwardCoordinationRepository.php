<?php

namespace App\Repositories\Instruction;

use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\ForwardCoordination;
use App\Models\ForwardInstruction;
use App\Models\Instruction;
use App\Repositories\ForwardCoordination\ForwardCoordinationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructionRepository implements ForwardCoordinationRepositoryInterface
{
    public function forwardCoordination(Coordination $coordination, array $data)
    {
        $forwardedRecords = [];

        foreach ($data['forwarded_to'] as $receiverId) {
            $forwardedRecords[] = ForwardCoordination::create([
                'coordination_id' => $coordination->id,
                'forwarded_by' => Auth::id(),
                'forwarded_to' => $receiverId,
            ]);
        }

        return $forwardedRecords;
    }

    public function deleteForwardCoordination(Coordination $coordination): bool
    {
        return ForwardCoordination::where('coordination_id', $coordination->id)->delete();
    }
}
