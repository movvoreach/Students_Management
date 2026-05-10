<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Department;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    //
    protected $departmentService;
    public function __construct( DepartmentService $departmentService){
        $this->departmentService = $departmentService;
    }

    public function index(Request $request)
    {
        $departments = $this->departmentService
            ->getWithsearchFilters($request->all());

        return view('department.index', compact('departments'));
    }

    // Show create form
    public function create()
    {
        return view('department.create');
    }

    // Store new department
    public function store(StoreDepartmentRequest $request)
    {
        $this->departmentService->store($request->validated());
        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully!');
    }

    //  Show edit form
    public function edit($id)
    {
        $department = Department::findOrFail($id);
        return view('department.edit', compact('department'));
    }

    // Update department
    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $this->departmentService->update($department, $request->validated());
        return redirect()->route('departments.index')->with('success', 'Department updated successfully!');
    }

    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();

        return redirect()->back()
            ->with('success', 'Department deleted successfully!');
    }

    // Show single department (optional)
    public function show($id)
    {
        $department = Department::findOrFail($id);
        // $scheduleInClass = $department->schedules()->with('teacher', 'subject')->get();

        return view('department.show', compact('department'));
    }
}
