<?php

namespace App\Services;

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
use File;
class Getcsvdataapi
{   
    public $arrtotals = [];
    public $waterlvltotal = [];
    function __construct(){
    	//for live --- replace if uploaded or new domain
		//$this->todaypath = 'public_html/public/data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        //$this->yesterday = 'public_html/public/data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
        //$this->lasttwodayspath = 'public_html/public/data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
		//for local
        $this->todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        $this->yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
        $this->lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
    }
    public function getdata($csvFile){
        $file_handle = fopen($csvFile, 'r');
        while (!feof($file_handle) ) {
            $line_of_text[] = fgetcsv($file_handle, 1024);
        }
        fclose($file_handle);
        return $line_of_text;
    }
    public function getfullaccum($path,$csv){
        $csvfile = $this->getcsv($path,$csv);
        $perline = count($csvfile);
        $sum = 0;
        for ($i=0; $i < $perline; $i++) {
            $sum += isset($csvfile[$i]['value']) ? (float) $csvfile[$i]['value'] : 0;
        }
        return $sum;
    }   
    public function dashboardData(){
        $sensors = DB::table('tbl_sensors')->whereIn('category_id', [1,2,3,4])->get();
        $todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        $yesterdaypath = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
        $lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
        $count = 0;

		foreach ($sensors as $sensor) {
			$sum1 = 0;
			$fname = $sensor->assoc_file."-".date('Ymd').".csv";
			$lasttwodaysfile =  $sensor->assoc_file."-".date('Ymd',strtotime("-2 days")).".csv";
            $filestatus = $this->getstatus($todaypath,$fname);	
            	
			if($sensor->category_id != 2){	
				$currentreading = $this->getcurrentreading($todaypath,$fname);	
				$sum = $this->getaccum($todaypath,$fname);
				$this->assocfile = $sensor->assoc_file;			
				$twoaccum = $this->displayaccumulatedtwodays($lasttwodayspath,$lasttwodaysfile);
				$this->arrtotals[$count++] = array(
					'id' => $sensor->id,
					'total' => $sum, 
					'twoaccum' => $twoaccum,		
					'filestatus' => $filestatus,	
					'currentreading' => $currentreading,	
					'province_id' => $sensor->province_id,	
				);			
			}else{$this->arrtotals[$count++] = array(
					'id' => $sensor->id,
					'total' => '-', 
					'twoaccum' => '-',		
					'filestatus' => $filestatus,	
					'currentreading' => '-',
					'province_id' => $sensor->province_id,	
					);
			}
		}
			$x = 0;
			$arrtotals = $this->arrtotals;
			$mainarray = array();
			$sortArray = array(); 
            foreach($arrtotals as $arrtotal){ 	               
	     		$mainarray[$x++] = array(
	            	'id' => $arrtotal['id'],
					'total' => $arrtotal['total'], 
					'twoaccum' => $arrtotal['twoaccum'],		
					'filestatus' => $arrtotal['filestatus'],	
					'currentreading' => $arrtotal['currentreading'],
					'province_id' => $arrtotal['province_id'],
	            );         
            } 
            foreach ($mainarray as $mr) {
            	foreach($mr as $key=>$value){ 
	                if(!isset($sortArray[$key])){ 
	                    $sortArray[$key] = array(); 
	                } 
	                $sortArray[$key][] = $value; 	                    
		        } 
            }        
	        $orderby = "total";
			array_multisort($sortArray[$orderby],SORT_DESC,$mainarray);	
			return $mainarray;
    }
    
    
    public function getaccum($path,$csv){
        $counter = [];
        $count = 0;
       // $todayfile = $csv."-".date('Ymd').".csv";  
        $csvfile = $this->getcsv($path,$csv);   
        // echo $path.'-'.$csv.'-'. $sum."\n";
        $perline = count($csvfile);
        
           for ($i=0; $i < $perline; $i++) { 
            $csvtime = explode(":",$csvfile[$i]['time']);  
            if($csvtime[0] >= 8){
                $cat = $csvfile[$i]['category'];
                if($cat == 2){
                    $counter[$count++] = array(
                            'time' =>  $csvfile[$i]['time'],
                            'waterlvl' => $csvfile[$i]['waterlvl'],
                            'category' => '2',
                            'value' => '0',
                        );
                }else if($cat == 3){
                    $counter[$count++] = array(
                            'time' =>   $csvfile[$i]['time'],
                            'value' => $csvfile[$i]['value'],
                            'waterlvl' => $csvfile[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter[$count++] = array(                        
                            'time' =>  $csvfile[$i]['time'],
                            'value' => $csvfile[$i]['value'],
                            'category' => '1',
                        );
                       
                }
            }
        }

        $sum = 0;
        $limit = count($counter);
        for ($i=0; $i < $limit; $i++) {
            $sum += isset($counter[$i]['value']) ? (float) $counter[$i]['value'] : 0;
        }
      return number_format((float)$sum, 2, '.', '');
    }

    public function getcurrentreading($path,$csv){
        $csvfile = $this->getcsv($path,$csv);
        $limit = count($csvfile);
        $currentreading = 0;    
        for ($i=0; $i < $limit; $i++) { 
            $currentreading = $csvfile[$i]['value'];
        }
        
        return $currentreading;
    }

    public function getcurrentwaterlevel($path,$csv){
        $csvfile = $this->getcsv($path,$csv);
        $limit = count($csvfile);
        $currentreading = 0;
        $error = 'ERR';    
        $fnal = 0;
        for ($i=0; $i < $limit; $i++) { 
            if(trim($csvfile[$i]['waterlvl'])=='ERR' || !$csvfile[$i]['waterlvl']){
                $currentreading = 0;
            }else{
                $currentreading = $csvfile[$i]['waterlvl'];
            }    
           // if(trim(!empty($csvfile[$i]['waterlvl']))){
           //    $currentreading = $csvfile[$i]['waterlvl']; 
           // }elseif($csvfile[$i]['waterlvl']=='ERR'){    
           //     $currentreading = 0;
           //}else{
           //     $currentreading = 0;
           //}
           
           //echo ($csvfile[$i]['waterlvl']).'<br>';
        }
        //$fnal = $currentreading / 100;
        return $currentreading;
    }

    public function getcurrenttime($path,$csv){
        $csvfile = $this->getcsv($path,$csv);
        $limit = count($csvfile);
        $currentreading = 0;    
        for ($i=0; $i < $limit; $i++) { 
            $currentreading = $csvfile[$i]['time'];
        }
        return $currentreading;
    }

    public function getstatus($path,$csv){
        $filestat = '';
        $csvfile = $this->getcsv($path,$csv);

        $csvfcont = count($csvfile);

        if($csvfcont < 2){
            $filestat = 'no_data';
        }else{
            $currtime = 0;
            $time = 0;
            for ($i=0; $i < $csvfcont; $i++) { 
                $currtime = $csvfile[$i]['time'];
                $currtime = explode(":",$currtime);
                $time = $currtime[0];
            }
            if($time > intval(date('H'))){
                $filestat = 'with_data';
            }else if($time == intval(date('H'))){
                $filestat = 'with_data';
            }else{
                $res = intval(date('H')) - $time;
                if($res >= 2){
                    $filestat = 'with_data';
                }else{
                    $filestat = 'with_data';
                }
            }
        }
        return $filestat;
    }

    public function getcsv($rootpath, $csvfile){
        $counter = [];
        $count = 0;
        $csvdatetime = '';
        $csvtime='';
        $sensors = DB::table('tbl_sensors')->whereIn('category_id', [1,2,3])->get();
        $mycsvFile = $rootpath.$csvfile;
        $waterlvl = '-WATERLEVEL-';
        $tndem = 'WATERLEVEL_';
       
        $indexWtrlvl = 0;
        $indexdateTime = 0;
        $indexrain = 0;
        $indexairpressure = 0;
        $indexraincum = 0;
        if(file_exists($mycsvFile)){
            $csv = $this->getdata($mycsvFile);
            if($csv[6]){
              foreach($csv[6] as $indexctr => $arr){
                if(strpos(strtolower($arr), 'datetimeread') !== false){
                     $indexdateTime = $indexctr;
                     
                }
                if(strpos(strtolower($arr), 'rain_value')){
                     $indexrain = $indexctr;
                     dd($csv[6]);
                }
                
              }
              
            }
            
            for($x=0;$x<=6;$x++){
				unset($csv[$x]);
            }
            $perlines = count($csv)+6;
            for ($i=7; $i < $perlines; $i++) { 
                $csvdatetime = $csv[$i][0]; 
                $csvdatetimearray = explode(" ", $csvdatetime);         
                $csvtime = explode(":", $csvdatetimearray[1]);      
                    if (strpos($mycsvFile,$waterlvl) !== false) {
                        $counter[$count++] = array(
                            'date' =>  $csvdatetimearray[0],
                            'time' =>  $csvdatetimearray[1],
                            'waterlvl' => $csv[$i][1],
                            'category' => '2',
                        );
                    }else if (strpos($mycsvFile,$tndem) !== false){
                        $counter[$count++] = array(
                            'date' =>  $csvdatetimearray[0],
                            'time' =>  $csvdatetimearray[1],
                            'value' => $csv[$i][2],
                            'waterlvl' => $csv[$i][3],
                            'category' => '3',
                        );
                    }else{
                        $counter[$count++] = array(
                            'date' =>  $csvdatetimearray[0],
                            'time' =>  $csvdatetimearray[1],
                            'value' => $csv[$i][2],
                            'category' => '1',
                        );
                    }
            }   
        }
        return $counter;
    }

    public function gettodaycsv($path,$assoc){
        $counter = [];
        $count = 0;
        $fname = $assoc."-".date('Ymd').".csv";
        $yestfile = $this->getcsv($path,$fname);
        $csvlimit = count($yestfile);
        for ($i=0; $i < $csvlimit; $i++) { 
            $time = $yestfile[$i]['time'];
            $cat = $yestfile[$i]['category'];
            $csvtime = explode(":", $time); 
            if($csvtime[0] >= 8){
                if($cat == 2){
                    $counter[$count++] = array(
                            'date' =>  $yestfile[$i]['date'],
                            'time' =>  $time,
                            'waterlvl' => $yestfile[$i]['waterlvl'],
                            'category' => '2',
                        );
                }else if($cat == 3){
                    $counter[$count++] = array(
                            'date' =>  $yestfile[$i]['date'],
                            'time' =>  $time,
                            'value' => $yestfile[$i]['value'],
                            'waterlvl' => $yestfile[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter[$count++] = array(
                            'date' =>  $yestfile[$i]['date'],
                            'time' =>  $time,
                            'value' => $yestfile[$i]['value'],
                            'category' => '1',
                        );
                }
            }
        }
        return $counter;
    }

    public function getyesterdaycsv($path,$assoc){
        $counter = [];
        $count = 0;
        $count1 = 0;
        $counter1 = [];
        $fnamey = $assoc."-".date('Ymd',strtotime("-1 days")).".csv";   
        $fname = $assoc."-".date('Ymd').".csv";
        $lower8 = $this->getcsv($this->todaypath,$fname);
        $yestfile = $this->getcsv($this->yesterday,$fnamey);
        $csvlimit = count($yestfile);
        $limittotal = count($lower8);

        for ($i=0; $i < $limittotal; $i++) { 
            $time = $lower8[$i]['time'];
            $cat = $lower8[$i]['category'];
            $csvtime = explode(":", $time);         
            if($csvtime[0] <= 7){
                if($cat == 2){
                    $counter1[$count++] = array(
                            'date' =>  $lower8[$i]['date'],
                            'time' =>  $time,
                            'waterlvl' => $lower8[$i]['waterlvl'],
                            'category' => '2',
                        );
                }else if($cat == 3){
                    $counter1[$count++] = array(
                            'date' =>  $lower8[$i]['date'],
                            'time' =>  $time,
                            'value' => $lower8[$i]['value'],
                            'waterlvl' => $lower8[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter1[$count++] = array(
                            'date' =>  $lower8[$i]['date'],
                            'time' =>  $time,
                            'value' => $lower8[$i]['value'],
                            'category' => '1',
                        );
                }
            }
        }

        for ($i=0; $i < $csvlimit; $i++) { 
            $time = $yestfile[$i]['time'];
            $cat = $yestfile[$i]['category'];
            $csvtime = explode(":", $time);         
            if($csvtime[0] >= 8){
                if($cat == 2){
                    $counter[$count++] = array(
                            'date' =>  $yestfile[$i]['date'],
                            'time' =>  $time,
                            'waterlvl' => $yestfile[$i]['waterlvl'],
                            'category' => '2',
                        );
                }else if($cat == 3){
                    $counter[$count++] = array(
                            'date' =>  $yestfile[$i]['date'],
                            'time' =>  $time,
                            'value' => $yestfile[$i]['value'],
                            'waterlvl' => $yestfile[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter[$count++] = array(
                            'date' =>  $yestfile[$i]['date'],
                            'time' =>  $time,
                            'value' => $yestfile[$i]['value'],
                            'category' => '1',
                        );
                }
            }
        }
        $mrgarray = array_merge($counter,$counter1);        
        return $mrgarray;
    }      

    public function getaccumyesterdayandtoday($path,$csv){
        $counter = [];
        $count = 0;
        $counter1 = [];
        $count1 = 0;
        $todayfile = $csv."-".date('Ymd').".csv";  
        $yesterdayfile =  $csv."-".date('Ymd',strtotime("-1 days")).".csv"; 
        $tods = $this->getcsv($this->todaypath,$todayfile);
        $csvfile = $this->getcsv($path,$yesterdayfile);
        $todaypercount = count($tods);
        $perline = count($csvfile);
        
        for ($i=0; $i < $todaypercount; $i++) { 
            $csvtime = explode(":",$tods[$i]['time']);         
            if($csvtime[0] <= 7){
                $cat = $tods[$i]['category'];
                if($cat == 2){
                    $counter1[$count1++] = array(
                            'time' =>  $tods[$i]['time'],
                            'waterlvl' => $tods[$i]['waterlvl'],
                            'value' => 0,
                            'category' => '2',
                        );
                }else if($cat == 3){
                    $counter1[$count1++] = array(
                            'time' =>   $tods[$i]['time'],
                            'value' => $tods[$i]['value'],
                            'waterlvl' => $tods[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter1[$count1++] = array(                        
                            'time' =>  $tods[$i]['time'],
                            'value' => $tods[$i]['value'],
                            'category' => '1',
                        );
                }
            }
        }

        for ($i=0; $i < $perline; $i++) { 
            $csvtime = explode(":",$csvfile[$i]['time']);       
            if($csvtime[0] >= 8){
                $cat = $csvfile[$i]['category'];
                if($cat == 2){
                    $counter[$count++] = array(
                            'time' =>  $csvfile[$i]['time'],
                            'waterlvl' => $csvfile[$i]['waterlvl'],
                            'category' => '2',
                            'value' => 0,
                        );
                }else if($cat == 3){
                    $counter[$count++] = array(
                            'time' =>   $csvfile[$i]['time'],
                            'value' => $csvfile[$i]['value'],
                            'waterlvl' => $csvfile[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter[$count++] = array(                        
                            'time' =>  $csvfile[$i]['time'],
                            'value' => $csvfile[$i]['value'],
                            'category' => '1',
                        );
                }
            }
        }

        $sum = 0;
        $sum1 = 0;
        $limit = count($counter);
        $limit1 = count($counter1);

        for ($i=0; $i < $limit; $i++) {
            $sum += isset($counter[$i]['value']) ? (float) $counter[$i]['value'] : 0;
        }

        for ($x=0; $x < $limit1; $x++) { 
            $sum1 += isset($counter1[$x]['value']) ? (float) $counter1[$x]['value'] : 0;
        }
        $totalyesterday = $sum1 + $sum;
        
        return number_format((float)$totalyesterday, 2, '.', '');
    }
    public function getaccumyesterdayonly($path,$csv){
        $counter = [];
        $count = 0;
        $counter1 = [];
        $count1 = 0;
        $yesterdayfile =  $csv."-".date('Ymd',strtotime("-1 days")).".csv"; 
        $csvfile = $this->getcsv($path,$yesterdayfile);
        $perline = count($csvfile);

        for ($i=0; $i < $perline; $i++) { 
            $csvtime = explode(":",$csvfile[$i]['time']);       
            if($csvtime[0] >= 8){
                $cat = $csvfile[$i]['category'];
                if($cat == 2){
                    $counter[$count++] = array(
                            'time' =>  $csvfile[$i]['time'],
                            'waterlvl' => $csvfile[$i]['waterlvl'],
                            'category' => '2',
                            'value' => 0,
                        );
                }else if($cat == 3){
                    $counter[$count++] = array(
                            'time' =>   $csvfile[$i]['time'],
                            'value' => $csvfile[$i]['value'],
                            'waterlvl' => $csvfile[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter[$count++] = array(
                        
                            'time' =>  $csvfile[$i]['time'],
                            'value' => $csvfile[$i]['value'],
                            'category' => '1',
                        );
                }
            }
        }
        $sum = 0;
        $limit = count($counter);
        for ($i=0; $i < $limit; $i++) {
            $sum += isset($counter[$i]['value']) ? (float) $counter[$i]['value'] : 0;
        }

        return number_format((float)$sum, 2, '.', '');
    }
	
    public function getapistocsv(){
              //Remove the time execution restriction
    set_time_limit(0);
    ignore_user_abort(true); 

    //Initial variables
    $sensors = DB::table('tbl_sensors')->get();   
    //$sensors = (object)[(object)['dev_id' => 453]];
    $username = 'dostregioncar';
    $password = 'dostCAR1116';
    
    //Method for session request
    $context = stream_context_create(array(
        'http' => array(
            'header'  => "Authorization: Basic " . base64_encode("$username:$password")
        ),
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    ));

    foreach ($sensors as $sensor) {
        if ($sensor->dev_id != 0) {
            $url = 'http://philsensors.asti.dost.gov.ph/api/data/'.
                    $sensor->dev_id . 
                    '/from/' . date('Y-m-d',strtotime("-1 days")) . '/to/' . date('Y-m-d');
            
            //try {
            //    $data = file_get_contents($url, false, $context);
            //} catch (Exception $e) {
            //    throw new Exception( 'Something really gone wrong', 0, $e);
            //}
            try {
                $data = file_get_contents($url, false, $context);
            } catch (\Throwable $th) {
                echo "Something went wrong\n";
            continue;
            }

            $mydatas = json_decode($data, true);          
            $counter = 0; 
            $sensorType = strtolower($mydatas['type_name']);   
            if (!empty($mydatas['province'])) { 
                //Variables
                $finalarray = array(
                    array('region: CAR'),
                    array('province: '.$mydatas['province']),
                    array('municipality: '.$mydatas['municipality']),
                    array('posx: '.$mydatas['latitude']),
                    array('posy: '.$mydatas['longitude']),
                    //array('imei: '.$mydatas['imei_num']),
                    array('sensor_name: '.$mydatas['type_name']),

                );
                
                $province = strtoupper(str_replace(' ', '_', $mydatas['province']));
                $location = strtoupper(str_replace(' ', '_', $mydatas['location']));
                $flocation = str_replace(',','',$location);
                $finallocation = str_replace('.','',$location);
                $type = strtoupper(str_replace(' ', '_', $mydatas['type_name']));
                $ftype = str_replace('&_','', $type);
                $rootfile = public_path() . '/data/'.date('Y').'/'.date('m').'/'.date('d').'/';
                $filename = $province.'-'.$finallocation.'-'.$ftype.'-'.date('Ymd').'.csv';
		
				//dd($rootfile);
		
                if (is_dir($rootfile) == false) {
                    mkdir($rootfile, 0777, true);
                }

                $file = fopen($rootfile.$filename,"w");

                foreach ($finalarray as $fields) {
                    fputcsv($file, $fields);
                }
                $keys = array();        
                $counter = 0;
                $counts = 0;

                if (!empty($mydatas['data'])) {
                    foreach ($mydatas['data'][0] as $key => $value) {
                        $keys[$counter++] =  $key;           
                    }

                    if ($sensorType == 'rain2') {
                        $newKeys = [$keys[0], $keys[2], $keys[3], $keys[1]];
                       // dd($newKeys);
                    } elseif ($sensorType == 'waterlvl & rain 2') {
                        $newKeys = [$keys[0], $keys[3], $keys[4], $keys[1], $keys[2]];
                    } else {
                            $newKeys = $keys;
                    }
                    //$thiskeys = array($keys);
                    $thiskeys = [$newKeys];

                    foreach ($thiskeys as $fields) {
                        fputcsv($file, $fields);
                    }
                    sort($mydatas['data']);          
                    $date = date('Y-m-d');

                    foreach($mydatas['data'] as $mydata){
                        if ($sensorType == 'rain2') {
                            $newData = ['dateTimeRead' => $mydata['dateTimeRead'],
                                        'rain_value' => $mydata['rain_value'],            
                                        'rain_cum' => $mydata['rain_cum'],
                                        'air_pressure' => $mydata['air_pressure']];
                        } else if($sensorType == 'waterlvl & rain 2') {
                            $newData = ['dateTimeRead' => $mydata['dateTimeRead'],
                                        'waterlvl' => $mydata['waterlvl'],
                                        'rain_value' => $mydata['rain_value'],
                                        'rain_cum' => $mydata['rain_cum'],
                                        //'waterlevel_msl' => $mydata['waterlevel_msl'],
                                        'air_pressure' => $mydata['air_pressure']];
                        } else {
                            $newData = $mydata;
                        }
                        $csvdatetimearray = explode(" ", $newData['dateTimeRead']); 

                        if($csvdatetimearray[0] == $date){
                            fputcsv($file, $newData);
                        }
                    }
                }                                         

                fclose($file);
            }
        }
    }
 }

    public function getapistocsvbydate($year,$month,$day){
        set_time_limit(0);
        ignore_user_abort(true); 
        $sensors = DB::table('tbl_sensors')->get();   
        $username = 'dostregioncar';
        $password = 'dostCAR1116';
        $context = stream_context_create(array(
        'http' => array(
            'header'  => "Authorization: Basic " . base64_encode("$username:$password")
        ),
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
        ));
        $date=date_create($year.'-'.$month.'-'.$day);
        date_sub($date,date_interval_create_from_date_string("1 days"));
        $ystmonth = date_format($date,"m");
        $ystyear = date_format($date,"Y");
        $ystday = date_format($date,"d");
        
        foreach ($sensors as $sensor) {
          if($sensor->dev_id != 0){
            $url = 'https://philsensors.asti.dost.gov.ph/api/data/'.$sensor->dev_id.'/from/'.$ystyear.'-'.$ystmonth.'-'.$ystday.'/to/'.$year.'-'.$month.'-'.$day;
            //try {
            //    $data = file_get_contents($url, false, $context);
            //} catch (Exception $e) {
            //    throw new Exception( 'Something really gone wrong', 0, $e);
            //}
           
            try {
                $data = file_get_contents($url, false, $context);
            } catch (\Throwable $th) {
                echo "Something went wrong\n";
            continue;
            }
            $mydatas = json_decode($data, true);
            $counter = 0;    
            $finalarray = [];
            //$filename = '';
            $sensorType = strtolower($mydatas['type_name']);
            if (!empty($mydatas['province'])) {
                $finalarray = array(
                    array('region: CAR'),
                    array('province: '.$mydatas['province']),
                    array('municipality: '.$mydatas['municipality']),
                    array('posx: '.$mydatas['latitude']),
                    array('posy: '.$mydatas['longitude']),
                    //array('imei: '.$mydatas['imei_num']),
                    array('sensor_name: '.$mydatas['type_name']),
                );

                $province = strtoupper(str_replace(' ', '_', $mydatas['province']));
                $location = strtoupper(str_replace(' ', '_', $mydatas['location']));
                $flocation = str_replace(',','',$location);
                $finallocation = str_replace('.','',$location);
                $type = strtoupper(str_replace(' ', '_', $mydatas['type_name']));
                $ftype = str_replace('&_','', $type);
                $rootfile = public_path() . '/data/'.$year.'/'.$month.'/'.$day.'/';
                $filename = $province.'-'.$finallocation.'-'.$ftype.'-'.$year.$month.$day.'.csv';
            
                if (is_dir($rootfile) === false)
                {
                    mkdir($rootfile, 0777, true);
                }
                $file = fopen($rootfile.$filename,"w");   

                foreach ($finalarray as $fields) {
                    fputcsv($file, $fields);
                }
                $keys = array();        
                $counter = 0;
                $counts = 0;
                
                if(!empty($mydatas['data'])){
                    foreach ($mydatas['data'][0] as $key => $value) {
                        $keys[$counter++] =  $key;           
                    }
                     if ($sensorType == 'rain2') {
                        $newKeys = [$keys[0], $keys[2], $keys[3], $keys[1]];
                       // dd($newKeys);
                    } elseif ($sensorType == 'waterlvl & rain 2') {
                        $newKeys = [$keys[0], $keys[3], $keys[4], $keys[1], $keys[2]];
                    } else {
                            $newKeys = $keys;
                    }
                    //$thiskeys = array($keys);
                    $thiskeys = [$newKeys];
                    //$thiskeys = array($keys);
                    foreach ($thiskeys as $fields) {
                        fputcsv($file, $fields);
                    }
                    sort($mydatas['data']);          
                    $date =  $year.'-'.$month.'-'.$day;

                    foreach($mydatas['data'] as $mydata){
                        if ($sensorType == 'rain2') {
                            $newData = ['dateTimeRead' => $mydata['dateTimeRead'],
                                        'rain_value' => $mydata['rain_value'],            
                                        'rain_cum' => $mydata['rain_cum'],
                                        'air_pressure' => $mydata['air_pressure']];
                        } else if($sensorType == 'waterlvl & rain 2') {
                            $newData = ['dateTimeRead' => $mydata['dateTimeRead'],
                                        'waterlvl' => $mydata['waterlvl'],
                                        'rain_value' => $mydata['rain_value'],
                                        'rain_cum' => $mydata['rain_cum'],
                                        //'waterlevel_msl' => $mydata['waterlevel_msl'],
                                        'air_pressure' => $mydata['air_pressure']];
                        } else {
                            $newData = $mydata;
                        }
                        $csvdatetimearray = explode(" ", $newData['dateTimeRead']); 
                        if($csvdatetimearray[0] == $date){
                            fputcsv($file, $newData);                           
                        }
                    }

                } 
                fclose($file);                        
            }
           }
        }//end loop sensor
    }      
    public function displayaccumulatedtwodays($path,$csv){
        $yesterdayfile = $this->assocfile."-".date('Ymd',strtotime("-1 days")).".csv";  
        $yesterdaypath = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
        $todayfile = $this->assocfile."-".date('Ymd').".csv";
        $lasttwodaysaccum = $this->getaccum($path,$csv);           
        $yesterday = $this->getfullaccum($yesterdaypath,$yesterdayfile);
        $today = $this->getfullaccum($this->todaypath,$todayfile);
        $total = $lasttwodaysaccum + $yesterday + $today;
       // echo $lasttwodaysaccum;
        return number_format((float)$total, 2, '.', '');
    }   

    public function postRainvalue(){
        $todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
       $yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
       $lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
        $sensors = DB::table('tbl_sensors')->whereIn('category_id', [1,2,3,4])->get();
        $categories = DB::table('tbl_categories')->get();
        $thresholds = DB::table('tbl_threshold')->get();
        $rainData = [];
        $waterlvl = [];
        $dispcount = 0;
        $count = 0;            
        $sensorcategory = '';

        foreach ($sensors as $sensor) {
            $sum1 = 0;
            $fname = $sensor->assoc_file."-".date('Ymd').".csv";  
            $lasttwodaysfile =  $sensor->assoc_file."-".date('Ymd',strtotime("-2 days")).".csv";
            $filestatus = $this->getstatus($todaypath,$fname); 

            if(($sensor->category_id == 1) || ($sensor->category_id == 3) || ($sensor->category_id == 4)){
            //for rain and tandem  
                $currentreading = $this->getcurrentreading($todaypath,$fname);   
                $sum = $this->getaccum($todaypath,$fname);
                $this->assocfile = $sensor->assoc_file;         
                $filepast2day = $lasttwodayspath.$lasttwodaysfile;
                $twoaccum = $this->displayaccumulatedtwodays($lasttwodayspath,$lasttwodaysfile);
                $this->arrtotals[$count++] = array(
                    'id' => $sensor->id,
                    'total' => $sum, 
                    'twoaccum' => $twoaccum,        
                    'filestatus' => $filestatus,    
                    'currentreading' => $currentreading,    
                    'province_id' => $sensor->province_id,  
                );          
            }
        }    

        foreach ($sensors as $sensor) {
            foreach($this->arrtotals as $arrtotal){
                foreach ($categories as $category) {
                    if ($category->id == $sensor->category_id) {                        
                        $sensorcategory = $category->name;
                    }
                }                
                if($arrtotal['id'] == $sensor->id){                                        
                    $rainData['data'][$dispcount++] = array(
                            'id' => $sensor->id,
                            'status' => $arrtotal['filestatus'],                               
                            'address' => $sensor->address,
                            'sensortype' => $sensorcategory,
                            'current' => number_format((float)$arrtotal['currentreading'], 2, '.', ''),
                            'cumulative' => $arrtotal['total'],
                            'past2days' => $arrtotal['twoaccum'],                            
                            'remarks' => $sensor->remarks                               
                    );
                }
            }
        }
        return $rainData;
    }

    public function postWaterlevelvalue(){
        $todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
       $yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
       $lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
        $sensors = DB::table('tbl_sensors')->whereIn('category_id', [1,2,3,4])->get();
        $categories = DB::table('tbl_categories')->get();
        $thresholds = DB::table('tbl_threshold')->get();
        $disptotal = [];
        $waterlvl = [];
        //$waterlvltotal = 0;
        $dispcount = 0;
        $watercount = 0;       
        $wcount = 0;
        $count = 0;                
        $sensorcategory = '';

        foreach ($sensors as $sensor) {
            $sum1 = 0;
            $fname = $sensor->assoc_file."-".date('Ymd').".csv";    
            $lasttwodaysfile =  $sensor->assoc_file."-".date('Ymd',strtotime("-2 days")).".csv";
            $filestatus = $this->getstatus($todaypath,$fname); 

            if(($sensor->category_id == 2) || ($sensor->category_id == 3)){
                $currentwater = $this->getcurrentwaterlevel($todaypath,$fname);  
                $this->waterlvltotal[$wcount++] = array(
                    'id' => $sensor->id,
                    'total' => '-', 
                    'twoaccum' => '-',      
                    'filestatus' => $filestatus,    
                    'currentreading' => $currentwater,
                    'province_id' => $sensor->province_id,          
                );
            }
        }
        foreach ($sensors as $sensor) {           
            foreach ($this->waterlvltotal as $water) {
                foreach ($categories as $category) {
                    if ($category->id == $sensor->category_id) {
                        $sensorcategory = $category->name;
                    }
                }
                foreach ($thresholds as $threshold) {
                    if ($threshold->address_id == $sensor->id) {
                       if($water['id'] == $sensor->id){                        
                            $waterlvl['data'][$watercount++] = array(
                                'id' => $sensor->id,
                                'status' => $water['filestatus'],                             
                                'address' => $sensor->address,
                                'sensortype' => $sensorcategory,
                                'current' => number_format((float)$water['currentreading'], 2, '.', ''),
                                'normal_val' => $threshold->normal_val,
                                'level1_val' => $threshold->level1_val,
                                'level2_val' => $threshold->level2_val,
                                'critical_val' => $threshold->critical_val,
                                'remarks' => $sensor->remarks                             
                            );
                        }
                    }
                }                
            }
        }
        return $waterlvl;
    }
    public function savetextFile(){
    }
}