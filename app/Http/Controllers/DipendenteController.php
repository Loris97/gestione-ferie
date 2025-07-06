<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Dipendente;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DipendenteController extends Controller
{
    /**
     * Mostra la home del dipendente con i suoi dati e le sue ferie.
     */
    public function index()
    {
        $user = Auth::user(); // Ottiene l'utente autenticato
        if (!$user) {
            abort(401, 'Utente non autenticato');
        }

        $dipendente = $user->dipendente; // Relazione user->dipendente
        $resFerie = $dipendente->ferieGodute(); // Giorni di ferie goduti
        if (!$dipendente) {
            abort(403, 'Dipendente non associato');
        }
        // Recupera tutte le ferie del dipendente ordinate per data
        $ferie = $dipendente->ferie()->orderBy('data_inizio', 'desc')->get();

        // Passa i dati alla view
        return view('dipendente.home', compact('dipendente', 'ferie', 'resFerie'));
    }

    /**
     * Salva un nuovo dipendente e crea anche l'account utente associato.
     */
    public function store(Request $request)
    {
        // Valida i dati del form
        $request->validate([
            'nome' => 'required|string|max:50',
            'cognome' => 'required|string|max:50',
            'codice_fiscale' => 'required|string|max:16|unique:dipendenti',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        // Crea il dipendente
        $dipendente = Dipendente::create([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'codice_fiscale' => $request->codice_fiscale,
        ]);

        // Crea l'utente associato al dipendente
        User::create([
            'name' => $request->nome,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ruolo' => 'dipendente',
            'must_change_password' => true, // obbliga il cambio password al primo accesso
            'fk_dipendente' => $dipendente->id,
        ]);

        // Reindirizza alla home admin con messaggio di successo
        return redirect('/admin')->with('success', 'Dipendente e account creati con successo.');
    }

    /**
     * Mostra il form per creare un nuovo dipendente.
     */
    public function create()
    {
        return view('dipendente.create');
    }

    /**
     * Mostra il form per modificare un dipendente.
     */
    public function edit($id)
    {
        $dipendente = Dipendente::findOrFail($id);
        $user = $dipendente->user; // relazione dipendente->user

        return view('dipendente.edit', compact('dipendente', 'user'));
    }

    /**
     * Aggiorna i dati di un dipendente e dell'utente associato.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'cognome' => 'required|string|max:255',
            'codice_fiscale' => 'required|string|max:16',
            'email' => 'required|email|max:255',
        ]);

        $dipendente = Dipendente::findOrFail($id);
        $user = $dipendente->user;

        // Aggiorna i dati del dipendente
        $dipendente->update([
            'nome' => $request->nome,
            'cognome' => $request->cognome,
            'codice_fiscale' => $request->codice_fiscale,
        ]);

        // Aggiorna l'email dell'utente associato
        $user->update([
            'email' => $request->email,
        ]);

        return redirect()->route('admin.home')->with('success', 'Dati aggiornati con successo.');
    }

    /**
     * Elimina un dipendente e l'utente associato.
     */
    public function destroy($id)
    {
        $dipendente = Dipendente::findOrFail($id);
        $dipendente->user->delete(); // elimina l'utente
        $dipendente->delete(); // elimina il dipendente

        return redirect()->route('admin.home')->with('success', 'Dipendente eliminato con successo.');
    }
}
