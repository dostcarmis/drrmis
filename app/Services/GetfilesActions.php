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

use Response;
use Auth;
use Carbon\Carbon;

class GetfilesAction
{
    
    function __construct(){
        $this->todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
        $this->yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
        $this->lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
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
    
        if(file_exists($mycsvFile)){
            $csv = $this->getdata($mycsvFile);
            for($x=0;$x<=7;$x++){
            unset($csv[$x]);
            }
            $perlines = count($csv)+7;
            for ($i=8; $i < $perlines; $i++) { 
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
                            'value' => $csv[$i][1],
                            'waterlvl' => $csv[$i][2],
                            'category' => '3',
                        );
                    }else{
                        $counter[$count++] = array(
                            'date' =>  $csvdatetimearray[0],
                            'time' =>  $csvdatetimearray[1],
                            'value' => $csv[$i][1],
                            'category' => '1',
                        );
                    }
                
            }   
        }
        return $counter;
    }
    public function gettodaycsv($assoc){
        $counter = [];
        $count = 0;
        $fname = $assoc."-".date('Ymd').".csv";
        $yestfile = $this->getcsv($this->todaypath,$fname);
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
    
    public function getyesterdaycsv($assoc){
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
                            'time' =>  $time,
                            'waterlvl' => $yestfile[$i]['waterlvl'],
                            'category' => '2',
                        );
                }else if($cat == 3){
                    $counter[$count++] = array(
                            'time' =>  $time,
                            'value' => $yestfile[$i]['value'],
                            'waterlvl' => $yestfile[$i]['waterlvl'],
                            'category' => '3',
                        );
                }else{
                    $counter[$count++] = array(
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
}