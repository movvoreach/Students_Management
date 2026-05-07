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
    // public function getAllStudents($filters = [])
    // {
    //     return Student::paginate(6);
    // }
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

        if ($user) {
            $user->assignRole('student');
        }

        // Create student
        $student = Student::create([
            'user_id'       => $user->id,
            'department_id' => $data['department'],
            'student_code'  => $data['student_code'],
            'name'          => $data['name'],
            'gender'        => $data['gender'],
            'dob'           => $data['dob'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'image'         => $imagePath,
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
    public function getWithsearchFilters($filters = [])
    {
        // dd($filters);
        $query = Student::query();

        // SEARCH
        if (isset($filters['search'])) {
            $s = $filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                    ->orWhere('id', 'like', "%{$s}%")
                    ->orWhere('student_code', 'like', "%{$s}%")
                    ->orWhere('phone', 'like', "%{$s}%")
                    ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if (! empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        $perPage = $filters['per_page'] ?? 10;

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }
    public function showStudentDetail(Student $student)
    {
        $student->load('schedules.class', 'schedules.teacher');

        $schedules = $student->schedules;

        return view('Student.show', compact('student', 'schedules'));
    }
}
