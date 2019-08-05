<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{   
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    protected $table = 'tbl_notifications';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable   = ['user_id', 'created_by',  'sent_at'];
 
    public function getDates()
    {
        return ['created_at', 'updated_at', 'sent_at'];
    }
 
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
    

    public function deliver()
    {
        $this->sent_at = new Carbon;
        $this->save();
     
        return $this;
    }
    public function scopeUnread($query)
    {
        
        return $query->where('is_seen', '=', 0);
    }
}
