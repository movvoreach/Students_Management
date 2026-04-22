<?php

namespace App\Http\Controllers;
use App\Models\Enrollment;
use App\Models\ScheduleStudent;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'student_id' => 'required|exists:students,id',
        'class_id'   => 'required',
        'schedule_id'=> 'required',
        'schedule_id' => 'required|exists:schedules,id',
    ]);


    Enrollment::create([
        'student_id'  => $request->student_id,
        'class_id'    => $request->class_id,
        'schedule_id' => $request->schedule_id,
    ]);
    ScheduleStudent::create([
        'student_id'  => $request->student_id,
        'schedule_id' => $request->schedule_id,
    ]);

    return back()->with('success', 'Student enrolled successfully');
}
}

