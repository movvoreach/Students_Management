<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreClassRequest;
use App\Http\Requests\UpdateClassRequest;
use App\Models\Classroom;
use App\Services\ClassService;

class ClassController extends Controller
{
    protected $classService;

    public function __construct()
    {
        // Instantiating the class directly
        $this->classService = new ClassService();
    }

    // Show all classes
    public function index()
    {
        $classes = $this->classService->getWithsearchFilters(request()->all());
        return view('class.index', compact('classes'));
    }

    // Show create form
    public function create()
    {
        return view('class.create');
    }

    // Store new class
    public function store(StoreClassRequest $request)
    {
        $this->classService->store($request->validated());
        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully!');
    }

    //  Show edit form
    public function edit($id)
    {
        $class = Classroom::findOrFail($id);
        return view('class.edit', compact('class'));
    }

    // Update class
    public function update(UpdateClassRequest $request, Classroom $classroom)
    {
        $this->classService->update($classroom, $request->validated());
        return redirect()->route('classes.index')->with('success', 'Class updated successfully!');
    }

    public function destroy($id)
    {
        $class = Classroom::findOrFail($id);
        $class->delete();

        return redirect()->back()
            ->with('success', 'Class deleted successfully!');
    }

    // Show single class (optional)
    public function show($id)
    {
        $class = Classroom::findOrFail($id);

        $scheduleInClass = Classroom::join('schedules', 'classes.id', '=', 'schedules.class_id')
            ->where('classes.id', $id)->get();

        return view('class.show', compact('class', 'scheduleInClass'));
    }

}
