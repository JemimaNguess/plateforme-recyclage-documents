<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telechargement extends Model
{
    use HasFactory;

    protected $fillable = ['document_id', 'utilisateur_id'];

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'utilisateur_id');
    }
}