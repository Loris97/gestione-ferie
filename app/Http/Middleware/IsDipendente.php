<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsDipendente
{
    /**
     * Middleware che permette l'accesso solo agli utenti con ruolo 'dipendente'.
     */
    public function handle(Request $request, Closure $next)
    {
        // Se l'utente è autenticato e ha ruolo dipendente, prosegue la richiesta
        if (Auth::check() && Auth::user()->ruolo === 'dipendente') {
            return $next($request);
        }
        // Altrimenti, reindirizza alla pagina di login
        return redirect('/login'); 
    }
}
