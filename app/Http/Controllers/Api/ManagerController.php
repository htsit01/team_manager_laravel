<?php

namespace App\Http\Controllers\Api;

use App\User;
use App\Verification;
use App\VisitPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Pusher\PushNotifications\PushNotifications;

class ManagerController extends Controller
{
    //manager
    public function verifyVisitPlan(Request $request){
        $this->validate($request, [
            'visit_plan_id'=> 'required',
            'date_time'=>'required|date_format:Y-m-d H:i:s',
        ]);

        $user = $request->user();
        $visit_plan_id = $request['visit_plan_id'];
        $date_time = $request['date_time'];

        $visit_plan = VisitPlan::find($visit_plan_id);
        $user_2 =  User::find($visit_plan->user_id);

        if($visit_plan==null){
            return response()->json([
                'message'=>'Plan id not found.'
            ],404);
        }
        $visit_plan->is_verify = 1;
        $visit_plan->save();

        $verification = new Verification();
        $verification->visit_plan_id = $visit_plan_id;
        $verification->user_id = $user->id;
        $verification->date_time = $date_time;

        if($verification->save()){
            return self::sendNotification('director', 'Verification Report', $user->name .' has verified ' . $user_2->name . '\'s visit plan ');
        }
        else{
            return response()->json([
                'message'=>'Verification fail. Please try again later.'
            ],500);
        }
    }

    //manager

    public function getSalesmanVisitPlan(Request $request)
    {
        $this->validate($request, [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
        ]);

        $month = $request['month'];
        $year = $request['year'];

        $visitplan = DB::table('visit_plans')
            ->whereMonth('valid_date', $month)
            ->whereYear('valid_date', $year)
            ->get();

        foreach ($visitplan as $item){
            $item->user = User::find($item->user_id);
        }

        return response()->json($visitplan, 200);
    }

    public function sendNotification($channel_name,$title, $body){
        $pushNotification = new PushNotifications(array(
            "instanceId" => "8d1eb444-d7c9-45d6-95a3-cbe1ab9d7253",
            "secretKey"=>"01A6D13F48BECE00D27216C5FD8A0DF",
        ));

        $publishResponse = $pushNotification->publish(
            array($channel_name), //this is the channel where the notification will be send
            array(
                "fcm" => array("notification" => array(
                    "title" => $title,
                    "body" => $body,
                )),
            )
        );

        //if we dont include this line of code
        //user wont know whether their notification has been send or not.
        if($publishResponse){
            return response()->json([
                "message" =>"Visit plan successfully verified."
            ],200);
        }
        return response()->json([
            "message"=>"Verification fail. Please try again later."
        ],400);
    }
}
