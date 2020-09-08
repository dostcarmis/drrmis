<?php

namespace App\Models;
use App\Models\Logs;

use Illuminate\Database\Eloquent\Model;


class User extends Model
{
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name','last_name','profile_img','role_id','municipality_id','province_id', 'email','password','position','designation','cellphone_num'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function notifications()
    {
        return $this->hasMany('App\Models\Notification');
    }
    public function newNotification()
    {
        $notification = new Notification;
        $notification->user()->associate($this);
        return $notification;
    }

    public function activityLogs($request, $msg){
        $userid = $this->id;
        $requestURL = $request->getRequestUrl();
        $method = $request->getMethod();
        $host = $request->header('host');
        $userAgent = $request->header('useragent');

        $instanceEmplog = new activityLogs;
        $intanceEmplog->userid = $userid;
        $intanceEmplog->request = $requestURL;
        $intanceEmplog->method = $method;
        $intanceEmplog->host = $host;
        $intanceEmplog->useragent = $userAgent;
        $intanceEmplog->remarks = $msg;
        $intanceEmplog->save();
    }

}
