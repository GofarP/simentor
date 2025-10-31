<?php

namespace App\Repositories\Coordination;

use App\Models\Coordination;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

class CoordinationRepository implements CoordinationRepositoryInterface
{
    public function query(): Builder
    {
        return Coordination::query();
    }

    public function paginate(Builder $query, int $perPage): LengthAwarePaginator
    {
        return $query->orderByDesc('created_at')
            ->paginate($perPage)
            ->onEachSide(1);
    }
    
    public function getCoordinationById(int $coordinationId): ?Coordination
    {
        return Coordination::find($coordinationId);
    }

    public function create(array $data): Coordination
    {
        return Coordination::create($data);
    }

    public function update(Coordination $coordination, array $data): bool
    {
        return $coordination->update($data);
    }

    public function delete(Coordination $coordination): bool
    {
        // Hanya delete. Tidak ada logika file di sini.
        return $coordination->delete();
    }

    public function syncReceivers(Coordination $coordination, array $pivotData): void
    {
        $coordination->receivers()->sync($pivotData);
    }
}