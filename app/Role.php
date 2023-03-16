<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\ModuleDefaults;

class Role extends Model
{
	protected $table="roles";
	protected $fillable = [
		'name', 'description'
	];
   	public function users(){
   		return $this->belongsToMany('App\User','user_role','role_id','user_id');
   	}
	public function moduleDefaults(){
		return $this->hasMany(ModuleDefaults::class);
	}
	public function modules(){

	}
}
