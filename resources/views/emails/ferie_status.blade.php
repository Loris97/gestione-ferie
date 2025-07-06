@php
    // Prepara i dati per la mail: nome, cognome, date e stato in italiano
    $nome = ucfirst($dipendente->nome);
    $cognome = ucfirst($dipendente->cognome);
    $dal = \Carbon\Carbon::parse($ferie->data_inizio)->format('d/m/Y');
    $al = \Carbon\Carbon::parse($ferie->data_fine)->format('d/m/Y');
    $statoTesto = $stato === 'approvato' ? 'approvate' : 'rifiutate';
@endphp

{{-- Corpo della mail formale inviata al dipendente --}}
<p>
    Gentile {{ $nome }} {{ $cognome }},<br>
    le sue ferie dal {{ $dal }} al {{ $al }} sono state <strong>{{ $statoTesto }}</strong>.<br>
    Cordiali saluti,<br>
    Team Gestione-Ferie LV
</p>