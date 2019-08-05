<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Floodproneareas extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_floodprone_areas';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['municipality_id','province_id','address','user_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
