<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;


use Session;
use App\Models\User;
use App\Models\Incidents;
use DB;
use Carbon\Carbon;
use Auth;
use App\Services\Checkfornotification;
use Illuminate\Support\Facades\Input;
use Response;
use Image;
use Illuminate\Support\Str;
use File;
class IncidentsController extends Controller
{
    public function viewIncidents(Request $request){  	
		$cntUser = Auth::user(); 
		$users = DB::table('users')->get();
		$provinces = DB::table('tbl_provinces')->get();
		$incidents = DB::table('tbl_incidents')->orderBy('date', 'desc')->get();
		$hazards = DB::table('tbl_hazardslib')->get();
		$incidentcontent = [];
		$incidentcount = 0;
		$headcheckbox = '<input type="checkbox" class="headcheckbox">';
		

		foreach($incidents as $incident){
			$chkbx = '';
			$title = '';
			$belowtitle = '';
			$belowtitle1 = '';
			$hazardName = '';
			$provName = '';
			$notpublished = '';
			if (($cntUser->id == $incident->created_by) || ($cntUser->role_id <= 3)) {
				$chkbx = '<input class="chbox" name="chks[]" value="'.$incident->id.'"  type="checkbox">';
				$title = '<a class="desctitle" href="'.url('editincident').'/'.$incident->slug.'">'.$incident->location.'</a>';
			}
			else{
				$chkbx = '<input  type="checkbox" disabled>';
				$title = '<a class="desctitle" href="'.url('incident').'/'.$incident->slug.'">'.$incident->location.'</a>';
			}
			if(($cntUser->id == $incident->created_by) || ($cntUser->role_id <= 3)){
				$belowtitle1 = '<a href="'.url('editincident').'/'.$incident->slug.'">Edit</a> | <a class="deletepost" href="#" id="'.$incident->id.'" data-type="incidents" value="'.$incident->id.'" title="Delete">Delete</a> |';
			}

			if($incident->report_status != "Published"){
				$notpublished = '<span class="repstat">— '.$incident->report_status.'</span>';
			}

			foreach($hazards as $hazard){
				if($hazard->id == $incident->incident_type){
					$hazardName = $hazard->name;
				}
			}
			foreach($provinces as $province){
				if($province->id == $incident->province_id){
					$provName = $province->name;			
				}
			}
			$belowtitle = $notpublished.'<span class="defsp spactions"><div class="inneractions">'.$belowtitle1.'<a href="'.url('incident').'/'.$incident->slug.'">Preview</a></div></span>';
			$fnaltitle = $title.$belowtitle;
			$incidentContent['data'][$incidentcount++] = array(
				$chkbx,$fnaltitle,$hazardName,$provName,$incident->latitude,$incident->longitude,$incident->author,date("F j, Y g:i A", strtotime($incident->date))
            );
		}
		
		$jsonIncident = json_encode($incidentContent);
		$dirIncident = 'json/hydrometcontent/incidents.json'; 
		File::put($dirIncident,$jsonIncident);

		if($request->ajax()){

			return response()->file($dirIncident);
	    }	

	   	return view('pages.viewincidents')->with(['incidents' => $incidents]);

    }

	public function editIncident($slug){
		$users = DB::table('users')->get();
		$incidents = DB::table('tbl_incidents')->where('slug',$slug)->first();
		$provinces = DB::table('tbl_provinces')->get();
		$hazards = DB::table('tbl_hazardslib')->get();
		return view('pages.editincident')->with(['users' => $users,'provinces' => $provinces,'incidents' => $incidents,'hazards' => $hazards]);
	}
	public function viewaddIncident(){
		$users = DB::table('users')->get();
		$incidents = DB::table('tbl_incidents')->orderBy('id', 'asc')->get();
		$provinces = DB::table('tbl_provinces')->get();
		$hazards = DB::table('tbl_hazardslib')->get();
		return view('pages.addincident')->with(['users' => $users,'incidents' => $incidents,'provinces' => $provinces,'hazards' => $hazards]);
	}
	
	public function viewperIncident($slug){
		$hazards = DB::table('tbl_hazardslib')->get();
		$users = DB::table('users')->get();
		$provinces = DB::table('tbl_provinces')->get();
		$incidents = DB::table('tbl_incidents')->where('slug',$slug)->first();
		return view('pages.viewperincident')->with(['users' => $users,'provinces' => $provinces,'incidents' => $incidents,'hazards' => $hazards]);
	}	
	public function destroyIncident($id){
       $i = DB::table('tbl_incidents')->where('id',$id)->delete();
       if($i > 0)
      {
         \Session::flash('message', 'Incident report successfully deleted');
         return redirect('incidents');
      }
   }
	
