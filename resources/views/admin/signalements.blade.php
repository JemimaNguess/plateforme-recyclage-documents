@extends('layouts.admin')

@section('contenu')
    <h1 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Signalements
    </h1>

    <div class="space-y-4">
        @forelse ($signalements as $signalement)
            <div class="bg-white p-4 rounded-lg shadow {{ $signalement->statut === 'en_attente' ? 'border-l-4 border-red-700' : '' }}">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-semibold text-gray-800">
                            {{ $signalement->document->titre ?? '(document supprimé)' }}
                        </p>
                        <p class="text-sm text-gray-500">
                            Signalé par {{ $signalement->utilisateur->name }} le {{ $signalement->created_at->format('d/m/Y') }}
                        </p>
                        <p class="text-gray-700 mt-2 text-sm">{{ $signalement->motif }}</p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded {{ $signalement->statut === 'en_attente' ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                        {{ $signalement->statut === 'en_attente' ? 'En attente' : 'Traité' }}
                    </span>
                </div>

                @if ($signalement->statut === 'en_attente')
                    <div class="flex gap-2 mt-3">
                        <form method="POST" action="{{ route('admin.signalements.rejeter', $signalement) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-xs bg-gray-700 hover:bg-gray-800 text-white px-3 py-1.5 rounded">
                                Rejeter le signalement
                            </button>
                        </form>

                        @if ($signalement->document)
                            <form method="POST" action="{{ route('admin.signalements.supprimer-document', $signalement) }}" onsubmit="return confirm('Supprimer définitivement ce document ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded">
                                    Supprimer le document
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <p class="text-gray-500">Aucun signalement.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $signalements->links() }}
    </div>
@endsection