<?php

namespace App\Repositories\Instruction;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class InstructionRepository implements InstructionRepositoryInterface
{
    public function query(): Builder
    {
        return Instruction::query();
    }

    public function paginate(Builder $query, int $perPage): LengthAwarePaginator
    {
        return $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->onEachSide(1);
    }
    
    public function getInstructionById(int $instructionId): ?Instruction
    {
        return Instruction::find($instructionId);
    }

    public function create(array $data): Instruction
    {
        return Instruction::create($data);
    }

    public function update(Instruction $instruction, array $data): bool
    {
        return $instruction->update($data);
    }

    public function delete(Instruction $instruction): bool
    {
        // Hanya delete. Tidak ada logika file di sini.
        return $instruction->delete();
    }

    public function syncReceivers(Instruction $instruction, array $pivotData): void
    {
        $instruction->receivers()->sync($pivotData);
    }
}