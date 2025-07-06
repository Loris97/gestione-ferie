@extends('layouts.app')
@section('title', 'Modifica Profilo')
@section('content')
<h2>Modifica dati Profilo</h2>

{{-- Mostra messaggio di successo dopo l'aggiornamento --}}
@if (session('status') == 'profile-updated')
    <div class="alert alert-success" style="color: green; margin-bottom: 10px;">
        Profilo aggiornato con successo!
    </div>
@endif

{{-- Mostra errori di validazione --}}
@if ($errors->any())
    <div class="alert alert-danger" style="color: red; margin-bottom: 10px;">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Form per modificare email e password --}}
<form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
    @csrf
    @method('patch')

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
        <input id="email" name="email" type="email" class="mt-1 block w-full" value="{{ old('email', $user->email) }}" required autofocus autocomplete="username" />
        @error('email')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="current_password">Password attuale</label>
        <input id="current_password" name="current_password" type="password" required>
        @error('current_password')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Nuova Password</label>
        <input id="password" name="password" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
        @error('password')
            <span class="text-red-600 text-sm">{{ $message }}</span>
        @enderror
    </div>
    <div>
        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Conferma Password</label>
        <input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" autocomplete="new-password"/>
    </div>
    <div class="flex items-center gap-4">
        <button type="submit" class="btn btn-primary">Salva</button>
        {{-- Link dinamico per tornare alla home giusta in base al ruolo --}}
        @php
            $user = auth()->user();
        @endphp
        <a href="{{ $user->ruolo === 'admin' ? route('admin.home') : route('dipendente.home') }}" class="btn-link">
            Torna alla home
        </a>
    </div>
</form>
@endsection