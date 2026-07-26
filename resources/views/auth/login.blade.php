<x-guest-layout>
    <h1 class="font-display text-xl font-semibold mb-6" style="color: var(--ink);">Connexion</h1>

    @session('status')
        <div class="mb-4 text-sm font-medium" style="color: #16A34A;">{{ $value }}</div>
    @endsession

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-1" style="color: var(--ink-soft);">Adresse email</label>
            <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1" style="color: var(--ink-soft);">Mot de passe</label>
            <input id="password" class="input-field" type="password" name="password" required autocomplete="current-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center text-sm" style="color: var(--ink-soft);">
                <input type="checkbox" name="remember" class="rounded mr-2">
                Se souvenir de moi
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm" style="color: var(--brick);">Mot de passe oublié ?</a>
            @endif
        </div>

        <button type="submit" class="btn-brick w-full justify-center mt-2">
            Se connecter
        </button>

        <p class="text-center text-sm mt-4" style="color: var(--ink-soft);">
            Pas encore de compte ?
            <a href="{{ route('register') }}" class="font-semibold" style="color: var(--brick);">S'inscrire</a>
        </p>
    </form>
</x-guest-layout>