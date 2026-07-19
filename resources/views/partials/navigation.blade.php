<nav class="bg-gray-900 text-white">
    <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
        <a href="{{ route('documents.recherche') }}" class="font-bold text-lg" style="font-family: 'Poppins', sans-serif;">
            Plateforme Recyclage
        </a>

        @auth
        <div class="flex items-center gap-4 text-sm">
            <a href="{{ route('documents.recherche') }}" class="hover:text-red-400">Rechercher</a>
            <a href="{{ route('documents.depot') }}" class="hover:text-red-400">Déposer</a>
            <a href="{{ route('documents.mes-documents') }}" class="hover:text-red-400">Mes documents</a>
            <a href="{{ route('profile.edit') }}" class="hover:text-red-400">{{ auth()->user()->name }}</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-700 hover:bg-red-800 px-3 py-1.5 rounded">Déconnexion</button>
            </form>
        </div>
        @endauth
    </div>
</nav>