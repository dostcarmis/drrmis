<?php

namespace App;
use App\Models\User;
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
    public function user(){
        return $this->belongsTo(User::class);
    }
}
