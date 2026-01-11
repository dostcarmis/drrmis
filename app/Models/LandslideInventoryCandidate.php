<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LandslideInventoryCandidate extends Model
{
    use SoftDeletes;   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'landslide_inventory_id',
        'candidate_id',
        'date', 
        'province_id',
        'municipality_id',
        'location',
        'latitude',
        'longitude',
        'area_m2',
        'validator_id',
        'validation_id',
        'incident_images'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    protected $casts = [
        'incident_images' => 'array',
    ];

    /**
     * Get the landslide inventory associated with this landslide inventory candidate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function landslideInventory()
    {
        return $this->belongsTo(LandslideInventory::class, 'landslide_inventory_id', 'id');
    }

    /**
     * Get the validation associated with this landslide inventory candidate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function landslideInventoryValidation()
    {
        return $this->hasOne(LandslideInventoryValidation::class, 'id', 'validation_id');
    }

    /**
     * Get the validator associated with this landslide inventory candidate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function validator()
    {
        return $this->belongsTo(User::class, 'validator_id', 'id');
    }
}
