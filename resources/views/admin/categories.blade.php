@extends('layouts.admin')

@section('contenu')
    <h1 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Gestion des catégories
    </h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- Filières --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-gray-800 mb-3">Filières</h2>
            <form method="POST" action="{{ route('admin.categories.filieres.store') }}" class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="nom" placeholder="Nouvelle filière" class="border-gray-300 rounded flex-1" required>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded text-sm">Ajouter</button>
            </form>
            <ul class="divide-y">
                @foreach ($filieres as $filiere)
                    <li class="py-2 flex justify-between items-center text-sm">
                        <span>{{ $filiere->nom }} <span class="text-gray-400">({{ $filiere->documents_count }} doc.)</span></span>
                        <form method="POST" action="{{ route('admin.categories.filieres.destroy', $filiere) }}" onsubmit="return confirm('Supprimer cette filière ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Niveaux --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-gray-800 mb-3">Niveaux</h2>
            <form method="POST" action="{{ route('admin.categories.niveaux.store') }}" class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="nom" placeholder="Nouveau niveau" class="border-gray-300 rounded flex-1" required>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded text-sm">Ajouter</button>
            </form>
            <ul class="divide-y">
                @foreach ($niveaux as $niveau)
                    <li class="py-2 flex justify-between items-center text-sm">
                        <span>{{ $niveau->nom }} <span class="text-gray-400">({{ $niveau->documents_count }} doc.)</span></span>
                        <form method="POST" action="{{ route('admin.categories.niveaux.destroy', $niveau) }}" onsubmit="return confirm('Supprimer ce niveau ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Types de document --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-gray-800 mb-3">Types de document</h2>
            <form method="POST" action="{{ route('admin.categories.types.store') }}" class="flex gap-2 mb-4">
                @csrf
                <input type="text" name="nom" placeholder="Nouveau type" class="border-gray-300 rounded flex-1" required>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded text-sm">Ajouter</button>
            </form>
            <ul class="divide-y">
                @foreach ($typesDocument as $type)
                    <li class="py-2 flex justify-between items-center text-sm">
                        <span>{{ $type->nom }} <span class="text-gray-400">({{ $type->documents_count }} doc.)</span></span>
                        <form method="POST" action="{{ route('admin.categories.types.destroy', $type) }}" onsubmit="return confirm('Supprimer ce type ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Matières --}}
        <div class="bg-white p-5 rounded-lg shadow">
            <h2 class="font-semibold text-gray-800 mb-3">Matières</h2>
            <form method="POST" action="{{ route('admin.categories.matieres.store') }}" class="flex gap-2 mb-4">
                @csrf
                <select name="filiere_id" class="border-gray-300 rounded text-sm" required>
                    <option value="">Filière</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                    @endforeach
                </select>
                <input type="text" name="nom" placeholder="Nouvelle matière" class="border-gray-300 rounded flex-1" required>
                <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-3 py-1.5 rounded text-sm">Ajouter</button>
            </form>
            <ul class="divide-y">
                @foreach ($matieres as $matiere)
                    <li class="py-2 flex justify-between items-center text-sm">
                        <span>{{ $matiere->nom }} <span class="text-gray-400">({{ $matiere->filiere->nom }}, {{ $matiere->documents_count }} doc.)</span></span>
                        <form method="POST" action="{{ route('admin.categories.matieres.destroy', $matiere) }}" onsubmit="return confirm('Supprimer cette matière ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-xs">Supprimer</button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>

    </div>
@endsection