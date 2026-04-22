<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class TeacherController extends Controller
{
    // =====================
    // LIST
    // =====================
    public function index()
    {
        $teachers = Teacher::latest()->get();
        return view('Teacher.index', compact('teachers'));
    }

    // =====================
    // CREATE FORM
    // =====================
    public function create()
    {
        return view('Teacher.create');
    }

    // =====================
    // STORE
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'teacher_code' => 'required|unique:teachers',
            'name'         => 'required',
            'email'        => 'required|email|unique:teachers',
            'password'     => 'required|min:6',
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('teachers', 'public');
        }

        Teacher::create([
            'teacher_code' => $request->teacher_code,
            'name'         => $request->name,
            'gender'       => $request->gender,
            'dob'          => $request->dob,
            'phone'        => $request->phone,
            'email'        => $request->email,
            'subject'      => $request->subject,
            'password'     => Hash::make($request->password),
            'image'        => $imagePath,
        ]);
User::create([
            'name'     => $request->name,
            'email'    => $request->email ?? $request->student_code . '@student.com',
            'password' => Hash::make($request->password),
            'role'     => 'student',
        ]);
        return redirect()->route('teachers.index')
            ->with('success', 'Teacher created successfully');
    }

    // =====================
    // EDIT
    // =====================
    public function edit($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('Teacher.edit', compact('teacher'));
    }

    // =====================
    // UPDATE
    // =====================
    public function update(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $request->validate([
            'teacher_code' => 'required|unique:teachers,teacher_code,' . $id,
            'name'         => 'required',
            'email'        => 'required|email|unique:teachers,email,' . $id,
        ]);

        $data = $request->only([
            'teacher_code',
            'name',
            'gender',
            'dob',
            'phone',
            'email',
            'subject',
        ]);

        // PASSWORD UPDATE (optional)
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // IMAGE UPDATE
        if ($request->hasFile('image')) {

            // delete old image
            if ($teacher->image) {
                Storage::disk('public')->delete($teacher->image);
            }

            $data['image'] = $request->file('image')->store('teachers', 'public');
        }

        $teacher->update($data);

        return redirect()->route('teachers.index')
            ->with('success', 'Teacher updated successfully');
    }

    // =====================
    // DELETE
    // =====================
    public function destroy($id)
    {
        $teacher = Teacher::findOrFail($id);

        // delete image
        if ($teacher->image) {
            Storage::disk('public')->delete($teacher->image);
        }

        $teacher->delete();

        return back()->with('success', 'Teacher deleted successfully');
    }
}
