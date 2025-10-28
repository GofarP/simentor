<?php
namespace App\Services\InstructionScore;

use App\Models\InstructionScore;

interface InstructionScoreServiceInterface{
    public function getAllInstructionScore(?string $search = null, int $id, int $perPage = 10);
    public function storeInstructionScore(array $data);
    public function editInstructionScore(InstructionScore $instructionScore, array $data);
    public function deleteInstructionScore(InstructionScore $instructionScore);
}