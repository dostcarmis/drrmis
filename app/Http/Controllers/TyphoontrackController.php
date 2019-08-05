<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use Auth;
use App\Models\Typhoon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;

class TyphoontrackController extends Controller
{
    public function viewTyphoonTracks(){
		$typhoontracks = DB::table('tbl_typhoontracks')->get();
		$typhoonstatus = DB::table('tbl_typhoonstat')->where('id',1)->first();
		return view('pages.viewtyphoontracks',compact('typhoonstatus', $typhoonstatus))->with(['typhoontracks' => $typhoontracks]);
   }
   public function viewaddTyphoonTracks(){
		$typhoontracks = DB::table('tbl_typhoontracks')->get();
		return view('pages.addtyphoontrack')->with(['typhoontracks' => $typhoontracks]);
   }
   public function editTyphoonTracks($id){
		$typhoontracks = DB::table('tbl_typhoontracks')->where('id',$id)->first();
		return view('pages.edittyphoontrack')->with(['typhoontracks' => $typhoontracks]);
   }
   public function updateTyphoonTrack(Request $request){
		$cntUser = Auth::user();
		$post = $request->all();
		$rules = [
			'name' => 'required',
		];
		$messages = [
			'name.required' => 'Title is required',
		];
		
		
			
		$v = \Validator::make($request->all(), $rules, $messages);

		if($v->fails()){

			return redirect()->back()->withErrors($v->errors());

		}else{
			$row = array(
				'typhoonstat' => $post['typhoonstat'],
				'typhoonName' => $post['name'],
				'typhoonpath' => $post['typhoon'],	
				'uploadedby' => $cntUser->id,
			);
		
			$i = DB::table('tbl_typhoontracks')->where('id',$post['id'])->update($row);
			if($i > 0){
				\Session::flash('message', 'Typhoon Track successfully updated');
				return redirect('viewtyphoontracks');
			}
		}   
    }
    public function status(Request $request){
    	$post = $request->all();
    	if(isset($post['typhoonstatus'])){    		
    		$row = array(
				'typhoonstat' => 1,				
			);
    		DB::table('tbl_typhoonstat')->where('id',1)->update($row);				
			return redirect('viewtyphoontracks');
			
    	}else{
    		$row = array(
				'typhoonstat' => 0,				
			);
    		DB::table('tbl_typhoonstat')->where('id',1)->update($row);				
			return redirect('viewtyphoontracks');
    	}
    }
    public function saveTyphoonTrack(Request $request){
		$cntUser = Auth::user();
		$post = $request->all();
		$rules = [
			'name' => 'required',
		];
		$messages = [
			'name.required' => 'Title is required',
		];
		
		
			
		$v = \Validator::make($request->all(), $rules, $messages);

		if($v->fails()){

			return redirect()->back()->withErrors($v->errors());

		}else{
			$row = array(
				'typhoonstat' => $post['typhoonstat'],
				'typhoonName' => $post['name'],
				'typhoonpath' => $post['typhoon'],	
				'uploadedby' => $cntUser->id,
			);
		
			$i = DB::table('tbl_typhoontracks')->insert($row);
			if($i > 0){
				\Session::flash('message', 'Typhoon Track successfully added');
				return redirect('viewtyphoontracks');
			}
		}   
    }
    public function destroymultipleTyphoons(Request $request){
      Typhoon::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Typhoon successfully deleted.';
      }else{
         $delmsg = $chk .' typhoons successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function destroyTyphoon($id){
       $i = DB::table('tbl_typhoontracks')->where('id',$id)->delete();
    if($i > 0)
	{
		\Session::flash('message', 'Typhoon successfully deleted');
		return redirect('viewtyphoontracks');
	}
   }
}
