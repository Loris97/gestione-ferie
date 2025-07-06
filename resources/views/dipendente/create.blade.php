@extends('layouts.app')
@section('title', 'Aggiungi Dipendente')
@section('content')
<h2>Aggiungi Dipendente</h2>

<div class="wrapper">
    {{-- Form per la creazione di un nuovo dipendente --}}
    <form method="POST" action="{{ route('dipendente.store') }}">
        @csrf

        <h4>Dati Dipendente</h4>
        <p>Compila il form per creare un account.</p>
        <div>
            <label for="nome">Nome:</label>
            <input type="text" name="nome" required>
        </div>
        <div>
            <label for="cognome">Cognome:</label>
            <input type="text" name="cognome" required>
        </div>
        <div>
            <label for="codice_fiscale">Codice Fiscale:</label>
            <input type="text" name="codice_fiscale" required>
        </div>
        <div>
            <h4>Dati Account</h4>
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" required>
            </div>
            <div>
                <label for="password">Password temporanea:</label>
                <input type="password" name="password" required>
            </div>
            <div>
                <button type="submit">Crea Dipendente</button>
                <a href="{{ route('admin.home') }}" class="btn-link">Torna alla home</a>
            </div>
        </div>
    </form>
</div>
@endsection