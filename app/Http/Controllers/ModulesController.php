<?php

namespace App\Http\Controllers;
use App\Modules;
use App\Role;
use App\RoleModules;
use Illuminate\Http\Request;

class ModulesController extends Controller
{
    public function show(Request $request){
        $modules = Modules::get();
        return view('pages.viewmodulesmanagement',compact('modules'));
    }
    public function crud(Request $request){
        if($request->has('type')){
            $type = $request->input('type');
            $data = [];
            $data['modules'] = Modules::get();
            switch($type){
                
                case 'add':
                    $data['roles'] = Role::get();
            }
            return view('pages.'.$type.'modules',compact('data'));
        }
    }
    public function userlist(Request $req){
        $mid = $req->input('module_id');
        $module = Modules::find($mid);
        $user = RoleModules::where('module_id',$module->id)
        ->where(function($q){
            $q->where('create',1)
            ->orWhere('read',1)
            ->orWhere('update',1)
            ->orWhere('delete',1);
        })->get();
        return view('pages.viewmoduleuserlist', compact('module', 'user'));
    }
    public function editform(Request $req){
        $id = $req->input('id');
        $module = Modules::find($id);
        $roles = Role::get();
        return view('pages.editmoduleform', compact('module', 'roles'));
    }
    
}
