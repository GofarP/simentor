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
            ['name' => 'show.instruction', 'guard_name' => 'web'],
            ['name' => 'delete.instruction', 'guard_name' => 'web'],
            ['name' => 'fetch.instruction', 'guard_name' => 'web'],

            ['name' => 'view.coordination', 'guard_name' => 'web'],
            ['name' => 'create.coordination', 'guard_name' => 'web'],
            ['name' => 'edit.coordination', 'guard_name' => 'web'],
            ['name' => 'show.instruction', 'guard_name' => 'web'],
            ['name' => 'delete.coordination', 'guard_name' => 'web'],
            ['name' => 'fetch.coordination', 'guard_name' => 'web'],

            ['name' => 'view.instructionscore', 'guard_name' => 'web'],
            ['name' => 'create.instructionscore', 'guard_name' => 'web'],
            ['name' => 'edit.instructionscore', 'guard_name' => 'web'],
            ['name' => 'delete.instructionscore', 'guard_name' => 'web'],

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
        ]);
    }
}
