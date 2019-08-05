<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use DateTime;
use DateInterval;
use DatePeriod;

class DataminerController extends Controller
{
    
    private $log = "";

    /*
	function __construct(){

    	$this->middleware('auth');

    }*/

    public function showDataminerPage(){

    	return view('pages.dataminer');

    }

    public function currentDayMining(){

    	ignore_user_abort(1);
		set_time_limit(0);

		$startDate = date("Y-m-d");
		$startDate = date("Y-m-d", strtotime("-1 day", strtotime($startDate)));
		$endDate = date("Y/m/d");

		$this->initializeMiner($startDate, $endDate);

    }

    public function fullMining(){

    	ignore_user_abort(1);
		set_time_limit(0);

		$startDate = "2016/01/01";
		$endDate = date("Y/m/d");

		$this->initializeMiner($startDate, $endDate);

    }

    #===========================================================================================================================================#

    private function getDateRange($startDate, $endDate){

    	ignore_user_abort(1);
		set_time_limit(0);

    	$begin = new DateTime($startDate);
		$end = new DateTime($endDate);
		$end = $end->modify( '+1 day' ); 

		$interval = new DateInterval('P1D');
		$period = new DatePeriod($begin, $interval, $end);

		return $period;

    }

    private function getLocationLink($rootpath, $fileroot){

    	$apayao = 'APAYAO';
        $benguet = 'BENGUET';
        $kalinga = 'KALINGA';
        $abra = 'ABRA';
        $ifugao = 'IFUGAO';
        $mt = 'MOUNTAIN_PROVINCE';

    	if(FALSE !== ($url = @file_get_contents($rootpath))) {

	    	$oDOMDoc = new \DOMDocument();
			$oDOMDoc->loadHTML($url);
			$error = libxml_get_last_error();
			libxml_use_internal_errors(false);

			if ($error){

				echo "error";
				return 0;

			}else {

				$oDOMNodes = $oDOMDoc->getElementsByTagName('a');

				for ($i = 0 ; $i <= $oDOMNodes -> length ; $i++){

				    $oDOMNode = $oDOMNodes->item( $i );

				    if (is_object($oDOMNode) && $oDOMNode->hasAttribute('href')){

				    	$filename = $oDOMNode->getAttribute('href');

				    	if (stripos($filename, $apayao) !== false || stripos($filename, $benguet) !== false || stripos($filename, $kalinga) !== false ||
				    		stripos($filename, $abra) !== false || stripos($filename, $ifugao) !== false || stripos($filename, $mt) !== false){

				    		$rootURL = $rootpath . $filename;
					    	$this->downloadSensorData($fileroot, $rootURL, $filename);

				    	}
				    	
				    }

				}

			}

		}else {

			echo "error";
			return 0;

		}

    }

    private function initializeMiner($startDate, $endDate){

		set_time_limit(0);

		$url = "";
		$fileDir = array();
		$roothPaths = array();
		$filename = "null";

		$period = $this->getDateRange($startDate, $endDate);

		foreach ( $period as $_dateList ){
			
			$dateList = $_dateList->format("Y/m/d");
			$dateList_Array = explode("/", $dateList);

			$fileroot = "data/" . $dateList_Array[0] . "/" . sprintf("%02d", $dateList_Array[1]) . "/" . sprintf("%02d", $dateList_Array[2]) . "/";
			
			if (!is_dir($fileroot)){

				mkdir($fileroot, 0777, true);

			}

			$rootpath = "http://repo.pscigrid.gov.ph/predict/" . $dateList_Array[0] . "/" . sprintf("%02d", $dateList_Array[1]) . "/" . sprintf("%02d", $dateList_Array[2]) . "/";
			$this->getLocationLink($rootpath, $fileroot);

		}

    }

    #===========================================================================================================================================#
    #=========================================== DOWNLOAD THE CSV FILE FROM THE ASTI SERVER ====================================================#
   	#===========================================================================================================================================#

    private function downloadSensorData($fileroot, $rootURL, $filename){

		set_time_limit(0);

		$file;
		$newf;

		if (fopen ($rootURL, 'rb')) {

			$file = fopen ($rootURL, 'rb');

		    if (fopen ($fileroot  . basename($rootURL), 'wb')) {

		    	$newf = fopen ($fileroot  . basename($rootURL), 'wb');

		        while(!feof($file)) {

		            fwrite($newf, fread($file, 1024 * 8), 1024 * 8);

		        }

		    }else {

		    	echo "error";
				return 0;

		    }

		}else {

			echo "error";
			return 0;

		}

		if ($file) {

		    fclose($file);

		}

		if ($newf) {

		    fclose($newf);

		}

    }

