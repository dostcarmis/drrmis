<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use DateTime;
use DateInterval;
use DatePeriod;
use app\Models\Sensors;
use DB;
class ReportController extends Controller {
    function __construct() {
        $this->middleware('auth');
    }
    public function showReport() {
        $provinces = DB::table('tbl_provinces')->get();
        return view('pages.report')->with(['provinces' => $provinces]);
    }
    public function getSensorLocation(Request $request) {
        $location = array();
        $displayType = $request->input('display_Type');
        $sensorType = $request->input('sensor_Type');
        $provinceID = $request->input('province_ID');
        $sensors = DB::table('tbl_sensors')->get();
        foreach ($sensors as $sensor) {
            $tempID = $sensor->id;
            if ($sensor->province_id == $provinceID && $sensor->category_id == $sensorType) {
                $location[] = "<option value='$tempID'>" . $sensor->address . "</option>";
            } else if ($sensor->province_id == $provinceID && $sensorType == "0") {
                if ($displayType == "1") {
                    $location[] = "<option value='$tempID'>" . $sensor->address . "</option>";
                } else {
                    if ($sensorType != "4") {
                        $location[] = "<option value='$tempID'>" . $sensor->address . "</option>";
                    }
                }
            }
        }
        return $location;
    }
    public function getSensorThreshold(Request $request) {
        $sensorID = $request->input('sensor_ID');
        $sensors = DB::table('tbl_sensors')->get();
        $thresholds = DB::table('tbl_threshold')->get();
        $thresholdData = array();
        $thFlood = "";
        $thLandslide = "";
        $categoryID = "";
        foreach ($sensors as $sensor) {
            if ($sensor->id == $sensorID) {
                $categoryID = $sensor->category_id;
            }
        }
        foreach ($thresholds as $threshold) {
            if ($threshold->address_id == $sensorID) {
                //$thFlood = $threshold->threshold_flood . " m";
                $thLandslide = $threshold->threshold_landslide . " mm";
                $thresholdData = array(
                    $thFlood,
                    $thLandslide,
                    $categoryID
                );
            }
        }
        if ($thFlood == "" || $thLandslide = "") {
            $thFlood = "Null";
            $thLandslide = "Null";
            $thresholdData = array( /*$thFlood*/
                "",
                $thLandslide,
                $categoryID
            );
        }
        return $thresholdData;
    }
    public function initializeDataGeneration(Request $request) {
        set_time_limit(0);
        $sensorID = array();
        $categoryID = array();
        $_sensorID = "";
        $data = json_encode(0);
        $displayType = $request->input('display_Type');
        $generateAllSensors = $request->input('generate_All_Sensors');
        $sensorType = $request->input('sensor_Type');
        $provinceID = $request->input('province_ID');
        $_sensorID = $request->input('sensor_ID');
        $dateStart = $request->input('date_Start');
        $dateEnd = $request->input('date_End');
        $toggleReportType = $request->input('toggle_Report_Type');
        $sensors = DB::table('tbl_sensors')->get();
        $provinces = DB::table('tbl_provinces')->get();
        /*
        $displayType = "2";
        $sensorType = "0";
        $provinceID = "1";
        $_sensorID = "88";
        $dateStart = "2017/02/01";
        $dateEnd = "2017/02/04";
        $generateAllSensors = "false";
        $sensors = DB::table('tbl_sensors')->get();
        $provinces = DB::table('tbl_provinces')->get();
        $toggleReportType = "1";
        */
        switch ($toggleReportType) {
            case '1':
                if ($generateAllSensors == "false") {
                    $sensorID[] = $_sensorID;
                    foreach ($sensors as $sensor) {
                        if ($_sensorID == $sensor->id) {
                            $categoryID[] = $sensor->category_id;
                            break;
                        }
                    }
                } else if ($generateAllSensors == "true") {
                    foreach ($provinces as $province) {
                        foreach ($sensors as $sensor) {
                            if (($sensor->category_id == "1" || $sensor->category_id == "3") && ($province->id == $sensor->province_id)) {
                                $sensorID[] = $sensor->id;
                                $categoryID[] = $sensor->category_id;
                            }
                        }
                    }
                }
                $data = $this->proccessData($displayType, $generateAllSensors, $sensorType, $provinceID, $sensorID, $categoryID, $dateStart, $dateEnd);
                return $data;
                break;
            case '2':
                $data = $this->showAllReportData("2");
                return $data;
                break;
            case '3':
                $data = $this->showAllReportData("3");
                return $data;
                break;
            case '4':
                $data = $this->showAllReportData("4");
                return $data;
                break;
            }
    }
    #================================================== HYDROMET DATA GENERATION ==================================================#
    /*
    =================================================================================
    =					PROCESS RANGES OF DATE FOR THE SENSOR						=
    =================================================================================
    */
    private function getDatePerYear($datePerDay, $dateListCount, $dateStart, $dateEnd) {
        $var_Count = 0;
        $datePerYear = array();
        for ($count4 = (int)$dateStart;$count4 <= (int)$dateEnd;$count4++) {
            for ($count3 = 0;$count3 < 12;$count3++) {
                for ($count2 = 0;$count2 < cal_days_in_month(CAL_GREGORIAN, $count3 + 1, $count4);$count2++) {
                    if ($var_Count < $dateListCount - 1) {
                        for ($count1 = 0;$count1 < 2;$count1++) {
                            $datePerYear[$count4][$count3][$count2][$count1] = $datePerDay[$var_Count][$count1];
                        }
                        $var_Count++;
                    } else {
                        break;
                    }
                }
            }
        }
        return $datePerYear;
    }
    private function getDatePerMonth($datePerDay, $dateListCount, $period) {
        $var_Count = 0;
        $datePerMonth = array();
        foreach ($period as $_dateList) {
            $dateList = $_dateList->format("Y/m/d");
            $dateList_Array = explode("/", $dateList);
            $_yearDate = (int)$dateList_Array[0];
            $_monthDate = (int)$dateList_Array[1];
            $_dayDate = (int)$dateList_Array[2];
            $yearDate[] = $_yearDate;
            $monthDate[] = $_monthDate;
            $dayDate[] = $_dayDate;
            if ($var_Count < $dateListCount - 1) {
                for ($count1 = 0;$count1 < 2;$count1++) {
                    $datePerMonth[$_yearDate][$_monthDate][$_dayDate][$count1] = $datePerDay[$var_Count][$count1];
                }
                $var_Count++;
            } else {
                break;
            }
        }
        return $datePerMonth;
    }
    private function getDatePerDay($displayType, $dateStart, $dateEnd) {
        $var_Count = 0;
        $dateList = array();
        $datePerDay = array();
        $datePerMonth = array();
        $datePerYear = array();
        $period = array();
        $begin = "";
        $end = "";
        if ($displayType == "1" || $displayType == "2" || $displayType == "3" || $displayType == "6") {
            $begin = new DateTime($dateStart);
            $end = new DateTime($dateEnd);
            $end = $end->modify('+1 day');
        } else if ($displayType == "4") {
            $daysEndMonth = 1;
            $dateStartArray = explode("/", $dateStart);
            $dateEndArray = explode("/", $dateEnd);
            if ($dateEndArray[0] === date("Y") && $dateEndArray[1] === date("m")) {
                for ($count = 1;$count <= date("d");$count++) {
                    $daysEndMonth = $count;
                }
            } else {
                $daysEndMonth = cal_days_in_month(CAL_GREGORIAN, $dateEndArray[1], $dateEndArray[0]);
            }
            $date_start = $dateStartArray[0] . "/" . sprintf("%02d", $dateStartArray[1]) . "/01";
            $date_end = $dateEndArray[0] . "/" . sprintf("%02d", $dateEndArray[1]) . "/" . sprintf("%02d", $daysEndMonth);
            $begin = new DateTime($date_start);
            $end = new DateTime($date_end);
            $end = $end->modify('+2 day');
        } else if ($displayType == "5") {
            $yearStart = $dateStart;
            $yearEnd = $dateEnd;
            if ($yearEnd == date("Y")) {
                $date_start = $yearStart . "/01/01";
                $date_end = date("Y/m/d");
            } else if ($yearEnd < date("Y")) {
                $date_start = $yearStart . "/01/01";
                $date_end = $yearEnd . "/12/31";
            }
            $begin = new DateTime($date_start);
            $end = new DateTime($date_end);
            $end = $end->modify('+2 day');
        } else if ($displayType == "0") {
            $begin = new DateTime($dateStart);
            $end = new DateTime($dateEnd);
            $end = $end->modify('+1 day');
        }
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($begin, $interval, $end);
        foreach ($period as $key => $_dateList) {
            $dateList[] = $_dateList->format("Y/m/d");
        }
        $dateListCount = count($dateList);
        if ($displayType != "0") {
            for ($count2 = 0;$count2 < $dateListCount - 1;$count2++) {
                for ($count1 = 0;$count1 < 2;$count1++) {
                    $datePerDay[$count2][$count1] = $dateList[$var_Count];
                    $var_Count++;
                }
                $var_Count--;
            }
        }
        if ($displayType == "1" || $displayType == "2" || $displayType == "3" || $displayType == "6") {
            return $datePerDay;
        } else if ($displayType == "4") {
            $datePerMonth = $this->getDatePerMonth($datePerDay, $dateListCount, $period);
            return $datePerMonth;
        } else if ($displayType == "5") {
            $datePerYear = $this->getDatePerYear($datePerDay, $dateListCount, $dateStart, $dateEnd);
            return $datePerYear;
        } else if ($displayType == "0") {
            return $dateList;
        }
    }
    #=============================================================================================================================
    private function processDataRanges($displayType, $generateAllSensors, $dateStart, $dateEnd) {
        $datePerDay = array();
        if ($generateAllSensors == "true") {
            if ($displayType == "3") {
                $displayType = "4";
            } else if ($displayType == "4") {
                if ($dateEnd == date("Y")) {
                    $dateStart.= "/01";
                    $dateEnd.= "/" . date("m");
                } else if ($dateEnd != date("Y")) {
                    $dateStart.= "/01";
                    $dateEnd.= "/12";
                }
            }
        }
        if ($displayType == "1" || $displayType == "2" || $displayType == "3" || $displayType == "4" || $displayType == "5" || $displayType == "6" || $displayType == "0") {
            $datePerDay = $this->getDatePerDay($displayType, $dateStart, $dateEnd);
            return $datePerDay;
        }
    }
    #=============================================================================================================================
    /*
    =================================================================================
    =					       GET DATA FROM DIRECTORY						        =
    =================================================================================
    */
    // Return all dates where the sensor does not send data
    private function getSensorDefectiveDate($sensorID, $startDayDate, $endDayDate) {
        $displayType = "0";
        $generateAllSensors = "false";
        $dateList = $this->processDataRanges($displayType, $generateAllSensors, $startDayDate, $endDayDate);
        $fileDirectory = "null";
        $sensors = DB::table('tbl_sensors')->get();
        $categories = DB::table('tbl_categories')->get();
        $tempFileName = "";
        $sensorDefectiveDate = array();
        $categoryID = "";
        $categoryName = "";
        $dateToday = date("Y") . "/" . sprintf("%02d", date("m")) . "/" . sprintf("%02d", date("d"));
        foreach ($dateList as $_date) {
            $date = explode("/", $_date);
            $fileDir = "data/" . $date[0] . "/" . sprintf("%02d", $date[1]) . "/" . sprintf("%02d", $date[2]) . "/";
            foreach ($sensors as $sensor) {
                if ($sensor->id == $sensorID) {
                    $tempFileName = $sensor->assoc_file;
                    $categoryID = $sensor->category_id;
                    break;
                }
            }
            foreach ($categories as $category) {
                if ($categoryID == $category->id) {
                    $categoryName = $category->name;
                    $categoryName = strtoupper($categoryName);
                    break;
                }
            }
            if (is_dir($fileDir)) {
                $fileNames = scandir($fileDir);
                $fileDirectory = "null";
                foreach ($fileNames as $fileName) {
                    if (stripos($fileName, $tempFileName) !== false) {
                        $fileDirectory = $fileDir . $fileName;
                        break;
                    }
                }
                if ($fileDirectory == "null") {
                    $sensorDefectiveDate[] = "$_date - No sensor data was transmitted.";
                } else if ($fileDirectory != "null") {
                    $file = fopen($fileDirectory, "r");
                    while (!feof($file)) {
                        $tempData[] = fgetcsv($file);
                    }
                    fclose($file);
                    $countData = count($tempData) - 7;
                    unset($tempData);
                    if ($countData == 0) {
                        $sensorDefectiveDate[] = "$_date - No sensor data was transmitted.";
                    } else {
                        if ($categoryName == "AUTOMATED RAIN GAUGES" && $_date != $dateToday) {
                            if ($countData > 0 && $countData < 96) {
                                $sensorDefectiveDate[] = "$_date - There is transmitted sensor data but incomplete.";
                            }
                        } else if ($categoryName == "AUTOMATED STREAM GAUGES" || $categoryName == "AUTOMATED RAIN AND STREAM GAUGES" && $_date != $dateToday) {
                            if ($countData > 0 && $countData < 144) {
                                $sensorDefectiveDate[] = "$_date - There is transmitted sensor data but incomplete.";
                            }
                        }
                    }
                }
            } else {
                $sensorDefectiveDate[] = "$_date - No sensor data was transmitted.";
            }
        }
        return $sensorDefectiveDate;
    }
    private function processDBData_Default_Hourly_Others($displayType, $categoryID, $sensorID, $dateArray, $startDayDate, $endDayDate) {
        $fileDir = "";
        $fileDirectory = "null";
        $date = array();
        $sensorData = array();
        $sensorDefectiveDate = array();
        $data = json_encode(0);
        $waterlevel = array();
        $cumulativeRain = 0;
        $lowestWaterlevel = 0;
        $highestWaterlevel = 0;
        $firstDataInput = true;
        $firstDataInput2 = true;
        $referenceHour = 8;
        $referenceHour2 = 0;
        //$_toggleTimeRange = false;
        foreach ($dateArray as $keyDateArray => $_dateArray) {
            if ($displayType == "1" || $displayType == "2") {
                $firstDataInput = true;
                $firstDataInput2 = true;
                $referenceHour = 8;
                $referenceHour2 = 0;
                $cumulativeRain = 0;
            }
            foreach ($_dateArray as $key => $_dateTime) {
                $tempData = array();
                $fileNames = array();
                $_date = date_create($_dateTime);
                $_date = date_format($_date, "Y/m/d");
                $date = explode("/", $_date);
                $fileDir = "data/" . $date[0] . "/" . sprintf("%02d", $date[1]) . "/" . sprintf("%02d", $date[2]) . "/";
                $tempFileName = "";
                $sensors = DB::table('tbl_sensors')->get();
                $fileDirectory = "null";
                if (is_dir($fileDir)) {
                    $fileNames = scandir($fileDir);
                    foreach ($sensors as $sensor) {
                        if ($sensor->id == $sensorID) {
                            $tempFileName = $sensor->assoc_file;
                            break;
                        }
                    }
                    foreach ($fileNames as $fileName) {
                        if (stripos($fileName, $tempFileName) !== false) {
                            $fileDirectory = $fileDir . $fileName;
                            break;
                        }
                    }
                }
                if ($key == 0) {
                    $toggleNextDay = false;
                } else if ($key == 1) {
                    $toggleNextDay = true;
                }
                if ($fileDirectory != "null") {
                    $file = fopen($fileDirectory, "r");
                    while (!feof($file)) {
                        $tempData[] = fgetcsv($file);
                    }
                    fclose($file);
                    foreach ($tempData as $keyData => $_data) {
                        $countDateString = strlen($_data[0]);
                        if ($keyData > 7 && $countDateString > 2) {
                            $tempDateTime = date_create($_data[0]);
                            $tempDate = date_format($tempDateTime, "Y-m-d H:i:s");
                            //$tempTime = date_format($tempDateTime, "H:i:s");
                            $timeHour = date_format($tempDateTime, "H");
                            $timeMinute = date_format($tempDateTime, "i");
                            switch ($categoryID) {
                                case '1':
                                    $rainValue = round((float)$_data[1], 2);
                                    $airPressure = round((float)$_data[2], 2);
                                    if ($displayType == "1") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $cumulativeRain+= $rainValue;
                                            $cumulativeRain = round((float)$cumulativeRain, 2);
                                            $sensorData[] = array(
                                                "date_read" => $tempDate,
                                                "rain_value" => $rainValue,
                                                "rain_cumulative" => $cumulativeRain,
                                                "air_pressure" => $airPressure
                                            );
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $cumulativeRain+= $rainValue;
                                            $cumulativeRain = round((float)$cumulativeRain, 2);
                                            $sensorData[] = array(
                                                "date_read" => $tempDate,
                                                "rain_value" => $rainValue,
                                                "rain_cumulative" => $cumulativeRain,
                                                "air_pressure" => $airPressure
                                            );
                                        }
                                    } else if ($displayType == "2") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $cumulativeRain+= $rainValue;
                                            $cumulativeRain = round((float)$cumulativeRain, 2);
                                            if ($timeHour == $referenceHour) {
                                                if ($firstDataInput) {
                                                    $sensorData[] = array(
                                                        "date_read" => $tempDate,
                                                        "rain_value" => $rainValue,
                                                        "rain_cumulative" => $cumulativeRain,
                                                        "air_pressure" => $airPressure
                                                    );
                                                }
                                                $firstDataInput = false;
                                                $referenceHour++;
                                            } else {
                                                $firstDataInput = true;
                                            }
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $cumulativeRain+= $rainValue;
                                            $cumulativeRain = round((float)$cumulativeRain, 2);
                                            if ($timeHour == $referenceHour2) {
                                                if ($firstDataInput2) {
                                                    $sensorData[] = array(
                                                        "date_read" => $tempDate,
                                                        "rain_value" => $rainValue,
                                                        "rain_cumulative" => $cumulativeRain,
                                                        "air_pressure" => $airPressure
                                                    );
                                                }
                                                $firstDataInput2 = false;
                                                $referenceHour2++;
                                            } else {
                                                $firstDataInput2 = true;
                                            }
                                        }
                                    } else if ($displayType == "6") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $cumulativeRain+= $rainValue;
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $cumulativeRain+= $rainValue;
                                        }
                                    }
                                    break;
                                case '2':
                                    $waterlevelValue = round((float)$_data[1] * 100, 2);
                                    if ($displayType == "1") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $sensorData[] = array(
                                                "date_read" => $tempDate,
                                                "waterlevel" => $waterlevelValue
                                            );
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $sensorData[] = array(
                                                "date_read" => $tempDate,
                                                "waterlevel" => $waterlevelValue
                                            );
                                        }
                                    } else if ($displayType == "2") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $waterlevel[] = $waterlevelValue;
                                            $lowestWaterlevel = min($waterlevel);
                                            $highestWaterlevel = max($waterlevel);
                                            if ($timeHour == $referenceHour) {
                                                if ($firstDataInput) {
                                                    $sensorData[] = array(
                                                        "date_read" => $tempDate,
                                                        "lowest_waterlevel" => $lowestWaterlevel,
                                                        "highest_waterlevel" => $highestWaterlevel
                                                    );
                                                    unset($waterlevel);
                                                    $waterlevel = array();
                                                    $lowestWaterlevel = 0;
                                                    $highestWaterlevel = 0;
                                                }
                                                $firstDataInput = false;
                                                $referenceHour++;
                                            } else {
                                                $firstDataInput = true;
                                            }
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            if ($timeHour == $referenceHour2) {
                                                if ($firstDataInput2) {
                                                    $sensorData[] = array(
                                                        "date_read" => $tempDate,
                                                        "lowest_waterlevel" => $lowestWaterlevel,
                                                        "highest_waterlevel" => $highestWaterlevel
                                                    );
                                                    unset($waterlevel);
                                                    $waterlevel = array();
                                                    $lowestWaterlevel = 0;
                                                    $highestWaterlevel = 0;
                                                }
                                                $firstDataInput2 = false;
                                                $referenceHour2++;
                                            } else {
                                                $firstDataInput2 = true;
                                            }
                                        }
                                    } else if ($displayType == "6") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $waterlevel[] = $waterlevelValue;
                                            $lowestWaterlevel = min($waterlevel);
                                            $highestWaterlevel = max($waterlevel);
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $waterlevel[] = $waterlevelValue;
                                            $lowestWaterlevel = min($waterlevel);
                                            $highestWaterlevel = max($waterlevel);
                                        }
                                    }
                                    break;
                                case '3':
                                    $rainValue = round((float)$_data[1], 2);
                                    $waterlevelValue = round((float)$_data[2] * 100, 2);
                                    $airPressure = round((float)$_data[4], 2);
                                    if ($displayType == "1") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $cumulativeRain+= $rainValue;
                                            $sensorData[] = array(
                                                "date_read" => $tempDate,
                                                "rain_value" => $rainValue,
                                                "rain_cumulative" => $cumulativeRain,
                                                "waterlevel" => $waterlevelValue,
                                                "air_pressure" => $airPressure
                                            );
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $cumulativeRain+= $rainValue;
                                            $sensorData[] = array(
                                                "date_read" => $tempDate,
                                                "rain_value" => $rainValue,
                                                "rain_cumulative" => $cumulativeRain,
                                                "waterlevel" => $waterlevelValue,
                                                "air_pressure" => $airPressure
                                            );
                                        }
                                    } else if ($displayType == "2") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $cumulativeRain+= $rainValue;
                                            $cumulativeRain = round((float)$cumulativeRain, 2);
                                            $waterlevel[] = $waterlevelValue;
                                            $lowestWaterlevel = min($waterlevel);
                                            $highestWaterlevel = max($waterlevel);
                                            if ($timeHour == $referenceHour) {
                                                if ($firstDataInput) {
                                                    $sensorData[] = array(
                                                        "date_read" => $tempDate,
                                                        "rain_value" => $rainValue,
                                                        "rain_cumulative" => $cumulativeRain,
                                                        "lowest_waterlevel" => $lowestWaterlevel,
                                                        "highest_waterlevel" => $highestWaterlevel,
                                                        "air_pressure" => $airPressure
                                                    );
                                                    unset($waterlevel);
                                                    $waterlevel = array();
                                                    $lowestWaterlevel = 0;
                                                    $highestWaterlevel = 0;
                                                }
                                                $firstDataInput = false;
                                                $referenceHour++;
                                            } else {
                                                $firstDataInput = true;
                                            }
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $cumulativeRain+= $rainValue;
                                            $cumulativeRain = round((float)$cumulativeRain, 2);
                                            if ($timeHour == $referenceHour2) {
                                                if ($firstDataInput2) {
                                                    $sensorData[] = array(
                                                        "date_read" => $tempDate,
                                                        "rain_value" => $rainValue,
                                                        "rain_cumulative" => $cumulativeRain,
                                                        "lowest_waterlevel" => $lowestWaterlevel,
                                                        "highest_waterlevel" => $highestWaterlevel,
                                                        "air_pressure" => $airPressure
                                                    );
                                                    unset($waterlevel);
                                                    $waterlevel = array();
                                                    $lowestWaterlevel = 0;
                                                    $highestWaterlevel = 0;
                                                }
                                                $firstDataInput2 = false;
                                                $referenceHour2++;
                                            } else {
                                                $firstDataInput2 = true;
                                            }
                                        }
                                    } else if ($displayType == "6") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $cumulativeRain+= $rainValue;
                                            $waterlevel[] = $waterlevelValue;
                                            $lowestWaterlevel = min($waterlevel);
                                            $highestWaterlevel = max($waterlevel);
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $cumulativeRain+= $rainValue;
                                            $waterlevel[] = $waterlevelValue;
                                            $lowestWaterlevel = min($waterlevel);
                                            $highestWaterlevel = max($waterlevel);
                                        }
                                    }
                                    break;
                                case '4':
                                    $rainValue = round((float)$_data[1], 2);
                                    $rainIntensity = round((float)$_data[2], 2);
                                    $rainDuration = round((float)$_data[3], 2);
                                    $airTemperature = round((float)$_data[4], 2);
                                    $airPressure = round((float)$_data[5], 2);
                                    $windSpeed = round((float)$_data[6], 2);
                                    $windDirection = round((float)$_data[7], 2);
                                    $airHumidity = round((float)$_data[8], 2);
                                    $windSpeedMax = round((float)$_data[9], 2);
                                    $solarRadiation = round((float)$_data[10], 2);
                                    $rainCum = round((float)$_data[11], 2);
                                    $sunshineCount = round((float)$_data[12], 2);
                                    $sunshineCum = round((float)$_data[13], 2);
                                    $soilMoisture1 = round((float)$_data[14], 2);
                                    $soilTemperature1 = round((float)$_data[15], 2);
                                    $soilMoisture2 = round((float)$_data[16], 2);
                                    $soilTemperature2 = round((float)$_data[17], 2);
                                    $windDirectionMax = round((float)$_data[18], 2);
                                    if ($displayType == "1") {
                                        if (!$toggleNextDay && $timeHour >= 8) {
                                            $sensorData[] = array(
                                                "date_read" => $tempDate,
                                                "rain_value" => $rainValue,
                                                "rain_intensity" => $rainIntensity,
                                                "rain_duration" => $rainDuration,
                                                "air_temperature" => $airTemperature,
                                                "air_pressure" => $airPressure,
                                                "wind_speed" => $windSpeed,
                                                "wind_direction" => $windDirection,
                                                "air_humidity" => $airHumidity,
                                                "wind_speed_max" => $windSpeedMax,
                                                "solar_radiation" => $solarRadiation,
                                                "rain_cum" => $rainCum,
                                                "sunshine_count" => $sunshineCount,
                                                "sunshine_cum" => $sunshineCum,
                                                "soil_moisture1" => $soilMoisture1,
                                                "soil_temperature1" => $soilTemperature1,
                                                "soil_moisture2" => $soilMoisture2,
                                                "soil_temperature2" => $soilTemperature2,
                                                "wind_direction_max" => $windDirectionMax
                                            );
                                        } else if ($toggleNextDay && $timeHour < 8) {
                                            $sensorData[] = array(
                                                "date_read" => $tempDateTime,
                                                "rain_value" => $rainValue,
                                                "rain_intensity" => $rainIntensity,
                                                "rain_duration" => $rainDuration,
                                                "air_temperature" => $airTemperature,
                                                "air_pressure" => $airPressure,
                                                "wind_speed" => $windSpeed,
                                                "wind_direction" => $windDirection,
                                                "air_humidity" => $airHumidity,
                                                "wind_speed_max" => $windSpeedMax,
                                                "solar_radiation" => $solarRadiation,
                                                "rain_cum" => $rainCum,
                                                "sunshine_count" => $sunshineCount,
                                                "sunshine_cum" => $sunshineCum,
                                                "soil_moisture1" => $soilMoisture1,
                                                "soil_temperature1" => $soilTemperature1,
                                                "soil_moisture2" => $soilMoisture2,
                                                "soil_temperature2" => $soilTemperature2,
                                                "wind_direction_max" => $windDirectionMax
                                            );
                                        }
                                    }
                                    break;
                                default:
                                    # code...
                                    break;
                                }
                            }
                        }
                        unset($tempData);
                    }
                }
            }
            if ($displayType == "6") {
                $dateRangeCount = count($dateArray);
                $startingDate = $dateArray[0][0];
                $endingDate = $dateArray[$dateRangeCount - 1][0];
                switch ($categoryID) {
                    case '1':
                        $cumulativeRain = round((float)$cumulativeRain, 2);
                        $sensorData[] = array(
                            "date_start" => $startingDate,
                            "date_end" => $endingDate,
                            "rain_cumulative" => $cumulativeRain
                        );
                    break;
                    case '2':
                        $cumulativeRain = round((float)$cumulativeRain, 2);
                        $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                        $highestWaterlevel = round((float)$highestWaterlevel, 2);
                        $sensorData[] = array(
                            "date_start" => $startingDate,
                            "date_end" => $endingDate,
                            "lowest_waterlevel" => $lowestWaterlevel,
                            "highest_waterlevel" => $highestWaterlevel
                        );
                    break;
                    case '3':
                        $cumulativeRain = round((float)$cumulativeRain, 2);
                        $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                        $highestWaterlevel = round((float)$highestWaterlevel, 2);
                        $sensorData[] = array(
                            "date_start" => $startingDate,
                            "date_end" => $endingDate,
                            "lowest_waterlevel" => $lowestWaterlevel,
                            "highest_waterlevel" => $highestWaterlevel,
                            "rain_cumulative" => $cumulativeRain
                        );
                    break;
                    default:
                        # code...
                        
                    break;
                }
            }
            $sensorDefectiveDate = $this->getSensorDefectiveDate($sensorID, $startDayDate, $endDayDate);
            $_data = array(
                "sensor_data" => $sensorData,
                "defective_date" => $sensorDefectiveDate
            );
            $data = json_encode($_data);
            return $data;
        }
        private function processDBData_Daily($categoryID, $sensorID, $generateAllSensors, $_dateArray, $startDayDate, $endDayDate) {
            $sensorData = array();
            $data = json_encode(0);
            $dateArray = array();
            if ($generateAllSensors == "true") {
                foreach ($_dateArray as $arrayDate) {
                    foreach ($arrayDate as $arrayDate2) {
                        foreach ($arrayDate2 as $arrayDate3) {
                            $dateArray[] = $arrayDate3;
                        }
                    }
                }
            } else if ($generateAllSensors == "false") {
                $dateArray = $_dateArray;
            }
            foreach ($sensorID as $sensorkey => $_sensorID) {
                $addressName = "";
                $categoryName = "";
                $provinceName = "";
                $provinceID = "";
                $fileDir = "";
                $fileDirectory = "null";
                $date = array();
                $tempDataArray = array();
                $waterlevel = array();
                $cumulativeRain = 0;
                $lowestWaterlevel = 0;
                $highestWaterlevel = 0;
                $firstDataInput = true;
                $firstDataInput2 = true;
                $referenceHour = 8;
                $referenceHour2 = 0;
                $sensorDefectiveDate = $this->getSensorDefectiveDate($_sensorID, $startDayDate, $endDayDate);
                foreach ($dateArray as $keyDate => $_dateArray) {
                    foreach ($_dateArray as $key => $_dateTime) {
                        $tempData = array();
                        $fileNames = array();
                        $_date = date_create($_dateTime);
                        $_date = date_format($_date, "Y/m/d");
                        $date = explode("/", $_date);
                        $fileDir = "data/" . $date[0] . "/" . sprintf("%02d", $date[1]) . "/" . sprintf("%02d", $date[2]) . "/";
                        $tempFileName = "";
                        $sensors = DB::table('tbl_sensors')->get();
                        $provinces = DB::table('tbl_provinces')->get();
                        if (is_dir($fileDir)) {
                            $fileNames = scandir($fileDir);
                        }
                        foreach ($sensors as $sensor) {
                            if ($sensor->id == $_sensorID) {
                                $tempFileName = $sensor->assoc_file;
                                $addressName = $sensor->address;
                                $provinceID = $sensor->province_id;
                                if ($sensor->category_id == "1") {
                                    $categoryName = "ARG";
                                } else if ($sensor->category_id == "3") {
                                    $categoryName = "TDM";
                                }
                                break;
                            }
                        }
                        foreach ($provinces as $province) {
                            if ($provinceID == $province->id) {
                                $provinceName = $province->name;
                            }
                        }
                        $fileDirectory = "null";
                        foreach ($fileNames as $fileName) {
                            if (stripos($fileName, $tempFileName) !== false) {
                                $fileDirectory = $fileDir . $fileName;
                                break;
                            }
                        }
                        if ($key == 0) {
                            $toggleNextDay = false;
                        } else if ($key == 1) {
                            $toggleNextDay = true;
                        }
                        if ($fileDirectory != "null") {
                            $file = fopen($fileDirectory, "r");
                            while (!feof($file)) {
                                $tempData[] = fgetcsv($file);
                            }
                            fclose($file);
                            foreach ($tempData as $keyData => $_data) {
                                $countDateString = strlen($_data[0]);
                                if ($keyData > 7 && $countDateString > 2) {
                                    $tempDateTime = date_create($_data[0]);
                                    $tempDate = date_format($tempDateTime, "Y/m/d");
                                    $tempTime = date_format($tempDateTime, "H:i:s");
                                    $timeHour = date_format($tempDateTime, "H");
                                    $timeMinute = date_format($tempDateTime, "i");
                                    switch ($categoryID[$sensorkey]) {
                                        case '1':
                                            $rainValue = (float)$_data[1];
                                            //$airPressure = (float)$_data[2];
                                            if (!$toggleNextDay && $timeHour >= 8) {
                                                $cumulativeRain+= $rainValue;
                                            } else if ($toggleNextDay && $timeHour < 8) {
                                                $cumulativeRain+= $rainValue;
                                            }
                                            break;
                                        case '2':
                                            $waterlevelValue = (float)($_data[1] * 100);
                                            if (!$toggleNextDay && $timeHour >= 8) {
                                                $waterlevel[] = $waterlevelValue;
                                                $lowestWaterlevel = min($waterlevel);
                                                $highestWaterlevel = max($waterlevel);
                                            } else if ($toggleNextDay && $timeHour < 8) {
                                                $waterlevel[] = $waterlevelValue;
                                                $lowestWaterlevel = min($waterlevel);
                                                $highestWaterlevel = max($waterlevel);
                                            }
                                            break;
                                        case '3':
                                            $rainValue = (float)$_data[1];
                                            $waterlevelValue = (float)($_data[2] * 100);
                                            //$airPressure = (float)$_data[4];
                                            if (!$toggleNextDay && $timeHour >= 8) {
                                                $cumulativeRain+= $rainValue;
                                                $waterlevel[] = $waterlevelValue;
                                                $lowestWaterlevel = min($waterlevel);
                                                $highestWaterlevel = max($waterlevel);
                                            } else if ($toggleNextDay && $timeHour < 8) {
                                                $cumulativeRain+= $rainValue;
                                                $waterlevel[] = $waterlevelValue;
                                                $lowestWaterlevel = min($waterlevel);
                                                $highestWaterlevel = max($waterlevel);
                                            }
                                            break;
                                        case '4':
                                            break;
                                        default:
                                            # code...
                                            break;
                                        }
                                    }
                                }
                                unset($tempData);
                        }
                    }
                    $firstDataInput = true;
                    $firstDataInput2 = true;
                    $referenceHour = 8;
                    $referenceHour2 = 0;
                    switch ($categoryID[$sensorkey]) {
                        case '1':
                            $cumulativeRain = round((float)$cumulativeRain, 2);
                            if ($generateAllSensors == "false") {
                                $sensorData[] = array(
                                    "date_read" => $dateArray[$keyDate][0],
                                    "rain_cumulative" => $cumulativeRain
                                );
                            } else if ($generateAllSensors == "true") {
                                $tempStr = $dateArray[$keyDate][0];
                                $tempStr = str_replace("/", "_", $tempStr);
                                $tempStr = "d" . $tempStr;
                                $tempDataArray[$tempStr] = "$cumulativeRain mm";
                            }
                            break;
                        case '2':
                            $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                            $highestWaterlevel = round((float)$highestWaterlevel, 2);
                            $sensorData[] = array(
                                "date_read" => $dateArray[$keyDate][0],
                                "lowest_waterlevel" => $lowestWaterlevel,
                                "highest_waterlevel" => $highestWaterlevel
                            );
                            break;
                        case '3':
                            $cumulativeRain = round((float)$cumulativeRain, 2);
                            if ($generateAllSensors == "false") {
                                $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                                $highestWaterlevel = round((float)$highestWaterlevel, 2);
                                $sensorData[] = array(
                                    "date_read" => $dateArray[$keyDate][0],
                                    "rain_cumulative" => $cumulativeRain,
                                    "lowest_waterlevel" => $lowestWaterlevel,
                                    "highest_waterlevel" => $highestWaterlevel
                                );
                            } else if ($generateAllSensors == "true") {
                                $tempStr = $dateArray[$keyDate][0];
                                $tempStr = str_replace("/", "_", $tempStr);
                                $tempStr = "d" . $tempStr;
                                $tempDataArray[$tempStr] = "$cumulativeRain mm";
                            }
                            break;
                        case '4':
                            break;
                        default:
                            # code...
                            break;
                        }
                        $lowestWaterlevel = 0;
                        $highestWaterlevel = 0;
                        $cumulativeRain = 0;
                        unset($waterlevel);
                        $waterlevel = array();
                    }
                    if ($generateAllSensors == "true") {
                        $tempDates = "";
                        foreach ($sensorDefectiveDate as $strDate) {
                            $tempDates.= "[ $strDate ]" . "\n";
                        }
                        $tempDataArray["defective_date"] = $tempDates;
                        $tempDataArray["sensor_location"] = $addressName;
                        $tempDataArray["category_name"] = $categoryName;
                        $tempDataArray["province_name"] = $provinceName;
                        $sensorData[] = $tempDataArray;
                        unset($tempDataArray);
                    }
            }
            if ($generateAllSensors == "true") {
                $data = json_encode($sensorData);
            } else if ($generateAllSensors == "false") {
                $_data = array(
                    "sensor_data" => $sensorData,
                    "defective_date" => $sensorDefectiveDate
                );
                $data = json_encode($_data);
            }
            return $data;
        }
        private function processDBData_Monthly($categoryID, $sensorID, $generateAllSensors, $dateStart, $dateEnd, $dateArray, $startDayDate, $endDayDate) {
            $sensorData = array();
            $sensorDefectiveDate = array();
            $data = json_encode(0);
            if ($generateAllSensors == "true") {
                if ($dateEnd == date("Y")) {
                    $dateStart.= "/01";
                    $dateEnd.= "/" . date("m");
                } else if ($dateEnd != date("Y")) {
                    $dateStart.= "/01";
                    $dateEnd.= "/12";
                }
            }
            foreach ($sensorID as $sensorkey => $_sensorID) {
                $addressName = "";
                $categoryName = "";
                $provinceName = "";
                $provinceID = "";
                $fileDir = "";
                $fileDirectory = "null";
                $date = array();
                $tempDataArray = array();
                $dateRange = array();
                $_dateRange = array();
                $tempRange = array();
                $waterlevel = array();
                $cumulativeRain = 0;
                $lowestWaterlevel = 0;
                $highestWaterlevel = 0;
                $firstDataInput = true;
                $firstDataInput2 = true;
                $referenceHour = 8;
                $referenceHour2 = 0;
                $sensorDefectiveDate = $this->getSensorDefectiveDate($_sensorID, $startDayDate, $endDayDate);
                $begin = new DateTime($dateStart . "/1");
                $end = new DateTime($dateEnd . "/1");
                $end = $end->modify('+1 day');
                $interval = new DateInterval('P1D');
                $period = new DatePeriod($begin, $interval, $end);
                foreach ($period as $_dateList) {
                    $_dateRange[] = $_dateList->format("Y/m");
                }
                $tempRange = array_unique($_dateRange);
                foreach ($tempRange as $range) {
                    if ($range != "") {
                        $dateRange[] = $range;
                    }
                }
                $monthCounter = 0;
                $monthDate = 0;
                foreach ($dateArray as $keyDate => $_dateArray) {
                    foreach ($_dateArray as $key => $__dateTime) {
                        if ($monthCounter < count($dateRange)) {
                            $monthDate = $dateRange[$monthCounter] . "/01";
                            $monthDate = date_create($monthDate);
                            $monthDate = date_format($monthDate, "F - Y");
                        }
                        $monthCounter++;
                        foreach ($__dateTime as $_dateTime) {
                            foreach ($_dateTime as $keyDate => $dateTime) {
                                $tempData = array();
                                $fileNames = array();
                                $_date = date_create($dateTime);
                                $_date = date_format($_date, "Y/m/d");
                                $date = explode("/", $_date);
                                $fileDir = "data/" . $date[0] . "/" . sprintf("%02d", $date[1]) . "/" . sprintf("%02d", $date[2]) . "/";
                                $tempFileName = "";
                                $sensors = DB::table('tbl_sensors')->get();
                                $provinces = DB::table('tbl_provinces')->get();
                                $fileDirectory = "null";
                                if (is_dir($fileDir)) {
                                    $fileNames = scandir($fileDir);
                                    foreach ($sensors as $sensor) {
                                        if ($sensor->id == $_sensorID) {
                                            $tempFileName = $sensor->assoc_file;
                                            $addressName = $sensor->address;
                                            $provinceID = $sensor->province_id;
                                            if ($sensor->category_id == "1") {
                                                $categoryName = "ARG";
                                            } else if ($sensor->category_id == "3") {
                                                $categoryName = "TDM";
                                            }
                                            break;
                                        }
                                    }
                                    foreach ($provinces as $province) {
                                        if ($provinceID == $province->id) {
                                            $provinceName = $province->name;
                                        }
                                    }
                                    foreach ($fileNames as $fileName) {
                                        if (stripos($fileName, $tempFileName) !== false) {
                                            $fileDirectory = $fileDir . $fileName;
                                            break;
                                        }
                                    }
                                }
                                if ($keyDate == 0) {
                                    $toggleNextDay = false;
                                } else if ($keyDate == 1) {
                                    $toggleNextDay = true;
                                }
                                if ($fileDirectory != "null") {
                                    $file = fopen($fileDirectory, "r");
                                    while (!feof($file)) {
                                        $tempData[] = fgetcsv($file);
                                    }
                                    fclose($file);
                                    foreach ($tempData as $keyData => $_data) {
                                        $countDateString = strlen($_data[0]);
                                        if ($keyData > 7 && $countDateString > 2) {
                                            $tempDateTime = date_create($_data[0]);
                                            $tempDate = date_format($tempDateTime, "Y/m/d");
                                            $tempTime = date_format($tempDateTime, "H:i:s");
                                            $timeHour = date_format($tempDateTime, "H");
                                            $timeMinute = date_format($tempDateTime, "i");
                                            switch ($categoryID[$sensorkey]) {
                                                case '1':
                                                    $rainValue = (float)$_data[1];
                                                    //$airPressure = (float)$_data[2];
                                                    if (!$toggleNextDay && $timeHour >= 8) {
                                                        $cumulativeRain+= $rainValue;
                                                    } else if ($toggleNextDay && $timeHour < 8) {
                                                        $cumulativeRain+= $rainValue;
                                                    }
                                                    break;
                                                case '2':
                                                    $waterlevelValue = (float)($_data[1] * 100);
                                                    if (!$toggleNextDay && $timeHour >= 8) {
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    } else if ($toggleNextDay && $timeHour < 8) {
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    }
                                                    break;
                                                case '3':
                                                    $rainValue = (float)$_data[1];
                                                    $waterlevelValue = (float)($_data[2] * 100);
                                                    //$airPressure = (float)$_data[4];
                                                    if (!$toggleNextDay && $timeHour >= 8) {
                                                        $cumulativeRain+= $rainValue;
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    } else if ($toggleNextDay && $timeHour < 8) {
                                                        $cumulativeRain+= $rainValue;
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    }
                                                    break;
                                                case '4':
                                                    break;
                                                default:
                                                    # code...
                                                    break;
                                                }
                                            }
                                        }
                                        unset($tempData);
                                }
                            }
                            $firstDataInput = true;
                            $firstDataInput2 = true;
                            $referenceHour = 8;
                            $referenceHour2 = 0;
                        }
                        switch ($categoryID[$sensorkey]) {
                            case '1':
                                $cumulativeRain = round((float)$cumulativeRain, 2);
                                if ($generateAllSensors == "false") {
                                    $sensorData[] = array(
                                        "date_read" => $monthDate,
                                        "rain_cumulative" => $cumulativeRain
                                    );
                                } else if ($generateAllSensors == "true") {
                                    $tempStr = $monthDate;
                                    $tempStr = str_replace(" ", "", $tempStr);
                                    $tempStr = str_replace("-", "_", $tempStr);
                                    $tempDataArray[$tempStr] = "$cumulativeRain mm";
                                }
                                break;
                            case '2':
                                $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                                $highestWaterlevel = round((float)$highestWaterlevel, 2);
                                $sensorData[] = array(
                                    "date_read" => $monthDate,
                                    "lowest_waterlevel" => $lowestWaterlevel,
                                    "highest_waterlevel" => $highestWaterlevel
                                );
                                break;
                            case '3':
                                $cumulativeRain = round((float)$cumulativeRain, 2);
                                if ($generateAllSensors == "false") {
                                    $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                                    $highestWaterlevel = round((float)$highestWaterlevel, 2);
                                    $sensorData[] = array(
                                        "date_read" => $monthDate,
                                        "rain_cumulative" => $cumulativeRain,
                                        "lowest_waterlevel" => $lowestWaterlevel,
                                        "highest_waterlevel" => $highestWaterlevel
                                    );
                                } else if ($generateAllSensors == "true") {
                                    $tempStr = $monthDate;
                                    $tempStr = str_replace(" ", "", $tempStr);
                                    $tempStr = str_replace("-", "_", $tempStr);
                                    $tempDataArray[$tempStr] = "$cumulativeRain mm";
                                }
                                break;
                            default:
                                # code...
                                break;
                            }
                            $lowestWaterlevel = 0;
                            $highestWaterlevel = 0;
                            $cumulativeRain = 0;
                            unset($waterlevel);
                            $waterlevel = array();
                        }
                        if ($generateAllSensors == "true") {
                            $tempDates = "";
                            foreach ($sensorDefectiveDate as $strDate) {
                                $tempDates.= "[ $strDate ]" . "\n";
                            }
                            $tempDataArray["defective_date"] = $tempDates;
                            $tempDataArray["sensor_location"] = $addressName;
                            $tempDataArray["category_name"] = $categoryName;
                            $tempDataArray["province_name"] = $provinceName;
                            $sensorData[] = $tempDataArray;
                            unset($tempDataArray);
                        }
                }
            }
            if ($generateAllSensors == "true") {
                $data = json_encode($sensorData);
            } else if ($generateAllSensors == "false") {
                $_data = array(
                    "sensor_data" => $sensorData,
                    "defective_date" => $sensorDefectiveDate
                );
                $data = json_encode($_data);
            }
            return $data;
        }
        private function processDBData_Yearly($categoryID, $sensorID, $generateAllSensors, $dateStart, $dateEnd, $dateArray, $startDayDate, $endDayDate) {
            $sensorData = array();
            $data = json_encode(0);
            foreach ($sensorID as $sensorkey => $_sensorID) {
                $addressName = "";
                $categoryName = "";
                $provinceName = "";
                $provinceID = "";
                $fileDir = "";
                $fileDirectory = "null";
                $date = array();
                $tempDataArray = array();
                $dateRange = array();
                $waterlevel = array();
                $cumulativeRain = 0;
                $lowestWaterlevel = 0;
                $highestWaterlevel = 0;
                $firstDataInput = true;
                $firstDataInput2 = true;
                $referenceHour = 8;
                $referenceHour2 = 0;
                $sensorDefectiveDate = $this->getSensorDefectiveDate($_sensorID, $startDayDate, $endDayDate);
                for ($dateCounter = $dateStart;$dateCounter <= $dateEnd;$dateCounter++) {
                    $dateRange[] = $dateCounter;
                }
                $counter = 0;
                $yearDate = 0;
                foreach ($dateArray as $_dateArray) {
                    foreach ($_dateArray as $keyYear => $year) {
                        foreach ($year as $month) {
                            foreach ($month as $keyDate => $day) {
                                $tempData = array();
                                $fileNames = array();
                                $_date = date_create($day);
                                $_date = date_format($_date, "Y/m/d");
                                $date = explode("/", $_date);
                                $fileDir = "data/" . $date[0] . "/" . sprintf("%02d", $date[1]) . "/" . sprintf("%02d", $date[2]) . "/";
                                $tempFileName = "";
                                $sensors = DB::table('tbl_sensors')->get();
                                $provinces = DB::table('tbl_provinces')->get();
                                $fileDirectory = "null";
                                if (is_dir($fileDir)) {
                                    $fileNames = scandir($fileDir);
                                    foreach ($sensors as $sensor) {
                                        if ($sensor->id == $_sensorID) {
                                            $tempFileName = $sensor->assoc_file;
                                            $addressName = $sensor->address;
                                            $provinceID = $sensor->province_id;
                                            if ($sensor->category_id == "1") {
                                                $categoryName = "ARG";
                                            } else if ($sensor->category_id == "3") {
                                                $categoryName = "TDM";
                                            }
                                            break;
                                        }
                                    }
                                    foreach ($provinces as $province) {
                                        if ($provinceID == $province->id) {
                                            $provinceName = $province->name;
                                        }
                                    }
                                    foreach ($fileNames as $fileName) {
                                        if (stripos($fileName, $tempFileName) !== false) {
                                            $fileDirectory = $fileDir . $fileName;
                                            break;
                                        }
                                    }
                                }
                                if ($keyDate == 0) {
                                    $toggleNextDay = false;
                                } else if ($keyDate == 1) {
                                    $toggleNextDay = true;
                                }
                                if ($fileDirectory != "null") {
                                    $file = fopen($fileDirectory, "r");
                                    while (!feof($file)) {
                                        $tempData[] = fgetcsv($file);
                                    }
                                    fclose($file);
                                    foreach ($tempData as $keyData => $_data) {
                                        $countDateString = strlen($_data[0]);
                                        if ($keyData > 7 && $countDateString > 1) {
                                            $tempDateTime = date_create($_data[0]);
                                            $tempDate = date_format($tempDateTime, "Y/m/d");
                                            $tempTime = date_format($tempDateTime, "H:i:s");
                                            $timeHour = date_format($tempDateTime, "H");
                                            $timeMinute = date_format($tempDateTime, "i");
                                            switch ($categoryID[$sensorkey]) {
                                                case '1':
                                                    $rainValue = (float)$_data[1];
                                                    //$airPressure = (float)$_data[2];
                                                    if (!$toggleNextDay && $timeHour >= 8) {
                                                        $cumulativeRain+= $rainValue;
                                                    } else if ($toggleNextDay && $timeHour < 8) {
                                                        $cumulativeRain+= $rainValue;
                                                    }
                                                    break;
                                                case '2':
                                                    $waterlevelValue = (float)($_data[1] * 100);
                                                    if (!$toggleNextDay && $timeHour >= 8) {
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    } else if ($toggleNextDay && $timeHour < 8) {
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    }
                                                    break;
                                                case '3':
                                                    $rainValue = (float)$_data[1];
                                                    $waterlevelValue = (float)($_data[2] * 100);
                                                    //$airPressure = (float)$_data[4];
                                                    if (!$toggleNextDay && $timeHour >= 8) {
                                                        $cumulativeRain+= $rainValue;
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    } else if ($toggleNextDay && $timeHour < 8) {
                                                        $cumulativeRain+= $rainValue;
                                                        $waterlevel[] = $waterlevelValue;
                                                        $lowestWaterlevel = min($waterlevel);
                                                        $highestWaterlevel = max($waterlevel);
                                                    }
                                                    break;
                                                case '4':
                                                    break;
                                                default:
                                                    # code...
                                                    break;
                                                }
                                            }
                                        }
                                        unset($tempData);
                                }
                            }
                            $firstDataInput = true;
                            $firstDataInput2 = true;
                            $referenceHour = 8;
                            $referenceHour2 = 0;
                        }
                    }
                    if ($counter < count($dateRange)) {
                        $yearDate = $dateRange[$counter];
                    }
                    $counter++;
                    switch ($categoryID[$sensorkey]) {
                        case '1':
                            $cumulativeRain = round((float)$cumulativeRain, 2);
                            if ($generateAllSensors == "false") {
                                $sensorData[] = array(
                                    "date_read" => $yearDate,
                                    "rain_cumulative" => $cumulativeRain
                                );
                            } else if ($generateAllSensors == "true") {
                                $tempStr = "d" . $yearDate;
                                $tempDataArray[$tempStr] = "$cumulativeRain mm";
                            }
                            break;
                        case '2':
                            $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                            $highestWaterlevel = round((float)$highestWaterlevel, 2);
                            $sensorData[] = array(
                                "date_read" => $yearDate,
                                "lowest_waterlevel" => $lowestWaterlevel,
                                "highest_waterlevel" => $highestWaterlevel
                            );
                            break;
                        case '3':
                            $cumulativeRain = round((float)$cumulativeRain, 2);
                            if ($generateAllSensors == "false") {
                                $lowestWaterlevel = round((float)$lowestWaterlevel, 2);
                                $highestWaterlevel = round((float)$highestWaterlevel, 2);
                                $sensorData[] = array(
                                    "date_read" => $yearDate,
                                    "rain_cumulative" => $cumulativeRain,
                                    "lowest_waterlevel" => $lowestWaterlevel,
                                    "highest_waterlevel" => $highestWaterlevel
                                );
                            } else if ($generateAllSensors == "true") {
                                $tempStr = "d" . $yearDate;
                                $tempDataArray[$tempStr] = "$cumulativeRain mm";
                            }
                            break;
                        case '4':
                            break;
                        default:
                            # code...
                            break;
                        }
                        $lowestWaterlevel = 0;
                        $highestWaterlevel = 0;
                        $cumulativeRain = 0;
                        unset($waterlevel);
                        $waterlevel = array();
                    }
                    if ($generateAllSensors == "true") {
                        $tempDates = "";
                        foreach ($sensorDefectiveDate as $strDate) {
                            $tempDates.= "[ $strDate ]" . "\n";
                        }
                        $tempDataArray["defective_date"] = $tempDates;
                        $tempDataArray["sensor_location"] = $addressName;
                        $tempDataArray["category_name"] = $categoryName;
                        $tempDataArray["province_name"] = $provinceName;
                        $sensorData[] = $tempDataArray;
                        unset($tempDataArray);
                    }
            }
            if ($generateAllSensors == "true") {
                $data = json_encode($sensorData);
            } else if ($generateAllSensors == "false") {
                $_data = array(
                    "sensor_data" => $sensorData,
                    "defective_date" => $sensorDefectiveDate
                );
                $data = json_encode($_data);
            }
            return $data;
        }
        private function getDBData($displayType, $generateAllSensors, $categoryID, $sensorID, $dateArray, $dateStart, $dateEnd) {
            $data = json_encode(0);
            switch ($displayType) {
                case '1':
                    $startDayDate = $dateStart;
                    $count = count($dateArray);
                    $endDayDate = $dateArray[$count - 1][0];
                    $data = $this->processDBData_Default_Hourly_Others($displayType, $categoryID[0], $sensorID[0], $dateArray, $startDayDate, $endDayDate);
                    return $data;
                break;
                case '2':
                    $startDayDate = $dateStart;
                    $count = count($dateArray);
                    $endDayDate = $dateArray[$count - 1][0];
                    $data = $this->processDBData_Default_Hourly_Others($displayType, $categoryID[0], $sensorID[0], $dateArray, $startDayDate, $endDayDate);
                    return $data;
                break;
                case '3':
                    if ($generateAllSensors == "false") {
                        $startDayDate = $dateStart;
                        $count = count($dateArray);
                        $endDayDate = $dateArray[$count - 1][0];
                    } else {
                        $startDayDate = $dateStart . "/01";
                        $date = explode("/", $dateEnd);
                        $count = count($dateArray[$date[0]][(int)$date[1]]);
                        $endDayDate = $dateArray[$date[0]][(int)$date[1]][$count][0];
                    }
                    $data = $this->processDBData_Daily($categoryID, $sensorID, $generateAllSensors, $dateArray, $startDayDate, $endDayDate);
                    return $data;
                break;
                case '4':
                    if ($generateAllSensors == "false") {
                        $date = explode("/", $dateEnd);
                        $year = (int)$date[0];
                        $month = (int)$date[1];
                        $count = count($dateArray[$year][$month]);
                        $startDayDate = $dateStart . "/01";
                        $endDayDate = $dateArray[$year][$month][$count][0];
                    } else {
                        $startDayDate = $dateStart . "/01/01";
                        $count = count($dateArray[$dateEnd]);
                        $count2 = count($dateArray[$dateEnd][$count]);
                        $endDayDate = $dateArray[$dateEnd][$count][$count2][0];
                    }
                    $data = $this->processDBData_Monthly($categoryID, $sensorID, $generateAllSensors, $dateStart, $dateEnd, $dateArray, $startDayDate, $endDayDate);
                    return $data;
                break;
                case '5':
                    $startDayDate = $dateArray[$dateStart][0][0][0];
                    $count = count($dateArray[$dateEnd]);
                    $count2 = count($dateArray[$dateEnd][$count - 1]);
                    $endDayDate = $dateArray[$dateEnd][$count - 1][$count2 - 1][0];
                    $data = $this->processDBData_Yearly($categoryID, $sensorID, $generateAllSensors, $dateStart, $dateEnd, $dateArray, $startDayDate, $endDayDate);
                    return $data;
                break;
                case '6':
                    $startDayDate = $dateStart;
                    $count = count($dateArray);
                    $endDayDate = $dateArray[$count - 1][0];
                    $data = $this->processDBData_Default_Hourly_Others($displayType, $categoryID[0], $sensorID[0], $dateArray, $startDayDate, $endDayDate);
                    return $data;
                break;
                default:
                break;
            }
        }
        #=============================================================================================================================
        private function proccessData($displayType, $generateAllSensors, $sensorType, $provinceID, $sensorID, $categoryID, $dateStart, $dateEnd) {
            $dateArray = array();
            $data = json_encode(0);
            $dateArray = $this->processDataRanges($displayType, $generateAllSensors, $dateStart, $dateEnd);
            $data = $this->getDBData($displayType, $generateAllSensors, $categoryID, $sensorID, $dateArray, $dateStart, $dateEnd);
            return $data;
        }
        #=============================================================================================================================
        #=================================== SHOW ALL DATA FOR LANDSLIDE, FLOOD, AND ROAD NETWORKS  ===================================#
        private function showAllReportData($reportType) {
            $sensorData = array();
            $reportList = array();
            $data = json_encode(0);
            $provinces = DB::table('tbl_provinces')->get();
            $landslides = DB::table('tbl_incidents')->where('incident_type', 1)->get();
            $floods = DB::table('tbl_incidents')->where('incident_type', 2)->get();
            $roadNetworks = DB::table('tbl_roadnetworks')->get();
            switch ($reportType) {
                case '2':
                    foreach ($landslides as $landslide) {
                        $tempStr = strip_tags($landslide->description);
                        $tempProvince = "";
                        foreach ($provinces as $province) {
                            if ($landslide->province_id == $province->id) {
                                $tempProvince = $province->name;
                            }
                        }
                        $reportList[] = array(
                            "date_time" => $landslide->date,
                            "province" => $tempProvince,
                            "location" => $landslide->location,
                            "description" => $tempStr
                        );
                    }
                break;
                case '3':
                    foreach ($floods as $flood) {
                        $tempStr = strip_tags($flood->description);
                        $tempProvince = "";
                        foreach ($provinces as $province) {
                            if ($flood->province_id == $province->id) {
                                $tempProvince = $province->name;
                            }
                        }
                        $reportList[] = array(
                            "date_time" => $flood->date,
                            "province" => $tempProvince,
                            "location" => $flood->location,
                            "description" => $tempStr
                        );
                    }
                break;
                case '4':
                    foreach ($roadNetworks as $roadNetwork) {
                        $tempStr = strip_tags($roadNetwork->description);
                        $reportList[] = array(
                            "date_time" => $roadNetwork->date,
                            "location" => $roadNetwork->location,
                            "status" => $roadNetwork->status,
                            "description" => $tempStr
                        );
                    }
                break;
            }
            $data = json_encode($reportList);
            return $data;
        }
        public function test() {
            $data = $this->getSensorDefectiveDate("88", "2017/02/01", "2017/02/05");
            echo "<br>";
            print_r($data);
        }
    }
