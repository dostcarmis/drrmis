<?php

namespace App\Http\Controllers;

use App\Modules;
use App\RoleModules;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleModulesController extends Controller
{
    public function show(Request $request){
        $res = RoleModules::get();
        return view('pages.viewmoduleaccess',compact('res'));
        // return response()->json(["res"=]);
    }
    public function save(Request $req){
        $data = $req->input('data');
        $data = json_decode($data);
        $uid = $data->uid;
        $create = $data->create;
        $update = $data->update;
        $response = ['success'=>'success','message'=>'Access updated'];
        if(empty($create) && empty($update)){
            $response['message'] = "No access updated";
        }else{
            if(count($update) > 0){
                foreach($update as $up){
                    if($up->read == 0 && $up->create == 0 && $up->update == 0 && $up->delete == 0){
                        RoleModules::find($up->id)->delete();
                        continue;
                    }else{
                        RoleModules::where('id',$up->id)
                        ->where('user_id',$uid)
                        ->update([
                            'read' => $up->read,
                            'create' => $up->create,
                            'update' => $up->update,
                            'delete' => $up->delete,
                            'special' => 1
                        ]);
                    }
                    
                }
            }
            if(count($create) > 0){
                foreach($create as $cr){
                    RoleModules::create([
                        'user_id' => $uid,
                        'module_id' => $cr->module_id,
                        'read' => $cr->read,
                        'create' => $cr->create,
                        'update' => $cr->update,
                        'delete' => $cr->delete,
                        'special' => 1
                    ]);
                }
            }
        }
        return response()->json($response);
    }
    public function search(Request $req){
        $search = "%".$req->input('ma-search')."%";
        $users = User::where(function($q) use ($search){
            $q->where('first_name','like',$search)
            ->orWhere('last_name','like',$search)
            ->orWhere('username','like',$search)
            ->orWhere('id','like',$search)
            ->orWhere('email','like',$search);
        });
        
        
        if(Auth::user()->role_id == 3 ){
            $users = $users->where('province_id',Auth::user()->province_id)
            ->where('role_id','>',3);
        }
        if(Auth::user()->role_id == 4){
            $users = $users->where('municipality_id',Auth::user()->municipality_id)
            ->where('role_id',7); //LGU Accounts only
        }
        
        $users = $users->get();
        return view('pages.viewmoduleaccess_search',compact('users'));
        
    }
}
