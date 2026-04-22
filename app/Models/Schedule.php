<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['teacher_id', 'class_id', 'day', 'start_time', 'end_time'];

    // public function teacher()
    // {
    //     return $this->belongsTo(Teacher::class);
    // }

    // public function class()
    // {
    //     return $this->belongsTo(Classroom::class);
    // }
    public function students()
    {
       return $this->belongsToMany(Student::class, 'schedule_students', 'schedule_id', 'student_id');
    }
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
// public function teacher()
// {
//     return $this->belongsTo(Teacher::class, 'teacher_id');
// }

    public function class ()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }


}
