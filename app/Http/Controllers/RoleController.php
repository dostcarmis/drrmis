<?php

namespace App\Http\Controllers;
use App\Role;
use App\ModuleDefaults;
use App\Modules;
use App\User;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function show(){
        $roles = Role::get();
        return view('pages.viewrolesmanagement',compact('roles'));
    }
    public function save(Request $req){
        $response = [];
        if(!$req->has('name') || !$req->has('description') || strlen(trim($req->input('name'))) == 0 ||  strlen(trim($req->input('description'))) == 0){
            $response['success'] = 'danger'; $response['message'] = "Fields required.";
        }else{
            $c = Role::create([
                'name'=>$req->input('name'),
                'description'=>$req->input('description')
            ]);
            if($c){
                $response['success']='success'; $response['message'] = "Role created";
            }else{
                $response['success']='warning'; $response['message'] = "Role not created. Please contact developer";
            }
        }
        return response()->json($response);
    }
    public function update(Request $req){
        $response = [];
        if(!$req->has('name') || !$req->has('description') || strlen(trim($req->input('name'))) == 0 ||  strlen(trim($req->input('description'))) == 0 || !$req->has('id')){
            $response['success'] = 'danger'; $response['message'] = "Fields required.";
        }else{
            $role = Role::find($req->input('id'));

            $u = $role->update([
                'name'=>$req->input('name'),
                'description'=>$req->input('description')
            ]);
            if($u){
                $response['success']='success'; $response['message'] = "Role updated";
            }else{
                $response['success']='warning'; $response['message'] = "Role not updated. Please contact developer";
            }
        }
        return response()->json($response);
    }
    public function delete(Request $req){
        $response = [];
        if(!$req->has('id')){
            $response['success'] = 'danger'; $response['message'] = "Fields required.";
        }else{
            $u = Role::find($req->input('id'))->delete();
            if($u){
                $response['success']='success'; $response['message'] = "Role deleted";
            }else{
                $response['success']='warning'; $response['message'] = "Role not deleted. Please contact developer";
            }
        }
        return response()->json($response);
    }
}
