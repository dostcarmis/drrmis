<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Floodproneareas;
use App\Http\Requests;
use DB;
use Auth;
class FloodproneareasController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function viewFloodproneAreas(){
    	$municipalities = DB::table('tbl_municipality')->get();
    	$provinces = DB::table('tbl_provinces')->get();
    	$floodproneareas = DB::table('tbl_floodprone_areas')->orderBy('created_at', 'desc')->get();
    	return view('pages.viewfloodproneareas')->with(['municipalities' => $municipalities,'provinces' => $provinces,'floodproneareas' => $floodproneareas]);
    }
    public function editFloodproneArea($id){
    	$municipalities = DB::table('tbl_municipality')->get();
    	$provinces = DB::table('tbl_provinces')->get();
    	$floodproneareas = DB::table('tbl_floodprone_areas')->where('id',$id)->first();
    	return view('pages.editfloodpronearea')->with(['floodproneareas' => $floodproneareas,'municipalities' => $municipalities,'provinces'=>$provinces]);
    }
    public function viewaddFloodproneArea(){
    	$municipalities = DB::table('tbl_municipality')->get();
    	$provinces = DB::table('tbl_provinces')->get();
    	return view('pages.addfloodpronearea')->with(['municipalities' => $municipalities,'provinces' => $provinces]);
    }
    public function saveFloodproneArea(Request $request){
		$cntUser = Auth::user();
		$post = $request->all();		

		$rules = [
			'address' => 'required',

		];
		$messages = [
			'address.required' => 'Address is required',
		];
					
		$v = \Validator::make($request->all(), $rules, $messages);

		if($v->fails()){

			return redirect()->back()->withErrors($v->errors());

		}else{
			$row = array(
				'address' => $post['address'],
				'province_id' => $post['province_id'],
				'municipality_id' => $post['municipality_id'],			
				'user_id' => $cntUser->id
			);				
			$i = DB::table('tbl_floodprone_areas')->insert($row);
			if($i > 0){
				\Session::flash('message', 'Flood-prone Area successfully added');
				return redirect('viewfloodproneareas');
			}
		}   
    }
    public function updateFloodproneArea(Request $request)
   	{
		$cntUser = Auth::user();
		$post = $request->all();

		$rules = [
		'address' => 'required',
		];
		$messages = [
		'address.required' => 'Address is required',
		];
		$v = \Validator::make($request->all(), $rules, $messages);

		if($v->fails())
		{
		return redirect()->back()->withErrors($v->errors());
		}else{
		$row = array(
			'address' => $post['address'],
			'province_id' => $post['province_idedit'],
			'municipality_id' => $post['municipality_idedit'],
		);

		$i = DB::table('tbl_floodprone_areas')->where('id',$post['id'])->update($row);
			\Session::flash('message', 'Flood-prone Area successfully added');
			return redirect()->back();			
		}
   }
    public function destroymultipleFloodproneAreas(Request $request){
      Floodproneareas::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Flood-prone Area successfully deleted.';
      }else{
         $delmsg = $chk .' flood-prone areas successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function destroyFloodpronearea($id){
       $i = DB::table('tbl_floodprone_areas')->where('id',$id)->delete();
    if($i > 0)
	{
		\Session::flash('message', 'Flood-prone Area successfully deleted');
		return redirect('viewfloodproneareas');
	}
   }

}
