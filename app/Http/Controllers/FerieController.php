<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ferie;
use App\Models\Dipendente;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

/**
 * Controller per la gestione delle richieste ferie.
 * Permette a dipendenti di richiedere ferie e agli admin di approvarle/rifiutarle.
 */
class FerieController extends Controller
{
    /**
     * Mostra la lista delle ferie (non implementato qui).
     */
    public function index()
    {
        //
    }

    /**
     * Mostra il form per creare una nuova richiesta ferie.
     */
    public function create()
    {
        return view('ferie.create'); // form per inserire richiesta
    }

    /**
     * Salva una nuova richiesta ferie nel database.
     * Valida le date e controlla che i giorni richiesti non superino le ferie residue.
     */
    public function store(Request $request)
    {
        $request->validate([
            'data_inizio' => 'required|date|after_or_equal:today',
            'data_fine' => 'required|date|after_or_equal:data_inizio',
        ]);
        $user = Auth::user();
        $dipendente = $user->dipendente;

        // Calcola i giorni richiesti
        $giorni_richiesti = Carbon::parse($request->data_inizio)
            ->diffInDays(Carbon::parse($request->data_fine)) + 1;

        // Recupera ferie residue
        $ferie_residue = $dipendente->ferieResidue();

        // Se i giorni richiesti superano le ferie residue, mostra errore
        if ($giorni_richiesti > $ferie_residue) {
            return back()->withErrors(['msg' => "Richiesta superiore al residuo ferie disponibile ($ferie_residue giorni)."]);
        }

        // Crea la richiesta ferie
        $dipendente->ferie()->create([
            'data_inizio' => $request->data_inizio,
            'data_fine' => $request->data_fine,
            'stato' => 'in attesa',
        ]);

        return redirect()->route('dipendente.home')->with('success', 'Richiesta ferie inviata con successo.');
    }

    /**
     * Mostra una richiesta ferie specifica (non implementato qui).
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Mostra il form per modificare una richiesta ferie (non implementato qui).
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Aggiorna una richiesta ferie (non implementato qui).
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Elimina una richiesta ferie (non implementato qui).
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Aggiorna lo stato di una richiesta ferie (approvato/rifiutato).
     * Solo l'admin può eseguire questa azione.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'stato' => 'required|in:approvato,rifiutato',
        ]);

        $feria = Ferie::findOrFail($id);
        $feria->stato = $request->stato;
        $feria->save();

        return redirect()->back()->with('success', 'Stato aggiornato con successo.');
    }

    /**
     * Mostra tutte le ferie di un dipendente specifico.
     * @param int $id ID del dipendente
     */
    public function showForDipendente($id)
    {
        $dipendente = Dipendente::with('ferie')->findOrFail($id);
        $ferie = $dipendente->ferie()->orderBy('data_inizio', 'desc')->get();

        return view('ferie.index', compact('dipendente', 'ferie'));
    }
}
