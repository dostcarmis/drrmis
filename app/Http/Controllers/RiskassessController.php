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
use App\Riskassess;

class RiskassessController extends Controller
{
    public function mainView(){
            $munici = Municipality::where('province_id',Auth::user()->province_id)->orderBy('name','asc')->get();
            return view('pages.mainviewriskassessfiles',compact('munici'));

    }
    
    public function viewFiles($province_id,$municipal_id){
        if(is_numeric($province_id) && Auth::user()->hasAccess(5)){
            $role =  Auth::user()->role_id;
            $upid = Auth::user()->province_id;
            
            $municipalities = Municipality::orderBy('name','asc')->get();
            $riskfiles = Riskassess::where('province_id',$province_id);
            if($role > 3){
                $muni = Auth::user()->municipality_id;
                $riskfiles = Riskassess::where('municipality_id',$muni);
            }else if($role <= 3 ){
                if($municipal_id != 'all'){
                    $riskfiles = $riskfiles->where('municipality_id',$municipal_id);
                }
                
                if($role < 3){
                    $riskfiles = $riskfiles->where('province_id',$province_id);
                }else{
                    $riskfiles = $riskfiles->where('province_id',Auth::user()->province_id);
                }
            }else{

            }

            
            $riskfiles = $riskfiles->orderBy('created_at', 'desc')->get();
            
            
            return view('pages.viewriskassesfiles',compact('riskfiles','municipalities'));
        }else{
            return response()->json(['success'=>'danger','message'=>"Access denied"]);
        }
    }


    public function viewaddRiskfiles(){
        return view('pages.addriskfile',compact('municipalities'));
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
            $municipality = Municipality::find($post['municipality']);
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
                    'municipality_id'=>$post['municipality'],
                    'province_id'=>$municipality->province->id,
                    'date'=>$post['date']
            );
            if($cntUser->role_id <= 3){
                if($request->has('municipality') && $request->input('municipality') != null && $request->input('municipality') != "0"){
                    $muni = $request->input('municipality');
                    $munis = Municipality::where('id',$muni)->get()->first();
                    if(
                        (empty($munis) || $munis == null) ||
                        ($munis->province_id != $provincedata->id)
                    ){
                        return back()->with('message','Invalid municipality');
                    }else{
                        $row['municipality'] = $municipality->name;
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
