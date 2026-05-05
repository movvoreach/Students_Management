<?php
namespace App\Services;

use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;

class ScheduleService
{
    public function createSchedule(array $data = [])
    {

        // $checkSchedule = Schedule::where('class_id', $data['class_id'])
        //     ->where('day', $data['day']) // Current selected day only
        //     ->where(function ($query) use ($data) {
        //         $query->where(function ($q) use ($data) {

        //             $q->where('start_time', '<', $data['end_time'])
        //             ->where('end_time', '>', $data['start_time']);
        //         });
        //     })
        //     ->exists();

        // try {
        //     if ($checkSchedule) {
        //         throw new Exception('This class already has a schedule at this time!');
        //     }
        // } catch (\Exception $e) {
        //     return back()->withErrors([
        //         'error' => $e->getMessage()
        //     ])->withInput();
        // }

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
        $query = Schedule::query();

        // SEARCH
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('day', 'like', "%{$search}%");
            });
        }

        // FILTERS
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

         if (! empty($filters['subject_id'])) {
            $query->where('subject_id', $filters['subject_id']);
        }
        $perPage = $filters['per_page'] ?? 10;

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }
}
