<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\View\Middleware\ErrorBinder;

use DB;
use Session;
use DateTime;
use DateInterval;
use DatePeriod;
use App\Http\Requests;
use App\Models\Category;
use App\Models\Sensors;
use App\Models\Province;
use App\Models\Incidents;
use App\Models\Roadnetwork;
use App\Models\Municipality;
use App\Models\User;
use App\Models\Landslide;
use App\Models\Floods;
use App\Clears;
use App\Services\Getcsvdataapi;
use JavaScript;
class PagesController extends Controller
{   
    private $getcsvdata;
    function __construct(Getcsvdataapi $getcsvdata){
        $this->todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        $this->yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
        $this->lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
        $this->getcsvdata = $getcsvdata;

    }
    public function home()
    {   
        $provinces = Province::all();
        $sensors = Sensors::all(); 
        $municipality = Municipality::all();   
  
        
        $hazardmaps = DB::table('tbl_hazardmaps')->where('status','=','1')->get();
        $roadnetworks = DB::table('tbl_roadnetworks')->orderBy('created_at', 'desc')->limit(3)->get();
        $users = User::all();   
        
        $typhoontracks = DB::table('tbl_typhoontracks')->get();
        $typhoonstatus = DB::table('tbl_typhoonstat')->where('id','=','1')->get();

        $maintotal = array();
        $count = 0;
        $arrtotals = array();
        $sum = 0;
        $thisdate = 0;

        foreach ($sensors as $sensor) {
            $fname = $sensor->assoc_file."-".date('Ymd').".csv";  
            $yesterdayfile =  $sensor->assoc_file."-".date('Ymd',strtotime("-1 days")).".csv"; 


            $filestatus = $this->getcsvdata->getstatus($this->todaypath,$fname); 

            $todayfile = $this->getcsvdata->gettodaycsv($this->todaypath,$sensor->assoc_file);

            $todayfiletime = $this->getcsvdata->getcurrenttime($this->todaypath,$fname);
            $tempTodaycsv = $sensor->assoc_file."-".date('Ymd').".csv";
            $time = explode(":",$todayfiletime);   
            
            if (!empty($todayfile) || $time[0] >= 8) {
               $sum = $this->getcsvdata->getaccum($this->todaypath,$tempTodaycsv);  
                
               $thisdate = date('m-d-Y');
            }else if(!empty($todayfile) || (($time[0] <= 7) && ($time[0] != 0))){
               $sum = $this->getcsvdata->getaccumyesterdayandtoday($this->yesterday,$sensor->assoc_file); 
               $thisdate = date('m-d-Y',strtotime("-1 days"))." - ".date('m-d-Y'); 
            }else{
               $sum = $this->getcsvdata->getaccumyesterdayonly($this->yesterday,$sensor->assoc_file); 
               $thisdate = date('m-d-Y',strtotime("-1 days"));
            }
            

            if($sensor->category_id == 1){  
                $currentreading = $this->getcsvdata->getcurrentreading($this->todaypath,$fname);             
                   
                $arrtotals[$count++] = array(
                    'id' => $sensor->id,
                    'total' => $sum,      
                    'filestatus' => $filestatus,    
                    'currentreading' => $currentreading,  
                    'date' => $thisdate,    
                    'province_id' => $sensor->province_id,   
                    'category' => $sensor->category_id,  
                    'municipality_id' => $sensor->municipality_id, 
                    'address' => $sensor->address

                );          
            }else if($sensor->category_id == 3){
                $currentreadingwl = $this->getcsvdata->getcurrentwaterlevel($this->todaypath,$fname);
                $currentreading = $this->getcsvdata->getcurrentreading($this->todaypath,$fname); 
                $arrtotals[$count++] = array(
                    'id' => $sensor->id,
                    'total' => $sum, 
                    'filestatus' => $filestatus,    
                    'currentreading' => $currentreading, 
                    'province_id' => $sensor->province_id,
                    'date' => $thisdate,  
                    'category' => $sensor->category_id,      
                    'municipality_id' => $sensor->municipality_id,  
                    'waterlevel' => $currentreadingwl,         
                    'address' => $sensor->address
                );
            }else if($sensor->category_id == 2){
                $currentreadingwl = $this->getcsvdata->getcurrentwaterlevel($this->todaypath,$fname);
                $arrtotals[$count++] = array(
                    'id' => $sensor->id,
                    'total' => '-0', 
                    'filestatus' => $filestatus,    
                    'currentreading' => '-0', 
                    'province_id' => $sensor->province_id, 
                    'date' => $thisdate, 
                    'category' => $sensor->category_id,      
                    'municipality_id' => $sensor->municipality_id,  
                    'waterlevel' => $currentreadingwl,       
                    'address' => $sensor->address
                );
            }else{  
                $currentreading = $this->getcsvdata->getcurrentreading($this->todaypath,$fname);                               
                $arrtotals[$count++] = array(
                    'id' => $sensor->id,
                    'total' => $sum,      
                    'filestatus' => $filestatus,    
                    'currentreading' => $currentreading,  
                    'date' => $thisdate,   
                    'province_id' => $sensor->province_id,   
                    'category' => $sensor->category_id,  
                    'municipality_id' => $sensor->municipality_id, 
                    'address' => $sensor->address
                );          
            }
        }

        $landslides = Landslide::orderBy('created_at', 'desc')->get(); 
        $floods = Floods::orderBy('created_at', 'desc')->get(); 
        $clears = Clears::orderBy('created_at', 'desc')->get(); 
        foreach($clears as $key=>$c){
            $clears[$key]['province_id'] = $c->province->id;
            $role = $c->user->role;
            $role_id = $role->id;
            $source = $role->name;
            if($role_id >= 4 ){
                $source .=" ".$c->user->municipality->name;
            }else{
                $source .= " ".$c->user->province->name;
            }
            $clears[$key]['source'] = $source;
        }
        JavaScript::put([
            'arrtotals' => $arrtotals,
            'coordinates' => $sensors,

        ]);
        return view('pages.home')->with(['typhoonstatus' => $typhoonstatus,
                                         'typhoontracks' => $typhoontracks,
                                         'hazardmaps' => $hazardmaps,
                                         'users' => $users,
                                         'sensors' => $sensors,
                                         'municipality' => $municipality,
                                         'provinces' => $provinces,
                                         'landslides' => $landslides,
                                         'floods' => $floods,
                                         'clears' => $clears
                                        ]);
    }

