<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class Incidents extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_incidents';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['incident_type','slug','date','location','incident_images','latitude','longitude','description','created_by','updated_by'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
