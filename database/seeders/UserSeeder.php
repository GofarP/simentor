<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role; // <-- Import Role

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Kasek
        $kasekUser = User::firstOrCreate(
            ['email' => 'kasek@example.com'],
            [
                'name' => 'kasek',
                'password' => Hash::make('password')
            ]
        );
        // Tetapkan role 'kasek'
        $kasekUser->assignRole('kasek');


        // 2. Buat User Kasubbag
        $kasubbagUser = User::firstOrCreate(
            ['email' => 'kasubbag@example.com'],
            [
                'name' => 'kasubbag',
                'password' => Hash::make('password')
            ]
        );
        // Tetapkan role 'kasubbag'
        $kasubbagUser->assignRole('kasubbag');

        // 3. Buat User Staff (ANDA MENULIS 'kasubbag' DISINI SEBELUMNYA)
        $staffUser = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            [
                'name' => 'staff',
                'password' => Hash::make('password')
            ]
        );
        // Tetapkan role 'staff'
        $staffUser->assignRole('staff'); // <-- INI YANG DIPERBAIKI
    }
}