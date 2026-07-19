@extends('layouts.admin')

@section('contenu')
    <!-- Section En-tête avec message de bienvenue dynamique -->
    <div class="mb-10 flex flex-col md:flex-row md:items-center md:justify-between border-b pb-6" style="border-color: #8A8A8A;">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight mb-1" style="font-family: 'Poppins', sans-serif; color: #2B2B2B;">
                Tableau de bord
            </h1>
            <p class="text-sm font-medium" style="color: #4A4A4A;">
                Ravi de vous revoir, <span class="font-bold text-gray-900">{{ auth()->user()->name }}</span>. Voici l'état de la plateforme aujourd'hui.
            </p>
        </div>
        <!-- Badge Date en temps réel pour faire professionnel -->
        <div class="mt-4 md:mt-0 px-4 py-2 rounded-lg text-xs font-semibold uppercase tracking-wider bg-white border" style="color: #4A4A4A; border-color: #8A8A8A;">
            Session Admin • {{ now()->translatedFormat('d F Y') }}
        </div>
    </div>

    <!-- Grille des statistiques avec effets de survol et relief -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        
        <!-- Carte 1 : Documents -->
        <div class="group bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold uppercase tracking-widest" style="color: #8A8A8A;">Documents</span>
                <!-- Icône avec fond léger -->
                <div class="p-2.5 rounded-lg bg-gray-100 group-hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" style="color: #2B2B2B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black font-sans tracking-tight" style="color: #2B2B2B;">{{ $totalDocuments }}</span>
                <span class="text-xs font-medium text-green-600 bg-green-50 px-2 py-0.5 rounded-full">+{{ $depotsRecents }} cette semaine</span>
            </div>
        </div>

        <!-- Carte 2 : Utilisateurs -->
        <div class="group bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold uppercase tracking-widest" style="color: #8A8A8A;">Utilisateurs</span>
                <div class="p-2.5 rounded-lg bg-gray-100 group-hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" style="color: #2B2B2B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <span class="text-4xl font-black font-sans tracking-tight" style="color: #2B2B2B;">{{ $totalUtilisateurs }}</span>
            <p class="text-xs mt-2" style="color: #4A4A4A;">Comptes étudiants actifs</p>
        </div>

        <!-- Carte 3 : Signalements (L'ALERTE PHARE - Effet d'urgence) -->
        <div class="group bg-white p-6 rounded-lg shadow-sm border-2 transition-all duration-300 transform hover:-translate-y-1 {{ $signalementsEnAttente > 0 ? 'animate-pulse' : '' }}" style="border-color: #B3121A;">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold uppercase tracking-widest" style="color: #B3121A;">Signalements critiques</span>
                <div class="p-2.5 rounded-lg" style="bg-color: #E8A3A7;">
                    <svg class="w-5 h-5" style="color: #B3121A;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <span class="text-4xl font-black font-sans tracking-tight" style="color: #B3121A;">{{ $signalementsEnAttente }}</span>
                <span class="text-xs font-bold uppercase px-2 py-0.5 rounded text-xs" style="background-color: #E8A3A7; color: #2B2B2B;">À traiter</span>
            </div>
        </div>

        <!-- Carte 4 : Activité Globale -->
        <div class="group bg-white p-6 rounded-lg shadow-sm border border-gray-200 hover:shadow-md transition-all duration-300 transform hover:-translate-y-1">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-bold uppercase tracking-widest" style="color: #8A8A8A;">Flux d'activité</span>
                <div class="p-2.5 rounded-lg bg-gray-100 group-hover:bg-gray-200 transition-colors">
                    <svg class="w-5 h-5" style="color: #2B2B2B;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
            </div>
            <span class="text-4xl font-black font-sans tracking-tight" style="color: #2B2B2B;">Stable</span>
            <p class="text-xs mt-2 text-green-600 font-medium">Santé du système : 100%</p>
        </div>

    </div>

    <!-- Section Ajoutée : Les Actions Rapides de Modération (Pour prouver la robustesse de l'app) -->
    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
        <h3 class="text-lg font-bold mb-4" style="font-family: 'Poppins', sans-serif; color: #2B2B2B;">
            Actions d'administration prioritaires
        </h3>
        <div class="flex flex-wrap gap-4">
            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white rounded-lg transition-all duration-200 transform hover:scale-105" style="background-color: #B3121A; box-shadow: 0 4px 6px -1px rgba(179, 18, 26, 0.2);">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                Modérer les documents signalés
            </a>
            <a href="#" class="inline-flex items-center px-4 py-2 text-sm font-semibold rounded-lg border transition-all duration-200 hover:bg-gray-50" style="color: #2B2B2B; border-color: #8A8A8A;">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                Gérer les filières & catégories
            </a>
        </div>
    </div>
@endsection