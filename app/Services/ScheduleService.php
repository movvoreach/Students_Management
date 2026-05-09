<?php
namespace App\Services;
use App\Models\Schedule;
use App\Models\ScheduleStudent;

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


    public function enrollStudent(array $data = [])
    {
        $ScheduleStudent = ScheduleStudent::create([
            'student_id'  => $data['student_id'],
            'schedule_id' => $data['schedule_id'],
        ]);
        return $ScheduleStudent;
    }

}
