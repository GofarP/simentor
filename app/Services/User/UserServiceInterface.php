<?php

namespace App\Services\User; // Sesuaikan namespace Anda

use App\Models\User;
use Illuminate\Support\Collection;

interface UserServiceInterface
{
    /**
     * Mengambil daftar user dengan filter.
     */
    public function getAllUsers(?string $search, int $perPage, bool $eager);

    /**
     * Menjalankan logika bisnis untuk menyimpan user baru.
     */
    public function storeUser(array $data): User;

    /**
     * Menjalankan logika bisnis untuk mengedit user.
     */
    public function editUser(User $user, array $data): User;

    /**
     * Menjalankan logika bisnis untuk menghapus user.
     */
    public function deleteUser(User $user): bool;

    /**
     * Mengambil daftar user penerima (selain diri sendiri).
     */
    public function getReceiver(): Collection;
}