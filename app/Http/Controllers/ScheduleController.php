<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
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
    protected ScheduleService $scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->scheduleService = $scheduleService;
    }

    // ================= ENROLL STUDENT =================
    public function storeEnrollment(StoreEnrollmentRequest $request)
    {
        $this->scheduleService->enrollStudent($request->validated());

        return redirect()->back()->with('success', 'Student enrolled successfully!');
    }

    // ================= INDEX =================
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
            $scheduleCollection = collect($data->items());
        } else {
            $data = $query->get();
            $scheduleCollection = $data;
        }

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $time = Schedule::query()
            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')
            ->orderByRaw('TIME(start_time) ASC')
            ->get();

        $schedules = [];

        foreach ($time as $key => $t) {

            $schedules[$key]['time'] = [
                'start_time' => $t->start_time,
                'end_time' => $t->end_time,
            ];

            foreach ($days as $day) {
                $items = $scheduleCollection
                    ->where('day', $day)
                    ->where('start_time', $t->start_time);

                $schedules[$key][$day] = $items;
            }
        }

        $departments = Department::all();
        $teachers = Teacher::select('id', 'name')->get();
        $classes = Classroom::select('id', 'class_name')->get();
        $students = Student::select('id', 'name')->get();
        $subjects = Subject::all();

        return view('schedule.index', compact(
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

    // ================= STORE SCHEDULE =================
    public function store(StoreScheduleRequest $request)
    {
        $this->scheduleService->createSchedule($request->validated());

        return back()->with('success', 'Schedule created successfully!');
    }

    // ================= SHOW =================
    public function show(Schedule $schedule)
    {
        $schedule->load([
            'class',
            'teacher',
            'students',
            'subject',
        ]);

        return view('schedule.show', compact('schedule'));
    }

    // ================= VIEW CLASS =================
    public function viewClass($id)
    {
        $schedule = Schedule::with([
            'class',
            'teacher',
            'students',
        ])->findOrFail($id);

        $students = $schedule->students;

        return view('schedule.view_class', compact('schedule', 'students'));
    }

    // ================= EDIT (AJAX) =================
    public function edit(Schedule $schedule)
    {
        $schedule->load([
            'subject',
            'teacher.department',
            'class',
        ]);

        return response()->json($schedule);
    }

    // ================= UPDATE =================
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        $this->scheduleService->updateSchedule(
            $schedule,
            $request->validated()
        );

        return redirect()->back()->with('success', 'Schedule updated successfully!');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Schedule deleted successfully!');
    }

    // ================= UNENROLL STUDENT =================
    public function unEnrollStudent($scheduleId, $studentId)
    {
        $schedule = Schedule::findOrFail($scheduleId);
        $schedule->students()->detach($studentId);

        return redirect()->back()->with('success', 'Student removed successfully!');
    }

    // ================= AJAX HELPERS =================
    public function getSubjects($departmentId)
    {
        return response()->json(
            Subject::where('department_id', $departmentId)->get()
        );
    }

    public function getTeachers($departmentId)
    {
        return response()->json(
            Teacher::where('department_id', $departmentId)->get()
        );
    }
}
