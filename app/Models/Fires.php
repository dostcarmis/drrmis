<?php

namespace App\Models;

use App\Http\Requests\Request;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Fires extends Model
{
    protected $table="tbl_fires";
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
