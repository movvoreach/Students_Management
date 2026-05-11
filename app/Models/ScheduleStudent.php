<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduleStudent extends Model
{
    protected $table = 'schedule_students';

    protected $fillable = [
        'schedule_id',
        'student_id',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function class ()
    {

        return $this->belongsTo(Classroom::class);
    }
     public function schedule ()
    {

        return $this->belongsTo(Schedule::class);
    }
}
