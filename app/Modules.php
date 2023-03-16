<?php

namespace App;

use App\User;
use App\Role;
use App\RoleModules;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    protected $table = 'modules';
    protected $fillable = [
        'name',
        'description',
        'remarks',
        'created_at',
        'updated_at',
    ];
    
    public function moduleDefaults(){
        return $this->hasMany(ModuleDefaults::class,'module_id','id');
    }
    public function roleModules($strict = false){
        if(!$strict)
            return $this->hasMany(RoleModules::class,'module_id','id');
        else{
            return $this->hasMany(RoleModules::class,'module_id','id')
            ->where(function($q){
                $q->where('create',1)
                ->orWhere('read',1)
                ->orWhere('update',1)
                ->orWhere('delete',1);
            })->get()->toArray();
            
        }
    }
    public function noAccess(){
        $access = array_column($this->moduleDefaults->toArray(),'role_id');
        $roles = Role::whereNotIn('id',$access)->get();
        return $roles;
        
    }
}
