<?php

namespace App\Repositories\Instruction;

use App\Enums\InstructionType;
use App\Models\Coordination;

interface CoordinationRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10, InstructionType $coordinationType, bool $eager = false);
    public function storeCoordination(array $data);
    public function editCoordination(Coordination $coordination, array $data);
    public function deleteCoordination(Coordination $coordination): bool;
    public function forwarCoordination(Coordination $coordination, array $data);
}
