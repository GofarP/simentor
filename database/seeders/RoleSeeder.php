<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // <-- Jangan lupa import model Role

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Daftar roles yang ingin dibuat
        $roles = [
            ['name' => 'kasek', 'guard_name' => 'web'],
            ['name' => 'kasubbag', 'guard_name' => 'web'],
            ['name' => 'staff', 'guard_name' => 'web'],
        ];

        // Looping dan buat roles
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}