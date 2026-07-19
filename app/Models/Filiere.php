<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom'];

    public function matieres()
    {
        return $this->hasMany(Matiere::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}