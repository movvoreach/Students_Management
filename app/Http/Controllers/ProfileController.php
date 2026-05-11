<?php
namespace App\Http\Controllers;

use App\Http\Requests\UpdatePasswordProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use App\Services\ProfileService;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }
    public function index()
    {
        $user = User::with(['student', 'teacher'])
            ->find(Auth::id());

        return view('profile.index', compact('user'));
    }

    public function update(UpdateProfileRequest $request)
    {
        $this->profileService->updateProfile(
            Auth::id(),
            $request->validated(),
            $request
        );

        return redirect()
            ->route('profile.show', Auth::id())
            ->with('success', 'Profile updated successfully.');
    }
    public function updatePassword(UpdatePasswordProfileRequest $request)
    {
        $result = $this->profileService->updatePassword($request->all());

        if (! $result['status']) {
            return redirect()->back()->withErrors([
                'error' => $result['message'],
            ]);
        }

        return redirect()->back()->with('success', $result['message']);
    }
}
