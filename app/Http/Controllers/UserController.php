<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;
use App\RoleModules;
use DB;
use Session;
use Validator;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Coordinates;
use App\User;
use App\Models\Groups;
use App\Models\Municipality;
use App\Models\Province;
use App\Role;
use App\Modules;
use App\ModuleDefaults;
use Auth;
use Carbon\Carbon;
use Image;

class UserController extends Controller {
	function __construct()
    {
        $this->middleware('auth');
    }
    public function destroymultipleUser(Request $request) {
        
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        User::destroy($request->chks);
        $chk = count($request->chks);
        $cntUser = Auth::user();

        if ($chk == 1) {
            $cntUser->activityLogs($request, $msg = "Deleted a user");
            $delmsg = 'User successfully deleted.';
        } else {
            $cntUser->activityLogs($request, $msg = "Deleted multiple users");
            $delmsg = $chk .' users successfully deleted.';
        }
        
        Session::flash('message',  $delmsg);

        return redirect()->back();
    }

    public function deleteMultipleGroups(Request $request) {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $chk = count($request->chks);

        foreach ($request->chks as $grpID) {
            $grpData = Groups::find($grpID);
            $grpData->deleted_at = Carbon::now();
            $grpData->save();
        }

        if ($chk == 1) {
            $delmsg = 'Group successfully deleted.';
        } else {
            $delmsg = $chk .' groups successfully deleted.';
        }
        
        Session::flash('message',  $delmsg);
        return redirect()->back();
    }

    public function profile() {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $roles = DB::table('roles')->get(); 
        $user_role = DB::table('user_role')->get(); 
        $municipalities = DB::table('tbl_municipality')->get();   
        $provinces = DB::table('tbl_provinces')->get();  

        return view('pages.profile', ['user' =>  Auth::user(),
            'provinces' => $provinces,
            'user_role' => $user_role,
            'roles' => $roles,
            'municipalities' => $municipalities]);
    }

    public function updateProfile(Request $request) {  
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $user = Auth::user();
        $post = $request->all();
        $profile_img = '';
        $filename = '';

        $v = Validator::make($request->all(),
            [  
                'first_name' => 'required',
                'email' => 'required',
                'cellphone_num'=>'required'
            ],
            [
                'first_name.required' => 'First Name is required',
                'email.required' => 'Email is required',
                'cellphone_num.required'=>'Cellphone number is required.'
            ]
        );
        
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {     
            $users='';

            if ($user->id != 1) {
                if ($request->has('password')) {
                    $users = [
                        'first_name' => $post['first_name'],
                        'last_name' => $post['last_name'],
                        'email' => $post['email'],
                        'cellphone_num' => $post['cellphone_num'],            
                        'position' => $post['position'],
                        'profile_img' => $post['filepath'],
                        'password' => bcrypt($post['password']),
                    ];
                } else {
                    $users = [
                        'first_name' => $post['first_name'],
                        'last_name' => $post['last_name'],
                        'email' => $post['email'],
                        'cellphone_num' => $post['cellphone_num'],
                        'position' => $post['position'],
                        'profile_img' => $post['filepath'],
                    ];
                }
            } else {
                if ($request->has('password')) {
                    $users = [
                        'first_name' => $post['first_name'],
                        'last_name' => $post['last_name'],
                        'email' => $post['email'],
                        'cellphone_num' => $post['cellphone_num'],
                        'municipality_id' => $post['municipality_id'],
                        'province_id' => $post['province_id'],
                        'position' => $post['position'],
                        'password' => bcrypt($post['password']),
                        'profile_img' => $post['filepath'],
                    ];
                } else {
                    $users = [
                        'first_name' => $post['first_name'],
                        'last_name' => $post['last_name'],
                        'email' => $post['email'],
                        'cellphone_num' => $post['cellphone_num'],
                        'municipality_id' => $post['municipality_id'],
                        'province_id' => $post['province_id'],
                        'position' => $post['position'],
                        'profile_img' => $post['filepath'],
                    ];
                }
            }

            $i = DB::table('users')->where('id',$user->id)->update($users);

            if ($i > 0) {
                Session::flash('message', 'Profile updated.');
                return redirect('profile');
            } else {
                Session::flash('message', 'Profile updated.');
                return redirect('profile');
            }
        }
    }

