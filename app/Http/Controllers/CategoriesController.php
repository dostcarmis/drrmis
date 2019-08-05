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

class CategoriesController extends Controller
{
    function __construct()
   {
      $this->middleware('auth');
   }
   public function destroymultipleCategories(Request $request){

      Category::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Category successfully deleted.';
      }else{
         $delmsg = $chk .' categories successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   public function viewCategories(){
   		$categories = DB::table('tbl_categories')->orderBy('id', 'asc')->get();
   		return view('pages.viewcategories')->with(['categories' => $categories]);
   }
   public function viewaddCategories(){
   		return view ('pages.addcategories');
   }
   public function saveCategory(Request $request)
   {
   	$post = $request->all();
       $rules = [
        'category_name' => 'required',
    ];
    $messages = [
        'category_name.required' => 'Category field is required',
    ];
    $v = \Validator::make($request->all(), $rules, $messages);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $categories = array(
               'name' => $post['category_name'],
            );

         $i = DB::table('tbl_categories')->insert($categories);
         if($i > 0){
            Session::flash('message', 'Category successfully added');
            return redirect('viewcategories');
         }
      }
   }
   public function editCategory($id){
      $row = DB::table('tbl_categories')->where('id',$id)->first();
      return view ('pages.editcategories')->with(['row' => $row]);
   }
   public function updateCategory(Request $request)
   {
      $post = $request->all();
      $v = \Validator::make($request->all(),
         [  
            'category_name' => 'required',

         ]);
      if($v->fails())
      {
         return redirect()->back()->withErrors($v->errors());
      }else{
         $categories = array(
               'name' => $post['category_name'],
            );

         $i = DB::table('tbl_categories')->where('id',$post['id'])->update($categories);
         if($i >= 0){
            \Session::flash('message', 'Category successfully updated');
            return redirect('viewcategories');
         }
      }
   }
   public function destroyCategory($id){
       $i = DB::table('tbl_categories')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Category successfully deleted');
         return redirect('viewcategories');
      }
   }
}
