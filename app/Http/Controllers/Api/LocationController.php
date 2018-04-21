<?php

namespace App\Http\Controllers\Api;

use App\Location;
use App\Customer;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    public function postUserLocation(Request $request){

        $this->validate($request, [
            'lat'=>'required',
            'lng'=>'required',
            'address'=>'required',
            'date_time'=>'required'
        ]);

        $user = $request->user();

        //get the last user location
        $last_location = $user->locations->sortByDesc('date_time')->first();

        //if null, save the location directly
        if($last_location==null){
            $location = new Location();
            $location->address = $request['address'];
            $location->lat = $request['lat'];
            $location->lng = $request['lng'];
            $location->date_time = $request['date_time'];
            $request->user()->locations()->save($location);
            return response()->json([
                'message'=>'location updated'
            ],200);
        }


        /*
         * if not null, check first if the last lat == now lat && last lng == now lng
         * if same, just send message (without saving)
        */
        if($last_location->lat == $request['lat'] && $last_location->lng = $request['lng']){
            return response()->json([
                'message'=>'location updated (not saved)'
            ],200);
        }

        //if different, save user location
        $location = new Location();
        $location->address = $request['address'];
        $location->lat = $request['lat'];
        $location->lng = $request['lng'];
        $location->date_time = $request['date_time'];
        $request->user()->locations()->save($location);
        return response()->json([
            'message'=>'location updated'
        ],200);
    }

    public function getAllLastLocation(Request $request){
        $current_user = $request->user();

        /*
         * set rules:
         * --> user with role id = 1 (director) can see everyone location
         * --> user with role id = 2 (manager) can see other manager & salesman location
         * --> user with role id = 3 (all salesman & surveyor) can only see other user with same role
         * for current project, we dont have user with role id >3, thats why we use role id >= current role id
         * example:
         *  --> user with role id= 1 then it means we will fetch all user with role id >= 1 (all the user)
         *  --> user with role id= 3 then it means we will fetch all user with role id >= 3 (currently no user with role id = 4,
         * it means only takes all salesman and surveyor)
         *
        */
//        $users = User::where('role_id', '>=',$current_user->role_id)->paginate(5)->getCollection();

        /*
         * Here we set the rules of view other locations
         * -->  if current_user->role_id equals to 1 (director)
         *      show all user locations
         * -->  if current_user->role_id equals to 2 or 3 or 4 (Retail manager, project manager, surveyor manager)
         *      show all user locations with same role_id AND role_id = current_user->role_id + 3 (current_user salesman/surveyor)
         *      5 = retail salesman, 6 = project salesman, 7 = surveyor
         *      example:
         *      current_user->role_id = 2, then system will return all user locations with role_id = 2 and role_id = 5
         * -->  other than above role_id, system will only send user locations that has same role_id
         *      example:
         *      current_user->role_id = 5, then system will show all user location that has role_id =5
         */
        if($current_user->role_id == 1){
            $users = User::paginate(5)->getCollection();
        }
        else if($current_user->role_id == 2 || $current_user->role_id == 3 || $current_user->role_id == 4){
            $users = User::whereIn('role_id',[$current_user->role_id,$current_user->role_id+3])->paginate(5)->getCollection();
        }
        else{
            $users = User::where('role_id',$current_user->role_id)->paginate(5)->getCollection();
        }

        foreach($users as $user){
            /*
             * foreach users that we fetch,
             * we simply get their last location and last checkin
             */
            $last_location = $user->locations->sortByDesc('date_time')->first();
            $last_checkin = $user->checkins->sortByDesc('date_time')->first();

            /*
             * if last_location == null
             * then check whether user last checkin is also null or not
             * -->  if null, then simply set user->last_location to null
             *      then on the frontend, simply dont map user location
             * -->  if not null, then simply set last_checkin value to user->last_location
             *      and we add:
             *      --> status, to make front end easier to recognise which one is checkin and which one is location (on the road)
             *          there are 2 status,
             *          --> 0 means user last location comes from location class (on the road)
             *          --> 1 means user last location comes from checkin class
             *      --> time_since,  to make front end easier to write down the difference time between last location time and now time
             *      --> shop, we only add shop if the status == 1, to make user know what shop is the salesman currently checkin
             *
             * else if last_location is not null
             * then we do exactly same step, check whether user last checkin is null or not
             * -->  if null, then simpy set last_location value to user->last_location
             * -->  if not null, it means we need to check which date_time is greater (means it was the latest action).
             *      --> if last_location->date_time is greater, it means user last location is on the road.
             *          so we set last_location value to user->last_location
             *      --> vice versa
             *
             */
            if($last_location==null){
                if($last_checkin==null){
                    $user->last_location = null;
                }
                else{
                    $shop = Customer::find($last_checkin->shop_id);
                    $user->last_location = $last_checkin;
                    $user->last_location->time_since =  Carbon::parse($last_location->date_time)->diffForHumans();
                    $user->last_location->status = 1;
                    $user->last_location->shop = $shop->name;
                }
            }
            else{
                if($last_checkin==null){
                    $user->last_location = $last_location;
                    $user->last_location->time_since = Carbon::parse($last_location->date_time)->diffForHumans();
                    $user->last_location->status = 0;
                }
                else{
                    /*
                     * this function is for comparing 2 date time;
                     */
                    if(strtotime($last_location->datetime)>strtotime($last_checkin->datetime)){
                        $user->last_location = $last_location;
                        $user->last_location->time_since = Carbon::parse($last_location->datetime)->diffForHumans();
                        $user->last_location->status = 0;
                    }
                    else{
                        $shop = Customer::find($last_checkin->shop_id);
                        $user->last_location = $last_checkin;
                        $user->last_location->time_since = Carbon::parse($last_checkin->datetime)->diffForHumans();
                        $user->last_location->status = 1;
                        $user->last_location->shop = $shop->name;
                    }
                }
            }
        }

        return response()->json($users,200);
    }

    public function getLocationHistory(Request $request, $id){

        /*
         * this validation means:
         * -->  day is required
         * -->  day must be an integer (do not has comma)
         * -->  day min value is 2, max value is 29
         *
         * we use 2 because, we want to show user 3 days location history
         * it means, we want to send user location history for this day and also for  2 days back from now (-2, not -3)
         * its also apply on when we want to show user 30 days location history (we use -29 not -30)
         *
         */
        $this->validate($request,[
            'day'=>'required|integer|min:2|max:29',
        ]);

        /*
         * find user by the id (sent by url parameter)
         */
        $user = User::find($id);

        if($user==null){
            return response()->json([
                "message"=>"User not found."
            ],404);
        }

        /*
         * Get all the location, checkin and checkout list history
         * we send checkin and checkout so front end can calculate how long salesman in the customer place
         *
         */
        $location_list = $user->locations()
            ->whereBetween('date_time',[date('Y-m-d H:i:s',strtotime("-". $request['day'] ." days")),Carbon::now()->toDateTimeString()])
            ->orderBy('date_time','desc')->sortByDesc('created_at')->get();
        $checkin_list = $user->checkins()
            ->whereBetween('date_time',[date('Y-m-d H:i:s',strtotime("-". $request['day'] ." days")),Carbon::now()->toDateTimeString()])
            ->orderBy('date_time','desc')->sortByDesc('created_at')->get();
        $checkout_list = $user->checkouts()
            ->whereBetween('date_time',[date('Y-m-d H:i:s',strtotime("-". $request['day'] ." days")),Carbon::now()->toDateTimeString()])
            ->orderBy('date_time','desc')->sortByDesc('created_at')->get();

        return response()->json([
            'locations'=>$location_list,
            'checkins'=>$checkin_list,
            'checkouts'=>$checkout_list
        ]);
    }
}
