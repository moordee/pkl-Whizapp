<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Display the user's profile edit form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('user', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        $userId = Auth::id();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($userId)],
            'password' => 'nullable|min:8|confirmed',
            'phone' => 'nullable|string',
            'gender' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }

    /**
     * Toggle dark mode for the user.
     */
    public function toggleDarkMode()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->dark_mode = !$user->dark_mode;
        $user->save();

        return back();
    }
}
