<x-guest-layout>
    <h1>Gestione Ferie</h1>
    <h2>Recupera password</h2>
    <div style="display: flex; justify-content: center;">
        <form method="POST" action="{{ route('password.email') }}">
            @csrf
            <table>
                <tr>
                    <td colspan="2" style="padding-bottom: 10px;">
                        <span>
                            Hai dimenticato la password? Nessun problema. Inserisci il tuo indirizzo email e ti invieremo un link per reimpostare la password e sceglierne una nuova.
                        </span>
                    </td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus style="width: 350px;">
                        @error('email')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right;">
                        <button type="submit">Invia link di reset password</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</x-guest-layout>
