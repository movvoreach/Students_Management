<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles safely
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $teacherRole = Role::firstOrCreate(['name' => 'teacher']);
        $studentRole = Role::firstOrCreate(['name' => 'student']);

        // Get all permissions
        $allPermissions = Permission::all();

        // Safe permission groups
        $studentPermissions = Permission::whereIn('name', [
            'view student',
            'create student',
            'edit student',
            'view studentdetail',
            'view schedule',
        ])->get();

        $teacherPermissions = Permission::whereIn('name', [
            'view student',
            'create student',
            'edit student',
            'view teacher',
            'view schedule',
            'create schedule',
            'edit schedule',
        ])->get();

        // ADMIN → ALL
        $adminRole->syncPermissions($allPermissions);

        // TEACHER
        $teacherRole->syncPermissions($teacherPermissions);

        // STUDENT
        $studentRole->syncPermissions($studentPermissions);
    }
}
