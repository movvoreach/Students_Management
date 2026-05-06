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

    public function index(Request $request)
    {
        $user         = Auth::user();
        $departmentId = $user->student ? $user->student->department_id : null;
        $query        = Schedule::query()->join('subjects', 'schedules.subject_id', '=', 'subjects.id')
            ->join('teachers', 'schedules.teacher_id', '=', 'teachers.id')
            ->join('classes', 'schedules.class_id', '=', 'classes.id')
            ->select('schedules.*', 'subjects.subject_name', 'teachers.name as teacher_name', 'classes.class_name')
            ->orderByRaw("TIME(schedules.start_time) ASC");

        $query = $query->where('schedules.department_id', $departmentId);
        $days  = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $times = Schedule::query()->where('department_id', $departmentId)
            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')
            ->get();

        $data      = $query->get();
        $schedules = [];
        foreach ($times as $pkey => $time) {
            foreach ($days as $day) {
                $row = $data
                    ->where('day', $day)
                    ->where('start_time', $time->start_time)
                    ->where('end_time', $time->end_time)
                    ->first();
                $schedules[$pkey]['time'] = $time->start_time . ' - ' . $time->end_time;
                $schedules[$pkey][$day]   = [
                    'time'         => $time->start_time . ' - ' . $time->end_time,
                    'day'          => $day,
                    'subject_name' => $row->subject_name ?? '-',
                ];
                // dd($times);
            }
        }
        // dd($schedules);
        $query = Schedule::with(['teacher', 'class', 'subject'])
            ->withCount('students');

        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');
            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)->value('department_id');
            $query->where('department_id', $departmentId);

        } elseif ($user->hasRole('admin')) {

            $query = $this->scheduleService->getWithsearchFilters($request->all(), $user);
        }

        $schedules = $query
            ->orderByRaw("TIME(start_time) ASC")
            ->paginate(10)
            ->withQueryString();

        $time = (clone $query)
            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')
            ->where('start_time', '>=', '08:00')
            ->get();
        $time = $query->select('start_time', 'end_time')->groupBy('start_time', 'end_time')
            ->where('start_time', '>=', '08:00')
            ->get();

        $departments = Department::all();
        $teachers    = Teacher::select('id', 'name')->get();
        $classes     = Classroom::select('id', 'class_name')->get();
        $students    = Student::select('id', 'name')->get();
        $subjects    = Subject::all();

        // dd($schedules);
        return view('Schedule.index', compact(
            'schedules',
            'time',
            'departments',
            'teachers',
            'classes',
            'students',
            'subjects'
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
