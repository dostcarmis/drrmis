<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;

class ChartController extends Controller
{
   
   public function viewmultipleCharts(){
   		$sensors = DB::table('tbl_sensors')->get();
   		$provinces = DB::table('tbl_provinces')->get();      
      	$municipalities = DB::table('tbl_municipality')->get();
   		return view ('pages.viewmultiplecharts')->with(['sensors' => $sensors, 'provinces' => $provinces,'municipalities' => $municipalities]);
   }

   public function filterChart(Request $request){
   		$post = $request->all();
   		$provinces = DB::table('tbl_provinces')->get();      
      	$municipalities = DB::table('tbl_municipality')->get();
   		if($post['pfilter'] == '0'){
	    	$sensors = DB::table('tbl_sensors')->get();	    	
	    }else{
			$sensors = DB::table('tbl_sensors')->where('province_id','=',$post['pfilter'])->get();
	    }
	    return view ('pages.viewmultiplecharts')->with(['sensors' => $sensors, 'provinces' => $provinces,'municipalities' => $municipalities]);
   }
   public static function getcsv($csvfile,$devid){

		$counter = [];
		$count = 0;
		$csvdatetime = '';
		$csvtime='';
		$todaypath = url('/data/'.date('Y').'/'.date('m').'/'.date('d'));
		$mycsvFile = $todaypath.'/'.$csvfile.'-'.date('Ymd').'.csv';
 		
		$waterlvl = '-WATERLEVEL-';
		$tndem = 'WATERLEVEL_';
		$headers=get_headers($mycsvFile);
		
		if(stripos($headers[0],"200 OK")){
		

			$file_handle = fopen($mycsvFile, 'r');
		    while (!feof($file_handle) ) {
		        $line_of_text[] = fgetcsv($file_handle, 1024);
		    }
		    fclose($file_handle);


			for($x=0;$x<=7;$x++){
			unset($line_of_text[$x]);
			}
			$perlines = count($line_of_text)+7;
			for ($i=8; $i < $perlines; $i++) {
				$csvdatetime = $line_of_text[$i][0];	
				$csvdatetimearray = explode(" ", $csvdatetime);			
				$csvtime = explode(":", $csvdatetimearray[1]);			
				if($csvtime[0] >= 8){
					if (strpos($mycsvFile,$waterlvl) !== false) {
			    		$counter[$count++] = array(

			    			'dev_id' => $devid,
							'time' =>  $csvdatetimearray[1],
							'waterlvl' => $line_of_text[$i][1],
							'category' => '2',
						);
					}else if (strpos($mycsvFile,$tndem) !== false){
						$counter[$count++] = array(

							'dev_id' => $devid,
							'time' =>  $csvdatetimearray[1],
							'value' => $line_of_text[$i][1],
							'waterlvl' => $line_of_text[$i][2],
							'category' => '3',
						);
					}else{
						$counter[$count++] = array(

							'dev_id' => $devid,
							'time' =>  $csvdatetimearray[1],
							'value' => $line_of_text[$i][1],
							'category' => '1',
						);
					}
				}
			}	
		}
		return $counter;
	}
}
