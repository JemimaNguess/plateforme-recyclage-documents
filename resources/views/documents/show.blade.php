@extends('layouts.app')

@section('contenu')
    <div class="bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold text-gray-800" style="font-family: 'Poppins', sans-serif;">
            {{ $document->titre }}
        </h1>

        <p class="text-sm text-gray-500 mt-2">
            Déposé par {{ $document->utilisateur->name }} le {{ $document->created_at->format('d/m/Y') }}
        </p>

        @if ($document->description)
            <p class="text-gray-700 mt-4">{{ $document->description }}</p>
        @endif

        <div class="flex flex-wrap gap-2 mt-4">
            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $document->filiere->nom }}</span>
            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $document->matiere->nom }}</span>
            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $document->niveau->nom }}</span>
            <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">{{ $document->typeDocument->nom }}</span>
            <span class="text-xs bg-gray-100 text-gray-700 px-2 py-1 rounded">{{ $document->annee_academique }}</span>
        </div>

        <p class="text-sm text-gray-500 mt-4">
            {{ $document->nb_telechargements }} téléchargement(s)
        </p>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('documents.download', $document) }}" class="bg-red-700 hover:bg-red-800 text-white px-4 py-2 rounded font-semibold">
                Télécharger
            </a>
        </div>
    </div>

    <div class="bg-white p-6 rounded-lg shadow mt-6">
        <h2 class="font-semibold text-gray-800 mb-3">Signaler ce document</h2>

        @if ($errors->any())
            <div class="text-red-700 text-sm mb-3">{{ $errors->first('motif') }}</div>
        @endif

        <form method="POST" action="{{ route('signalements.store') }}">
            @csrf
            <input type="hidden" name="document_id" value="{{ $document->id }}">
            <textarea name="motif" rows="3" placeholder="Expliquez pourquoi vous signalez ce document..." class="w-full border-gray-300 rounded"></textarea>
            <button type="submit" class="mt-2 bg-gray-800 hover:bg-gray-900 text-white px-4 py-2 rounded text-sm">
                Signaler
            </button>
        </form>
    </div>
@endsection