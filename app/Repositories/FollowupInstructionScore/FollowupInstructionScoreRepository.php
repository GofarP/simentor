<?php

namespace App\Repositories\FollowupInstructionScore;

use Illuminate\Support\Arr;
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
        return FollowupInstructionScore::create($data);
    }


    public function editFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore, array $data) {
        $allowedFields=['user_id','score','comment'];
        $filteredFields=Arr::only($data, $allowedFields);
        return $followupInstructionScore->update($filteredFields);
    }
    

    public function deleteFollowupInstructionScore(FollowupInstructionScore $followupInstructionScore) {
        return $followupInstructionScore->delete();
    }
}
