<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Session;
use App\Http\Requests;
use App\Models\User;
use App\Models\Landslides;
use App\Models\Municipality;
use DB;
use Carbon\Carbon;
use Auth;
use App\Services\Checkfornotification;
use Illuminate\Support\Facades\Input;
use Response;
use Image;

class LandslideController extends Controller
{
    private $foo_service;
    function __construct(Checkfornotification $foo_service){
      $this->foo_service = $foo_service;
    }

    public function viewmultipleLandslides(){
      $cntUser = Auth::user(); 
      $municipalities = DB::table('tbl_municipality')->get();
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $landslides = DB::table('tbl_landslides')
                      ->orderBy('created_at', 'desc')->paginate(12);
      return view('pages.viewmultiplelandslides')->with(['users' => $users,
                                                         'municipalities' => $municipalities,'provinces' => $provinces,'landslides' => $landslides]);
    }

    public function viewperLandslide($id){
      $municipalities = DB::table('tbl_municipality')->get();
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $landslides = DB::table('tbl_landslides')->where('id',$id)->first();
      return view('pages.viewperlandslide')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'landslides' => $landslides]);
   }

    public function viewLandslides(){
      $cntUser = Auth::user(); 
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $landslides = DB::table('tbl_landslides')
                      ->orderBy('created_at', 'desc')->get();
    	return view('pages.viewlandslides')->with(['users' => $users,'provinces' => $provinces,'landslides' => $landslides]);
    }

    public function editLandslide($id){
      $municipalities = DB::table('tbl_municipality')->get();
    	$users = DB::table('users')->get();
    	$landslides = DB::table('tbl_landslides')->where('id',$id)->first();
      $provinces = DB::table('tbl_provinces')->get();
    	return view('pages.editlandslide')->with(['users' => $users,'landslides' => $landslides,'provinces' => $provinces, 'municipalities' => $municipalities]);
    }

    public function destroymultipleLandslides(Request $request){
      Landslides::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Landslide successfully deleted.';
      }
      else{
         $delmsg = $chk .' landslides successfully deleted.';
      }
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }

   public function viewaddLandslide(){
	   $users = DB::table('users')->get();
		$landslides = DB::table('tbl_landslides')->orderBy('id', 'asc')->get();
      $provinces = DB::table('tbl_provinces')->get();
		return view('pages.addlandslide')->with(['users' => $users,'landslides' => $landslides,'provinces' => $provinces]);
   }

   public function saveLandslide(Request $request){ 
    $cntUser = Auth::user();
    $post = $request->all();
    $input = Input::all();
    $reportstat = '';
    $landslideimages = "";
    if($post['myimages'] == "myimages[]"){
      $landslideimages = "";
    }
    else{
      $landslideimages = explode('-@,', rtrim($post['myimages'], '-@,'));
      $landslideimages = serialize($landslideimages);
    }
    $rules = [
      'date' => 'required',  
      'road_location' => 'required',
      'province_id' => 'required',
    ];
    $messages = [
       'date.required' => 'Date and Time rquired',
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
         'road_location' => $post['road_location'],
         'house_location' => $post['house_location'],
         'province_id' => $post['province_id'],
         'municipality' => $post['municipality_id'],
         'landcover' => $post['landcover'],
         'landmark' => $post['landmark'],
         'landslidetype' => $post['landslidetype'],
         'landslidereccuring' => $post['landslidereccuring'],
         'lewidth' => $post['lewidth'],
         'lelength' => $post['lelength'],
         'ledepth' => $post['ledepth'],
         'idkilled' => $post['idkilled'],
         'idinjured' => $post['idinjured'],
         'idmissing' => $post['idmissing'],
         'idaffectedcrops' => $post['idaffectedcrops'],
         'idaffectedinfra' => $post['idaffectedinfra'],
         'cause' => $post['cause'],
         'typhoonname' => $post['typhoonname'],
         'heavyrainfall' => $post['heavyrainfall'],
         'reportedby' => $post['reportedby'],
         'reporterpos' => $post['reporterpos'],
         'incident_images' => $landslideimages,
         'created_by' => $cntUser->id,
         'created_at' => $datenow,
         'latitude' => $post['latitude'],
         'longitude' => $post['longitude'],
         'author' => $post['author'],
         'user_municipality' => $cntUser->municipality_id,
         'report_status' => $reportstat,
        );  
         $i = DB::table('tbl_landslides')->insert($row);
         if($i > 0){
            Session::flash('message', 'Landslide Report successfully added');
            return redirect('viewlandslides');
         }
      }
   }

   public function updateLandslide(Request $request){
   	$cntUser = Auth::user();
   	$post = $request->all();   
      $landslideimages = "";
      $roadloc = $post['road_location'];
      
    
      if(($post['landslideimages'] == "landslideimages[]") || ($post['landslideimages'] == "")){
      $landslideimages = "";
    }
    else{
       rtrim($post['landslideimages'], ',');
      $landslideimages = explode('-@,', rtrim($post['landslideimages'], '-@,'));
      $landslideimages = serialize($landslideimages);
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
      }
      else{
      	$date = Carbon::createFromFormat('Y-m-d H:i', $post['date'])->toDateTimeString();
      	$datenow = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'))->toDateTimeString();
         if($cntUser->role_id != 5){
				$reportstat = 'Published';				
			}elseif($cntUser->role_id == 5){
				$reportstat = 'Pending';	
         }
         $row = array(
            'date' => $date,
            'road_location' => $roadloc,
            'house_location' => $post['house_location'],
            'province_id' => $post['province_id'],
            'municipality' => $post['municipality_id'],
            'landcover' => $post['landcover'],
            'landmark' => $post['landmark'],
            'landslidereccuring' => $post['landslidereccuring'],
            'landslidetype' => $post['landslidetype'],
            'lewidth' => $post['lewidth'],
            'lelength' => $post['lelength'],
            'ledepth' => $post['ledepth'],
            'idkilled' => $post['idkilled'],
            'idinjured' => $post['idinjured'],
            'idmissing' => $post['idmissing'],
            'idaffectedcrops' => $post['idaffectedcrops'],
            'idaffectedinfra' => $post['idaffectedinfra'],
            'cause' => $post['cause'],
            'typhoonname' => $post['typhoonname'],
            'heavyrainfall' => $post['heavyrainfall'],
            'reportedby' => $post['reportedby'],
            'reporterpos' => $post['reporterpos'],
            'incident_images' => $landslideimages,
            'created_by' => $cntUser->id,
            'updated_at' => $datenow,
            'latitude' => $post['latitude'],
            'longitude' => $post['longitude'],
            'author' => $post['author'],
            'user_municipality' => $cntUser->municipality_id,
            'report_status' => $reportstat,
           );  

         $i = DB::table('tbl_landslides')->where('id',$post['id'])->update($row);
         if($i > 0){
            Session::flash('message', 'Landslide Report on successfully updated');
            return redirect('viewlandslides');
         }
      }
   }

   public function showprovince(Request $request)
   {
     $province = $request->cat_id;
     $items = Municipality::where('province_id', '=', $province)->get();
     return Response::json($items);      
   }

   public function destroyLandslide($id){
       $i = DB::table('tbl_landslides')->where('id',$id)->delete();
       if($i > 0){
         \Session::flash('message', 'Landslide report successfully deleted');
         return redirect('viewlandslides');
      }
   }

   public function uploadLandslideimage(){
      $input = Input::all();        
        $rules = array(
            'file' => 'image|max:8000',
        );
        $validation = \Validator::make($input, $rules);
        if ($validation->fails()) {
            return Response::make($validation->errors()->all(), 400);
        }
        $destinationPath = 'files/1/Incident_Images'; // upload path
        $destinthumb = 'files/1/Incident_Images'; 
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
        } 
        else {
            return Response::json('error', 400);
        }
   }

   public function edituploadLandslideimage($id){
      $input = Input::all();        
        $rules = array(
            'file' => 'image|max:8000',
        );
        $validation = \Validator::make($input, $rules);
        if ($validation->fails()) {
            return Response::make($validation->errors()->all(), 400);
        }
        $destinationPath = 'files/1/Incident_Images'; // upload path
        $destinthumb = 'files/1/Incident_Images/thumbs'; 
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
        } 
        else{
            return Response::json('error', 400);
        }
   }

   public function viewReportLandslide(){
      $datadate = '';
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $landslides = DB::table('tbl_landslides')->orderBy('date', 'desc')->get();
      return view('pages.landslidereports')->with('datadate',$datadate)->with(['users' => $users,'provinces' => $provinces,'landslides' => $landslides]);
   }

   public function filterLandslideReport(Request $request){
      $post = $request->all();     
      $datadate = $post['daterangeinput'];
      $users = DB::table('users')->get();
      $provinces = DB::table('tbl_provinces')->get(); 
      $dateranges = explode(' - ', $post['daterangeinput']);
      $fromDate = date($dateranges[0] . ' 00:00:00', time()); 
      $toDate = date($dateranges[1]. ' 23:00:00', time()); 
      if ($post['inputreportgen'] == 0) {
        $landslides = DB::table('tbl_landslides')->whereBetween('date', array($fromDate, $toDate))->get();
      }
      else{
        $landslides = DB::table('tbl_landslides')->where('province_id','=',$post['inputreportgen'])->whereBetween('date', array($fromDate, $toDate))->get();
      }
      return view('pages.landslidereports')->with('datadate',$datadate)->with(['users' => $users,'provinces' => $provinces,'landslides' => $landslides]);
   }

   public function syncDataFromIncidentToLandslide(){
      $datIncident = DB::table('tbl_incidents')
                       ->where('incident_type', 1)
                       ->get();
      //dd($datIncident);
      
      foreach($datIncident as $cnt => $incident){
        echo $cnt . "<br>";
         DB::table('tbl_landslides')->insert(
            [
               'id' => $incident->id,
               'date' => $incident->date,
               'road_location' => $incident->location,
               'house_location' => '',
               'municipality' => '',
               'province_id' => $incident->province_id,
               'landcover' => 'Not recorded',
               'landmark' => 'Not recorded',
               'landslidereccuring' => 'Not recorded',
               'landslidetype' => 'Not recorded',
               'lewidth' => '',
               'lelength' => '',
               'ledepth' => '',
               'idkilled' => '',
               'idinjured' =>'',
               'idaffectedcrops' => '',
               'idaffectedinfra' => '',
               'reportedby' => 'Not recorded',
               'reporterpos' => 'Not recorded',
               'cause' => 'n/a',
               'typhoonname' => 'n/a',
               'heavyrainfall' => 'n/a',
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

