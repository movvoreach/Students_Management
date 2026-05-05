<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Models\Classroom;
use App\Models\Department;
use App\Models\Student;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{

    protected $studentService;

    public function __construct()
    {
        $this->studentService = new StudentService();
    }

    // Add $id to the signature and handle potential missing filters
    public function index(Request $request)
    {

        $students = $this->studentService->getWithsearchFilters($request->all());

        $student = Student::with(['schedules.class'])->get();
        // dd($student);
        $classes = Classroom::all();

        return view('Student.index', compact('students', 'classes', 'student'));
    }

    public function checkStudent(Request $request)
    {
        // dd($request->all());

        $scheduleId         = $request->query('schedule_id');
        $studentsInSchedule = DB::table('schedule_students')->where('schedule_id', $scheduleId)->pluck('student_id', 'id')->toArray();
        $students           = Student::whereNotIn('id', $studentsInSchedule)->get();
        // $getDepartmentid = Department::Whare('')
        $data = [];
        foreach ($students as $student) {
            $data[] = [
                'id'   => $student->id,
                'text' => $student->name,
            ];
        }
        return response()->json($data);
        // dd($students);
    }
    public function create()
    {
        // Retrieve data to pass to the view
        $departments = Department::all();

        // Pass variable 'departments' to 'resources/views/Student/create.blade.php'
        return view('Student.create', compact('departments'));
    }

    public function store(StoreStudentRequest $request)
    {
        $this->studentService->store($request->validated());
        return redirect()->route('student.index')
            ->with('success', 'Student and login account created successfully');
    }
    public function edit(Student $student)
    {
         $departments = Department::all();
        return view('Student.edit', compact('student', 'departments'));
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
