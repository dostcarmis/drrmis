<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Auth;
use App\Models\Subscribers;
use App\Models\Contact;
use App\Models\ContactNumber;
use App\Models\SentMessage;
use App\Models\User;
use Globe\Connect\Oauth;
use Globe\Connect\Sms;
use Semaphore\SemaphoreClient as SMSClient;
use Illuminate\Support\Facades\Storage;
use File;

class SMSController extends Controller
{
	function __construct(){
    	$this->middleware('auth');
    }
    
    // Automatated SMS Notification Module

    public function viewNotificationSubscribers(){
    	return view('pages.subscribers');
    }

    public function viewAllNotifications(){
    	return view('pages.notifications');
    }

    public function viewSubscribe(){
        return view('pages.subscribe');
    }

    public function viewSuccessSubscribe(){
        return view('pages.success-subscribe');
    }

    public function checkSubscribed(Request $request) {
        $subscribers = DB::table('tbl_subscribers')->get();
        $userID = $request->input('user_id');
        $isSubscribe = "0";

        foreach ($subscribers as $subscriber) {
            if ($subscriber->user_id == $userID) {
                $isSubscribe = "1";
                break;
            }
        }

        return $isSubscribe;
    }

    public function unsubscribeUser(Request $request) {
        $userID = $request->input('user_id');
        DB::table('tbl_subscribers')->where('user_id', '=', $userID)->delete();

        return "1";
    }

    public function getRecipients(Request $request){
        $keyword = trim($request->search);
        $contacts = DB::table('tbl_contacts as contact')
                      ->select('contact.firstname', 'contact.middlename', 'contact.lastname',
                               'num.phone_number')
                      ->join('tbl_contact_numbers as num', 'num.contact_id', '=', 'contact.id');

        if ($keyword) {
            $contacts = $contacts->where(function($qry) use ($keyword) {
                $qry->where('contact.firstname', 'like', "%$keyword%")
                    ->orWhere('contact.middlename', 'like', "%$keyword%")
                    ->orWhere('contact.lastname', 'like', "%$keyword%")
                    ->orWhere('num.phone_number', 'like', "%$keyword%");
            });
        }

        $contacts = $contacts->orderBy('contact.firstname')
                             ->get();

        return response()->json($contacts);
    }

    public function getNotifications(Request $request){
        $sensors = DB::table('tbl_sensors')->get();
        $notifications = DB::table('tbl_notifications')->get();
        $notificationContents = DB::table('tbl_notificationscontent')->get();
        $provinces = DB::table('tbl_provinces')->get();
        $municipalities = DB::table('tbl_municipality')->get();
        $userID = $request->input('user_id');

        $ncID = "";
        $date_time = "";
        $municipalID = "";
        $provinceID = "";
        $municipalName = "";
        $provinceName = "";
        $value = "";
        $message = "";
        $data = array();
        $notificationData = json_encode(0);
        foreach ($notifications as $notification) {
            if ($notification->user_id == $userID) {
                $ncID = $notification->nc_id;
                $value = $notification->value;
                $provinceID = $notification->province_id;
                $municipalID = $notification->sensorsids;
                $date_time = $notification->created_at;

                foreach ($provinces as $province) {
                    if ($province->id == $provinceID) {
                        $provinceName = $province->name;
                        break;
                    }
                }

                foreach ($sensors as $sensor) {
                    if ($sensor->id == $municipalID) {
                        $municipalName = $sensor->address;
                        break;
                    }
                }

                foreach ($notificationContents as $content) {
                    if ($content->id == $ncID) {
                        $message = "$municipalName" . ", $provinceName has exceeded the threshold value from 100 to $value". "mm.";
                        $data[] = array("date_time" => $date_time,
                                        "message" => $message);
                        break;
                    }
                }
            }
        }

        $notificationData = json_encode($data);
        return $notificationData;
    }

    // SMS Module

    public function viewRegisteredContacts(){
    	return view('pages.contacts');
    }

    public function viewComposeMessage(){
        $users = DB::table('users')->orderBy('first_name', 'asc')->get();
        $subscribers = DB::table('tbl_subscribers')->get();

    	return view('pages.compose')->with(['users' => $users,
                                            'subscribers' => $subscribers]);
    }

