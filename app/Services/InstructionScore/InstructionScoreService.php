<?php
use App\Repositories\InstructionScore\InstructionScoreRepositoryInterface;
use App\Services\InstructionScore\InstructionScoreServiceInterface;
use App\Models\InstructionScore;

class InstructionScoreService implements InstructionScoreServiceInterface{
    private InstructionScoreRepositoryInterface $instructionScoreRepository;

    public function __construct(InstructionScoreRepositoryInterface $instructionScoreRepository) {
        $this->instructionScoreRepository = $instructionScoreRepository;
    }

    public function getAllInstructionScore($search = null, int $perPage = 10, bool $eager = false){
        return $this->instructionScoreRepository->getAll($search, $perPage, $eager);
    }

    public function storeInstructionScore(array $data){
        return $this->instructionScoreRepository->storeInstructionScore($data);
    }

    public function editInstructionScore(InstructionScore $instructionScore, array $data){
        return $this->instructionScoreRepository->editInstructionScore($instructionScore, $data);
    }

    public function deleteInstructionScore(InstructionScore $instructionScore){
        return $this->instructionScoreRepository->deleteInstructionScore($instructionScore);
    }

}