<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;

use App\Http\Requests;
use DB;
use Session;
use App\Models\Susceptibility;
use App\Models\Sensors;
use App\Models\Threshold;
use Auth;
class SusceptibilityController extends Controller
{
    function __construct()
   {
      $this->middleware('auth');

   }
   public function destroymultipleSusceptibility(Request $request){

      Threshold::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Hazard Assessment successfully deleted.';
      }else{
         $delmsg = $chk .' hazard assessments successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function viewSusceptibility(){
      $sensors = DB::table('tbl_sensors')->get();
      $susceptibility = DB::table('tbl_susceptibility')->orderBy('created_at', 'desc')->get();
      return view('pages.viewsusceptibility')->with(['susceptibility' => $susceptibility,'sensors' => $sensors]);
   }
   public function viewaddSusceptibility(){
      $sensors = DB::table('tbl_sensors')->get();
      return view ('pages.addsusceptibility')->with(['sensors' => $sensors]);
   }
   public function saveSusceptibility(Request $request)
   {
    $user = Auth::user();
    $post = $request->all();

  $tresexists = DB::table('tbl_susceptibility')->where('address_id', '=',$post['address_id'])->first();
      if ($tresexists == null) {
         $susceptibility = array(
               'address_id' => $post['address_id'],
               'susceptibility_flood' => $post['flood'],
               'susceptibility_landslide' => $post['landslide'],
               'user_id' => $user->id,
            );

         $i = DB::table('tbl_susceptibility')->insert($susceptibility);
         if($i > 0){
            Session::flash('message', 'Hazard Assessment successfully added');
            return redirect('viewsusceptibility');
         }
      }else{
         Session::flash('message', 'Hazard Assessment already exists!');
         return redirect()->back();
      }
      
   }
   public function editSusceptibility($id){
      $sensors = DB::table('tbl_sensors')->get();
      $susceptibility = DB::table('tbl_susceptibility')->where('id',$id)->first();
      return view ('pages.editsusceptibility')->with(['susceptibility' => $susceptibility,'sensors' => $sensors]);
   }
   public function updateSusceptibility(Request $request)
   {  $user = Auth::user();
      
         $post = $request->all();
         $susceptibility = array(
               'address_id' => $post['address_id'],
               'susceptibility_flood' => $post['flood'],
               'susceptibility_landslide' => $post['landslide'],
               'user_id' => $user->id,
               'updated_at' => date('Y-m-d H:i:s'),
            );

         $i = DB::table('tbl_susceptibility')->where('id',$post['id'])->update($susceptibility);
         if($i >= 0){
            \Session::flash('message', 'Hazard Assessment successfully updated');
            return redirect('viewsusceptibility');
         }
      
   }
   public function destroySusceptibility($id){
       $i = DB::table('tbl_susceptibility')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Hazard Assessment successfully deleted');
         return redirect('viewsusceptibility');
      }
   }
}
