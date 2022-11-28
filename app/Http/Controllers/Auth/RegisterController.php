<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }
    
    

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'username' => 'required|max:255|unique:users',
            'password'=> 'required|string|min:8|confirmed',
            'municipality_id' => 'required',
        ],[
            'municipality_id.required'  => 'Please Select Municipality',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {

        $username = str_replace(' ', '_', $data['first_name']);
        $username1 = substr($data['last_name'], 0, 1);

        $countuserexist = DB::table('users')
                ->where('email', '=', $data['email'])
                ->count();
        $countuserexistusername = DB::table('users')
                ->where('username', '=', $data['username'])
                ->count();
        
        if (($countuserexist < 1) || ($countuserexistusername < 1)) {
            $user = new User();
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->email = $data['email'];
            $user->username = $data['username'];
            $user->password = bcrypt($data['password']);
            $user->province_id = $data['province_id'];
            $user->municipality_id = $data['municipality_id'];
            $user->role_id = 4;
            $user->profile_img = url('assets/images/default.jpg');
            $user->save();

            $user->roles()->attach(Role::where('name', 'MDRRM')->first());
            
            $this->AppServiceCreatenewNotif->newAccountNotification($user->id,$user->municipality_id,$user->province_id);

            Auth::login($user);

            return $user;

        }else{
            return redirect()->back()->withErrors($v->errors());
        }
        
    }

    public function registerprovince()
    {
      $province = Input::get('cat_id');
      $items = Municipality::where('province_id', '=', $province)->get();
      return Response::json($items);      
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showRegistrationForm()
    {
        $provinces = DB::table('tbl_provinces')->get();
        $municipalities = DB::table('tbl_municipality')->get();

        if (property_exists($this, 'registerView')) {
            return view($this->registerView);
        }


        return view('auth.register')->with(['provinces' => $provinces,'municipalities' => $municipalities]);
    }
}
