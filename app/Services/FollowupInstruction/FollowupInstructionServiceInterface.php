<?php

namespace App\Services\FollowupInstruction; // Sesuaikan namespace Anda

use App\Enums\MessageType;
use App\Models\FollowupInstruction;
use Illuminate\Pagination\LengthAwarePaginator;

interface FollowupInstructionServiceInterface
{

    public function getAll(?int $instructionId, ?string $search, MessageType $messageType, int $perPage, bool $eager): LengthAwarePaginator;


    public function storeFollowupInstruction(array $data): FollowupInstruction;


    public function editFollowupInstruction(FollowupInstruction $followupInstruction, array $data): bool;


    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction): bool;
}
