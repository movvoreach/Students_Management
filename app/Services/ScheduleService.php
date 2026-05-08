<?php
namespace App\Services;

use App\Models\Classroom;
use App\Models\Department;
use App\Models\Schedule;
use App\Models\ScheduleStudent;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Teacher;

class ScheduleService
{
    public function createSchedule(array $data = [])
    {
        return Schedule::create([
            'department_id' => $data['department_id'],
            'subject_id'    => $data['subject_id'],
            'teacher_id'    => $data['teacher_id'],
            'class_id'      => $data['class_id'],
            'day'           => $data['day'],
            'start_time'    => $data['start_time'],
            'end_time'      => $data['end_time'],
        ]);
    }

    public function getWithsearchFilters($filters = [], $user = null)
    {
        $query = Schedule::with(['teacher', 'class', 'subject'])->withCount('students');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('day', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['day'])) {
            $query->where('day', $filters['day']);
        }

        if (! empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (! empty($filters['teacher_id'])) {
            $query->where('teacher_id', $filters['teacher_id']);
        }

        if (! empty($filters['class_id'])) {
            $query->where('class_id', $filters['class_id']);
        }

        return $query;
    }

    public function updateSchedule(Schedule $schedule, array $data): Schedule
    {
        $schedule->update([
            'department_id' => $data['department_id'],
            'subject_id'    => $data['subject_id'],
            'teacher_id'    => $data['teacher_id'],
            'class_id'      => $data['class_id'],
            'day'           => $data['day'],
            'start_time'    => $data['start_time'],
            'end_time'      => $data['end_time'],
        ]);

        return $schedule;
    }

    public function getWithRoleUsers($user)
    {
        $query = Schedule::with(['teacher.department', 'class', 'subject'])->withCount('students');

        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');
            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)->value('department_id');
            $query->where('department_id', $departmentId);

        }

        return $query;
    }

    public function getScheduleWithTime($query, $user)
    {
        $query->orderByRaw('TIME(start_time) ASC');

        if ($user->hasRole('admin')) {$data = $query->paginate(10)->withQueryString();
            return [
                'data'       => $data,
                'collection' => collect($data->items()),
            ];}

        $data = $query->get();

        return [
            'data'       => $data,
            'collection' => $data,
        ];
    }

    /**
     * Get distinct time slots
     */
    public function getStartTimesAndEndTimes($user)
    {
        return Schedule::query()->when($user->hasRole('teacher'), function ($q) use ($user) {
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
    }

    public function getScheduleWithTimeAndDays($getScheduleWithTime, $getTime, $days)
    {
        $schedules = [];

        foreach ($getTime as $pkey => $time) {

            $schedules[$pkey]['time'] = [
                'start_time' => $time->start_time,
                'end_time'   => $time->end_time,
            ];

            foreach ($days as $day) {

                $items = $getScheduleWithTime
                    ->where('day', $day)
                    ->where('start_time', $time->start_time);

                $schedules[$pkey][$day] = $items;
            }
        }

        return $schedules;
    }

    // My Controller code

    public function index(Request $request)
    {
        $user = Auth::user();

        $query = $this->scheduleService->getWithRoleUsers($user);

        if ($user->hasRole('admin')) {
            $query = $this->scheduleService->getWithsearchFilters($request->all(), $user);
        }

        $queryResult = $this->scheduleService->getScheduleWithTime($query, $user);

        $data               = $queryResult['data'];
        $scheduleCollection = $queryResult['collection'];

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];

        $time = $this->scheduleService->getStartTimesAndEndTimes($user);

        $schedules = $this->scheduleService->getScheduleWithTimeAndDays($scheduleCollection, $time, $days);

        // $dropdown = $this->scheduleService->getWithSelectData();
        $departments = Department::all();
        $teachers    = Teacher::select('id', 'name')->get();
        $classes     = Classroom::select('id', 'class_name')->get();
        $students    = Student::select('id', 'name')->get();
        $subjects    = Subject::all();
        return view('Schedule.index', array_merge([
            'schedules'   => $schedules,
            'time'        => $time,
            'days'        => $days,
            'data'        => $data,
            'departments' => $departments,
            'teachers'    => $teachers,
            'classes'     => $classes,
            'students'    => $students,
            'subjects'    => $subjects,
        ]));
    }

    public function enrollStudent(array $data = [])
    {
        $ScheduleStudent = ScheduleStudent::create([
            'student_id'  => $data['student_id'],
            'schedule_id' => $data['schedule_id'],
        ]);
        return $ScheduleStudent;
    }

}
