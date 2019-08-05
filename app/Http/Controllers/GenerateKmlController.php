<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use DB;
use App\Services\Generatekmlservice;
class GenerateKmlController extends Controller
{

	function __construct(Generatekmlservice $generatekml){
        $this->todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        $this->Fldrpth = 'contour/';
        $this->pthTmp = 'contour/csvtemplate/';
        $this->generatekml = $generatekml;
    }    
	
    public function postGenerate(){
        $this->generatekml->doAll();
    }
    public function viewpageGenerate(){    	
    	return view('pages.generatekml');
    }
    
}	
