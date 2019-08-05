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
use App\Models\Thresholdfloodmodel;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use JavaScript;
class ThresholdFlood extends Controller
{
    function __construct()
   {
      $this->middleware('auth');
   }
   public function destroymultipleThresholdFlood(Request $request){

      Thresholdfloodmodel::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Flood threshold successfully deleted.';
      }else{
         $delmsg = $chk .' flood thresholds successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function destroyThresholdFlood($id){
       $i = DB::table('tbl_thresholdflood')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Flood Threshold successfully deleted');
         return redirect('viewthresholdflood');
      }
   }
   public function viewThresholdFlood(){
      $floodproneareas = DB::table('tbl_floodprone_areas')->get();
   		$sensors = DB::table('tbl_sensors')->get();
   		$thresholdfloods = DB::table('tbl_thresholdflood')->orderBy('created_at', 'desc')->get();
      JavaScript::put([
            'floodproneareas' => $floodproneareas
        ]);
   		return view('pages.viewfloodthresholds')->with(['thresholdfloods' => $thresholdfloods,'sensors' => $sensors,'floodproneareas' => $floodproneareas]);
   }
   public function viewaddThresholdFlood(){
         $sensors = DB::table('tbl_sensors')->get();
         $users = DB::table('users')->get();
         $floodproneareas = DB::table('tbl_floodprone_areas')->get();
         JavaScript::put([
            'floodproneareas' => $floodproneareas
        ]);
         return view ('pages.addthresholdflood')->with(['sensors' => $sensors,'users' => $users,'floodproneareas' => $floodproneareas]);
   }
   public function editThresholdFlood($id){
        $sensors = DB::table('tbl_sensors')->get();
         $floodproneareas = DB::table('tbl_floodprone_areas')->get();
         $thresholdflood = DB::table('tbl_thresholdflood')->where('id',$id)->first();
         JavaScript::put([
            'floodproneareas' => $floodproneareas
        ]);
         return view ('pages.editthresholdflood')->with(['thresholdflood' => $thresholdflood,'sensors' => $sensors,'floodproneareas' => $floodproneareas]);
   }
   public function saveThresholdFlood(Request $request){
      $user = Auth::user();
      $post = $request->all();          
      $rules = [
        'threshold_flood' => 'required','affected_areas' => 'required' ];
       $messages = [
        'threshold_flood.required' => 'Landslide value field is required',
        'affected_areas.required' => 'Affected areas field is required',
      ];

      $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{

          $sensorandvalue = [];
          $fvalue = [];
          $counter = 0;
          $c = 0;
          foreach ($post['address_id'] as  $sensorid) {
              $sensorandvalue[$counter] = array($sensorid,$post['threshold_flood'][$counter]);
              $counter++;
          }

            $thresholdflood = array(
                'areas_affected' => serialize($post['affected_areas']),
                'sensor_sources' => serialize($sensorandvalue),
                'user_id' => $user->id,
               );

            $i = DB::table('tbl_thresholdflood')->insert($thresholdflood);
            if($i > 0){
               Session::flash('message', 'Flood threshold successfully added');
               return redirect('viewthresholdflood');
            }        
      }
   }
   public function updateThresholdFlood(Request $request){
      $user = Auth::user();
      $post = $request->all();          

      $rules = [
        'threshold_flood' => 'required',
       ];

       $messages = [
        'threshold_flood.required' => 'Landslide value field is required',
      ];


      $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
          $sensorandvalue = [];
          $counter = 0;

          foreach ($post['address_id'] as  $sensorid) {
              $sensorandvalue[$counter] = array(
                 $sensorid,  $post['threshold_flood'][$counter]
              );
              $counter++;
          }

          $thresholdflood = array(
            'areas_affected' => serialize($post['affected_areas']),
            'sensor_sources' => serialize($sensorandvalue),
            'user_id' => $user->id,
          );

          $i = DB::table('tbl_thresholdflood')->where('id',$post['id'])->update($thresholdflood);
          if($i > 0){
             Session::flash('message', 'Flood threshold successfully updated');
             return redirect()->back();
          }        

      }
   }
}
