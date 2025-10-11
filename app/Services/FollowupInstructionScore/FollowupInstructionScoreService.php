<?php
namespace App\Services\FollowupInstructionScore;

use App\Enums\MessageType;
use App\Models\FollowupInstructionScore;
use App\Repositories\FollowupInstructionScore\FollowupInstructionRepositoryInterface;
use App\Repositories\FollowupInstructionScore\FollowupInstructionScoreRepositoryInterface;
use App\Services\FollowupInstructionScore\FollowupInstructionServiceInterface;

class FollowupInstructionScoreService implements FollowupInstructionScoreServiceInterface{

    private FollowupInstructionScoreRepositoryInterface $followupInstructionScoreRepository;

    public function __construct(FollowupInstructionScoreRepositoryInterface $followupInstructionScoreRepository) {
        $this->followupInstructionScoreRepository = $followupInstructionScoreRepository;
    }

    public function getAllFollowupInstructionStore(?string $search = null, int $id, int $perPage = 10)
    {
        return $this->followupInstructionScoreRepository->getAllFollowupInstructionStore($search, $id, $perPage);
    }

    public function storeFollowupInstructionScore(array $data)
    {
        return $this->followupInstructionScoreRepository->storeFollowupInstructionScore($data);
    }

    public function editFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore, array $data)
    {
        return $this->followupInstructionScoreRepository->editFollowupInstructionScore($followupInstructionScore, $data);
    }

    public function deleteFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore)
    {
        return $this->followupInstructionScoreRepository->deleteFollowupInstructionScore($followupInstructionScore);
    }
}