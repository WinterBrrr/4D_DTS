<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    public function show()
    {
        // If the user is a handler, redirect to the handler-exclusive profile
        if (Auth::user() && Auth::user()->role === 'handler') {
            return redirect()->route('handler.profile');
        }
        $profile = UserProfile::where('user_id', Auth::id())->first();
        return view('profile.show', compact('profile'));
    }

    public function showHandler()
    {
        if (Auth::user()->role !== 'handler') {
            abort(403, 'Unauthorized');
        }
        $profile = UserProfile::where('user_id', Auth::id())->first();
        // If department is empty, flash a message and highlight the field
        if (!$profile || empty($profile->department)) {
            session()->flash('require_department', true);
            session()->flash('error', 'Please add your department to continue.');
        }
        return view('profile.handler-show', compact('profile'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        $fields = [
            'nickname' => 'nullable|string|max:255',
            'full_name' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'department' => 'nullable|string|max:255',
            'age' => 'nullable|integer|min:1|max:120',
            'occupation' => 'nullable|string|max:255',
            'nationality' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500',
            'gender' => 'nullable|in:Male,Female',
        ];
        $validated = $request->validate($fields);

        // Update user table for name/email
        if ($user) {
            $user->fill([
                'name' => $validated['full_name'] ?? $user->name,
                'email' => $validated['email'] ?? $user->email,
            ])->save();
        }

        // Update user_profiles table for all profile fields, including department
        $profile = UserProfile::firstOrCreate(['user_id' => $user->id]);
        $profile->fill([
            'nickname' => $validated['nickname'] ?? $profile->nickname,
            'department' => array_key_exists('department', $validated) ? $validated['department'] : $profile->department,
            'age' => $validated['age'] ?? $profile->age,
            'occupation' => $validated['occupation'] ?? $profile->occupation,
            'nationality' => $validated['nationality'] ?? $profile->nationality,
            'contact_number' => $validated['contact_number'] ?? $profile->contact_number,
            'address' => $validated['address'] ?? $profile->address,
            'gender' => $validated['gender'] ?? $profile->gender,
        ])->save();

        // Log department value for debugging
        \Log::info('Profile update department', [
            'user_id' => $user->id,
            'validated_department' => $validated['department'] ?? null,
            'profile_department' => $profile->department,
        ]);

        return back()->with('success', 'Profile updated');
    }
}
