<?php
 
namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use Response;
 
class OtherController extends Controller {
 
    public function index() {
        return view('pages.media-2');
    }
 
    public function uploadFiles() {
 
        $input = Input::all();
        
        $rules = array(
            'file' => 'image|max:3000',
        );
        $messages = [
            'file' => 'Location field is required',
        ];
        $validation = \Validator::make($input, $rules,$messages);
 
        if ($validation->fails()) {
            return Response::make($validation->errors()->all(), 400);
        }
 
        $destinationPath = 'files/1/'; // upload path

        $extension = Input::file('file')->getClientOriginalExtension(); // getting file extension
        $name = Input::file('file')->getClientOriginalName();
        $fileName = $name. '.' . $extension; // renameing image
        $upload_success = Input::file('file')->move($destinationPath, $name); // uploading file to given path
        if (($upload_success) || ($upload_success1)) {
            return Response::json('success', 200);
        } else {
            return Response::json('error', 400);
        }
    }
 
}