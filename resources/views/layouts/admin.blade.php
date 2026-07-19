<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administration — Plateforme Recyclage</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,600,700|inter:400,500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">
    <div class="min-h-screen">
        <nav class="bg-gray-900 text-white">
            <div class="max-w-6xl mx-auto px-4 py-3 flex items-center justify-between">
                <span class="font-bold text-lg" style="font-family: 'Poppins', sans-serif;">
                    Administration
                </span>
                <div class="flex items-center gap-4 text-sm">
                    <a href="{{ route('admin.tableau-bord') }}" class="hover:text-red-400">Tableau de bord</a>
                    <a href="{{ route('admin.utilisateurs') }}" class="hover:text-red-400">Utilisateurs</a>
                    <a href="{{ route('admin.signalements') }}" class="hover:text-red-400">Signalements</a>
                    <a href="{{ route('admin.categories') }}" class="hover:text-red-400">Catégories</a>
                    <a href="{{ route('admin.documents') }}" class="hover:text-red-400">Documents</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="bg-red-700 hover:bg-red-800 px-3 py-1.5 rounded">Déconnexion</button>
                    </form>
                </div>
            </div>
        </nav>

        @if (session('succes'))
            <div class="max-w-6xl mx-auto mt-4 px-4">
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('succes') }}
                </div>
            </div>
        @endif

        @if (session('erreur'))
            <div class="max-w-6xl mx-auto mt-4 px-4">
                <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                    {{ session('erreur') }}
                </div>
            </div>
        @endif

        <main class="max-w-6xl mx-auto py-8 px-4">
            @yield('contenu')
        </main>
    </div>

    @stack('scripts')
</body>
</html>