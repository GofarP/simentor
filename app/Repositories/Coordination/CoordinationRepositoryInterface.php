<?php

namespace App\Repositories\Coordination;

use App\Enums\MessageType;
use App\Models\Coordination;

interface CoordinationRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10, MessageType $messageType, bool $eager = false);
    public function storeCoordination(array $data);
    public function editCoordination(Coordination $coordination, array $data);
    public function deleteCoordination(Coordination $coordination): bool;
    public function getSenderIdByCoordination(int $id):int;
}
