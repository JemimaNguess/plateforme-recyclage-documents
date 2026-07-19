@extends('layouts.app')

@section('contenu')
    <h1 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Rechercher un document
    </h1>

    <form method="GET" action="{{ route('documents.recherche') }}" class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-2 md:grid-cols-5 gap-3">
        <select name="filiere_id" class="border-gray-300 rounded">
            <option value="">Filière</option>
            @foreach ($filieres as $filiere)
                <option value="{{ $filiere->id }}" @selected(request('filiere_id') == $filiere->id)>{{ $filiere->nom }}</option>
            @endforeach
        </select>

        <select name="niveau_id" class="border-gray-300 rounded">
            <option value="">Niveau</option>
            @foreach ($niveaux as $niveau)
                <option value="{{ $niveau->id }}" @selected(request('niveau_id') == $niveau->id)>{{ $niveau->nom }}</option>
            @endforeach
        </select>

        <select name="type_document_id" class="border-gray-300 rounded">
            <option value="">Type</option>
            @foreach ($typesDocument as $type)
                <option value="{{ $type->id }}" @selected(request('type_document_id') == $type->id)>{{ $type->nom }}</option>
            @endforeach
        </select>

        <input type="text" name="annee_academique" placeholder="Année (ex: 2024-2025)" value="{{ request('annee_academique') }}" class="border-gray-300 rounded">

        <input type="text" name="mot_cle" placeholder="Mot-clé" value="{{ request('mot_cle') }}" class="border-gray-300 rounded">

        <button type="submit" class="col-span-2 md:col-span-5 bg-red-700 hover:bg-red-800 text-white py-2 rounded font-semibold">
            Rechercher
        </button>
    </form>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @forelse ($documents as $document)
            <a href="{{ route('documents.show', $document) }}" class="block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                <h2 class="font-semibold text-gray-800">{{ $document->titre }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $document->filiere->nom }} • {{ $document->matiere->nom }} • {{ $document->niveau->nom }}
                </p>
                <span class="inline-block mt-2 text-xs bg-red-100 text-red-800 px-2 py-1 rounded">
                    {{ $document->typeDocument->nom }}
                </span>
            </a>
        @empty
            <p class="text-gray-500 col-span-2">Aucun document trouvé.</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $documents->links() }}
    </div>
@endsection