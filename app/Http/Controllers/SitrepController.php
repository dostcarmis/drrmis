<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
// use Auth;
use Illuminate\Support\Facades\Auth;
use File;
use App\User;
use App\Sitrep;
use App\Role;

class SitrepController extends Controller
{
    public function viewallsitreps(Request $request){
        if($request->has('sitrep_level')){
            $this->validate($request,[
                'sitrep_level'=>'required|string',
                // 'val'=>'required|string'
            ]);
            $sitrep_level = strtolower(trim($request->input('sitrep_level')));
            $val = strtolower(trim(strip_tags($request->input('val'))));
            $user = Auth::user();
            $role = $user->role_id;
            if($sitrep_level != "provincial" && $sitrep_level != "regional" && $sitrep_level != "all" && $sitrep_level != "municipal"){
                return response()->json(["success"=>false,"msg"=>"Invalid Level: ".$sitrep_level]);
            // }else if($val == ""){
            //     return response()->json(["success"=>false]);
            }else{
                $files = Sitrep::where("filename","like","%".$val."%");
                if($sitrep_level != "all" && $sitrep_level != null)
                    $files = $files->where("sitrep_level","like",$sitrep_level);
                $filtered = [];
                if(strtolower($sitrep_level) != 'regional'){
                    if($role == 3){ // provincial
                        $province = $user->province_id;
                        $filtered = [];
                        $sitreps = $files->orderBy('created_at','desc')->get();
                        
                        foreach($sitreps as $sit){
                            $uploader_province = $sit->uploader->province_id;
                            if($uploader_province == $province ){
                                $sit->name = $sit->uploader->first_name." ".$sit->uploader->last_name;
                                $filtered[] = $sit;
                                continue;
                            }
                        }
                    }else if($role == 4){ //municipal
                        $municipality = $user->municipality_id;
                        $filtered = [];
                        $sitreps = $files->orderBy('created_at','desc')->get();
                        foreach($sitreps as $sit){
                            $uploader_municipality = $sit->uploader->municipality_id;
                            if($uploader_municipality == $municipality){
                                $sit->name = $sit->uploader->first_name." ".$sit->uploader->last_name;  
                                $filtered[] = $sit;
                                continue;
                            }
                        }
                    }else if($role == 1 || $role == 2){
                        $filtered = $files->orderBy('created_at','desc')->get();
                    }
                }else{
                    if($role <=4){
                        $filtered = $files->orderBy('created_at','desc')->get();
                    }else{
                        $filtered= [];
                    }
                    
                }
                
                $count = count($filtered);
                if($count > 0){
                    return view('pages.viewsitreps_filtered',compact('filtered'));
                }else{
                    return response()->json(['success'=>true,"msg"=>"No matches found."]);
                }
            }
        }else{
            return $this->mainviewsitreps('all');
        }
    }

    public function deleteSitrep($id){
        $fileName = DB::table('tbl_sitreps')->where('id', $id)->first();
        $fileUrl = public_path('fileuploads/sitreps');

        File:: delete($fileUrl.'/'.$fileName->file);

        $i = DB::table('tbl_sitreps')->where('id',$id)->delete();
            if($i > 0){
                \Session::flash('success_delete', 'Report successfully deleted');
                return back();
            }
    }
    
