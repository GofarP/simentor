<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleUserPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $modules = [
            'instruction' => ['view', 'create', 'show', 'edit', 'delete'],
            'coordination' => ['view', 'create', 'show', 'edit', 'delete'],
            'followup-coordination' => ['view', 'create', 'show', 'edit', 'delete'],
            'followup-instruction' => ['view', 'create', 'show', 'edit', 'delete'],
            'followup-instruction-score' => ['view', 'create', 'show', 'edit', 'delete'],
            'forward-coordination' => ['showform', 'submit'],
            'forward-followup-coordination' => ['showform', 'submit'],
            'forward-followup-instruction' => ['showform', 'submit'],
            'forward-instruction' => ['showform', 'submit'],
            'permission' => ['view', 'create', 'edit', 'delete'],
            'role' => ['view', 'create', 'edit', 'delete'],
            'user' => ['view', 'create', 'edit', 'delete', 'fetch'],
            'instruction-score' => ['view', 'create', 'show', 'edit']
        ];

        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {

                $permissionName = $action . '.' . $module;

                Permission::firstOrCreate([
                    'name' => $permissionName,
                    'guard_name' => 'web'
                ]);
            }
        }
        $this->command->info('Permissions created successfully (Format: action.module).');

        // 3. Buat Roles (kasek, kasubbag, staff)
        Role::firstOrCreate(['name' => 'kasek', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'kasubbag', 'guard_name' => 'web']);
        Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);
        $this->command->info('Roles (kasek, kasubbag, staff) created successfully.');

        // 4. Berikan Semua Permission ke Semua Role
        $allPermissions = Permission::pluck('name');
        $allRoles = Role::all();

        foreach ($allRoles as $role) {
            $role->givePermissionTo($allPermissions);
        }

        $this->command->info('All permissions have been assigned to all roles.');
    }
}