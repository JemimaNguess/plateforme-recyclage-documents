<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Signalement;
use App\Models\Utilisateur;

class TableauBordController extends Controller
{
    public function index()
    {
        $totalDocuments = Document::count();
        $totalUtilisateurs = Utilisateur::count();
        $signalementsEnAttente = Signalement::where('statut', 'en_attente')->count();
        $depotsRecents = Document::where('created_at', '>=', now()->subDays(7))->count();

        return view('admin.tableau-bord', compact(
            'totalDocuments',
            'totalUtilisateurs',
            'signalementsEnAttente',
            'depotsRecents'
        ));
    }
}