    public function viewusers(){	   
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $cntUser = Auth::user();
        $roles = DB::table('roles')->get(); 
        $user_role = DB::table('user_role')->get(); 
        $municipalities = DB::table('tbl_municipality')->get();   
        $provinces = DB::table('tbl_provinces')->get();

        if ($cntUser->role_id == 1) {
            $users = DB::table('users')->orderBy('first_name', 'asc')->get();  
        }else if(($cntUser->role_id == 2) ){
            $users = DB::table('users')
                ->where('id', '!=', $cntUser->id)
                ->where('province_id', '=', $cntUser->province_id)
                ->where('role_id', '>', '2')            
                ->orderBy('created_at', 'desc')
                ->get();
        } else if(($cntUser->role_id == 3)) {
            $users = DB::table('users')
                ->where('id', '!=', $cntUser->id)
                ->where('province_id', '=', $cntUser->province_id)
                ->where('role_id', '>', '3')            
                ->orderBy('created_at', 'desc')
                ->get();  
        } else if ($cntUser->role_id == 4) {
            $users = DB::table('users')
                       ->where('municipality_id', '=', $cntUser->municipality_id)
                       ->where('id', '!=', $cntUser->id)
                       ->where('role_id', '>', '4')
                       ->where('role_id', '!=', '10') //PDRRMC
                       ->orderBy('created_at', 'desc')
                       ->get();  
        }

        return view('pages.viewusers', ['users' => $users,
                                        'provinces' => $provinces,
                                        'roles' => $roles,
                                        'user_role' => $user_role,
                                        'municipalities' => $municipalities]);
    }

    public function viewadduser(){
        $role = Auth::user()->role_id;
        $province = Auth::user()->province_id;
        if($role > 4){
            return redirect()->back();
        }
        $users = DB::table('users')->get();      
        $roles = DB::table('roles'); 
        $user_role = DB::table('user_role'); 
        $municipalities = DB::table('tbl_municipality');
        if($role == 3){
            $roles = $roles->where('id','>',3);
            $municipalities = $municipalities->where('province_id',$province);
        }else if($role == 4){
            $roles = $roles->where('id','>',4)
            ->where('id','!=',10); //PDRRMC
        }
        $municipalities = $municipalities->get();  
        $roles = $roles->get();
        $groups = DB::table('tbl_groups')
                    ->orderBy('group_name')
                    ->get(); 
        $provinces = DB::table('tbl_provinces')->get();  

        return view('pages.adduser', [
            'users' => $users,
            'provinces' => $provinces,
            'roles' => $roles,
            'user_role' => $user_role, 
            'municipalities' => $municipalities,
            'groups' => $groups]);
    }

    public function edituser($id){
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $users = DB::table('users')->where('id',$id)->first();      
        $roles = DB::table('roles')->get(); 
        $user_role = DB::table('user_role')->get(); 
        $municipalities = DB::table('tbl_municipality')->get();
        $groups = DB::table('tbl_groups')
                    ->orderBy('group_name')
                    ->get();
        $provinces = DB::table('tbl_provinces')->get();

        return view('pages.editusers', ['users' => $users,
                                        'provinces' => $provinces,
                                        'roles' => $roles, 
                                        'user_role' => $user_role, 
                                        'municipalities' => $municipalities,
                                        'groups' => $groups]);
    }

    public function updateuser(Request $request){
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $cntUser = Auth::user();
        $post = $request->all();
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
        ];
        $messages = [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'email.required'  => 'Email is required',
        ];
        $v = Validator::make($request->all(), $rules, $messages);     
        
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            if($cntUser->role_id == 1) {
                $users = [
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'username' => $post['username'],
                    'cellphone_num' => $post['cellphone_num'],
                    'province_id' => $post['province_idedit'],
                    'municipality_id' => $post['municipality_idedit'],
                    'role_id' => $post['role_id'],     
                    'email' => $post['email'],
                    'group' => $post['group'],
                    'password'=> bcrypt('password'),
                ];
                $userrole =  ['role_id' => $post['role_id']];

                $i = DB::table('users')
                    ->where('id',$post['id'])
                    ->update($users);
                $x = DB::table('user_role')
                    ->where('user_id',$post['id'])
                    ->update($userrole);
                    
                RoleModules::where('user_id',$post['id'])->delete();
                $this->makeAccess($post['role_id'],$post['id']);
            } else if ($cntUser->role_id == 2) {
                $users = [
                    'first_name' => $post['first_name'],
                    'last_name' => $post['last_name'],
                    'email' => $post['email'],
                    'cellphone_num' => $post['cellphone_num'], 
                ];

                $i = DB::table('users')
                    ->where('id',$post['id'])
                    ->update($users);
            }
            
