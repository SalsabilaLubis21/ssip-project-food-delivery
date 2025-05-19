<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function processLogin(Request $request)
    {
        $request->validate([
            'login' => 'required' // 🔹 Bisa berupa email atau nomor handphone
        ]);

        // 🔍 Cari user berdasarkan email atau nomor telepon
        $user = User::where('email', $request->login)
                    ->orWhere('phone', $request->login)
                    ->first();

        if ($user) {
            session(['user' => $user]); // 🔹 Simpan user ke sesi tanpa password
            return redirect('/dashboard');
        }

        return back()->withErrors(['login' => 'Email atau nomor handphone tidak terdaftar']);
    }

    public function logout()
    {
        session()->forget('user');
        return redirect('/login');
    }
}
