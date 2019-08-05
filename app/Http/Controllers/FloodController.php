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

      $floods = DB::table('tbl_incidents')
                  ->where('report_status','=','Published')
                  ->where('incident_type','=',2)
                  ->orderBy('created_at', 'desc')->paginate(4);

      return view('pages.viewmultiplefloods')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'floods' => $floods]);

    }

    public function viewperFlood($id){



      $municipalities = DB::table('tbl_municipality')->get();

      $users = DB::table('users')->get();

      $provinces = DB::table('tbl_provinces')->get();

      $floods = DB::table('tbl_incidents')->where('id',$id)->first();

    return view('pages.viewperflood')->with(['users' => $users,'municipalities' => $municipalities,'provinces' => $provinces,'floods' => $floods]);

   }

    public function viewFloods(){

      $cntUser = Auth::user(); 

      $provinces = DB::table('tbl_provinces')->get();

      $users = DB::table('users')->get();

      $floods = DB::table('tbl_incidents')
                  ->where('report_status','=','Published')
                  ->where('incident_type','=',2)
                  ->orderBy('date', 'desc')->get(); 

    	return view('pages.viewfloods')->with(['users' => $users,'floods' => $floods,'provinces' => $provinces]);

    }

    public function editFlood($id){

    	$users = DB::table('users')->get();

    	$floods = DB::table('tbl_incidents')->where('id',$id)->first();

      $provinces = DB::table('tbl_provinces')->get();

    	return view('pages.editflood')->with(['users' => $users,'provinces' => $provinces,'floods' => $floods]);

    }

    public function updateFlood(Request $request)

   	{

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

               'location' => $post['location'],

               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'flood_images' => $floodimages,

               'latitude' => $post['latitude'],

               'longitude' => $post['longitude'],

               'location' => $post['location'],

               'province_id' => $post['province_id'],

               'author' => $post['author'],

               'updated_at' => $datenow,

               'updated_by' => $cntUser->id,

               'report_status' => $post['report_status'],

            );



        }elseif($cntUser->role_id == 5){

          $row = array(

               'location' => $post['location'],

               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'flood_images' => $floodimages,

               'latitude' => $post['latitude'],

               'longitude' => $post['longitude'],

               'location' => $post['location'],

               'province_id' => $post['province_id'],

               'author' => $post['author'],

               'updated_at' => $datenow,

               'updated_by' => $cntUser->id,

            );

        }   

         



         $i = DB::table('tbl_flood')->where('id',$post['id'])->update($row);

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

       $i = DB::table('tbl_flood')->where('id',$id)->delete();

       if($i > 0)

      {

         \Session::flash('message', 'Flood report successfully deleted');

         return redirect('viewfloods');

      }

   }



   public function viewaddFlood(){



	    $users = DB::table('users')->get();

		  $floods = DB::table('tbl_flood')->get();

      $provinces = DB::table('tbl_provinces')->get();



		return view('pages.addflood')->with(['provinces' => $provinces,'users' => $users,'floods' => $floods]);

   }

   public function saveFlood(Request $request)

   	{          

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

               'location' => $post['location'],

               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'flood_images' => $floodimages,

               'province_id' => $post['province_id'],

               'latitude' => $post['latitude'],

               'longitude' => $post['longitude'],

               'user_id' => $cntUser->id,

               'author' => $post['author'],

               'report_status' => 'Published',

               'user_municipality' => $cntUser->municipality_id

            );

        }elseif($cntUser->role_id == 5){

          $row = array(

               'location' => $post['location'],

               'description' => $post['description'],

               'date' => $date,

               'location' => $post['location'],

               'flood_images' => $floodimages,

               'province_id' => $post['province_id'],

               'latitude' => $post['latitude'],               

               'longitude' => $post['longitude'],

               'user_id' => $cntUser->id,

               'author' => $post['author'],

               'report_status' => 'Pending',

               'user_municipality' => $cntUser->municipality_id

            );

        }

         



         $i = DB::table('tbl_flood')->insert($row);

         if($i > 0){

            Session::flash('message', 'Flood Report successfully added');

            return redirect('viewfloods');

         }

      }

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

      $floods = DB::table('tbl_flood')->orderBy('date', 'desc')->get();

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

        $floods = DB::table('tbl_flood')->whereBetween('date', array($fromDate, $toDate))->get();

      }else{

        $floods = DB::table('tbl_flood')->where('province_id','=',$post['inputreportgen'])->whereBetween('date', array($fromDate, $toDate))->get();

      }

      

      return view('pages.floodreports')->with('datadate',$datadate)->with(['users' => $users,'provinces' => $provinces,'floods' => $floods]);

   }

}

