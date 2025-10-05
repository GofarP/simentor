<?php
namespace App\Repositories\FollowupInstruction;

use App\Enums\MessageType;
use App\Models\FollowupInstruction;

interface FollowupInstructionRepositoryInterface{
    public function getAll(? string $search=null, int $perPage=10,MessageType $messageType ,bool $eager=false);

    public function storeFollowupInstruction(array $data);

    public function editFollowupInstruction(FollowupInstruction $followupInstruction,array $data);

    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction):bool;
}

