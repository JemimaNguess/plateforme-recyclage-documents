<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSignalementRequest;
use App\Models\Signalement;

class SignalementController extends Controller
{
    public function store(StoreSignalementRequest $request)
    {
        $donnees = $request->validated();

        Signalement::create([
            'document_id' => $donnees['document_id'],
            'utilisateur_id' => auth()->id(),
            'motif' => $donnees['motif'],
            'statut' => 'en_attente',
        ]);

        return back()->with('succes', 'Le document a été signalé. Merci pour votre vigilance.');
    }
}