<?php
namespace App\Http\Controllers;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected DepartmentService $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    // ================= INDEX =================
    public function index(Request $request)
    {
        $departments = $this->departmentService
            ->getWithsearchFilters($request->all());

        return view('department.index', compact('departments'));
    }

    // ================= CREATE =================
    public function create()
    {
        return view('department.create');
    }

    // ================= STORE =================
    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentService->store($request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department created successfully!');
    }

    // ================= EDIT =================
    public function edit($id)
    {
        $department = Department::findOrFail($id);

        return view('department.edit', compact('department'));
    }

    // ================= UPDATE =================
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->departmentService->update($department, $request->validated());

        return redirect()
            ->route('departments.index')
            ->with('success', 'Department updated successfully!');
    }

    // ================= DELETE =================
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()
            ->back()
            ->with('success', 'Department deleted successfully!');
    }

    // ================= SHOW =================
    public function show($id)
    {
        $department = Department::findOrFail($id);

        return view('department.show', compact('department'));
    }
}
