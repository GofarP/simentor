<?php
namespace App\Repositories\FollowupInstruction;

class FollowupInstructionRepository implements FollowupInstructionRepositoryInterface{
    public function getAll(string|null $search = null, int $perPage = 10, bool $eager = false){

    }


    public function storeFollowupInstruction(array $data){

    }

    public function editFollowupInstruction(array $data){

    }


    public function deleteFollowupInstruction(array $data): bool{
        return false;
    }
}
