<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Support\Facades\Storage;
use File;
use App\Models\SentMessage;

class GsmModuleController extends Controller {
    
    public function getQueueSMS() {
        $user = Auth::user();
        $userID = $user->id;
        $publicDirectory = public_path("storage/queued-messages/$userID");

        if (File::exists($publicDirectory)) {
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
        } else {
            return response()->json(
                ['error' => "no-pending"], 404
            );
        } 
    }

    public function disposeSentJsonFile(Request $request) {
        $filename = $request->filename;
        $user = Auth::user();
        $userID = $user->id;
        $publicDirectory = public_path("storage/queued-messages/$userID");
        $publicFileAddress = public_path("storage/queued-messages/$userID/$filename");

        if (File::exists($publicFileAddress)) {
            File::delete($publicFileAddress);

            return response()->json(
                ['success' => 'disposed'], 200
            );
        } else {
            return response()->json(
                ['error' => "no-file"], 404
            );
        }
    }

    public function storeSentMessages(Request $request) {
        $messageLogs = explode(',', $request->message_logs);
        $message = $request->message;
        $user = Auth::user();
        $userID = $user->id;
        $groupID = !empty($user->group) ? $user->group : NULL;
        $recipients = [];
        $status = [];

        foreach ($messageLogs as $_msgLogs) {
            $msgLogs = explode(':', $_msgLogs);
            $recipients[] = $msgLogs[2];
            $status[] = "$msgLogs[2] ($msgLogs[1])";
        }

        try {
            $sentMessageInstance = new SentMessage;
            $sentMessageInstance->user_id = $userID;
            $sentMessageInstance->group_id = $groupID;
            $sentMessageInstance->recipients = serialize($recipients);
            $sentMessageInstance->message = $message;
            $sentMessageInstance->sms_medium = "DRRMIS GSM Client (GSM Module)";
            $sentMessageInstance->status = serialize($status);
            $sentMessageInstance->save();

            return response()->json(
                ['success' => 'stored'], 200
            );
        } catch (\Throwable $th) {
            return response()->json(
                ['error' => "error-storing"], 404
            );
        }
    }
}
