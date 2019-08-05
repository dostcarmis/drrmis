<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use DB;
use Session;
use App\Http\Requests;
use App\Models\Municipality;
use App\Models\Province;
use App\Models\User;
use App\Models\Roadnetwork;
use Auth;
use Carbon\Carbon;
class RoadController extends Controller
{

   public function viewRoadnetworks(){
      $cntUser = Auth::user(); 
      $users = DB::table('users')->get();

      if((Auth::user()->role_id == 1) || (Auth::user()->role_id == 2)){
         $roadnetworks = DB::table('tbl_roadnetworks')->orderBy('date', 'desc')->get();         
      }elseif((Auth::user()->role_id == 3) || (Auth::user()->role_id == 4)){
         $roadnetworks = DB::table('tbl_roadnetworks')->where('municipality_id','=',$cntUser->municipality_id)->orderBy('date', 'desc')->get();
      }elseif(Auth::user()->role_id == 5){
         $roadnetworks = DB::table('tbl_roadnetworks')->where('user_id','=',$cntUser->id)->where('municipality_id','=',$cntUser->municipality_id)->orderBy('date', 'desc')->get();
      }
   	return view('pages.viewroadnetworks')->with(['roadnetworks' => $roadnetworks,'users' => $users]);
   }
   public function viewRoadnetworksmonitoring(){
         $users = DB::table('users')->get();
         $roadnetworks = DB::table('tbl_roadnetworks')->where('report_status','=','Published')->orderBy('date', 'desc')->get();
         return view('pages.viewroadnetworksmonitoring')->with(['roadnetworks' => $roadnetworks,'users' => $users]);
   }
   public function searchRoadnetwork(Request $request){
      if($request->ajax()){
         $users = DB::table('users')->get();
         
         if($request->searchval != 'Recent'){
            $statok = DB::table('tbl_roadnetworks')->where('report_status','=','Published')->whereNotNull('latest_status');
         }else{
            $statok = DB::table('tbl_roadnetworks')->where('report_status','=','Published')->whereNull('latest_status');
         }

         $roadnetworks = $statok->where('status','like','%'.$request->searchroadnetwork.'%')       
         ->orWhere('date','like','%'.$request->searchroadnetwork.'%') 
         ->orWhere('location','like','%'.$request->searchroadnetwork.'%')  
         ->orWhere('author','like','%'.$request->searchroadnetwork.'%')          
               ->get();

         $output = "";
         $rolename ="";

         if($request->searchval != 'Recent'){
           foreach ($roadnetworks as $key => $roadnetwork) {
            foreach ($users as $user) {
               if($roadnetwork->user_id == $user->id){
                  $rolename =  $user->last_name;
               }
            }            
               $classother = $roadnetwork->latest_status;
               $classother  = strtolower(str_replace(' & ', '-', $classother));
               $classother  = strtolower(str_replace(' ', '-', $classother));
               
            $output .='<div class="col-xs-12 col-sm-12 col-sm-12 per-monitoring"><div class="col-xs-12 np per-monitoringwrap"><div class="col-xs-12 per-monitoringwrap-title"><div class="col-xs-6 np">'.
                  '<span class="defsp spstatus '.$classother.'">'.$roadnetwork->status.'</span></div>'.
                  '<div class="col-xs-6 np"><span class="defsp sptimeanddate">'.date("F j Y g:i A", strtotime($roadnetwork->date)).'</span></div></div>'.
                  '<div class="col-xs-12 per-monitoringwrap-details"><span class="defsp splocation">'.$roadnetwork->location.'</span>'.
                  '<span class="defsp spdesc">'.$roadnetwork->description.'</span></div>'.  
                  '<div class="col-xs-12 per-monitoring-blw">'.
                   '<span class="defsp">Old Status: <span>'.$roadnetwork->status.'</span></span>'.
                   '<span class="defsp">Date: <span>'.date("F j Y g:i A", strtotime($roadnetwork->date)).'</span></span></div>'.
                  '<div class="col-xs-12 per-monitoring-blw"><span>Source: <span>'.$roadnetwork->author.'</span></span> | <span>Uploaded by: <span>'.$rolename.'</span></span>'.
                  '</div></div></div>';        
             
           
         }
         }else{
              foreach ($roadnetworks as $key => $roadnetwork) {
               foreach ($users as $user) {
               if($roadnetwork->user_id == $user->id){
                  $rolename =  $user->last_name;
               }
            }            
               $class = $roadnetwork->status;
               $class  = strtolower(str_replace(' & ', '-', $class));
               $class  = strtolower(str_replace(' ', '-', $class));
               
            $output .='<div class="col-xs-12 col-sm-12 col-sm-12 per-monitoring"><div class="col-xs-12 np per-monitoringwrap"><div class="col-xs-12 per-monitoringwrap-title"><div class="col-xs-6 np">'.
                  '<span class="defsp spstatus '.$class.'">'.$roadnetwork->status.'</span></div>'.
                  '<div class="col-xs-6 np"><span class="defsp sptimeanddate">'.date("F j Y g:i A", strtotime($roadnetwork->date)).'</span></div></div>'.
                  '<div class="col-xs-12 per-monitoringwrap-details"><span class="defsp splocation">'.$roadnetwork->location.'</span>'.
                  '<span class="defsp spdesc">'.$roadnetwork->description.'</span></div>'.        
                  '<div class="col-xs-12 per-monitoring-blw"><span>Source: <span>'.$roadnetwork->author.'</span></span> | <span>Uploaded by: <span>'.$rolename.'</span></span>'.
                  '</div></div></div>';        
             
           
         }
         }     
               
         

         return Response($output);
      }
   }
   public function viewaddRoadnetwork(){
	  $users = DB::table('users')->get();
      return view('pages.addroadnetwork')->with(['users' => $users]);
   }
   public function editRoadnetwork($id){
	   $users = DB::table('users')->get();
      $roadnetworks = DB::table('tbl_roadnetworks')->where('id',$id)->first();
      return view ('pages.editroadnetwork')->with(['roadnetworks' => $roadnetworks,'users' => $users]);
   }
   public function saveRoadnetwork(Request $request)
   {
      $cntUser = Auth::user();   	
   	$post = $request->all();
      $rules = [
           'address' => 'required',
           'date' => 'required',
           'author' => 'required',
       ];
       $messages = [
           'address.required' => 'Location field is required',
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
               'location' => $post['address'],
               'date' => $date,
               'status' => $post['status'],
               'user_id' => $cntUser->id,
               'description' => $post['description'],
               'author' => $post['author'],
               'report_status' => 'Published',
               'municipality_id' => $cntUser->municipality_id
            );
         }elseif($cntUser->role_id == 5){
            $row = array(
               'location' => $post['address'],
               'date' => $date,
               'status' => $post['status'],
               'user_id' => $cntUser->id,
               'description' => $post['description'],
               'author' => $post['author'],
               'report_status' => 'Pending',
               'municipality_id' => $cntUser->municipality_id
            );
         }
         

