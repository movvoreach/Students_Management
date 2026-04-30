<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Classroom;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;

class StudentController extends Controller
{

    protected $studentService;

    public function __construct()
    {
        $this->studentService = new StudentService();
    }

    public function index(Request $request)
    {
        $students = $this->studentService->getWithsearchFilters($request->all());
        return view('Student.index', compact('students'));
    }

    public function create()
    {
        return $this->studentService->create();
    }

    public function store(StoreStudentRequest $request)
    {
        $this->studentService->store($request->validated());
        return redirect()->route('student.index')
            ->with('success', 'Student and login account created successfully');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return $this->studentService->edit($student);
    }

    public function update(UpdateStudentRequest $request, Student $student)
    {

        $this->studentService->update($student, $request->validated());
        return redirect()->route('student.index')
            ->with('success', 'Student updated successfully');
    }

    public function destroy(Student $student)
    {
        $this->studentService->delete($student);
        return redirect()->route('student.index')
            ->with('success', 'Student deleted successfully');
    }

}
