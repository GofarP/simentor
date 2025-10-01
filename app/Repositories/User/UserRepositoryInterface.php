<?php
namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;


interface UserRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, bool $eager=false);
    public function storeUser(array $data);
    public function editUser(User $permission, array $data);
    public function deleteUser(User $permission): bool;
    public function getReceiver();

    
}
