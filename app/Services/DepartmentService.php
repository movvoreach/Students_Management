<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
<<<<<<< HEAD


=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
    public function getWithsearchFilters($filters = [])
    {
        $query = Department::query();

<<<<<<< HEAD
        // SEARCH FILTER
=======
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        if (!empty($filters['search'])) {
            $query->where('department_name', 'like', '%' . $filters['search'] . '%');
        }

<<<<<<< HEAD
        // PER PAGE (FIX HERE)
        $perPage = $filters['per_page'] ?? 10;

        return $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
=======
        return $query->orderBy('created_at', 'desc')->paginate(10);
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
    }

    public function store(array $data)
    {
        return Department::create($data);
    }

    public function update(Department $department, array $data)
    {
        return $department->update($data);
    }

}
