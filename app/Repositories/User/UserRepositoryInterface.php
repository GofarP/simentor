<?php

namespace App\Repositories\User; // Sesuaikan namespace Anda

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Mengambil query builder dasar untuk model.
     */
    public function query(): Builder;

    /**
     * Menjalankan paginasi pada query yang sudah jadi.
     */
    public function paginate(Builder $query, int $perPage): LengthAwarePaginator;

    /**
     * Menjalankan 'get' pada query yang sudah jadi.
     */
    public function get(Builder $query): Collection;

    /**
     * Menyimpan data user baru (hanya data user).
     */
    public function create(array $data): User;

    /**
     * Mengupdate data user (hanya data user).
     */
    public function update(User $user, array $data): bool;

    /**
     * Menghapus data user.
     */
    public function delete(User $user): bool;

    /**
     * Menetapkan role ke user.
     */
    public function assignRole(User $user, Role $role): void;

    /**
     * Sinkronisasi role ke user (menggunakan nama).
     */
    public function syncRoles(User $user, array $roleNames): void;

    /**
     * Mengambil semua user KECUALI satu ID.
     */
    public function getWhereNotId(int $userId): Collection;
}