<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;

class GsmModuleController extends Controller {
    
    public function getQueueSMS() {
        $user = Auth::user();
    }
}
