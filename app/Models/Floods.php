<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Floods extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_flood';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['original_name','filename','date','location','latitude','longitude','description','user_id','updated_by','updated'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
