<x-guest-layout>
    <h1 class="font-display text-xl font-semibold mb-4" style="color: var(--ink);">Mot de passe oublié</h1>

    <div class="mb-4 text-sm" style="color: var(--ink-soft);">
        {{ __('Vous avez oublié votre mot de passe ? Pas de problème. Indiquez-nous votre adresse email et nous vous enverrons un lien pour en choisir un nouveau.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium mb-1" style="color: var(--ink-soft);">Adresse email</label>
            <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" required autofocus>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <button type="submit" class="btn-brick w-full justify-center mt-2">
            {{ __('Envoyer le lien de réinitialisation') }}
        </button>

        <p class="text-center text-sm mt-4" style="color: var(--ink-soft);">
            <a href="{{ route('login') }}" style="color: var(--brick);">← Retour à la connexion</a>
        </p>
    </form>
</x-guest-layout>