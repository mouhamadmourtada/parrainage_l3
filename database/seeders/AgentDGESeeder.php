<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AgentDGE;
use App\Models\User;
use Faker\Factory;

class AgentDGESeeder extends Seeder
{
    public function run(): void
    {
        $faker = Factory::create('fr_FR');

        // Créer 5 agents DGE
        for ($i = 1; $i <= 5; $i++) {
            $agent = AgentDGE::create([
                'nom_utilisateur' => 'agent' . $i . "@gmail.com",
                'password' => bcrypt('password'),
                'nom' => $faker->lastName(),
                'prenom' => $faker->firstName(),
                'date_creation' => now(),
            ]);

            // Créer un compte utilisateur pour l'agent
            User::create([
                'nom_utilisateur' => $agent->nom_utilisateur,
                'password' => $agent->password,
                'userable_type' => 'App\Models\AgentDGE',
                'userable_id' => $agent->id,
                'date_creation' => now(),
                'email' => $agent->nom_utilisateur,
            ]);
        }
    }
}
