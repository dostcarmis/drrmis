<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\Municipality;
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
        $role =  Auth::user()->role_id;

        if($role > 2){
            if(strtolower($province) != strtolower(Auth::user()->province->name)){
                return back();
            }
        }
        $riskfiles = DB::table('tbl_riskassessfiles as risk') 
                    ->select('risk.*',
                        DB::raw('CONCAT(user.first_name, " ", user.last_name) as name'))
                    ->join('users as user', 'user.id', '=', 'risk.uploadedby')
                    ->where('risk.province', 'LIKE', '%'.$province.'%');
        if($role == 4){
            $muni = Auth::user()->municipality->name;
            $riskfiles = $riskfiles->where('risk.municipality','LIKE','%'.$muni.'%');
        }
        $riskfiles = $riskfiles->orderBy('risk.created_at', 'desc')->get();
        $return = ['riskfile' => $riskfiles];
        if($role <= 3){
            $municipalities = Municipality::where('province_id',Auth::user()->province_id)->get();
            $return['municipalities'] = $municipalities;
        }
        return view('pages.viewriskassesfiles')->with($return);
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
            'date'=>'required|before:today'
        ];
        if($cntUser->role_id <= 3){
            $rules['municipality']= 'required';
        }

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
                    'municipality'=>'',
                    'date'=>$post['date']
            );
            if($cntUser->role_id <= 3){
                if($request->has('municipality') && $request->input('municipality') != null && $request->input('municipality') != "0"){
                    $muni = $request->input('municipality');
                    $munis = Municipality::where('name','LIKE','%'.$muni.'%')->get()->first();
                    // return back()->with('message',($munis->province_id." ".$provincedata->id));
                    if(
                        (empty($munis) || $munis == null) ||
                        ($munis->province_id != $provincedata->id)
                    ){
                        return back()->with('message','Invalid municipality');
                    }else{
                        $row['municipality'] = $muni;
                    }
                    
                }else{
                    return back()->with('message', 'Please select a municipality');
                }
            }else{
                $row['municipality'] = Auth::user()->municipality->name;
            }
            $i = DB::table('tbl_riskassessfiles')->insert($row);
            if($i > 0){
                return back()->with('message', 'File successfully uploaded under your province of '. $provincedata->name);
            }
            return back();
        }    
    }
}
