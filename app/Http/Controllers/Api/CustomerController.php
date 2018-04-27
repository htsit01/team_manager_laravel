<?php

namespace App\Http\Controllers\Api;

use App\CheckIn;
use App\CheckOut;
use App\CreditForm;
use App\CreditFormSupplier;
use App\Customer;
use App\CustomerArea;
use App\FollowUp;
use App\FollowUpCustomer;
use App\ListPlan;
use App\Verification;
use App\VisitPlan;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    /*
     * Customer controller is controller that handle:
     * -->  Checkin
     * -->  Checkout
     * -->  Follow Up
     * -->  Register Customer
     *
     */

    public function postCheckin(Request $request){

        $this->validate($request, [
            'customer_id'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            'address'=>'required',
            'date_time'=>'required',
            'plan_id'=>'required'
        ]);

        $user = $request->user();
        $customer_id = $request['customer_id'];
        $lat = $request['lat'];
        $lng = $request['lng'];
        $address = $request['address'];
        $date_time = $request['date_time'];
        $plan_id = $request['plan_id'];

        $plan = ListPlan::find($plan_id);

        if($plan== null){
            return response()->json([
                'message' => 'Plan not found'
            ]);
        }

        if($plan->visit_plan->status!=2){
            return response()->json([
                'message' => 'Plan hasn\'t been approved'
            ]);
        }

        /*
         * We get current user last checkin and last checkout.
         * This is for determined whether user can do checkin or not
         */

        $last_checkin = $user->checkins->sortByDesc('date_time')->first();
        $last_checkout = $user->checkouts->sortByDesc('date_time')->first();

        /*
         * if last_checkin is null it means user havent sign in to this place before
         * so user can do checkin in this place
         *
         * we dont check whether user last_checkout is null or not because we will
         * protect it on checkout function
         *
         */
        if($last_checkin==null){
            $checkin = new CheckIn();
            $checkin->user_id = $user->id;
            $checkin->customer_id = $customer_id;
            $checkin->lat = $lat;
            $checkin->lng = $lng;
            $checkin->address = $address;
            $checkin->date_time = $date_time;
            $checkin->plan_id = $plan_id;
            $checkin->save();

            $plan->status_done = 1;
            $plan->start_time = $date_time;
            $plan->update();

            return response()->json([
                'message'=>"Successfully Checkin"
            ],200);
        }

        /*
         * when we reach this state, we know that last_checkin is not null
         * then it means, we need to check if last_checkout is null
         * -->  if null, then it means, user hasn't checkout from previous customer before
         * -->  if not null, then it means, we need to check whether the last_checkout is the "real" checkout action for the last_checkin
         *
         */
        if($last_checkin->customer_id == $customer_id && $last_checkin->plan_id == $plan_id && $last_checkin->user_id == $user->id){
            return response()->json([
                'messsage'=>'You cannot checkin more than once on same plan.'
            ],400);
        }

        if($last_checkout==null){
            return response()->json([
                'message'=>'You haven\'t checkout from previous customer.'
            ], 400);
        }

        /*
         * Now we are reaching state where our last_checkin and last_checkout is not null
         * It means, we need to check is our last_checkout is the "real" checkout action for last_checkin
         * We will know the checkout is real or not by check both of last_checkin and last_checkout customer_id
         * -->  if its not same, it means, user hasnt sign out from previous customer
         *      example:
         *      the last_checkin->customer_id = 2;
         *      the last_checkout->customer_id = 3,
         *      it means, user hasnt sign out from customer 2
         * -->  if its same, it means, we need to check the date_time
         *      --> if the last_checkin->date_time > last_checkout->date_time
         *          it means, user hasn't checkout from previous customer
         *          example:
         *          the last_checkin->date_time = 13-04-2018 16:14:50;
         *          the last_checkout->date_time = 13-04-2018 15:30:20;
         *      --> if the last_checkin->date_time <= last_checkout->date_time
         *          it means, we are save to save checkin data to database
         */
        if($last_checkin->customer_id != $last_checkout->customer_id){
            return response()->json([
                "message"=>"You haven't checkout from previous customer."
            ],400);
        }

        // here we check the last_checkin->date_time and last_checkout->date_time
        if(strtotime($last_checkin->date_time)>strtotime($last_checkout->date_time)){
            return response()->json([
                'message'=>'You haven\'t checkout from previous customer.'
            ],400);
        }

        // save to save the checkin data to database
        $checkin = new CheckIn();
        $checkin->user_id = $user->id;
        $checkin->customer_id = $customer_id;
        $checkin->lat = $lat;
        $checkin->lng = $lng;
        $checkin->address = $address;
        $checkin->date_time = $date_time;
        $checkin->plan_id = $plan_id;
        $checkin->save();

        $plan->status_done = 1;
        $plan->start_time = $date_time;
        $plan->update();

        return response()->json([
            'message'=>"Successfully Checkin"
        ],200);
    }

    public function postCheckout(Request $request){

        $this->validate($request, [
            'customer_id'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            'address'=>'required',
            'date_time'=>'required',
            'plan_id'=>'required'
        ]);

        $user = $request->user();
        $customer_id = $request['customer_id'];
        $lat = $request['lat'];
        $lng = $request['lng'];
        $address = $request['address'];
        $date_time = $request['date_time'];
        $plan_id = $request['plan_id'];

        $last_checkin = $user->checkins->sortByDesc('date_time')->first();
        $last_checkout = $user->checkouts->sortByDesc('date_time')->first();

        /*
         * -->  if last checkin is null, means user havent done checkin process
         *      it means, there is no way for the user to do checkout process
         */
        if($last_checkin==null){
            return response()->json([
                "message"=>"You haven\'t checkin to this place."
            ],400);
        }

        /*
         * now we are on state where last checkin is not null
         * the next step we do is check the last checkout status
         *
         * -->  if last checkout status is null
         *      then its means, we need to check whether last_checkin->customer_id == current customer id that user want to checkout
         *      --> if it is same, then save the checkout info to database
         *      --> if it is different,
         * -->  if last checkout status is not null
         *      we need to check whether last_checkin->customer_id == current customer id that user want to checkout
         *      --> if it is same, then we need to check whether last_checkin date < last_checkout or not
         *          --> if its smaller, then it means, user hasnt checkin to the current customer
         *          example:
         *          Today is 16 April 2018
         *          user want to checkout from Customer A
         *          the last_checkin data is 15 April 2018 10:53:13
         *          the last_checkin data is 15 April 2018 11:10:12
         *          then it means, the user hasnt checkin to the current customer
         *          --> other than that, then it means, we safe to save the data to database.
         */
        if($last_checkout == null){
            /*
             * check last_checkin-->customer_id
             */
            if($last_checkin->customer_id == $customer_id){
                $checkout = new CheckOut();
                $checkout->user_id = $user->id;
                $checkout->customer_id = $customer_id;
                $checkout->lat = $lat;
                $checkout->lng = $lng;
                $checkout->address = $address;
                $checkout->date_time = $date_time;
                $checkout->plan_id = $plan_id;
                $checkout->save();

                /*
                 * Here we need to update the Listplan finish_time, status_done and status_color
                 * status color:
                 * -->  0 means user hasn't finish his plans (front_end, color == red)
                 * -->  1 means user has finished his plans on same day(front_end, color == green)
                 * -->  2 means user has finished his plans but on different day (front_end, color == orange)
                 *
                 * before we set the color status, we need to check the listplan type
                 * -->  if the listplan type == 0 (daily plan)
                 *      we compare the finish time with start time (start time here means visit plans date)
                 *      --> if finish time > start time, set status color to 2
                 *      --> other than that, set status to 1
                 * -->  if the listplan type == 1 (periodic plan)
                 *      we need to set the threshold_time for finish time (end of the week (sunday))
                 *      then we compare finish time with threshold_time
                 *      --> if finish_time > threshold_time, set status color to 2
                 *      --> other than that, set status to 1
                 */
                $plan = ListPlan::find($plan_id);
                $plan->finish_time = $date_time;
                $plan->status_done = 2;
                if($plan->type == 0){
                    if(strtotime(Carbon::parse($plan->finish_time)->format('Y-m-d'))>strtotime($plan->date_time)){
                        $plan->status_color = 2;
                    }
                    else{
                        $plan->status_color = 1;
                    }
                }
                else{
                    /*
                     * Set the threshold time to the end of the week from plan start_time
                     */
                    $threshold_time = Carbon::createFromFormat('Y-m-d', $plan->date_time)->endOfWeek()->toDateString();

                    if(strtotime(Carbon::parse($plan->finish_time)->format('Y-m-d'))>strtotime($threshold_time)){
                        $plan->status_color = 2;
                    }
                    else{
                        $plan->status_color = 1;
                    }
                }
                $plan->update();

                return response()->json([
                    'message'=>'Successfully Checkout'
                ],200);
            }
            return response()->json([
                'message'=>'You haven\'t checkin to this place.'
            ],400);
        }

        /*
         * Now we reach the state where last_checkout is not null
         * We need to compare last_chekckin and last_checkout time
         */

        if(strtotime($last_checkin->date_time)<=strtotime($last_checkout->date_time)){
            return response()->json([
                'message'=>'You haven\'t checkin to this place.'
            ]);
        }

        /*
         * Safe to save to database
         */
        $checkout = new CheckOut();
        $checkout->user_id = $user->id;
        $checkout->customer_id = $customer_id;
        $checkout->lat = $lat;
        $checkout->lng = $lng;
        $checkout->address = $address;
        $checkout->date_time = $date_time;
        $checkout->plan_id = $plan_id;
        $checkout->save();

        $plan = ListPlan::find($plan_id);
        $plan->finish_time = $date_time;
        $plan->status_done = 2;
        if($plan->type == 0){
            if(strtotime(Carbon::parse($plan->finish_time)->format('Y-m-d'))>strtotime($plan->date_time)){
                $plan->status_color = 2;
            }
            else{
                $plan->status_color = 1;
            }
        }
        else{
            /*
             * Set the threshold time to the end of the week from plan start_time
             */
            $threshold_time = Carbon::createFromFormat('Y-m-d', $plan->date_time)->endOfWeek()->toDateString();

            if(strtotime(Carbon::parse($plan->finish_time)->format('Y-m-d'))>strtotime($threshold_time)){
                $plan->status_color = 2;
            }
            else{
                $plan->status_color = 1;
            }
        }
        $plan->update();

        return response()->json([
            'message'=>'Successfully Checkout'
        ]);
    }

    public function postRegisterCustomer (Request $request){
        $user = $request->user();

        $this->validate($request, [
            'work_field'=>'required',
            'name'=>'required',
            'since'=>'required|date_format:Y-m-d',
            'owner_name' => 'required',
            'resident_card_id'=>'required',
            'npwp_pkp'=>'required',
            'customer_area_id'=>'required',
            'phone'=>'required',
            'lat'=>'required',
            'lng'=>'required',
            'billing_address'=>'required',
            'credit_term' =>'required',
            'credit_plafon' =>'required',
            'ktp_img'=>'file',
            'customer_img'=>'file'
        ]);


        $array_supplier_name = $request['supplier_name'];
        $array_supplier_omset = $request['omset_estimation'];
        $array_supplier_credit = $request['credit_term'];
        $array_supplier_information = $request['information'];

        if(count($array_supplier_name)!= count($array_supplier_omset) && count($array_supplier_name)!= count($array_supplier_credit) && count($array_supplier_name)!=count($array_supplier_information)){
            return response()->json([
                'message'=>'Please make sure you send all the required data.'
            ]);
        }

        /*
         * Save all the customer data.
         */
        $customer = new Customer();
        $customer->lat = $request['lat'];
        $customer->lng = $request['lng'];
        $customer->name = $request['name']; //customer name (customer_id)
        $customer->billing_address = $request['billing_address'];
        $customer->phone = $request['phone'];
        $customer->customer_area_id = 1;

        /*
         * Check all optional request..
         * If user does send the request,then save it
         * otherwise, ignore it
         */
        if($request['shipping_address']){
            $customer->shipping_address  = $request['shipping_address'];
        }
        if($request['fax']){
            $customer->fax = $request['fax'];
        }

        /*
         * -->  if saving customer process is successfully execute, then continue the saving credit form process
         *      --> if saving credit form is successfully execute, save credit form then show success message to user
         *      --> if saving credit form is failed, then delete the registered customer
         * -->  if saving customer process is failed, then show error message to user, and skip inserting credit form data
         */
        if($customer->save()){
            /*
             * Save all credit form data
             */

            if($request->file('ktp_img')){
                $ktp_img = $request->file('ktp_img');
                $ktp_img->move(public_path('images').'/customer/ktp/'.'customer_'.$customer->id.'.'.$ktp_img->getClientOriginalExtension());
                $customer->ktp_img = '/images/customer/ktp/customer_'.$customer->id.'.'.$ktp_img->getClientOriginalExtension();
            }

            if($request->file('customer_img')){
                $customer_img = $request->file('customer_img');
                $customer_img->move(public_path('images').'/customer/ktp/'.'customer_'.$customer->id.'.'.$customer_img->getClientOriginalExtension());
                $customer->customer_img = '/images/customer/ktp/customer_'.$customer->id.'.'.$customer_img->getClientOriginalExtension();
            }

            $customer->save();

            $credit_form  = new CreditForm();
            $credit_form->customer_id = $customer->id;
            $credit_form->user_id = $user->id;
            $credit_form->work_field = $request['work_field'];
            $credit_form->since = $request['since'];
            $credit_form->owner_name = $request['owner_name'];
            $credit_form->resident_card_id = $request['resident_card_id'];
            $credit_form->npwp_pkp = $request['npwp_pkp'];
            $credit_form->credit_term = $request['credit_term'];
            $credit_form->credit_plafon = $request['credit_plafon'];

            /*
             * Check all optional request..
             * If user does send the request,then save it
             * otherwise, ignore it
             */
            if($request['owner_address']){
                $credit_form->owner_address = $request['owner_address'];
            }
            if($request['customer_status']){
                $credit_form->customer_status = $request['customer_status'];
            }
            if($request['recommended_by']){
                $credit_form->recommended_by = $request['recommended_by'];
            }
            if($request['other_supported_invoice']){
                $credit_form->other_supported_invoice = $request['other_supported_invoice'];
            }

            /*
             * if process success, our job to register customer is done
             */
            if($credit_form->save()){

                for($i = 0;$i<count($array_supplier_name);$i++){
                    $supplier = new CreditFormSupplier();
                    $supplier->supplier_name = $array_supplier_name[$i];
                    $supplier->omset_estimation = $array_supplier_omset[$i];
                    $supplier->credit_form = $array_supplier_credit[$i];
                    $supplier->information = $array_supplier_information[$i];

                   $supplier->save();
                }
                return response()->json([
                    'message' => 'Customer successfully registered'
                ],200);
            }

            /*
             * if process failed, delete registered customer.
             */
            $customer->delete();
            return response()->json([
                'message' => 'Failed to register customer.'
            ],400);
        }
        return response()->json([
            'message'=>'Failed to register customer.'
        ],400);
    }

    public function followUpCheckin(Request $request){
        $this->validate($request, [
            'lat'=>'required',
            'lng'=>'required',
            'address'=>'required',
            'start_time'=>'required|date_format:Y-m-d H:i:s', // i in this case is minute
            'followup_id'=>'required',
            'type'=>'required|integer|min:0|max:1'
        ]);
        $user = $request->user();
        $lat = $request['lat'];
        $lng = $request['lng'];
        $address = $request['address'];
        $followup_id = $request['followup_id'];
        $type = $request['type'];

        /*
        * 0: Means followup end user
        * 1: Means followup customer
        */
        if($type==0){
            $followup = $user->follow_ups()->find($followup_id);
        }
        else{
            $followup = $user->follow_up_customers()->find($followup_id);
        }

        if($followup== null){
            return response()->json([
                'message' => 'Plan not found'
            ],404);
        }

        /*
         * -->  if user start_time is null
         *      check the end time first,
         *      --> if the both start time and end time is null
         *          then save checkin
         *      --> else (if start_time is null but end end time is not null)
         *          send error message
         * -->  if user start_time is not null
         *      means user has sign in to this place
         *      then send error message
         *
         * if user end_time
         *
         */
        if($followup->start_time==null){
            if($followup->end_time==null){
                $followup->checkin_lat = $lat;
                $followup->checkin_lng = $lng;
                $followup->checkin_address = $address;
                $followup->start_time = $request['start_time'];
                $followup->status_done = 1; //Checkin
                $followup->save();

                return response()->json([
                    'message'=>'Successfully Checkin.'
                ],200);
            }
            return response()->json([
                'message'=>'Failed to Checkin.'
            ],400);
        }
        return response()->json([
            'message'=>'Failed to Checkin.'
        ],400);
    }

    public function followUpCheckout(Request $request){
        $this->validate($request, [
            'lat'=>'required',
            'lng'=>'required',
            'address'=>'required',
            'end_time'=>'required|date_format:Y-m-d H:i:s', // i in this case is minute
            'followup_id'=>'required',
            'type'=>'required|integer|min:0|max:1'
        ]);

        $user = $request->user();
        $lat = $request['lat'];
        $lng = $request['lng'];
        $address = $request['address'];
        $followup_id = $request['followup_id'];
        $type = $request['type'];

        /*
        * 0: Means followup end user
        * 1: Means followup customer
        */
        if($type==0){
            $followup = $user->follow_ups()->find($followup_id);
        }
        else{
            $followup = $user->follow_up_customers()->find($followup_id);
        }

        if($followup== null){
            return response()->json([
                'message' => 'Plan not found'
            ],404);
        }

        if($followup->start_time==null){
            return response()->json([
                'message'=>'You haven\'t checkin to this place.'
            ],400);
        }

        if($followup->end_time==null){
            $followup->checkout_lat = $lat;
            $followup->checkout_lng = $lng;
            $followup->checkout_address = $address;
            $followup->finish_time = $request['end_time'];
            $followup->status_done = 2; //checkout
            $followup->status_color = 1; //done color: green (in report, color will be represent as gray)
            $followup->update();

            return response()->json([
                'message'=>'Successfully Checkout.'
            ],200);
        }
        /*
         * if end time is not null means this user has checkout (and then he checkout again)
         * thats why we send error message
         */
        return response()->json([
            'message'=>'Failed to Checkin.'
        ],400);
    }

    public function getCustomerAreas(){
        $customer_areas = CustomerArea::all();

        return response()->json($customer_areas,200);
    }

    public function getCustomers(){
        $customers = Customer::all();

        return response()->json($customers, 200);
    }

    

//    //for director
//    public function getVerification(Request $request){
//        $this->validate($request, [
//            'month'=>'required|integer|min:1|max:12',
//            'year'=>'required|integer'
//        ]);
//
//        $verification =
//    }
}
