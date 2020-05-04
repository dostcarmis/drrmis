<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use File;
use  App\Models\Province;
use App\Models\User;

class RiskassessController extends Controller
{
    public function mainView(){
        return view('pages.mainviewriskassessfiles');

    }
    
    public function viewFiles($province){
        $riskfiles = DB::table('tbl_riskassessfiles as risk') 
                    ->select('risk.*',
                             DB::raw('CONCAT(user.first_name, " ", user.last_name) as name'))
                    ->join('users as user', 'user.id', '=', 'risk.uploadedby')
                    ->where('risk.province', 'LIKE', '%'.$province.'%')
                    ->orderBy('risk.created_at', 'desc')
                    ->get();
        return view('pages.viewriskassesfiles')->with(['riskfile' => $riskfiles]);
    }

    public function viewaddRiskfiles(){

        return view('pages.addriskfile');
    }
    
    public function deleteRiskfile($id){

        $filename = DB::table('tbl_riskassessfiles')->where('id',$id)->first();
        $fileurl = public_path('fileuploads/riskassessments');

        File::delete($fileurl.'/'.$filename->file);
        
        $i = DB::table('tbl_riskassessfiles')->where('id',$id)->delete();
            if($i > 0)
            {
            \Session::flash('message','Report Successfully deleted');
            return back();
            }
    }

    public function saveRiskassess(Request $request){

        $post = $request->all();
        $cntUser = Auth::user();
        $userProv = $cntUser->province_id;
        $provincedata = Province::find($userProv);
       
        $rules = [
            'fileUploadName' => 'required|mimes:pdf',
        ];

        $validate = \Validator::make($request->all(), $rules);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors());
        }else{
            $file = $request->file('fileUploadName');
            $filename = $file->getClientOriginalName();
            $fileExtension = $file->getClientOriginalExtension();
            $originalNameNoExtension = substr($filename, 0, strlen($filename) - strlen($fileExtension) - 1);
            $nospaceFilename = str_replace(' ', '', $originalNameNoExtension);
            $fileurl = 'fileuploads/riskassessments/'. $nospaceFilename. '.'. $fileExtension;
            $countname = DB::table('tbl_riskassessfiles')->where('original_name', '=', $nospaceFilename)->count(); 

            $fname = '';
            $origName = '';

            if($countname > 0){
                $fname = $nospaceFilename.'-'.$countname.'.'.$fileExtension;
                $origName = $nospaceFilename;
            }else{
                $fname = $nospaceFilename.'.'.$fileExtension;
                $origName = $nospaceFilename;
            }
            $fileTodisplay = '';
            
            if($post['filename'] == ''){
                $fileTodisplay = $fname;
            }else{
                $fileTodisplay = $post['filename'];
            }
           
            $file->move(public_path('fileuploads/riskassessments'),$fname);
            
            
            $row = array(
                    
                    'uploadedby' => $cntUser->id,
                    'filename' => $post['filename'],
                    'original_name' => $nospaceFilename,
                    'province' => $provincedata->name,
                    'fileurl' => $fileurl,
                    'file' => $fname,
                    'filetype' => $fileExtension,
            );

            $i = DB::table('tbl_riskassessfiles')->insert($row);
            if($i > 0){
                return back()->with('message', 'File successfully uploaded under your province of '. $provincedata->name);
            }
            return back();
        }    
    }
}
