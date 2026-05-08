<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{

    //
    public function index()
    {
        $user = User::with(['student', 'teacher'])
            ->find(auth()->id());

        return view('Profile.index', compact('user'));
    }

    public function update(Request $request)
    {

        $user = User::with(['student', 'teacher'])->find(auth()->id());

        // Validate form data
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Update basic user info
        $user->name  = $request->name;
        $user->email = $request->email;

        // Check if user uploaded a new image
        if ($request->hasFile('image')) {

            // Store image depending on user type
            if ($user->student) {

                // Delete old student image
                if ($user->student->image) {
                    Storage::disk('public')->delete($user->student->image);
                }

                // Upload new image
                $path = $request->file('image')->store('students', 'public');

                // Save new image path
                $user->student->image = $path;
                $user->student->save();

            } elseif ($user->teacher) {

                // Delete old teacher image
                if ($user->teacher->image) {
                    Storage::disk('public')->delete($user->teacher->image);
                }

                $path = $request->file('image')->store('teachers', 'public');

                // Save new image path
                $user->teacher->image = $path;
                $user->teacher->save();

            } else {

                // Delete old user image
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }

                // Upload new image
                $path = $request->file('image')->store('users', 'public');

                // Save new image path
                $user->image = $path;
            }
        }

        // Save user data
        $user->save();

        // Redirect back with success message
        return redirect()
            ->route('profile.show', auth()->id())
            ->with('success', 'Profile updated successfully.');
    }
    public function updatePassword(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'current_password'      => 'required',
            'new_password'          => 'required|min:6',
            'password_confirmation' => 'required|min:6',
        ]);
        // dd($request->all());
        $user = User::find(auth()->id());

        $currentPassword = Hash::check($request->current_password, $user->password);
        if (! $currentPassword) {
            return redirect()->route('profile.show', auth()->id())->withErrors(['current_password' => 'Current password is incorrect.']);
        }
        if ($request->new_password !== $request->password_confirmation) {
            return redirect()->route('profile.show', auth()->id())->withErrors(['new_password' => 'New password and confirmation do not match.']);
        }
        $user->password = Hash::make($request->new_password);
        $user->save();

        // Update password

        return redirect()
            ->route('profile.show', auth()->id())
            ->with('success', 'Password updated successfully.');
    }
}
