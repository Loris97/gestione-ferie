<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class MustChangePassword
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && Auth::user()->must_change_password) {
            // Se non siamo già sulla pagina di cambio password, reindirizza
            if (!$request->is('auth/change-password') && !$request->is('logout')) {
                return redirect()->route('password.change');
            }
        }
        return $next($request);
    }
}
