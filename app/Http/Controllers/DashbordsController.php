<?php
namespace App\Http\Controllers;

use App\Models\Classroom;
use App\Models\ScheduleStudent;

class DashbordsController extends Controller
{
    //
    public function index()
    {
        $studentsCount   = \App\Models\Student::count();
        $teachersCount   = \App\Models\Teacher::count();
        $classesCount    = Classroom::count();
        $enrollmentCount = ScheduleStudent::count();
        $totalSchedules  = \App\Models\Schedule::count();
        $tatalSubject    = \App\Models\Subject::count();
        $totalDepartment = \App\Models\Department::count();
        $enrollments     = ScheduleStudent::with('student','class','schedule')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard',
            compact(
                'studentsCount',
                'teachersCount',
                'classesCount',
                'enrollmentCount',
                'totalSchedules',
                'tatalSubject',
                'totalDepartment',
                'enrollments'
            ));
    }
}
