<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClearsAudit extends Model
{
    protected $table = 'tbl_clears_audit';
    protected $fillable = [
        'user_id',
        'clears_id',
        'request',
        'source',
        'remarks'
    ];

}
