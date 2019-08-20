<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SitrepController extends Controller
{
    public function viewsitreps(){
        return view('pages.maintenancepage');
    }
        //return view('pages.addfile')
}
