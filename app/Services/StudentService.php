<?php

namespace App\Services;

use App\Models\Student;


class StudentService
{
    protected $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }
    // This service can be used for user-related operations, such as creating a user when a student is created.
    public function store(array $data)
    {
        // dd($data);
        $user = $this->userService->store($data);
        // dd($user);
           // 1. Create Student
        $student = Student::create([
            'user_id'      => $user->id,
            'student_code' => $data['student_code'],
            'name'         => $data['name'],
            'gender'       => $data['gender'],
            'dob'          => $data['dob'],
            'class'        => $data['class'],
            'phone'        => $data['phone'],
            'email'        => $data['email'],
            // 'image'        => $imagePath
        ]);



    }
}
