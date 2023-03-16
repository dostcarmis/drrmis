<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Modules;
use App\User;
use Auth;
class RoleModules extends Model
{
    protected $table = 'role_modules';
    protected $fillable = [
        'user_id',
        'module_id',
        'create',
        'read',
        'update',
        'delete',
        'special',
        'created_at',
        'updated_at',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function module(){
        return $this->belongsTo(Modules::class,'module_id');
    }
}
