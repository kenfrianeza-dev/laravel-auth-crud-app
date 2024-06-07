<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request) {
        return view('auth.register');
    }

    public function registerUser(Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        if ($user) {
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }
}
