<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 🔍 Debugging: Print request data to check if password is received
        if (!$request->has('password')) {
            return back()->withErrors(['password' => 'Password field is missing!']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // ✅ Explicitly setting password (Prevents empty password error)
        $password = $request->password ?? 'defaultpassword'; // 🚀 Fallback value for debugging

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($password), // 🔥 Ensure hashing!
        ]);

        // 🔍 Debugging: Confirm if user was created
        if (!$user) {
            return back()->withErrors(['error' => 'User registration failed!']);
        }

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
