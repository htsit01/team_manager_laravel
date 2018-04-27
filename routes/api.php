<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/send', 'Api\NotificationController@postSendNotif');
Route::get('/sendmail', 'Api\NotificationController@postSendMail');
Route::post('/login', 'Api\AuthController@postLogin');
Route::get('/fetchcustomertype', 'Api\FetchController@fetchCustomerType');
Route::get('/fecthsalesperson', 'Api\FetchController@fecthSalesPerson');
Route::get('/fetchcustomer', 'Api\FetchController@fetchCustomer');
Route::get('/fetchcustomerarea', 'Api\FetchController@fetchCustomerArea');

Route::get('/firstmonday','Api\DateController@getMondays');


Route::middleware('auth:api')->group(function(){

    /*
     * USER ROUTE
     */
    Route::get('user','Api\UserController@getUser');

    /*
     * LOCATION ROUTE
     */
    Route::get('all-locations','Api\LocationController@getAllLastLocation');
    Route::get('location-history/{id}','Api\LocationController@getLocationHistory');
    Route::post('store-location','Api\LocationController@postUserLocation');

    /*
     * PLAN ROUTE
     */
    Route::post('add-plan','Api\PlanController@postVisitPlan');
    Route::get('visitplan','Api\PlanController@getUserVisitPlans');
    Route::post('visitplan/delete','Api\PlanController@deleteUserVisitPlan');
    Route::post('visitplan/approval','Api\PlanController@postAskForApproval');

    Route::post('visitplan/plan-list', 'Api\PlanController@postUserVisitPlanList');
    Route::get('visitplan/{id}/plan-list','Api\PlanController@getUserVisitPlanList');
    Route::post('visitplan/plan-list/{id}/delete','Api\PlanController@deleteUserVisitPlanList');
    Route::post('visitplan/plan-list/{id}/update','Api\PlanController@updateUserVisitPlanList');
    Route::post('visitplan/plan-list/{id}/report', 'Api\PlanController@saveVisitPlanReport');

    Route::post('followup', 'Api\PlanController@postFollowUp');
    Route::post('followupcustomer', 'Api\PlanController@postFollowUpCustomer');
    Route::post('followup/report', 'Api\PlanController@saveFollowUpReport');

    Route::get('salesman/visitplan', 'Api\ManagerController@getSalesmanVisitPlan');
    Route::get('salesman/pendingvisitplan', 'Api\ManagerController@getPendingVisitPlan');


    /*
     * VERIFICATION
     */
    Route::post('salesman/visitplan/verification', 'Api\ManagerController@verifyVisitPlan');
    Route::get('manager/verification','Api\DirectorController@getManagerVerification');


    /*
     * CHECKIN CHECKOUT
     */
    Route::post('visitplan/plan-list/checkin', 'Api\CustomerController@postCheckin');
    Route::post('visitplan/plan-list/checkout', 'Api\CustomerController@postCheckout');
    Route::post('followup/checkin','Api\CustomerController@followUpCheckin');

    /*
     * Follow Up
     */
    Route::post('followup/post','Api\PlanController@postFollowUp');
    Route::post('followupcustomer/post','Api\PlanController@postFollowUpCustomer');
    Route::get('allfollowup','Api\PlanController@getFollowUp');
    Route::post('followup/delete', 'Api\PlanController@deleteFollowUp');

    /*
     * Customers
     */
    Route::get('customerareas', 'Api\CustomerController@getCustomerAreas');
    Route::get('customers', 'Api\CustomerController@getCustomers');
});
