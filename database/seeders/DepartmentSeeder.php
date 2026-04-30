<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([


            [
                'department_name' => 'Business Administration',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'department_name' => 'Accounting',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'department_name' => 'English',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'department_name' => 'Computer Science',
                'created_at' => now(),
                'updated_at' => now(),
            ],


            [
                'department_name' => 'Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'department_name' => 'Marketing',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'department_name' => 'Finance and Banking',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
