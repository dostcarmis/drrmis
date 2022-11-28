<?php

namespace App\Http\Controllers;

use App\Models\Fires;
use App\Models\User;
use App\Models\Floods;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Image;
use Response;

class FiresController extends Controller
{
    public function viewaddFire(){
        $users = User::get();
        $provinces = Province::get();
        $municipalities = Municipality::orderBy('name','asc')->get();
        return view('pages.addfire')->with(compact('municipalities'));
    }
    public function uploadFireImages(){
        $input = Input::all();        
        $rules = array(
            'file' => 'image|max:8000',
        );
        $validation = \Validator::make($input, $rules);
        if ($validation->fails()) {
            return response()->json(["success"=>false]);;
        } 

        $destinationPath = 'files/1/Fire Images'; 
        $destinthumb = 'files/1/Fire Images/thumbs'; 
        $extension = Input::file('file')->getClientOriginalExtension();
        $name = Input::file('file')->getClientOriginalName();
        $img = Image::make(Input::file('file'));
        $img->fit(200, 200);
        $img->save($destinthumb.'/'.$name);
        $fileName = $name. '.' . $extension; 
        $upload_success = Input::file('file')->move($destinationPath, $name);
        if ($upload_success) {
            // return response()->json(["success"=>true]);
            return Response::json('success', 200);
        } else {
            // return response()->json(["success"=>false]);
            return Response::json('error', 400);
        }
    }
    public function savefire(Request $request){ 
        $cntUser = Auth::user();
        $post = $request->all();
        $reportstat = '';
        $fireimages = "";
        if($post['fireimages'] == "fireimages[]"){$fireimages = "";}
        else{
            $fireimages = explode('-@,', rtrim($post['fireimages'], '-@,'));
            $fireimages = serialize($fireimages);
        }
        $rules = [
            'date' => 'required|before:'.date('Y-m-d'),
            'municipality' => 'required|min:1',
            'description'=>'required',
            'casualties'=>'required',
            'damages'=>'required',
            'latitude'=>'required',
            'longitude'=>'required',
            'reportedby'=>'required',
            'type'=>'required'
        ];
        $messages = [
            'date.required' => 'Date required',
            'municipality.required' => 'Municipality is required',
            'description.required'=>'Description is required',
            'casualties.required'=>'Casualties is required',
            'damages.required'=>'Damages is required',
            'latitude.required'=>'Latitude is required',
            'longitude.required'=>'Longitude is required',
            'reportedby.required'=>'Reporter name is required',
            'type.required'=>'Type of fire is required',
        ];
        $v = \Validator::make($request->all(), $rules, $messages);
        if($v->fails()){
            $errors = [];
            foreach($v->errors()->toArray() as $e){
                $errors[] = $e;
            }
            return response()->json(["errors"=>$errors]);
        }
        else{
            if($cntUser->role_id != 5){
                $reportstat = 'Published';
            }elseif($cntUser->role_id == 5){
                $reportstat = 'Pending';
            }
            $province_id = Municipality::where('id',$post['municipality'])->get()->first()->province_id;
            $i = Fires::create([
                "uploader_id"=>Auth::user()->id ,
                "date"=> $post['date'],
                "incident_images"=> $fireimages,
                "description"=> $post['description'],
                "casualties"=> $post['casualties'],
                "damages"=> $post['damages'],
                "latitude"=> $post['latitude'],
                "longitude"=> $post['longitude'],
                "reportedby"=> $post['reportedby'],
                "province_id"=> $province_id,//$post['province_id'],
                "municipality_id"=> $post['municipality'],
            ]);
            
            if($i){
                $cntUser->activityLogs($request, $msg = "Added a fire report");
                return response()->json(["msg"=>"Successfully added a fire report",'success'=>true]);
            }
        }
    }
}