    #===========================================================================================================================================#
    #============================================== EXPORT CSV DATA TO LOCAL DATABASE ==========================================================#
    #===========================================================================================================================================#

    /*
    public function syncDatabase_Daily(){

    	$location = array();

		$yearDir = array();
		$monthDir = array();
		$dayDir = array();
		$aLinks = array();

		$yearDir = scandir("data/");


		foreach ($yearDir as $yDir) {

			
			if ($yDir >= 2011){

				$monthDir = scandir("data/" . (string)$yDir . "/");

				foreach ($monthDir as $mDir) {
					
					if ($mDir >= 1){

						$dayDir = scandir("data/" . (string)$yDir . "/" . (string)$mDir . "/");
					
						foreach ($dayDir as $dDir) {

							if ($dDir >= 1){

								$_aLinks = scandir("data/" . (string)$yDir . "/" . (string)$mDir . "/" . $dDir . "/");

								foreach ($_aLinks as $_aTest) {
									
									if ($_aTest !== "." && $_aTest !== ".."){

										$tempFileRoot = "data/" . $yDir . "/" . $mDir . "/" . $dDir . "/";
										$tempSensorCSVFileName = $_aTest;
										$this->storeSensorData_Database($tempFileRoot, $tempSensorCSVFileName);

									}

								}

							}

						}
						
					}

				}

			}

		}

    }

    public function syncDatabase(){

    	$location = array();

		$yearDir = array();
		$monthDir = array();
		$dayDir = array();
		$aLinks = array();

		$yearDir = scandir("data/");


		foreach ($yearDir as $yDir) {

			
			if ($yDir >= 2016){

				$monthDir = scandir("data/" . (string)$yDir . "/");

				foreach ($monthDir as $mDir) {
					
					if ($mDir >= 1){

						$dayDir = scandir("data/" . (string)$yDir . "/" . (string)$mDir . "/");
					
						foreach ($dayDir as $dDir) {

							if ($dDir >= 1){

								$_aLinks = scandir("data/" . (string)$yDir . "/" . (string)$mDir . "/" . $dDir . "/");

								foreach ($_aLinks as $_aTest) {
									
									if ($_aTest !== "." && $_aTest !== ".."){

										$tempFileRoot = "data/" . $yDir . "/" . $mDir . "/" . $dDir . "/";
										$tempSensorCSVFileName = $_aTest;
										//$this->storeSensorData_Database($tempFileRoot, $tempSensorCSVFileName);

									}

								}

							}

						}
						
					}

				}

			}

		}

    }
    
    private function storeSensorData_Database($fileroot, $sensorLocation){

    	ignore_user_abort(1);
		set_time_limit(0);

    	$_file = "temp/logs/dataminer-" . date("Y-m-d") . ".log";
		$this->log = file_get_contents($_file);
		$this->log .= "[" . date("h:i:s a") . "]: Storing to database. \n";
		file_put_contents($_file, $this->log);

    	$data = array();
    	$sensorID = "";
    	$categoryID = "";
    	$WLMS = "WATERLEVEL";
    	$ARG = "RAIN2";
    	$AWS = "UAAWS";
    	$TDM = "WATERLEVEL_%26_RAIN_2";
		$categories = DB::table('tbl_categories')->get();
		$sensors = DB::table('tbl_sensors')->get();
    	$tempCategory = "";

    	if ((stripos($sensorLocation, $WLMS) !== false) && (stripos($sensorLocation, $TDM) === false)) {

	    	$tempCategory = "Automated Stream Gauges";

	    }else if ((stripos($sensorLocation, $ARG) !== false)) {

	    	$tempCategory = "Automated Rain Gauges";

	    }else if ((stripos($sensorLocation, $AWS) !== false)) {

	    	$tempCategory = "Automated Weather Stations";

	    }else if ((stripos($sensorLocation, $TDM) !== false)) {

	    	$tempCategory = "Automated Rain and Stream Gauges";

	    }

	    foreach ($categories as $category) {
	    	
	    	if (strtoupper($tempCategory) === strtoupper($category->name)){
	    	
				$categoryID = (string)$category->id;

			}

	    }

	    foreach ($sensors as $sensor) {
      		
	    	if (stripos(strtoupper($sensorLocation), strtoupper($sensor->assoc_file)) !== false){
	    	
				$sensorID = (string)$sensor->id;

			}

	    }
    	
    	$file = fopen($fileroot . $sensorLocation, "r");

		while(! feof($file)){

			$data[] = fgetcsv($file);

		}

		fclose($file);

		foreach ($data as $key => $_data) {
		
			if ($key > 7){
				
				if (!empty($_data)){

					switch ($tempCategory) {

						case "Automated Stream Gauges":

							$sensorData = array(
				               'sensor_id' => $sensorID,
				               'category_id' => $categoryID,
				               'date_time' => $_data[0],
				               'waterlevel' => $_data[1],
				               'rain_value' => "",
				               'air_pressure' => "",
				               'rain_intensity' => "",
				               'rain_duration' => "",
				               'air_temperature' => "",
				               'wind_speed' => "",
				               'wind_direction' => "",
				               'air_humidity' => "",
				               'solar_radiation' => "",
				               'wind_speed_max' => "",
				               'rain_cum' => "",
				               'sunshine_count' => "",
				               'sunshine_cum' => "",
				               'soil_moisture1' => "",
				               'soil_temperature1' => "",
				               'soil_moisture2' => "",
				               'soil_temperature2' => "",
				               'wind_direction_max' => "",
				            );

				            DB::table('tbl_hydromet_data')->insert($sensorData);

							break;

						case "Automated Rain Gauges":
							
							$sensorData = array(
				               'sensor_id' => $sensorID,
				               'category_id' => $categoryID,
				               'date_time' => $_data[0],
				               'waterlevel' => "",
				               'rain_value' => $_data[1],
				               'air_pressure' => $_data[2],
				               'rain_intensity' => "",
				               'rain_duration' => "",
				               'air_temperature' => "",
				               'wind_speed' => "",
				               'wind_direction' => "",
				               'air_humidity' => "",
				               'solar_radiation' => "",
				               'wind_speed_max' => "",
				               'rain_cum' => "",
				               'sunshine_count' => "",
				               'sunshine_cum' => "",
				               'soil_moisture1' => "",
				               'soil_temperature1' => "",
				               'soil_moisture2' => "",
				               'soil_temperature2' => "",
				               'wind_direction_max' => "",
				            );

				            DB::table('tbl_hydromet_data')->insert($sensorData);

							break;

						case "Automated Weather Stations":
							
							$sensorData = array(
				               'sensor_id' => $sensorID,
				               'category_id' => $categoryID,
				               'date_time' => $_data[0],
				               'waterlevel' => "",
				               'rain_value' => $_data[1],
				               'air_pressure' => $_data[5],
				               'rain_intensity' => $_data[2],
				               'rain_duration' => $_data[3],
				               'air_temperature' => $_data[4],
				               'wind_speed' => $_data[6],
				               'wind_direction' => $_data[7],
				               'air_humidity' => $_data[8],
				               'solar_radiation' => $_data[9],
				               'wind_speed_max' => $_data[10],
				               'rain_cum' => $_data[11],
				               'sunshine_count' => $_data[12],
				               'sunshine_cum' => $_data[13],
				               'soil_moisture1' => $_data[14],
				               'soil_temperature1' => $_data[15],
				               'soil_moisture2' => $_data[16],
				               'soil_temperature2' => $_data[17],
				               'wind_direction_max' => $_data[18],
				            );

				            DB::table('tbl_hydromet_data')->insert($sensorData);

							break;

						case "Automated Rain and Stream Gauges":
			
							$sensorData = array(
				               'sensor_id' => $sensorID,
				               'category_id' => $categoryID,
				               'date_time' => $_data[0],
				               'waterlevel' => $_data[1],
				               'rain_value' => $_data[2],
				               'air_pressure' => $_data[3],
				               'rain_intensity' => "",
				               'rain_duration' => "",
				               'air_temperature' => "",
				               'wind_speed' => "",
				               'wind_direction' => "",
				               'air_humidity' => "",
				               'solar_radiation' => "",
				               'wind_speed_max' => "",
				               'rain_cum' => "",
				               'sunshine_count' => "",
				               'sunshine_cum' => "",
				               'soil_moisture1' => "",
				               'soil_temperature1' => "",
				               'soil_moisture2' => "",
				               'soil_temperature2' => "",
				               'wind_direction_max' => "",
				            );

				            DB::table('tbl_hydromet_data')->insert($sensorData);

							break;
						
						default:
							
							break;

					}

				}

			}

		}

		unset($data);	

    }
    */

}
