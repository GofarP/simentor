<?php

namespace App\Services\InstructionScore; // Sesuaikan namespace Anda

use App\Models\InstructionScore;
use Illuminate\Pagination\LengthAwarePaginator;

interface InstructionScoreServiceInterface
{

    public function getAllInstructionScores(?string $search, int $instructionId, int $perPage): LengthAwarePaginator;


    public function storeInstructionScore(array $data): InstructionScore;


    public function editInstructionScore(InstructionScore $instructionScore, array $data): bool;


    public function deleteInstructionScore(InstructionScore $instructionScore): bool;
}