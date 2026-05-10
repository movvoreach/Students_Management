<?php
namespace App\Services;


use App\Models\Subject;

class SubjectService
{
<<<<<<< HEAD
    public function getWithSearchFilters($filters = [])
    {
        $query = Subject::with('department');

        // SEARCH
=======
    public function getWithsearchFilters($filters = [])
    {
        $query = Subject::with('department');

>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
        if (!empty($filters['search'])) {
            $query->where('subject_name', 'like', '%' . $filters['search'] . '%');
        }

<<<<<<< HEAD
        // PER PAGE
        $perPage = $filters['per_page'] ?? 10;

        return $query
            ->orderBy('id', 'desc')
            ->paginate($perPage)
            ->withQueryString();
=======
        return $query->orderBy('created_at', 'desc')->paginate(10);
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
    }

    public function store( $data)
    {
<<<<<<< HEAD
        return Subject::create([
        'subject_name'  => $data['subject_name'],
        'department_id' => $data['department_id'],
         ]);
=======
        // dd($data);?\
        $data = [
            'subject_name' => $data['subject_name'],
            'department_id' => $data['department_id'],
        ];
        dd($data);
        return Subject::create($data);
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
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
