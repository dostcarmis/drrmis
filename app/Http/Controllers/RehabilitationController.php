<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use File;
class RehabilitationController extends Controller
{
    public function viewRehabilitation(){
        $rehabilitation = DB::table('tbl_rehabilitation')->orderBy('created_at', 'desc')->get();
    	return view('pages.viewrehabilitation')->with(['rehabilitation' => $rehabilitation ]);
    }
    public function viewaddRehabilitation(){
    	return view('pages.addrehabilitation');
    }
    public function deleteRehab($id){

        $filename = DB::table('tbl_rehabilitation')->where('id',$id)->first();
        $fileurl = public_path('fileuploads/rehabilitation'); 
        
        File::delete($fileurl.'/'.$filename->file);

        $i = DB::table('tbl_rehabilitation')->where('id',$id)->delete();
           if($i > 0)
          {
             \Session::flash('message', 'Report successfully deleted');
             return redirect('rehabilitationnrecovery');
          }
    }
    public function saveRehabilitation(Request $request){

            $post = $request->all();

        	$cntUser = Auth::user();

            $rules = [
                'fileToUpload' => 'required|mimes:txt,pdf,docx,pptx,xlsx',
            ];

            $v = \Validator::make($request->all(), $rules);

            if($v->fails()){
                // return response()->json(["somethingwrong"=>true]);
                return redirect()->back()->withErrors($v->errors());
            }else{
                $fileurl = asset('fileuploads/rehabilitation');

                $file = $request->file('fileToUpload');

                $fileName = $file->getClientOriginalName();

                $fileExtension = $file->getClientOriginalExtension(); 

                $originalNameWithoutExt = substr($fileName, 0, strlen($fileName) - strlen($fileExtension) - 1);

                $nospaceFilename = str_replace(' ', '', $originalNameWithoutExt);

                $countname = DB::table('tbl_rehabilitation')
                        ->where('original_name', '=', $nospaceFilename)
                        ->count();

                $fname = '';
                $oRigName = '';

                if($countname > 0){
                    $fname = $nospaceFilename.'-'.$countname.'.'.$fileExtension;     
                    $oRigName = $nospaceFilename.'-'.$countname;
                }else{
                    $fname = $nospaceFilename.'.'.$fileExtension;   
                    $oRigName = $nospaceFilename;
                }
                $fileToDisplay = '';

                if($post['filename'] == ''){
                    $fileToDisplay = $fname;
                }else{
                    $fileToDisplay = $post['filename'];
                }

                //move to folders
                $file->move(public_path('fileuploads/rehabilitation'),$fname);

                //save to database
                $row = array(
                        'uploadedby' => $cntUser->id,
                        'filename' => $post['filename'],
                        'original_name' => $nospaceFilename,
                        'fileurl' => $fileurl,
                        'file' => $fname,
                        'filetype' => $fileExtension,
                    );

                $i = DB::table('tbl_rehabilitation')->insert($row);
                if($i > 0){
                    \Session::flash('message', 'Report successfully uploaded');
                    return redirect('rehabilitationnrecovery');
                    // return response()->json(["message"=>'Report successfully uploaded']);
                }
                return redirect('rehabilitationnrecovery');
            }      
    }
    /* public function saveRehabilitation(Request $request){
        return response()->json(["req"=>$request]);
    } */
}
