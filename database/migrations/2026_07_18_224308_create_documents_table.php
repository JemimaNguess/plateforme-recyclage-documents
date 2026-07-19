<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('chemin_fichier');
            $table->string('hash_fichier', 64);
            $table->foreignId('utilisateur_id')->constrained('utilisateurs')->onDelete('cascade');
            $table->foreignId('filiere_id')->constrained('filieres');
            $table->foreignId('matiere_id')->constrained('matieres');
            $table->foreignId('niveau_id')->constrained('niveaux');
            $table->foreignId('type_document_id')->constrained('types_document');
            $table->string('annee_academique', 9);
            $table->unsignedInteger('nb_telechargements')->default(0);
            $table->timestamps();

            $table->index('hash_fichier');
            $table->index(['filiere_id', 'matiere_id', 'niveau_id', 'type_document_id', 'annee_academique'], 'idx_documents_recherche');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
