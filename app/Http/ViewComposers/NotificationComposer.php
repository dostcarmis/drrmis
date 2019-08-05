<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Notification;
use App\Models\Sensors;
use App\Models\User;
use Auth;
use DB;

class NotificationComposer{
	public function compose(View $view){
		if (Auth::check()) {
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
			$view->with('notifcount',$notifications)
			->with(['allnotifications' => $allnotifications,'thresholds' => $thresholds,'allprovinces' => $allprovinces,'allmunicipalities' => $allmunicipalities,'sensorss' => $sensorss,'notitifcontent' => $notitifcontent,'allusers' => $allusers,'floodthresholds' => $floodthresholds,'proneareas' => $proneareas
				]);
		}		
	}
}
