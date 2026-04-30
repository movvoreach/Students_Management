<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'teacher_code',
        'name',
        'gender',
        'dob',
        'phone',
        'email',
        'password',
        // 'subject',
        'image',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'teacher_id');
    }
     public function department()
    {
        // Assumes 'department_id' is in the teachers table
        return $this->belongsTo(Department::class);
    }
}
