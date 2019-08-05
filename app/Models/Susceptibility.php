<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Susceptibility extends Model
{
    protected $table = 'tbl_susceptibility';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['address_id', 'susceptibility_flood','susceptibility_flood','created_at','updated_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
