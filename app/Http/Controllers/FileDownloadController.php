<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use App\Models\User;
use File;

class FileDownloadController extends Controller
{
    public function viewFiledownload(Request $request){
        $filetype = strtolower($request->filetype);
        $filename = strtolower($request->filename);
        $files = DB::table('tbl_files as file')
                ->select('file.*',
                         DB::Raw('CONCAT(user.first_name, " ", user.last_name) as name'))
                ->join('users as user', 'user.id', '=', 'file.uploadedby');
                
        if (!empty($filetype)) {

            $files = $files->where('file.filetype', $filetype);
        }
        if (!empty($filename)){
            $files = $files->where('file.filename','like', '%'.$filename.'%');
        }

        $files = $files->orderBy('file.created_at', 'desc')
                       ->get();
        
        return view('pages.viewfiledownload')->with(['files' => $files ]);
    }
    
    public function deleteFile(Request $request, $id){
        $cntUser = Auth::user();
        $msg = "";
        $filename = DB::table('tbl_files')->where('id',$id)->first();
        $fileurl = public_path('fileuploads/drrmfiles');

        File:: delete($fileurl.'/'.$filename->file);

        $i = DB::table('tbl_files')->where('id',$id)->delete();
            if($i > 0){
                //$fullName = $cntUser->getFullname();
                $cntUser->activityLogs($request, $msg = "Deleted a DRRM file-$filename->filename");
                \Session::flash('success_delete', 'Report successfully deleted');
                return back();
            }
    }

    public function saveFile(Request $request){

        $msg = "";
        $post = $request->all();
        $cntUser = Auth::user();
       
        $rules = [
            'fileToUpload' => 'required|mimes:txt,pdf,docx,pptx,xlsx,rar,kml,jpeg,jpg',
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
                    //$fullName = $cntUser->getFullname();
                    $cntUser->activityLogs($request, $msg = "Added a DRRM file-$fileToDisplay");
                    \Session::flash('success_upload', 'File successfully uploaded');
                    return redirect('filedownloadpage');
                }
                return redirect('filedownloadpage');
        }


    }
    
}
