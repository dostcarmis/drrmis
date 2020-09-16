<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{

     public function login(Request $request)
	{
        //dd($request->login);
    $user = new User;    
    $uname = $request->login;    
	$msg = "Successfully login";
	$field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
    $request->merge([$field => $request->input('login')]);
    if (\Auth::attempt($request->only($field, 'password')))
    {
        return redirect('/dashboard');
    }
    //dd(Auth::user());
    $user->activityLogs($request, $msg);
    return redirect()->back()->withErrors([
        'error' => 'These credentials do not match our records.',
    ]);
	} 
	 
	
}
