<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;

use DB;
use Session;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Coordinates;
use Javascript;
use App\Models\Province;

class ProvinceController extends Controller
{
    function __construct()
   {
      $this->middleware('auth');
   }
   public function destroymultipleProvinces(Request $request){
      Province::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Province successfully deleted.';
      }else{
         $delmsg = $chk .' provinces successfully deleted.';
      }      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function viewProvince(){
         $provinces = DB::table('tbl_provinces')->orderBy('name', 'asc')->get();
         return view('pages.viewprovince')->with(['provinces' => $provinces]);
   }
   public function viewaddProvince(){
         return view ('pages.addprovince');
   }
   public function saveProvince(Request $request)
   {
      $post = $request->all();
      $v = \Validator::make($request->all(),
         [  
            'province_name' => 'required',
         ]);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $province = array(
               'name' => $post['province_name'],
            );

         $i = DB::table('tbl_provinces')->insert($province);
         if($i > 0){
            Session::flash('message', 'Province successfully added');
            return redirect('viewprovince');
         }
      }
   }
   public function editProvince($id){
      $row = DB::table('tbl_provinces')->where('id',$id)->first();
      return view ('pages.editprovince')->with(['row' => $row]);
   }
   public function updateProvince(Request $request)
   {
      $post = $request->all();
      $v = \Validator::make($request->all(),
         [  
            'province_name' => 'required',

         ]);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $province = array(
               'name' => $post['province_name'],
            );

         $i = DB::table('tbl_provinces')->where('id',$post['id'])->update($province);
         if($i >= 0){
            \Session::flash('message', 'Province successfully updated');
            return redirect('viewprovince');
         }
      }
   }
   public function destroyProvince($id){
       $i = DB::table('tbl_provinces')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Province successfully deleted');
         return redirect('viewprovince');
      }
   }
}
