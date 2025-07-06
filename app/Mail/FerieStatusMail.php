<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Mailable per notificare al dipendente l'esito della richiesta ferie (approvata o rifiutata).
 */
class FerieStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    /** @var object $ferie La richiesta ferie */
    public $ferie;

    /** @var object $dipendente Il dipendente destinatario */
    public $dipendente;

    /** @var string $stato Stato della richiesta ('approvato' o 'rifiutato') */
    public $stato;

    /**
     * Costruttore: riceve la richiesta ferie, il dipendente e lo stato.
     */
    public function __construct($ferie, $dipendente, $stato)
    {
        $this->ferie = $ferie;
        $this->dipendente = $dipendente;
        $this->stato = $stato;
    }

    /**
     * Costruisce la mail, imposta l'oggetto e la view.
     */
    public function build()
    {
        return $this->subject('Esito richiesta ferie')
            ->view('emails.ferie_status');
    }
}
