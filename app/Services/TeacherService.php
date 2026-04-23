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
    public function getAllTeachers()
    {
        return Teacher::paginate(6);
    }

    public function create()
    {
        return view('Teacher.create');
    }
    public function TeacherStore(array $data, $image = null)
    {
        $imagePath = null;

        if ($image) {
            $imagePath = $image->store('teachers', 'private');
        }

        $user = $this->userService->store([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => 'teacher',
        ]);

        return Teacher::create([
            'user_id'      => $user->id,
            'teacher_code' => $data['teacher_code'],
            'name'         => $data['name'],
            'gender'       => $data['gender'] ?? null,
            'dob'          => $data['dob'] ?? null,
            'phone'        => $data['phone'] ?? null,
            'email'        => $data['email'],
            'subject'      => $data['subject'] ?? null,
            'password'     => Hash::make($data['password']),
            'image'        => $imagePath,
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
   public function searchTeacher($request)
{
    $query = Teacher::query();

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('teacher_code', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%")
              ->orWhere('email', 'like', "%{$request->search}%")
              ->orWhere('subject', 'like', "%{$request->search}%");
        });
    }

    $perPage = $request->per_page ?? 10;

    return $query->orderBy('id', 'desc')
        ->paginate($perPage)
        ->appends($request->all());
}
}

