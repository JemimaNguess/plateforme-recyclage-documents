<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Plateforme Recyclage Documents') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=fraunces:600,700i|inter:400,500,600|ibm-plex-mono:500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="background: var(--ink);" class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="/" class="font-display text-2xl text-white tracking-tight">
                Recyclage<span style="color: var(--blush);">.</span>Documents
            </a>
            <p class="text-sm mt-2" style="color: #B5B5B5;">Plateforme de partage académique entre étudiants</p>
        </div>

        <div class="doc-card !overflow-visible">
            {{ $slot }}
        </div>
    </div>

</body>
</html>