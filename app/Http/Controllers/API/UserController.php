<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Auth;
use Validator;
use Lcobucci\JWT\Parser;

class UserController extends Controller {

    /**
    * login api
    *
    * @return \Illuminate\Http\Response
    */
    public function login(Request $request){
        $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 
                 'email' : 'username';
        $request->merge([$field => $request->input('login')]);
        $credentials = $request->only([$field, 'password']);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('GSMClient')->accessToken;
            return response()->json(['success' => $success], 200);
        } else {
            return response()->json(['error'=>'Unauthorised'], 401);
        }
    }

    /**
    * logout api
    *
    * @return \Illuminate\Http\Response
    */
    public function logout(Request $request, $id) { 
        $user = User::find($id);
        
        if ($user) {
            $user->AauthAcessToken()->delete();
            return response()->json(['success' =>'logout_success'],200); 
        } else {
            return response()->json(['error' =>'api.something_went_wrong'], 500);
        }
    }

    /**
     * details api
     *
     * @return \Illuminate\Http\Response
     */
    public function getUserInfo() {
        $user = Auth::user();
        return response()->json(['success' => $user], 200);
    }
}