	public function saveIncident(Request $request)
	{
		$cntUser = Auth::user();
		$post = $request->all();
		$input = Input::all();
		$reportstat = '';
		$incidentimages = "";
		$fslug = "";


		$slug = Str::slug($post['location'],'-');
		$slugs = DB::table('tbl_incidents')->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'");
		if ($slugs->count() != 0) { 
        	$lastSlugNumber = intval(str_replace($slug . '-', '', $slugs->orderBy('slug', 'desc')->first()->slug)); 
    		$fslug = $slug . '-' . ($lastSlugNumber + 1);

        }else{

        	$fslug = $slug;

        } 
    
		if($post['incidentimages'] == "incidentimages[]"){
			$incidentimages = "";
		}else{
			$incidentimages = explode('-@,', rtrim($post['incidentimages'], '-@,'));
			$incidentimages = serialize($incidentimages);
		}
		$rules = [
			'location' => 'required',
			'author' => 'required',
			'optprovince' => 'required',
		];
		$messages = [
			'location.required' => 'Location field is required',
			'author.required' => 'Source field is required',
			'optprovince.required' => 'Province field is required'
		];
		$v = \Validator::make($request->all(), $rules, $messages);

		if($v->fails())
		{
			return redirect()->back()->withErrors($v->errors());
			
		}else{

			$date = Carbon::createFromFormat('Y-m-d H:i', $post['date'])->toDateTimeString();
			if($cntUser->role_id != 5){
				$reportstat = 'Published';				
			}elseif($cntUser->role_id == 5){
				$reportstat = 'Pending';	
			}
			$row = array(
				'slug' => $fslug,
				'incident_type' => $post['hazard_id'],
				'date' => $date,
				'location' => $post['location'],
				'incident_images' => $incidentimages,	
				'province_id' => $post['optprovince'],
				'latitude' => $post['latitude'],
				'longitude' => $post['longitude'],
				'description' => $post['description'],
				'created_by' => $cntUser->id,
				'author' => $post['author'],
				'user_municipality' => $cntUser->municipality_id,
				'report_status' => $reportstat,	
			);

			$i = DB::table('tbl_incidents')->insert($row);

			if($i > 0){
				Session::flash('message', 'Incident Report successfully added');
				return redirect('incidents');
			}
		}
	}
	public function updateIncident(Request $request)
	{
		$cntUser = Auth::user();
		$post = $request->all();
		$input = Input::all();
		$reportstat = '';
		$incidentimages = "";
		$fslug = "";


		$slug = Str::slug($post['location'],'-');
		$slugs = DB::table('tbl_incidents')->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'");
		if ($slugs->count() != 0) { 
        	$lastSlugNumber = intval(str_replace($slug . '-', '', $slugs->orderBy('slug', 'desc')->first()->slug)); 
    		$fslug = $slug . '-' . ($lastSlugNumber + 1);

        }else{

        	$fslug = $slug;

        } 
    
		if($post['incidentimages'] == "incidentimages[]"){
			$incidentimages = "";
		}else{
			$incidentimages = explode('-@,', rtrim($post['incidentimages'], '-@,'));
			$incidentimages = serialize($incidentimages);
		}
		$rules = [
			'location' => 'required',
			'author' => 'required',
		];
		$messages = [
			'location.required' => 'Location field is required',
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
				$reportstat = 'Published';				
			}elseif($cntUser->role_id == 5){
				$reportstat = 'Pending';	
			}
			$row = array(

				'slug' => $fslug,
				'incident_type' => $post['hazard_id'],
				'updated_at' => $datenow,
				'date' => $post['date'],
				'location' => $post['location'],
				'incident_images' => $incidentimages,	
				'province_id' => $post['optprovince'],
				'latitude' => $post['latitude'],
				'longitude' => $post['longitude'],
				'description' => $post['description'],
				'updated_by' => $cntUser->id,
				'author' => $post['author'],
				'report_status' => $reportstat,	

			);

			$i = DB::table('tbl_incidents')->where('id',$post['id'])->update($row);
				if($i > 0){
					Session::flash('message', $post['location'].' successfully updated');
					return redirect('incidents');
				}
		}
	}
	public function uploadIncidentimage(){
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
        } else {
            return Response::json('error', 400);
        }
   }
   public function destroymultipleIncidents(Request $request){

      Incidents::destroy($request->chks);
      $chk = count($request->chks);
      if($chk == 1){
         $delmsg = 'Incident successfully deleted.';
      }else{
         $delmsg = $chk .' incidents successfully deleted.';
      }
      
      \Session::flash('message',  $delmsg);
      return redirect()->back();

   }
   public function generateKml(Request $request){
		$incidents = DB::table('tbl_incidents')->get();

		foreach ($incidents as $incident) {
			$slug = Str::slug($incident->location,'-');
			$slugs = DB::table('tbl_incidents')->whereRaw("slug REGEXP '^{$slug}(-[0-9]*)?$'");
			$fslug = "";
			if ($slugs->count() != 0) { 
	        	$lastSlugNumber = intval(str_replace($slug . '-', '', $slugs->orderBy('slug', 'desc')->first()->slug)); 
	    		$fslug = $slug . '-' . ($lastSlugNumber + 1);
	        }else{
	        	$fslug = $slug;
	        } 	     
          $row = array(
               'slug' => $fslug,
            );       
          $incId = $incident->id;
         $i = DB::table('tbl_incidents')->where('id',$incId)->update($row);

        }
	}
}
