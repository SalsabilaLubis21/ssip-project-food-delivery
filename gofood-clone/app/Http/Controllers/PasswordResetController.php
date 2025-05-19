<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class PasswordResetController extends Controller
{
    
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

   
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
        ]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

  
    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    
    public function processReset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:user,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                // Regenerate session untuk login otomatis setelah reset password berhasil
                Auth::login($user);
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('dashboard')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    
    public function resetDirectly(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:user,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email tidak ditemukan.']);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('login')->with('success', 'Password berhasil diubah! Silakan login dengan password baru Anda.');
    }
}
