<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\User;
use App\Verification;
use App\VisitPlan;
use Carbon\Carbon;
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
            return self::sendNotification('director', 'Verification Report',
                $user->name .' has verified ' . $user_2->name . '\'s visit plan '
                ,'Salesman Visit Plan successfully verified.'
                ,'Verification fail. Please try again later.');
        }
        else{
            return response()->json([
                'message'=>'Verification fail. Please try again later.'
            ],500);
        }
    }

    /*
     *  this function is for manager to fetch all salesman visit plan
     *  this function is used when manager want to verify salesman.
     *
     */

    //untuk approve
    public function getSalesmanVisitPlanForApprove(Request $request)
    {
        $this->validate($request, [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
        ]);

        $month = $request['month'];
        $year = $request['year'];

        $manager = $request->user();
        $salesmans_id = $manager->group->members->pluck('id');

        $visitplans = VisitPlan::whereMonth('valid_date', '=',$month)
            ->whereYear('valid_date','=', $year)
            ->where('status', 0)
            ->whereIn('user_id', $salesmans_id)
            ->orderByDesc('id')
            ->get();

        foreach ($visitplans as $item){
            $item->user = User::find($item->user_id)->name;
        }

        return response()->json($visitplans, 200);
    }

    //untuk visitplanlist (bedanya dengan nama)
    public function getUserVisitPlanList(Request $request, $id){

        /*
         * same rule apply on get user visit plan list
         * we set min value to 0 and max value to 6
         *
         * to get user visit plan on specific date,
         * we do exactly same thing on post visit plan list
         * we add day to the visit plan valid date
         *
         */
        $this->validate($request, [
            'day'=>'required|integer|min:0|max:6',
        ]);

        $visit_plan = VisitPlan::find($id);
        if($visit_plan==null){
            return response()->json([
                'message'=>'Visit plan id not found.'
            ],404);
        }

        /*
         * Get Visit Plan plan list by start_time value
         *
         * return format is array
         */
        $plan_list = $visit_plan->list_plans()->where('date_time', Carbon::createFromFormat('Y-m-d', $visit_plan->valid_date)->addDays($request['day'])->toDateString())->get();

        foreach ($plan_list as $item){
            $item->customer = Customer::find($item->customer_id);
        }

        return response([
            'plan_list'=>$plan_list,
            'salesman' =>User::find($visit_plan->user_id)->name
        ],200);
    }

    //untuk verify
    public function getSalesmanVisitPlanForVerify(Request $request)
    {
        $this->validate($request, [
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer',
        ]);

        $month = $request['month'];
        $year = $request['year'];

        $manager = $request->user();
        $salesmans_id = $manager->group->members->pluck('id');

        $visitplans = VisitPlan::whereMonth('valid_date', '=',$month)
            ->whereYear('valid_date','=', $year)
            ->whereIn('user_id', $salesmans_id)
            ->where('status', 2)
            ->withCount('list_plans as numb_of_plans')
            ->withCount(array('list_plans as numb_of_done'=>function($query){
                $query->where('status_done',2);
            }))
            ->get();

        foreach ($visitplans as $item){
            $item->user = User::find($item->user_id)->name;
        }

        return response()->json($visitplans, 200);
    }

    public function getPendingVisitPlan(Request $request){
        $this->validate($request,[
            'valid_date'=>'required|date_format:Y-m-d'
        ]);

        $valid_date = $request['valid_date'];

        $visitplans = DB::table('visit_plans')
            ->where('valid_date', $valid_date)
            ->where('status', 0) //means pending
            ->get();

        foreach($visitplans as $item){
            $item->user = User::find($item->user_id)->name;
        }

        return response()->json($visitplans, 200);
    }

    public function approveSalesmanVisitPlan(Request $request){
        $this->validate($request, [
            'visit_plan_id'=>'required',
            'status'=>'required'
        ]);
        $visit_plan_id = $request['visit_plan_id'];
        $visit_plan = VisitPlan::find($visit_plan_id);
        if($visit_plan==null){
            return response()->json([
                'message'=> 'Visit Plan id not found.'
            ],404);
        }

        $visit_plan->status = $request['status']; // 1 reject , 2 approve
        if($visit_plan->update()){
            return self::sendNotification('salesman_'.$visit_plan->user_id, 'Approve Visit Plan',
                'Your Visit Plan at '.Carbon::parse($visit_plan->valid_date)->format('d M y') . ' has been approved'
                ,'Salesman visit plan successfully approved', 'Fail to approve salesman visitplan');
        }

        return response()->json([
            'message'=>'Failed to approve salesman visitplan'
        ],500);
    }


    //this function is used to send notification.
    public function sendNotification($channel_name,$title, $body, $success_message, $error_message){
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
                "message" =>$success_message
            ],200);
        }
        return response()->json([
            "message"=>$error_message
        ],400);
    }
}
