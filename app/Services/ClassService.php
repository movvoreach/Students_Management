<?php
namespace App\Services;

use App\Models\Classroom;
use App\Models\Student;

class ClassService
{
    /**
     * create a new classroom
     * @param array $data
     * @return Classroom
     */
    public function store(array $data)
    {
        $class = Classroom::create([

            'class_name' => $data['class_name'],
            'table'      => $data['table'],
            'status'     => $data['status'],
        ]);
        return $class;
    }

    /**
     * update classroom data
     * @param Classroom $class
     * @param array $data
     * @return Classroom
     */
    public function update(Classroom $class, array $data)
    {
        $class->update([
            'class_name' => $data['class_name'],
            'table'      => $data['table'],
            'status'     => $data['status'],
        ]);
        return $class;
    }

    public function getWithsearchFilters($filters = [])
    {
        $query = Classroom::query();

        // SEARCH
        if (isset($filters['search'])) {
            $s = $filters['search'];
            $query->where(function ($q) use ($s) {
                $q->where('class_name', 'like', "%{$s}%")
                    ->orWhere('id', 'like', "%{$s}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        $perPage = $filters['per_page'] ?? 5;

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }

}
