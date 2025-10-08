<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::insert([
            ['name' => 'view.role', 'guard_name' => 'web'],
            ['name' => 'create.role', 'guard_name' => 'web'],
            ['name' => 'edit.role', 'guard_name' => 'web'],
            ['name' => 'delete.role', 'guard_name' => 'web'],

            ['name' => 'view.instruction', 'guard_name' => 'web'],
            ['name' => 'create.instruction', 'guard_name' => 'web'],
            ['name' => 'edit.instruction', 'guard_name' => 'web'],
            ['name' => 'delete.instruction', 'guard_name' => 'web'],
            ['name' => 'fetch.instruction', 'guard_name' => 'web'],

            ['name' => 'view.coordination', 'guard_name' => 'web'],
            ['name' => 'create.coordination', 'guard_name' => 'web'],
            ['name' => 'edit.coordination', 'guard_name' => 'web'],
            ['name' => 'delete.coordination', 'guard_name' => 'web'],
            ['name' => 'fetch.coordination', 'guard_name' => 'web'],

            ['name' => 'view.instructionscore', 'guard_name' => 'web'],
            ['name' => 'create.instructionscore', 'guard_name' => 'web'],
            ['name' => 'edit.instructionscore', 'guard_name' => 'web'],
            ['name' => 'delete.instructionscore', 'guard_name' => 'web'],

            ['name' => 'view.followupinstruction', 'guard_name' => 'web'],
            ['name' => 'create.followupinstruction', 'guard_name' => 'web'],
            ['name' => 'edit.followupinstruction', 'guard_name' => 'web'],
            ['name' => 'delete.followupinstruction', 'guard_name' => 'web'],

            ['name' => 'view.followupcoordination', 'guard_name' => 'web'],
            ['name' => 'create.followupcoordination', 'guard_name' => 'web'],
            ['name' => 'edit.followupcoordination', 'guard_name' => 'web'],
            ['name' => 'delete.followupcoordination', 'guard_name' => 'web'],

            ['name' => 'view.forwardinstruction', 'guard_name' => 'web'],
            ['name' => 'create.forwardinstruction', 'guard_name' => 'web'],
            ['name' => 'edit.forwardinstruction', 'guard_name' => 'web'],
            ['name' => 'delete.forwardinstruction', 'guard_name' => 'web'],

            ['name' => 'view.forwardcoordination', 'guard_name' => 'web'],
            ['name' => 'create.forwardcoordination', 'guard_name' => 'web'],
            ['name' => 'edit.forwardcoordination', 'guard_name' => 'web'],
            ['name' => 'delete.forwardcoordination', 'guard_name' => 'web'],

            ['name' => 'view.forwardfollowupcoordination', 'guard_name' => 'web'],
            ['name' => 'create.forwardfollowupcoordination', 'guard_name' => 'web'],
            ['name' => 'edit.forwardfollowupcoordination', 'guard_name' => 'web'],
            ['name' => 'delete.forwardfollowupcoordination', 'guard_name' => 'web'],
        ]);
    }
}
