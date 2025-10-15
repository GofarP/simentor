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

        $permissions = [
            ['name' => 'view.role', 'guard_name' => 'web'],
            ['name' => 'create.role', 'guard_name' => 'web'],
            ['name' => 'edit.role', 'guard_name' => 'web'],
            ['name' => 'delete.role', 'guard_name' => 'web'],

            ['name' => 'view.instruction', 'guard_name' => 'web'],
            ['name' => 'create.instruction', 'guard_name' => 'web'],
            ['name' => 'edit.instruction', 'guard_name' => 'web'],
            ['name' => 'show.instruction', 'guard_name' => 'web'],
            ['name' => 'delete.instruction', 'guard_name' => 'web'],
            ['name' => 'fetch.instruction', 'guard_name' => 'web'],

            ['name' => 'view.coordination', 'guard_name' => 'web'],
            ['name' => 'create.coordination', 'guard_name' => 'web'],
            ['name' => 'edit.coordination', 'guard_name' => 'web'],
            ['name' => 'show.coordination', 'guard_name' => 'web'],
            ['name' => 'delete.coordination', 'guard_name' => 'web'],
            ['name' => 'fetch.coordination', 'guard_name' => 'web'],

            ['name' => 'view.followupinstructionscore', 'guard_name' => 'web'],
            ['name' => 'create.followupinstructionscore', 'guard_name' => 'web'],
            ['name' => 'edit.followupinstructionscore', 'guard_name' => 'web'],
            ['name' => 'delete.followupinstructionscore', 'guard_name' => 'web'],

            ['name' => 'view.followupinstruction', 'guard_name' => 'web'],
            ['name' => 'create.followupinstruction', 'guard_name' => 'web'],
            ['name' => 'edit.followupinstruction', 'guard_name' => 'web'],
            ['name' => 'show.followupinstruction', 'guard_name' => 'web'],
            ['name' => 'delete.followupinstruction', 'guard_name' => 'web'],

            ['name' => 'view.followupcoordination', 'guard_name' => 'web'],
            ['name' => 'create.followupcoordination', 'guard_name' => 'web'],
            ['name' => 'edit.followupcoordination', 'guard_name' => 'web'],
            ['name' => 'show.followupcoordination', 'guard_name' => 'web'],
            ['name' => 'delete.followupcoordination', 'guard_name' => 'web'],

            ['name' => 'showform.forwardinstruction', 'guard_name' => 'web'],
            ['name' => 'submit.forwardinstruction', 'guard_name' => 'web'],

            ['name' => 'showform.forwardcoordination', 'guard_name' => 'web'],
            ['name' => 'submit.forwardcoordination', 'guard_name' => 'web'],

            ['name' => 'showform.forwardfollowupcoordination', 'guard_name' => 'web'],
            ['name' => 'submit.forwardfollowupcoordination', 'guard_name' => 'web'],

            ['name' => 'showform.forwardfollowupInstruction', 'guard_name' => 'web'],
            ['name' => 'submit.forwardfollowupInstruction', 'guard_name' => 'web'],

            ['name' => 'view.user', 'guard_name' => 'web'],
            ['name' => 'create.user', 'guard_name' => 'web'],
            ['name' => 'edit.user', 'guard_name' => 'web'],
            ['name' => 'delete.user', 'guard_name' => 'web'],

            ['name' => 'view.permission', 'guard_name' => 'web'],
            ['name' => 'create.permission', 'guard_name' => 'web'],
            ['name' => 'edit.permission', 'guard_name' => 'web'],
            ['name' => 'delete.permission', 'guard_name' => 'web'],


        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm['name']], ['guard_name' => 'web']);
        }

        $kasek   = Role::firstOrCreate(['name' => 'kasek', 'guard_name' => 'web']);
        $kasubbag = Role::firstOrCreate(['name' => 'kasubbag', 'guard_name' => 'web']);
        $staff   = Role::firstOrCreate(['name' => 'staff', 'guard_name' => 'web']);


        // === ROLE ADMIN (KASEK) ===
        $kasek->syncPermissions([
            'view.coordination',
            'show.coordination',
            'create.instruction',
            'submit.forwardinstruction',
            'view.instructionscore',
            'create.instructionscore',
            'view.user',
            'show.user',
            'create.user',
            'edit.user',
            'delete.user',


        ]);

        // === ROLE KASUBBAG ===
        $kasubbag->syncPermissions([
            'view.coordination',
            'create.coordination',
            'submit.forwardcoordination',
            'view.instruction',
            'create.followupinstruction',
            'submit.forwardfollowupInstruction',
            'create.followupcoordination',
            'submit.forwardfollowupcoordination',
            'view.instructionscore',
            'create.instructionscore',
        ]);

        // === ROLE STAF ===
        $staff->syncPermissions([
            'create.coordination',
            'submit.forwardcoordination',
            'view.instruction',
            'create.followupinstruction',
            'submit.forwardfollowupInstruction',
        ]);


        $kasekUser = User::firstOrCreate(
            ['email' => 'kasek@example.com'],
            ['name' => 'Kepala Seksi','telp'=>"0819291891829891" ,'password' => Hash::make('password')]
        );
        $kasekUser->assignRole($kasek);

        $kasubbagUser = User::firstOrCreate(
            ['email' => 'kasubbag@example.com'],
            ['name' => 'Kasubbag User', 'telp'=>"08019019912090" ,'password' => Hash::make('password')]
        );
        $kasubbagUser->assignRole($kasubbag);

        $staffUser = User::firstOrCreate(
            ['email' => 'staff@example.com'],
            ['name' => 'Staff User','telp'=>"2119019209021" ,'password' => Hash::make('password')]
        );
        $staffUser->assignRole($staff);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
