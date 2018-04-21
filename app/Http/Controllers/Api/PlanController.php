<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\FollowUp;
use App\FollowUpCustomer;
use App\ListPlan;
use App\VisitPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Pusher\PushNotifications\PushNotifications;

class PlanController extends Controller
{
    public function postVisitPlan(Request $request){
        $this->validate($request, [
            'valid_date'=>'required|date_format:Y-m-d'
        ]);

        $user = $request->user();
        /*
         * Find user's visit plans which has week, month and year value same as the request value
         * -->  if its exist, then show error message to user that he already create plan on that week of month & year
         * -->  if its not exist, then save visit plan to database
         *
         */
        /*
         * $_plan is array format
         */
        $_plan = $user->visit_plans()->where('valid_date',$request['valid_date'])->get()->toArray();

        if(!empty($_plan)){
            return response()->json([
                'message'=>'You have already create a plan within current week, month and year.'
            ],400);
        }

        $plan = new VisitPlan();
        $plan->user_id = $user->id;
        $plan->valid_date = $request['valid_date'];
        $plan->save();

        return response()->json([
            'message'=>'Successfully created.'
        ],200);
    }

    /*
     * Get user visit plans under specific week, month, year
     *
     * return value in array
     */
    public function getUserVisitPlans(Request $request){
        $this->validate($request,[
            'valid_date'=>'required'
        ]);
        $user = $request->user();

        $_plan = $user->visit_plans()->where('valid_date')->get();

        return response()->json($_plan,200);
    }

    public function postUserVisitPlanList(Request $request){
        $this->validate($request,[
            'visit_plan_id'=>'required',
            'customer_id'=>'required',
            'date_time'=>'required|date_format:Y-m-d',
            'type'=>'required|integer|min:0|max:1'
        ]);

        /*
         * get the visit plan
         */
        $visit_plan = $request->user()->visit_plans()->find($request['visit_plan_id']);

        if($visit_plan ==null){
            return response()->json([
                'message'=>'Visit Plan id not found.'
            ],404);
        }

        /*
         * Before we create new plan, we check whether plans with request start_time and customer_id is exist or not (no same visit plan allowed on same day)
         * TODO: tambahkan penjagaan apabila plan list yang dibuat di bawah hari dari visit plan atau di atas hari dari visit plan (harus berada dalam range 1 minggu)
         */
        if($visit_plan->list_plans->where('date_time', $request['date_time'])->where('customer_id',$request['customer_id'])->first()==null){
            $plan = new ListPlan();
            $plan->visit_plan_id = $request['visit_plan_id'];
            $plan->customer_id = $request['customer_id'];
            $plan->date_time = $request['date_time'];
            $plan->type = $request['type'];
            $plan->save();

            return response()->json([
                'message'=>'Plan Added.'
            ],200);
        }
        return response()->json([
            'message' => 'Visit plan with current customer id is already exist.'
        ]);
    }

    public function getUserVisitPlanList(Request $request, $id){

        $this->validate($request, [
            'date_time'=>'required|date_format:Y-m-d',
        ]);

        $visit_plan = $request->user()->visit_plans()->find($id);
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
        $plan_list = $visit_plan->list_plans()->where('date_time', $request['date_time'])->get();

        return response($plan_list, 200);
    }

    public function deleteUserVisitPlan(Request $request){
        $this->validate($request,[
            'id'=>'required',
        ]);

        $visit_plan = $request->user()->visit_plans()->find($request['id']);
        if($visit_plan==null){
            return response()->json([
                'message'=>'Visit plan id not found.'
            ]);
        }

        if($visit_plan->status==2){
            return response()->json([
                'message'=>'Visit Plan that has been approved cannot be edited anymore. '
            ],200);
        }

        if($visit_plan->delete()){
            return response()->json([
                'message'=>'Visit Plan successfully deleted.'
            ],200);
        }
        return response()->json([
            'message'=>'Fail to delete Visit Plan'
        ],400);
    }

    public function updateUserVisitPlanList(Request $request){
        $this->validate($request, [
            'id'=>'required', //plan list id
            'visit_plan_id'=>'required',
            'customer_id'=>'required',
            'date_time'=>'required|date_format:Y-m-d',
            'type'=>'required|integer|min:0|max:1'
        ]);

        $visit_plan = $request->user()->visit_plans()->find($request['visit_plan_id']);
        $plan = $visit_plan->list_plans->find($request['id']);

        /*
         * First, we check if visit_plan is exist
         * Second, we check the visit plan status, if current status is approved, update process is not allowed
         * Third, we check if the plan is exist
         * Last, we check if the new plan customer id is exist
         */
        if($visit_plan == null){
            return response()->json([
                'message'=>'Visit Plan id not found.'
            ],404);
        }

        if($visit_plan->status==2){
            return response()->json([
                'message'=>'Visit Plan that has been approved cannot be edited anymore.'
            ],400);
        }

        if($plan == null){
            return response()->json([
                'message'=>'Plan List id not found.'
            ],404);
        }

        if($visit_plan->list_plans->where('start_time', $request['start_time'])->where('customer_id',$request['customer_id'])->first()==null){

            $plan->visit_plan_id = $request['visit_plan_id'];
            $plan->customer_id = $request['customer_id'];
            $plan->date_time = $request['date_time'];
            $plan->type = $request['type'];
            $plan->update();

            return response()->json([
                'message'=>'Plan Update'
            ],200);
        }
        return response()->json([
            'message' => 'Visit plan with current customer id is already exist.'
        ]);
    }

