<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeDocument extends Model
{
    use HasFactory;

    protected $table = 'types_document';

    protected $fillable = ['nom'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}