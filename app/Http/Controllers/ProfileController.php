<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserProfile;

class ProfileController extends Controller
{
    public function show()
    {
        $profile = UserProfile::where('user_id', Auth::id())->first();
        return view('profile.show', compact('profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
        ]);
        $profile = UserProfile::where('user_id', Auth::id())->first();
        $profile->update($request->only(['name', 'email']));
        return back()->with('success', 'Profile updated.');
    }
}
