<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Pusher\PushNotifications\PushNotifications;

class NotificationController extends Controller
{
    /*
     * this function is for send notification to specific chanel that we want
     * for this project, we use pusher api. link: https://pusher.com/
     * instancedId & secretKey obtained from firebase site
     * (you need to create your project on firebase console)
     */
    public function postSendNotif(Request $request){
        $pushNotification = new PushNotifications(array(
            "instanceId" => "8402f9d4-872e-4ed8-9f9a-f9fffd742db3",
            "secretKey"=>"13785DC78D0EA21BB02B35C13DD3F1A",
        ));

        $publishResponse = $pushNotification->publish(
            array("hello"), //this is the channel where the notification will be send
            array(
                "apns" => array("aps" => array(
                    "alert" => "Hello!",
                )),

                //on our case, we use fcm format..
                "fcm" => array("notification" => array(
                    "title" => $request['title'],
                    "body" => $request['body'],
                )),
            )
        );

        //if we dont include this line of code
        //user wont know whether their notification has been send or not.
        if($publishResponse){
            return response()->json([
                "message" =>"sukses"
            ],200);
        }
        return response()->json([
            "message"=>"failed"
        ]);
    }

    public function postSendMail(){

        /*
         * this function is to send mail to specific email address.
         * the sender email information can be get on .env file
         *
         */

        Mail::send([],[],function($message){
            $message->to('littledeveloper1611@gmail.com')
                ->subject('Welcome')
                ->setBody('Hi, welcome User');
        });

        //if we dont include this line of code
        //user wont know whether their email has been send or not.
        if(Mail::failures()){
            return response()->json([
                "message"=> "sending email failed"
            ]);
        }
        else{
            return response()->json([
                "message"=> "success"
            ]);
        }
    }
}
