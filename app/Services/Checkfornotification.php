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
use Carbon\Carbon;
use App\Services\Getcsvdataapi;
class Checkfornotification
{
	private $arrtotals = [];
	private $filterprovince;
	private $filtercategory;
	private $todaypath;
	private $yesterday;
	private $test = [];
	private $assocfile;
	private $cummulativedate = [];
	public $AppServiceCsvfunction;

	function __construct(Getcsvdataapi $AppServiceCsvfunction){

        //$this->todaypath = 'public_html/public/data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
		//$this->yesterday = 'public_html/public/data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
		//$this->lasttwodayspath = 'public_html/public/data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
		
		$this->todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
		$this->yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
		$this->lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';

		$this->AppServiceCsvfunction = $AppServiceCsvfunction;

	}

    public function totalcummulativeOnedayforflood($csv){
			
		return $tots;	
	}	
	public function newAccountNotification($id,$mID,$pID){
		$date = date('Ymd');
		if($id != ''){
			$notificationtable = array(
			'user_id' => $id,
			'nc_id' => '1',
			'municipality_id' => $mID,
			'province_id' => $pID,
			'timehrsent' => date('h'),
			'is_read' => '0',
			'is_seen' => '0',
			'sent_at' => $date,
		);					

		DB::table('tbl_notifications')->insert($notificationtable);	


		}

	}
	public function newSensorNotification($sensorid,$accum){
		$municipalityid = '';
		$provinceid = '';
		$userid = '';
		$assocfile = '';
		$counter = 0;
		$date = date('Ymd');
		$allusers = DB::table('users')->get();
		$notifications = DB::table('tbl_notifications')->get();
		$sensors = DB::table('tbl_sensors')->get();
		$datenow = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'))->toDateTimeString();
		$dymn = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->toDateTimeString();


		foreach ($sensors as $sensor) {
			if($sensor->id == $sensorid){
				$municipalityid = $sensor->municipality_id;
				$provinceid = $sensor->province_id;
				$assocfile = $sensor->assoc_file;
			}
		}

		//all prov notification
		$countiftableexists = DB::table('tbl_notifications')
			    ->where('sent_at', '=', $date)
			    ->where('sensorsids', '=', $sensorid)
			    ->where('user_id', '=', '1')
			    ->count();
	
		if ($countiftableexists < 1) {
			foreach ($allusers as $user) {			
					$notificationtable = array(
					'user_id' => $user->id,
					'sensorsids' => $sensorid,
					'nc_id' => '3',
					'value' => $accum,
					'municipality_id' => $municipalityid,
					'province_id' => $provinceid,
					'timehrsent' => date('h'),
					'is_read' => '0',
					'is_seen' => '0',
					'sent_at' => $date,
					);	

				DB::table('tbl_notifications')->insert($notificationtable);	
			}			    
		}//if not yet
		//return true;
	}

	public function oldSensorNotification($sensorid,$accum,$prevValue){

		$municipalityid = '';
		$provinceid = '';
		$userid = '';
		$assocfile = '';
		$counter = 0;
		$date = date('Ymd');
		$allusers = DB::table('users')->get();
		$notifications = DB::table('tbl_notifications')->get();
		$sensors = DB::table('tbl_sensors')->get();
		$datenow = Carbon::createFromFormat('Y-m-d H:i', date('Y-m-d H:i'))->toDateTimeString();
		$dymn = Carbon::createFromFormat('Y-m-d', date('Y-m-d'))->toDateTimeString();


		foreach ($sensors as $sensor) {
			if($sensor->id == $sensorid){
				$municipalityid = $sensor->municipality_id;
				$provinceid = $sensor->province_id;
				$assocfile = $sensor->assoc_file;
			}
		}

			foreach ($allusers as $user) {		//notification for all users	
					$notificationtable = array(
					'user_id' => $user->id,
					'sensorsids' => $sensorid,
					'nc_id' => '7',
					'prevvalue' => $prevValue,
					'value' => $accum,
					'municipality_id' => $municipalityid,
					'province_id' => $provinceid,
					'timehrsent' => date('h'),
					'is_read' => '0',
					'is_seen' => '0',
					'sent_at' => $date,
					);	

				DB::table('tbl_notifications')->insert($notificationtable);	
			}			    

		// return true;
	}

