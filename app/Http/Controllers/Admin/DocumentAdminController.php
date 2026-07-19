<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Filiere;
use App\Models\Niveau;
use App\Models\TypeDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentAdminController extends Controller
{
    public function index(Request $request)
    {
        $documents = Document::query()
            ->when($request->filled('filiere_id'), fn ($q) => $q->where('filiere_id', $request->filiere_id))
            ->when($request->filled('niveau_id'), fn ($q) => $q->where('niveau_id', $request->niveau_id))
            ->when($request->filled('type_document_id'), fn ($q) => $q->where('type_document_id', $request->type_document_id))
            ->with(['filiere', 'niveau', 'typeDocument', 'utilisateur'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $filieres = Filiere::orderBy('nom')->get();
        $niveaux = Niveau::orderBy('nom')->get();
        $typesDocument = TypeDocument::orderBy('nom')->get();

        return view('admin.documents', compact('documents', 'filieres', 'niveaux', 'typesDocument'));
    }

    public function destroy(Document $document)
    {
        Storage::disk('local')->delete($document->chemin_fichier);
        $document->delete();

        return back()->with('succes', 'Document supprimé.');
    }
}