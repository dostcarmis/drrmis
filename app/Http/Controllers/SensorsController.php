<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;

use DB;
use Session;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Sensors;
use App\Models\Municipality;
use App\Models\Province;
use Javascript;
use Illuminate\Support\Facades\Input;
use Response;
class SensorsController extends Controller
{
   function __construct()
   {
      $this->middleware('auth');
   }
   private $filterprovince;
   private $filtercategory;

   public function destroymultipleSensors(Request $request){

      Sensors::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Sensor successfully deleted.';
      }else{
         $delmsg = $chk .' sensors successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function duplicate()
    {
      $province = Input::get('cat_id');
      $items = Municipality::where('province_id', '=', $province)->get();
      return Response::json($items);
      
    }
   
    public function duplicateedit($id){
      $province_id = Input::get('province_idedit');
      $items = Municipality::where('province_id', '=', $province_id)->get();
      return Response::json($items); 
      
    }
   public function viewaddSensor(){

      $categories = DB::table('tbl_categories')->get();      
      $provinces = DB::table('tbl_provinces')->get();
      $municipalities = DB::table('tbl_municipality')->get();
      return view('pages.addsensor')->with(['categories' => $categories, 'provinces' => $provinces,'municipalities' => $municipalities]);
   }
   public function viewSensor()
   {
      return $this->displayfiltersensors('default');
   }


   public function displayfiltersensors($displaytype){
         $categories = DB::table('tbl_categories')->get();
         $provinces = DB::table('tbl_provinces')->get();
         $municipalities = DB::table('tbl_municipality')->get();
      if($displaytype === 'default'){
         $sensors = DB::table('tbl_sensors')->orderBy('province_id', 'asc')->get();         
      }
      return view('pages.viewsensors')->with(['sensors' => $sensors, 'provinces' => $provinces,'categories' => $categories,'municipalities' => $municipalities]);
   }
   public function filterSensor(Request $request){
      $post = $request->all();
      if($post['sensortype'] != 0){
         $sensors = DB::table('tbl_sensors')->where('category_id','=', $post['sensortype'])->orderBy('address', 'asc')->get();
      }else{
         $users = DB::table('tbl_sensors')->orderBy('address', 'asc')->get();
      }
        $categories = DB::table('tbl_categories')->get();
         $provinces = DB::table('tbl_provinces')->get();
         $municipalities = DB::table('tbl_municipality')->get();

      return view('pages.viewsensors')->with(['sensors' => $sensors,'provinces' => $provinces,'categories' => $categories, 'municipalities' => $municipalities]);
   }
   public function destroySensor($id){
       $i = DB::table('tbl_sensors')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Sensor successfully deleted');
         return redirect('viewsensor');
      }
   }
   public function editSensor($id){
       $categories = DB::table('tbl_categories')->get();
       $provinces = DB::table('tbl_provinces')->get();
      $sensors = DB::table('tbl_sensors')->where('id',$id)->first();
      $municipalities = DB::table('tbl_municipality')->get();
      return view ('pages.editsensors')->with(['municipalities' => $municipalities,'sensors' => $sensors, 'provinces' => $provinces,'categories' => $categories]);
   }
   
   public function updateSensor(Request $request)
   {
      $post = $request->all();
      $rules = [
        'dev_id' => 'required',
        'address' => 'required',
        'province_idedit' => 'required',
        'municipality_idedit' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'remarks' => 'required',
       ];
       $messages = [
           'dev_id.required' => 'Device ID is required',
           'address.required' => 'Address field is required',
           'province_idedit.required' => 'Please Select Province',
           'municipality_idedit.required'  => 'Please Select Municipality',
           'latitude.required' => 'Latitude field is required',
           'longitude.required'  => 'Longitude field is required',
           'remarks.required'  => 'Remarks field is required',
       ];
       $v = \Validator::make($request->all(), $rules, $messages);

      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $sensors = array(
               'address' => $post['address'],
               'province_id' => $post['province_idedit'],
               'dev_id' => $post['dev_id'],
               'municipality_id' => $post['municipality_idedit'],
               'category_id' => $post['category_id'],               
               'latitude' => $post['latitude'],
               'longitude' => $post['longitude'],
               'assoc_file' => $post['assoc_file'],
               'updated_at' => date('Y-m-d H:i:s'),
               'remarks' => $post['remarks'],
            );

         $i = DB::table('tbl_sensors')->where('id',$post['id'])->update($sensors);
         if($i >= 0){
            \Session::flash('message', 'Sensor successfully updated');
            return redirect('viewsensor');
         }
      }
   }
  
   public function saveSensor(Request $request)
   {
    $post = $request->all();


      $rules = [
        'address' => 'required',
        'province_id' => 'required',
        'municipality_id' => 'required',
        'latitude' => 'required',
        'longitude' => 'required',
        'remarks' => 'required',
       ];
       $messages = [
           'address.required' => 'Address field is required',
           'province_id.required' => 'Please Select Province',
           'municipality_id.required'  => 'Please Select Municipality',
           'latitude.required' => 'Latitude field is required',
           'longitude.required'  => 'Longitude field is required',
           'remarks.required'  => 'Remarks field is required',
       ];
       $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $sensors = array(
               'address' => $post['address'],
               'category_id' => $post['category_id'],
               'province_id' => $post['province_id'],
               'dev_id' => $post['dev_id'],
               'municipality_id' => $post['municipality_id'],
               'latitude' => $post['latitude'],
               'longitude' => $post['longitude'],
               'remarks' => $post['remarks'],
            );

         $i = DB::table('tbl_sensors')->insert($sensors);
         if($i > 0){
            Session::flash('message', 'Sensor successfully added');
            return redirect('viewsensor');
         }
      }
   }

}
