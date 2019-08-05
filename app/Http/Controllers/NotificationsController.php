<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;



use DB;
use Session;

use App\Models\Category;
use App\Models\Coordinates;
use App\Models\Province;
use App\Models\Municipality;
use App\Models\Notification;
use App\Models\Sensors;
use App\Models\User;
use Javascript;
use View;
use Auth;
use Illuminate\Support\Facades\Input;
use Response;
use App\Services\Getcsvdataapi;

class NotificationsController extends Controller
{
    public $AppServiceCsvfunction;
    function __construct(Getcsvdataapi $AppServiceCsvfunction)
    {
      $this->middleware('auth');
      $this->todaypath = 'data'.'/'.date('Y').'/'.date('m').'/'.date('d').'/';
      $this->yesterday = 'data'.'/'.date('Y/m/d',strtotime("-1 days")).'/';
      $this->lasttwodayspath = 'data'.'/'.date('Y/m/d',strtotime("-2 days")).'/';
      $this->AppServiceCsvfunction = $AppServiceCsvfunction;
    }
    private function gettotaltoday($path,$filedate,$assoc){
      $counter = [];
      $count = 0;
      $fname = $assoc."-".$filedate.".csv";
      $fpath = 'data'.'/'.$path.'/';
      $yestfile = $this->AppServiceCsvfunction->getcsv($fpath,$fname);
      $csvlimit = count($yestfile);
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
      return $counter;
    }

    public function viewNotifications()
    {
      $provinces = DB::table('tbl_provinces')->get();
      $municipalities = DB::table('tbl_municipality')->get();
      $users = DB::table('users')->get();
      $notifications = DB::table('tbl_notifications')->get();
      $notificationcontents = DB::table('tbl_notificationscontent')->get();

      return view('pages.viewnotifications')->with(['users' => $users,'provinces' => $provinces,'municipalities'=>$municipalities,'notifications' => $notifications,'notificationcontents'=>$notificationcontents]);    
    }
    public function seeNotifications(Request $request){
      $cntUser = Auth::user(); 
          $row = array(
               'is_seen' => 1,                         
            );
          $i = DB::table('tbl_notifications')->where('user_id',$cntUser->id)->update($row);      
    }
    public function readNotifications(Request $request){
      $notifid = Input::get('readnotifications');   
      $row = array(
        'is_read' => 1,                         
      );
      $i = DB::table('tbl_notifications')->where('id','=',$notifid)->update($row);  
    }
    public function viewNotification($id){
      $notifications = DB::table('tbl_notifications')->where('id',$id)->first();
      $sensors = DB::table('tbl_sensors')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $municipalities = DB::table('tbl_municipality')->get();      
      $notificationcontents = DB::table('tbl_notificationscontent')->get();
      $thresholds = DB::table('tbl_threshold')->get();
      $incidents = DB::table('tbl_incidents')->get();
   
      $date = new \DateTime($notifications->created_at);
      
      $newdate = $date->format('Y/m/d');
      $filedate = $date->format('Ymd');
      $assoc = '';

      foreach ($sensors as $sensor) {
          if($sensor->id == $notifications->sensorsids){
            $assoc = $sensor->assoc_file;
          }
      }
      $todayfile = $this->gettotaltoday($newdate,$filedate,$assoc);

    return view('pages.viewnotification')->with(['todayfile' => $todayfile,'thresholds' => $thresholds,'notifications' => $notifications,'sensors' => $sensors,'provinces' => $provinces,'municipalities'=>$municipalities,'incidents'=>$incidents,'notifications' => $notifications,'notificationcontents'=>$notificationcontents]);  


    }



    public function viewNotificationFlood($id){
      $notifications = DB::table('tbl_notifications')->where('id',$id)->first();
      $sensors = DB::table('tbl_sensors')->get();
      $provinces = DB::table('tbl_provinces')->get();
      $municipalities = DB::table('tbl_municipality')->get();      
      $notificationcontents = DB::table('tbl_notificationscontent')->get();
      $thresholdfloods = DB::table('tbl_thresholdflood')->get();
      $floods = DB::table('tbl_flood')->get();
      $floodproneareas = DB::table('tbl_floodprone_areas')->get();


    
        $date = new \DateTime($notifications->created_at);
        $newdate = $date->format('Y/m/d');
        $filedate = $date->format('Ymd');
        $assoc = '';

      foreach ($sensors as $sensor) {
          if($sensor->id == $notifications->sensorsids){
            $assoc = $sensor->assoc_file;
          }
      }
      $todayfile = $this->gettotaltoday($newdate,$filedate,$assoc);

    return view('pages.viewnotificationflood')->with(['todayfile' => $todayfile,'thresholdfloods' => $thresholdfloods,'notifications' => $notifications,'sensors' => $sensors,'provinces' => $provinces,'municipalities'=>$municipalities,'floods'=>$floods,'notifications' => $notifications,'notificationcontents'=>$notificationcontents,'floodproneareas' => $floodproneareas]);  


    }

