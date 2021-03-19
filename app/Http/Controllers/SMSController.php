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

    public function viewSentMessages(){
        return view('pages.sent');
    }
    

    #=======================================================================================#
    #=================================== SMS GLOBE API =====================================#
    #=======================================================================================#

    /*-------------------------------------------------------
        egzkIAzxGEu67igo4Xcxxzu8ogEeILEo -- ews account
        BkABUBA97jF5bcbaa4T9yAFzMkjeUbBr -- lowil account
        qKKMuL7Baetq5cdaR5TBnLtKGKdKuKyb -- lowil 2 account
        BezpHpeRyeHzaTXG7AiR65HnqeyaHXMy -- mac account
        ngyMh6rXAzhMoc4eBdTXMKhB5g4LhAjX -- drrmis account
    ---------------------------------------------------------*/

    private $appID = "ngyMh6rXAzhMoc4eBdTXMKhB5g4LhAjX"; 

    /*--------------------------------------------------------------------------------------
        69aaa2830789b6f3a6e820e0ee5a3b1811fded49e34c18058eda910cddbba529 --ews account
        8d032697f9ba22c5ab3b44c7c78fe63a974ec2da5b09bbd581d41e2c7c1130e3 --lowil account
        64960f423bafca7a060bf8b567f4d8346142d974e8ea387b58391ce42d4f4476 --lowil 2 account
        8223b68655b878831d16c362cec3964d8c6a0324f91cd6caf2be4d7a4144643c --mac account
        45fb8c6db3ffc2cb1d7bf61f41bb369c8587a332ef5c1deb56e3bcddc871807a --drrmis account
    ----------------------------------------------------------------------------------------*/

    private $appSecretCode = "45fb8c6db3ffc2cb1d7bf61f41bb369c8587a332ef5c1deb56e3bcddc871807a";

    /*-----------------------------------------------
        "29290580094" "21580094" -- ews account
        "29290582050" "21582050" -- lowil account
        "29290583777" "21583777" -- lowil 2 account
        "29290588806" "21588806" -- mac account
        "21580045" "225650045" -- drrmis account
    -------------------------------------------------*/

    private $shortCode = "0045"; 

    private function initializeAPI() {
        $oauth = new Oauth($this->appID, $this->appSecretCode);
        return $oauth;
    }

    public function webSubscribe() {
        $oauth = $this->initializeAPI();
        $redirectURL = $oauth->getRedirectUrl();
        header('Location: ' . $redirectURL);
        die();
    }

    public function addSubscriber(Request $request) {
        /*
        $userID = $request->input('user_id');
        $userURL = $request->input('user_url');
        $subscribers = DB::table('tbl_subscribers')->get();
        $urlLength = strlen($userURL);
        $codeStringPos = strpos($userURL, "?code=") + 6;
        $code = substr($userURL, $codeStringPos, $urlLength);
        
        $oauth = $this->initializeAPI();
        $oauth->setCode($code);
        $_authResponse = $oauth->getAccessToken();
        $authResponse = json_decode($_authResponse, true);
        $accessToken = $authResponse["access_token"];
        $subscriberNumber = "+63" . $authResponse["subscriber_number"];
        
        $msg = "";
        $countSubscriber = count($subscribers);

        if ($countSubscriber == 0) {
            DB::table('tbl_subscribers')->insert(
                [ "user_id" => $userID,
                  "access_token" => $accessToken,
                  "subscriber_number" => $subscriberNumber]
            );

            $msg = "1";
        } else if ($countSubscriber > 0) {
            foreach ($subscribers as $subscriber) {
                if ($userID != $subscriber->user_id) {
                    DB::table('tbl_subscribers')->insert(
                        [ "user_id" => $userID,
                          "access_token" => $accessToken,
                          "subscriber_number" => $subscriberNumber]
                    );
                    $msg = "1";
                    break;
                } else {
                    $msg = "0";
                    break;
                }
            }
        }

        // $msg = 0; Already Subscribed 
        // $msg = 1; Successfully Subscribed

        return $msg; */

        $msg = 1; // 1 = Success, 2 = Error on phone number, 
                  // 3 = Unknown error, 4 = already registered
        $userID = $request->user_id;
        $userDat = User::find($userID);
        $subscriberCount = DB::table('tbl_subscribers')
                             ->where('user_id', $userID)
                             ->count();

        if ($subscriberCount == 0) {
            if ($userDat) {
                if (!empty($userDat->cellphone_num) && strlen($userDat->cellphone_num) >= 11 &&
                    strlen($userDat->cellphone_num) <= 13) {
                    DB::table('tbl_subscribers')->insert(
                        ["user_id" => $userID,
                        "subscriber_number" => $userDat->cellphone_num]
                    );
                    
                    $msg = 1;
                } else {
                    $msg = 2;
                }
            } else {
                $msg = 3;
            }
        } else {
            $msg = 4;
        }

        return $msg;
    }

    /*
    public function sendMessage(Request $request){
        //$oauth = $this->initializeAPI();
        
        $recipient = $request-phone_number;
        $msg = $request->msg;
        $subscribers = DB::table('tbl_subscribers')->get();
        $sender = $this->shortCode;
        $accessToken = "";
        $subscriberNumber = "";
        $dataResponse = array();

        $response = "";
        
        foreach ($recipient as $nCounter => $number) {
            foreach ($subscribers as $subscriber) {
                if ($number == $subscriber->subscriber_number) {
                    //$accessToken = $subscriber->access_token;
                    $subscriberNumber = str_replace("+63", "0", $subscriber->subscriber_number);
                    //$subscriberNumber = $subscriber->subscriber_number;
                    $sms = new Sms($sender, $accessToken);
                    $sms->setReceiverAddress($subscriberNumber);
                    $sms->setMessage($msg);
                    //$sms->setClientCorrelator('');
                    $response .= ($nCounter + 1) . ".] " . $subscriberNumber . ": " . $sms->sendMessage() . "\n\n";

                    break;
                }
            }
        }
        
        //return "Message/s Sent.";
        return $response;
    }*/

    private function proccessContactNumber($contactNo) {
        $contactNo = strtolower(preg_replace('/[^+0-9]/', '', $contactNo));
        $digitCount = strlen($contactNo);

        

        if ($digitCount !== 11 && $digitCount !== 13) {
            return false;
        }

        if ($digitCount === 13) {
            $contactNo = str_replace('+63', '0', $contactNo);
        }

        return $contactNo;
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

        if (count($_csvRows[0]) !== 3) {
            return false;
        } else if (count($_csvRows[0]) === 3) {
            foreach ($_csvRows[0] as $column) {
                $column = strtolower(preg_replace('/\s+/', '', $column));
                $newColumnHeaders[] = $column;

                if (!in_array($column, $columnHeaders)) {
                    return false;
                }
            }
        } else {
            return false;
        }

        $_numbersKey = array_keys($newColumnHeaders, 'numbers');
        $numbersKey = $_numbersKey[0];

        $_messageKey = array_keys($newColumnHeaders, 'message');
        $messageKey = $_messageKey[0];

        $_sendernameKey = array_keys($newColumnHeaders, 'sendername');
        $sendernameKey = $_sendernameKey[0];

        foreach ($_csvRows as $key => $column) {
            $contactNo = $this->proccessContactNumber($column[$numbersKey]);
            $message = $column[$messageKey];
            $senderName = $column[$sendernameKey];

            if ($key == 0) {
                continue;
            }

            if (!$column) {
                continue;
            }

            if (!$contactNo) {
                continue;
            }

            $csvRows[] = (object) [
                'recipient' => $contactNo,
                'msg' => $message,
                'sender_name' => $senderName,
            ];
        }

        return $csvRows;
    }

    public function sendMessage(Request $request) {
        $sendType = $request->send_type;

        try {
            $userID = Auth::user()->id;
            $groupID = Auth::user()->group;
            $userDat = DB::table('tbl_groups as grp')
                        ->select('grp.sms_api_key')
                        ->join('users as user', 'user.group', '=', 'grp.id')
                        ->where('user.id', $userID)
                        ->first();

            $sentMessageInstance = new SentMessage;
            $status = [];

            if ($sendType == 'file') {
                $file = $request->file('csv_file');
                $recipients = $this->proccessCSV($file);
            } else {
                $recipients = $request->contact_numbers;
                $msg = $request->msg;
            }

            foreach ($recipients as $recipient) {
                $subscriberNumber = $sendType == 'file' ? $recipient->recipient : 
                                    $this->proccessContactNumber($recipient);
                $msg = $sendType == 'file' ? $recipient->msg : $msg;
                $senderName = $sendType == 'file' ? $recipient->sender_name : 'DRRMIS';
                
                if ($userDat) {
                    $ch = curl_init();
                    $parameters = array(
                        'apikey' => $userDat->sms_api_key, //Your API KEY
                        'number' => $subscriberNumber,
                        'message' => $msg,
                        'sendername' => $senderName
                    );
                    curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
                    curl_setopt( $ch, CURLOPT_POST, 1 );

                    //Send the parameters set above with the request
                    curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

                    // Receive response from server
                    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                    $output = curl_exec( $ch );
                    curl_close ($ch);

                    //Show the server response
                    echo $output;
                    $status[] = $output;
                } else {
                    echo 'Not subscribed to SMS API.';
                    $status[] = 'Not subscribed to SMS API.';
                }
            }

            if ($userDat) {
                $sentMessageInstance->user_id = $userID;
                $sentMessageInstance->group_id = $groupID;
                $sentMessageInstance->recipients = serialize($recipients);
                $sentMessageInstance->message = $msg;
                $sentMessageInstance->status = serialize($status);
                $sentMessageInstance->save();
            }
        } catch (\Throwable $th) {
            if ($sendType == 'file') {
                echo 'No file selected or invalid CSV file and format.';
            } else {
                echo 'Unknown error occured. Try again!';
            }
        }
    }

    #=======================================================================================#
    #================================= SMS SEMAPHORE API ===================================#
    #=======================================================================================#

    public function testSemaphore() {
        $ch = curl_init();
        $parameters = array(
            'apikey' => 'c4f4d24799b91dc6b36e9929ca43be7e', //Your API KEY
            'number' => '09129527475',
            'message' => 'I just sent my first message with Semaphore',
            'sendername' => 'SEMAPHORE'
        );
        curl_setopt( $ch, CURLOPT_URL,'https://semaphore.co/api/v4/messages' );
        curl_setopt( $ch, CURLOPT_POST, 1 );

        //Send the parameters set above with the request
        curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $parameters ) );

        // Receive response from server
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $output = curl_exec( $ch );
        curl_close ($ch);

        //Show the server response
        echo $output;
    }
}