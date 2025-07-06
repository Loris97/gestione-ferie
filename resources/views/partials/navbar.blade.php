<nav class="topbar">
    <!-- Form di logout, mostra il pulsante per uscire -->
    <div class="welcome">
        Benvenuto
        @php
            $user = auth()->user();
            $isDipendente = $user->ruolo === 'dipendente';
        @endphp
        <!-- Se l'utente è dipendente, mostra nome e cognome dal modello Dipendente -->
        @if($isDipendente && $user->dipendente)
            {{ $user->dipendente->nome }} {{ $user->dipendente->cognome }}
            <!-- Bottone profilo solo per dipendente -->
        @else
            <!-- Altrimenti mostra il nome utente generico -->
            {{ $user->name }}
        @endif
        <a href="{{ route('profile.edit') }}" title="Modifica il profilo" style="margin-left: 10px; vertical-align: middle;">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24" style="vertical-align: middle;">
                    <circle cx="12" cy="8" r="4" />
                    <path d="M12 14c-5 0-8 2.5-8 4v2h16v-2c0-1.5-3-4-8-4z"/>
                </svg>
            </a>
    </div>
    <form method="POST" action="{{ route('logout') }}" class="logout-form">
        @csrf
        <button type="submit" class="btn logout-btn">Logout</button>
    </form>
</nav>
