<?php
namespace App\Services;

use App\Models\User;

class UserService
{

    public function store(array $data): User
    {
        $user = \App\Models\User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
            'role'     => 'student',
        ]);
        return $user;
    }
    // public function updateProfile($request, $user, $validated)
    // {
    //     $user->update([
    //         'name'  => $validated['name'],
    //         'email' => $validated['email'],
    //     ]);

    //     $this->uploadProfileImage($request, $user);
    // }

    // public function uploadProfileImage($request, $user)
    // {
    //     if (!$request->hasFile('image')) {
    //         return;
    //     }

    //     // Student
    //     if ($user->student) {

    //         if ($user->student->image) {
    //             Storage::disk('public')
    //                 ->delete($user->student->image);
    //         }

    //         $pathStore = $request->file('image')
    //                         ->store('students', 'public');

    //         $user->student->update([
    //             'image' => $pathStore
    //         ]);
    //     }

    //     // Teacher
    //     elseif ($user->teacher) {

    //         if ($user->teacher->image) {
    //             Storage::disk('public')
    //                 ->delete($user->teacher->image);
    //         }

    //         $pathStore = $request->file('image')
    //                         ->store('teachers', 'public');

    //         $user->teacher->update([
    //             'image' => $pathStore
    //         ]);
    //     }
    //     else {

    //         if ($user->image) {
    //             Storage::disk('public')
    //                 ->delete($user->image);
    //         }

    //         $pathStore = $request->file('image')
    //                         ->store('users', 'public');

    //         $user->update([
    //             'image' => $pathStore
    //         ]);
    //     }
    // }

}
