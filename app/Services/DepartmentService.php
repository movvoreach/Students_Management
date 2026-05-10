<?php

namespace App\Services;

use App\Models\Department;

class DepartmentService
{


    public function getWithsearchFilters($filters = [])
    {
        $query = Department::query();

        // SEARCH FILTER
        if (!empty($filters['search'])) {
            $query->where('department_name', 'like', '%' . $filters['search'] . '%');
        }

        // PER PAGE (FIX HERE)
        $perPage = $filters['per_page'] ?? 10;

        return $query->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
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
