<?php
namespace App\Services\FollowupInstruction;
use App\Models\FollowupInstruction;
use App\Repositories\FollowupInstruction\FollowupInstructionRepositoryInterface;

class FollowupInstructionService implements FollowupInstructionServiceInterface
{
    private FollowupInstructionRepositoryInterface $followupInstructionRepository;
    public function __construct(FollowupInstructionRepositoryInterface $followupInstructionRepository) {
        $this->var = $followupInstructionRepository;
    }

    public function getAll(?string $search = null, int $perPage, bool $eager = false){
    }

    public function storeFollowupInstruction(array $data){

    }

    public function editFollowupInstruction(FollowupInstruction $followupInstruction, array $data){

    }

    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction){

    }
}