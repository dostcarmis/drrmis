<?php

namespace App;

use App\Models\Logs;
use App\Models\Municipality;
use App\Models\Province;
use App\Role;
use App\Modules;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable {

    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function municipality(){
        return $this->belongsTo(Municipality::class);
    }
    public function province(){
        return $this->belongsTo(Province::class);
    }
    public function role(){
        return $this->belongsTo(Role::class);
    }
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
    public function hasAccess($module_id,$crud = null){
        /* 
        REFERENCE FOR MODULE ID
        | 1	KM Resources
        | 2	SitReps
        | 3	Incident Reports
        | 4	CLEARS
        | 5	PDRA
        | 6	Users
        | 7 Report Generation
        | 8 Libraries
        */
        $access = RoleModules::where('user_id',Auth::user()->id)->where('module_id',$module_id);
        if($crud != null){
            $crud = strtolower(trim($crud));
            $access = $access->where($crud,'1');
            
            $access = $access->get()->toArray();
            if(count($access) == 1){
                
                return true;
            }
            return false; 
        }
        else{
            $access = $access->get();
            if($access && count($access) > 0){
                $access = $access->toArray();
                if($access[0]['create'] == 0
                && $access[0]['read'] == 0
                && $access[0]['update'] == 0
                && $access[0]['delete'] == 0
                ){
                    return false;
                }
                return true;
            }else{
                return false;
            }

        }
    }
    public function print($module_id){
        $rm = RoleModules::where('user_id',Auth::user()->id)->where('module_id',$module_id)->get();
        $rm = $rm->toArray();
        return var_dump($rm[0]);
    }
    public function access(){
        return $this->hasMany(RoleModules::class);
    }
    public function noAccess(){
        $access = array_column($this->access->toArray(),'module_id');
        $modules = Modules::whereNotIn('id',$access)->get();
        return $modules;
    }
    public function module($module_id = null){
        if($module_id != null){
            if(RoleModules::where('user_id',$this->id)->where('module_id',$module_id)->exists()){
                $module = Modules::find($module_id);
            }else{
                $module = false;
            }
        }else{
            $module = RoleModules::where('user_id',$this->id)->get();
        }
        return $module;
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
        'c_token'
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
        return $fullName ? $fullName : NULL;
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

    public function AauthAcessToken(){
        return $this->hasMany('\App\OauthAccessToken');
    }
}
