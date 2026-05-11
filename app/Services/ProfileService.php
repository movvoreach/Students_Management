<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function updateProfile(
        int $userId,
        array $data,
        Request $request
    ): User {

        $user = User::with(['student', 'teacher'])
            ->findOrFail($userId);

        /*
        |--------------------------------------------------------------------------
        | Basic Info
        |--------------------------------------------------------------------------
        */

        $user->name  = $data['name'];
        $user->email = $data['email'];

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('image')) {

            $this->ProfileImageUpload($user, $request);
        }

        $user->save();

        return $user;
    }

    /*
    |--------------------------------------------------------------------------
    | Handle Image Upload
    |--------------------------------------------------------------------------
    */

    public function ProfileImageUpload(User $user, Request $request): void
    {
        if ($user->student) {

            $this->deleteOldImage($user->student->image);

            $path = $request->file('image')
                ->store('students', 'public');

            $user->student->update([
                'image' => $path
            ]);

        } elseif ($user->teacher) {

            $this->deleteOldImage($user->teacher->image);

            $path = $request->file('image')
                ->store('teachers', 'public');

            $user->teacher->update([
                'image' => $path
            ]);

        } else {

            $this->deleteOldImage($user->image);

            $path = $request->file('image')
                ->store('users', 'public');

            $user->image = $path;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Old Image
    |--------------------------------------------------------------------------
    */

    public function deleteOldImage(?string $image): void
    {
        if ($image && Storage::disk('public')->exists($image)) {

            Storage::disk('public')->delete($image);
        }
    }

    public function updatePassword(array $data)
    {
        $user = User::find(Auth::id());

        // Check current password
        if (!Hash::check($data['current_password'], $user->password)) {
            return [
                'status' => false,
                'message' => 'Current password is incorrect.'
            ];
        }

        // Check new password confirmation
        if ($data['new_password'] !== $data['password_confirmation']) {
            return [
                'status' => false,
                'message' => 'New password and confirmation do not match.'
            ];
        }

        // Update password
        $user->password = Hash::make($data['new_password']);
        $user->save();

        return [
            'status' => true,
            'message' => 'Password updated successfully.'
        ];
    }

}
