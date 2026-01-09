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

    protected $casts = [
        'details'  => 'array',
        'analysis' => 'array',
        'remarks'  => 'array',
    ];
    
    protected $fillable = [
        'date', 
        'location', 
        'details', 
        'analysis', 
        'remarks', 
        'validation_status',
        'created_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function landslideInventoryValidation()
    {
        return $this->hasOne(LandslideInventoryValidation::class, 'id', 'validation_status');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
