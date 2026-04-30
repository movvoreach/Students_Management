<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Override;

class Department extends Model
{
    //
    protected $table = 'departments';

    protected $fillable = [
        'department_name',
        'time'
    ];

}
