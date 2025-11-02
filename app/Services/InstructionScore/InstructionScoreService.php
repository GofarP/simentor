<?php

namespace App\Services\InstructionScore; // Sesuaikan namespace Anda

use App\Models\InstructionScore;
use App\Repositories\InstructionScore\InstructionScoreRepositoryInterface; // Import Repo
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class InstructionScoreService implements InstructionScoreServiceInterface
{
    protected $instructionScoreRepository;

    public function __construct(InstructionScoreRepositoryInterface $instructionScoreRepository)
    {
        $this->instructionScoreRepository = $instructionScoreRepository;
    }


    public function getAllInstructionScores(?string $search, int $instructionId, int $perPage): LengthAwarePaginator
    {
        $query = $this->instructionScoreRepository->query();

        $query->where('instruction_id', $instructionId);

        // 3. Terapkan logika Search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('comment', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($sub) => $sub->where('name', 'like', "%{$search}%"));
            });
        }

        return $this->instructionScoreRepository->paginate($query, $perPage);
    }


    public function storeInstructionScore(array $data): InstructionScore
    {
        $data['user_id'] = Auth::id();

        return $this->instructionScoreRepository->store($data);
    }


    public function editInstructionScore(InstructionScore $instructionScore, array $data): bool
    {
        return $this->instructionScoreRepository->update($instructionScore, $data);
    }


    public function deleteInstructionScore(InstructionScore $instructionScore): bool
    {
        return $this->instructionScoreRepository->delete($instructionScore);
    }
}