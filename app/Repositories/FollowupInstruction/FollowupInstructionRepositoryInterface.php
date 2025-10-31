<?php

namespace App\Repositories\FollowupInstruction; // Sesuaikan namespace Anda

use App\Models\FollowupInstruction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface FollowupInstructionRepositoryInterface
{
    
    public function query(): Builder;

    
    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;
    
    
    public function storeFollowupInstruction(array $data): FollowupInstruction;

    
    public function editFollowupInstruction(FollowupInstruction $followupInstruction, array $data): bool;

    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction): bool;
}