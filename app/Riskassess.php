<?php

namespace App;

use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Database\Eloquent\Model;

class Riskassess extends Model
{
    protected $table = 'tbl_riskassessfiles';
    protected $fillable = [
        'uploadedby',
        'original_name',
        'municipality_id',
        'province_id',
        'municipality',
        'province',
        'filetype',
        'filename',
        'file',
        'fileurl',
        'date',
    ];

    public function municipality(){
        return $this->belongsTo(Municipality::class,'municipality_id');
    }
    public function province(){
        return $this->belongsTo(Province::class,'province_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'uploadedby');
    }
    
}
