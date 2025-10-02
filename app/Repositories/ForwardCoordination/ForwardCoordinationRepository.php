<?php

namespace App\Repositories\Instruction;

use App\Enums\MessageType;
use App\Models\ForwardCoordination;
use App\Models\ForwardInstruction;
use App\Models\Instruction;
use App\Repositories\ForwardCoordination\ForwardCoordinationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InstructionRepository implements ForwardCoordinationRepositoryInterface
{
    public function forwardCoordination(ForwardCoordination $coordination, array $data)
    {

    }

    public function deleteForwardCoordination(ForwardCoordination $forwardCoordination): bool
    {
        return false;
    }
}