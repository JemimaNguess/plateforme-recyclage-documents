@extends('layouts.admin')

@section('titre', 'Gestion des catégories')

@section('contenu')
    <h1 class="text-xl sm:text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Gestion des catégories
    </h1>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Filières --}}
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <h2 class="font-semibold text-gray-800 mb-3 text-base">Filières</h2>
            <form method="POST" action="{{ route('admin.categories.filieres.store') }}" class="flex flex-col sm:flex-row gap-2 mb-4">
                @csrf
                <input type="text" name="nom" placeholder="Nouvelle filière" class="border-gray-300 rounded-lg text-sm flex-1 focus:ring-[#B3121A] focus:border-[#B3121A]" required>
                <button type="submit" class="bg-[#B3121A] hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shrink-0">Ajouter</button>
            </form>
            <ul class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse ($filieres as $filiere)
                    <li class="py-2.5 flex justify-between items-center text-sm">
                        <span class="text-gray-700 font-medium">{{ $filiere->nom }} <span class="text-gray-400 font-normal">({{ $filiere->documents_count }} doc.)</span></span>
                        <form method="POST" action="{{ route('admin.categories.filieres.destroy', $filiere) }}" onsubmit="return confirm('Supprimer cette filière ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium hover:underline">Supprimer</button>
                        </form>
                    </li>
                @empty
                    <li class="py-3 text-sm text-gray-400 text-center">Aucune filière enregistrée.</li>
                @endforelse
            </ul>
        </div>

        {{-- Niveaux --}}
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <h2 class="font-semibold text-gray-800 mb-3 text-base">Niveaux</h2>
            <form method="POST" action="{{ route('admin.categories.niveaux.store') }}" class="flex flex-col sm:flex-row gap-2 mb-4">
                @csrf
                <input type="text" name="nom" placeholder="Nouveau niveau" class="border-gray-300 rounded-lg text-sm flex-1 focus:ring-[#B3121A] focus:border-[#B3121A]" required>
                <button type="submit" class="bg-[#B3121A] hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shrink-0">Ajouter</button>
            </form>
            <ul class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse ($niveaux as $niveau)
                    <li class="py-2.5 flex justify-between items-center text-sm">
                        <span class="text-gray-700 font-medium">{{ $niveau->nom }} <span class="text-gray-400 font-normal">({{ $niveau->documents_count }} doc.)</span></span>
                        <form method="POST" action="{{ route('admin.categories.niveaux.destroy', $niveau) }}" onsubmit="return confirm('Supprimer ce niveau ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium hover:underline">Supprimer</button>
                        </form>
                    </li>
                @empty
                    <li class="py-3 text-sm text-gray-400 text-center">Aucun niveau enregistré.</li>
                @endforelse
            </ul>
        </div>

        {{-- Types de document --}}
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <h2 class="font-semibold text-gray-800 mb-3 text-base">Types de document</h2>
            <form method="POST" action="{{ route('admin.categories.types.store') }}" class="flex flex-col sm:flex-row gap-2 mb-4">
                @csrf
                <input type="text" name="nom" placeholder="Nouveau type" class="border-gray-300 rounded-lg text-sm flex-1 focus:ring-[#B3121A] focus:border-[#B3121A]" required>
                <button type="submit" class="bg-[#B3121A] hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shrink-0">Ajouter</button>
            </form>
            <ul class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse ($typesDocument as $type)
                    <li class="py-2.5 flex justify-between items-center text-sm">
                        <span class="text-gray-700 font-medium">{{ $type->nom }} <span class="text-gray-400 font-normal">({{ $type->documents_count }} doc.)</span></span>
                        <form method="POST" action="{{ route('admin.categories.types.destroy', $type) }}" onsubmit="return confirm('Supprimer ce type ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium hover:underline">Supprimer</button>
                        </form>
                    </li>
                @empty
                    <li class="py-3 text-sm text-gray-400 text-center">Aucun type enregistré.</li>
                @endforelse
            </ul>
        </div>

        {{-- Matières --}}
        <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100">
            <h2 class="font-semibold text-gray-800 mb-3 text-base">Matières</h2>
            <form method="POST" action="{{ route('admin.categories.matieres.store') }}" class="flex flex-col sm:flex-row gap-2 mb-4">
                @csrf
                <select name="filiere_id" class="border-gray-300 rounded-lg text-sm focus:ring-[#B3121A] focus:border-[#B3121A]" required>
                    <option value="">Filière</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}">{{ $filiere->nom }}</option>
                    @endforeach
                </select>
                <input type="text" name="nom" placeholder="Nouvelle matière" class="border-gray-300 rounded-lg text-sm flex-1 focus:ring-[#B3121A] focus:border-[#B3121A]" required>
                <button type="submit" class="bg-[#B3121A] hover:bg-red-800 text-white px-4 py-2 rounded-lg text-sm font-medium transition shrink-0">Ajouter</button>
            </form>
            <ul class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
                @forelse ($matieres as $matiere)
                    <li class="py-2.5 flex justify-between items-center text-sm">
                        <span class="text-gray-700 font-medium">
                            {{ $matiere->nom }} 
                            <span class="text-gray-400 font-normal">({{ $matiere->filiere?->nom ?? 'N/A' }}, {{ $matiere->documents_count }} doc.)</span>
                        </span>
                        <form method="POST" action="{{ route('admin.categories.matieres.destroy', $matiere) }}" onsubmit="return confirm('Supprimer cette matière ?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-xs font-medium hover:underline">Supprimer</button>
                        </form>
                    </li>
                @empty
                    <li class="py-3 text-sm text-gray-400 text-center">Aucune matière enregistrée.</li>
                @endforelse
            </ul>
        </div>

    </div>
@endsection