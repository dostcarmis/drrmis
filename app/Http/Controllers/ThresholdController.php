<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;

use App\Http\Requests;
use DB;
use Session;
use App\Models\Category;
use App\Models\Sensors;
use App\Models\Threshold;
use App\Models\User;
use Carbon\Carbon;
use Auth;
class ThresholdController extends Controller
{
    function __construct()
   {
      $this->middleware('auth');

   }
   public function destroymultipleThreshold(Request $request){

      Threshold::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Threshold successfully deleted.';
      }else{
         $delmsg = $chk .' threshold successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function viewThreshold(){
   		$sensors = DB::table('tbl_sensors')->get();
      $categories = DB::table('tbl_categories')->get();
   		$threshold = DB::table('tbl_threshold')->orderBy('created_at', 'desc')->get();
   		return view('pages.viewthreshold')->with(['threshold' => $threshold,'sensors' => $sensors,'categories' => $categories]);
   }

   public function viewaddThreshold(){
   		$sensors = DB::table('tbl_sensors')->get();
      $threshold = DB::table('tbl_threshold')->get();
      $users = DB::table('users')->get();
   		return view ('pages.addthreshold')->with(['sensors' => $sensors,'users' => $users,'threshold' => $threshold]);
   }
   public function saveThreshold(Request $request)
   {   	
      $user = Auth::user();
   	  $post = $request->all();  
      $tresexists = DB::table('tbl_threshold')->where('address_id', '=',$post['address_id'])->first();
    
      $rules = [

        'threshold_date' => 'required',

       ];
       $messages = [

           'threshold_date.required' => 'Date is required',
       ];
       




    $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         if ($tresexists == null) {
            $date = Carbon::createFromFormat('Y-m-d', $post['threshold_date'])->toDateString();
            $threshold = array(
                  'address_id' => $post['address_id'],
                  'threshold_date' => $date,
                  'threshold_landslide' => $post['threshold_landslide'],
                  'normal_val' => $post['waternormalvalue'],
                  'level1_val' => $post['waterlevel1value'],
                  'level2_val' => $post['waterlevel2value'],
                  'critical_val' => $post['watercriticalvalue'],
                  'user_id' => $user->id,

               );

            $i = DB::table('tbl_threshold')->insert($threshold);
            if($i > 0){
               Session::flash('message', 'Threshold successfully added');
               return redirect('viewthreshold');
            }
               
         }else{
             Session::flash('message', 'Threshold Value already exists!');
               return redirect()->back();
         }
      	
      }
   }
   public function editThreshold($id){
   		$sensors = DB::table('tbl_sensors')->get();
      $threshold = DB::table('tbl_threshold')->where('id',$id)->first();
      $categories = DB::table('tbl_categories')->get();
      return view ('pages.editthreshold')->with(['threshold' => $threshold,'sensors' => $sensors,'categories' => $categories]);
   }
   public function updateThreshold(Request $request)
   {
      $user = Auth::user();
      $post = $request->all();
      $rules = [
        'threshold_date' => 'required',

       ];
       $messages = [

           'threshold_date.required' => 'Date is required',
       ];
       $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $date = Carbon::createFromFormat('Y-m-d', $post['threshold_date'])->toDateString();
         $threshold = array(
               'threshold_date' => $date,
               'threshold_landslide' => $post['threshold_landslide'],
               'normal_val' => $post['waternormalvalue'],
                'level1_val' => $post['waterlevel1value'],
                'level2_val' => $post['waterlevel2value'],
                'critical_val' => $post['watercriticalvalue'],
               'user_id' => $user->id,
               'updated_at' => date('Y-m-d H:i:s'),
            );

         $i = DB::table('tbl_threshold')->where('id',$post['id'])->update($threshold);
         if($i >= 0){
            \Session::flash('message', 'Threshold successfully updated');
            return redirect('viewthreshold');
         }
      }
   }

   public function destroyThreshold($id){
       $i = DB::table('tbl_threshold')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Threshold successfully deleted');
         return redirect('viewthreshold');
      }
   }
}
