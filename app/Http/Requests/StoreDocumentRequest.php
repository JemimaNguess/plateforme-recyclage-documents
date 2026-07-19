<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string'],
            'filiere_id' => ['required', 'exists:filieres,id'],
            'matiere_id' => ['required', 'exists:matieres,id'],
            'niveau_id' => ['required', 'exists:niveaux,id'],
            'type_document_id' => ['required', 'exists:types_document,id'],
            'annee_academique' => ['required', 'string', 'max:9'],
            'fichier' => ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'confirmer_malgre_doublon' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required' => 'Le titre du document est obligatoire.',
            'filiere_id.required' => 'Veuillez sélectionner une filière.',
            'matiere_id.required' => 'Veuillez sélectionner une matière.',
            'niveau_id.required' => 'Veuillez sélectionner un niveau.',
            'type_document_id.required' => 'Veuillez sélectionner un type de document.',
            'annee_academique.required' => 'L\'année académique est obligatoire.',
            'fichier.required' => 'Veuillez sélectionner un fichier à déposer.',
            'fichier.mimes' => 'Le fichier doit être un PDF, un document Word ou une image.',
            'fichier.max' => 'Le fichier ne doit pas dépasser 10 Mo.',
        ];
    }
}