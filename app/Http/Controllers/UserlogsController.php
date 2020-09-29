<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Logs;
use App\Http\Requests;

class UserlogsController extends Controller
{
    public function viewactivitylogs(){
        $logs = DB::table('tbl_logs')
                ->orderBy('logged_at', 'desc')->get();
        return view('pages.viewuserlogs')->with(['logs' => $logs]);
     }
}
