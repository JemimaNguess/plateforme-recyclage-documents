<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSignalementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'document_id' => ['required', 'exists:documents,id'],
            'motif' => ['required', 'string', 'min:10', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'motif.required' => 'Merci de préciser le motif du signalement.',
            'motif.min' => 'Le motif doit contenir au moins 10 caractères.',
        ];
    }
}