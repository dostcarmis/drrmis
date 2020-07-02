<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use File;
use App\Models\User;
use App\Role;

class SitrepController extends Controller
{
    public function viewallsitreps(){
        $sitreps = DB::table('tbl_sitreps as sitrep')
            ->select('sitrep.*',
                    DB::raw('CONCAT(user.first_name, " ", user.last_name) as name'))
            ->join('users as user', 'user.id', '=', 'sitrep.uploadedby')
            ->orderBy('sitrep.created_at', 'desc')
            ->get();
        return view('pages.viewsitreps')->with(['sitrep' => $sitreps]);
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
    
    public function mainviewsitreps($sitrep_level){
        $sitreps = DB::table('tbl_sitreps as sitrep')
                ->select('sitrep.*',
                        DB::raw('CONCAT(user.first_name, " ", user.last_name) as name'))
                ->join('users as user', 'user.id', '=', 'sitrep.uploadedby')
                ->where('sitrep.sitrep_level', $sitrep_level)
                ->orderBy('sitrep.created_at', 'desc')
                ->get();
        
        return view('pages.viewsitreps')->with(['sitrep' => $sitreps]);
      
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
           
          
            if($userRole <= 2){
                $row = array(
                    'uploadedby' => $cntUser->id,
                    'filename' => $post['filename'],
                    'risk_type' => $post['risk'],
                    'typhoon_name' => $post['typhoon_name'],
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
                    return redirect('sitreps');
                }
                return redirect('sitreps');
            
        }
    }
}
