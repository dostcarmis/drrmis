<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;


use DB;
use Session;

use App\Models\Category;
use App\Models\Sensors;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Threshold;
use Illuminate\Support\Facades\Input;
use App\Models\User;
use App\Models\Notifval;
use App\Models\Notification;
use Response;
use Auth;
use App\Services\Getcsvdataapi;
use File;
use Javascript;

class HydrometController extends Controller
{
	public $arrtotals = [];
	public $filterprovince;
	public $filtercategory;
	public $todaypath;
	public $yesterday;
	public $test = [];
	public $assocfile;
	public $cummulativedate = [];
	public $getcsvdata;

	function __construct(Getcsvdataapi $getcsvdata){
		$this->todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
		$this->yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
		$this->lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
		$this->getcsvdata = $getcsvdata;
	}
	public function displayaccumulatedtwodays($path,$csv){
		$yesterdayfile = $this->assocfile."-".date('Ymd',strtotime("-1 days")).".csv";	
		$todayfile = $this->assocfile."-".date('Ymd').".csv";
		$lasttwodaysaccum = $this->getcsvdata->getaccum($path,$csv);					
		$yesterday = $this->getcsvdata->getfullaccum($this->yesterday,$yesterdayfile);
		$today = $this->getcsvdata->getfullaccum($this->todaypath,$todayfile);
		$total = $lasttwodaysaccum + $yesterday + $today;
		return $total;
	}	
	

	public function ajaxHydromet(){
		$sensortype = Input::get('sensortype');
		$pathToFile = '';
		if($sensortype == 'rain'){
			$pathToFile = 'json/hydrometcontent/raingauge.json';			
		}elseif($sensortype == 'stream'){
			$pathToFile = 'json/hydrometcontent/waterlvl.json';			
		}
		return response()->file($pathToFile);		
		
	}
	public function viewHydrometdatawaterlevel(Request $request){
		
		$waterData = $this->getcsvdata->postWaterlevelvalue();
		$data_=$waterData['data'];
		return $this->filterData($request,"waterData",$waterData,$data_,"viewhydrometdatawaterlevel");
		
	}
    public function viewHydrometdata(Request $request)
	{	
		$rainData = $this->getcsvdata->postRainvalue();	
		$data_=$rainData['data'];
		return $this->filterData($request,"rainData",$rainData,$data_,"viewhydrometdata");
	}
	public function filterData($request,$type,$data, $data_=[],$page){
		if(!empty($data_)){
			if($request->has('search') && trim($request->input('search')) != ''){
				$new_data = [];
				$term = strtolower(strip_tags(trim($request->input('search'))));
				foreach($data_ as $key=>$d){
					$address = strtolower($d['address']);
					$sensortype = strtolower($d['sensortype']);
					if(strpos($address,$term) !== false || strpos($sensortype,$term) !== false){
						$new_data[] = $d;
					}
				}
				$data['data'] = $new_data;
				return view('pages.'.$page.'_filtered')->with(["$type" => $data]);
			}else if($request->has('search') && trim($request->input('search')) == ''){
				$waterData['data'] = $data_;
				return view('pages.'.$page.'_filtered')->with(["$type" => $data]);
			}else
				return view('pages.'.$page)->with(["$type" => $data]);
		}
	}



	public function dashboard(){	
		$count = 0;
		$categories = DB::table('tbl_categories')->get();      
		$provinces = DB::table('tbl_provinces')->get();  	
		$thresholds = DB::table('tbl_threshold')->get(); 
		$municipalities = DB::table('tbl_municipality')->get();
		$landslides = DB::table('tbl_landslides')->orderBy('date', 'desc')->get();  	
		$floods = DB::table('tbl_floods')->orderBy('date', 'desc')->get(); 
		$roadnetworks = DB::table('tbl_roadnetworks')->orderBy('date', 'desc')->get();
		$users = DB::table('users')->get();  
		$sensors = DB::table('tbl_sensors')->whereIn('category_id', [1,2,3,4])->get();

        $mainarray = $this->getcsvdata->dashboardData();
           
		JavaScript::put([
            'mainarray' => $mainarray
        ]);
	        
		return view('pages.dashboard')->with(['roadnetworks' => $roadnetworks,'floods' => $floods,'landslides' => $landslides,'users' => $users,'mainarray' => $mainarray,'municipalities' => $municipalities,'thresholds' => $thresholds,'sensors' => $sensors,'provinces' => $provinces,'categories' => $categories]);
	}	
    public function viewperSensor(){
		$sensorid = Input::get('sensorid');
		$sensor = DB::table('tbl_sensors')->where('id','=',$sensorid)->first();
		$categories = DB::table('tbl_categories')->get();
		$provinces = DB::table('tbl_provinces')->get();      
		$municipalities = DB::table('tbl_municipality')->get();
		$todayfile = $this->getcsvdata->gettodaycsv($this->todaypath,$sensor->assoc_file);
		if (!empty($todayfile)) {
			$csvcontents = $todayfile;      		
		}else{
			$csvcontents = $this->getcsvdata->getyesterdaycsv($this->yesterday,$sensor->assoc_file);
		}
		JavaScript::put([
            'csvcontents' => $csvcontents,
        ]);
		return view ('pages.viewpersensor')->with(['municipalities' => $municipalities,'sensor' => $sensor, 'provinces' => $provinces,'categories' => $categories]);
   }
   
   
}
