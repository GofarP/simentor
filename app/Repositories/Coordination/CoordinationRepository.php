<?php
namespace App\Repositories\Coordination;
use App\Enums\MessageType;
use App\Models\Coordination;
use App\Models\ForwardInstruction;
use App\Models\Instruction;
use App\Repositories\Instruction\CoordinationRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CoordinationRepository implements CoordinationRepositoryInterface{
    public function getAll(?string $search = null, int $perPage = 10, MessageType $coordinationType, bool $eager = false)
    {

    }

    public function storeCoordination(array $data)
    {

    }


    public function editCoordination(Coordination $coordination, array $data)
    {

    }

    public function deleteCoordination(Coordination $coordination): bool
    {
        return false;
    }

    public function forwarCoordination(Coordination $coordination, array $data)
    {

    }
}
