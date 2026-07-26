@extends('layouts.app')

@section('contenu')
    {{-- En-tête de page --}}
    <div class="mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight" style="color: var(--ink); font-family: 'Poppins', sans-serif;">
                Mes documents
            </h1>
            <p class="text-sm mt-1" style="color: var(--ink-soft, #6B7280);">
                Gérez vos contributions et retrouvez l'historique de vos téléchargements.
            </p>
        </div>

        <a href="{{ route('documents.depot') }}" 
           class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl font-medium text-xs tracking-wide text-white transition-all shadow-sm hover:shadow hover:scale-[1.01] active:scale-[0.99] self-start sm:self-auto"
           style="background-color: var(--blush, #B3121A);">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
            </svg>
            <span>Nouveau dépôt</span>
        </a>
    </div>

    {{-- SECTION 1 : Mes Dépôts --}}
    <section class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold tracking-tight flex items-center gap-2" style="color: var(--ink);">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                </svg>
                <span>Mes dépôts</span>
            </h2>
            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-600">
                {{ $mesDepots->count() }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($mesDepots as $document)
                <a href="{{ route('documents.show', $document) }}" 
                   class="group bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-gray-300 transition-all flex flex-col justify-between">
                    <div>
                        {{-- Badge Type / Matière --}}
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase bg-gray-100 text-gray-700 group-hover:bg-red-50 group-hover:text-red-700 transition">
                                {{ $document->typeDocument?->nom ?? 'Document' }}
                            </span>
                            <span class="font-mono text-[11px] text-gray-400">
                                DOC-{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        {{-- Titre --}}
                        <h3 class="font-display text-base font-bold tracking-tight group-hover:text-red-700 transition line-clamp-1" style="color: var(--ink);">
                            {{ $document->titre }}
                        </h3>
                        
                        <p class="text-xs text-gray-500 mt-1">
                            {{ $document->matiere?->nom ?? 'Général' }}
                        </p>
                    </div>

                    {{-- Stats bas de carte --}}
                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-400">
                        <span class="flex items-center gap-1.5 text-gray-600 font-medium">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            {{ $document->nb_telechargements }} téléchargement(s)
                        </span>
                        
                        <span class="group-hover:translate-x-0.5 transition-transform text-gray-400 group-hover:text-red-700">→</span>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white border border-dashed border-gray-200 rounded-2xl p-8 text-center">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-500">Vous n'avez encore déposé aucun document.</p>
                </div>
            @endforelse
        </div>
    </section>

    {{-- SECTION 2 : Mes Téléchargements --}}
    <section>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold tracking-tight flex items-center gap-2" style="color: var(--ink);">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <span>Mes téléchargements</span>
            </h2>
            <span class="text-xs font-semibold px-2.5 py-0.5 rounded-full bg-gray-100 text-gray-600">
                {{ $mesTelechargements->count() }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @forelse ($mesTelechargements as $telechargement)
                <a href="{{ route('documents.show', $telechargement->document) }}" 
                   class="group bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-gray-300 transition-all flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold tracking-wider uppercase bg-gray-100 text-gray-700 group-hover:bg-red-50 group-hover:text-red-700 transition">
                                {{ $telechargement->document->typeDocument?->nom ?? 'Document' }}
                            </span>
                            <span class="text-[11px] text-gray-400">
                                {{ $telechargement->created_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <h3 class="font-display text-base font-bold tracking-tight group-hover:text-red-700 transition line-clamp-1" style="color: var(--ink);">
                            {{ $telechargement->document->titre }}
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ $telechargement->document->filiere?->nom }} · {{ $telechargement->document->matiere?->nom }}
                        </p>
                    </div>

                    <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-end text-xs text-gray-400">
                        <span class="inline-flex items-center gap-1 font-semibold text-gray-600 group-hover:text-red-700 transition">
                            Revoir le document
                            <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                            </svg>
                        </span>
                    </div>
                </a>
            @empty
                <div class="col-span-full bg-white border border-dashed border-gray-200 rounded-2xl p-8 text-center">
                    <div class="w-10 h-10 mx-auto mb-2 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                        </svg>
                    </div>
                    <p class="text-xs font-medium text-gray-500">Vous n'avez encore rien téléchargé.</p>
                </div>
            @endforelse
        </div>
    </section>
@endsection