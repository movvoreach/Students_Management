<?php

namespace App\Http\Controllers;

use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassController extends Controller
{
    // 📋 Show all classes
    public function index()
    {
        $classes = Classroom::latest()->paginate(10);
        return view('Class.index', compact('classes'));
    }

    // ➕ Show create form
    public function create()
    {
        return view('Class.create');
    }

    // 💾 Store new class
    public function store(Request $request)
    {
        $request->validate([
            'class_name' => 'required|string|max:255',
            'table' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Classroom::create([
            'class_name' => $request->class_name,
            'table' => $request->table,
            'status' => $request->status,
        ]);

        return redirect()->route('classes.index')
            ->with('success', 'Class created successfully!');
    }

    // ✏️ Show edit form
    public function edit($id)
    {
        $class = Classroom::findOrFail($id);
        return view('Class.edit', compact('class'));
    }

    // 🔄 Update class
    public function update(Request $request, $id)
    {
        $class = Classroom::findOrFail($id);

        $request->validate([
            'class_name' => 'required|string|max:255',
            'table' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $class->update([
            'class_name' => $request->class_name,
            'table' => $request->table,
            'status' => $request->status,
        ]);

        return redirect()->route('classes.index')
            ->with('success', 'Class updated successfully!');
    }

    public function destroy($id)
    {
        $class = Classroom::findOrFail($id);
        $class->delete();

        return redirect()->back()
            ->with('success', 'Class deleted successfully!');
    }

    // 👁️ Show single class (optional)
    public function show($id)
    {
        $class = Classroom::findOrFail($id);
        return view('Class.show', compact('class'));
    }
}
