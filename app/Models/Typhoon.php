<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sensors;


class Typhoon extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_typhoontracks';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['typhoonstat','typhoonName','typhoonpath','uploadedby'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    protected $hidden = [];

}
