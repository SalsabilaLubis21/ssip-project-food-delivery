<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RestaurantMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('restaurant')->check()) {
            return redirect()->route('login');
        }
        return $next($request);
    }
}

?>