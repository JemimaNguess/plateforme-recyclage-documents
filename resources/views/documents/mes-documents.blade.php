@extends('layouts.app')

@section('contenu')
    <h1 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Mes documents
    </h1>

    <h2 class="font-semibold text-gray-700 mb-3">Mes dépôts</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
        @forelse ($mesDepots as $document)
            <a href="{{ route('documents.show', $document) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800">{{ $document->titre }}</h3>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $document->matiere->nom }} • {{ $document->nb_telechargements }} téléchargement(s)
                </p>
            </a>
        @empty
            <p class="text-gray-500">Vous n'avez encore déposé aucun document.</p>
        @endforelse
    </div>

    <h2 class="font-semibold text-gray-700 mb-3">Mes téléchargements</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse ($mesTelechargements as $telechargement)
            <a href="{{ route('documents.show', $telechargement->document) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                <h3 class="font-semibold text-gray-800">{{ $telechargement->document->titre }}</h3>
                <p class="text-sm text-gray-500 mt-1">Téléchargé le {{ $telechargement->created_at->format('d/m/Y') }}</p>
            </a>
        @empty
            <p class="text-gray-500">Vous n'avez encore rien téléchargé.</p>
        @endforelse
    </div>
@endsection