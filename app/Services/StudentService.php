<?php

namespace App\Services;

use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class StudentService
{
    protected $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function getAllStudents()
    {
        return Student::paginate(6);
    }
    public function create()
    {
        return view('Student.create');
    }
    public function store(array $data)
    {
        // Upload image
        $imagePath = null;
        if (isset($data['image'])) {
            $imagePath = $data['image']->store('students', ['visibility' => 'private']);
        }

        // Create user
        $user = $this->userService->store($data);

        // Create student
        $student = Student::create([
            'user_id'      => $user->id,
            'student_code' => $data['student_code'],
            'name'         => $data['name'],
            'gender'       => $data['gender'],
            'dob'          => $data['dob'],
            'class'        => $data['class'],
            'phone'        => $data['phone'],
            'email'        => $data['email'],
            'image'        => $imagePath,
        ]);

        return $student;
    }
    public function edit(Student $student)
    {
        return view('Student.edit', compact('student'));
    }
    public function update($student, array $data)
    {
        $imagePath = $student->image;

        if (! empty($data['image'])) {

            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }

            $imagePath = $data['image']->store('students', 'public');
        }

        $student->update([
            'student_code' => $data['student_code'],
            'name'         => $data['name'],
            'gender'       => $data['gender'],
            'dob'          => $data['dob'],
            'class'        => $data['class'],
            'phone'        => $data['phone'],
            'email'        => $data['email'],
            'image'        => $imagePath,
        ]);

        if ($student->user) {
            $student->user->update([
                'name'  => $data['name'],
                'email' => $data['email'] ?? $student->user->email,
            ]);
        }

        return $student;
    }
    public function show()
    {
        return view('Student.show');
    }
    public function delete(Student $student)
    {
        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        if ($student->user) {
            $student->user->delete();
        } else {
            User::where('email', $student->email)->delete();
        }

        return $student->delete();
    }
    public function searchStudent($request)
{
    $query = Student::query();

    // SEARCH
    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('student_code', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%");
        });
    }


    if ($request->class_id) {
        $query->where('class', $request->class_id);
    }

    // GENDER FILTER
    if ($request->gender) {
        $query->where('gender', $request->gender);
    }

    $perPage = $request->per_page ?? 10;

    return $query->orderBy('id', 'desc')
        ->paginate($perPage)
        ->appends($request->all());
}
    public function showStudentDetail(Student $student)
    {
        $student->load('schedules.class', 'schedules.teacher');

        $schedules = $student->schedules;

        return view('Student.show', compact('student', 'schedules'));
    }
    // public function filterStudent($request)
    // {
    //     $query = Student::query();

    //     if ($request->class_id) {
    //         $query->whereHas('classes', function ($q) use ($request) {
    //             $q->where('classes.id', $request->class_id);
    //         });
    //     }

    //     if ($request->gender) {
    //         $query->where('gender', $request->gender);
    //     }

    //     $perPage = $request->per_page ?? 10;

    //     return $query->orderBy('id', 'desc')
    //         ->paginate($perPage)
    //         ->appends($request->all());
    // }
}
