<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class UtilisateurAdminController extends Controller
{
    public function index(Request $request)
    {
        $utilisateurs = Utilisateur::query()
            ->when($request->filled('recherche'), function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->recherche . '%')
                  ->orWhere('email', 'like', '%' . $request->recherche . '%');
            })
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.utilisateurs', compact('utilisateurs'));
    }

    public function toggleStatut(Utilisateur $utilisateur)
    {
        $utilisateur->statut = $utilisateur->statut === 'actif' ? 'suspendu' : 'actif';
        $utilisateur->save();

        return back()->with('succes', 'Statut de ' . $utilisateur->name . ' mis à jour.');
    }
}