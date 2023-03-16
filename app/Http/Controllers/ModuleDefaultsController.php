<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Modules;
use App\User;
use App\RoleModules;
use App\ModuleDefaults;
class ModuleDefaultsController extends Controller
{
    public function save(Request $req){
        $name = $req->input('name');
        $description = $req->input('description');
        $remarks = $req->input('remarks');
        $module_defaults = $req->input('module-defaults');
        if(Auth::user()->role_id == 1){
            $module = Modules::create([
                'name' => $name,
                'description' => $description,
                'remarks' => $remarks,
            ]);
            $module_id = $module->id;
            foreach($module_defaults as $md){
                $m = ModuleDefaults::create([
                    'module_id' => $module_id,
                    'role_id' => $md['role_id'],
                    'create' => $md['create'],
                    'read' => $md['read'],
                    'update' => $md['update'],
                    'delete' => $md['delete'],
                ]);
                $users = User::where('role_id',$md['role_id'])->get();
                foreach($users as $u){
                    if($md['create'] == 0 && $md['read'] == 0 && $md['update'] == 0 && $md['delete']){
                        continue;
                    }else{
                        $r = RoleModules::create([
                            'user_id' => $u->id,
                            'module_id' => $module_id,
                            'create' => $md['create'],
                            'read' => $md['read'],
                            'update' => $md['update'],
                            'delete' => $md['delete'],
                        ]);
                    }
                }
                
            }
            return response()->json(['success'=>'success','message'=>'Module successfully created']);
        }
    }
    public function update(Request $req){
        $name = $req->input('name');
        $description = $req->input('description');
        $remarks = $req->input('remarks');
        $module_id = $req->input('module_id'); 
        $createable = $req->input('createable');
        $updateable = $req->input('updateable');
        $navupdate = false;
        if(Auth::user()->role_id == 1){

            $module = Modules::find($module_id);
            if($module->name != $name){
                $navupdate = true;
            }
            $module->update([
                'name' => $name,
                'description' => $description,
                'remarks' => $remarks,
            ]);
            if(is_array($updateable) && count($updateable) > 0){
                foreach($updateable as $up){
                    if($up['create'] == 0 && $up['read'] == 0 && $up['update'] == 0 && $up['delete'] == 0){
                        $m_exists = ModuleDefaults::where('id',$up['id'])->exists();
                        if($m_exists)
                            $m = ModuleDefaults::find($up['id'])->delete();
                        $rm = RoleModules::where('module_id',$module_id)->get();
                        foreach($rm as $r_m){
                            $user = User::find($r_m->user_id);
                            if($user->role_id == $up['role_id'] && $r_m->special != 1){
                                $r_m->delete();
                            }
                        }
                    }else{
                        $m = ModuleDefaults::where('id',$up['id'])
                        ->update([
                            'create' => $up['create'],
                            'read' => $up['read'],
                            'update' => $up['update'],
                            'delete' => $up['delete'],
                        ]);
                        $rm = RoleModules::where('module_id',$module_id)->get();
                        foreach($rm as $r_m){
                            $user = User::find($r_m->user_id);
                            if($user->role_id == $up['role_id']){
                                $r_m->update([
                                    'create' => $up['create'],
                                    'read' => $up['read'],
                                    'update' => $up['update'],
                                    'delete' => $up['delete'],
                                ]);
                            }
                        }
                        
                    }
                }
            }
            if(is_array($createable) && count($createable) > 0){
                foreach($createable as $md){
                    $exists = ModuleDefaults::where('module_id', $module_id)->where('role_id',$md['role_id'])->exists();
                    if($exists){
                        $c = ModuleDefaults::where('module_id', $module_id)->where('role_id',$md['role_id'])
                        ->update([
                            'create' => $md['create'],
                            'read' => $md['read'],
                            'update' => $md['update'],
                            'delete' => $md['delete'],
                        ]);
                    }else{
                        if($md['create'] == 0 && $md['read'] == 0 && $md['update'] == 0 && $md['delete'] == 0){
                            continue;
                        }else{
                            $m = ModuleDefaults::create([
                                'module_id' => $module_id,
                                'role_id' => $md['role_id'],
                                'create' => $md['create'],
                                'read' => $md['read'],
                                'update' => $md['update'],
                                'delete' => $md['delete'],
                            ]);
                        }
                    }
                    
                    $users = User::where('role_id',$md['role_id'])->get();
                    foreach($users as $u){
                        $rm_exists = RoleModules::where('module_id', $module_id)->where('user_id',$u->id)->exists();
                        if($rm_exists){
                            $r = RoleModules::where('module_id', $module_id)->where('user_id',$u->id)
                            ->update([
                                'create' => $md['create'],
                                'read' => $md['read'],
                                'update' => $md['update'],
                                'delete' => $md['delete'],
                            ]);
                        }else{
                            if($md['create'] == 0 && $md['read'] == 0 && $md['update'] == 0 && $md['delete']){
                                continue;
                            }else{
                                $r = RoleModules::create([
                                    'user_id' => $u->id,
                                    'module_id' => $module_id,
                                    'create' => $md['create'],
                                    'read' => $md['read'],
                                    'update' => $md['update'],
                                    'delete' => $md['delete'],
                                ]);
                            }
                        }
                    }
                    
                }
            }
            $res = ['success'=>'success','message'=>'Module successfully created'];
            
            return response()->json($res);
        }
    }
}
