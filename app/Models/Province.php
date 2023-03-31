<?php

namespace App\Models;

use App\Riskassess;
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
    public function riskAssessments(){
        return $this->hasMany(Riskassess::class,'province_id');
    }
    public function municipalities(){
        return $this->hasMany(Municipality::class,'province_id');
    }
}
