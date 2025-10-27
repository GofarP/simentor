<?php

namespace App\Services\FollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;

interface FollowupCoordinationServiceInterface
{
    public function getAll(int $coordinationId, ?string $search = null, MessageType $messageType, int $perPage, bool $eager = false);
    public function storeFollowupCoordination(array $data);
    public function editFollowupCoordination(FollowupCoordination $followupCoordination, array $data);
    public function deleteFollowupCoordination(FollowupCoordination $followupCoordination);
}
