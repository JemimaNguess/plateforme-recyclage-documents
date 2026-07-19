<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'description',
        'chemin_fichier',
        'hash_fichier',
        'utilisateur_id',
        'filiere_id',
        'matiere_id',
        'niveau_id',
        'type_document_id',
        'annee_academique',
        'nb_telechargements',
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }

    public function filiere()
    {
        return $this->belongsTo(Filiere::class);
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class);
    }

    public function typeDocument()
    {
        return $this->belongsTo(TypeDocument::class, 'type_document_id');
    }

    public function signalements()
    {
        return $this->hasMany(Signalement::class);
    }

    public function telechargements()
    {
        return $this->hasMany(Telechargement::class);
    }
}