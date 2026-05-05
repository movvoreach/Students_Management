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
use Illuminate\Http\Request;
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

        $query = Schedule::with(['teacher', 'class', 'subject'])
            ->withCount('students');

        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');
            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)->value('department_id');
            $query->where('department_id', $departmentId);

        } elseif ($user->hasRole('admin')) {

            if (request()->input('department_id')) {
                $query->where('department_id', request('department_id'));
            }
        }

        $schedules = $query
            ->orderBy('start_time')
            ->paginate(10)
            ->withQueryString();

        $time = (clone $query)
            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')->get();

        $departments = Department::all();
        $teachers    = Teacher::select('id', 'name')->get();
        $classes     = Classroom::select('id', 'class_name')->get();
        $students    = Student::select('id', 'name')->get();
        $subjects    = Subject::all();

        return view('Schedule.index', compact(
            'schedules',
            'teachers',
            'classes',
            'students',
            'subjects',
            'departments',
            'time'
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

        $schedules = $student->schedules()->with(['class', 'teacher', 'subject'])->withCount('students')->get();

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

    // app/Http/Controllers/ScheduleController.php

// ... (your existing imports and index method)

    public function edit(Schedule $schedule)
    {

        $schedule->load('subject', 'teacher.department', 'class');
        return response()->json($schedule);
    }

    public function update(Request $request, Schedule $schedule)
    {
        $request->validate([
            'department_id' => 'required|integer|exists:departments,id',
            'subject_id'    => 'required|integer|exists:subjects,id',
            'teacher_id'    => 'required|integer|exists:teachers,id',
            'class_id'      => 'required|integer|exists:classes,id',
            'day'           => 'required|string',
            'start_time'    => 'required',
            'end_time'      => 'required|after:start_time',
        ]);

        $schedule->update([
            'department_id' => $request->department_id,
            'subject_id'    => $request->subject_id,
            'teacher_id'    => $request->teacher_id,
            'class_id'      => $request->class_id,
            'day'           => $request->day,
            'start_time'    => $request->start_time,
            'end_time'      => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Schedule updated successfully!');
    }

}
