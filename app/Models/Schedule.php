<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = ['subject_id', 'department_id', 'teacher_id', 'class_id', 'day', 'start_time', 'end_time'];


    public function students()
    {
        return $this->belongsToMany(Student::class, 'schedule_students', 'schedule_id', 'student_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function class ()
    {
        return $this->belongsTo(Classroom::class, 'class_id');
    }

    public function department()
    {
        // Assumes 'department_id' is in the teachers table
        return $this->belongsTo(Department::class);
    }
    public function schedules() {
    return $this->hasMany(Schedule::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }


}
