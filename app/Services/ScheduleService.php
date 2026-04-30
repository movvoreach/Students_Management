<?php

namespace App\Services;

use App\Models\Schedule;
use TheSeer\Tokenizer\Exception;

class ScheduleService
{
    public function createSchedule(array $data = [])
    {


            $checkSchedule = Schedule::where('class_id', $data['class_id'])
                ->where('day', $data['day']) // Current selected day only
                ->where(function ($query) use ($data) {
                    $query->where(function ($q) use ($data) {

                        $q->where('start_time', '<', $data['end_time'])
                        ->where('end_time', '>', $data['start_time']);
                    });
                })
                ->exists();

            try {
                if ($checkSchedule) {
                    throw new Exception('This class already has a schedule at this time!');
                }
            } catch (\Exception $e) {
                return back()->withErrors([
                    'error' => $e->getMessage()
                ])->withInput();
            }

            // Create new schedule if no duplicate found
            return Schedule::create([
                'department_id' =>$data['department_id'],
                'subject_id' => $data['subject_id'],
                'teacher_id' => $data['teacher_id'],
                'class_id'   => $data['class_id'],
                'day'        => $data['day'],
                'start_time' => $data['start_time'],
                'end_time'   => $data['end_time'],
            ]);
    }
}
