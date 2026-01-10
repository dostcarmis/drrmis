<?php

use Illuminate\Database\Seeder;
use App\Modules;


class LandslideInventoryModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Modules::create([
            'name' => 'Landslides (GEE)',
            'description' => 'Module for managing landslide inventory data'
        ]);
    }
}
