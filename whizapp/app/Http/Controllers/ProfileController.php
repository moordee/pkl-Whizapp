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
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'phone'    => 'nullable|string|max:20',
            'gender'   => 'nullable|string|max:50',
            'address'  => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user->name    = $validated['name'];
        $user->email   = $validated['email'];
        $user->phone   = $validated['phone'] ?? $user->phone;
        $user->gender  = $validated['gender'] ?? $user->gender;
        $user->address = $validated['address'] ?? $user->address;

        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

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
