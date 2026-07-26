<x-guest-layout>
    <h1 class="font-display text-xl font-semibold mb-6" style="color: var(--ink);">Créer un compte</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium mb-1" style="color: var(--ink-soft);">Nom complet</label>
            <input id="name" class="input-field" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-1" style="color: var(--ink-soft);">Adresse email</label>
            <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-1" style="color: var(--ink-soft);">Mot de passe</label>
            <input id="password" class="input-field" type="password" name="password" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-1" style="color: var(--ink-soft);">Confirmer le mot de passe</label>
            <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required autocomplete="new-password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <button type="submit" class="btn-brick w-full justify-center mt-2">
            S'inscrire
        </button>

        <p class="text-center text-sm mt-4" style="color: var(--ink-soft);">
            Déjà un compte ?
            <a href="{{ route('login') }}" class="font-semibold" style="color: var(--brick);">Se connecter</a>
        </p>
    </form>
</x-guest-layout>