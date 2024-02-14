<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(5)->create();
        \App\Models\Consultant::factory(5)->create();
        \App\Models\Organization::factory(5)->create();
        \App\Models\Region::factory(5)->create();
        \App\Models\RegionOrganization::factory(5)->create();
        \App\Models\ConsultantOrganization::factory(5)->create();
        \App\Models\Categori::factory(5)->create();
        \App\Models\Question::factory(5)->create();
        \App\Models\Consultation::factory(5)->create();
    }
}
