<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Classroom;

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_code',
        'department_id',
        'user_id',
        'class_id',
        'name',
        'gender',
        'dob',
        'class',
        'phone',
        'email',
        'image',
    ];
    // public function classes()
    // {
    //     return $this->belongsToMany(Classroom::class, 'enrollments');
    // }

    public function schedules()
    {
        return $this->belongsToMany(
            Schedule::class,
            'schedule_students',
            'student_id',
            'schedule_id'
        );
    }

    public function classes()
    {
        return $this->belongsToMany(Classroom::class, 'enrollments', 'student_id', 'class_id','schedule_students','schedule_id');
    }
    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function schedule_students()
    {
        return $this->hasMany(ScheduleStudent::class, 'student_id');
    }
     public function department()
    {
        // Assumes 'department_id' is in the teachers table
        return $this->belongsTo(Department::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}
