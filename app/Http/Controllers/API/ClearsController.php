<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Clears;
use App\ClearsAudit;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;

class ClearsController extends Controller
{
    
    public function showLoginForm(Request $r){return view("api.clears.login");}  
    public function login(Request $request){
        // return response()->json(['res'=>$request->input('login')]);
        $re = $request->validate([
            'login' => 'required|string',
            'password' => 'required',
        ]);
        $msg = "Login attempt failed!"; 
        $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('login')]);
        
        if (\Auth::attempt($request->only($field, 'password')))
        {
            $user = Auth::user();
            $c_token = $user->c_token;
            if($c_token && $c_token != null && $c_token != ''){
                if($request->has('overwrite') && $request->input('overwrite') == 1){
                    $api_token = Str::random(80);
                    $user->c_token=$api_token;
                    $user->save();
                    $message = "Login Successful";
                    $success = true;
                    
                    $content = view('api.clears.success',compact('message','success','api_token'));
                    return response()->json(['message'=>$message])->withHeaders([
                        'Content-Type' => 'application/json',
                        'X-success'=>true,
                        'X-c_token'=>$api_token]);

                }else{
                    $message = "User already logged in on another device.";
                    $success = false;
                    $error = 1;
                    $content = view('api.clears.success',compact('message'));
                    return response()->json(['message'=>$message,'error'=>$error])->withHeaders([
                        'Content-Type' => 'application/json',
                        'X-success'=>$success,]);
                }
            }else{
                $api_token = Str::random(80);
                $user->c_token=$api_token;
                $user->save();
                $message = "Login Successful";
                $success = true;
                $content = view('api.clears.success',compact('message'));
                return response()->json(['message'=>$message])->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-success'=>true,
                    'X-c_token'=>$api_token]);
            }
        }
  
        return response()->json(["success"=>false,'error'=>2,'message'=>'Invalid login attempt']);
    }
    public function save(Request $request){
        $rules = [
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
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            if($request->header('Authorization') != null ){
                $token = $request->header('Authorization');
                $user = User::where('c_token',$token)->get()->first();
                if($user != null){
                    $pic = null;
                    if($request->has('image')){
                        $pic = $user->id."-".$user->username.time().'.'.$request->image->extension();
                        $request->image->move(public_path('photos/clears'), $pic);
                    }
                    $make = Clears::create([
                        "municipality_id"=>$request->input("municipality_id"),
                        "user_id"=>$user->id,
                        "survey_date"=>date('Y-m-d',strtotime($request->input("survey_date"))),
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
                        session_unset();
                        Auth::logout();
                        Session::flush();
                        $c_id = $make->id;
                        $log = ClearsAudit::create([
                            'user_id'=>$user->id,
                            'clears_id'=>$c_id,
                            'request'=>"CREATE",
                            'source'=>"WEB",
                            'remarks'=>"Added report"
                        ]);
                        $message = "Upload Successful";
                        return view('api.clears.success',compact('message'));
                    }else{
                        return response()->json(["success"=>false],500);
                    }
                }else{
                    return response()->json(["success"=>false,'token'=>$token],401);
                }
                
            }else{
                return response()->json(["success"=>false],401);
            }
        } else {
            return response()->json(["success"=>false,"error"=>$validator->errors()->all()],400);
        }
    }
    public function show(Request $request){
        if($request->header('Authorization') != null ){
            $token = $request->header('Authorization');
            $user = User::where('c_token',$token)->get()->first();
            if($user){
                $id = $user->id;
                return response()->json(["res"=>Clears::where('user_id',$id)->get()->toArray()]);
            }else{
                return response()->json(["success"=>false,"msg"=>"Token does not exist"],403);
            }
        }else{
            return response()->json(["success"=>false,"message"=>"Unauthorized"],401);
        }
        
    }
    public function logout(Request $request){
        if($request->header('Authorization') != null ){
            $token = $request->header('Authorization');
            $user = User::where('c_token',$token)->get()->first();
            if($user){
                $update = $user->update(['c_token'=>null]);
                if($update){
                    return response()->json(["success"=>true],200);
                }else{
                    return response()->json(["success"=>false,"message"=>"Not updated"],500);
                }
            }else{
                return response()->json(["success"=>false,"msg"=>"Token does not exist"],403);
            }
            
        }else{
            return response()->json(["success"=>false,"message"=>"Unauthorized"],401);
        }
    }
    public function delete(Request $req){
        $rules = ["clears_id"=>"required|numeric"];
        $validator = Validator::make($req->all(), $rules);
        if ($validator->passes()) {
            if($req->header('Authorization') != null ){
                $token = $req->header('Authorization');
                $user = User::where('c_token',$token)->get()->first();
                if($user != null){
                    $user_id = $user->id;
                    $report = Clears::find($req->input('clears_id'));
                    if($report && $report != null){
                        if($report->user_id == $user_id){
                            $date = date("Y-m-d H:i:s");
                            $delete = Clears::where('id',$req->input('clears_id'))->update(['deleted_at'=>$date]);
                            if($delete){
                                $log = ClearsAudit::create([
                                    'user_id'=>$user->id,
                                    'clears_id'=>$req->input('clears_id'),
                                    'request'=>"DELETE",
                                    'source'=>"MOBILE",
                                    'remarks'=>"Deleted report"
                                ]);
                                return response()->json(['success'=>true],200);
                            }else{
                                return response()->json(['success'=>false,'msg'=>"Delete Failed."],500);
                            }
                        }else{
                            return response()->json(['success'=>false,'msg'=>"Report does not belong to you."], 401);
                        }
                    }else{
                        return response()->json(['success'=>false,'msg'=>"Report does not exist."], 200);
                    }
                    
                    
                }
            }else{
                return response()->json(['success'=>false,'msg'=>"Unauthorized."], 401);
            }
        }else{
            return response()->json(['success'=>false,'msg'=>"Missing data."],400);
        }
        
    }

}
