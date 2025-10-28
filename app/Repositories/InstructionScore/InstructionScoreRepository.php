<?php

namespace App\Repositories\FollowupInstructionScore;

use Illuminate\Support\Arr;
use App\Models\InstructionScore;
use App\Repositories\InstructionScore\InstructionScoreRepositoryInterface;

class InstructionScoreRepository implements InstructionScoreRepositoryInterface
{
    public function getAllInstructionStore(?string $search = null, int $id, int $perPage = 10)
    {
        return InstructionScore::with('instruction')
            ->whereHas('instruction', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->orderByDesc('created_at')
            ->paginate(10);
    }

    public function storeInstructionScore(array $data) {
        return InstructionScore::create($data);
    }


    public function editInstructionScore(InstructionScore $instructionScore, array $data) {
        $allowedFields=['user_id','score','comment'];
        $filteredFields=Arr::only($data, $allowedFields);
        return $instructionScore->update($filteredFields);
    }
    

    public function deleteInstructionScore(InstructionScore $instructionScore) {
        return $instructionScore->delete();
    }
}
