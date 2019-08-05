<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Sensors extends Model
{
    protected $table = 'tbl_sensors';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id', 'address','latitude', 'longtitude','updated_at','created_at' ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function threshold(){
        return $this->belongsTo('App\Models\Threshold','id');
    }
}
