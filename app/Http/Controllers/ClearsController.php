<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Clears;
use App\ClearsAudit;
use App\Models\Municipality;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ClearsController extends Controller
{
    
    public function save(Request $request){
        $rules = [
            "municipality_id"=>'required|numeric',
            "barangay_id"=>'required|numeric',
            "survey_date"=>'required|date',
            "survey_latitude"=>'required|numeric',
            "survey_longitude"=>'required|numeric',
            "vFactor"=>'required|numeric|min:1|max:2.5|in:1,1.1,1.2,1.5,2,2.5',
            "fFactor"=>'required|numeric|min:0.5|max:1.2|in:0.5,0.7,1.2',
            "frequency_id"=>'required|numeric|min:0|max:5',
            "sRating"=>'required|numeric|min:5|max:122|in:5,8,10,16,15,25,30,61,122',
            "material_id"=>'required|string',
            "sRed"=>'integer|min:0|max:2|required_without:rain|required_with:dRed',
            "dRed"=>'integer|min:0|max:2|required_without:rain|required_with:sRed',
            "drain_id"=>'integer|min:1|max:5|required_without:rain|required_with:dRed',
            "rain"=>'integer|min:0|max:4|in:0,2,3,4|required_without_all:sRed,dRed',
            "lFactor"=>'required|numeric|min:1|max:1.4|in:1,1.25,1.4',
            "land_id"=>'required|numeric|min:1|max:8',
            "alphaRating"=>'required|integer|min:2|max:100|in:2,5,10,17,32,100',
            "Fs"=>'required|numeric',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            if(Auth::check() ){
                $user = Auth::user();
                if($user != null){
                    $pic = null;
                    if($request->has('image')){
                        $pic = $user->id."-".$user->username.time().'.'.$request->image->extension();
                        $request->image->move(public_path('photos/clears'), $pic);
                    }
                    $make = Clears::create([
                        "municipality_id"=>$request->input("municipality_id"),
                        "barangay_id"=>$request->input("barangay_id"),
                        "user_id"=>$user->id,
                        "survey_date"=>$request->input("survey_date"),
                        "survey_latitude"=>$request->input("survey_latitude"),
                        "survey_longitude"=>$request->input("survey_longitude"),
                        "vFactor"=>$request->input("vFactor"),
                        "fFactor"=>$request->input("fFactor"),
                        "frequency_id"=>$request->input("frequency_id"),
                        "sRating"=>$request->input('sRating'),
                        "material_id"=>$request->input("material_id"),
                        "sRed"=>$request->input("sRed"),
                        "dRed"=>$request->input("dRed"),
                        "drain_id"=>$request->input('drain_id'),
                        "rain"=>$request->input("rain"),
                        "lFactor"=>$request->input("lFactor"),
                        "land_id"=>$request->input('land_id'),
                        "alphaRating"=>$request->input("alphaRating"),
                        "Fs"=>$request->input("Fs"),
                        "image"=>$pic
                    ]);

                    if($make->wasRecentlyCreated){
                        $res = Clears::where('deleted_at',null)->get();
                        $munis = Municipality::get();
                        $c_id = $make->id;
                        $log = ClearsAudit::create([
                            'user_id'=>$user->id,
                            'clears_id'=>$c_id,
                            'request'=>"CREATE",
                            'source'=>"WEB",
                            'remarks'=>"Added report"
                        ]);
                        return view('pages.viewclears_filtered',compact('res','munis'));
                    }else{
                        return response()->json(["success"=>false],500);
                    }
                }else{
                    return response()->json(["success"=>false,'msg'=>"Invalid user"],401);
                }
                
            }else{
                return response()->json(["success"=>false,'msg'=>"Invalid user"],401);
            }
        } else {
            return response()->json(["success"=>false,"error"=>$validator->errors()->all()],400);
        }
    }
    public function show(Request $request){
        $res = Clears::where('deleted_at',null)->get();
        $munis = Municipality::orderBy('name')->get();
        return view('pages.viewclears',compact('res','munis'));
        // return response()->json(["res"=]);
    }
    public function showAudit(Request $req){
        $res = ClearsAudit::get();
        return view('pages.viewclears_audit',compact('res'));
    }
    public function update(Request $req){
        $rules = [
            "clears_id"=>"required|numeric",
            "barangay_id"=>'numeric',
            "municipality_id"=>'required|numeric',
            "survey_date"=>'required|date',
            "survey_latitude"=>'required|numeric',
            "survey_longitude"=>'required|numeric',
            "vFactor"=>'required|numeric|min:1|max:2.5|in:1,1.1,1.2,1.5,2,2.5',
            "fFactor"=>'required|numeric|min:0.5|max:1.2|in:0.5,0.7,1.2',
            "frequency_id"=>'required|numeric|min:0|max:5',
            "sRating"=>'required|numeric|min:5|max:122|in:5,8,10,16,15,25,30,61,122',
            "material_id"=>'required|string',
            "sRed"=>'integer|min:0|max:2|required_without:rain|required_with:dRed',
            "dRed"=>'integer|min:0|max:2|required_without:rain|required_with:sRed',
            "drain_id"=>'integer|min:1|max:5|required_without:rain|required_with:dRed',
            "rain"=>'integer|min:0|max:4|in:0,2,3,4|required_without_all:sRed,dRed',
            "lFactor"=>'required|numeric|min:1|max:1.4|in:1,1.25,1.4',
            "land_id"=>'required|numeric|min:1|max:8',
            "alphaRating"=>'required|integer|min:2|max:100|in:2,5,10,17,32,100',
            "Fs"=>'required|numeric',
            'image' => 'image|mimes:jpg,png,jpeg|max:2048',
        ];
        $validator = Validator::make($req->all(), $rules);
        $user = Auth::user();
        $user_id = $user->id;
        $report = Clears::findOrFail($req->input('clears_id'));
        $collection = $report;
        
        
        if($report->user_id == $user_id){
            if(is_numeric($req->input("Fs"))){
                $pic= $report->image;
                if($req->has('image')){
                    if($pic != null){
                        $old = public_path('photos/clears/'.$pic);
                        if(File::exists($old)){
                            File::delete($old);
                        }
                    }
                    $pic = $user->id."-".$user->username.time().'.'.$req->image->extension();
                    $req->image->move(public_path('photos/clears'), $pic);
                    
                    
                }
                if($req->input('del-image') == 'true'){
                    if($pic != null){
                        $old = public_path('photos/clears/'.$pic);
                        if(File::exists($old)){
                            File::delete($old);
                        }
                    }
                    $pic = null;
                }
                $req['image'] = $pic;
                $dirty = Clears::dirty($report,$req);
                $in = [
                    'barangay_id' =>$req->has('barangay_id')? $req->input('barangay_id'): null,
                    "municipality_id"=>$req->input("municipality_id"),
                    "survey_date"=>date("Y-m-d",strtotime($req->input("survey_date"))),
                    "survey_latitude"=>$req->input("survey_latitude"),
                    "survey_longitude"=>$req->input("survey_longitude"),
                    "vFactor"=>$req->input("vFactor"),
                    "fFactor"=>$req->input("fFactor"),
                    "frequency_id"=>$req->input("frequency_id"),
                    "sRating"=>$req->input("sRating"),
                    "material_id"=>$req->input("material_id"),
                    "sRed"=>$req->input("sRed"),
                    "dRed"=>$req->input("dRed"),
                    "drain_id"=>$req->input("drain_id"),
                    "rain"=>$req->input("rain"),
                    "lFactor"=>$req->input("lFactor"),
                    "land_id"=>$req->input("land_id"),
                    "alphaRating"=>$req->input("alphaRating"),
                    "Fs"=>$req->input("Fs"),
                    "image"=>$pic
                ];
                // if($req->has('barangay_id')){
                //     $in['barangay_id'] = $req->input('barangay_id');
                // }
                $update = $report->update($in);
                if($update){
                    $report = $report->toArray();
                    if($req->has('barangay_id')){
                        $report['barangay_name'] = $collection->municipality->barangay($req->input('barangay_id'))->name;
                    }else{
                        $report['barangay_name'] = "";
                    }
                    $report["survey_date"]= date("Y-m-d",strtotime($collection->survey_date));
                    $report['municipality_name'] = $collection->municipality->name;
                    $report['province_name'] = $collection->province->name;
                    $report['material'] = $collection->slopeMaterial($collection->material_id);
                    $report['vegetation'] = $collection->vegetation($collection->vFactor);
                    $report['frequency'] = $collection->frequency($collection->frequency_id);
                    $report['springs'] = $collection->springs($collection->sRed);
                    $report['canals'] = $collection->canals($collection->dRed);
                    $report['rain_d'] = $collection->rain($collection->rain);
                    $report['land'] = $collection->land($collection->land_id);
                    $report['angle'] = $collection->slopeAngle($collection->alphaRating);
                    $report['stability'] = $collection->stability($collection->Fs);
                    $log = ClearsAudit::create([
                        'user_id'=>$user->id,
                        'clears_id'=>$req->input('clears_id'),
                        'request'=>"UPDATE",
                        'source'=>"WEB",
                        'remarks'=>$dirty
                    ]);
                    return response()->json(['success'=>true,'report'=>$report,'dirty'=>$dirty, 'update'=>$in]);
                }else{
                    return response()->json(['success'=>false,'msg'=>"Update Failed."]);
                }
            }else{
                return response()->json(['success'=>false,'msg'=>"Invalid Factor of Safety."]);
            }
            
        }else{
            return response()->json(['success'=>false,'msg'=>"Report does not belong to you."]);
        }
    }
    public function delete(Request $req){
        $rules = ["clears_id"=>"required|numeric"];
        $validator = Validator::make($req->all(), $rules);
        $user = Auth::user();
        $user_id = $user->id;
        $report = Clears::findOrFail($req->input('clears_id'));
        if($report->user_id == $user_id){
            $date = date("Y-m-d H:i:s");
            $delete = Clears::where('id',$req->input('clears_id'))->update(['deleted_at'=>$date]);
            if($delete){
                $log = ClearsAudit::create([
                    'user_id'=>$user->id,
                    'clears_id'=>$req->input('clears_id'),
                    'request'=>"DELETE",
                    'source'=>"WEB",
                    'remarks'=>"Deleted report"
                ]);
                return response()->json(['success'=>true]);
            }else{
                return response()->json(['success'=>false,'msg'=>"Delete Failed."]);
            }
        }else{
            return response()->json(['success'=>false,'msg'=>"Report does not belong to you."]);
        }
    }
    public function filter(Request $req){
        if($req->has('filter') && $req->input('filter') != null && $req->has('fs') && $req->input('fs') != null){
            $fs = $req->input('fs');
            if($req->input('filter') == 1){
                switch($fs){
                    case 1: $res = Clears::where('deleted_at',null)->get();break;
                    case 2: $res = Clears::where('deleted_at',null)->where('Fs','>=',1.2)->get();break;
                    case 3: $res = Clears::where('deleted_at',null)->where('Fs','>=',1)->where('Fs','<',1.2)->get();break;
                    case 4: $res = Clears::where('deleted_at',null)->where('Fs','>=',0.7)->where('Fs','<',1)->get();break;
                    case 5: $res = Clears::where('deleted_at',null)->where('Fs','<',0.7)->get();break;
                    default: $res = Clears::where('deleted_at',null)->get();break;
                }
                
            }else{
                $uid = Auth::user()->id;
                $res = Clears::where('deleted_at',null)->where('user_id',$uid);
                switch($fs){
                    case 1: $res = $res->get();break;
                    case 2: $res = $res->where('Fs','>=',1.2)->get();break;
                    case 3: $res = $res->where('Fs','>=',1)->where('Fs','<',1.2)->get();break;
                    case 4: $res = $res->where('Fs','>=',0.7)->where('Fs','<',1)->get();break;
                    case 5: $res = $res->where('Fs','<',0.7)->get();break;
                    default: $res = $res->get();break;
                }
            }
            $munis = Municipality::get();
            return view('pages.viewclears_filtered',compact('res','munis'));
        }else{
            return response()->json(['msg'=>'Invalid filter value.']);
        }
    }
    public function logout(Request $request){
        if($request->header('Authorization') != null ){
            $token = $request->header('Authorization');
            $user = User::where('c_token',$token)->get()->first();
            $update = $user->update(['c_token'=>null]);
            if($update){
                return response()->json(["success"=>true],200);
            }
        }
    }
}
