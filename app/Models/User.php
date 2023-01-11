<?php

namespace App\Models;
use App\Models\Logs;
use App\Models\Municipality;
use App\Models\Province;
use App\Role;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements JWTSubject {
    
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'profile_img',
        'role_id',
        'municipality_id',
        'province_id', 
        'email',
        'password',
        'position',
        'designation',
        'cellphone_num',
        'c_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    public function notifications() {
        return $this->hasMany('App\Models\Notification');
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }
    public function province(){
        return $this->belongsTo(Province::class);
    }

    public function newNotification() {
        $notification = new Notification;
        $notification->user()->associate($this);
        return $notification;
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }
    public function activityLogs($request, $msg){
        $userid = $this->id ? $this->id : NULL;
        $requestURL = $request->getRequestUri();
        $method = $request->getMethod();
        $host = $request->header('host');
        $userAgent = $request->header('User-Agent');
        $fullname = $this->getFullName();
        $usermunicipality = $this->municipality_id ? $this->municipality_id : NULL;
        $userprovince = $this->province_id ? $this->province_id : NULL;

        //dd([$userAgent, $requestURL, $method, $host, $userAgent, $msg]);

        $intanceEmplog = new Logs;
        $intanceEmplog->userid = $userid;
        $intanceEmplog->request = $requestURL;
        $intanceEmplog->method = $method;
        $intanceEmplog->userfullname = $fullname;
        $intanceEmplog->usermunicipality = $usermunicipality;
        $intanceEmplog->userprovince = $userprovince;
        $intanceEmplog->host = $host;
        $intanceEmplog->useragent = $userAgent;
        $intanceEmplog->remarks = $msg;
        $intanceEmplog->save();
    }
}
