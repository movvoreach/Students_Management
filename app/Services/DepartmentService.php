<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{
    public function getWithsearchFilters($filters = [])
    {
        $query = Department::query();

        if (!empty($filters['search'])) {
            $query->where('department_name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
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
