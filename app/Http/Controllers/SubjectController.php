<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubjectRequest;
use App\Http\Requests\UpdateSubjectRequest;
use App\Models\Department;
use App\Models\Subject;
use App\Services\SubjectService;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    //

    protected $subjectService;
    public function __construct( SubjectService $subjectService){
        $this->subjectService = $subjectService;
    }

     public function index()
    {
        $subjects = $this->subjectService->getWithsearchFilters(request()->all());
        $departments = Department::all();
        return view('subject.index', compact('subjects', 'departments'));
    }

    // Show create form
    public function create()
    {
        $departments = Department::all();
        return view('subject.create', compact('departments'));
    }

    // Store new subject
<<<<<<< HEAD
   public function store(StoreSubjectRequest $request)
    {
        //  dd($request->all());
        $this->subjectService->store($request->validated());

        return redirect()
            ->route('subjects.index')
=======
    public function store(Request $request)
    {
        dd($request->all());
        // $this->subjectService->store($request->validated());
        return redirect()->route('subjects.index')
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
            ->with('success', 'Subject created successfully!');
    }

    //  Show edit form
    public function edit($id)
    {
        $subject = Subject::findOrFail($id);
        $departments = Department::all();
        return view('subject.edit', compact('subject', 'departments'));
    }

    // Update subject
    public function update(UpdateSubjectRequest $request, Subject $subject)
    {
        $this->subjectService->update($subject, $request->validated());
        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully!');
    }

    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->back()
            ->with('success', 'Subject deleted successfully!');
    }

    // Show single subject (optional)
    public function show($id)
    {
        $subject = Subject::findOrFail($id);
<<<<<<< HEAD
        $department = Department::all();
        // $scheduleInClass = $subject->schedules()->with('teacher', 'subject')->get();

        return view('subject.show', compact('subject', 'department'));
=======
        $departments = Department::all();
        // $scheduleInClass = $subject->schedules()->with('teacher', 'subject')->get();

        return view('subject.show', compact('subject'));
>>>>>>> 76e73daff4800ff2b39ac38c1463607781ccef23
    }
}
