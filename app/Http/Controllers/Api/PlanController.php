<?php

namespace App\Http\Controllers\Api;

use App\Customer;
use App\FollowUp;
use App\FollowUpCustomer;
use App\ListPlan;
use App\VisitPlan;
use Carbon\Carbon;
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
        $time = Carbon::createFromFormat('Y-m-d', $request['valid_date']);

        if(!empty($_plan)){
            return response()->json([
                'message'=>'You have already create a plan within current week, month and year.'
            ],400);
        }

        $plan = new VisitPlan();
        $plan->user_id = $user->id;
        $plan->valid_date = $request['valid_date'];
//        $plan->valid_month = $time->month;
//        $plan->valid_year = $time->year;
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
            /*
             * valid date is only monday date. (because every visit plan, will start on monday)
             * in the front end, user will fetch monday date on specific year and month on DateController
             *
             */
            'valid_date'=>'required|date_format:Y-m-d'
        ]);
        $user = $request->user();

        $_plan = $user->visit_plans()->where('valid_date', $request['valid_date'])->get();

        return response()->json($_plan,200);
    }

    public function postUserVisitPlanList(Request $request){

        /*
         * changes: back then, we use week, month, year parameter to get visit plan list
         * this can cause ambiguity and error in specific case. for example 30 april 2018
         * 30 april is the last date of april. mean while the next visit plan list will be on may month
         * it means, when we filter using week, month, year, it wont show the May visit plan list
         */
        $this->validate($request,[
            'visit_plan_id'=>'required',
            'customer_id'=>'required',
            'day'=>'required|integer|min:0|max:6',
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
         * the way we save visit plan list date time is we get our visit plan valid_date (means where visit plan start/monday)
         * then, we add the valid date with the day request data that we need
         * the reason why day min allowed value is 0 is if we put min = 1, means when user send day=1
         * we will set the visit plan list date time by adding the valid date with 1 (means it will be tomorrow after the valid date
         * in other word, we will never able to set plan list on the first day of our visit plan (on the valid date which is monday)
         * thats why we set 0 as min value  and 6 as max value (if we plus 6, day will be on sunday)
         */
        if($visit_plan->list_plans->where('date_time',Carbon::createFromFormat('Y-m-d',$visit_plan->valid_date)->addDays($request['day'])->toDateString())->where('customer_id',$request['customer_id'])->first()==null){
            $plan = new ListPlan();
            $plan->visit_plan_id = $request['visit_plan_id'];
            $plan->customer_id = $request['customer_id'];
            $plan->date_time = Carbon::createFromFormat('Y-m-d',$visit_plan->valid_date)->addDays($request['day'])->toDateString();
            $plan->type = $request['type'];
            if($request['description']){
                $plan->description = $request['description'];
            }
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
        $plan_list = $visit_plan->list_plans()->where('date_time', Carbon::createFromFormat('Y-m-d', $visit_plan->valid_date)->addDays($request['day'])->toDateString())->get();

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
            'day'=>'required|min=0|max=6',
            'type'=>'required|integer|min:0|max:1',
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

        /*
         * when user wants to edit the visit plan list,
         * we have to recheck if the plan with exact starttime and customer id is exist
         * if it is exist, then show error message;
         * if not, update the plan
         */
        if($visit_plan->list_plans->where('date_time',  Carbon::createFromFormat('Y-m-d', $visit_plan->valid_date)->addDays($request['day'])->toDateString())->where('customer_id',$request['customer_id'])->first()==null){

            /*
             * here, we dont have to set date_time value to the plan
             * because it will still remain the same
             * it happens because we planning to make user unable to change plan list date when they want to edit the plan
             * if the want to move it to other day, then delete the old one and add new one to specific day that they want.
             */
            $plan->visit_plan_id = $request['visit_plan_id'];
            $plan->customer_id = $request['customer_id'];
            $plan->type = $request['type'];

            if($request['description']){
                $plan->description = $request['description'];
            }

            $plan->update();

            return response()->json([
                'message'=>'Plan Update'
            ],200);
        }
        return response()->json([
            'message' => 'Visit plan with current customer id is already exist.'
        ]);
    }

    public function deleteUserVisitPlanList(Request $request, $id){
        $this->validate($request,[
            'visit_plan_id'=>'required'
        ]);

        $visit_plan = $request->user()->visit_plans()->find($request['visit_plan_id']);
        $plan = $visit_plan->list_plans->find($id);

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

        /*
         * we send this reponse to user to indicates if the asking for approval method work properly
         */
        if($visit_plan->update()){
            return self::sendNotification($channel_name, $user->group->leader()->role_id, $title, $body);
        }
        return response([
            'message'=>'Failed to send approval request.'
        ], 400);
    }

    public function postFollowUp(Request $request){
        $this->validate($request, [
            'name'=>'required',
            'address'=>'required',
            'date_time'=>'required',
        ]);

        $user = $request->user();
        $follow_up = new FollowUp();
        $follow_up->user_id = $user->id;
        $follow_up->name = $request['name'];
        $follow_up->address = $request['address'];
        $follow_up->date_time = $request['date_time'];

        if($request['description']){
            $follow_up->description = $request['description'];
        }

        $follow_up->save();
        return response()->json([
            'message'=>'Follow up end-user successfully created.'
        ]);
    }

    public function postFollowUpCustomer(Request $request){
        $this->validate($request,[
            'date_time'=>'required',
            'customer_id'=>'required',
        ]);

        $user = $request->user();
        if($user->follow_up_customers()->where('customer_id', $request['customer_id'])->where('date_time',$request['date_time'])->first()==null){
            $follow_up_customer = new FollowUpCustomer();
            $follow_up_customer->user_id = $user->id;
            $follow_up_customer->customer_id = $request['customer_id'];
            $follow_up_customer->date_time = $request['date_time'];

            if($request['description']){
                $follow_up_customer->description = $request['description'];
            }

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
            'date_time'=>'required',
        ]);

        if($request['status'] == 'active'){
            $follow_ups = $request->user()->follow_ups()->whereIn('status_done',[0,1])->where('date_time', $request['date_time'])->get();
            $follow_up_customers = $request->user()->follow_up_customers()->whereIn('status_done',[0,1])->where('date_time', $request['date_time'])->get();

            foreach($follow_up_customers as $item){
                $item->customer = Customer::find($item->customer_id);
            }

            $result  = $follow_ups->concat($follow_up_customers);

            return response()->json($result,200);
        }

        else if($request['status']=='history'){
            $follow_ups = $request->user()->follow_ups()->where('status_done',2)->where('date_time', $request['date_time'])->get();
            $follow_up_customers = $request->user()->follow_up_customers()->where('status_done',2)->where('date_time', $request['date_time'])->get();

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

    public function saveVisitPlanReport(Request $request){
        $this->validate($request, [
            'id' => 'required',
            'report'=>'required'
        ]);
        $user = $request->user();
        $plan = $user->visit_plans()->find($request['id']);

        if($plan ==  null){
            return response()->json([
                'messsage'=>'Plan id is not found.'
            ],404);
        }

        $plan->report = $request['report'];
        $plan->update();

        return response()->json([
            'message'=>'Report successfully saved'
        ],200);
    }

    public function saveFollowUpReport(Request $request){
        $this->validate($request,[
            'id'=>'required',
            'report'=>'required'
        ]);
        $user = $request->user();
        $plan = $user->visit_plans()->find($request['id']);

        if($plan ==  null){
            return response()->json([
                'messsage'=>'Plan id is not found.'
            ],404);
        }

        $plan->report = $request['report'];
        $plan->update();

        return response()->json([
            'message'=>'Report successfully saved'
        ],200);
    }



    public function sendNotification($channel_name, $role_id, $title, $body){
        $pushNotification = new PushNotifications(array(
            "instanceId" => "8d1eb444-d7c9-45d6-95a3-cbe1ab9d7253",
            "secretKey"=>"01A6D13F48BECE00D27216C5FD8A0DF",
        ));

        $publishResponse = $pushNotification->publish(
            array( $channel_name . $role_id), //this is the channel where the notification will be send
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
                "message" =>"Approval request has been sent."
            ],200);
        }
        return response()->json([
            "message"=>"Failed to send approval request."
        ],400);
    }
}