            Session::flash('message', 'User successfully updated');
            return redirect('viewusers');
        }
    }
    
    public function addnewuser(Request $request) {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $cntUser = Auth::user();
        $user = new User();
        $post = $request->all();
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password'=> 'required|string|min:8|confirmed',
            'municipality_id' => 'required',
            
        ];
        $messages = [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'email.required'  => 'Email is required',
            'cellphone_num.required'  => 'Cellphone # is required',
        ];
        $v = Validator::make($request->all(), $rules, $messages);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            if ($cntUser->role_id == 1) {
                $user->first_name = $post['first_name'];
                $user->last_name = $post['last_name'];
                $user->username = $post['username'];
                $user->cellphone_num = $post['cellphone_num'];
                $user->municipality_id = $post['municipality_id'];
                $user->province_id = $post['province_id'];
                $user->email = $post['email'];
                $user->position = $post['position'];
                $user->password = bcrypt($post['password']);
                $user->role_id = $post['role'];
                $user->profile_img = url('assets/images/default.jpg');
                $user->save();
                $role_id = $post['role'];
                $user->roles()->attach($role_id);
                $this->makeAccess($post['role'],$user->id);
            }
            else if(($cntUser->role_id == 2)){
                $user->first_name = $post['first_name'];
                $user->last_name = $post['last_name'];
                $user->username = $post['username'];
                $user->email = $post['email'];
                $user->position = $post['position'];
                $user->cellphone_num = $post['cellphone_num'];
                $user->province_id = $cntUser->province_id;
                $user->municipality_id = $post['municipality_id'];
                $user->role_id = $post['role'];
                $user->password = bcrypt('password');
                $user->profile_img = url('assets/images/default.jpg');
                $user->save();
                $user->roles()->attach($role_id);
                $this->makeAccess($post['role'],$user->id);
            }
            else if (($cntUser->role_id == 3)) {
                $user->first_name = $post['first_name'];
                $user->last_name = $post['last_name'];
                $user->username = $post['username'];
                $user->email = $post['email'];
                $user->position = $post['position'];
                $user->cellphone_num = $post['cellphone_num'];
                $user->province_id = $cntUser->province_id;
                $user->municipality_id = $cntUser->municipality_id;
                $user->role_id = 10;
                $user->password = bcrypt('password');
                $user->profile_img = url('assets/images/default.jpg');
                $user->save();
                $user->roles()->attach($role_id);
                $this->makeAccess($post['role'],$user->id);
                
            } else if($cntUser->role_id == 4) {
                $user->first_name = $post['first_name'];
                $user->last_name = $post['last_name'];
                $user->username = $post['username'];
                $user->email = $post['email'];
                $user->position = $post['position'];
                $user->cellphone_num = $post['cellphone_num'];
                $user->province_id = $cntUser->province_id;
                $user->municipality_id = $cntUser->municipality_id;
                $user->role_id = '9';
                $user->profile_img = url('assets/images/default.jpg');
                $user->password = bcrypt('password');
                $user->save();
                $user->roles()->attach(Role::where('name', 'Staff')->first());
                $this->makeAccess($post['role'],$user->id);
            }           

            Session::flash('message', 'User successfully added');
            $cntUser->activityLogs($request, $msg = "Added a new user");
            return redirect('viewusers');
        }
    }
    private function makeAccess($role_id,$user_id){
        $modules = ModuleDefaults::where('role_id',$role_id)->get();
        foreach($modules as $m){
            RoleModules::create([
                'user_id'=>$user_id,
                'module_id'=>$m->module_id,
                'create'=>$m->create,
                'read'=>$m->read,
                'update'=>$m->update,
                'delete'=>$m->delete,
            ]);
        }
        // switch($role_id){
        //     case 1:
        //         $modules = RoleModules::insert([
        //             ['user_id'=>$user_id,'module_id'=>1,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>2,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>3,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>4,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>5,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>6,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //         ]);
        //     break;
        //     case 2:
        //         $modules = RoleModules::insert([
        //             ['user_id'=>$user_id,'module_id'=>1,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>2,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>3,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>4,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>5,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>6,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //         ]);
        //     break;
        //     case 3:
        //         $modules = RoleModules::insert([
        //             ['user_id'=>$user_id,'module_id'=>1,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>2,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>3,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>4,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>5,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>6,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //         ]);
        //     break;
        //     case 4:
        //         $modules = RoleModules::insert([
        //             ['user_id'=>$user_id,'module_id'=>1,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>2,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>3,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>4,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>5,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>6,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //         ]);
        //     break;
        //     case 9:
        //         $modules = RoleModules::insert([
        //             ['user_id'=>$user_id,'module_id'=>1,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>2,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>3,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>4,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>5,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //         ]);
        //     break;
        //     case 10:
        //         $modules = RoleModules::insert([
        //             ['user_id'=>$user_id,'module_id'=>1,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>2,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>3,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>4,'create'=>1,'read'=>1,'update'=>1,'delete'=>1],
        //             ['user_id'=>$user_id,'module_id'=>5,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //         ]);
        //     break;
        //     default:
        //         $modules = RoleModules::insert([
        //             ['user_id'=>$user_id,'module_id'=>1,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>2,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>3,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>4,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //             ['user_id'=>$user_id,'module_id'=>5,'create'=>0,'read'=>1,'update'=>0,'delete'=>0],
        //         ]);
        //     break;

        // }
        
    }

    public function destroyUser($id) {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $user = Auth::user();

        if ($id != $user->id) {
            $i = DB::table('users')
                   ->where('id',$id)
                   ->delete();

            if ($i > 0) {
                Session::flash('message', 'User successfully deleted');
                $user->activityLogs($request, $msg = "Deleted a user");
                return redirect('viewusers');
            }
        } else {
            Session::flash('message', 'Cannot delete own account!');
            $user->activityLogs($request, $msg = "Trying to delete own account");
            return redirect('viewusers');
        }
    }

    public function viewGroups() {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $grpData = DB::table('tbl_groups')
                     ->whereNull('deleted_at')
                     ->get();
        return view('pages.viewgroups', ['groups' => $grpData]);
    }

    public function viewCreateGroup() {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        return view('pages.addgroup');
    }

    public function viewUpdateGroup($id) {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $grpData = DB::table('tbl_groups as grp')
                     ->select(DB::raw('CONCAT(user.first_name, " ", user.last_name) AS created_by'),
                             'grp.id', 'grp.group_name', 'grp.sms_api_key', 'grp.description')
                     ->join('users as user', 'user.id', '=', 'grp.created_by')
                     ->where('grp.id', $id)
                     ->first();
        
        return view('pages.editgroup', ['group' => $grpData]);
    }

    public function createGroup(Request $request) {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $rules = [
            'group_name' => 'required',
        ];
        $messages = [
            'group_name.required' => 'Group Name is required',
        ];
        $v = Validator::make($request->all(), $rules, $messages);

        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            $grpData = new Groups;
            $grpData->group_name = $request->group_name;
            $grpData->sms_api_key = $request->sms_api_key;
            $grpData->description = $request->description;
            $grpData->created_by = Auth::user()->id;
            $grpData->save();

            Session::flash('message', 'Group successfully added');
            return redirect('usergroups');
        }
    }

    public function updateGroup(Request $request) {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        $rules = [
            'group_name' => 'required',
        ];
        $messages = [
            'group_name.required' => 'Group Name is required',
        ];
        $v = Validator::make($request->all(), $rules, $messages);
        
        if ($v->fails()) {
            return redirect()->back()->withErrors($v->errors());
        } else {
            $grpID = $request->id;
            $grpData = Groups::find($grpID);
            $grpData->group_name = $request->group_name;
            $grpData->sms_api_key = $request->sms_api_key;
            $grpData->description = $request->description;
            $grpData->save();

            Session::flash('message', 'Group successfully updated');
            return redirect('usergroups');
        }
    }

    public function deleteGroup($id) {
        if(Auth::user()->role_id > 4){
            return redirect()->back();
        }
        try {
            $grpData = Groups::find($id);

            if (empty($grpData->deleted_at)) {
                $grpData->delete();
            } else {
                Session::flash('message', 'Group already deleted!');
                return redirect('usergroups');
            }
        } catch (\Throwable $th) {
            Session::flash('message', 'Cannot delete this group!');
            return redirect('usergroups');
        }

        Session::flash('message', 'Group successfully deleted');
        return redirect('usergroups');
    }

}
