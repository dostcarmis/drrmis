<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Logs;
use App\Http\Requests;

class UserlogsController extends Controller
{
    public function viewactivitylogs(){
        $logs = Logs::with(['province', 'municipal'])
                ->orderBy('logged_at', 'desc')
                ->get();

        foreach ($logs as $log) {
            $provinceName = $log['province'] ? 
                            json_decode($log['province'])->name : 
                            NULL;
            $municipalName = $log['municipal'] ? 
                            json_decode($log['municipal'])->name : 
                            NULL;

            $log->municipal_name = $municipalName;
            $log->province_name = $provinceName;

            //echo $log['province'] . "<br>";
        }

        //dd($logs);

                //dd($logs[0] ['province']->name);
        return view('pages.viewuserlogs')->with(['logs' => $logs]);
     }
}