    public function deleteUserVisitPlanList(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'visit_plan_id'=>'required'
        ]);

        $visit_plan = $request->user()->visit_plans()->find($request['visit_plan_id']);
        $plan = $visit_plan->list_plans->find($request['id']);

        if($visit_plan == null){
            return response()->json([
                'message'=>'Visit Plan id not found.'
            ],404);
        }

        if($visit_plan->status==2){
            return response()->json([
                'message'=>'Visit Plan that has been approved cannot be edited anymore.'
            ],400);
        }

        if($plan == null){
            return response()->json([
                'message'=>'Plan List id not found.'
            ],404);
        }

        $plan->delete();
        return response()->json([
            'message'=>'Plan List successfully deleted.'
        ],200);
    }

    public function postAskForApproval(Request $request){
        $this->validate($request,[
            'visit_plan_id'=>'required',
        ]);

        $user = $request->user();
        if($user->role_id==5){
            $channel_name = "retail_manager_";
        }
        else{
            $channel_name = "project_manager_";
        }

        $visit_plan = $user->visit_plans()->find($request['visit_plan_id']);
        /*
         * We need to check the user role
         * -->  if $user->role_id == 5 (means he is retail salesman, so the channel name that we want to send the notification is retail_manager_)
         * -->  if $user->role_id == 6 (means he is project salesman, so the channel name that we want to send the notification is project_manager_)
         *
         */
        if($visit_plan==null){
            return response()->json([
                'message'=>'Visit Plan id not found.'
            ],200);
        }

        if($visit_plan->status==2){
            return response()->json([
                'message'=>'Visit Plan has already been approved'
            ],400);
        }

        /*
         * Set the status to pending
         * Set notification title to "Asking for approval"
         * Set notification body to "User Name is asking for plan approval"
         */
        $visit_plan->status = 0;
        $title = 'Asking for approval';
        $body = $user->name . ' is asking for visit plan approval!';

        if($visit_plan->update()){
            return self::sendNotification($channel_name, $user->group->leader()->role_id, $title, $body);
        }
        return response([
            'message'=>'Failed to send approval request.'
        ], 400);
    }

    public function postFollowUp(Request $request){
        $this->validate($request, [
            'address'=>'required',
            'date_time'=>'required',
        ]);

        $user = $request->user();
        $follow_up = new FollowUp();
        $follow_up->user_id = $user->id;
        $follow_up->address = $request['address'];
        $follow_up->date_time = $request['date_time'];

        $follow_up->save();

        return response()->json([
            'message'=>'Follow up end-user successfully created.'
        ]);
    }

    public function postFollowUpCustomer(Request $request){
        $this->validate($request,[
            'date_time'=>'required',
            'customer_id'=>'customer_id'
        ]);

        $user = $request->user();
        if($user->follow_up_customers()->where('customer_id', $request['customer_id'])->where('date_time',$request['date_time'])->first()==null){
            $follow_up_customer = new FollowUpCustomer();
            $follow_up_customer->user_id = $user->id;
            $follow_up_customer->customer_id = $request['customer_id'];
            $follow_up_customer->date_time = $request['date_time'];
            $follow_up_customer->save();

            return response()->json([
                'message'=>'Follow up customer successfully created.'
            ],200);
        }

        return response()->json([
            'message'=>'Follow up customer with current customer id is already exist.'
        ],400);
    }

    public function getFollowUp(Request $request){
        $this->validate($request, [
            'status'=>'required',
        ]);

        if($request['status'] == 'active'){
            $follow_ups = $request->user()->follow_ups()->where('status_done',0)->get();
            $follow_up_customers = $request->user()->follow_up_customers()->where('status_done',0)->get();

            foreach($follow_up_customers as $item){
                $item->customer = Customer::find($item->customer_id);
            }

            $result  = $follow_ups->concat($follow_up_customers);

            return response()->json($result,200);
        }

        else if($request['status']=='history'){
            $follow_ups = $request->user()->follow_ups()->where('status_done',1);
            $follow_up_customers = $request->user()->follow_up_customers()->where('status_done',1);

            foreach($follow_up_customers as $item){
                $item->customer = Customer::find($item->customer_id);
            }

            $result  = $follow_ups->concat($follow_up_customers);

            return response()->json($result,200);
        }

        return response()->json([
            'message'=>'Failed to get follow up.'
        ],200);
    }

    public function sendNotification($channel_name, $role_id, $title, $body){
        $pushNotification = new PushNotifications(array(
            "instanceId" => "8402f9d4-872e-4ed8-9f9a-f9fffd742db3",
            "secretKey"=>"13785DC78D0EA21BB02B35C13DD3F1A",
        ));

        $publishResponse = $pushNotification->publish(
            array( $channel_name . $role_id), //this is the channel where the notification will be send
            array(
                "apns" => array("aps" => array(
                    "alert" => "Hello!",
                )),

                //on our case, we use fcm format..
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
                "message" =>"Approval request has been sent."
            ],200);
        }
        return response()->json([
            "message"=>"Failed to send approval request."
        ],400);
    }
}
