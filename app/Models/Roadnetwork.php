<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roadnetwork extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_roadnetworks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date','status','location','municipality_id','province_id','user_id','updated_at','author'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
