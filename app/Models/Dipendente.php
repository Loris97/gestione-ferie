<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Dipendente extends Model
{
    // Relazione: un dipendente ha un utente associato
    public function user()
    {
        return $this->hasOne(User::class, 'fk_dipendente');
    }

    // Nome della tabella nel database
    protected $table = 'dipendenti';

    // Campi assegnabili in massa
    protected $fillable = [
        'nome',
        'cognome',
        'codice_fiscale',
    ];

    // Relazione: un dipendente ha molte ferie
    public function ferie()
    {
        return $this->hasMany(Ferie::class);
    }

    // Calcola i giorni di ferie già goduti (approvati)
    public function ferieGodute()
    {
        $usate = $this->ferie()
            ->where('stato', 'approvato')
            ->sum(DB::raw('DATEDIFF(data_fine, data_inizio) + 1'));

        return $usate;
    }

    // Calcola le ferie residue (es: 30 giorni totali - ferie usate)
    public function ferieResidue()
    {
        $totali = 30; // ferie totali annuali

        // Somma i giorni di ferie approvate
        $usate = $this->ferie()
            ->where('stato', 'approvato')
            ->get()
            ->sum(function ($feria) {
                return Carbon::parse($feria->data_fine)
                    ->diffInDays(Carbon::parse($feria->data_inizio)) + 1;
            });

        $residuo = $totali - $usate;

        // Non permette valori negativi
        return max(0, $residuo);
    }
}
