@extends('layouts.app')
@section('title', 'Home Dipendente')
@section('content')
<h1>Benvenuto Dipendente</h1>
<div class="richFerie">
<div class="wrapper-wide">
    <h2>I tuoi dati</h2>
    {{-- Tabella con i dati anagrafici e ferie del dipendente --}}
    <table>
        <tr>
            <th>Matricola</th>
            <th>Cognome</th>
            <th>Nome</th>
            <th>Codice Fiscale</th>
            <th>Ferie Godute</th>
            <th>Ferie residue</th>
        </tr>
        <tr>
            <td>{{ $dipendente->id}}</td>
            <td>{{ $dipendente->cognome }}</td>
            <td>{{ $dipendente->nome }}</td>
            <td>{{ $dipendente->codice_fiscale }}</td>
            <td>{{ $dipendente->ferieGodute() }}</td>
            <td>{{ $dipendente->ferieResidue() }}</td>
        </tr>
    </table> 

    <h2>Ferie Richieste</h2>
    {{-- Tabella con tutte le richieste ferie del dipendente --}}
    <table>
        <thead>
            <tr>
                <th>Richiesta</th>
                <th>Data inizio</th>
                <th>Data fine</th>
                <th>Numero giorni</th>
                <th>Stato</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ferie as $feria)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ \Carbon\Carbon::parse($feria->data_inizio)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($feria->data_fine)->format('d/m/Y') }}</td>
                <td>{{ \Carbon\Carbon::parse($feria->data_inizio)->diffInDays(\Carbon\Carbon::parse($feria->data_fine)) + 1 }}</td>
                <td>{{ ucfirst($feria->stato) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="wrapper">
    <h2>Richiedi Ferie</h2>
    {{-- Mostra errori di validazione o messaggio di successo --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    {{-- Form per inviare una nuova richiesta ferie --}}
    <form method="POST" action="{{ route('ferie.store') }}">
        @csrf
        <label>Data Inizio</label>
        <input type="date" name="data_inizio" required>
        <label>Data Fine</label>
        <input type="date" name="data_fine" required>
        <button type="submit" class="btn-primary">
            Richiedi
        </button>
    </form>
</div>
</div>
@endsection
