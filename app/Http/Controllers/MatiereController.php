<?php

namespace App\Http\Controllers;

use App\Models\Matiere;

class MatiereController extends Controller
{
    public function parFiliere($filiereId)
    {
        $matieres = Matiere::where('filiere_id', $filiereId)->orderBy('nom')->get();

        return response()->json($matieres);
    }
}