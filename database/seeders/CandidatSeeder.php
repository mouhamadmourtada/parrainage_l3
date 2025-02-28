<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CandidatSeeder extends Seeder
{
    public function run(): void
    {
        // Sélectionner 5 électeurs aléatoires pour devenir candidats
        $electeurs = \App\Models\Electeur::inRandomOrder()->take(5)->get();
        $faker = \Faker\Factory::create('fr_FR');

        foreach ($electeurs as $electeur) {
            $candidat = \App\Models\Candidat::create([
                'numero_electeur' => $electeur->numero_electeur,
                'email' => $faker->unique()->safeEmail(),
                'telephone' => $faker->unique()->phoneNumber(),
                'parti_politique' => $faker->company(),
                'slogan' => $faker->catchPhrase(),
                'photo_url' => $faker->imageUrl(640, 480, 'people'),
                'couleur1' => $faker->hexColor(),
                'couleur2' => $faker->hexColor(),
                'couleur3' => $faker->hexColor(),
                'url_page' => $faker->url(),
                'code_securite' => \Illuminate\Support\Str::random(10),
                'code_validation' => str_pad($faker->numberBetween(0, 99999), 5, '0', STR_PAD_LEFT),
                'date_enregistrement' => now(),
            ]);

            // Créer un compte utilisateur pour le candidat
            \App\Models\User::create([
                'nom_utilisateur' => 'candidat_' . $electeur->numero_electeur,
                'password' => bcrypt('password'),
                'userable_type' => 'App\Models\Candidat',
                'userable_id' => $candidat->id,
                'date_creation' => now(),
            ]);
        }
    }
}
