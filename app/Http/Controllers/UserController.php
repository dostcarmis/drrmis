<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;

use DB;
use Session;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Coordinates;
use App\User;
use App\Models\Municipality;
use App\Models\Province;
use App\Role;
use Auth;
use Image;
class UserController extends Controller
{
	function __construct()
   {
      $this->middleware('auth');
   }
   
   public function destroymultipleUser(Request $request){

      User::destroy($request->chks);
      $chk = count($request->chks);

      if($chk == 1){
         $delmsg = 'User successfully deleted.';
      }else{
         $delmsg = $chk .' users successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);

      return redirect()->back();
   }

   public function profile(){

    $roles = DB::table('roles')->get(); 
    $user_role = DB::table('user_role')->get(); 
    $municipalities = DB::table('tbl_municipality')->get();   
    $provinces = DB::table('tbl_provinces')->get();  

    return view('pages.profile',array('user' =>  Auth::user()))->with(['provinces' => $provinces,'user_role' => $user_role,'roles' => $roles,'municipalities' => $municipalities]);

   }
   public function updateProfile(Request $request)
   {  
      $user = Auth::user();
      $post = $request->all();
      $profile_img='';
      $filename='';

      $v = \Validator::make($request->all(),
         [  
            'first_name' => 'required',
            'email' => 'required',


         ]);
      
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{         
         $users='';
         if($user->id != 1){
            if($request->has('password')){
            $users = array(
               'first_name' => $post['first_name'],
               'last_name' => $post['last_name'],
               'email' => $post['email'],
               'cellphone_num' => $post['cellphone_num'],            
               'designation' => $post['designation'],
               'position' => $post['position'],
               'profile_img' => $post['filepath'],
               'password' => bcrypt($post['password']),
            );
            }else{
               $users = array(
                  'first_name' => $post['first_name'],
                  'last_name' => $post['last_name'],
                  'email' => $post['email'],
                  'cellphone_num' => $post['cellphone_num'],
                  'designation' => $post['designation'],
                  'position' => $post['position'],
                  'profile_img' => $post['filepath'],
               );
            }
         }else{
            if($request->has('password')){
            $users = array(
               'first_name' => $post['first_name'],
               'last_name' => $post['last_name'],
               'email' => $post['email'],
               'cellphone_num' => $post['cellphone_num'],
               'municipality_id' => $post['municipality_id'],
               'province_id' => $post['province_id'],
               'designation' => $post['designation'],
               'position' => $post['position'],
               'password' => bcrypt($post['password']),
               'profile_img' => $post['filepath'],
            );
            }else{
               $users = array(
                  'first_name' => $post['first_name'],
                  'last_name' => $post['last_name'],
                  'email' => $post['email'],
                  'cellphone_num' => $post['cellphone_num'],
                  'municipality_id' => $post['municipality_id'],
                  'province_id' => $post['province_id'],
                  'designation' => $post['designation'],
                  'position' => $post['position'],
                  'profile_img' => $post['filepath'],
               );
            }
         }
         $i = DB::table('users')->where('id',$user->id)->update($users);
         if($i > 0){
            \Session::flash('message', 'Profile updated.');
            return redirect('profile');
         }else{
            \Session::flash('message', 'Profile updated.');
            return redirect('profile');
         }
      }
   }
    public function viewusers(){	   
      $cntUser = Auth::user();
      $roles = DB::table('roles')->get(); 
      $user_role = DB::table('user_role')->get(); 
      $municipalities = DB::table('tbl_municipality')->get();   
      $provinces = DB::table('tbl_provinces')->get();  
      if($cntUser->role_id == 1){
        $users = DB::table('users')->orderBy('first_name', 'asc')->get();  
      }elseif(($cntUser->role_id == 2) || ($cntUser->role_id == 3)){
         $users = DB::table('users')->where('province_id', '=', $cntUser->province_id)->where('role_id', '!=', '1')->orderBy('created_at', 'desc')->get();  
      }elseif($cntUser->role_id == 4){
         $users = DB::table('users')->where('municipality_id', '=', $cntUser->municipality_id)->where('id', '!=', $cntUser->id)->where('role_id', '!=', '3')->where('role_id', '!=', '2')->where('role_id', '!=', '1')->orderBy('created_at', 'desc')->get();  
      }
       return view('pages.viewusers')->with(['users' => $users,'provinces' => $provinces,'roles' => $roles,'user_role' => $user_role, 'municipalities' => $municipalities]);
	    
    }
    public function viewadduser(){
       $users = DB::table('users')->get();      
       $roles = DB::table('roles')->get(); 
          $user_role = DB::table('user_role')->get(); 
          $municipalities = DB::table('tbl_municipality')->get();   
          $provinces = DB::table('tbl_provinces')->get();   
          return view('pages.adduser')->with(['users' => $users,'provinces' => $provinces,'roles' => $roles,'user_role' => $user_role, 'municipalities' => $municipalities]);
    }
    public function edituser($id){
      $users = DB::table('users')->where('id',$id)->first();      
      $roles = DB::table('roles')->get(); 
      $user_role = DB::table('user_role')->get(); 
      $municipalities = DB::table('tbl_municipality')->get();   
      $provinces = DB::table('tbl_provinces')->get();   
      return view('pages.editusers')->with(['users' => $users,'provinces' => $provinces,'roles' => $roles, 'user_role' => $user_role, 'municipalities' => $municipalities]);
    }
   public function updateuser(Request $request)
   {
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
       $v = \Validator::make($request->all(), $rules, $messages);     
      
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         if($cntUser->role_id == 1){
            $users = array(
               'first_name' => $post['first_name'],
               'last_name' => $post['last_name'],
               'cellphone_num' => $post['cellphone_num'],
               'province_id' => $post['province_idedit'],
               'municipality_id' => $post['municipality_idedit'],
               'role_id' => $post['role_id'],     
               'email' => $post['email'],
            );
            $userrole =  array('role_id' => $post['role_id']);

         $i = DB::table('users')->where('id',$post['id'])->update($users);
         $x = DB::table('user_role')->where('user_id',$post['id'])->update($userrole);
         }elseif($cntUser->role_id == 2){
            $users = array(
               'first_name' => $post['first_name'],
               'last_name' => $post['last_name'],
               'email' => $post['email'],
               'cellphone_num' => $post['cellphone_num'], 
            );
            $i = DB::table('users')->where('id',$post['id'])->update($users);
         } 
         
            Session::flash('message', 'User successfully updated');
            return redirect('viewusers');
         
      }
   }
   public function addnewuser(Request $request)
   {
      $cntUser = Auth::user();
      $user = new User();
      $post = $request->all();
      $rules = [
           'first_name' => 'required',
           'last_name' => 'required',
           'email' => 'required',
           'cellphone_num' => 'required',
           
       ];
       $messages = [
           'first_name.required' => 'First Name is required',
           'last_name.required' => 'Last Name is required',
           'email.required'  => 'Email is required',
           'cellphone_num.required'  => 'Cellphone # is required',

       ];
       $v = \Validator::make($request->all(), $rules, $messages);

      
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{

         if($cntUser->role_id == 1){
            $user->first_name = $post['first_name'];
            $user->last_name = $post['last_name'];
            $user->cellphone_num = $post['cellphone_num'];
            $user->municipality_id = $post['municipality_id'];
            $user->province_id = $post['province_id'];
            $user->email = $post['email'];
            $user->password = bcrypt('password');
            $user->role_id = $post['role'];
            $user->profile_img = url('assets/images/default.jpg');
            $user->save();
            $role_id = $post['role'];
            $user->roles()->attach($role_id);

         }elseif(($cntUser->role_id == 2) || ($cntUser->role_id == 3)){
            $user->first_name = $post['first_name'];
            $user->last_name = $post['last_name'];
            $user->email = $post['email'];
            $user->cellphone_num = $post['cellphone_num'];
            $user->province_id = $cntUser->province_id;
            $user->municipality_id = $cntUser->municipality_id;
            $user->role_id = '4';
            $user->password = bcrypt('password');
            $user->profile_img = url('assets/images/default.jpg');
            $user->save();
            $user->roles()->attach($role_id);
         }elseif($cntUser->role_id == 4){
            $user->first_name = $post['first_name'];
            $user->last_name = $post['last_name'];
            $user->email = $post['email'];
            $user->cellphone_num = $post['cellphone_num'];
            $user->province_id = $cntUser->province_id;
            $user->municipality_id = $cntUser->municipality_id;
            $user->role_id = '5';
            $user->profile_img = url('assets/images/default.jpg');
            $user->password = bcrypt('password');
            $user->save();
            $user->roles()->attach(Role::where('name', 'Staff')->first());
         }           

         Session::flash('message', 'User successfully added');
         return redirect('viewusers');
         
      }
   }
   public function destroyUser($id){
      $user = Auth::user();
      if($id != $user->id){
         $i = DB::table('users')->where('id',$id)->delete();
          if($i > 0)
         {
            \Session::flash('message', 'User successfully deleted');
            return redirect('viewusers');
         }
      }else{
         \Session::flash('message', 'Cannot delete own account!');
            return redirect('viewusers');
      }
   }

   
}
