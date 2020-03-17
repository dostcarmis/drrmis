<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SitrepController extends Controller
{
    public function mainviewsitreps(){
        return view('pages.mainmainviewsitreps');
    }

    public function savesitrepfile(Request $request){

        $post = $request->all();
        $cntUser = Auth::user();
        $username = $cntUser->first_name;
        $namedata = First_name::find($username);

        $rules = [
            'sitreptoupload' => 'required|mimes:pdf,docx,jpg', 
        ];

        $validate = \Validator::make($request->all(), $rules);

        if($validate->fails()){
            return redirect()->back()->withErrors($validate->errors());
        }else{
            $file = $request->file('sitreptoupload');
            $filename = $file->getClientOriginalName();
            $fileextension = $file->getClientOriginalExtension();
            $originalNameNoExtension = substr($filename, 0, strlen($filename) - strlen($fileextension) - 1);
            

        }

    }

        
}
