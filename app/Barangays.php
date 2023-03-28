<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Municipality;

class Barangays extends Model
{
    protected $table = 'tbl_barangay';
    public function municipality(){
        return $this->belongsTo(Municipality::class,'municipality_id');
    }
}
