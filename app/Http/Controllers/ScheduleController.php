<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
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
        $user = Auth::user();

        $query = Schedule::with([
            'teacher.department',
            'class',
            'subject',
        ])->withCount('students');


        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');

            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)->value('department_id');

            $query->where('department_id', $departmentId);

        } elseif ($user->hasRole('admin')) {

            $query = $this->scheduleService
                ->getWithsearchFilters($request->all(), $user);
        }


        $query->orderByRaw('TIME(start_time) ASC');


        if ($user->hasRole('admin')) {

            $data = $query->paginate(10)->withQueryString();

            // collection for timetable
            $scheduleCollection = collect($data->items());

        } else {

            $data = $query->get();

            $scheduleCollection = $data;
        }


        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
        ];


        $time = Schedule::query()

            ->when($user->hasRole('teacher'), function ($q) use ($user) {

                $teacherId = Teacher::where('user_id', $user->id)->value('id');

                $q->where('teacher_id', $teacherId);

            })

            ->when($user->hasRole('student'), function ($q) use ($user) {

                $departmentId = Student::where('user_id', $user->id)->value('department_id');

                $q->where('department_id', $departmentId);

            })

            ->select('start_time', 'end_time')

            ->groupBy('start_time', 'end_time')

            ->orderByRaw('TIME(start_time) ASC')

            ->get();


        $schedules = [];

        foreach ($time as $pkey => $t) {

            $schedules[$pkey]['time'] = [
                'start_time' => $t->start_time,
                'end_time'   => $t->end_time,
            ];

            foreach ($days as $day) {

                $items = $scheduleCollection
                    ->where('day', $day)
                    ->where('start_time', $t->start_time);

                $schedules[$pkey][$day] = $items;
            }
        }


        $departments = Department::all();

        $teachers = Teacher::select('id', 'name')->get();

        $classes = Classroom::select('id', 'class_name')->get();

        $students = Student::select('id', 'name')->get();

        $subjects = Subject::all();


        return view('Schedule.index', compact(
            'schedules',
            'time',
            'departments',
            'teachers',
            'classes',
            'students',
            'subjects',
            'days',
            'data'
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

    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $this->scheduleService->updateSchedule($schedule, $request->validated());
        return redirect()->back()->with('success', 'Schedule updated successfully!');
    }

}
