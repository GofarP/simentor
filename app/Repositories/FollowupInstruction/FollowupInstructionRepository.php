<?php

namespace App\Repositories\FollowupInstruction; // Sesuaikan namespace Anda

use App\Models\FollowupInstruction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class FollowupInstructionRepository implements FollowupInstructionRepositoryInterface
{
    
    public function query(): Builder
    {
        return FollowupInstruction::query();
    }

    
    public function paginate(Builder $query, int $perPage): LengthAwarePaginator
    {
        return $query->orderByDesc('created_at')
                     ->paginate($perPage)
                     ->onEachSide(1);
    }
    
  
    public function storeFollowupInstruction(array $data): FollowupInstruction
    {
        return FollowupInstruction::create($data);
    }

    
    public function editFollowupInstruction(FollowupInstruction $followupInstruction, array $data): bool
    {
        return $followupInstruction->update($data);
    }

  
    public function deleteFollowupInstruction(FollowupInstruction $followupInstruction): bool
    {
       return $followupInstruction->delete();
    }
}