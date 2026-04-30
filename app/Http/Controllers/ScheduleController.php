<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Models\Classroom;
use App\Models\Department;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;
use App\Services\ScheduleService;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{
    /**
     * Display list
     */
    protected $scheduleService;
    public function __construct()
    {
        $this->scheduleService = new ScheduleService();
    }

    public function index()
    {
        $user = Auth::user();

        $departments = Department::all();
        $teachers    = Teacher::select('id', 'name')->get();
        $classes     = Classroom::select('id', 'class_name')->get();
        $students    = Student::select('id', 'name')->get();
        $subjects    = Subject::all();

        $query = Schedule::with(['teacher', 'class', 'subject']);

        // ================= ADMIN =================
        if ($user->hasRole('admin')) {
            $schedules = $query->withCount('students')->get();
        }

        // ================= TEACHER =================
        elseif ($user->hasRole('teacher')) {

            $teacher = Teacher::where('user_id', $user->id)->first();

            if (! $teacher) {
                $schedules = collect();
            } else {
                $schedules = $query
                    ->where('teacher_id', $teacher->id)
                    ->withCount('students')
                    ->get();
            }
        }

        // ================= STUDENT =================
        elseif ($user->hasRole('student')) {

            $student = Student::where('user_id', $user->id)->first();

            if (! $student) {
                $schedules = collect();
            } else {
                $schedules = $query
                    ->where('department_id', $student->department_id)
                    ->withCount('students')
                    ->get();
            }
        }

        // ================= DEFAULT =================
        else {
            $schedules = collect();
        }

        return view('Schedule.index', compact(
            'schedules',
            'teachers',
            'classes',
            'students',
            'subjects',
            'departments'
        ));
    }

    public function store(StoreScheduleRequest $request)
    {
        // dd($request->all());
        $this->scheduleService->createSchedule($request->validated());
        return back()->with('success', 'Schedule created successfully!');
    }
    public function viewClass($id)
    {
        $schedule = Schedule::with(['class', 'teacher', 'students'])->findOrFail($id);

        $students = $schedule->students;

        return view('Schedule.view_class', compact('schedule', 'students'));
    }
    public function showClass($id)
    {
        $schedule = Schedule::with(['class', 'teacher', 'students'])->findOrFail($id);

        $students = $schedule->students;

        return view('Class.show', compact('schedule', 'students'));
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Schedule deleted successfully');
    }
    public function removeStudent($scheduleId, $studentId)
    {
        // Find schedule
        $schedule = Schedule::findOrFail($scheduleId);

        // Remove student from pivot table
        $schedule->students()->detach($studentId);

        return redirect()->back()->with('success', 'Student removed from schedule successfully.');
    }

    public function studentSchedule($id)
    {
        $student = Student::findOrFail($id);

        $schedules = $student->schedules()->with(['class', 'teacher'])->withCount('students')->get();

        return view('Schedule.student_detail', compact('student', 'schedules'));
    }
    public function getSubjects($departmentId)
    {
        $subjects = Subject::where('department_id', $departmentId)->get();
        return response()->json($subjects);
    }
    public function getTeachers($departmentId)
    {
        $teachers = Teacher::where('department_id', $departmentId)->get();
        return response()->json($teachers);
    }

}
