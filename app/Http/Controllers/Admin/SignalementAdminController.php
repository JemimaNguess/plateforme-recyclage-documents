<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Signalement;
use Illuminate\Support\Facades\Storage;

class SignalementAdminController extends Controller
{
    public function index()
    {
        $signalements = Signalement::with(['document', 'utilisateur'])
            ->orderByRaw("CASE WHEN statut = 'en_attente' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(15);

        return view('admin.signalements', compact('signalements'));
    }

    public function traiter(Signalement $signalement)
    {
        $signalement->statut = 'traite';
        $signalement->save();

        return back()->with('succes', 'Signalement marqué comme traité.');
    }

    public function rejeter(Signalement $signalement)
    {
        $signalement->statut = 'traite';
        $signalement->save();

        return back()->with('succes', 'Signalement rejeté (document conservé).');
    }

    public function supprimerDocument(Signalement $signalement)
    {
        $document = $signalement->document;

        if ($document) {
            Storage::disk('local')->delete($document->chemin_fichier);
            $document->delete();
        }

        $signalement->statut = 'traite';
        $signalement->save();

        return back()->with('succes', 'Document supprimé suite au signalement.');
    }
}