@extends('layouts.admin')

@section('titre', 'Gestion des signalements')

@section('contenu')
    {{-- En-tête --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif;">
                Signalements
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Gérez les retours et abus signalés par les utilisateurs.
            </p>
        </div>
        
        {{-- Filtres par statut --}}
        <div class="inline-flex p-1 bg-gray-100 rounded-lg text-xs font-medium self-start sm:self-auto">
            <a href="{{ route('admin.signalements') }}" 
               class="px-3 py-1.5 rounded-md transition {{ !request('statut') ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                Tous
            </a>
            <a href="{{ route('admin.signalements', ['statut' => 'en_attente']) }}" 
               class="px-3 py-1.5 rounded-md transition {{ request('statut') === 'en_attente' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                En attente
            </a>
            <a href="{{ route('admin.signalements', ['statut' => 'traite']) }}" 
               class="px-3 py-1.5 rounded-md transition {{ request('statut') === 'traite' ? 'bg-white text-gray-900 shadow-sm' : 'text-gray-600 hover:text-gray-900' }}">
                Traités
            </a>
        </div>
    </div>

    {{-- Liste des signalements --}}
    <div class="space-y-4">
        @forelse ($signalements as $signalement)
            <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 transition {{ $signalement->statut === 'en_attente' ? 'border-l-4 border-l-[#B3121A]' : 'border-l-4 border-l-gray-300' }}">
                
                <div class="flex flex-col sm:flex-row justify-between items-start gap-3">
                    <div class="space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-semibold text-gray-900 text-base">
                                {{ $signalement->document?->titre ?? 'Document supprimé' }}
                            </h3>
                            
                            {{-- Lien direct vers le document s'il existe toujours --}}
                            @if ($signalement->document)
                                <a href="{{ route('admin.documents', ['search' => $signalement->document->titre]) }}" target="_blank" class="text-xs text-[#B3121A] hover:underline inline-flex items-center gap-0.5">
                                    <span>Voir le document</span>
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                </a>
                            @endif
                        </div>

                        <p class="text-xs text-gray-500">
                            Signalé par <span class="font-medium text-gray-700">{{ $signalement->utilisateur?->name ?? 'Utilisateur inconnu' }}</span> 
                            le {{ $signalement->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>

                    {{-- Badge de statut --}}
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $signalement->statut === 'en_attente' ? 'bg-red-50 text-[#B3121A]' : 'bg-green-50 text-green-700' }}">
                        <span class="w-1.5 h-1.5 rounded-full {{ $signalement->statut === 'en_attente' ? 'bg-[#B3121A]' : 'bg-green-600' }} mr-1.5"></span>
                        {{ $signalement->statut === 'en_attente' ? 'En attente' : 'Traité' }}
                    </span>
                </div>

                {{-- Motif du signalement --}}
                <div class="mt-3 p-3 bg-gray-50 rounded-lg text-sm text-gray-700 border border-gray-100">
                    <span class="font-medium text-gray-900 block text-xs uppercase tracking-wider text-gray-400 mb-1">Motif :</span>
                    {{ $signalement->motif }}
                </div>

                {{-- Actions --}}
                @if ($signalement->statut === 'en_attente')
                    <div class="flex flex-wrap items-center gap-2 mt-4 pt-3 border-t border-gray-100">
                        <form method="POST" action="{{ route('admin.signalements.rejeter', $signalement) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-1.5 rounded-lg font-medium transition">
                                Rejeter le signalement
                            </button>
                        </form>

                        @if ($signalement->document)
                            <form method="POST" action="{{ route('admin.signalements.supprimer-document', $signalement) }}" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement ce document ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-[#B3121A] hover:bg-red-800 text-white px-3 py-1.5 rounded-lg font-medium transition">
                                    Supprimer le document
                                </button>
                            </form>
                        @endif
                    </div>
                @endif

            </div>
        @empty
            <div class="bg-white p-8 text-center rounded-lg shadow-sm border border-gray-100">
                <p class="text-gray-400 text-sm">Aucun signalement à afficher pour le moment.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $signalements->links() }}
    </div>
@endsection