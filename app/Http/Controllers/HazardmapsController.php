<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Models\HazardMaps;
use DB;
use Auth;
class HazardmapsController extends Controller
{
	function __construct()
   {
      $this->middleware('auth');
   }
    public function viewHazardmaps(){
    	$cntUser = Auth::user(); 
    	$municipalities = DB::table('tbl_municipality')->get();
		$users = DB::table('users')->get();
		$provinces = DB::table('tbl_provinces')->get();
		if(($cntUser->role_id == 1) || ($cntUser->role_id == 2)){
        	$hazardmaps = DB::table('tbl_hazardmaps')->orderBy('created_at', 'desc')->get();
		}elseif(($cntUser->role_id == 3) || ($cntUser->role_id == 4)){
			$hazardmaps = DB::table('tbl_hazardmaps')->where('uploadedby','=',$cntUser->id)->orderBy('created_at', 'desc')->get();
		} 	
		
    	return view('pages.viewhazardmaps')->with(['hazardmaps' => $hazardmaps,'municipalities' => $municipalities, 'users' => $users,'provinces'=>$provinces]);
    }
    public function addHazardmap(){
    	$municipalities = DB::table('tbl_municipality')->get();
		$users = DB::table('users')->get();
		$provinces = DB::table('tbl_provinces')->get();
		$hazardmaps = DB::table('tbl_hazardmaps')->get();
    	return view('pages.addhazardmap')->with(['hazardmaps' => $hazardmaps,'municipalities' => $municipalities, 'users' => $users,'provinces'=>$provinces]);
    }
    public function editHazardmap($id){
    	$municipalities = DB::table('tbl_municipality')->get();
		$users = DB::table('users')->get();
		$provinces = DB::table('tbl_provinces')->get();
    	$hazardmaps = DB::table('tbl_hazardmaps')->where('id',$id)->first();
    	return view('pages.edithazardmap')->with(['hazardmaps' => $hazardmaps,'municipalities' => $municipalities, 'users' => $users,'provinces'=>$provinces]);
    }
    public function saveHazardmap(Request $request){
		$cntUser = Auth::user();
		$post = $request->all();

		if($post['overlaytype'] == 'kmlfile'){
			$rules = [
				'name' => 'required',
			];
			$messages = [
				'name.required' => 'Title is required',
			];
		}else{
			$rules = [
				'name' => 'required',
				'north' => 'required',
				'south' => 'required',
				'east' => 'required',
				'west' => 'required',

			];
			$messages = [
				'name.required' => 'Title is required',
				'north.required' => 'North Coordinate is required',
				'south.required' => 'South Coordinate is required',
				'east.required' => 'East Coordinate is required',
				'west.required' => 'West Coordinate is required',
			];
		}
			
		$v = \Validator::make($request->all(), $rules, $messages);

		if($v->fails()){

			return redirect()->back()->withErrors($v->errors());

		}else{
			$row = array();
			if($post['overlaytype'] == 'kmlfile'){
				$row = array(
					'name' => $post['name'],
					'status' => $post['hazardstatus'],
					'province_id' => $post['province_id'],
					'municipality_id' => $post['municipality_id'],					
					'uploadedby' => $cntUser->id,
					'hazardmap' => $post['kmlfile'],
					'category_id' => $post['hazardcategory'],
					'overlaytype' => 'kmlfile',
					'north' => '',
					'south' => '',					
					'east' => '',
					'west' => '',

				);
			}else{
				$row = array(
					'name' => $post['name'],
					'status' => $post['hazardstatus'],
					'province_id' => $post['province_id'],
					'municipality_id' => $post['municipality_id'],					
					'uploadedby' => $cntUser->id,
					'hazardmap' => $post['kmlimagefile'],
					'north' => $post['north'],
					'south' => $post['south'],					
					'east' => $post['east'],
					'west' => $post['west'],
					'category_id' => $post['hazardcategory'],
					'overlaytype' => 'imagetype',
				);
			}			
			$i = DB::table('tbl_hazardmaps')->insert($row);
			if($i > 0){
				\Session::flash('message', 'Hazard Map successfully added');
				return redirect('viewhazardmaps');
			}
		}   
    }
    public function updateHazardmap(Request $request)
   	{
   	$cntUser = Auth::user();
   	$post = $request->all();

	if($post['overlaytype'] == 'kmlfile'){
			$rules = [
				'name' => 'required',
			];
			$messages = [
				'name.required' => 'Title is required',
			];
		}else{
			$rules = [
				'name' => 'required',
				'north' => 'required',
				'south' => 'required',
				'east' => 'required',
				'west' => 'required',

			];
			$messages = [
				'name.required' => 'Title is required',
				'north.required' => 'North Coordinate is required',
				'south.required' => 'South Coordinate is required',
				'east.required' => 'East Coordinate is required',
				'west.required' => 'West Coordinate is required',
			];
		}
	$v = \Validator::make($request->all(), $rules, $messages);

      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
      	$row = array();
			if($post['overlaytype'] == 'kmlfile'){
				$row = array(
					'name' => $post['name'],
					'status' => $post['hazardstatus'],
					'province_id' => $post['province_idedit'],
					'municipality_id' => $post['municipality_idedit'],					
					'uploadedby' => $cntUser->id,
					'hazardmap' => $post['kmlfile'],
					'category_id' => $post['hazardcategory'],
					'overlaytype' => 'kmlfile',
					'north' => '',
					'south' => '',					
					'east' => '',
					'west' => '',

				);
			}else{
				$row = array(
					'name' => $post['name'],
					'status' => $post['hazardstatus'],
					'province_id' => $post['province_idedit'],
					'municipality_id' => $post['municipality_idedit'],					
					'uploadedby' => $cntUser->id,
					'hazardmap' => $post['kmlimagefile'],
					'north' => $post['north'],
					'south' => $post['south'],					
					'east' => $post['east'],
					'west' => $post['west'],
					'category_id' => $post['hazardcategory'],
					'overlaytype' => 'imagetype',
				);
			}

	 $i = DB::table('tbl_hazardmaps')->where('id',$post['id'])->update($row);
		if($i > 0){
			\Session::flash('message', 'Hazard Map successfully updated');
			return redirect('viewhazardmaps');
		}
      }
   }
    public function destroymultipleHazardmaps(Request $request){
      HazardMaps::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Hazardmap successfully deleted.';
      }else{
         $delmsg = $chk .' hazardmaps successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function destroyHazardmap($id){
       $i = DB::table('tbl_hazardmaps')->where('id',$id)->delete();
    if($i > 0)
	{
		\Session::flash('message', 'Hazardmap successfully deleted');
		return redirect('viewhazardmaps');
	}
   }
}
