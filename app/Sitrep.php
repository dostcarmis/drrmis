<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sitrep extends Model
{
    protected $table = 'tbl_sitreps';
    protected $fillable = [
        "uploadedby",
        "risk_type",
        "typhoon_name",
        "original_name",
        "sitrep_level",
        "filetype",
        "filename",
        "file",
        "fileurl",
    ];
    public function user(){
        return $this->belongsTo(User::class,'uploadedby')->orderBy('created_at', 'desc');
    }
    public function user_name($id){
        $user = User::where('id',$id)->get()->first();
        return $user->first_name." ".$user->last_name;
    }
    public function uploader(){
        return $this->belongsTo(User::class,'uploadedby');
    }
}
