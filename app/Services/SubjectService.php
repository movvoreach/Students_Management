<?php
namespace App\Services;


use App\Models\Subject;

class SubjectService
{
    public function getWithsearchFilters($filters = [])
    {
        $query = Subject::with('department');

        if (!empty($filters['search'])) {
            $query->where('subject_name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    public function store( $data)
    {
        // dd($data);?\
        $data = [
            'subject_name' => $data['subject_name'],
            'department_id' => $data['department_id'],
        ];
        dd($data);
        return Subject::create($data);
    }

    public function update(Subject $subject, array $data)
    {
            $data = [
                'subject_name' => $data['subject_name'],
                'department_id' => $data['department_id'],
            ];
        return $subject->update($data);
    }

}
