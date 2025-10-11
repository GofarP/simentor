<?php

namespace App\Repositories\FollowupInstructionScore;

use App\Models\FollowupInstruction;
use App\Models\FollowupInstructionScore;

interface FollowupInstructionScoreRepositoryInterface{
    public function getAllFollowupInstructionStore(?string $search=null,int $id, int $perPage=10,);
    public function storeFollowupInstructionScore(array $data);
    public function editFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore, array $data);
    public function deleteFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore);
}