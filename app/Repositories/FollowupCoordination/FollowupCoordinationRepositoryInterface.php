<?php
namespace App\Repositories\FollowupCoordination;

use App\Enums\MessageType;
use App\Models\FollowupCoordination;

interface FollowupCoordinationRepositoryInterface{
    public function getAll(int $coordinationId, ?string $search=null, int $perPage=10,MessageType $messageType ,bool $eager=false);

    public function storeFollowupCoordination(array $data);

    public function editFollowupCoordination(FollowupCoordination $followupInstruction,array $data);

    public function deleteFollowupCoordination(FollowupCoordination $followupInstruction):bool;
}

