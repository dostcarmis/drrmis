<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleDefaults extends Model
{
    protected $table = "module_defaults";
    protected $fillable = [
        'module_id',
        'role_id',
        'create',
        'read',
        'update',
        'delete',
    ];  
    public function roles(){
        return $this->belongsTo(Role::class,'role_id');
    }
    public function modules(){
        return $this->belongsTo(Modules::class,'module_id');
    }
}