    public function mapView()
    {   
        $provinces = Province::all();
        $sensors = Sensors::all(); 
        $municipality = Municipality::all();   
        $landslides = Landslide::orderBy('created_at', 'desc')->get();    
        $floods = Floods::orderBy('created_at', 'desc')->get();
        $roadnetworks = DB::table('tbl_roadnetworks')->orderBy('created_at', 'desc')->limit(3)->get();
        $users = User::all();   

        $maintotal = array();
        $count = 0;
        $arrtotals = array();

        foreach ($sensors as $sensor) {
            $fname = $sensor->assoc_file."-".date('Ymd').".csv";    
            $lasttwodaysfile =  $sensor->assoc_file."-".date('Ymd',strtotime("-2 days")).".csv";
            $filestatus = $this->getcsvdata->getstatus($this->todaypath,$fname); 

            if($sensor->category_id != 2){  
                $currentreading = $this->getcsvdata->getcurrentreading($this->todaypath,$fname);                
                $sum = $this->getcsvdata->getaccum($this->todaypath,$fname);    
                $arrtotals[$count++] = array(
                    'id' => $sensor->id,
                    'total' => $sum,      
                    'filestatus' => $filestatus,    
                    'currentreading' => $currentreading,    
                    'province_id' => $sensor->province_id,   
                    'category' => $sensor->category_id,           
                );          
            }else{

                $arrtotals[$count++] = array(
                    'id' => $sensor->id,
                    'total' => '-0', 
                    'filestatus' => $filestatus,    
                    'currentreading' => '-0', 
                    'province_id' => $sensor->province_id, 
                    'category' => $sensor->category_id,                 
                );
            }
        }
        return view('pages.mapviewincidents')->with(['arrtotals' => $arrtotals,
                    'users' => $users,'landslides' => $landslides,
                    'floods' => $floods,
                    'roadnetworks' => $roadnetworks,
                    'sensors' => $sensors,
                    'municipality' => $municipality,
                    'provinces' => $provinces]);
    }
    public function minerPage()
    {           
        $sensors = Sensors::all();
        return view('pages.miner')->with(['sensors' => $sensors]);
    }
    public function saveMiner(Request $request){
        set_time_limit(0);
        ignore_user_abort(true);
        //$post = $request->all();

        $dateStart = '2022/03/25';
        $dateEnd = '2022/04/05'; 

        $begin = new DateTime($dateStart);
		$end = new DateTime($dateEnd);
		$end = $end->modify( '+1 day' ); 
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($begin, $interval, $end);
    
		foreach ($period as $key => $_dateList){
			$dateList[] = $_dateList->format("Y/m/d");
        }
        
		foreach ($dateList as $key => $dateDat){
            
            //$dateList[] = $_dateList->format("Y/m/d");
            $date = explode('/', $dateDat);
            $year = $date[0];
            $month = $date[1];
            $day = $date[2];
            $this->getcsvdata->getapistocsvbydate($year,$month,$day);
    
            echo $dateDat. " - OK<br>";
        }
        
        

        //return redirect('minerpage');   
             
    }
    public function viewTestsite(){
        return view('pages.testsite');
    }
    public function viewMedia(){
        return view('pages.media');
    }

    public function incidentsMapView(){
        //$landslides = Incidents::orderBy('created_at', 'desc')->where('incident_type','=','1')->get();    
        //$floods = Incidents::orderBy('created_at', 'desc')->where('incident_type','=','2')->get();
        $landslides = Landslide::orderBy('created_at', 'desc')->get(); 
        $floods = Floods::orderBy('created_at', 'desc')->get(); 
        $clears = Clears::orderBy('created_at', 'desc')->get(); 
        return view('pages.mapviewincidents', compact('landslides','floods','clears'))/* ->with(['landslides' => $landslides,'floods' => $floods]) */;
    }
}
