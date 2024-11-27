<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class oginController extends Controller
{
    public function show()
    {
        return view('login');
    }

    public function login(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        // Attempt to log in the user
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            // Authentication passed
            return redirect()->intended('/home'); // Redirect to intended page
        }

        // If authentication fails, redirect back with an error message
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ]);
    }
    public function logout(Request $request)
    {
        Auth::logout(); // Log the user out
        return redirect('/login'); // Redirect to the welcome page or login page
    }

}
