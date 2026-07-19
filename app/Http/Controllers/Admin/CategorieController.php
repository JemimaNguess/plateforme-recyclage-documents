<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFiliereRequest;
use App\Http\Requests\StoreNiveauRequest;
use App\Http\Requests\StoreTypeDocumentRequest;
use App\Http\Requests\StoreMatiereRequest;
use App\Models\Filiere;
use App\Models\Niveau;
use App\Models\TypeDocument;
use App\Models\Matiere;

class CategorieController extends Controller
{
    public function index()
    {
        $filieres = Filiere::withCount('documents')->orderBy('nom')->get();
        $niveaux = Niveau::withCount('documents')->orderBy('nom')->get();
        $typesDocument = TypeDocument::withCount('documents')->orderBy('nom')->get();
        $matieres = Matiere::with('filiere')->withCount('documents')->orderBy('nom')->get();

        return view('admin.categories', compact('filieres', 'niveaux', 'typesDocument', 'matieres'));
    }

    // Filières
    public function storeFiliere(StoreFiliereRequest $request)
    {
        Filiere::create($request->validated());
        return back()->with('succes', 'Filière ajoutée.');
    }

    public function destroyFiliere(Filiere $filiere)
    {
        if ($filiere->documents()->exists()) {
            return back()->with('erreur', 'Impossible de supprimer : des documents utilisent cette filière.');
        }
        $filiere->delete();
        return back()->with('succes', 'Filière supprimée.');
    }

    // Niveaux
    public function storeNiveau(StoreNiveauRequest $request)
    {
        Niveau::create($request->validated());
        return back()->with('succes', 'Niveau ajouté.');
    }

    public function destroyNiveau(Niveau $niveau)
    {
        if ($niveau->documents()->exists()) {
            return back()->with('erreur', 'Impossible de supprimer : des documents utilisent ce niveau.');
        }
        $niveau->delete();
        return back()->with('succes', 'Niveau supprimé.');
    }

    // Types de document
    public function storeTypeDocument(StoreTypeDocumentRequest $request)
    {
        TypeDocument::create($request->validated());
        return back()->with('succes', 'Type de document ajouté.');
    }

    public function destroyTypeDocument(TypeDocument $typeDocument)
    {
        if ($typeDocument->documents()->exists()) {
            return back()->with('erreur', 'Impossible de supprimer : des documents utilisent ce type.');
        }
        $typeDocument->delete();
        return back()->with('succes', 'Type de document supprimé.');
    }

    // Matières
    public function storeMatiere(StoreMatiereRequest $request)
    {
        Matiere::create($request->validated());
        return back()->with('succes', 'Matière ajoutée.');
    }

    public function destroyMatiere(Matiere $matiere)
    {
        if ($matiere->documents()->exists()) {
            return back()->with('erreur', 'Impossible de supprimer : des documents utilisent cette matière.');
        }
        $matiere->delete();
        return back()->with('succes', 'Matière supprimée.');
    }
}