    public function mainviewsitreps(Request $request){
        $sitrep_level = $request->input('sitrep_level');
        $user = Auth::user();
        $role = $user->role_id;
        $sitreps = Sitrep::where('sitrep_level',$sitrep_level)->orderBy('created_at','desc')->get();
        if(strtolower($sitrep_level) == 'all' || strtolower($sitrep_level) == '' || !isset($sitrep_level)){
            $sitreps = Sitrep::orderBy('created_at','desc')->get();
        }
        if($user->hasAccess(2,'read')){

        
            $filtered = [];
            if(strtolower($sitrep_level) != 'regional'){
                
                if($role == 3){ // provincial
                    $province = $user->province_id;
                    
                    foreach($sitreps as $sit){
                        $uploader_province = $sit->uploader->province_id;
                        if($uploader_province == $province && strtolower($sit->sitrep_level) != 'regional'){
                            $sit->name = $sit->uploader->first_name." ".$sit->uploader->last_name;
                            $filtered[] = $sit;
                            continue;
                        }
                        if(strtolower($sitrep_level) == 'all' && strtolower($sit->sitrep_level) == 'regional'){
                            $sit->name = $sit->uploader->first_name." ".$sit->uploader->last_name;  
                            $filtered[] = $sit;
                            continue;
                        }
                    }
                }else if($role == 4){ //municipal
                    $municipality = $user->municipality_id;
                    
                    foreach($sitreps as $sit){
                        $uploader_municipality = $sit->uploader->municipality_id;
                        $ins[] = [$uploader_municipality,$municipality];
                        if(strtolower($sit->sitrep_level) == 'provincial'){
                            $uploader_province = $sit->uploader->province_id;
                            $province = $user->province_id;
                            if($uploader_province == $province){
                                $sit->name = $sit->uploader->first_name." ".$sit->uploader->last_name;  
                                $filtered[] = $sit;
                            }
                            continue;}
                        
                        if($uploader_municipality == $municipality && strtolower($sit->sitrep_level) == 'municipal'){
                            $sit->name = $sit->uploader->first_name." ".$sit->uploader->last_name;  
                            $filtered[] = $sit;
                            continue;
                        }
                        if(strtolower($sitrep_level) == 'all' && strtolower($sit->sitrep_level) == 'regional'){
                            $sit->name = $sit->uploader->first_name." ".$sit->uploader->last_name;  
                            $filtered[] = $sit;
                            continue;
                        }
                    }
                    
                }else if($role == 1 || $role == 2){
                    $filtered = $sitreps;
                }
            }else{
                if($role <=4){
                    $filtered = $filtered = $sitreps;
                }else{
                    $filtered= [];
                }
                
                
            }
            


            
            return view('pages.viewsitreps')->with(['sitrep' => $filtered]);
        }
    }
    

    public function savesitrepfile(Request $request){

        $post = $request->all();
        $cntUser = Auth::user();
        $userRole = $cntUser->role_id;
        $roleData = Role::find($userRole);
        //$username = $cntUser->first_name;
       //$namedata = User::find($username);
       

        $rules = [
            'sitreptoupload' => 'required|mimes:pdf,docx,jpg', 
        ];
        $rules = [];
        $validate = \Validator::make($request->all(), $rules);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors());
        }else{
            $file = $request->file('sitreptoupload');
            $filename = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $originalNameNoExtension = substr($filename, 0, strlen($filename) - strlen($fileExtension) - 1);
            $nospaceFilename = str_replace(' ', '', $originalNameNoExtension);
            $fileurl = 'fileuploads/sitreps/'. $nospaceFilename. '.'.$fileExtension;
            $countname = DB::table('tbl_sitreps')->where('original_name', '=', $nospaceFilename)->count();

            $fname = '';
            $origName = '';

            if($countname > 0){
                $fname = $nospaceFilename.'-'.$countname.'.'.$fileExtension;
                $origName = $nospaceFilename.'-'.$countname;
            }else{
                $fname = $nospaceFilename.'.'.$fileExtension;
                $origName = $nospaceFilename;
            }
            $fileToDisplay = '';

            if($post['filename'] == ''){
                $fileToDisplay = $fname;
            }else{
                $fileToDisplay = $post['filename'];
            }

            $file->move(public_path('fileuploads/sitreps'), $fname);
            $post['typhoon_name'] = !empty($post['typhoon_name']) ? $post['typhoon_name'] : NULL;
            $post['magnitude'] = !empty($post['magnitude']) ? $post['magnitude'] : NULL;
          
            if($userRole <= 2){
                $row = array(
                    'uploadedby' => $cntUser->id,
                    'filename' => $post['filename'],
                    'risk_type' => $post['risk'],
                    'typhoon_name' => $post['typhoon_name'],
                    'magnitude' => $post['magnitude'],
                    'sitrep_level' => 'Regional',
                    'original_name' => $nospaceFilename,
                    'fileurl' => $fileurl,
                    'file' => $fname,
                    'filetype' => $fileExtension,
                );
            }else{
                $row = array(
                    'uploadedby' => $cntUser->id,
                    'filename' => $post['filename'],
                    'risk_type' => $post['risk'],
                    'typhoon_name' => $post['typhoon_name'],
                    'magnitude' => $post['magnitude'],
                    'sitrep_level' => 'Provincial',
                    'original_name' => $nospaceFilename,
                    'fileurl' => $fileurl,
                    'file' => $fname,
                    'filetype' => $fileExtension,
                );
                
            }
            
            $i = DB::table('tbl_sitreps')->insert($row);
                if($i > 0){
                    \Session::flash('success_upload', 'File successfully uploaded');
                    return back();
                }
                return back();
            
        }
    }
}
