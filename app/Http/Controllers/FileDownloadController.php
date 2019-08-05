<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use File;
use App\Models\User;
class FileDownloadController extends Controller
{
    
    
    public function viewFiledownload(Request $request){
        $filetype = strtolower($request->filetype);

        $files = DB::table('tbl_files as file')
                ->select('file.*',
                         DB::Raw('CONCAT(user.first_name, " ", user.last_name) as name'))
                ->join('users as user', 'user.id', '=', 'file.uploadedby');
                
        if (!empty($filetype)) {

            $files = $files->where('file.filetype', $filetype);
        }

        $files = $files->orderBy('file.created_at', 'desc')
                       ->get();
        
        return view('pages.viewfiledownload')->with(['files' => $files ]);
    }
    public function viewaddfiledownload(){
        return view('503.blade.php');
        //return view('pages.addfile')
    }
    public function deletFile($id){

        $filename = DB::table('tbl_files')->where('id',$id)->first();
        $fileurl = public_path('fileuploads/drrmfiles');

        File:: delete($fileurl.'/'.$filename->file);

        $i = DB::table('tbl_files')->where('id',$id)->delete();
            if($i > 0){
                \Session::flash('message', 'Report successfully deleted');
                return back();
            }
    }

    public function saveFile(Request $request){

        $post = $request->all();
        $cntUser = Auth::user();
       
        $rules = [
            'fileToUpload' => 'required|mimes:txt,pdf,docx,pptx,xlsx,rar,kml,jpg',
        ];
        $rules = [];
        $v = \Validator::make($request->all(), $rules);

        if($v->fails()){
            return redirect()->back()->witherrors($v->errors());    
        }else{
            $file = $request->file('fileUploadName');
            $filename = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $originalNameWithout = substr($filename, 0, strlen($filename) - strlen($fileExtension) - 1);
            $nospaceFilename = str_replace(' ', '', $originalNameWithout);
            $fileurl = 'fileuploads/drrmfiles/'. $nospaceFilename. '.'.$fileExtension;
            $countname = DB::table('tbl_files')->where('original_name', '=', $nospaceFilename)->count();
            
            
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


            $file->move(public_path('fileuploads/drrmfiles'), $fname);

            $row = array(
                'uploadedby' => $cntUser->id,
                'filename' => $post['filename'],
                'original_name' => $nospaceFilename,
                'fileurl' => $fileurl,
                'file' => $fname,
                'filetype' => $fileExtension,
            );

            $i = DB::table('tbl_files')->insert($row);
                if($i > 0){
                    \Session::flash('message', 'File successfully uploaded');
                    return back();
                }
                return back();
        }


    }
    
}
