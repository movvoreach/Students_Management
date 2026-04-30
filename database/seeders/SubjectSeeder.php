<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([

            /*
            |--------------------------------------------------------------------------
            | BUSINESS ADMINISTRATION (department_id = 1)
            |--------------------------------------------------------------------------
            */
            [
                'department_id' => 1,
                'subject_name' => 'Business Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'subject_name' => 'Entrepreneurship',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'subject_name' => 'Marketing Principles',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 1,
                'subject_name' => 'Human Resource Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | ACCOUNTING (department_id = 2)
            |--------------------------------------------------------------------------
            */
            [
                'department_id' => 2,
                'subject_name' => 'Financial Accounting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 2,
                'subject_name' => 'Cost Accounting',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 2,
                'subject_name' => 'Taxation',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 2,
                'subject_name' => 'Auditing',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | ENGLISH (department_id = 3)
            |--------------------------------------------------------------------------
            */
            [
                'department_id' => 3,
                'subject_name' => 'English Grammar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 3,
                'subject_name' => 'Academic Writing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 3,
                'subject_name' => 'Public Speaking',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 3,
                'subject_name' => 'English Literature',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | COMPUTER SCIENCE (department_id = 4)
            |--------------------------------------------------------------------------
            */
            [
                'department_id' => 4,
                'subject_name' => 'Programming Fundamentals',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 4,
                'subject_name' => 'Database Management System',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 4,
                'subject_name' => 'Data Structures',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 4,
                'subject_name' => 'Web Development',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | MANAGEMENT (department_id = 5)
            |--------------------------------------------------------------------------
            */
            [
                'department_id' => 5,
                'subject_name' => 'Project Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 5,
                'subject_name' => 'Leadership Skills',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 5,
                'subject_name' => 'Strategic Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | MARKETING (department_id = 6)
            |--------------------------------------------------------------------------
            */
            [
                'department_id' => 6,
                'subject_name' => 'Digital Marketing',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 6,
                'subject_name' => 'Consumer Behavior',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 6,
                'subject_name' => 'Brand Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | FINANCE AND BANKING (department_id = 7)
            |--------------------------------------------------------------------------
            */
            [
                'department_id' => 7,
                'subject_name' => 'Banking Operations',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 7,
                'subject_name' => 'Investment Analysis',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 7,
                'subject_name' => 'Financial Management',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'department_id' => 7,
                'subject_name' => 'Corporate Finance',
                'created_at' => now(),
                'updated_at' => now(),
            ],

        ]);
    }
}
