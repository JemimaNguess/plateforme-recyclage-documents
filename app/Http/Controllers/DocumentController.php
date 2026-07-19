<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Models\Document;
use App\Models\Filiere;
use App\Models\Matiere;
use App\Models\Niveau;
use App\Models\TypeDocument;
use App\Models\Telechargement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentController extends Controller
{
    // Formulaire de dépôt
    public function create()
    {
        $filieres = Filiere::orderBy('nom')->get();
        $niveaux = Niveau::orderBy('nom')->get();
        $typesDocument = TypeDocument::orderBy('nom')->get();

        return view('documents.depot', compact('filieres', 'niveaux', 'typesDocument'));
    }

    // Enregistrement du dépôt
    public function store(StoreDocumentRequest $request)
    {
        $donnees = $request->validated();
        $fichier = $request->file('fichier');

        // Calcul du hash du fichier
        $hashFichier = hash_file('sha256', $fichier->getRealPath());

        // Vérification de doublon (sauf si l'utilisateur a déjà confirmé malgré l'avertissement)
        if (!$request->boolean('confirmer_malgre_doublon')) {
            $doublon = Document::where('hash_fichier', $hashFichier)
                ->orWhere(function ($requete) use ($donnees) {
                    $requete->where('titre', 'like', '%' . $donnees['titre'] . '%')
                        ->where('matiere_id', $donnees['matiere_id'])
                        ->where('niveau_id', $donnees['niveau_id'])
                        ->where('annee_academique', $donnees['annee_academique'])
                        ->where('type_document_id', $donnees['type_document_id']);
                })
                ->first();

            if ($doublon) {
                return back()
                    ->withInput()
                    ->with('avertissement_doublon', true)
                    ->with('document_similaire', $doublon->titre);
            }
        }

        // Stockage du fichier avec un nom unique
        $nomFichier = Str::uuid() . '.' . $fichier->getClientOriginalExtension();
        $cheminFichier = $fichier->storeAs('documents_deposes', $nomFichier, 'local');

        // Création de l'enregistrement
        Document::create([
            'titre' => $donnees['titre'],
            'description' => $donnees['description'] ?? null,
            'chemin_fichier' => $cheminFichier,
            'hash_fichier' => $hashFichier,
            'utilisateur_id' => auth()->id(),
            'filiere_id' => $donnees['filiere_id'],
            'matiere_id' => $donnees['matiere_id'],
            'niveau_id' => $donnees['niveau_id'],
            'type_document_id' => $donnees['type_document_id'],
            'annee_academique' => $donnees['annee_academique'],
        ]);

        return redirect()->route('documents.mes-documents')
            ->with('succes', 'Document déposé avec succès.');
    }

    // Recherche avec filtres
    public function index(Request $request)
    {
        $documents = Document::query()
            ->when($request->filled('filiere_id'), fn ($q) => $q->where('filiere_id', $request->filiere_id))
            ->when($request->filled('matiere_id'), fn ($q) => $q->where('matiere_id', $request->matiere_id))
            ->when($request->filled('niveau_id'), fn ($q) => $q->where('niveau_id', $request->niveau_id))
            ->when($request->filled('type_document_id'), fn ($q) => $q->where('type_document_id', $request->type_document_id))
            ->when($request->filled('annee_academique'), fn ($q) => $q->where('annee_academique', $request->annee_academique))
            ->when($request->filled('mot_cle'), fn ($q) => $q->where('titre', 'like', '%' . $request->mot_cle . '%'))
            ->with(['filiere', 'matiere', 'niveau', 'typeDocument'])
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $filieres = Filiere::orderBy('nom')->get();
        $niveaux = Niveau::orderBy('nom')->get();
        $typesDocument = TypeDocument::orderBy('nom')->get();

        return view('documents.recherche', compact('documents', 'filieres', 'niveaux', 'typesDocument'));
    }

    // Détail d'un document
    public function show(Document $document)
    {
        $document->load(['utilisateur', 'filiere', 'matiere', 'niveau', 'typeDocument']);

        return view('documents.show', compact('document'));
    }

    // Téléchargement
    public function download(Document $document)
    {
        if (!Storage::disk('local')->exists($document->chemin_fichier)) {
            abort(404, 'Fichier introuvable.');
        }

        $document->increment('nb_telechargements');

        Telechargement::create([
            'document_id' => $document->id,
            'utilisateur_id' => auth()->id(),
        ]);

        return Storage::disk('local')->download($document->chemin_fichier, $document->titre);
    }

    // Mes documents (dépôts + téléchargements)
    public function mesDocuments()
    {
        $mesDepots = Document::where('utilisateur_id', auth()->id())
            ->with(['filiere', 'matiere', 'niveau', 'typeDocument'])
            ->latest()
            ->get();

        $mesTelechargements = Telechargement::where('utilisateur_id', auth()->id())
            ->with('document')
            ->latest()
            ->get();

        return view('documents.mes-documents', compact('mesDepots', 'mesTelechargements'));
    }
}