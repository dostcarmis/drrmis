<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sensors;


class Thresholdfloodmodel extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_thresholdflood';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['address_ids','threshold_date','threshold_flood'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    
    protected $hidden = [];
    
    public function sensors(){
        return $this->hasMany('App\Models\Sensors','address_id');
    }
}
