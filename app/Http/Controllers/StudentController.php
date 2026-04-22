<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Models\Student;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    protected $studentService;
    // protected $userService;

    public function __construct()
    {
        $this->studentService = new StudentService();
    }
    // =====================
    // LIST
    // =====================
    public function index()
    {
        $students = Student::latest()->get();
        return view('Student.index', compact('students'));
    }

    // =====================
    // CREATE FORM
    // =====================
    public function create()
    {
        return view('Student.create');
    }

    // =====================
    // STORE
    // =====================
    public function store(StoreStudentRequest $request)
    {
        $this->studentService->store($request->validated());
        return redirect()->route('student.index')
            ->with('success', 'Student and login account created successfully');



    }

    // =====================
    // EDIT FORM
    // =====================
    public function edit(Student $student)
    {
        return view('Student.edit', compact('student'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, Student $student)
    {
        $request->validate([
            'student_code' => 'required|unique:students,student_code,' . $student->id,
            'name'         => 'required',
        ]);

        $imagePath = $student->image;

        if ($request->hasFile('image')) {

            // delete old image
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }

            $imagePath = $request->file('image')->store('students', 'public');
        }

        $student->update([
            'student_code' => $request->student_code,
            'name'         => $request->name,
            'gender'       => $request->gender,
            'dob'          => $request->dob,
            'class'        => $request->class,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'image'        => $imagePath,
        ]);

        return redirect()->route('student.index')
            ->with('success', 'Student updated successfully');
    }

    // =====================
    // DELETE
    // =====================
    public function destroy(Student $student)
    {
        // delete image
        if ($student->image) {
            Storage::disk('public')->delete($student->image);
        }

        // delete related user account
        User::where('email', $student->email)->delete();

        // delete student
        $student->delete();

        return redirect()->route('student.index')
            ->with('success', 'Student deleted successfully');
    }
}
