<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Clear cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'view student',
            'edit student',
            'delete student',
            'create student',
            'view studentdetail',

            'view teacher',
            'edit teacher',
            'delete teacher',
            'create teacher',
            'view studentdetail',

            'view schedule',
            'edit schedule',
            'delete schedule',
            'create schedule',
            'view scheduledetail',

            'view class',
            'create class',
            'edit class',
            'delete class',
             'view classdetail',
        ];


    }
}
