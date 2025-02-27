<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Electeur;
use Faker\Factory;

class ElecteurSeeder extends Seeder
{
    public function run(): void
    {
        // Créer 100 électeurs de test
        $faker = Factory::create('fr_FR');
        for ($i = 1; $i <= 100; $i++) {
            Electeur::create([
                'cin' => 'CIN' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'numero_electeur' => 'EL' . str_pad($i, 8, '0', STR_PAD_LEFT),
                'nom' => $faker->lastName(),
                'prenom' => $faker->firstName(),
                'date_naissance' => $faker->date(),
                'lieu_naissance' => $faker->city(),
                'sexe' => $faker->randomElement(['M', 'F']),
                'bureau_vote' => 'BV' . str_pad($faker->numberBetween(1, 20), 3, '0', STR_PAD_LEFT),
            ]);
        }
    }
}
