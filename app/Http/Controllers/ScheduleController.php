<?php
namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Http\Request;
    use App\Models\Student;
class ScheduleController extends Controller
{
    /**
     * Display list
     */

    public function index()
    {
        $teachers = Teacher::all();

        $classes = Classroom::all(); // keep simple

        // 🔥 COUNT BY SCHEDULE (NOT CLASS)
        $schedules = Schedule::with(['teacher', 'class'])->withCount('students')->get();

        return view('Schedule.index', compact('teachers', 'classes', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'teacher_id' => 'required',
            'class_id'   => 'required',
            'day'        => 'required',
            'start_time' => 'required',
            'end_time'   => 'required',
        ]);

        $exists = \App\Models\Schedule::where('class_id', $request->class_id)
            ->where('day', $request->day)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($exists) {
            return back()->with('error', 'This class already has a schedule at this time!');
        }

        // ✅ CREATE SCHEDULE
        \App\Models\Schedule::create([
            'teacher_id' => $request->teacher_id,
            'class_id'   => $request->class_id,
            'day'        => $request->day,
            'start_time' => $request->start_time,
            'end_time'   => $request->end_time,
        ]);

        return back()->with('success', 'Schedule created successfully!');
    }
    public function viewClass($id)
    {
        $schedule = Schedule::with(['class', 'teacher', 'students'])->findOrFail($id);

        $students = $schedule->students;

        return view('Schedule.view_class', compact('schedule', 'students'));
    }
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->back()->with('success', 'Schedule deleted successfully');
    }



public function studentSchedule($id)
{
    $student = Student::findOrFail($id);

    // get all schedules of this student (pivot table)
    $schedules = $student->schedules()->with(['class', 'teacher'])->get();

    return view('Schedule.student_detail', compact('student', 'schedules'));
}
}
