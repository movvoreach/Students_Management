<?php
namespace App\Services;

use App\Models\Teacher;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class TeacherService
{
    protected $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }



    public function TeacherStore(array $data, $image = null)
    {
        
        $imagePath = null;

        if ($image) {
            $imagePath = $image->store('teachers', 'private');
        }

        // Create user
        $user = $this->userService->store([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);


        if ($user) {
            $user->assignRole('teacher');
        }

        // Create teacher profile
        return Teacher::create([
            'user_id'       => $user->id,
            'teacher_code'  => $data['teacher_code'],
            'name'          => $data['name'],
            'gender'        => $data['gender'],
            'dob'           => $data['dob'],
            'phone'         => $data['phone'],
            'email'         => $data['email'],
            'password'      => Hash::make($data['password']),
            'department_id' => $data['department'],
            'image'         => $imagePath,
        ]);
    }
    public function edit(Teacher $teacher)
    {
        return view('Teacher.edit', compact('teacher'));
    }

    # ===================== UPDATE =====================
    public function update($teacher, array $data)
    {
        $imagePath = $teacher->image;

        if (! empty($data['image'])) {

            if ($teacher->image) {
                Storage::disk('public')->delete($teacher->image);
            }

            $imagePath = $data['image']->store('teachers', 'public');
        }

        $teacher->update([
            'teacher_code' => $data['teacher_code'],
            'name'         => $data['name'],
            'gender'       => $data['gender'],
            'dob'          => $data['dob'],
            'phone'        => $data['phone'],
            'email'        => $data['email'],
            'subject'      => $data['subject'],
            'image'        => $imagePath,
        ]);

    }
    public function delete(Teacher $teacher)
    {
        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        if ($teacher->user) {
            $teacher->user->delete();
        }

        return $teacher->delete();
    }
    public function getWithsearchFilters($filters = [])
    {
        $query = Teacher::query();

        // 1. Keyword search (Name, Code, Phone, Email)
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('teacher_code', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['department_id'])) {
            $query->where('department_id', $filters['department_id']);
        }

        if (! empty($filters['gender'])) {
            $query->where('gender', $filters['gender']);
        }

        $perPage = $filters['per_page'] ?? 10;

        return $query->orderBy('id', 'desc')->paginate($perPage);
    }
    # TeacherService.php
    public function showTeacherDetail($id)
    {
        $teacher = Teacher::with(['schedules.class', 'schedules.students'])->findOrFail($id);

        return [
            'teacher'   => $teacher,
            'schedules' => $teacher->schedules,
        ];
    }

}
