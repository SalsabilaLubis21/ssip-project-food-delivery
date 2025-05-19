<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the role selection form.
     * Middleware 'guest' di routes/web.php akan menangani redirect jika sudah login.
     *
     * @return \Illuminate\View\View
     */
    public function showSelectRoleForm()
    {
        
        return view('auth.select-role');
    }

    public function processSelectRole(Request $request)
    {
        $role = $request->input('role'); 
        session(['user_role' => $role]); 
        
        
        switch ($role) {
            case 'driver':
                return redirect()->route('driver.login');
            case 'restaurant':
                return redirect()->route('restaurant.login');
            case 'user':
            default:
                return redirect()->route('login');
        }
    }

    /**
     * Show the login form for regular users (guard: web).
     * Middleware 'guest' di routes/web.php akan menangani redirect jika sudah login.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        
        return view('auth.login', ['guard' => 'web']);
    }

    /**
     * Show the driver-specific login form (guard: driver).
     * Middleware 'guest' di routes/web.php akan menangani redirect jika sudah login.
     *
     * @return \Illuminate\View\View
     */
    public function showDriverLoginForm()
    {
         
        return view('auth.driver-login', ['guard' => 'driver']);
    }

    

    /**
     * Show the restaurant-specific login form (guard: restaurant).
     * Middleware 'guest' di routes/web.php akan menangani redirect jika sudah login.
     *
     * @return \Illuminate\View\View
     */
    public function showRestaurantLoginForm()
    {
         
        return view('auth.restaurant-login', ['guard' => 'restaurant']);
    }

    /**
     * Process login for all types of users based on the hidden 'guard' input.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function processLogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            Auth::login($user);
            session(['role' => $user->role]); 
            return redirect()->route('dashboard');
        }
    
       
        $restaurant = \App\Models\Restaurant::where('email', $credentials['email'])->first();
        if ($restaurant && Hash::check($credentials['password'], $restaurant->password)) {
            Auth::guard('restaurant')->login($restaurant);
            session(['role' => $restaurant->role]);
            return redirect()->route('restaurant.dashboard');
        }
    
      
        $driver = \App\Models\Driver::where('email', $credentials['email'])->first();
        if ($driver && Hash::check($credentials['password'], $driver->password)) {
            Auth::guard('driver')->login($driver);
            session(['role' => $driver->role]);
            return redirect()->route('driver.dashboard');
        }
    
        return back()->withErrors(['error' => 'Email atau password salah']);
    }

    /**
     * Redirect user based on which guard they're authenticated with.
     * Pastikan nama rute ('dashboard', 'driver.dashboard', 'restaurant.dashboard')
     * sesuai dengan yang didefinisikan di routes/web.php.
     *
     * @param string|null $guard Guard yang baru saja berhasil login, atau null jika dicek saat request biasa.
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectBasedOnAuthGuard($guard = null)
    {
        
        if ($guard === null) {
            if (Auth::guard('web')->check()) {
                $guard = 'web';
            } elseif (Auth::guard('driver')->check()) {
                $guard = 'driver';
            } elseif (Auth::guard('restaurant')->check()) {
                $guard = 'restaurant';
            } else {
                
                return redirect()->route('select.role');
            }
        }

        
        if ($guard === 'web') {
            
            return redirect()->intended(route('dashboard'));
        } elseif ($guard === 'driver') {
            return redirect()->intended(route('driver.dashboard'));
        } elseif ($guard === 'restaurant') {
            return redirect()->intended(route('restaurant.dashboard'));
        }

        
        Log::error('Unknown guard detected in redirectBasedOnAuthGuard', ['guard' => $guard]);
        return redirect()->route('select.role');
    }

    /**
     * Log the user out from all guards.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $loggedOutGuard = null;

      
        if (Auth::guard('web')->check()) {
            $loggedOutGuard = 'web';
            Auth::guard('web')->logout();
        } elseif (Auth::guard('driver')->check()) { 
            $loggedOutGuard = 'driver';
            Auth::guard('driver')->logout();
        } elseif (Auth::guard('restaurant')->check()) {
            $loggedOutGuard = 'restaurant';
            Auth::guard('restaurant')->logout();
        }

        if ($loggedOutGuard) {
            Log::info('User logged out', ['guard' => $loggedOutGuard]);
        } else {
             Log::info('Logout requested but no authenticated guard found.');
        }

        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        
        return redirect()->route('select.role');
    }

    public function processRestaurantLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('restaurant')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('restaurant.dashboard');
        }

        return back()->withErrors([
            'login' => 'Email atau password salah',
        ]);
    }

    public function processDriverLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('driver')->attempt($credentials)) {
            return redirect()->route('driver.dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }

    public function processUserLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('web')->attempt($credentials)) {
            return redirect()->route('dashboard')->with('success', 'Login successful!');
        }

        return back()->withErrors(['email' => 'Invalid email or password.']);
    }
}