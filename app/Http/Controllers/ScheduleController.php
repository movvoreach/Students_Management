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
    public function storeEnrollment(StoreEnrollmentRequest $request)
    {
        $this->scheduleService->enrollStudent($request->validated());

        return redirect()->back()->with('success', 'Student enrolled successfully');
    }

    /**
     * Display schedule list
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        // ================= BASE QUERY =================
        $query = Schedule::with([
            'teacher.department',
            'class',
            'subject',
        ])->withCount('students');

<<<<<<< HEAD
        // ================= ROLE FILTER =================
=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');

            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)
                ->value('department_id');

            $query->where('department_id', $departmentId);

        } elseif ($user->hasRole('admin')) {

            $query = $this->scheduleService
                ->getWithsearchFilters($request->all(), $user);
        }

<<<<<<< HEAD
        // ================= SORT =================
        $query->orderByRaw('TIME(start_time) ASC');

        // ================= DATA =================
=======
        $query->orderByRaw('TIME(start_time) ASC');

>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        if ($user->hasRole('admin')) {

            $data = $query->paginate(10)->withQueryString();

            $scheduleCollection = collect($data->items());

        } else {

            $data = $query->get();

            $scheduleCollection = $data;
        }

<<<<<<< HEAD
        // ================= DAYS =================
=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
        ];

<<<<<<< HEAD
        // ================= TIME SLOTS =================
=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        $time = Schedule::query()

            ->when($user->hasRole('teacher'), function ($q) use ($user) {

                $teacherId = Teacher::where('user_id', $user->id)
                    ->value('id');

                $q->where('teacher_id', $teacherId);

            })

            ->when($user->hasRole('student'), function ($q) use ($user) {

                $departmentId = Student::where('user_id', $user->id)
                    ->value('department_id');

                $q->where('department_id', $departmentId);

            })

            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')
            ->orderByRaw('TIME(start_time) ASC')
            ->get();

<<<<<<< HEAD
        // ================= TIMETABLE =================
=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        $schedules = [];

        foreach ($time as $key => $t) {

            $schedules[$key]['time'] = [
                'start_time' => $t->start_time,
                'end_time'   => $t->end_time,
            ];

            foreach ($days as $day) {

                $items = $scheduleCollection
                    ->where('day', $day)
                    ->where('start_time', $t->start_time);

                $schedules[$key][$day] = $items;
            }
        }

<<<<<<< HEAD
        // ================= EXTRA DATA =================
=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
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

    /**
     * Store new schedule
     */
    public function store(StoreScheduleRequest $request)
    {
<<<<<<< HEAD
        $this->scheduleService
            ->createSchedule($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Schedule created successfully!');
    }

    /**
     * Enroll student
     */
    public function storeEnrollment(StoreEnrollmentRequest $request)
    {
        $this->scheduleService
            ->enrollStudent($request->validated());

        return redirect()
            ->back()
            ->with('success', 'Student enrolled successfully!');
    }

    /**
     * Show schedule detail
     */
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

    /**
     * View class students
     */
=======
        $this->scheduleService->createSchedule($request->validated());
        return back()->with('success', 'Schedule created successfully!');
    }

>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
    public function viewClass($id)
    {
        $schedule = Schedule::with([
            'class',
            'teacher',
            'students',
        ])->findOrFail($id);

        $students = $schedule->students;

<<<<<<< HEAD
        return view('schedule.view_class', compact(
            'schedule',
            'students'
        ));
=======
        return view('Schedule.view_class', compact('schedule', 'students'));
    }

    public function show(Schedule $schedule)
    {
        // $schedule = Schedule::with(['class', 'teacher', 'students'])->findOrFail($id);
        return view('schedule.show', compact('schedule'));
    }

    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Schedule deleted successfully');
    }

    // Unenroll student from schedule
    public function unEnrollStudent($scheduleId, $studentId)
    {
        dd($scheduleId, $studentId);
        // Find schedule
        $schedule = Schedule::findOrFail($scheduleId);

        // Remove student from pivot table
        $schedule->students()->detach($studentId);

        return redirect()->back()->with('success', 'Student removed from schedule successfully.');
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
    }

    /**
     * Student schedule
     */
    public function studentSchedule($id)
    {
        $student = Student::findOrFail($id);

        $schedules = $student->schedules()
            ->with([
                'class',
                'teacher',
                'subject',
            ])
            ->withCount('students')
            ->get();

        return view('schedule.student_detail', compact(
            'student',
            'schedules'
        ));
    }

<<<<<<< HEAD
    /**
     * Edit schedule
     */
=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
    public function edit(Schedule $schedule)
    {
        $schedule->load([
            'subject',
            'teacher.department',
            'class',
        ]);

        return response()->json($schedule);
    }

    /**
     * Update schedule
     */
    public function update(
        UpdateScheduleRequest $request,
        Schedule $schedule
    ) {
        $this->scheduleService->updateSchedule(
            $schedule,
            $request->validated()
        );

        return redirect()
            ->back()
            ->with('success', 'Schedule updated successfully!');
    }

    /**
     * Delete schedule
     */
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);

        $schedule->delete();

        return redirect()
            ->back()
            ->with('success', 'Schedule deleted successfully!');
    }

    /**
     * Remove student from schedule
     */
    public function unEnrollStudent($scheduleId, $studentId)
    {
        $schedule = Schedule::findOrFail($scheduleId);

        $schedule->students()->detach($studentId);

        return redirect()
            ->back()
            ->with(
                'success',
                'Student removed from schedule successfully!'
            );
    }

    /**
     * Get subjects by department
     */
    public function getSubjects($departmentId)
    {
        $subjects = Subject::where(
            'department_id',
            $departmentId
        )->get();

        return response()->json($subjects);
    }

    /**
     * Get teachers by department
     */
    public function getTeachers($departmentId)
    {
        $teachers = Teacher::where(
            'department_id',
            $departmentId
        )->get();

        return response()->json($teachers);
    }
}
