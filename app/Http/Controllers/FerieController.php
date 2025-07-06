<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ferie;
use App\Models\Dipendente;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Mail\FerieStatusMail;
use Illuminate\Support\Facades\Mail;

/**
 * Controller per la gestione delle richieste ferie.
 * Permette a dipendenti di richiedere ferie e agli admin di approvarle/rifiutarle.
 */
class FerieController extends Controller
{
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
     * Aggiorna lo stato di una richiesta ferie (approvato/rifiutato) e invia una mail formale al dipendente.
     * Solo l'admin può eseguire questa azione.
     *
     * @param Request $request La richiesta HTTP contenente il nuovo stato.
     * @param int $id L'ID della richiesta ferie da aggiornare.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateStatus(Request $request, $id)
    {
        // Valida che il campo 'stato' sia presente e abbia un valore valido
        $request->validate([
            'stato' => 'required|in:approvato,rifiutato',
        ]);

        // Recupera la richiesta ferie dal database tramite ID
        $feria = Ferie::findOrFail($id);

        // Aggiorna lo stato della richiesta ferie (approvato o rifiutato)
        $feria->stato = $request->stato;
        $feria->save();

        // Recupera il dipendente associato alla richiesta ferie
        $dipendente = $feria->dipendente;

        if (!$dipendente || !$dipendente->user) {
            return redirect()->back()->withErrors(['msg' => 'Dipendente o utente associato non trovato.']);
        }

        // Recupera l'utente associato al dipendente (per ottenere l'email)
        $user = $dipendente->user;

        // Invia una mail formale al dipendente con l'esito della richiesta ferie
        // Usa la Mailable FerieStatusMail che riceve la richiesta ferie, il dipendente e lo stato
        Mail::to($user->email)->send(new FerieStatusMail($feria, $dipendente, $feria->stato));

        // Torna alla pagina precedente con un messaggio di successo
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
