@extends('layouts.app')

@section('title', 'Home Admin')

@section('content')
<h1>Pannello di amministrazione</h1>
<h2>Elenco dipendenti</h2>

{{-- Pulsante per aggiungere un nuovo dipendente --}}
<center>
    <a href="{{ route('dipendente.create') }}">Aggiungi dipendenti</a>
</center>

<table>
    <thead>
        <tr>
            <th>Matricola</th>
            <th>Cognome</th>
            <th>Nome</th>
            <th>Codice Fiscale</th>
            <th>Ferie godute</th>
            <th>Ferie residue</th>
            <th>Aggiorna dati</th>
            <th>Gestione Ferie</th>
        </tr>
    </thead>
    <tbody>
        {{-- Ciclo su tutti i dipendenti per mostrare i dati nella tabella --}}
        @foreach($dipendenti as $dip)
            <tr>
                {{-- ID del dipendente (matricola) --}}
                <td>{{ $dip->id }}</td>
                {{-- Cognome del dipendente --}}
                <td>{{ $dip->cognome }}</td>
                {{-- Nome del dipendente --}}
                <td>{{ $dip->nome }}</td>
                {{-- Codice fiscale del dipendente --}}
                <td>{{ $dip->codice_fiscale }}</td>
                {{-- Ferie godute (calcolate tramite metodo nel model) --}}
                <td>{{ $dip->ferieGodute() }}</td>
                {{-- Ferie residue (calcolate tramite metodo nel model) --}}
                <td>{{ $dip->ferieResidue() }}</td>
                <td>
                    {{-- Link per modificare i dati del dipendente --}}
                    <a href="{{ route('dipendente.edit', $dip->id) }}">Aggiorna</a> |
                    {{-- Form per eliminare il dipendente, con conferma tramite popup --}}
                    <form method="POST" action="{{ route('dipendente.destroy', $dip->id) }}" style="display:inline;" onsubmit="return confirm('Sei sicuro di voler eliminare questo dipendente?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:red; background:none; border:none; cursor:pointer;">Elimina</button>
                    </form>
                </td>
                <td>
                    {{-- Link per visualizzare e gestire le ferie del dipendente --}}
                    <a href="{{ route('ferie.dipendente', $dip->id) }}">Visualizza Ferie</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
