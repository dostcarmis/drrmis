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
    
    protected $table = 'tbl_landslides';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'road_location',
        'house_location',
        'municipality',
        'province_id',
        'landcover',
        'landmark',
        'landslidetype',
        'landslidereccuring',
        'lewidth',
        'lelength',
        'ledepth',
        'idkilled',
        'idinjured',
        'idmissing',
        'idaffectedcrops',
        'cause',
        'typhooname',
        'heavyrainfall',
        'reportedby',
        'reporterpos',
        'incident_images',
        'pastrainvalue',
        'latitude',
        'longitude',
        'created_by',
        'updated_by',
        'author',
        'user_municipality',
        'report_status'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    public function municipal(){
        return $this->hasOne('App\Models\Municipality', 'id', 'municipality');
      }
      public function province(){
        return $this->hasOne('App\Models\Province', 'id', 'province_id');
      }
    
}
