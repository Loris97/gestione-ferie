@extends('layouts.app')
@section('title', 'Modifica dati Dipendente')
@section('content')
 <h2>Aggiorna anagrafica dipendente</h2>
<form method="POST" action="{{ route('dipendente.update', $dipendente->id) }}">
    @csrf
    @method('PUT')

    <table>
        <tr>
            <td>Cognome:</td>
            <td><input type="text" name="cognome" value="{{ $dipendente->cognome }}" /></td>
        </tr>
        <tr>
            <td>Nome:</td>
            <td><input type="text" name="nome" value="{{ $dipendente->nome }}" /></td>
        </tr>
        <tr>
            <td>Codice fiscale:</td>
            <td><input type="text" name="codice_fiscale" value="{{ $dipendente->codice_fiscale }}" /></td>
        </tr>
        <tr>
            <td>Email:</td>
            <td><input type="email" name="email" value="{{ $dipendente->user->email }}" /></td>
        </tr>
        <tr>
            <td></td>
            <td><button type="submit">Modifica</button>
            <a href="{{ route('admin.home') }}" class="btn-link">Torna alla home</a></td>
            
        </tr>
    </table>
</form>
@endsection