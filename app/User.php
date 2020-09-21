<?php

namespace App;
use App\Models\Logs;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function roles()
    {
        return $this->belongsToMany('App\Role', 'user_role', 'user_id', 'role_id');
    }
    
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                return true;
            }
        }
        return false;
    }
    
    public function hasRole($role)
    {
        if ($this->roles()->where('name', $role)->first()) {
            return true;
        }
        return false;
    }
    
    protected $fillable = [
        'first_name',
        'last_name',
        'username', 
        'accesslevel',
        'municipality_id',
        'profile_img',
        'province_id',
        'cellphone_num', 
        'email','password' ,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getFullName($userid = ''){
        if (!$userid){
            $fname = $this->first_name;
            $lname = $this->last_name;
            $fullName = $fname. " " .$lname;
        } else {
            $user = $this::find($userid);
            $fname = $user->first_name;
            $lname = $user->last_name;
        }
        $fullName = $fname. " " .$lname;
        return $fullName;
    }

    public function activityLogs($request, $msg){
        $userid = $this->id ? $this->id : NULL;
        $requestURL = $request->getRequestUri();
        $method = $request->getMethod();
        $host = $request->header('host');
        $userAgent = $request->header('User-Agent');

        //dd([$userAgent, $requestURL, $method, $host, $userAgent, $msg]);

        //dd($this);
        //$instanceEmplog = new Logs;
        $intanceEmplog = new Logs;
        $intanceEmplog->userid = $userid;
        $intanceEmplog->request = $requestURL;
        $intanceEmplog->method = $method;
        $intanceEmplog->host = $host;
        $intanceEmplog->useragent = $userAgent;
        $intanceEmplog->remarks = $msg;
        $intanceEmplog->save();
    }

}
