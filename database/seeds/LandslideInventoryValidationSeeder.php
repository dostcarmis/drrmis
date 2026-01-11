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
                'description' => 'Raw detection awaiting authoritative review and taxonomic classification.',
                'active' => true
            ],
            [
                'name' => 'Confirmed (Field Validation)',
                'description' => 'Empirically verified through on-site ground-truthing and physical geological assessment.',
                'active' => true
            ],
            [
                'name' => 'Confirmed (Remote Validation)',
                'description' => 'Verified via high-resolution multi-spectral imagery or LiDAR topographic analysis.',
                'active' => true
            ],
            [
                'name' => 'Rejected',
                'description' => 'Identified as a false positive; feature corresponds to anthropogenic activity or non-landslide geomorphology.',
                'active' => true
            ],
            [
                'name' => 'Requires Further Validation',
                'description' => 'Inconclusive evidence; necessitates secondary expert review or multi-temporal data comparison.',
                'active' => true
            ],
        ];

        foreach ($validations as $validation) {
            LandslideInventoryValidation::create($validation);
        }
    }
}
