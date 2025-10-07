<?php
namespace App\Repositories\InstructionScore;

use App\Enums\MessageType;
use App\Models\InstructionScore;


interface InstructionScoreRepositoryInterface{
    public function getAll(? string $search=null, int $perPage=10, bool $eager=false);
    public function storeInstructionScore(array $data);
    public function editInstructionScore(InstructionScore $instructionScore,array $data);

    public function deleteInstructionScore(InstructionScore $instructionScore);
}