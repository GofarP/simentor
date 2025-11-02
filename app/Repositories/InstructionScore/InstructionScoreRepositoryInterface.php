<?php

namespace App\Repositories\InstructionScore; // Sesuaikan namespace

use App\Models\InstructionScore;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface InstructionScoreRepositoryInterface
{

    public function query(): Builder;


    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;


    public function store(array $data): InstructionScore;


    public function update(InstructionScore $instructionScore, array $data): bool;


    public function delete(InstructionScore $instructionScore): bool;
}