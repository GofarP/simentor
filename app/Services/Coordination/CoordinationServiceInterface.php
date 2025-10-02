<?php

namespace App\Services\Coordination;

use App\Enums\MessageType;
use App\Models\Coordination;

interface CoordinationServiceInterface
{
    public function getAllCoordination($search = null, int $perPage = 10, MessageType $messageType, bool $eager = false);
    public function storeCoordination(array $data): Coordination;
    public function editCoordination(Coordination $coordination, array $data): Coordination;
    public function deleteCoordination(Coordination $coordination): bool;
    public function forwardCoordination(Coordination $coordination, array $data);
}
