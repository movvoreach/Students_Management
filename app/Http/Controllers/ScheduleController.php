<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreEnrollmentRequest;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Schedule;
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
        $result = $this->scheduleService->getScheduleIndexData(
            $request->all(),
            Auth::user()
        );

        return view('schedule.index', $result);
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
