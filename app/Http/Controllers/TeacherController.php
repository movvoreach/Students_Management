<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use App\Models\Department;
use App\Models\Teacher;
use App\Services\TeacherService;
use Illuminate\Http\Request;

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

    public function index(Request $request)
    {
        // dd($request->all());

        $teachers = $this->teacherService->getWithsearchFilters($request->all());
        return view('teacher.index', compact('teachers', ));
    }

    public function create()
    {
        $departments = Department::all();
        return view('teacher.create', compact('departments'));
    }

    // =====================
    // STORE
    // =====================
    public function store(StoreTeacherRequest $request)
    {
        // dd($request->all())
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
        $teacher     = Teacher::findOrFail($id);
        $departments = Department::all();

        return view('Teacher.edit', compact('teacher', 'departments'));
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
        $teachers = $this->teacherService->getWithsearchFilters($request);

        return view('teacher.index', compact('teachers'));
    }
    public function show($id)
    {
        $data = $this->teacherService->showTeacherDetail($id);

        return view('Teacher.show', [
            'teacher'   => $data['teacher'],
            'schedules' => $data['schedules'],
        ]);
    }

}
