<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Civility;
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

        \App\Models\Company::factory(15)->create();
        \App\Models\Person::factory(15)->create();
        
        
    }
}