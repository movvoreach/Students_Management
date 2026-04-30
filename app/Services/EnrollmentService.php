<?php
namespace App\Services;
use App\Models\ScheduleStudent;


class EnrollmentService
{
    public function enrollStudent(array $data = [])
    {
      $ScheduleStudent =  ScheduleStudent::create([
            'student_id'  => $data['student_id'],
            'schedule_id' => $data['schedule_id'],
        ]);
        return $ScheduleStudent;
    }

}
