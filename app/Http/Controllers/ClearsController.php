<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Clears;
use App\Models\Municipality;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;

class ClearsController extends Controller
{
    
    public function save(Request $request){
        $rules = [
            "municipality_id"=>'required|numeric',
            "survey_date"=>'required|date',
            "survey_latitude"=>'required|numeric',
            "survey_longitude"=>'required|numeric',
            "vFactor"=>'required|numeric|min:1|max:2.5|in:1,1.1,1.2,1.5,2,2.5',
            "fFactor"=>'required|numeric|min:0.5|max:1.2|in:0.5,0.7,1.2',
            "frequency_id"=>'required|numeric|min:0|max:5',
            "sRating"=>'required|numeric|min:5|max:100|in:5,8,10,13,15,25,30,45,100',
            "material_id"=>'required|string',
            "sRed"=>'integer|min:0|max:2|required_without:rain|required_with:dRed',
            "dRed"=>'integer|min:0|max:2|required_without:rain|required_with:sRed',
            "drain_id"=>'integer|min:1|max:5|required_without:rain|required_with:dRed',
            "rain"=>'integer|min:0|max:4|in:0,2,3,4|required_without_all:sRed,dRed',
            "lFactor"=>'required|numeric|min:1|max:1.4|in:1,1.25,1.4',
            "land_id"=>'required|numeric|min:1|max:8',
            "alphaRating"=>'required|integer|min:2|max:100|in:2,5,10,17,32,100',
            "Fs"=>'required|numeric',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->passes()) {
            if($request->header('Authorization') != null ){
                $token = $request->header('Authorization');
                $user = User::where('c_token',$token)->get()->first();
                if($user != null){
                    $make = Clears::create([
                        "municipality_id"=>$request->input("municipality_id"),
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
                    ]);
                    if($make->wasRecentlyCreated){
                        session_unset();
                        Auth::logout();
                        Session::flush();
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
        $res = Clears::get();
        $munis = Municipality::get();
        return view('pages.viewclears',compact('res','munis'));
        // return response()->json(["res"=]);
    }
}
