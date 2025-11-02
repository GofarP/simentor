<?php

namespace App\Repositories\User; // Sesuaikan namespace Anda

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class UserRepository implements UserRepositoryInterface
{
    public function query(): Builder
    {
        return User::query();
    }

    public function paginate(Builder $query, int $perPage): LengthAwarePaginator
    {
        return $query->orderByDesc('created_at')
                     ->paginate($perPage)
                     ->onEachSide(1);
    }

    public function get(Builder $query): Collection
    {
        return $query->orderByDesc('created_at')->get();
    }

    public function create(array $data): User
    {
        // Hanya create. Hashing password dilakukan di Service.
        return User::create($data);
    }

    public function update(User $user, array $data): bool
    {
        // Hanya update. Hashing password dilakukan di Service.
        return $user->update($data);
    }

    public function delete(User $user): bool
    {
       // Hanya delete. Sync roles dilakukan di Service.
       return $user->delete();
    }

    public function assignRole(User $user, Role $role): void
    {
        $user->assignRole($role);
    }

    public function syncRoles(User $user, array $roleNames): void
    {
        $user->syncRoles($roleNames);
    }

    public function getWhereNotId(int $userId): Collection
    {
        // Repo "bodoh" ini menerima ID dari Service
        return User::where('id', '!=', $userId)->get();
    }
}
