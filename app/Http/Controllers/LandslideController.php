<?php



namespace App\Http\Controllers;



use Illuminate\Http\Request;

use Session;

use App\Http\Requests;

use App\Models\User;

use App\Models\Landslide;

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

      $landslides = DB::table('tbl_incidents')
                      ->where('report_status','=','Published')
                      ->where('incident_type','=',1)
                      ->orderBy('created_at', 'desc')->paginate(12);

      return view('pages.viewmultiplelandslides')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'landslides' => $landslides]);

    }

    public function viewperLandslide($id){



      $municipalities = DB::table('tbl_municipality')->get();

      $users = DB::table('users')->get();

      $provinces = DB::table('tbl_provinces')->get();

      $landslides = DB::table('tbl_incidents')->where('id',$id)->first();

      return view('pages.viewperlandslide')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'landslides' => $landslides]);

   }

    public function viewLandslides(){

      $cntUser = Auth::user(); 

      $users = DB::table('users')->get();

      $provinces = DB::table('tbl_provinces')->get();

      $landslides = DB::table('tbl_incidents')
                      ->where('report_status','=','Published')
                      ->where('incident_type','=',1)
                      ->orderBy('created_at', 'desc')->get();

    	return view('pages.viewlandslides')->with(['users' => $users,'provinces' => $provinces,'landslides' => $landslides]);

    }

    public function editLandslide($id){

    	$users = DB::table('users')->get();

    	$landslides = DB::table('tbl_incidents')->where('id',$id)->first();

      $provinces = DB::table('tbl_provinces')->get();

    	return view('pages.editlandslide')->with(['users' => $users,'landslides' => $landslides,'provinces' => $provinces]);

    }

    public function destroymultipleLandslides(Request $request){

      Landslide::destroy($request->chks);

      $chk = count($request->chks);

      if($chk == 1){

         $delmsg = 'Landslide successfully deleted.';

      }else{

         $delmsg = $chk .' landslides successfully deleted.';

      }

      

      \Session::flash('message',  $delmsg);

      return redirect()->back();

   }

   public function viewaddLandslide(){

	    $users = DB::table('users')->get();

		$landslides = DB::table('tbl_landslide')->orderBy('id', 'asc')->get();

    $provinces = DB::table('tbl_provinces')->get();

		return view('pages.addlandslide')->with(['users' => $users,'landslides' => $landslides,'provinces' => $provinces]);

   }

   public function saveLandslide(Request $request)

   	{

   	$cntUser = Auth::user();

   	$post = $request->all();

    $input = Input::all();

    $landslideimages = "";

    if($post['myimages'] == "myimages[]"){

      $landslideimages = "";

    }else{

      $landslideimages = explode('-@,', rtrim($post['myimages'], '-@,'));

      $landslideimages = serialize($landslideimages);

    }

    $rules = [

        'location' => 'required',

        'date' => 'required',

        'author' => 'required',



    ];

    $messages = [

        'location.required' => 'Location field is required',

        'date.required'  => 'Date field is required',

        'author.required' => 'Source field is required',



    ];

    $v = \Validator::make($request->all(), $rules, $messages);



      if($v->fails())

      {

         return redirect()->back()->withErrors($v->errors());

      }else{

      	$date = Carbon::createFromFormat('Y-m-d H:i', $post['date'])->toDateTimeString();

        if($cntUser->role_id != 5){

          $row = array(



               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'latitude' => $post['latitude'],

               'longitude' => $post['longitude'],

               'province_id' => $post['province_id'],

               'landslide_image' =>$landslideimages,

               'user_id' => $cntUser->id,

               'author' => $post['author'],

               'report_status' => 'Published',

               'user_municipality' => $cntUser->municipality_id

            );

        }elseif($cntUser->role_id == 5){

          $row = array(

               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'latitude' => $post['latitude'],

               'longitude' => $post['longitude'],

               'province_id' => $post['province_id'],

               'landslide_image' =>$landslideimages,

               'user_id' => $cntUser->id,

               'author' => $post['author'],

               'report_status' => 'Pending',

               'user_municipality' => $cntUser->municipality_id

            );

        }

         



         $i = DB::table('tbl_landslide')->insert($row);

         if($i > 0){

            Session::flash('message', 'Landslide Report successfully added');

            return redirect('viewlandslides');

         }

      }

   }

   public function updateLandslide(Request $request)

   	{



   	$cntUser = Auth::user();

   	$post = $request->all();   

    $landslideimages = "";

    if(($post['landslideimages'] == "landslideimages[]") || ($post['landslideimages'] == "")){

      $landslideimages = "";

    }else{

       rtrim($post['landslideimages'], ',');

      $landslideimages = explode('-@,', rtrim($post['landslideimages'], '-@,'));

      $landslideimages = serialize($landslideimages);

    }

    $rules = [

        'location' => 'required',

        'date' => 'required',

        'author' => 'required',



    ];

    $messages = [

        'location.required' => 'Location field is required',

        'date.required'  => 'Date field is required',

        'author.required' => 'Source field is required',



    ];



    $v = \Validator::make($request->all(), $rules, $messages);

      if($v->fails())

      {

         return redirect()->back()->withErrors($v->errors());

      }else{

      	$date = Carbon::createFromFormat('Y-m-d H:i', $post['date'])->toDateTimeString();

      	$datenow = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'))->toDateTimeString();

        if($cntUser->role_id != 5){

          $row = array(



               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'latitude' => $post['latitude'],

               'longitude' => $post['longitude'],               

               'province_id' => $post['province_id'],

               'landslide_image' => $landslideimages,

               'author' => $post['author'],

               'updated_at' => $datenow,

               'updated_by' => $cntUser->id,

               'report_status' => $post['report_status'],

            );



        }elseif($cntUser->role_id == 5){

          $row = array(

               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'latitude' => $post['latitude'],

               'longitude' => $post['longitude'],

               'province_id' => $post['province_id'],

               'landslide_image' => $landslideimages,

               'author' => $post['author'],

               'updated_at' => $datenow,

               'updated_by' => $cntUser->id,

            );

        }   

         



         $i = DB::table('tbl_landslide')->where('id',$post['id'])->update($row);

         if($i > 0){

            Session::flash('message', 'Landslide Report successfully updated');

            return redirect()->back();

         }else{

         	Session::flash('message', 'Landslide Report successfully updated');

            return redirect()->back();

         }

      }

   }

   public function destroyLandslide($id){

       $i = DB::table('tbl_landslide')->where('id',$id)->delete();

       if($i > 0)

      {

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

 

        $destinationPath = 'files/1/Landslide Images'; // upload path

        $destinthumb = 'files/1/Landslide Images/thumbs'; 

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

   public function edituploadLandslideimage($id){

      $input = Input::all();        

        $rules = array(

            'file' => 'image|max:8000',

        );



        $validation = \Validator::make($input, $rules);

 

        if ($validation->fails()) {

            return Response::make($validation->errors()->all(), 400);

        }

 

        $destinationPath = 'files/1/Landslide Images'; // upload path

        $destinthumb = 'files/1/Landslide Images/thumbs'; 

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

   public function viewReportLandslide(){

      $datadate = '';

      $users = DB::table('users')->get();

      $provinces = DB::table('tbl_provinces')->get();

      $landslides = DB::table('tbl_landslide')->orderBy('date', 'desc')->get();

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

        $landslides = DB::table('tbl_landslide')->whereBetween('date', array($fromDate, $toDate))->get();

      }else{

        $landslides = DB::table('tbl_landslide')->where('province_id','=',$post['inputreportgen'])->whereBetween('date', array($fromDate, $toDate))->get();

      }

      

      return view('pages.landslidereports')->with('datadate',$datadate)->with(['users' => $users,'provinces' => $provinces,'landslides' => $landslides]);

   }

}

