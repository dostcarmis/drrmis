<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use App\Models\Subscribers;
use App\Models\User;
use Twilio\Rest\Client;
use Plivo\RestAPI;
use Globelabs\SMS;

class SMSController extends Controller
{

	function __construct(){

    	$this->middleware('auth');

    }
    
    public function viewRegisteredContacts(){

    	return view('pages.phonebook');

    }

    public function viewManualSMS(){

        $users = DB::table('users')->orderBy('first_name', 'asc')->get();
        $subscribers = DB::table('tbl_subscribers')->get();

    	return view('pages.compose')->with(['users' => $users,
                                            'subscribers' => $subscribers]);

    }

    public function viewAllNotifications(){

    	return view('pages.inbox');

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

        $users = DB::table('users')->orderBy('first_name', 'asc')->get();
        $provinces = DB::table('tbl_provinces')->get();
        $subscribers = DB::table('tbl_subscribers')->get();

        $data = array();
        $recipients = json_encode(0);
        $firstName = "";
        $lastName = "";
        $province = "";
        $picture = "";
        $phoneNumber = "";

        /*
        foreach ($users as $user) {

            $tempID = $user->province_id;
            $tempName = $user->first_name . " " . $user->last_name;
            $tempNumber = $user->cellphone_num;
            $picture = $user->profile_img;

            foreach ($provinces as $_province) {
                
                if ($tempID == $_province->id) {

                    $province = $_province->name;
                    break;

                }

            }
            
            if ($tempNumber != ""){

                $firstname = $user->first_name;
                $lastname = $user->last_name;
                
                //$tempNumber = substr_replace($tempNumber, "+63", 0, 1);

                $data[] = array("firstname" => $firstname,
                                "lastname" => $lastname,
                                "province" => $province,
                                "picture" => $picture,
                                "contact_name" => $tempName,
                                "contact_number" => $tempNumber);

            }

        }*/

        foreach ($subscribers as $subscriber) {

            $firstName = "";
            $lastName = "";
            $province = "";
            $picture = "";
            $phoneNumber = "";
            
            foreach ($users as $user) {
                
                if ($user->id == $subscriber->user_id) {

                    $firstName = $user->first_name;
                    $lastName = $user->last_name;
                    $phoneNumber = $subscriber->subscriber_number;
                    $tempName = $user->first_name . " " . $user->last_name;
                    $picture = $user->profile_img;

                    foreach ($provinces as $_province) {
                        if ($user->province_id == $_province->id) {

                            $province = $_province->name;
                            break;

                        }
                    }

                    $data[] = array("firstname" => $firstName,
                                    "lastname" => $lastName,
                                    "province" => $province,
                                    "picture" => $picture,
                                    "contact_name" => $tempName,
                                    "contact_number" => $phoneNumber);

                }

            }

        }

        $recipents = json_encode($data);
        return $recipents;

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

    #=======================================================================================#
    #======================================= SMS API =======================================#
    #=======================================================================================#

    private $appID = "qKKMuL7Baetq5cdaR5TBnLtKGKdKuKyb"; 
    // egzkIAzxGEu67igo4Xcxxzu8ogEeILEo --ews account
    // BkABUBA97jF5bcbaa4T9yAFzMkjeUbBr --lowil account
    // qKKMuL7Baetq5cdaR5TBnLtKGKdKuKyb  -lowil 2 account
    private $appSecretCode = "64960f423bafca7a060bf8b567f4d8346142d974e8ea387b58391ce42d4f4476"; 
    // 69aaa2830789b6f3a6e820e0ee5a3b1811fded49e34c18058eda910cddbba529 --ews account
    // 8d032697f9ba22c5ab3b44c7c78fe63a974ec2da5b09bbd581d41e2c7c1130e3 --lowil account
    // 64960f423bafca7a060bf8b567f4d8346142d974e8ea387b58391ce42d4f4476 --lowil 2 account
    private function initializeSMS_API() {
        
        require ('../vendor/globelabs/src/GlobeApi.php');
        $data = array();

        $globe = new \GlobeApi('v1');

        $auth = $globe->auth(
            $this->appID,
            $this->appSecretCode
        );

        $data = array($globe, $auth);

        return $data;

    }
    
    public function webSubscribe() {

        $data = $this->initializeSMS_API();
        $loginUrl = $data[1]->getLoginUrl();
        header('Location: ' . $loginUrl);
        die();
        
    }

    public function addSubscriber(Request $request) {

        $userID = $request->input('user_id');
        $userURL = $request->input('user_url');
        //$users = User::where("id", $userID)->get();
        //$subscribers = Subscribers::get();
        $subscribers = DB::table('tbl_subscribers')->get();
        $data = $this->initializeSMS_API();
        $urlLength = strlen($userURL);
        $codeStringPos = strpos($userURL, "?code=") + 6;
        $code = substr($userURL, $codeStringPos, $urlLength);
        $authResponse = $data[1]->getAccessToken($code);
        $accessToken = $authResponse["access_token"];
        $subscriberNumber = "+63" . $authResponse["subscriber_number"];
        $msg = "";

        $countSubscriber = count($subscribers);

        if ($countSubscriber == 0) {

            DB::table('tbl_subscribers')->insert(
                [ "user_id" => $userID,
                  "access_token" => $accessToken,
                  "subscriber_number" => $subscriberNumber ]
            );

            $msg = "1";

        } else if ($countSubscriber > 0) {

            foreach ($subscribers as $subscriber) {
                if ($userID != $subscriber->user_id) {

                    DB::table('tbl_subscribers')->insert(
                        [ "user_id" => $userID,
                          "access_token" => $accessToken,
                          "subscriber_number" => $subscriberNumber ]
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

        return $msg; 

    }

    public function sendMessage(Request $request){

        $data = $this->initializeSMS_API();
        $shortCode = "3777"; 
        //"29290580094" "21580094" --ews account
        //"29290582050" "21582050" -- lowil account
        //"29290583777" "21583777" -- lowil 2 account
        $recipient = $request->input('phone_number');
        $msg = $request->input('msg');
        $subscribers = DB::table('tbl_subscribers')->get();
        $accessToken = "";
        $subscriberNumber = "";
        $dataResponse = array();
        
        foreach ($recipient as $number) {
            foreach ($subscribers as $subscriber) {
                
                if ($number == $subscriber->subscriber_number) {

                    $accessToken = $subscriber->access_token;
                    $subscriberNumber = str_replace("+63", "0", $subscriber->subscriber_number);
                    $sms = $data[0]->sms($shortCode, 'v1');
                    $response = $sms->sendMessage($accessToken, $subscriberNumber, $msg);
                    break;

                }

            }
        }
        
        return "Message/s Sent.";
        
        /*
        require_once "systemdata/vendor/autoload.php";

        $recipient = $request->input('phone_number');

        $msg = $request->input('msg');
        //$msg = "Hello Lowil...";
        $confirmationMsg = "";
        $successCount = 0;
        $failedCount = 0;
        
        // Step 2: set our AccountSid and AuthToken from https://twilio.com/console
        $AccountSid = "ACad21c42984a8fe9292f9678dbeca13fe";
        $AuthToken = "2d2436d5f8ea4b7de234bad50497684f";

        // Step 3: instantiate a new Twilio Rest Client
        $client = new Client($AccountSid, $AuthToken);

        // Step 4: make an array of people we know, to send them a message. 
        // Feel free to change/add your own phone number and name here.

        $people = $recipient;

        // Step 5: Loop over all our friends. $number is a phone number above, and 
        // $name is the name next to it
        foreach ($people as $number) {

            try {

                $sms = $client->account->messages->create(

                // the number we are sending to - Any phone number
                $number,

                array(
                        // Step 6: Change the 'From' number below to be a valid Twilio number 
                        // that you've purchased
                        'from' => "+18172038618", 
                        
                        // the sms body
                        'body' => $msg
                    )
                );

                // Display a confirmation message on the screen
                $successCount++;
                
            } catch (Exception $e) {

                $failedCount++;
                
            }
            
        }

        $confirmationMsg = "$successCount Message/s Sent!";

        return $confirmationMsg; */

        /*
        require 'systemdata/vendor/autoload.php';

        $source = "DRRMIS";
        $recipient = "";
        $_recipient = $request->input('phone_number');
        $msg = $request->input('msg');

        $auth_id = "MAMWJJZTZMNWI2MGQYMJ";
        $auth_token = "NDRlNTNhOWQ3OTBlYmYyMTRlNGNhY2NhNTBlOGY5";
        $p = new RestAPI($auth_id, $auth_token);

        foreach ($_recipient as $key => $number) {

            if ($key == 0) {
                $recipient .= $number;
            } else if ($key > 0) {
                $recipient .= "<" . $number;
            }

        }

        $params = array(
            'src' => $source,
            'dst' => $recipient,
            'text' => $msg
        );
        $response = $p->send_message($params);

        return $response['response'];*/

    }

    public function testSMS(){

        /*
        //Chikka Messenger
        $arr_post_body = array(
            "message_type" => "SEND",
            "mobile_number" => "639129527475",
            "shortcode" => "292909029",
            "message_id" => "12345678901234567890123456789012",
            "message" => urlencode("Hello"),
            "client_id" => "6e640e6c46fd51c9cda91bc810b848879aa6e9d2c00b1fbbd9a85261b0d16af4",
            "secret_key" => "cd90aa75883684bb32f5ec8a61d04215aa6dc9a2546582793bb311a1bb3641e2"
        );

        $query_string = "";
        foreach($arr_post_body as $key => $frow)
        {
            $query_string .= '&'.$key.'='.$frow;
        }

        $URL = "https://post.chikka.com/smsapi/request";

        $curl_handler = curl_init();
        curl_setopt($curl_handler, CURLOPT_URL, $URL);
        curl_setopt($curl_handler, CURLOPT_POST, count($arr_post_body));
        curl_setopt($curl_handler, CURLOPT_POSTFIELDS, $query_string);
        curl_setopt($curl_handler, CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($curl_handler);
        curl_close($curl_handler);

        return $response;*/

        /*
        //Globe API

        //require_once "systemdata/vendor/autoload.php";
        require ('systemdata/vendor/globelabs/src/GlobeApi.php');

        $appID = "egzkIAzxGEu67igo4Xcxxzu8ogEeILEo";
        $appSecretCode = "69aaa2830789b6f3a6e820e0ee5a3b1811fded49e34c18058eda910cddbba529";
        $shortCode = "0094";
        $code = "Mkuq7zL8t7k5ERsyb7neCABGneILX5MrH566LESKXeBrUMkLpjSxpBrkSdARnzSxp5grCjaorefad565C57n4kIXeBdnSj64rbuMBMKLfXBGgeskK5MzH9aXAzhMoT48EB8TXMKhB554oHeEGEesp8MzgfnE4KaudqBGASndnEoIL658kCqKox7fyG5bnC95RLXS9eBxMS9nLLxSkqeR7UKG6aoSXM5a6H9dG7RIEo7BMCBR5nBs4AzAdtr6MoMu";
        $phoneNumber = "09465854398";
        $message = "Hello World!";
        
        $globe = new \GlobeApi('v1');

        $auth = $globe->auth(
            $appID,
            $appSecretCode
        );

        //$loginUrl = $auth->getLoginUrl();
        //header('Location: '.$loginUrl);

        $accessToken = $auth->getAccessToken($code);

        //$sms = $globe->sms($shortCode);
        //$response = $sms->sendMessage($accessToken["access_token"], $phoneNumber, $message);

        return $response;
        */

        /*
        //semaphore
        $one_number = "639129527475";
        $string_from = "SEMAPHORE";
        $string_message = "Hello World!";

        $fields = array();
        $fields["api"] = "MTgD6pqxZ726wKvQRDHu";
        $fields["number"] = $one_number; //safe use 63
        $fields["message"] = $string_message;
        $fields["from"] = $string_from;
        $fields_string = http_build_query($fields);
        $outbound_endpoint = "http://api.semaphore.co/api/sms";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $outbound_endpoint);
        curl_setopt($ch,CURLOPT_POST, count($fields));
        curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);

        return $output; */

        /*
        //pushbullet
        require_once "systemdata/vendor/autoload.php";

        // Get your access token here: https://www.pushbullet.com/account
        $pb = new \Pushbullet\Pushbullet('o.yqA3cexPyWeVi7DnTTT6iSspuIxNYNlu');

        $people = $pb->device("Chrome")->getPhonebook();

        return $people;*/

        /*
        require_once "systemdata/vendor/autoload.php";

        $auth_id = "MAMWJJZTZMNWI2MGQYMJ";
        $auth_token = "NDRlNTNhOWQ3OTBlYmYyMTRlNGNhY2NhNTBlOGY5";

        $p = new RestAPI($auth_id, $auth_token);
        
        // Send a message
        $params = array(
                'src' => '+639129527475', // Sender's phone number with country code
                'dst' => '+639129527475', // receiver's phone number with country code
                'text' => 'Hi, Message from Plivo' // Your SMS text message
            );
        // Send message
        $response = $p->send_message($params);
        // Print the response
        print_r ($response['response']);
        // Loop throught the message uuids
        $uuids = $response['response']['message_uuid'];
            
        // Print the uuids
        foreach($uuids as $value){
            print_r ("Message UUID : {$value} <br>");
        }
        // When an invalid number is given as dst parameter, an error will be thrown and the message will not be sent
        /*
        $r = new RestAPI($auth_id, $auth_token);
        $params = array(
                'src' => '1111111111', // Sender's phone number with country code
                'dst' => '2222222222<33333', // receiver's phone number with country code
                'text' => 'Hi, Message from Plivo' // Your SMS text message
            );
        // Send message
        $response = $r->send_message($params);
        // Print the response
        print_r ($response['response']);*/




        /*
        //Globe API
        require ('systemdata/vendor/globelabs/src/GlobeApi.php');

        $appID = "egzkIAzxGEu67igo4Xcxxzu8ogEeILEo";
        $appSecretCode = "69aaa2830789b6f3a6e820e0ee5a3b1811fded49e34c18058eda910cddbba529";
        $shortCode = "0094"; //"29290580094" "21580094"
        $code = "Mkuq7zL8t7k5ERsyb7neCABGneILX5MrH566LESKXeBrUMkLpjSxpBrkSdARnzSxp5grCjaorefad565C57n4kIXeBdnSj64rbuMBMKLfXBGgeskK5MzH9aXAzhMoT48EB8TXMKhB554oHeEGEesp8MzgfnE4KaudqBGASndnEoIL658kCqKox7fyG5bnC95RLXS9eBxMS9nLLxSkqeR7UKG6aoSXM5a6H9dG7RIEo7BMCBR5nBs4AzAdtr6MoMu";
        $phoneNumber = "09465854398";
        $message = "Hello World!";
        
        $globe = new \GlobeApi('v1');

        $auth = $globe->auth(
            $appID,
            $appSecretCode
        );

        $authResponse = $auth->getAccessToken($code);
        $accessToken = $authResponse["access_token"];
        $subscriberNumber = $authResponse["subscriber_number"];

        $sms = $globe->sms($shortCode, 'v1');
        $response = $sms->sendMessage($accessToken, $phoneNumber, $message);

        return $response;*/

        /*
        //Plivo
        require 'systemdata/vendor/autoload.php';

        $auth_id = "MAMWJJZTZMNWI2MGQYMJ";
        $auth_token = "NDRlNTNhOWQ3OTBlYmYyMTRlNGNhY2NhNTBlOGY5";
        $p = new RestAPI($auth_id, $auth_token);

        $params = array(
            'src' => 'DRRMIS',
            'dst' => '+639129527475<+639217341212',
            'text' => 'Hello World!'
        );
        $response = $p->send_message($params);

        print_r ($response['response']);*/

        /*
        require ('systemdata/vendor/globelabs/src/GlobeApi.php');

        $appID = "egzkIAzxGEu67igo4Xcxxzu8ogEeILEo";
        $appSecretCode = "69aaa2830789b6f3a6e820e0ee5a3b1811fded49e34c18058eda910cddbba529";
        $shortCode = "21580094"; //"29290580094" "21580094"
        $code = "Mkuq7zL8t7k5ERsyb7neCABGneILX5MrH566LESKXeBrUMkLpjSxpBrkSdARnzSxp5grCjaorefad565C57n4kIXeBdnSj64rbuMBMKLfXBGgeskK5MzH9aXAzhMoT48EB8TXMKhB554oHeEGEesp8MzgfnE4KaudqBGASndnEoIL658kCqKox7fyG5bnC95RLXS9eBxMS9nLLxSkqeR7UKG6aoSXM5a6H9dG7RIEo7BMCBR5nBs4AzAdtr6MoMu";
        $phoneNumber = "+639129527475";
        $message = "Hello World!";

        $data = $this->initializeSMS_API();

        //$loginUrl = $auth->getLoginUrl();
        //header('Location: ' . $loginUrl);
        //die();

        
        $authResponse = $data[0]->getAccessToken($code);
        $accessToken = $authResponse["access_token"];
        $subscriberNumber = $authResponse["subscriber_number"];

        $sms = $data[1]->sms($shortCode, 'v1');
        $response = $sms->sendMessage($accessToken, $phoneNumber, $message);

        print_r($response);*/
        $tempDateTime = date_create("2017-02-02 00:15:06+08");

        $tempDate = date_format($tempDateTime, "Y-m-d H:i:s");
        echo $tempDate;
                    
    }    

}