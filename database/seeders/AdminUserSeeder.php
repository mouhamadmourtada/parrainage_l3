<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\AgentDGE;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Créer un agent DGE admin
        $agent = AgentDGE::create([
            'nom_utilisateur' => 'admin',
            'mot_de_passe_hash' => bcrypt('passer'),
            'nom' => 'Admin',
            'prenom' => 'System',
            'date_creation' => now(),
        ]);

        // Créer un utilisateur admin lié à l'agent DGE
        User::create([
            'nom_utilisateur' => $agent->nom_utilisateur,
            'mot_de_passe_hash' => $agent->mot_de_passe_hash,
            'userable_type' => AgentDGE::class,
            'userable_id' => $agent->id,
            'date_creation' => now(),
        ]);
    }
}
