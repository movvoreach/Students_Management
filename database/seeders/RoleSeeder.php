<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'admin']);
        $teacherRole = Role::create(['name' => 'teacher']);
        $studentRole = Role::create(['name' => 'student']);

        // Get Permissions
        $all_permissions = Permission::all();

        $viewStudent = Permission::where('name', 'view student')->first();
        $editStudent = Permission::where('name', 'edit student')->first();
        $createStudent = Permission::where('name', 'create student')->first();
        $detailstudent = Permission::where('name', 'view studentdetail')->first();

        $viewTeacher = Permission::where('name', 'view teacher')->first();

        $viewSchedule = Permission::where('name', 'view schedule')->first();
        $editSchedule = Permission::where('name', 'edit schedule')->first();
        $createSchedule = Permission::where('name', 'create schedule')->first();
        $detailschedule= Permission::where('name' ,'view scheduledetail')->first();
        $deleteschedule = Permission::whare('name', 'delete schedule')->first();

        // Admin gets all permissions
        $adminRole->syncPermissions($all_permissions);

        // Teacher permissions
        $teacherRole->syncPermissions([
            $viewStudent,
            $editStudent,
            $createStudent,
            $viewTeacher,
            $viewSchedule,
            $editSchedule,
            $createSchedule,
        ]);

        // Student permissions
        $studentRole->syncPermissions([
            $viewStudent,
            $viewSchedule,
        ]);
    }
}