    public function viewSentMessages(Request $request){
        $cntUser = Auth::user();
        $users = DB::table('users')->get();
        $sentMessages = DB::table('tbl_sent_messages')
                          ->orderBy('created_at', 'desc')
                          ->get();
        $sentMsgcontent = [];
        $sentMsgCount = 0;
        $headcheckbox = '<input type="checkbox" class="headcheckbox">';

        foreach ($sentMessages as $sent) {
            $chkbx = '';
			$message = '';
            $sender = '';
            $recipients = $sent->recipients;
            $smsMedium = $sent->sms_medium;
            $status = $sent->status;
			$belowtitle = '';
			$belowtitle1 = '';

            if (($cntUser->id == $sent->user_id) || ($cntUser->role_id <= 3)) {
				$chkbx = '<input class="chbox" name="chks[]" value="'.$sent->id.'"  type="checkbox">';
				$message = '<a class="desctitle" href="'.url("sent-messages/$sent->id").'">'.$sent->message.'</a>';
			} else {
				$chkbx = '<input type="checkbox" disabled>';
				$message = '<a class="desctitle" href="'.url("sent-messages/$sent->id").'">'.$sent->message.'</a>';
			}

            foreach ($users as $user) {
                if ($user->id === $sent->user_id) {
                    $sender = "$user->first_name $user->last_name";
                    break;
                }
            }

            $belowtitle = 
            '<span class="defsp spactions"><div class="inneractions">'.
                $belowtitle1.'<a href="'.url("sent-messages/$sent->id").'">Preview</a></div></span>';
			$fnaltitle = $message.$belowtitle;
            $sentMsgcontent['data'][$sentMsgCount++] = [
				$chkbx,
                $fnaltitle,
                $sender,
                $recipients,
                $smsMedium,
                $status,
                date("F j, Y g:i A", strtotime($sent->created_at))
            ];
        }

        $jsonIncident = json_encode($sentMsgcontent);

        if ($request->ajax()) {
            return response()->json($sentMsgcontent);
        }

        return view('pages.sent', [
            'sentMessages' => $sentMessages,
        ]);
    }

    public function destroymultipleSentMsgs(Request $request){
        SentMessage::destroy($request->chks);
        $chk = count($request->chks);

        if ($chk == 1) {
           $delmsg = 'Sent messages successfully deleted.';
        } else {
           $delmsg = $chk .' sent messages successfully deleted.';
        }
        
        \Session::flash('message',  $delmsg);
        return redirect()->back();
     }

    private function proccessContactNumber($contactNo) {
        $contactNo = strtolower(preg_replace('/[^+0-9]/', '', $contactNo));
        $digitCount = strlen($contactNo);
        $isValidNumber = false;

        if ($digitCount !== 10 && $digitCount !== 11 && 
            $digitCount !== 12 && $digitCount !== 13) {
            return false;
        }

        if (!$digitCount) {
            return false;
        }

        if (substr($contactNo, 0, 1) === '9' && $digitCount === 10) {
            $contactNo = "0$contactNo";
            $isValidNumber = true;
        }

        if (substr($contactNo, 0, 2) === '09' && $digitCount === 11) {
            $isValidNumber = true;
        }

        if (substr($contactNo, 0, 3) === '639' && $digitCount === 12) {
            $contactNo = "+$contactNo";
            $contactNo = str_replace('+63', '0', $contactNo);
            $isValidNumber = true;
        }

        if (substr($contactNo, 0, 4) === '+639' && $digitCount === 13) {
            $contactNo = str_replace('+63', '0', $contactNo);
            $isValidNumber = true;
        }

        if (!$isValidNumber) {
            return false;
        }

        return $contactNo;
    }

