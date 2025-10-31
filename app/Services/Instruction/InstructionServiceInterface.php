<?php
namespace App\Services\Instruction;

use App\Enums\MessageType;
use App\Models\Instruction;
use Illuminate\Pagination\LengthAwarePaginator;

interface InstructionServiceInterface
{
    public function getAllInstructions(?string $search, int $perPage, MessageType $messageType, bool $eager): LengthAwarePaginator;
    public function getInstructionsWithFollowupCounts(?string $search, int $perPage): LengthAwarePaginator;
    public function storeInstruction(array $data): Instruction;
    public function updateInstruction(Instruction $instruction, array $data): Instruction;
    public function deleteInstruction(Instruction $instruction): bool;
}