<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MyProfileController extends Controller
{
    // Show the profile view
    public function show()
    {
        $user = Auth::user();
        return view('back_end.preference.profile.show', compact('user'));
    }

    // Show the edit profile form
    public function edit()
    {
        $user = Auth::user();
        return view('back_end.preference.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'img_profile' => 'mimes:png,jpg,jpeg', // Adjusted allowed formats
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        $user->email = $request->email;

        // Update profile image if provided
        if ($request->hasFile('img_profile')) {
            // Delete the old profile image if it exists
            if ($user->img_profile && \Storage::disk('public')->exists($user->img_profile)) {
                \Storage::disk('public')->delete($user->img_profile);
            }

            // Store the new profile image in 'profiles' directory on the public disk
            $user->img_profile = $request->file('img_profile')->store('profiles', 'public');
        }

        $user->save();

        return redirect()->route('my-profile.show')->with('success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Check if current password matches
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password updated successfully');
    }
}
