<?php

namespace App\Repositories\InstructionScore;

use App\Models\InstructionScore;

interface InstructionScoreRepositoryInterface{
    public function getAllInstructionStore(?string $search=null,int $id, int $perPage=10,);
    public function storeInstructionScore(array $data);
    public function editInstructionScore(InstructionScore $InstructionScore, array $data);
    public function deleteInstructionScore(InstructionScore $InstructionScore);
}