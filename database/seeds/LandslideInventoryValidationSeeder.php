<?php

use Illuminate\Database\Seeder;
use App\Models\LandslideInventoryValidation;

class LandslideInventoryValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $validations = [
            [
                'name' => 'Pending',
                'description' => 'Awaiting validation or additional data',
                'active' => true
            ],
            [
                'name' => 'Rejected',
                'description' => 'False positive (e.g., agriculture, construction)',
                'active' => true
            ],
            [
                'name' => 'Probable',
                'description' => 'Strong indicators but limited confirmation',
                'active' => true
            ],
            [
                'name' => 'Confirmed',
                'description' => 'Verified by expert review and/or multiple data sources',
                'active' => true
            ],
        ];

        foreach ($validations as $validation) {
            LandslideInventoryValidation::create($validation);
        }
    }
}
