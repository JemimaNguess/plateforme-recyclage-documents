@extends('layouts.admin')

@section('contenu')
    <h1 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Gestion des documents
    </h1>

    <form method="GET" class="bg-white p-4 rounded-lg shadow mb-6 grid grid-cols-2 md:grid-cols-4 gap-3">
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
        <button type="submit" class="bg-gray-800 hover:bg-gray-900 text-white rounded text-sm">Filtrer</button>
    </form>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="px-4 py-3">Titre</th>
                    <th class="px-4 py-3">Déposant</th>
                    <th class="px-4 py-3">Filière</th>
                    <th class="px-4 py-3">Type</th>
                    <th class="px-4 py-3">Téléchargements</th>
                    <th class="px-4 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($documents as $document)
                    <tr class="border-b">
                        <td class="px-4 py-3">{{ $document->titre }}</td>
                        <td class="px-4 py-3">{{ $document->utilisateur->name }}</td>
                        <td class="px-4 py-3">{{ $document->filiere->nom }}</td>
                        <td class="px-4 py-3">{{ $document->typeDocument->nom }}</td>
                        <td class="px-4 py-3">{{ $document->nb_telechargements }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" onsubmit="return confirm('Supprimer ce document ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded">
                                    Supprimer
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $documents->links() }}
    </div>
@endsection