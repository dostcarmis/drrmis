<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Landslide extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_landslide';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date','location','latitude','longitude','description','user_id','updated_by','updated'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
