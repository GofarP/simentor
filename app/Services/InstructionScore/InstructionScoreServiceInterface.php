<?php
namespace App\Services\InstructionScore;

use App\Models\Instruction;
use App\Models\InstructionScore;


interface InstructionScoreServiceInterface{
    public function getAllInstructionScore($search=null, int $perPage=10, bool $eager=false);
    public function storeInstructionScore(array $data);

    public function editInstructionScore(InstructionScore $instructionScore,array $data);

    public function deleteInstructionScore(InstructionScore $instructionScore);

}