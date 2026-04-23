<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{

    // =====================
    // LIST
    // =====================

    protected $teacherService;

    public function __construct(TeacherService $teacherService)
    {
        $this->teacherService = $teacherService;
    }

    public function index()
    {
        $teachers = $this->teacherService->getAllTeachers();
        return view('Teacher.index', compact('teachers'));
    }

    public function create()

    {
        return $this->teacherService->create();
    }

    // =====================
    // STORE
    // =====================
    public function store(StoreTeacherRequest $request)
    {
        $this->teacherService->TeacherStore(
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher Created successfully');
    }
    // =====================
    // EDIT
    // =====================
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return $this->teacherService->edit($teacher);
    }

    // =====================
    // UPDATE
    // =====================
    public function update(UpdateTeacherRequest $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->teacherService->update($teacher, $request->validated());
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully');

    }

    // =====================
    // DELETE
    // =====================
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);
        $this->teacherService->delete($teacher);
        return back()->with('success', 'Teacher deleted successfully');
    }
    public function search(Request $request)
{
    $teachers = $this->teacherService->searchTeacher($request);

    return view('Teacher.index', compact('teachers'));
}
    
}
