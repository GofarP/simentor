<?php

namespace App\Services\User;

use App\Models\User;
use App\Repositories\User\UserRepositoryInterface;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class UserService implements UserServiceInterface
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function getAllUsers(?string $search = '', int $perPage = 10, bool $eager = false)
    {
        $query = $this->userRepository->query()->with('roles');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('telp', 'like', '%' . $search . '%');
            })
            ->orWhereHas('roles', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
            });
        }

        if ($eager) {
            return $this->userRepository->get($query);
        }

        return $this->userRepository->paginate($query, $perPage);
    }


    public function storeUser(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $data['password'] = Hash::make($data['password']);

            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
                'telp' => $data['telp'] ?? null,
            ]);

            if (!empty($data['role_id'])) {
                $role = Role::find($data['role_id']);
                if ($role) {
                    $this->userRepository->assignRole($user, $role);
                }
            }
            return $user;
        });
    }

    public function editUser(User $user, array $data): User
    {
        return DB::transaction(function () use ($user, $data) {
            if (empty($data['password'])) {
                unset($data['password']);
            } else {
                $data['password'] = Hash::make($data['password']);
            }

            $this->userRepository->update($user, $data);

            if (!empty($data['role_id'])) {
                $role = Role::find($data['role_id']);
                if ($role) {
                    $this->userRepository->syncRoles($user, [$role->name]);
                }
            }

            return $user;
        });
    }


    public function deleteUser(User $user): bool
    {
        return DB::transaction(function () use ($user) {
            // 1. Logika Bisnis (Lepas semua role dulu)
            $this->userRepository->syncRoles($user, []);

            return $this->userRepository->delete($user);
        });
    }


    public function getReceiver(): Collection
    {
        $userId = Auth::id();

        return $this->userRepository->getWhereNotId($userId);
    }
}