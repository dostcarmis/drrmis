<?php

namespace App\Models;

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
        return $this->belongsTo(Province::class);
    }
}
