<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;

class LandslideInventory extends Model
{
    use SoftDeletes;   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date', 
        'location', 
        'details', 
        'analysis', 
        'remarks',
        'created_by_id'
    ];

    protected $casts = [
        'details'  => 'array',
        'analysis' => 'array',
        'remarks'  => 'array',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * Get the user associated with this landslide inventory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');
    }

    /**
     * Get the candidates associated with this landslide inventory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function candidates()
    {
        return $this->hasMany(LandslideInventoryCandidate::class, 'landslide_inventory_id');
    }
}
