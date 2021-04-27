<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use File;

class GsmModuleController extends Controller {
    
    public function getQueueSMS() {
        $user = Auth::user();
        $userID = $user->id;
        $publicDirectory = public_path("storage/queued-messages/$userID");

        if (!File::exists($publicDirectory)) {
            Storage::makeDirectory($publicDirectory);
        }

        $files = File::files($publicDirectory);
        $countFiles = count($files);
        
        if ($countFiles > 0) {
            $file = $files[0];

            return response()->json(
                ['success' => json_decode(file_get_contents($file), true)], 200
            );
        } else {
            return response()->json(
                ['error' => "no-pending"], 404
            );
        }
    }

    public function respondMessageSent(Request $request) {

    }
}
