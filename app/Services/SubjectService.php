<?php
namespace App\Services;


use App\Models\Subject;

class SubjectService
{
    public function getWithSearchFilters($filters = [])
    {
        $query = Subject::with('department');

        // SEARCH
        if (!empty($filters['search'])) {
            $query->where('subject_name', 'like', '%' . $filters['search'] . '%');
        }

        // PER PAGE
        $perPage = $filters['per_page'] ?? 10;

        return $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function store( $data)
    {
        return Subject::create([
        'subject_name'  => $data['subject_name'],
        'department_id' => $data['department_id'],
         ]);
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
