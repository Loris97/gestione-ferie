<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Middleware che permette l'accesso solo agli utenti con ruolo 'admin'.
     */
    public function handle(Request $request, Closure $next)
    {
        // Se l'utente è autenticato e ha ruolo admin, prosegue la richiesta
        if (Auth::check() && Auth::user()->ruolo === 'admin') {
            return $next($request);
        }
        // Altrimenti, reindirizza alla pagina di login
        return redirect('/login');
    }
}