    private function groupContactByMessages($csvRows, $columnCount) {
        $groupedList = [];
        $messages = [];

        foreach ($csvRows as $row) {
            $messages[] = $row->message;
        }

        $messages = array_unique($messages);

        foreach ($messages as $message) {
            $contactNumbers = [];
            
            if ($columnCount === 3) {
                $senderNames = [];

                foreach ($csvRows as $row) {
                    if ($row->message == $message) {
                        $contactNumbers[] = $row->contact_number;
                        $senderNames[] = $row->sender_name;
                    }
                }

                $groupedList[] = (object) [
                    'message' => $message,
                    'contact_number' => implode(',', $contactNumbers),
                    'sender_name' => $senderNames[0]
                ];
            } else if ($columnCount === 2) {
                foreach ($csvRows as $row) {
                    if ($row->message == $message) {
                        $contactNumbers[] = $row->contact_number;
                    }
                }

                $groupedList[] = (object) [
                    'message' => $message,
                    'contact_number' => implode(',', $contactNumbers)
                ];
            }
                
        }

        return $groupedList;
    }

    private function proccessCSV($file) {
        $_csvRows = [];
        $csvRows = [];
        $newColumnHeaders = [];
        $columnHeaders = ['numbers', 'message', 'sendername'];
        $numbersKey = 0;
        $messageKey = 1;
        $sendernameKey = 2;
        $csv = fopen($file, 'r');

        while (!feof($csv)) {
            $_csvRows[] = fgetcsv($csv, 0, ',');
        }

        fclose($csv);

        if (count($_csvRows[0]) === 2) {
            foreach ($_csvRows[0] as $column) {
                $column = strtolower(preg_replace('/\s+/', '', $column));
                $newColumnHeaders[] = $column;

                if (!in_array($column, $columnHeaders)) {
                    return false;
                }
            }

            $_numbersKey = array_keys($newColumnHeaders, 'numbers');
            $numbersKey = $_numbersKey[0];

            $_messageKey = array_keys($newColumnHeaders, 'message');
            $messageKey = $_messageKey[0];
        } else if (count($_csvRows[0]) === 3) {
            foreach ($_csvRows[0] as $column) {
                $column = strtolower(preg_replace('/\s+/', '', $column));
                $newColumnHeaders[] = $column;

                if (!in_array($column, $columnHeaders)) {
                    return false;
                }
            }

            $_numbersKey = array_keys($newColumnHeaders, 'numbers');
            $numbersKey = $_numbersKey[0];

            $_messageKey = array_keys($newColumnHeaders, 'message');
            $messageKey = $_messageKey[0];

            $_sendernameKey = array_keys($newColumnHeaders, 'sendername');
            $sendernameKey = $_sendernameKey[0];
        } else {
            return false;
        }

        foreach ($_csvRows as $key => $column) {
            $contactNo = $this->proccessContactNumber($column[$numbersKey]);
            $message = $column[$messageKey];

            if ($key == 0) {
                continue;
            }

            if (!$column) {
                continue;
            }

            if (!$contactNo) {
                continue;
            }

            if (count($_csvRows[0]) === 2) {
                $csvRows[] = (object) [
                    'contact_number' => $contactNo,
                    'message' => $message,
                ];
            } else if (count($_csvRows[0]) === 3) {
                $senderName = $column[$sendernameKey];
                $csvRows[] = (object) [
                    'contact_number' => $contactNo,
                    'message' => $message,
                    'sender_name' => $senderName,
                ];
            }
        }

        return $this->groupContactByMessages($csvRows, count($_csvRows[0]));
    }

    private function apiSendSMS($apiKey, $contactNumber, $message, $senderName) {
        $ch = curl_init();
        $parameters = array(
            'apikey' => $apiKey,
            'number' => $contactNumber,
            'message' => $message,
            'sendername' => $senderName
        );
        curl_setopt($ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages');
        curl_setopt($ch, CURLOPT_POST, 1);

        //Send the parameters set above with the request
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($parameters));

        // Receive response from server
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($ch);
        curl_close ($ch);

        //Show the server response
        return $output;
    }

