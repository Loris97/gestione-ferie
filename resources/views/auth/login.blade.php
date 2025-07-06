<x-guest-layout>
    <h1>Gestione Ferie</h1>
    <h2>login</h2>
    <div style="display: flex; justify-content: center;">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <table>
                <tr>
                    <td>Email:</td>
                    <td>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" style="width: 350px";>
                        @error('email')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>Password:</td>
                    <td>
                        <input type="password" id="password" name="password" required autocomplete="current-password" style="width: 350px";>
                        @error('password')
                            <div style="color:red;">{{ $message }}</div>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <button type="submit">Login</button>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">
                                <button type="button">Registrati</button>
                            </a>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:right;">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}">Password dimenticata?</a>
                        @endif
                    </td>
                </tr>
            </table>
        </form>
    </div>
</x-guest-layout>
