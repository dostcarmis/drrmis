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
                'name' => 'Candidate (Unvalidated)',
                'description' => 'Initial identification pending validation',
                'active' => true
            ],
            [
                'name' => 'Rejected',
                'description' => 'False positive (e.g., agriculture, construction)',
                'active' => true
            ],
            [
                'name' => 'Confirmed (Field Validation)',
                'description' => 'Verified by on-site inspection',
                'active' => true
            ],
            [
                'name' => 'Confirmed (Remote Validation)',
                'description' => 'Verified by high-resolution imagery or other remote sensing methods',
                'active' => true
            ],
            [
                'name' => 'Candidate (Unvalidated)',
                'description' => 'Identified as a potential landslide but not yet validated',
                'active' => true
            ],
        ];

        foreach ($validations as $validation) {
            LandslideInventoryValidation::create($validation);
        }
    }
}
