<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicular extends Model
{
    protected $table="tbl_vehicular";
    protected $fillable = [
        'uploader_id',
        'editor_id',
        'date',
        'incident_images',
        'description',
        'casualties',
        'damages',
        'latitude',
        'longitude',
        'municipality_id',
        'province_id',
        'reportedby',
    ];
    public function uploader(){
        return $this->belongsTo(User::class,'uploader_id');
    }
}
