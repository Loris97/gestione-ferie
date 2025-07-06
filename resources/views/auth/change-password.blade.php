@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <label>Nuova password</label>
        <input type="password" name="password" required>
        <label>Conferma password</label>
        <input type="password" name="password_confirmation" required>
        <button type="submit">Cambia password</button>
    </form>
@endsection
