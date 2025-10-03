<?php
namespace App\Repositories\FollowupInstruction;

use App\Enums\MessageType;

interface FollowupInstructionRepositoryInterface{
    public function getAll(? string $search=null, int $perPage=10,MessageType $messageType ,bool $eager=false);
    public function storeFollowupInstruction(array $data);

    public function editFollowupInstruction(array $data);

    public function deleteFollowupInstruction(array $data):bool;
}

