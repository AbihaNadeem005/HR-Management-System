<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = [
            'email' => trim($request->email),
            'password' => trim($request->password),
        ];

        // Attempt login
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate(); // prevent session fixation
            return redirect()->route('dashboard')->with('success', 'Login successful');
        }

        // If login fails, redirect back with error
        return back()->with('error', 'Incorrect email or password.');
    }

    /**
     * Handle user registration
     */
    public function register(Request $request)
    {
        // Validate signup input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|confirmed|min:6',
        ]);

        // Create new user
        $user = User::create([
            'name' => trim($request->name),
            'email' => trim($request->email),
            'password' => Hash::make(trim($request->password)), // bcrypt password
        ]);

        // Auto-login the new user
        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Account created and logged in successfully');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Logged out successfully');
    }
}
