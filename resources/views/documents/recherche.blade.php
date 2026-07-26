@extends('layouts.app')

@section('contenu')
    {{-- En-tête de page --}}
    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight" style="color: var(--ink); font-family: 'Poppins', sans-serif;">
                Rechercher un document
            </h1>
            <p class="text-sm mt-1" style="color: var(--ink-soft, #6B7280);">
                Explorez la banque de documents par filière, niveau et type de cours.
            </p>
        </div>

        @if(request()->anyFilled(['filiere_id', 'niveau_id', 'type_document_id', 'annee_academique', 'mot_cle']))
            <a href="{{ route('documents.recherche') }}" 
               class="inline-flex items-center gap-1.5 text-xs font-semibold text-gray-500 hover:text-red-700 transition self-start md:self-auto">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Réinitialiser les filtres
            </a>
        @endif
    </div>

    {{-- Formulaire de Recherche & Filtres --}}
    <form method="GET" action="{{ route('documents.recherche') }}" 
          class="bg-white p-5 rounded-2xl border border-gray-200/80 shadow-sm mb-10 transition-all focus-within:shadow-md">
        
        {{-- Champ Mot-Clé principal --}}
        <div class="mb-4 relative">
            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <input type="text" 
                   name="mot_cle" 
                   placeholder="Rechercher par titre, sujet ou description..." 
                   value="{{ request('mot_cle') }}" 
                   class="w-full pl-11 pr-4 py-2.5 text-sm bg-gray-50/50 border border-gray-200 rounded-xl focus:bg-white focus:border-gray-400 focus:ring-0 transition placeholder-gray-400">
        </div>

        {{-- Filtres Secondaires --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
            <div>
                <label class="block text-[11px] uppercase font-bold tracking-wider text-gray-400 mb-1">Filière</label>
                <select name="filiere_id" onchange="this.form.submit()" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition cursor-pointer">
                    <option value="">Toutes les filières</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}" @selected(request('filiere_id') == $filiere->id)>{{ $filiere->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] uppercase font-bold tracking-wider text-gray-400 mb-1">Niveau</label>
                <select name="niveau_id" onchange="this.form.submit()" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition cursor-pointer">
                    <option value="">Tous les niveaux</option>
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" @selected(request('niveau_id') == $niveau->id)>{{ $niveau->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] uppercase font-bold tracking-wider text-gray-400 mb-1">Type de document</label>
                <select name="type_document_id" onchange="this.form.submit()" class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition cursor-pointer">
                    <option value="">Tous les types</option>
                    @foreach ($typesDocument as $type)
                        <option value="{{ $type->id }}" @selected(request('type_document_id') == $type->id)>{{ $type->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-[11px] uppercase font-bold tracking-wider text-gray-400 mb-1">Année académique</label>
                <input type="text" 
                       name="annee_academique" 
                       placeholder="ex: 2024-2025" 
                       value="{{ request('annee_academique') }}" 
                       class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition placeholder-gray-400">
            </div>
        </div>

        {{-- Bouton de soumission --}}
        <div class="mt-4 pt-3 border-t border-gray-100 flex justify-end">
            <button type="submit" 
                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-medium text-xs tracking-wide text-white transition-all shadow-sm hover:shadow hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2"
                    style="background-color: var(--blush, #B3121A);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <span>Lancer la recherche</span>
            </button>
        </div>
    </form>

    {{-- Liste des Résultats --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        @forelse ($documents as $document)
            <a href="{{ route('documents.show', $document) }}" 
               class="group relative bg-white border border-gray-200/80 rounded-2xl p-5 shadow-sm hover:shadow-md hover:border-gray-300 transition-all flex flex-col justify-between">
                
                <div>
                    {{-- Badge & Référence --}}
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold tracking-wider uppercase bg-gray-100 text-gray-700 group-hover:bg-red-50 group-hover:text-red-700 transition">
                            {{ $document->typeDocument?->nom ?? 'Document' }}
                        </span>
                        <span class="font-mono text-[11px] text-gray-400">
                            DOC-{{ str_pad($document->id, 4, '0', STR_PAD_LEFT) }}
                        </span>
                    </div>

                    {{-- Titre --}}
                    <h2 class="font-display text-base font-bold tracking-tight group-hover:text-red-700 transition line-clamp-2" style="color: var(--ink);">
                        {{ $document->titre }}
                    </h2>

                    {{-- Métadonnées --}}
                    <p class="text-xs mt-2 font-medium" style="color: var(--ink-soft, #6B7280);">
                        {{ $document->filiere?->nom ?? 'Général' }} 
                        <span class="opacity-40">·</span> 
                        {{ $document->matiere?->nom ?? '-' }} 
                        <span class="opacity-40">·</span> 
                        {{ $document->niveau?->nom ?? '-' }}
                    </p>
                </div>

                {{-- Pied de carte --}}
                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-gray-400">
                    <span class="font-mono">
                        {{ $document->annee_academique ?? 'N/A' }}
                    </span>
                    <span class="inline-flex items-center gap-1 font-semibold text-gray-600 group-hover:text-red-700 transition">
                        Consulter
                        <svg class="w-3.5 h-3.5 group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                        </svg>
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full bg-white border border-dashed border-gray-200 rounded-2xl p-12 text-center">
                <div class="w-12 h-12 mx-auto mb-3 rounded-full bg-gray-50 flex items-center justify-center text-gray-400">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h3 class="text-base font-bold text-gray-800">Aucun document trouvé</h3>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                    Ajustez vos filtres ou essayez avec d'autres mots-clés pour trouver ce que vous cherchez.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-8">
        {{ $documents->links() }}
    </div>
@endsection