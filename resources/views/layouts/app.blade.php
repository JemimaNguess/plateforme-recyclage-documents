<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Plateforme Recyclage Documents') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:400,600,700|inter:400,500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        @include('partials.navigation')

        @if (session('succes'))
            <div class="max-w-5xl mx-auto mt-4 px-4">
                <div class="bg-green-50 border border-green-300 text-green-800 px-4 py-3 rounded-lg">
                    {{ session('succes') }}
                </div>
            </div>
        @endif

        @if (session('avertissement_doublon'))
            <div class="max-w-5xl mx-auto mt-4 px-4">
                <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg">
                    ⚠️ Un document similaire existe déjà ({{ session('document_similaire') }}).
                    Vérifiez le formulaire ci-dessous pour confirmer malgré tout.
                </div>
            </div>
        @endif

        <main class="max-w-5xl mx-auto py-8 px-4">
            @yield('contenu')
        </main>
    </div>

    @stack('scripts')
</body>
</html>