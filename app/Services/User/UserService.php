<?php

namespace App\Services\User;

use App\Repositories\User\UserRepositoryInterface;
use App\Models\User;

class UserService implements UserServiceInterface
{
    protected UserRepositoryInterface $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUser($search = null, int $perPage = 10, bool $eager = false)
    {
        return $this->userRepository->getAll($search, $perPage, $eager);
    }

    public function storeUser(array $data):User{
        return $this->userRepository->storeUser($data);
    }

    public function editUser(User $user, array $data):User{
        return $this->userRepository->editUser($user, $data);
    }

    public function deleteUser(User $user):bool{
        return $this->userRepository->deleteUser($user);
    }

    public function getPenerima(){
        return $this->userRepository->getPenerima();
    }
}
