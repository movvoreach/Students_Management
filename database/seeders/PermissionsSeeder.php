<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permissions')->insert([
            // STUDENT
            ['name' => 'view student', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create student', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit student', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete student', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view studentdetail', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            // TEACHER
            ['name' => 'view teacher', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create teacher', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit teacher', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete teacher', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            // SCHEDULE
            ['name' => 'view schedule', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create schedule', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit schedule', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete schedule', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view scheduledetail', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],

            // CLASS
            ['name' => 'view class', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'create class', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit class', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'delete class', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'view classdetail', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],


            ['name' => 'view profile', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'edit profile', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],
            // ['name' => 'edit profile', 'guard_name' => 'web', 'created_at' => now(), 'updated_at' => now()],


        ]);
    }
}
