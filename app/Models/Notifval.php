<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifval extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_notifdate';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['assoc_file','sensor_id','date'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