	public function getAlertStatus($sensorID){

		
		$sensors = DB::table('tbl_sensors')->whereIn('category_id', [2,3])->get(); 
		$notificationsWaterlvl = DB::table('tbl_notificationwaterlevel')->get();

		



		$currentStatus = 0; //normal value

		foreach ($notificationsWaterlvl as $notificationWaterlvl) {
			if ($notificationWaterlvl->sensorid == $sensorID) {						
				$currentStatus = $notificationWaterlvl->alertstatus;
			}
		}	
		
		return $currentStatus;
	}
	public function savetoWaterlevelNotification($sensorID,$date,$currentWaterlvl,$munID,$provID,$stat){
		$users = DB::table('users')->get();

		foreach ($users as $user) {		
			$content = array(
				'date' => $date,
				'userid' => $user->id,				
				'nc_id' => '4',
				'alertstatus' => $stat,
				'sensorid' => $sensorID,
				'currentWaterlvl' => $currentWaterlvl,
				'municipality_id' => $munID,
				'province_id' => $provID,
				'is_read' => '0',
				'is_seen' => '0',
			);	

			DB::table('tbl_notificationwaterlevel')->insert($content);	
		}

	}
	public function waterlvlNotification(){

		$thresholds = DB::table('tbl_threshold')->get();
		$sensors = DB::table('tbl_sensors')->whereIn('category_id', [2,3])->get(); //waterlevel and tandem
		
		$date = date('Ymd');
		$currentDate = date('Y-m-d');

		


		foreach ($sensors as $sensor) {

	
			$waterlvlTotal = 0;


			$now =  $sensor->assoc_file."-".$date.".csv";	

			$newpathnow = $this->todaypath;

			$currentWaterlvl = $this->AppServiceCsvfunction->getcurrentwaterlevel($newpathnow,$now);				
	
			$currentStatget = $this->getAlertStatus($sensor->id);//check level of alert


			$newStat = 0;

			//threshold values
			$level1Val ='';
			$level2Val ='';
			$criticalVal = '';


			foreach ($thresholds as $threshold){	
				if ($sensor->id == $threshold->address_id) {
					$level1Val = $threshold->level1_val;
					$level2Val = $threshold->level2_val;
					$criticalVal = $threshold->critical_val;
				}
			}		

			$checkDuplicate = DB::table('tbl_notificationwaterlevel')
			    ->where('date', '=', $currentDate)
			    ->where('sensorid', '=', $sensor->id)
			    ->where('userid', '=', '1')
			    ->count();

		

			
			if(($currentWaterlvl > 0) && ($level1Val > 0) && ($level2Val > 0) && ($criticalVal > 0)) { 
				//if not null or empty
				if($currentWaterlvl >= $criticalVal) {
					$newStat = 3;
				}elseif(($currentWaterlvl >= $level2Val) && ($currentWaterlvl < $criticalVal)){
					$newStat = 2;
				}elseif(($currentWaterlvl >= $level1Val) && ($currentWaterlvl < $level2Val)){
					$newStat = 1;
				}elseif($currentWaterlvl < $level1Val){
					$newStat = 0;
				}
				$this->savetoWaterlevelNotification($sensor->id,$currentDate,$currentWaterlvl,$sensor->municipality_id,$sensor->province_id,$newStat);
			}

	

			
		}//end sensors
	}

	public function docheck(){
  		$thresholds = DB::table('tbl_threshold')->get(); 
		$sensors = DB::table('tbl_sensors')->whereIn('category_id', [1,2,3])->get();
		$notifications = DB::table('tbl_notifications')->get(); 
		$date = date('Y-m-d');

		
		
		//check sensor		
		foreach ($sensors as $sensor) {
			$threshtotal = 0;
			foreach($thresholds as $threshold){
				if($sensor->id == $threshold->address_id){
					$threshtotal = $threshold->threshold_landslide;		
				}
			}
			
			$prevValue = 0;
			$firstwarn = 0;
            $tempCSV = $sensor->assoc_file."-".date('Ymd').".csv"; 
      
			$firstwarn = $this->AppServiceCsvfunction->getaccum($this->todaypath,$tempCSV);	
		
		    
			$chkTbl = DB::table('tbl_notifications')
			    ->where('sent_at', '=', $date)
			    ->where('sensorsids', '=', $sensor->id)
			    ->where('nc_id', '=', '3')			    
			    ->count();

			if($chkTbl >= 1){
				
				$chkTblother = DB::table('tbl_notifications')
			    ->where('value', '=', $firstwarn)			    
			    ->count();
			   
			    
			    if($chkTblother < 1){
			    
			    	echo $chkTblother."-".$sensor->id."-".$sensor->address."-".$firstwarn."\n"; 
				   if(($firstwarn >= $threshtotal) && ($firstwarn != 0)){
			    	$this->oldSensorNotification($sensor->id,$firstwarn,$prevValue);	  
				   }
			    }
			    

			}elseif($chkTbl < 1){
				if(($firstwarn >= $threshtotal) && ($firstwarn != 0)){
				echo "firstwarn-".$chkTbl."-".$sensor->id."-".$sensor->address."\n";		
					$this->newSensorNotification($sensor->id,$firstwarn);//first warning	
				}
			}


		}		
		echo "run @ ".date("Y/m/d");
	}

}