<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ForgetPasswordController extends Controller
{
    // forget password page route
    public function forgetPassword() {
        return view('forget-password');
    }

    // handles the forgetting of password
    public function forgetPasswordPost(Request $request) {

        // validate the input field and check if the email is valid and exists in the database, if not throw a warning
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // generate a random string that represents the token
        $token = Str::random(64);

        // selects the password_reset_tokens table and then inserting the email, token and the current date and time
        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // sends a reset password email to the email that was sent to
        Mail::send('emails.forget-password', ['token' => $token], function($message) use ($request) {
            $message->to($request->email)->subject('Reset Password');
        });

        // after sending the email, throws a success message
        return redirect('forget-password')
            ->with('success', 'Check your email, we have sent the reset password!');
    }

    // returns the new password route with a token
    public function resetPassword($token) {
        return view('new-password', compact('token'));
    }

    // handles the resetting of the password
    public function resetPasswordPost(Request $request) {

        // validates the email, password and password confirmation if it's valid and the password and password confirmation matches
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        // fetches a password reset token from the database for a specific email and token combination, if it exists.
        $updatePassword = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        // if it's not match redirect to reset password including the token and then throw an error or warning
        if (!$updatePassword) {
            return redirect()
                ->route('reset-password', ['token' => $request->token])
                ->with('error', 'Invalid token or email.');
        }

        // if the condition above passed, this will update the password of the current user
        User::where('email', $request->email)->update(['password' => Hash::make($request->password)]);

        // after that, the user's token will get deleted from the database
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        // and then redirects to the  login  page if it succeeds, throws a success message
        return redirect('login')->with('success', 'Password reset successfully, Login using your new password');
    }
}
