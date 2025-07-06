<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ferie extends Model
{
    protected $table = 'ferie';
    protected $fillable = [
        'idDipendente',   // FK al dipendente che chiede ferie
        'data_inizio',
        'data_fine',
        'stato',          // 'in attesa', 'approvato', 'rifiutato'
    ];

    // Relazione: una richiesta ferie appartiene a un dipendente
    public function dipendente()
    {
        return $this->belongsTo(Dipendente::class, 'idDipendente');
    }

    public function giorniRichiesti()
    {
        return Carbon::parse($this->data_inizio)
            ->diffInDays(Carbon::parse($this->data_fine)) + 1;
    }
}
