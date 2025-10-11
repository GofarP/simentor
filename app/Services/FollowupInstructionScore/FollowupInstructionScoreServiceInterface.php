<?php
namespace App\Services\FollowupInstructionScore;

use App\Models\FollowupInstructionScore;

interface FollowupInstructionScoreServiceInterface{
    public function getAllFollowupInstructionStore(?string $search = null, int $id, int $perPage = 10);
    public function storeFollowupInstructionScore(array $data);
    public function editFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore, array $data);
    public function deleteFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore);
}