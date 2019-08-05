<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Auth;
use File;
class ResponseController extends Controller
{
    public function viewResponse(){
    	$response = DB::table('tbl_response')->orderBy('created_at', 'desc')->get();
    	return view('pages.viewresponse')->with(['response' => $response]);
    }
    public function deletResponse($id){

    	$filename = DB::table('tbl_response')->where('id',$id)->first();
      
        
        $fileurl = public_path('fileuploads/response'); 

        File::delete($fileurl.'/'.$filename->file);

        $i = DB::table('tbl_response')->where('id',$id)->delete();
           if($i > 0)
          {          	
            \Session::flash('message', 'Report successfully deleted');
            return redirect('response');
          }
    }
    public function saveResponse(Request $request){

            $post = $request->all();
        	$cntUser = Auth::user();
            $rules = [
                'fileToUpload' => 'required|mimes:txt,pdf,docx,pptx,xlsx',
            ];

            $v = \Validator::make($request->all(), $rules);

            if($v->fails()){
               return redirect()->back()->withErrors($v->errors());
            }else{
                $fileurl = asset('fileuploads/response');

                $file = $request->file('fileToUpload');

                $fileName = $file->getClientOriginalName();

                $fileExtension = $file->getClientOriginalExtension(); 

                $originalNameWithoutExt = substr($fileName, 0, strlen($fileName) - strlen($fileExtension) - 1);

                $nospaceFilename = str_replace(' ', '', $originalNameWithoutExt);

                $countname = DB::table('tbl_response')
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
                $file->move(public_path('fileuploads/response'),$fname);

                //save to database
                $row = array(
                        'uploadedby' => $cntUser->id,
                        'filename' => $post['filename'],
                        'original_name' => $nospaceFilename,
                        'fileurl' => $fileurl,
                        'file' => $fname,
                        'filetype' => $fileExtension,
                    );

                $i = DB::table('tbl_response')->insert($row);
                if($i > 0){
                    \Session::flash('message', 'Report successfully uploaded');
                    return redirect('response');
                }
                return redirect('response');
            }      
    }
}
