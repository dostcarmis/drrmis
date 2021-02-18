<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Models\User;
use App\Models\Landslide;
use App\Models\Municipality;
use DB;
use Carbon\Carbon;
use Auth;
use App\Services\Checkfornotification;
use Illuminate\Support\Facades\Input;
use Response;
use Image;

class VehicleAccidentsController extends Controller
{
    public function viewMultipleVehicularAccidents(){
        $cntUser = Auth::user();
        $municipalities = DB::table('tbl_municipality')->get();
        $users = DB::table('users')->get();
        $provinces = DB::table('tbl_provinces')->get();
        $vehicleaccidents = DB::table('tbl_vehicularaccidents')
                            ->orderBy('created_at', 'desc')->paginate(12);
        return view('pages.viewmultiplevehicleaccidents')->with(['users' => $users,
                                                                    'municipalities' => $municipalities, 'provinces' => $provinces, 'vehicleaccidents' => $vehiclaccidents]);                            
    }

    public function viewperVehicleAccidents($id){
        $municipalities = DB::table('tbl_municipality')->get();
        $users = DB::table('users')->get();
        $provinces = DB::table('tbl_provinces')->get();
        $landslides = DB::table('tbl_vehicularaccidents')->where('id',$id)->first();
        return view('pages.viewpervehicleaccidents')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'vehicleaccidents' => $vehiclaccidents]);
     }

     public function viewVehicleAccidents(){
        $cntUser = Auth::user();
        $users = DB::table('users')->get();
        $provinces = DB::table('tbl_provinces')->get();
        $vehicleaccidents = Vehicularaccidents::with(['province','municipal'])
                            ->orderBy('created_at', 'desc')->get();
        return view('pages.viewvehicleaccidents')->with(['users' => $users,'provinces' => $provinces,'vehicleaccidents' => $vehiclaccidents]);                    
     }

     public function editVehicleAccidents($id){
        $municipalities = DB::table('tbl_municipality')->get();
          $users = DB::table('users')->get();
          $landslides = DB::table('tbl_landslides')->where('id',$id)->first();
        $provinces = DB::table('tbl_provinces')->get();
          return view('pages.editvehicleaccidents')->with(['users' => $users,'landslides' => $landslides,'provinces' => $provinces, 'municipalities' => $municipalities]);
      }

      public function destroymultipleVehicleAccidents(Request $request){
        Vehicularaccidents::destroy($request->chks);
        $chk = count($request->chks);
        if($chk == 1){
           $delmsg = 'Vehicular Accident Report successfully deleted.';
        }
        else{
           $delmsg = $chk .'Vehicular Accident Report successfully deleted.';
        }
        \Session::flash('message',  $delmsg);
        return redirect()->back();
     }

     public function viewaddVehicleAccidents(){
        $users = DB::table('users')->get();
         $landslides = DB::table('tbl_vehicularaccidents')->orderBy('id', 'asc')->get();
         $provinces = DB::table('tbl_provinces')->get();
         return view('pages.addvehicleaccidents')->with(['users' => $users,'landslides' => $landslides,'provinces' => $provinces]);
    }

    public function saveVehicleAccidents(){
        $cntUser = Auth::user();
        $msg = "";
        $post = $request->all();
        $input = Input::all();
        $reportstat = '';
        $vehicleaccidentsimages = "";
        if($post['vehicleaccidentsimages'] == 'vehicleaccidentsimages[]'){
            $vehicleaccidentsimages = "";
        } else {
            $vehicleaccidentsimages = explode('-@', rtrim($post['vehicleaccidentsimages'], '-@,'));
            $vehicleaccidentsimages = serialize($vehicleaccidentsimages);
        } 
        $rules = [
            'date' => 'required',
            'road_location' => 'required',
            'province_id' => 'required',
        ];
        $messages = [
            'date.required' => 'Date and Time required',
            'road_location.required' => 'Road location field is required',
            'province_id.required' => 'Province is required',
            'municipality_id.required' => 'Municipality is required'
         ];
         $v = \Validator::make($request->all(), $rules, $messages);
         if($v->fails()){
            return redirect()->back()->withErrors($v->errors());
         }
         else{
            $date = Carbon::createFromFormat('Y-m-d H:i', $post['date'])->toDateTimeString();
            $datenow = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'))->toDateTimeString();
            //$reporttime = Carbon::createFromFormat('Y-m-d H:i', $post['reporttime'])->toDateTimeString();
            if($cntUser->role_id != 5){
            $reportstat = 'Published';
           }elseif($cntUser->role_id == 5){
            $reportstat = 'Pending';
           }
           $row = array(
            'date' => $date,
            'no_of_vehicles_involved' => $post['no_of_vehicles_involved'],
            'no_of_vehicles_damaged' => $post['no_of_vehicles_damaged'],
            'no_of_drivers_killed' => $post['no_of_drivers_killed'],
            'no_of_drivers_injured' => $post['no_of_drivers_injured'],
            'no_of_passengers_killed' => $post['no_of_passengers_killed'],
            'no_of_passengers_injured' => $post['no_of_passengers_injured'],
            'road_location' => $post['road_location'],
            'municipality' => $post['municipality'],
            'province_id' => $post['province_id'],
            'description' => $post['description'],
            'reportedby' => $post['reportedby'],
            'reporterpos' => $post['reporterpos'],
            'incident_images' => $post['incident_images'],
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'created_by' => $post['created_by'],
            'updated_by' => $post['updated_by'],
            'author' => $post['author'],
            'user_municipality' => $post['user_municipality'],
            'report_status' => $post['report_status'],
           );  
            $i = DB::table('tbl_vehicularaccidents')->insert($row);
            if($i > 0){
               $cntUser->activityLogs($request, $msg = "Added a landslide report");
               Session::flash('message', 'Landslide Report successfully added');
               return redirect('viewlandslides');
            }
         }
      } 


        

   }






     

