<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use DB;
use Session;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Coordinates;
use App\Models\Province;
use App\Models\Municipality;
use Javascript;

class MunicipalityController extends Controller
{
    function __construct()
   {
      $this->middleware('auth');
   }

   public function destroymultipleMunicipality(Request $request){

      Municipality::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Municipality successfully deleted.';
      }else{
         $delmsg = $chk .' municipalities successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function viewMunicipality(){
         $municipality = DB::table('tbl_municipality')->orderBy('name', 'ASC')->orderBy('province_id', 'asc')->get();
         $provinces = DB::table('tbl_provinces')->get();
         return view('pages.viewmunicipality')->with(['municipality' => $municipality,'provinces' => $provinces]);
   }
   public function viewaddMunicipality(){
   		$provinces = DB::table('tbl_provinces')->get();
         return view ('pages.addmunicipality')->with(['provinces' => $provinces]);
   }
   public function saveMunicipality(Request $request)
   {
      $post = $request->all();
      $v = \Validator::make($request->all(),
         [  
            'municipality_name' => 'required',
            'province_id' => 'required',
         ]);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $municipality = array(
               'name' => $post['municipality_name'],
               'province_id' => $post['province_id'],
            );

         $i = DB::table('tbl_municipality')->insert($municipality);
         if($i > 0){
            Session::flash('message', 'Municipality successfully added');
            return redirect('viewmunicipality');
         }
      }
   }
   public function editMunicipality($id){
      $provinces = DB::table('tbl_provinces')->get();
      $row = DB::table('tbl_municipality')->where('id',$id)->first();
      return view ('pages.editmunicipality')->with(['row' => $row, 'provinces' => $provinces]);
   }
   public function updateMunicipality(Request $request)
   {
      $post = $request->all();
      $v = \Validator::make($request->all(),
         [  
            'municipality_name' => 'required',
            'province_id' => 'required',

         ]);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $municipality = array(
               'name' => $post['municipality_name'],
               'province_id' => $post['province_id'],
            );

         $i = DB::table('tbl_municipality')->where('id',$post['id'])->update($municipality);
         if($i >= 0){
            \Session::flash('message', 'Municipality successfully updated');
            return redirect('viewmunicipality');
         }
      }
   }
   public function destroyMunicipality($id){
       $i = DB::table('tbl_municipality')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Municipality successfully deleted');
         return redirect('viewmunicipality');
      }
   }
}
