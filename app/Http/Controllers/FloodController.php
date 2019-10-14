<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Models\User;
use App\Models\Floods;
use DB;
use Carbon\Carbon;
use Auth;
use Storage;
use Illuminate\Support\Facades\Input;
use Response;
use Image;


class FloodController extends Controller

{
	public function viewmultipleFloods(){
      $cntUser = Auth::user(); 
      $municipalities = DB::table('tbl_municipality')->get();
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $floods = DB::table('tbl_floods')
                  ->orderBy('created_at', 'desc')->paginate(4);
      return view('pages.viewmultiplefloods')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'floods' => $floods]);
    }

    public function viewperFlood($id){
      $municipalities = DB::table('tbl_municipality')->get();
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $floods = DB::table('tbl_floods')->where('id',$id)->first();
    return view('pages.viewperflood')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'floods' => $floods]);

   }

    public function viewFloods(){
      $cntUser = Auth::user(); 
      $provinces = DB::table('tbl_provinces')->get();
      $users = DB::table('users')->get();
      $floods = DB::table('tbl_floods')
                  ->orderBy('date', 'desc')->get(); 
    	return view('pages.viewfloods')->with(['users' => $users,'floods' => $floods,'provinces' => $provinces]);

    }

    public function editFlood($id){
      $municipalities = DB::table('tbl_municipality')->get();
    	$users = DB::table('users')->get();
    	$floods = DB::table('tbl_floods')->where('id',$id)->first();
      $provinces = DB::table('tbl_provinces')->get();
      return view('pages.editflood')->with(['users' => $users,'floods' => $floods,'provinces' => $provinces, 'municipalities' => $municipalities]);
    }

    public function saveFlood(Request $request){          
      $cntUser = Auth::user();
      $post = $request->all();
      $floodimages = "";
        if($post['floodimages'] == "floodimages[]"){
          $floodimages = "";
        }else{
         $floodimages = explode('-@,', rtrim($post['floodimages'], '-@,'));
         $floodimages = serialize($floodimages);
        }
  
      $rules = [
         'date' => 'required',  
         'road_location' => 'required',
         'province_id' => 'required',
      ];
  
      $messages = [
         'date.required' => 'Date and Time rquired',
         'road_location.required' => 'Road location field is required',
         'province_id.required' => 'Province and Municipality is required',
      ];
  
      $v = \Validator::make($request->all(), $rules, $messages);
        if($v->fails()){
           return redirect()->back()->withErrors($v->errors());
        }else{
           $date = Carbon::createFromFormat('Y-m-d H:i', $post['date'])->toDateTimeString();
           $datenow = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'))->toDateTimeString();
           if($cntUser->role_id != 5){
            $reportstat = 'Published';
           }elseif($cntUser->role_id == 5){
            $reportstat = 'Pending';
           }
            $row = array(
               'date' => $date,
               'road_location' => $post['road_location'],
               'province_id' => $post['province_id'],
               'municipality' => $post['municipality_id'],
               'river_system' => $post['river_system'],
               'flood_type' => $post['flood_type'],
               'flood_reccuring' => $post['flood_reccuring'],
               'flood_waterlvl' => $post['flood_waterlvl'],
               'measuredat' => $post['measuredat'],
               'flood_killed' => $post['flood_killed'],
               'flood_injured' => $post['flood_injured'],
               'flood_missing' => $post['flood_missing'],
               'flood_affectedcrops' => $post['flood_affectedcrops'],
               'flood_affectedinfra' => $post['flood_affectedinfra'],
               'cause' => $post['cause'],
               'typhoon_name' => $post['typhoon_name'],
               'heavy_rainfall' => $post['heavy_rainfall'],
               'reported_by' => $post['reported_by'],
               'reporter_pos' => $post['reporter_pos'],
               'incident_images' => $floodimages,
               'created_by' => $cntUser->id,
               'created_at' => $datenow,
               'latitude' => $post['latitude'],
               'longitude' => $post['longitude'],
               'author' => $post['author'],
               'user_municipality' => $cntUser->municipality_id,
               'report_status' => $reportstat,
               
              );  
          
           $i = DB::table('tbl_floods')->insert($row);
           if($i > 0){
              Session::flash('message', 'Flood Report successfully added');
              return redirect('viewfloods');
           }
        }
     }


    public function updateFlood(Request $request){
   	$cntUser = Auth::user();
    $post = $request->all();
    if(($post['floodimages'] == "floodimages[]") || ($post['floodimages'] == "")){
      $floodimages = "";
    }else{
       rtrim($post['floodimages'], ',');
      $floodimages = explode('-@,', rtrim($post['floodimages'], '-@,'));
      $floodimages = serialize($floodimages);
    }

      $rules = [
         'date' => 'required',  
         'road_location' => 'required',
         'province_id' => 'required', 
    ];

    $messages = [
      'date.required' => 'Date and Time rquired',
      'road_location.required' => 'Road location field is required',
      'province_id.required' => 'Province and Municipality is required',
    ];

    $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
      	$date = Carbon::createFromFormat('Y-m-d H:i', $post['date'])->toDateTimeString();
      	$datenow = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'))->toDateTimeString();
         if($cntUser->role_id != 5){
				$reportstat = 'Published';				
			}elseif($cntUser->role_id == 5){
				$reportstat = 'Pending';	
         }
         $row = array(
            'date' => $date,
            'road_location' => $post['road_location'],
            'province_id' => $post['province_id'],
            'municipality' => $post['municipality_id'],
            'river_system' => $post['river_system'],
            'flood_type' => $post['flood_type'],
            'flood_reccuring' => $post['flood_reccuring'],
            'flood_waterlvl' => $post['flood_waterlvl'],
            'measuredat' => $post['measuredat'],
            'flood_killed' => $post['flood_killed'],
            'flood_injured' => $post['flood_injured'],
            'flood_missing' => $post['flood_missing'],
            'flood_affectedcrops' => $post['flood_affectedcrops'],
            'flood_affectedinfra' => $post['flood_affectedinfra'],
            'cause' => $post['cause'],
            'typhoon_name' => $post['typhoon_name'],
            'heavy_rainfall' => $post['heavy_rainfall'],
            'reported_by' => $post['reported_by'],
            'reporter_pos' => $post['reporter_pos'],
            'incident_images' => $floodimages,
            'created_by' => $cntUser->id,
            'updated_at' => $datenow,
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'author' => $post['author'],
            'user_municipality' => $cntUser->municipality_id,
            'report_status' => $reportstat,
           );  
          

         $i = DB::table('tbl_floods')->where('id',$post['id'])->update($row);
         if($i > 0){
            Session::flash('message', 'Flood Report successfully updated');
            return redirect()->back();
         }else{
         	Session::flash('message', 'Flood Report successfully updated');
            return redirect()->back();
         }
      }
   } 

   public function destroyFlood($id){
       $i = DB::table('tbl_floods')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Flood report successfully deleted');
         return redirect('viewfloods');
      }
   }


   public function viewaddFlood(){
	    $users = DB::table('users')->get();
		  $floods = DB::table('tbl_floods')->get();
      $provinces = DB::table('tbl_provinces')->get();
		return view('pages.addflood')->with(['provinces' => $provinces,'users' => $users,'floods' => $floods]);
   }

   

   public function destroymultipleFloods(Request $request){
      Floods::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Flood successfully deleted.';
      }else{
         $delmsg = $chk .' floods successfully deleted.';
      }
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }

   public function uploadFloodimages(){
    $input = Input::all();        
        $rules = array(
            'file' => 'image|max:8000',
        );
        $validation = \Validator::make($input, $rules);
        if ($validation->fails()) {
            return Response::make($validation->errors()->all(), 400);
        } 

        $destinationPath = 'files/1/Flood Images'; 
        $destinthumb = 'files/1/Flood Images/thumbs'; 
        $extension = Input::file('file')->getClientOriginalExtension();
        $name = Input::file('file')->getClientOriginalName();
        $img = Image::make(Input::file('file'));
        $img->fit(200, 200);
        $img->save($destinthumb.'/'.$name);
        $fileName = $name. '.' . $extension; 
        $upload_success = Input::file('file')->move($destinationPath, $name);
        if ($upload_success) {
            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
   }

   public function edituploadFloodimage($id){
      $input = Input::all();        
        $rules = array(
            'file' => 'image|max:8000',
        );
        $validation = \Validator::make($input, $rules);
        if ($validation->fails()) {
            return Response::make($validation->errors()->all(), 400);
        }

        $destinationPath = 'files/1/Flood Images'; // upload path
        $destinthumb = 'files/1/Flood Images/thumbs'; 
        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $name = Input::file('file')->getClientOriginalName();
        $img = Image::make(Input::file('file'));
        $img->fit(200, 200);
        $img->save($destinthumb.'/'.$name);
        $fileName = $name. '.' . $extension; // renameing image
       // $uploadthumb_success = $img->move($destinthumb, $name);
        $upload_success = Input::file('file')->move($destinationPath, $name); // uploading file to given path
        if ($upload_success) {
            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
   }

   public function viewFloodLandslide(){
      $datadate = '';
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $floods = DB::table('tbl_floods')->orderBy('date', 'desc')->get();
      return view('pages.floodreports')->with('datadate',$datadate)->with(['users' => $users,'provinces' => $provinces,'floods' => $floods]);
   }

   public function filterFloodReport(Request $request){
      $post = $request->all();     
      $datadate = $post['daterangeinput'];
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get(); 
      $dateranges = explode(' - ', $post['daterangeinput']);
      $fromDate = date($dateranges[0] . ' 00:00:00', time()); 
      $toDate = date($dateranges[1]. ' 23:00:00', time()); 

      if ($post['inputreportgen'] == 0) {
        $floods = DB::table('tbl_floods')->whereBetween('date', array($fromDate, $toDate))->get();
      }else{
        $floods = DB::table('tbl_floods')->where('province_id','=',$post['inputreportgen'])->whereBetween('date', array($fromDate, $toDate))->get();
      }
      return view('pages.floodreports')->with('datadate',$datadate)->with(['users' => $users,'provinces' => $provinces,'floods' => $floods]);
   }

   public function syncDataFromIncidentToFlood(){
      $datIncident = DB::table('tbl_incidents')
                       ->where('incident_type', 2)
                       ->get();
      //dd($datIncident);
      
      foreach($datIncident as $cnt => $incident){
        echo $cnt . "<br>";
         DB::table('tbl_floods')->insert(
            [
               'id' => $incident->id,
               'date' => $incident->date,
               'road_location' => $incident->location,
               'municipality' => '',
               'province_id' => $incident->province_id,
               'river_system' => 'Not recorded',
               'flood_type' => 'River Flooding',
               'flood_reccuring' => 'Not recorded',
               'flood_waterlvl' => 'Not recorded',
               'measuredat' =>'',
               'flood_killed' => '',
               'flood_injured' => '',
               'flood_missing' => '',
               'flood_affectedcrops' => '',
               'flood_affectedinfra' => '',
               'reported_by' => 'Not recorded',
               'reporter_pos' => 'Not recorded',
               'cause' => 'n/a',
               'typhoon_name' => 'n/a',
               'heavy_rainfall' => 'n/a',
               'incident_images' => $incident->incident_images,
               'latitude' => $incident->latitude,
               'longitude' => $incident->longitude,
               'created_by' => $incident->created_by,
               'updated_by' => $incident->updated_by,
               'author' => $incident->author,
               'user_municipality' => $incident->user_municipality,
               'report_status' => $incident->report_status,
               'created_at' => $incident->created_at,
               'updated_at' => $incident->updated_at,
            ]
         );
            
      }
    }

}

