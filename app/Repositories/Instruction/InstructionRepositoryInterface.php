<?php

namespace App\Repositories\Instruction;

use App\Models\Instruction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface InstructionRepositoryInterface
{
   
    public function query(): Builder;

   
    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;

    public function getInstructionById(int $instructionId): ?Instruction;


    public function create(array $data): Instruction;


    public function update(Instruction $instruction, array $data): bool;


    public function delete(Instruction $instruction): bool;


    public function syncReceivers(Instruction $instruction, array $pivotData): void;
}