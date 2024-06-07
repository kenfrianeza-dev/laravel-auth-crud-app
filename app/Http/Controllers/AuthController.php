<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // register page route
    public function register(Request $request) {
        return view('auth.register');
    }

    // this function handles the registration of user
    public function registerUser(Request $request) {
        // checks and validates the user input
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        // creating a new user instance and passes the credentials from the frontend
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // checks the user if succesfully registered, and then return the message to the frontend
        if ($user) {
            return back()->with('success', 'You have registered successfully');
        } else {
            return back()->with('error', 'Something went wrong');
        }
    }

    // login page route
    public function login(Request $request) {
        return view('auth.login');
    }

    // handles the login
    public function loginUser(Request $request) {
        // checks and validates the user input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|max:12',
        ]);

        // checks if the credentials exists or registered in the database, if it is redirect to the dashboard, else throw an error
        if (Auth::attempt($request->only('email', 'password'))) {
            return redirect()->intended('dashboard');
        } else {
            return back()->with('error', 'Invalid credentials');
        }
    }

    // dashboard page route
    public function dashboard(Request $request) {
        // creating an instance of all users and the current authenticated user
        $users = User::all();
        $user = Auth::user();

        // passing all the users and the current authenticated user from the database into the dashboard page
        return view('dashboard',  ['user' => $user, 'users' => $users]);
    }

    // handles the logging out of the user
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        // after logging out, redirect to the login page
        return redirect('login');
    }

    // handles the user delete
    public function destroy(User $user) {
        $user->delete();
        return redirect('dashboard')->with('success', 'User deleted successfully');
    }
}
