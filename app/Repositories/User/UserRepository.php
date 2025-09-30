<?php

namespace App\Repositories\User;

use App\Models\User;
use Illuminate\Support\Collection;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserRepositoryInterface
{
    public function getAll(?string $search = '', int $perPage = 10, bool $eager = false)
    {
        $query = User::with('roles');
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('telp', 'like', '%' . $search . '%');
            })
            ->orWhereHas('roles', function ($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
            });
        }


        $query->orderByDesc('created_at');

        if ($eager) {
            return $query->get();
        }

        return $query->paginate($perPage)->onEachSide(1);
    }


    public function storeUser(array $data)
    {
        // Simpan user
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'telp' => $data['telp'] ?? null,
        ]);

        // Assign role
        if (!empty($data['role_id'])) {
            $role = Role::find($data['role_id']);
            if ($role) {
                $user->assignRole($role);
            }
        }

        return $user;
    }


    public function editUser(User $user, array $data): User
    {
        // Jika password kosong, jangan update
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);

        // Sinkronisasi role
        if (!empty($data['role_id'])) {
            $role = Role::find($data['role_id']);
            if ($role) {
                $user->syncRoles([$role->name]);
            }
        }

        return $user;
    }

    public function deleteUser(User $user): bool
    {
        $user->syncRoles([]);
        $user->delete();
        return true;
    }

    public function getPenerima()
    {
        return User::where('id','!=',Auth::user()->id)->get();
    }
}
