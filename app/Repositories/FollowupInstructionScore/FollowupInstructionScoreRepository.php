<?php

namespace App\Repositories\FollowupInstructionScore;

use App\Models\FollowupInstruction;
use App\Models\FollowupInstructionScore;

class FollowupInstructionScoreRepository implements FollowupInstructionScoreRepositoryInterface
{
    public function getAllFollowupInstructionStore(?string $search = null, int $id, int $perPage = 10)
    {
        return FollowupInstructionScore::with('followupInstruction')
            ->whereHas('followupInstruction', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function storeFollowupInstructionScore(array $data) {
        return FollowupInstructionScore::store($data);
    }


    public function editFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore, array $data) {
        return $followupInstructionScore->update($data);
    }

    public function deleteFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore) {
        return $followupInstructionScore->delete();
    }
}
