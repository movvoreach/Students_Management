<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, \Spatie\Permission\Traits\HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    /**
 * Get the teacher associated with this record.
 */
    // app/Models/User.php



    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'user_id', 'id');
    }

    /**
     * Get the department associated with this record.
     */
    public function department()
    {

        return $this->belongsTo(Department::class);
    }

    /**
     * Get the student associated with this record.
     */
    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
