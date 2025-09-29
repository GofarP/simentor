<?php

namespace App\Services\User;

use App\Models\User;

interface UserServiceInterface
{
    public function getAllUser($search = null, int $perPage = 10, bool $eager = false);
    public function storeUser(array $data): User;
    public function editUser(User $permission, array $data): User;
    public function deleteUser(User $permission): bool;
}