    public function myNotifications(Request $request){
      $output = [];
      $outputCount = 0;
      $sensorss = Sensors::all();
      $thresholds = DB::table('tbl_threshold')->get();
      $cntUser = Auth::user(); 
      $user = User::where('id', $cntUser->id)->first();
      $notifications = $user->notifications()->unread()->count();
      $unreadNotifications = $user->notifications()->unread()->get();
      $allnotifications = DB::table('tbl_notifications')->orderBy('created_at','desc')->get();
      $notitifcontent = DB::table('tbl_notificationscontent')->get();
      $allusers = DB::table('users')->get();
      $thresholds = DB::table('tbl_threshold')->get();
      $floodthresholds = DB::table('tbl_thresholdflood')->get();
      $proneareas = DB::table('tbl_floodprone_areas')->get();
      $allprovinces = DB::table('tbl_provinces')->get();
      $allmunicipalities = DB::table('tbl_municipality')->get();  

        foreach($allnotifications as $bynotification){
            if($bynotification->user_id == $cntUser->id){
              
              $class="";
              $munname = "";
              $provname = "";    
              $ncbody = "";
              $tresh = "";
              $prev ="";
              $icon = '';
              $fname = '';

              //check for not read
              if($bynotification->is_read != 1){
                $class="unread";                    
              }else{
                $class="";
              }

              //get firstname
              foreach ($allusers as $user) {
                if($cntUser->id == $user->id){
                  $fname = $user->first_name;
                }
              }

              //get content
              foreach($notitifcontent as $nc){                                               
                if($nc->id == $bynotification->nc_id){
                  $ncbody = explode("-@-", $nc->body);
                  $icon = $nc->icon;
                }
              }   
              foreach ($sensorss as $sensor) {
                if($sensor->id == $bynotification->sensorsids){
                      $munname = $sensor->address;
                  }
              }

              foreach($allprovinces as $province){                                               
                  if($province->id == $bynotification->province_id){
                      $provname =  $province->name;
                  }
              }

                //addnotif for sensor readings
                if($bynotification->nc_id == 1){
                  //new account
                  $fstring = "";
                  $fstring .='<a href="'.url('profile').'" class="readnotifications '.$class.'">'.
                              '<input type="hidden" value="'.$bynotification->id.'" id="notifid" name="notifid">'.
                              '<div class="media"><div class="media-body">'.
                              '<div class="col-xs-12 newaccountNotif"><p class="notifcontents"><span></span><span>'.$ncbody[0].'</span>'.
                              '<span class="sp-notifname"> '.$fname.'</span>'.
                              '<span> '.$ncbody[1].' </span>'.
                              '<p class="time"><i class="fa fa-pencil-square-o"></i> Edit your profile</p></div></div></div>'.
                              '</a>';
                  $output['body'][$outputCount++] = $fstring;

                }elseif($bynotification->nc_id == 3){    
                    //reading reached               
                  foreach($thresholds as $threshold){
                      if($threshold->address_id == $bynotification->sensorsids){
                          $tresh = $threshold->threshold_landslide;
                      }
                  }
                  $fstring = "";
                  $fstring .='<a href="'.url('viewnotification').'/'.$bynotification->id.'" class="readnotifications '.$class.'">'.
                              '<input type="hidden" value="'.$bynotification->id.'" id="notifid" name="notifid">'.
                              '<div class="media"><div class="media-body">'.
                              '<div class="col-xs-2 notif-icons"><img class="mres" src="http://drrmis.dostcar.ph/public/'.$icon.'"></div><div class="col-xs-10 np"><p class="notifcontents"><span></span><span>'.$ncbody[0].'</span>'.
                              '<span class="sp-notiflocation"> '.$munname.', '.$provname.' </span>'.
                              '<span> '.$ncbody[1].' </span>'.
                              '<span><span><strong>'.$bynotification->value.'mm</strong></span>'.
                              '<span> '.$ncbody[2].' </span>'.
                              '<span>'.$tresh.'mm. </span></p>'.
                              '<p class="time"><i class="fa fa-clock-o"></i> '.\Carbon\Carbon::createFromTimeStamp(strtotime($bynotification->created_at))->diffForHumans().'</p></div></div></div>'.
                              '</a>';
                  $output['body'][$outputCount++] = $fstring;
                }elseif($bynotification->nc_id == 7){    
                    //reading reached               
                  foreach($thresholds as $threshold){
                      if($threshold->address_id == $bynotification->sensorsids){
                          $tresh = $threshold->threshold_landslide;
                      }
                  }
                  $fstring = "";
                  $fstring .='<a href="'.url('viewnotification').'/'.$bynotification->id.'" class="readnotifications '.$class.'">'.
                              '<input type="hidden" value="'.$bynotification->id.'" id="notifid" name="notifid">'.
                              '<div class="media"><div class="media-body">'.
                              '<div class="col-xs-2 notif-icons"><img class="mres" src="http://drrmis.dostcar.ph/public/'.$icon.'"></div><div class="col-xs-10 np"><p class="notifcontents"><span></span><span>'.$ncbody[0].'</span>'.
                              '<span class="sp-notiflocation"> '.$munname.', '.$provname.' </span>'.
                              '<span> '.$ncbody[1].' </span>'.
                              '<span><span><strong>'.$bynotification->value.'mm</strong></span>'.
                              '<span> '.$ncbody[2].' </span>'.
                              '</p>'.
                              '<p class="time"><i class="fa fa-clock-o"></i> '.\Carbon\Carbon::createFromTimeStamp(strtotime($bynotification->created_at))->diffForHumans().'</p></div></div></div>'.
                              '</a>';
                  $output['body'][$outputCount++] = $fstring;
                }
                 
            }
            
        }
      if($request->ajax()){       
        return response()->json(['output' => $output,'unread' => $notifications]);
      }
   }

    public function displaynotif()    
    {    
      return view('pages.notification');
    }
    public function viewmobileNotifications()    
    {    
      return view('pages.viewnotificationmobile');
    }
    public function displayCount()
    {
      $userid = Input::get('userid');
      $items = Notification::where('user_id', '=', $userid)->get();
      return Response::json($items);
    }
}
