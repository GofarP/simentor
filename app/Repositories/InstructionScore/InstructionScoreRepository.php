<?php

namespace App\Repositories\InstructionScore;

use App\Models\InstructionScore;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class InstructionScoreRepository implements InstructionScoreRepositoryInterface
{
    public function query(): Builder
    {
        return InstructionScore::query();
    }

    public function paginate(Builder $query, int $perPage): LengthAwarePaginator
    {
        return $query->orderByDesc('created_at')
                     ->paginate($perPage)
                     ->onEachSide(1);
    }

    public function store(array $data): InstructionScore
    {
        return InstructionScore::create($data);
    }

    public function update(InstructionScore $instructionScore, array $data): bool
    {
        // Hanya update.
        return $instructionScore->update($data);
    }

    public function delete(InstructionScore $instructionScore): bool
    {
       // Hanya delete.
       return $instructionScore->delete();
    }
}