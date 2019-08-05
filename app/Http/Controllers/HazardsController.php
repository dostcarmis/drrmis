<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use Session;
use App\Models\Hazards;
class HazardsController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
    public function viewHazards(){
    	$hazards = DB::table('tbl_hazardslib')->get();
    	return view ('pages.viewhazards')->with(['hazards'=> $hazards]);
    }
    public function viewaddHazard(){
   		return view ('pages.addhazard');
   }
   public function editHazard($id){
      $row = DB::table('tbl_hazardslib')->where('id',$id)->first();
      return view ('pages.edithazard')->with(['row' => $row]);
   }
    public function saveHazard(Request $request)
   {
   	$post = $request->all();
       $rules = [
        'hazard_name' => 'required',
    ];
    $messages = [
        'hazard_name.required' => 'Hazard name field is required',
    ];
    $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $hazard = array(
               'name' => $post['hazard_name'],
               'description' => $post['hazard_desc']
            );

         $i = DB::table('tbl_hazardslib')->insert($hazard);
         if($i > 0){
            Session::flash('message', 'Hazard successfully added');
            return redirect('viewhazards');
         }
      }
   }
   public function updateHazard(Request $request)
   {	
   		$post = $request->all();
	    $rules = [
	        'hazard_name' => 'required',
	    ];
	    $messages = [
	        'hazard_name.required' => 'Hazard name field is required',
	    ];
	    $v = \Validator::make($request->all(), $rules, $messages);
	      if($v->fails())
	      {
	         return redirect()->back()->withErrors($v->errors());
	      }else{
	         $hazard = array(
	               'name' => $post['hazard_name'],
	               'description' => $post['hazard_desc']
	            );

	         $i = DB::table('tbl_hazardslib')->where('id',$post['id'])->update($hazard);
	         if($i > 0){
	            Session::flash('message', 'Hazard successfully updated');
	            return redirect('viewhazards');
	         }
	      }
   }
   public function destroyHazard($id){
       $i = DB::table('tbl_hazardslib')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Hazard successfully deleted');
         return redirect('viewhazards');
      }
   }
   public function destroymultipleHazards(Request $request){
      Hazards::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Hazard successfully deleted.';
      }else{
         $delmsg = $chk .' hazards successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
}
