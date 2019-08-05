<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class HazardMaps extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_hazardmaps';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['province_id','municipality_id','hazardmap'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
