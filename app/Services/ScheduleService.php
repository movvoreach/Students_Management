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
    //  protected $scheduleService;
    //  public function __construct()
    //  {
    //      $this->scheduleService = new ScheduleService();
    //  }
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

     public function getScheduleIndexData(array $filters, $user): array
    {
        $query = Schedule::with([
            'teacher.department',
            'class',
            'subject',
        ])->withCount('students');

        /*
        |--------------------------------------------------------------------------
        | Role Filters
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('teacher')) {

            $teacherId = Teacher::where('user_id', $user->id)->value('id');

            $query->where('teacher_id', $teacherId);

        } elseif ($user->hasRole('student')) {

            $departmentId = Student::where('user_id', $user->id)
                ->value('department_id');

            $query->where('department_id', $departmentId);

        } elseif ($user->hasRole('admin')) {

            $query = $this->getWithsearchFilters($filters, $user);
        }

        /*
        |--------------------------------------------------------------------------
        | Order
        |--------------------------------------------------------------------------
        */

        $query->orderByRaw('TIME(start_time) ASC');

        /*
        |--------------------------------------------------------------------------
        | Data
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('admin')) {

            $data = $query->paginate(10)->withQueryString();

            $scheduleCollection = collect($data->items());

        } else {

            $data = $query->get();

            $scheduleCollection = $data;
        }

        /*
        |--------------------------------------------------------------------------
        | Schedule Table
        |--------------------------------------------------------------------------
        */

        $days = [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday',
        ];

        $time = Schedule::query()
            ->select('start_time', 'end_time')
            ->groupBy('start_time', 'end_time')
            ->orderByRaw('TIME(start_time) ASC')
            ->get();

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

        /*
        |--------------------------------------------------------------------------
        | Dropdown Data
        |--------------------------------------------------------------------------
        */

        return [
            'schedules'   => $schedules,
            'time'        => $time,
            'departments' => Department::all(),
            'teachers'    => Teacher::select('id', 'name')->get(),
            'classes'     => Classroom::select('id', 'class_name')->get(),
            'students'    => Student::select('id', 'name')->get(),
            'subjects'    => Subject::all(),
            'days'        => $days,
            'data'        => $data,
        ];
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
