<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Civility;
use App\Models\Departement;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $civilities = [
            [
                'name' => "Homme",
            ],
            [
                'name' => "Femme",
            ],
            [
                'name' => "Autre",
            ],
        ];
        collect($civilities)->each(function ($civilities) {
            Civility::create($civilities); });

        $departements = [
            [
                'name' => "Ain",
            ],
            [
                'name' => "Aisne",
            ],
            [
                'name' => "Allier",
            ],
            [
                'name' => "Alpes-de-Haute-Provence",
            ],
            [
                'name' => "Hautes-Alpes",
            ],
            [
                'name' => "Alpes-Maritimes",
            ],
            [
                'name' => "Ardèche",
            ],
            [
                'name' => "Ardennes",
            ],
            [
                'name' => "Ariège",
            ],
            [
                'name' => "Aube",
            ],
            [
                'name' => "Aude",
            ],
            [
                'name' => "Aveyron",
            ],
            [
                'name' => "Bouches-du-Rhône",
            ],
            [
                'name' => "Calvados",
            ],
            [
                'name' => "Cantal",
            ],
            [
                'name' => "Charente",
            ],
            [
                'name' => "Charente-Maritime",
            ],
        ];
        collect($departements)->each(function ($departements) {
            Departement::create($departements); });

        \App\Models\Company::factory(15)->create();
        \App\Models\Person::factory(15)->create();
        
        
    }
}