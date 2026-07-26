@extends('layouts.app')

@section('contenu')
    {{-- Bouton de retour rapide --}}
    <div class="mb-6">
        <a href="{{ url()->previous() }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-gray-800 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
            </svg>
            Retour
        </a>
    </div>

    {{-- Carte Principale du Document --}}
    <div class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-sm mb-6">
        
        {{-- En-tête : Badge & Référence --}}
        <div class="flex items-center justify-between gap-2 mb-4">
            <span class="inline-flex items-center px-3 py-1 rounded-md text-xs font-bold tracking-wider uppercase bg-red-50 text-red-700">
                {{ $document->typeDocument?->nom ?? 'Document' }}
            </span>
            <span class="font-mono text-xs text-gray-400">
                DOC-{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }}
            </span>
        </div>

        {{-- Titre --}}
        <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight mb-2" style="color: var(--ink); font-family: 'Poppins', sans-serif;">
            {{ $document->titre }}
        </h1>

        {{-- Auteur & Date --}}
        <div class="flex items-center gap-2 text-xs text-gray-500 mb-6">
            <div class="w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center font-bold text-gray-600 text-[10px]">
                {{ strtoupper(substr($document->utilisateur?->name ?? 'U', 0, 1)) }}
            </div>
            <span>Par <strong class="font-semibold text-gray-700">{{ $document->utilisateur?->name ?? 'Utilisateur inconnu' }}</strong></span>
            <span class="opacity-40">·</span>
            <time>Déposé le {{ $document->created_at?->format('d/m/Y') }}</time>
        </div>

        {{-- Description --}}
        @if ($document->description)
            <div class="prose prose-sm text-gray-600 mb-6 leading-relaxed bg-gray-50/50 p-4 rounded-xl border border-gray-100">
                <p>{{ $document->description }}</p>
            </div>
        @endif

        {{-- Métadonnées (Badges) --}}
        <div class="flex flex-wrap gap-2 mb-8">
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                Filière : {{ $document->filiere?->nom ?? 'Général' }}
            </span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                Matière : {{ $document->matiere?->nom ?? '-' }}
            </span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-100 text-gray-700">
                Niveau : {{ $document->niveau?->nom ?? '-' }}
            </span>
            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-mono bg-gray-100 text-gray-700">
                Année : {{ $document->annee_academique ?? 'N/A' }}
            </span>
        </div>

        <div class="pt-6 border-t border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            {{-- Nombre de téléchargements --}}
            <div class="flex items-center gap-2 text-xs font-medium text-gray-500">
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>{{ $document->nb_telechargements }} téléchargement(s)</span>
            </div>

            {{-- Bouton d'action / Téléchargement --}}
            <a href="{{ route('documents.download', $document) }}" 
               class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-medium text-xs tracking-wide text-white transition-all shadow-sm hover:shadow hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2"
               style="background-color: var(--blush, #B3121A);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                <span>Télécharger le fichier</span>
            </a>
        </div>
    </div>

    {{-- Bloc Signalement --}}
    <div class="bg-white p-6 rounded-2xl border border-gray-200/80 shadow-sm">
        <h2 class="text-sm font-bold uppercase tracking-wider text-gray-700 mb-1">
            Signaler un problème
        </h2>
        <p class="text-xs text-gray-500 mb-4">
            Si ce document est inapproprié, corrompu ou ne respecte pas les règles, veuillez le signaler.
        </p>

        @if ($errors->has('motif'))
            <div class="bg-red-50 text-red-700 text-xs p-3 rounded-xl mb-3 border border-red-200">
                {{ $errors->first('motif') }}
            </div>
        @endif

        <form method="POST" action="{{ route('signalements.store') }}" class="space-y-3">
            @csrf
            <input type="hidden" name="document_id" value="{{ $document->id }}">
            
            <textarea name="motif" 
                      rows="3" 
                      placeholder="Expliquez brièvement le motif du signalement..." 
                      class="w-full text-xs bg-gray-50/50 border border-gray-200 rounded-xl p-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition placeholder-gray-400"
                      required></textarea>
            
            <div class="flex justify-end">
                <button type="submit" 
                        class="px-4 py-2 rounded-xl text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 transition-all flex items-center gap-1.5">
                    <svg class="w-3.5 h-3.5 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm9-13.5V9"/>
                    </svg>
                    <span>Envoyer le signalement</span>
                </button>
            </div>
        </form>
    </div>
@endsection