<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

public function run(): void
{
    $admin = User::create([
        'name' => 'Admin-User',
        'email' => 'adminuser@gmail.com',
        'password' => Hash::make('123456'),
    ]);
    $admin->assignRole('admin');

    $teacher = User::create([
        'name' => 'Teacher',
        'email' => 'teacher@gmail.com',
        'password' => Hash::make('123456'),
    ]);
    $teacher->assignRole('teacher');

    $student = User::create([
        'name' => 'Student',
        'email' => 'student@gmail.com',
        'password' => Hash::make('123456'),
    ]);
    $student->assignRole('student');
}
}

