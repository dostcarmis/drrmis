<?php

namespace App\Models;

use App\Barangays;
use App\Riskassess;
use Illuminate\Database\Eloquent\Model;



class Municipality extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_municipality';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','province_id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function province(){
        return $this->belongsTo(Province::class,'province_id');
    }
    public function barangays($municipal_id = null){
        if($municipal_id != null){
            $m = Municipality::find($municipal_id);
            return $m->barangays;
        }
        return $this->hasMany(Barangays::class,'municipality_id')->orderBy('name');
    }
    public function barangay($id){
        return Barangays::find($id);
    }
    public function riskAssessments(){
        return $this->hasMany(Riskassess::class,'municipality_id');
    }
}
