@extends('layouts.app')

@section('contenu')
    <h1 class="text-2xl font-bold text-gray-800 mb-6" style="font-family: 'Poppins', sans-serif;">
        Déposer un document
    </h1>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-4">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session('avertissement_doublon'))
        <div class="bg-yellow-50 border border-yellow-400 text-yellow-800 px-4 py-3 rounded-lg mb-4">
            <p class="font-semibold">⚠️ Document similaire détecté</p>
            <p class="text-sm mt-1">Un document proche existe déjà : « {{ session('document_similaire') }} ».</p>
            <label class="flex items-center gap-2 mt-3 text-sm">
                <input type="checkbox" name="confirmer_malgre_doublon" form="formulaireDepot" value="1">
                Je confirme vouloir déposer ce document malgré tout
            </label>
        </div>
    @endif

    <form id="formulaireDepot" method="POST" action="{{ route('documents.store') }}" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
            <input type="text" name="titre" value="{{ old('titre') }}" class="w-full border-gray-300 rounded" required>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Description (optionnel)</label>
            <textarea name="description" class="w-full border-gray-300 rounded" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Filière</label>
                <select name="filiere_id" id="filiere_id" class="w-full border-gray-300 rounded" required>
                    <option value="">-- Choisir --</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}" @selected(old('filiere_id') == $filiere->id)>{{ $filiere->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Matière</label>
                <select name="matiere_id" id="matiere_id" class="w-full border-gray-300 rounded" required>
                    <option value="">-- Choisir une filière d'abord --</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Niveau</label>
                <select name="niveau_id" class="w-full border-gray-300 rounded" required>
                    <option value="">-- Choisir --</option>
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" @selected(old('niveau_id') == $niveau->id)>{{ $niveau->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type de document</label>
                <select name="type_document_id" class="w-full border-gray-300 rounded" required>
                    <option value="">-- Choisir --</option>
                    @foreach ($typesDocument as $type)
                        <option value="{{ $type->id }}" @selected(old('type_document_id') == $type->id)>{{ $type->nom }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Année académique</label>
                <input type="text" name="annee_academique" placeholder="2024-2025" value="{{ old('annee_academique') }}" class="w-full border-gray-300 rounded" required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Fichier</label>
                <input type="file" name="fichier" class="w-full" required>
            </div>
        </div>

        <button type="submit" class="bg-red-700 hover:bg-red-800 text-white px-6 py-2 rounded font-semibold">
            Déposer le document
        </button>
    </form>
@endsection

@push('scripts')
<script>
document.getElementById('filiere_id').addEventListener('change', async function () {
    const filiereId = this.value;
    const selectMatiere = document.getElementById('matiere_id');
    selectMatiere.innerHTML = '<option value="">Chargement...</option>';

    if (!filiereId) {
        selectMatiere.innerHTML = '<option value="">-- Choisir une filière d\'abord --</option>';
        return;
    }

    const reponse = await fetch(`/matieres/par-filiere/${filiereId}`);
    const matieres = await reponse.json();

    selectMatiere.innerHTML = '<option value="">-- Choisir --</option>';
    matieres.forEach(matiere => {
        const option = document.createElement('option');
        option.value = matiere.id;
        option.textContent = matiere.nom;
        selectMatiere.appendChild(option);
    });
});
</script>
@endpush