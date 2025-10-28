<?php
namespace App\Services\InstructionScore;

use App\Models\InstructionScore;
use App\Repositories\InstructionScore\InstructionScoreRepositoryInterface;

class InstructionScoreService implements InstructionScoreServiceInterface{

    private InstructionScoreRepositoryInterface $instructionScoreRepository;

    public function __construct(InstructionScoreRepositoryInterface $instructionScoreRepository) {
        $this->instructionScoreRepository = $instructionScoreRepository;
    }

    public function getAllInstructionScore(?string $search = null, int $id, int $perPage = 10)
    {
        return $this->instructionScoreRepository->getAllInstructionStore($search, $id, $perPage);
    }

    public function storeInstructionScore(array $data)
    {
        return $this->instructionScoreRepository->storeInstructionScore($data);
    }

    public function editInstructionScore(InstructionScore $instructionScore, array $data)
    {
        return $this->instructionScoreRepository->editInstructionScore($instructionScore, $data);
    }

    public function deleteInstructionScore(InstructionScore $instructionScore)
    {
        return $this->instructionScoreRepository->deleteInstructionScore($instructionScore);
    }
}