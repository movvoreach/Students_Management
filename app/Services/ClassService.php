<?php
namespace App\Services;

use App\Models\Classroom;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;

class ClassService
{
     public function store(array $data)
    {
        $class = Classroom::create([

            'class_name' => $data['class_name'],
            'table'      => $data['table'],
            'status'     => $data['status'],
        ]);
        return $class;
    }
    public function updateStudents($Student, array $data)
    {
        // dd($Student);
        $Student->update([
            'class_name' => $data['class_name'],
            'table'      => $data['table'],
            'status'     => $data['status'],
        ]);
        return $Student;
    }
     public function getWithsearchFilters($filters = [])
    {
        // dd($filters);
        $query = Classroom::query();

        // SEARCH
        if (isset($filters['search'])) {
            $s = $filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('class_name', 'like', "%{$s}%")
                    ->orWhere('id', 'like', "%{$s}%");
            });
        }


        if (!empty($filters['status'])) {
           $query->where('status', $filters['status']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        $perPage = $filters['per_page'] ?? 10;

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }


}


