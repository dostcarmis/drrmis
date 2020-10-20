<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
    public function login(Request $request)
	{
        $user = new User;
        $uname = $request->login;  
        $msg = "Login attempt failed!"; 
        $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('login')]);
        
        if (\Auth::attempt($request->only($field, 'password')))
        {
            //$fullname = Auth::user()->getFullname();
            $msg = "Logged in!";  
            Auth::user()->activityLogs($request, $msg);
            return redirect('/dashboard');
        }
      
        $user->activityLogs($request, $msg);
        
        return redirect()->back()->withErrors([
            'error' => 'These credentials do not match our records.',
        ]);
    } 	
}
