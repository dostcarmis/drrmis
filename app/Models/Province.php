<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Province extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_provinces';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name',];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
