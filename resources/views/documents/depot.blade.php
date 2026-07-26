@extends('layouts.app')

@section('contenu')
    {{-- En-tête de page --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold tracking-tight" style="color: var(--ink); font-family: 'Poppins', sans-serif;">
            Déposer un document
        </h1>
        <p class="text-sm mt-1" style="color: var(--ink-soft, #6B7280);">
            Partagez des ressources pédagogiques avec les étudiants et enseignants.
        </p>
    </div>

    {{-- Gestion des Erreurs de Validation --}}
    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-2xl mb-6 text-sm">
            <div class="flex items-center gap-2 font-bold mb-2">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Des erreurs sont survenues :</span>
            </div>
            <ul class="list-disc list-inside space-y-1 text-xs pl-2">
                @foreach ($errors->all() as $erreur)
                    <li>{{ $erreur }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Avertissement de Doublon --}}
    @if (session('avertissement_doublon'))
        <div class="bg-amber-50 border border-amber-200 text-amber-900 p-4 rounded-2xl mb-6 text-sm">
            <div class="flex items-center gap-2 font-bold text-amber-800 mb-1">
                <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
                <span>Document similaire détecté</span>
            </div>
            <p class="text-xs text-amber-700 mb-3">
                Un document proche existe déjà : « <strong class="font-semibold">{{ session('document_similaire') }}</strong> ».
            </p>
            <label class="inline-flex items-center gap-2 text-xs font-semibold cursor-pointer select-none">
                <input type="checkbox" 
                       name="confirmer_malgre_doublon" 
                       form="formulaireDepot" 
                       value="1"
                       class="rounded border-amber-300 text-amber-600 focus:ring-amber-500">
                <span>Je confirme vouloir déposer ce document malgré tout</span>
            </label>
        </div>
    @endif

    {{-- Formulaire Principal --}}
    <form id="formulaireDepot" 
          method="POST" 
          action="{{ route('documents.store') }}" 
          enctype="multipart/form-data" 
          class="bg-white p-6 sm:p-8 rounded-2xl border border-gray-200/80 shadow-sm space-y-6">
        @csrf

        {{-- Titre --}}
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                Titre du document <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="titre" 
                   value="{{ old('titre') }}" 
                   placeholder="Ex: Examen de Synthèse - Session Juin"
                   class="w-full text-sm bg-gray-50/50 border border-gray-200 rounded-xl py-2.5 px-3.5 focus:bg-white focus:border-gray-400 focus:ring-0 transition placeholder-gray-400"
                   required>
        </div>

        {{-- Description --}}
        <div>
            <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                Description <span class="text-gray-400 text-[10px] font-normal">(optionnel)</span>
            </label>
            <textarea name="description" 
                      rows="3" 
                      placeholder="Précisez le contenu ou le contexte du document..."
                      class="w-full text-sm bg-gray-50/50 border border-gray-200 rounded-xl py-2.5 px-3.5 focus:bg-white focus:border-gray-400 focus:ring-0 transition placeholder-gray-400">{{ old('description') }}</textarea>
        </div>

        {{-- Grille des Sélecteurs --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            {{-- Filière --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                    Filière <span class="text-red-500">*</span>
                </label>
                <select name="filiere_id" 
                        id="filiere_id" 
                        class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition cursor-pointer" 
                        required>
                    <option value="">-- Choisir une filière --</option>
                    @foreach ($filieres as $filiere)
                        <option value="{{ $filiere->id }}" @selected(old('filiere_id') == $filiere->id)>
                            {{ $filiere->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Matière --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                    Matière <span class="text-red-500">*</span>
                </label>
                <select name="matiere_id" 
                        id="matiere_id" 
                        class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition cursor-pointer disabled:opacity-50" 
                        required>
                    <option value="">-- Choisir une filière d'abord --</option>
                </select>
            </div>

            {{-- Niveau --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                    Niveau d'étude <span class="text-red-500">*</span>
                </label>
                <select name="niveau_id" 
                        class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition cursor-pointer" 
                        required>
                    <option value="">-- Choisir --</option>
                    @foreach ($niveaux as $niveau)
                        <option value="{{ $niveau->id }}" @selected(old('niveau_id') == $niveau->id)>
                            {{ $niveau->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Type de document --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                    Type de document <span class="text-red-500">*</span>
                </label>
                <select name="type_document_id" 
                        class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition cursor-pointer" 
                        required>
                    <option value="">-- Choisir --</option>
                    @foreach ($typesDocument as $type)
                        <option value="{{ $type->id }}" @selected(old('type_document_id') == $type->id)>
                            {{ $type->nom }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Année académique --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                    Année académique <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="annee_academique" 
                       placeholder="ex: 2024-2025" 
                       value="{{ old('annee_academique') }}" 
                       class="w-full text-xs bg-gray-50 border border-gray-200 rounded-xl py-2.5 px-3 focus:bg-white focus:border-gray-400 focus:ring-0 transition placeholder-gray-400" 
                       required>
            </div>

            {{-- Fichier --}}
            <div>
                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1.5">
                    Fichier joint <span class="text-red-500">*</span>
                </label>
                <input type="file" 
                       name="fichier" 
                       class="w-full text-xs text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 file:transition cursor-pointer" 
                       required>
            </div>
        </div>

        {{-- Boutons d'action --}}
        <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <button type="submit" 
                    class="w-full sm:w-auto px-6 py-2.5 rounded-xl font-medium text-xs tracking-wide text-white transition-all shadow-sm hover:shadow hover:scale-[1.01] active:scale-[0.99] flex items-center justify-center gap-2"
                    style="background-color: var(--blush, #B3121A);">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
                <span>Déposer le document</span>
            </button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const filiereSelect = document.getElementById('filiere_id');
    const matiereSelect = document.getElementById('matiere_id');
    const oldMatiereId = "{{ old('matiere_id') }}";

    async function chargerMatieres(filiereId, selectedMatiereId = null) {
        if (!filiereId) {
            matiereSelect.innerHTML = '<option value="">-- Choisir une filière d\'abord --</option>';
            matiereSelect.disabled = true;
            return;
        }

        matiereSelect.disabled = false;
        matiereSelect.innerHTML = '<option value="">Chargement des matières...</option>';

        try {
            const reponse = await fetch(`/matieres/par-filiere/${filiereId}`);
            const matieres = await reponse.json();

            matiereSelect.innerHTML = '<option value="">-- Choisir une matière --</option>';
            
            matieres.forEach(matiere => {
                const option = document.createElement('option');
                option.value = matiere.id;
                option.textContent = matiere.nom;
                if (selectedMatiereId && selectedMatiereId == matiere.id) {
                    option.selected = true;
                }
                matiereSelect.appendChild(option);
            });
        } catch (error) {
            matiereSelect.innerHTML = '<option value="">Erreur de chargement</option>';
        }
    }

    // Événement au changement de filière
    filiereSelect.addEventListener('change', function () {
        chargerMatieres(this.value);
    });

    // Chargement initial au rafraîchissement si une filière était déjà sélectionnée (ex: retour d'erreur)
    if (filiereSelect.value) {
        chargerMatieres(filiereSelect.value, oldMatiereId);
    }
});
</script>
@endpush