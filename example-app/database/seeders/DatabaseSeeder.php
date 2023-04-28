<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Activitysector;
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

        $sectors = [
            [
                'name' => "Agroalimentaire",
            ],
            [
                'name' => "Banque / Assurance",
            ],
            [
                'name' => "Bois / Papier / Carton / Imprimerie",
            ],
            [
                'name' => "BTP / Matériaux de construction",
            ],
            [
                'name' => "Chimie / Parachimie",
            ],
            [
                'name' => "Commerce / Négoce / Distribution",
            ],
            [
                'name' => "Édition / Communication / Multimédia",
            ],
            [
                'name' => "Électronique / Électricité",
            ],
            [
                'name' => "Études et conseils",
            ],
            [
                'name' => "Industrie pharmaceutique",
            ],
            [
                'name' => "Informatique / Télécoms",
            ],
            [
                'name' => "Machines et équipements / Automobile",
            ],
            [
                'name' => "Métalurgie / Travail du métal",
            ],
            [
                'name' => "Plastique / Caoutchouc",
            ],
            [
                'name' => "Services aux entreprises",
            ],
            [
                'name' => "Textile / Habillement / Chaussure",
            ],
            [
                'name' => "Transports / Logistique",
            ],
        ];
        collect($sectors)->each(function ($sectors) {
            Activitysector::create($sectors); });

        \App\Models\Company::factory(15)->create();
        \App\Models\Person::factory(15)->create();
        
        
    }
}