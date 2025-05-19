<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class DriverMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Log for debugging purposes
        Log::info('DriverMiddleware called', [
            'path' => $request->path(),
            'auth_driver_check' => Auth::guard('driver')->check(),
            'auth_web_check' => Auth::check(),
            'all_guards' => array_keys(config('auth.guards')),
        ]);
        
        // Check if user is authenticated via driver guard
        if (!Auth::guard('driver')->check()) {
            Log::warning('DriverMiddleware: User not authenticated as driver');
            return redirect()->route('driver.login')
                ->with('error', 'Anda harus login sebagai driver untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}