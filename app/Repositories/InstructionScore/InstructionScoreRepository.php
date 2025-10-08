<?php

namespace App\Repositories\InstructionScore;

use App\Models\InstructionScore;
use Illuminate\Support\Facades\Auth;


class InstructionScoreRepository implements InstructionScoreRepositoryInterface
{
    public function getAll(?string $search = null, int $perPage = 10, bool $eager = false)
    {
        $query = InstructionScore::query();
        if ($eager) {
            $query->with(['instruction', 'user']);
        }

        if (!empty($search)) {
            $query->whereHas('instruction', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            })->orWhereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $query->orderByDesc('created_at');

        // Paginate atau get semua
        return $perPage > 0 ? $query->paginate($perPage)->onEachSide(1) : $query->get();
    }


    public function storeInstructionScore(array $data)
    {
        $data['user_id'] = Auth::id();

        return InstructionScore::firstOrCreate(
            [
                'instruction_id' => $data['instruction_id'],
                'user_id' => $data['user_id'],
            ],
            $data
        );
    }

    public function editInstructionScore(InstructionScore $instructionScore, array $data)
    {
        return $instructionScore->update($data);
    }


    public function deleteInstructionScore(InstructionScore $instructionScore)
    {
        return $instructionScore->delete();
    }
}
