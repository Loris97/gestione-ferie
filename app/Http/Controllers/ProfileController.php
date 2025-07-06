<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

/**
 * Controller per la gestione del profilo utente (admin e dipendente).
 */
class ProfileController extends Controller
{
    /**
     * Mostra il form di modifica del profilo.
     * @param Request $request
     * @return View
     */
    public function edit(Request $request): View
    {
        // Passa l'utente autenticato alla view
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Aggiorna i dati del profilo utente.
     * @param ProfileUpdateRequest $request
     * @return RedirectResponse
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        // Aggiorna i dati validati (solo email e password)
        $user->fill($request->validated());

        // Se l'email è cambiata, azzera la verifica
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Se è stata inserita una nuova password, aggiorna e hasha
        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->save();

        // Redirect con messaggio di successo
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Elimina l'account utente.
     * Richiede la password attuale per sicurezza.
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
