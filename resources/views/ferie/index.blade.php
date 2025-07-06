@extends('layouts.app') {{-- Estende il layout principale --}}

@section('content')
<a href="{{ route('admin.home') }}" class="btn-link">← Torna alla home</a> {{-- Link per tornare alla home admin --}}

<h2>Ferie di {{ $dipendente->nome }} {{ $dipendente->cognome }}</h2> {{-- Titolo con nome e cognome del dipendente --}}

<table>
    <thead>
        <tr>
            <th>Data Inizio</th>
            <th>Data Fine</th>
            <th>Giorni Richiesti</th>
            <th>Stato</th>
            <th>Azioni</th>
        </tr>
    </thead>
    <tbody>
        {{-- Ciclo su tutte le ferie del dipendente --}}
        @foreach($ferie as $feria)
            <tr>
                {{-- Mostra la data di inizio in formato gg/mm/aaaa --}}
                <td>{{ \Carbon\Carbon::parse($feria->data_inizio)->format('d/m/Y') }}</td>
                {{-- Mostra la data di fine in formato gg/mm/aaaa --}}
                <td>{{ \Carbon\Carbon::parse($feria->data_fine)->format('d/m/Y') }}</td>
                {{-- Mostra i giorni richiesti (funzione nel model Ferie) --}}
                <td>{{ $feria->giorniRichiesti() }}</td>
                {{-- Mostra lo stato attuale della richiesta ferie --}}
                <td>{{ $feria->stato }}</td>
                <td>
                    {{-- Form per cambiare lo stato della richiesta ferie --}}
                    <form method="POST" action="{{ route('ferie.updateStatus', $feria->id) }}">
                        @csrf {{-- Token di sicurezza contro CSRF --}}
                        @method('PATCH') {{-- Metodo PATCH per aggiornare lo stato --}}
                        {{-- Select per scegliere lo stato: Approva o Rifiuta.
                             Se la richiesta è già approvata o rifiutata, la select è disabilitata --}}
                        <select name="stato" required {{ in_array($feria->stato, ['approvato', 'rifiutato']) ? 'disabled' : '' }}>
                            <option value="approvato" {{ $feria->stato === 'approvato' ? 'selected' : '' }}>Approva</option>
                            <option value="rifiutato" {{ $feria->stato === 'rifiutato' ? 'selected' : '' }}>Rifiuta</option>
                        </select>
                        {{-- Bottone per salvare la modifica.
                             Se la richiesta è già approvata o rifiutata, il bottone è disabilitato --}}
                        <button type="submit" {{ in_array($feria->stato, ['approvato', 'rifiutato']) ? 'disabled' : '' }}>Salva</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
