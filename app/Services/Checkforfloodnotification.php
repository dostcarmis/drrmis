<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Http\Requests;

use DB;
use Session;

use Illuminate\Support\Facades\Input;

use App\Model\Thresholdfloodmodel;
use Response;
use Auth;
use Carbon\Carbon;
use App\Services\Checkfornotification;
class Checkforfloodnotification
{
	function __construct(Checkfornotification $checkfornotification)
    {
         $this->checkfornotification = $checkfornotification;
    }

    public function checkfloodvaluefromthreshold(){   	
    	
    	$thresholdfloodtable = DB::table('tbl_thresholdflood')->get(); 
    	$sensors = DB::table('tbl_sensors')->get(); 
    	


    	foreach ($thresholdfloodtable as $thresholdflood) {
    		$floodarrayfornotif = [];
    		$counter = 0;
			$floodvalues = unserialize($thresholdflood->sensor_sources); 
			$areasaffected = unserialize($thresholdflood->areas_affected); 
			foreach ($sensors as $sensor) {				
				foreach ($floodvalues as $fv) {
					if ($fv[0] == $sensor->id) {
						$todaytotalreading = $this->checkfornotification->totalcummulativeOnedayforflood($sensor->assoc_file);
						if ($todaytotalreading >= $fv[1]) {
							$floodarrayfornotif[$counter++] = array(
								$fv[0],$fv[1],$thresholdflood->id,$todaytotalreading
								);
						}						
					}
				}
			}
			if (!empty($floodarrayfornotif)) {
				$this->savenotificationtable($floodarrayfornotif);
			}			
    	}		

    }
    public function savenotificationtable($floodarrayfornotifs){
		//tbl_notification_flood

		$provinceid = '';

		$sensorids = [];
		$sensoridscount = 0;

		$sensorvalues = [];
		$sensorvaluescount = 0;



		$userid = '';
		$date = date('Ymd');
		$allusers = DB::table('users')->get();

		$sensors = DB::table('tbl_sensors')->get();

		$floodthresholdid = 0;

		$counts = count($floodarrayfornotifs);  	


    	foreach ($floodarrayfornotifs as $floodarrayfornotif) {
    		foreach ($sensors as $sensor) {
				if($sensor->id == $floodarrayfornotif[0]){
					$provinceid = $sensor->province_id;
				}
			}
			$sensorids[$sensoridscount++] = $floodarrayfornotif[0];
			$floodthresholdid = $floodarrayfornotif[2];
			$sensorvalues[$sensorvaluescount++] = $floodarrayfornotif[3];

    	}
		
		$countiftableexists = DB::table('tbl_notifications')
		    ->where('sent_at', '=', $date)
		    ->where('user_id', '=', '1')
		    ->where('floodthresholdid', '=', $floodthresholdid)
		    ->count();		

		//all prov notification		

		if ($countiftableexists < 1) {
			foreach ($allusers as $user) {			
					$notificationtable = array(
					'user_id' => $user->id,
					'ifflood' => '1',
					'floodthresholdid' => $floodthresholdid,
					'sensorsids' => serialize($sensorids),
					'nc_id' => '4',
					'sensorvalues' => serialize($sensorvalues),
					'province_id' => $provinceid,
					'is_read' => '0',
					'is_seen' => '0',
					'sent_at' => $date,
					);	

				DB::table('tbl_notifications')->insert($notificationtable);	
			}			    
		}else{
			echo '------- ADAn -------';
		}	
		
		return true;
	}

    

}