         $i = DB::table('tbl_roadnetworks')->insert($row);
         if($i > 0){
            Session::flash('message', 'Road Report successfully added');
            return redirect('viewroadnetworks');
         }
      }
   }
   public function updateRoadnetwork(Request $request)
   {
      $cntUser = Auth::user();  
   	$post = $request->all();
      $rules = [
           'address' => 'required',
           'date' => 'required',
           'author' => 'required',
       ];
       $messages = [
           'address.required' => 'Location field is required',
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
           if($cntUser->role_id == 5){
            $row = array(
               'location' => $post['address'],
               'date' => $date,
               'status' => $post['status'],
               'description' => $post['description'],
               'updated_by' => $cntUser->id,
               'updated_at' => $datenow,
               'author' => $post['author'],
            );
            }else{
               $row = array(
                  'location' => $post['address'],
                  'date' => $date,
                  'latest_status' => $post['status'],
                  'recent_date' => $date,
                  'description' => $post['description'],
                  'updated_by' => $cntUser->id,
                  'updated_at' => $datenow,
                  'author' => $post['author'],
                  'report_status' => $post['report_status'],
               );
            }
            

         $i = DB::table('tbl_roadnetworks')->where('id',$post['id'])->update($row);
         if($i >= 0){
            \Session::flash('message', 'Province successfully updated');
            return redirect('viewroadnetworks');
         }else{
            Session::flash('message', 'Accident Report successfully updated');
            return redirect('viewaccidents');
         }
      }

   }
   public function destroyRoadnetwork($id){
       $i = DB::table('tbl_roadnetworks')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Road report successfully deleted');
         return redirect('viewroadnetworks');
      }
   }
   public function destroymultipleRoadnetworks(Request $request){
      Roadnetwork::destroy($request->chks);
      $chk = count($request->chks);
      if($chk === 1){
         $delmsg = 'Road report successfully deleted.';
      }else{
         $delmsg = $chk .' road reports successfully deleted.';
      }      
      \Session::flash('message',  $delmsg);
      return redirect()->back();
   }
   
}
