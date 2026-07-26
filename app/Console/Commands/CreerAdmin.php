<?php

namespace App\Console\Commands;

use App\Models\Utilisateur;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreerAdmin extends Command
{
    protected $signature = 'admin:creer {email} {--nom=Administrateur} {--password=motdepasse123}';

    protected $description = 'Crée un compte administrateur ou promeut un compte existant';

    public function handle(): void
    {
        $email = $this->argument('email');

        $utilisateur = Utilisateur::where('email', $email)->first();

        if ($utilisateur) {
            $utilisateur->role = 'admin';
            $utilisateur->save();
            $this->info("Le compte {$email} a été promu administrateur.");
            return;
        }

        Utilisateur::create([
            'name' => $this->option('nom'),
            'email' => $email,
            'password' => Hash::make($this->option('password')),
            'role' => 'admin',
            'statut' => 'actif',
            'email_verified_at' => now(),
        ]);

        $this->info("Compte administrateur créé pour {$email} avec le mot de passe : {$this->option('password')}");
    }
}