    private function gsmModuleSendSMS($userID, $contactNumber, $message) {
        $status = "";
        $directory = "public/queued-messages/$userID/";

        if (!File::exists($directory)) {
            Storage::makeDirectory($directory);
        }

        $files = Storage::files($directory);
        $countFiles = count($files);

        $filename = ($countFiles + 1)."-batch.json";
        $sendData = (object) [
            'phone_numbers' => $contactNumber,
            'message' => $message,
            'filename' => $filename
        ];
        $sendJsonData = json_encode($sendData);

        try {
            Storage::put("$directory$filename", $sendJsonData);
            $status = "'$directory$filename' is sent to queued.";
        } catch (\Throwable $th) {
            $status = "There is an error on sending this '$directory$filename' to queued.";
        }
        
        return $status;
    }

    public function sendMessage(Request $request) {
        $smsMedium = $request->sms_medium;
        $sendType = $request->send_type;
        $contactNumbers = [];
        $messages = [];

        try {
            $userID = Auth::user()->id;

            if ($smsMedium == "semaphore") {
                $groupID = Auth::user()->group;
                $userDat = DB::table('tbl_groups as grp')
                            ->select('grp.sms_api_key')
                            ->join('users as user', 'user.group', '=', 'grp.id')
                            ->where('user.id', $userID)
                            ->first();
                $apiKey = $userDat->sms_api_key;
            }

            $sentMessageInstance = new SentMessage;
            $status = [];

            if ($smsMedium == "semaphore") {
                if (!$userDat) {
                    return 'Not subscribed to SMS API.';
                }
            }

            if ($sendType == 'file') {
                $file = $request->file('csv_file');
                $recipients = $this->proccessCSV($file);

                foreach ($recipients as $ctr => $recipient) {
                    $contactNumber = $recipient->contact_number;
                    $message = $recipient->message;
                    $contactNumbers[] = $contactNumber;
                    $messages[] = "[$ctr : $message]";
                    
                    if ($smsMedium == "semaphore") {
                        $senderName = $recipient->sender_name;
                        $status[] = $this->apiSendSMS(
                            $apiKey, $contactNumber, $message, $senderName
                        );
                    } else if ($smsMedium == "gsm-module") {
                        $status[] = $this->gsmModuleSendSMS($userID, $contactNumber, $message);
                    }
                }
            } else {
                $senderName = $request->sender_name;
                $__contactNumbers = $request->contact_numbers;
                $message = $request->msg;
                $_contactNumbers = [];

                foreach ($__contactNumbers as $contactNumber) {
                    $_contactNumbers[] = $this->proccessContactNumber($contactNumber);
                }

                $contactNumber = implode(',', $_contactNumbers);

                $contactNumbers[] = $contactNumber;
                $messages[] = "[1 : $message]";

                if ($smsMedium == "semaphore") {
                    $status[] = $this->apiSendSMS(
                        $apiKey, $contactNumber, $message, $senderName
                    );
                } else if ($smsMedium == "gsm-module") {
                    $status[] = $this->gsmModuleSendSMS($userID, $contactNumber, $message);
                }
            }
            
            if ($smsMedium == "semaphore") {
                if ($userDat) {
                    $sentMessageInstance->user_id = $userID;
                    $sentMessageInstance->group_id = $groupID;
                    $sentMessageInstance->recipients = serialize($contactNumber);
                    $sentMessageInstance->message = implode(", \n", $messages);
                    $sentMessageInstance->sms_medium = "Semaphore API";
                    $sentMessageInstance->status = serialize($status);
                    $sentMessageInstance->save();
                }
            }

            return implode(", \n", $status);
        } catch (\Throwable $th) {
            if ($sendType == 'file') {
                return 'No file selected or invalid CSV file and format.';
            } else {
                return 'Unknown error occured. Try again!';
            }
        }
    }

    public function getSenderNames() {
        $apiKey = $this->getSmsApiKey();

        $ch = curl_init();

        curl_setopt( $ch, CURLOPT_URL, "https://semaphore.co/api/v4/account/sendernames?apikey=$apiKey" );
        curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'GET' );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        //Show the server response
        return response()->json($output);
    }

    private function getSmsApiKey() {
        $userID = Auth::user()->id;
        $userDat = DB::table('tbl_groups as grp')
                     ->select('grp.sms_api_key')
                     ->join('users as user', 'user.group', '=', 'grp.id')
                     ->where('user.id', $userID)
                     ->first();

        return $userDat ? $userDat->sms_api_key : NULL;
    }
}