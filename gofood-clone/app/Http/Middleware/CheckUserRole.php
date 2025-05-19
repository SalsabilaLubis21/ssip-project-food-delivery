<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
{
    error_log('Middleware CheckUserRole dijalankan');
    
    if (!session()->has('user_role')) {
        error_log('User role belum ada di session, mengarahkan ke select.role');
        return redirect()->route('select.role');
    }
    
    error_log('User role terdeteksi, lanjut ke dashboard');
    return $next($request);
}

    
}
